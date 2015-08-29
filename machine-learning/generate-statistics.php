<?PHP
    $mongo = new MongoClient();
    $db = $mongo->{"build-ap"};
    $static_champions = $db->{"STATIC.CHAMPIONS"};
    $static_items = $db->{"STATIC.ITEMS"};
    $old_matches = $db->{"RANKED_SOLO.5.11.NA"};
    $new_matches = $db->{"RANKED_SOLO.5.14.NA"};
    // Global Item Usage
    $old_item = array();
    $match_cursor = $old_matches->find();
    foreach ($match_cursor as $match) {
        foreach($match["participants"] as $player) {
            echo $player["timeline"]["role"] . "\n";
        }
    }
?>