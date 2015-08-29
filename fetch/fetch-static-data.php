<?PHP
    /**
     * Retrieves match information of one json file and stores the data in MongoDB.
     * Automatically detects region from filename.
     */
    require "classes/riot-league-api.php";
    require "classes/rate-limit.php";
    require "classes/settings.php";
    $api = new RiotLeagueAPI("na", $league_api_key);
    $time = new RateLimit();
    $mongo = new MongoClient();
    $db = $mongo->{"build-ap"};
    // Add champions to database
    $champions = $db->{"STATIC.CHAMPIONS"};
    $champions->drop();
    $success = false;
    while(!$success) {
        $data = $api->getChampions();
        $success = $api->getSuccess();
        if(!$success)
            $time->exceed();
        $time->delay();
    }
    $document = json_decode($data);
    foreach($document->{"data"} as $name => $data) {
        $champions->insert($data);
    }
    // Add items to database
    $items = $db->{"STATIC.ITEMS"};
    $items->drop();
    $success = false;
    while(!$success) {
        $data = $api->getItems();
        $success = $api->getSuccess();
        if(!$success)
            $time->exceed();
        $time->delay();
    }
    $document = json_decode($data);
    foreach($document->{"data"} as $name => $data) {
        $items->insert($data);
    }
?>
