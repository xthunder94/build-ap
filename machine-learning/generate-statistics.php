<?PHP
    $mongo = new MongoClient();
    $db = $mongo->{"build-ap"};
    $static_champions = $db->{"STATIC.CHAMPIONS"};
    $static_items = $db->{"STATIC.ITEMS"};
    $old_matches = $db->{"RANKED_SOLO.5.11.NA"};
    $new_matches = $db->{"RANKED_SOLO.5.14.NA"};
    // Global Item Usage
    $old_item = array();
    $old_champion_item = array();
    $match_cursor = $old_matches->find();
    foreach ($match_cursor as $match) {
        foreach ($match["participants"] as $player) {
            // Locate mid laner
            if ($player["timeline"]["role"] == "SOLO" && $player["timeline"]["lane"] == "MIDDLE") {
                $champion_id = $player["championId"];
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
    }
    print_r($old_item);
    print_r($old_champion_item);
?>