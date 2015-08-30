<?PHP
    $mongo = new MongoClient();
    $db = $mongo->{"build-ap"};
    $static_champions = $db->{"STATIC.CHAMPIONS"};
    $static_items = $db->{"STATIC.ITEMS"};
    $old_matches = $db->{"RANKED_SOLO.5.11.NA"};
    $new_matches = $db->{"RANKED_SOLO.5.14.NA"};
    // Conversion Functions
    function GetItem($itemid) {
        global $static_items;
        return $static_items->findOne(array('id' => $itemid));
    }
    function GetChampion($championid) {
        global $static_champions;
        return $static_champions->findOne(array('id' => $championid));
    }
    print_r(GetItem(3068));
    exit;
    // Global Item Usage
    $old_item = array();
    $old_item_total = 0;
    $old_champion_item = array();
    $old_champion_total = array();
    $match_cursor = $old_matches->find();
    foreach ($match_cursor as $match) {
        foreach ($match["participants"] as $player) {
            // Locate mid laner
            if ($player["timeline"]["role"] == "SOLO" && $player["timeline"]["lane"] == "MIDDLE") {
                $champion_id = $player["championId"];
                if (!isset($old_champion_total["$champion_id"]))
                    $old_champion_total["$champion_id"] = 0;
                $old_champion_total["$champion_id"]++;
                // Loop through each item
                for ($i = 0; $i < 6; $i++) {
                    $item_id = $player["stats"]["item" . $i];
                    if ($item_id != 0) {
                        if (!isset($old_item["$item_id"]))
                            $old_item["$item_id"] = 0;
                        $old_item["$item_id"]++;
                        if (!isset($old_champion_item["$champion_id"]))
                            $old_champion_item["$champion_id"] = array();
                        if (!isset($old_champion_item["$champion_id"]["$item_id"]))
                            $old_champion_item["$champion_id"]["$item_id"] = 0;
                        $old_champion_item["$champion_id"]["$item_id"]++;
                    }
                }
            }
        }
        $old_item_total++;
    }
    print_r($old_item);
    print_r($old_champion_item);
    echo "$old_item_total\n";
    print_r($old_champion_total);
?>