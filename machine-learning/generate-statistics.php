<?PHP
    $mongo = new MongoClient();
    $db = $mongo->{"build-ap"};
    $static_champions = $db->{"STATIC.CHAMPIONS"};
    $static_items = $db->{"STATIC.ITEMS"};
    $old_matches = $db->{"RANKED_SOLO.5.11.NA"};
    $new_matches = $db->{"RANKED_SOLO.5.14.NA"};
    $global_item = $db->{"ML.STATISTICS.GLOBAL.ITEM"};
    $global_champion = $db->{"ML.STATISTICS.GLOBAL.CHAMPION"};
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
    $old_champion_item_total = array(); // ChampionID => Count
    $old_champion_win = array(); // ChampionID => Win
    $old_champion_damage = array(); // ChampionID => Total Damage (Before Divide By Champion Count)
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
                // Champion Pick Rate
                if (!isset($old_champion_item_total["$champion_id"]))
                    $old_champion_item_total["$champion_id"] = 0;
                $old_champion_item_total["$champion_id"]++;
                // Champion Win Rate
                if ($player["teamId"] == $winning_team) {
                    if (!isset($old_champion_win["$champion_id"]))
                        $old_champion_win["$champion_id"] = 0;
                    $old_champion_win["$champion_id"]++;
                }
                // Champion Damage Dealt
                if (!isset($old_champion_damage["$champion_id"]))
                    $old_champion_damage["$champion_id"] = 0;
                $old_champion_damage["$champion_id"] += $match["stats"]["totalDamageDealtToChampions"];
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
    $new_champion_item_total = array(); // ChampionID => Count
    $new_champion_win = array(); // ChampionID => Win
    $new_champion_damage = array(); // ChampionID => Total Damage (Before Divide By Champion Count)
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
                // Champion Pick Rate
                if (!isset($new_champion_item_total["$champion_id"]))
                    $new_champion_item_total["$champion_id"] = 0;
                $new_champion_item_total["$champion_id"]++;
                // Champion Win Rate
                if ($player["teamId"] == $winning_team) {
                    if (!isset($new_champion_win["$champion_id"]))
                        $new_champion_win["$champion_id"] = 0;
                    $new_champion_win["$champion_id"]++;
                }
                // Champion Damage Dealt
                if (!isset($new_champion_damage["$champion_id"]))
                    $new_champion_damage["$champion_id"] = 0;
                $new_champion_damage["$champion_id"] += $match["stats"]["totalDamageDealtToChampions"];
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
    $global_item->drop();
    foreach ($old_item as $itemid => $itemcount) {
        $item_info = GetItem($itemid);
        $document = array();
        $document["id"] = $itemid;
        $document["name"] = $item_info["name"];
        $document["image"] = "http://ddragon.leagueoflegends.com/cdn/5.7.1/img/item/" . $item_info["image"]["full"];
        $document["old_usage"] = $itemcount / $old_item_total * 100;
        $document["new_usage"] = $new_item[$itemid] / $new_item_total * 100;
        $document["old_winrate"] = $old_item_win[$itemid] / $itemcount * 100;
        $document["new_winrate"] = $new_item_win[$itemid] / $new_item[$itemid] * 100;
        $global_item->insert($document);
    }
    $global_champion->drop();
    foreach ($old_champion_item as $championid => $championitemdata) {
        $champion_info = GetChampion($championid);
        $document = array();
        $document["id"] = $championid;
        $document["name"] = $champion_info["name"];
        $document["image"] = "http://ddragon.leagueoflegends.com/cdn/img/champion/splash/" . $champion_info["name"] . "_0.jpg";
        $document["old_winrate"] = $old_champion_win[$championid] / $old_champion_item_total[$championid] * 100;
        $document["new_winrate"] = $new_champion_win[$championid] / $new_champion_item_total[$championid] * 100;
        $document["old_pickrate"] = $old_champion_item_total[$championid] / $old_item_total;
        $document["new_pickrate"] = $new_champion_item_total[$championid] / $new_item_total;
        $document["old_damage"] = $old_champion_damage[$championid] / $old_champion_item_total[$championid];
        $document["new_damage"] = $new_champion_damage[$championid] / $new_champion_item_total[$championid];
        $global_champion->insert($document);
    }
    echo "Total Count: $old_item_total\n";
    print_r($old_item);
    print_r($old_item_win);
    echo "==========================================\n";
    print_r($old_champion_item);
    print_r($old_champion_item_win);
    print_r($old_champion_item_total);
?>