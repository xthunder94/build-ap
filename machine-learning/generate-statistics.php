<?PHP
    $mongo = new MongoClient();
    $db = $mongo->{"build-ap"};
    $static_champions = $db->{"STATIC.CHAMPIONS"};
    $static_items = $db->{"STATIC.ITEMS"};
    $old_matches = $db->{"RANKED_SOLO.5.11.NA"};
    $new_matches = $db->{"RANKED_SOLO.5.14.NA"};
    $global_item = $db->{"ML.STATISTICS.GLOBAL.ITEM"};
    // Conversion Functions
    function GetItem($itemid) {
        global $static_items;
        return $static_items->findOne(array('id' => $itemid));
    }
    function GetChampion($championid) {
        global $static_champions;
        return $static_champions->findOne(array('id' => $championid));
    }
    // Global Item Usage
    $old_item = array(); // ItemID => Count
    $old_item_win = array(); // ItemID => Win
    $old_item_total = 0; // Mid Laner Count
    $old_champion_item = array(); // ChampionID => [ItemID => Count]
    $old_champion_item_win = array(); // ChampionID => [ItemID => Win]
    $old_champion_item_total = array(); // ChampionID => Mid Laner Count
    $match_cursor = $old_matches->find();
    foreach ($match_cursor as $match) {
        // Get winning team
        $winning_team = 0;
        foreach ($match["teams"] as $team)
            if ($team["winner"])
                $winning_team = $team["teamId"];
        // Loop through each player
        foreach ($match["participants"] as $player) {
            // Locate mid laner
            if ($player["timeline"]["role"] == "SOLO" && $player["timeline"]["lane"] == "MIDDLE") {
                $champion_id = $player["championId"];
                if (!isset($old_champion_item_total["$champion_id"]))
                    $old_champion_item_total["$champion_id"] = 0;
                $old_champion_item_total["$champion_id"]++;
                // Loop through each item
                for ($i = 0; $i < 6; $i++) {
                    $item_id = $player["stats"]["item" . $i];
                    if ($item_id != 0) {
                        // Count the item as being used
                        if (!isset($old_item["$item_id"]))
                            $old_item["$item_id"] = 0;
                        $old_item["$item_id"]++;
                        if (!isset($old_champion_item["$champion_id"]))
                            $old_champion_item["$champion_id"] = array();
                        if (!isset($old_champion_item["$champion_id"]["$item_id"]))
                            $old_champion_item["$champion_id"]["$item_id"] = 0;
                        $old_champion_item["$champion_id"]["$item_id"]++;
                        // Check if the item is a winning item
                        if ($player["teamId"] == $winning_team) {
                            if (!isset($old_item_win["$item_id"]))
                                $old_item_win["$item_id"] = 0;
                            $old_item_win["$item_id"]++;
                            if (!isset($old_champion_item_win["$champion_id"]))
                                $old_champion_item_win["$champion_id"] = array();
                            if (!isset($old_champion_item_win["$champion_id"]["$item_id"]))
                                $old_champion_item_win["$champion_id"]["$item_id"] = 0;
                            $old_champion_item_win["$champion_id"]["$item_id"]++;
                        }
                    }
                }
                $old_item_total++;
            }
        }
    }
    $new_item = array(); // ItemID => Count
    $new_item_win = array(); // ItemID => Win
    $new_item_total = 0; // Mid Laner Count
    $new_champion_item = array(); // ChampionID => [ItemID => Count]
    $new_champion_item_win = array(); // ChampionID => [ItemID => Win]
    $new_champion_item_total = array(); // ChampionID => Mid Laner Count
    $match_cursor = $new_matches->find();
    foreach ($match_cursor as $match) {
        // Get winning team
        $winning_team = 0;
        foreach ($match["teams"] as $team)
            if ($team["winner"])
                $winning_team = $team["teamId"];
        // Loop through each player
        foreach ($match["participants"] as $player) {
            // Locate mid laner
            if ($player["timeline"]["role"] == "SOLO" && $player["timeline"]["lane"] == "MIDDLE") {
                $champion_id = $player["championId"];
                if (!isset($new_champion_item_total["$champion_id"]))
                    $new_champion_item_total["$champion_id"] = 0;
                $new_champion_item_total["$champion_id"]++;
                // Loop through each item
                for ($i = 0; $i < 6; $i++) {
                    $item_id = $player["stats"]["item" . $i];
                    if ($item_id != 0) {
                        // Count the item as being used
                        if (!isset($new_item["$item_id"]))
                            $new_item["$item_id"] = 0;
                        $new_item["$item_id"]++;
                        if (!isset($new_champion_item["$champion_id"]))
                            $new_champion_item["$champion_id"] = array();
                        if (!isset($new_champion_item["$champion_id"]["$item_id"]))
                            $new_champion_item["$champion_id"]["$item_id"] = 0;
                        $new_champion_item["$champion_id"]["$item_id"]++;
                        // Check if the item is a winning item
                        if ($player["teamId"] == $winning_team) {
                            if (!isset($new_item_win["$item_id"]))
                                $new_item_win["$item_id"] = 0;
                            $new_item_win["$item_id"]++;
                            if (!isset($new_champion_item_win["$champion_id"]))
                                $new_champion_item_win["$champion_id"] = array();
                            if (!isset($new_champion_item_win["$champion_id"]["$item_id"]))
                                $new_champion_item_win["$champion_id"]["$item_id"] = 0;
                            $new_champion_item_win["$champion_id"]["$item_id"]++;
                        }
                    }
                }
                $new_item_total++;
            }
        }
    }
    // Generate Global Statistics
    foreach ($old_item as $itemid => $itemcount) {
        $item_info = GetItem($itemid);
        $document = array();
        $document["id"] = $itemid;
        $document["name"] = $item_info["name"];
        $document["image"] = "http://ddragon.leagueoflegends.com/cdn/5.7.1/img/item/" . $item_info["image"]["full"];
        $document["old_usage"] = $itemcount / $old_item_total * 100;
        $document["new_usage"] = $new_item[$itemid] / $new_item_total * 100;
        $document["old_winrate"] = $old_winrate[$itemid] / $old_item_total * 100;
        $document["new_winrate"] = $new_winrate[$itemid] / $new_item_total * 100;
        $global_item->insert($document);
    }
    echo "Total Count: $old_item_total\n";
    print_r($old_item);
    print_r($old_item_win);
    echo "==========================================\n";
    print_r($old_champion_item);
    print_r($old_champion_item_win);
    print_r($old_champion_item_total);
?>