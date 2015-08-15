<?PHP
	/**
	 * Retrieves match information of one json file and stores the data in MongoDB.
	 * Automatically detects region from filename.
	 */
	require "classes/riot-league-api.php";
	require "classes/rate-limit.php";

	$opts = getopt("i:t:v:");
	if(!isset($opts["i"]) || !isset($opts["t"]) || !isset($opts["v"])) {
		echo "php fetch-matches.php -i MATCH_LIST -t MATCH_TYPE -v MATCH_VERSION\n";
		echo "	-i json file containing a list of matches\n";
		echo "	-t match type, either 'NORMAL_5X5' or 'RANKED_SOLO'\n";
		echo "	-v match game version, something like 5.11 or 5.14\n";
		echo "example: php fetch-matches.php -i NA.json -t normal -v 5.11\n";
		die;
	}
	if(!file_exists($opts["i"])) {
		echo "unable to locate '" . $opts["i"]  . "'...\n";
		die;
	}
	if(!preg_match('/(?:^|\/)(\w*)\.(?:\w*)$/', $opts["i"], $matches)) {
		echo "invalid filename format... expected {region}.json\n";
		die;
	}
	$region = $matches[1];
	$api = new RiotLeagueAPI($region, "029e6503-7dc2-4a97-ac9e-d9f152c1b439");
	$time = new RateLimit();
	$mongo = new MongoClient();
	$db = $mongo->{"build-ap"};
	$collection_name = strtoupper($opts["t"] . "." . $opts["v"] . "." . $region);
	$collection = $db->{$collection_name};
	$matches = json_decode(file_get_contents($opts["i"]), true);
	echo "retrieving $collection_name...\n";
	$match_count = count($matches);
	for($i = 0; $i < $match_count; $i++) {
		$success = false;
		while(!$success) {
			$data = $api->getMatch($matches[$i]);
			$success = $api->getSuccess();
			if(!$success)
				$time->exceed();
			$time->delay();
		}
		$document = json_decode($data);
		$collection->remove(array('matchId' => $document->matchId));
		$collection->insert($document);
		echo ($i + 1) . "/$match_count processed...\r";
	}
	echo "\n";
	echo "done\n";
?>
