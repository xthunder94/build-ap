<?PHP
	/**
	 * Loops through provided folder and calls fetch-matches.php for each json file found.
	 * Automatically generate correct version, type, and region.
	 */
	$opts = getopt("i:");
	if(!isset($opts["i"])) {
		echo "php fetch-all-matches.php -i ROOT_FOLDER\n";
		echo "	-i root folder of matches\n";
		echo "example: php fetch-all-matches.php -i AP_ITEM_DATASET\n";
		die;
	}
	function exec_p($cmd) {
		while(@ob_end_flush());
		$proc = popen($cmd, 'r');
		while(!feof($proc)) {
			echo fread($proc, 4096);
			@flush();
		}
	}
	function parseFile($full_path) {
		if(!preg_match('/^(?:\w*)\/([\w\.]*)\/(\w*)\/(\w*)\.json$/', $full_path, $matches)) {
			echo "invalid path format\n";
			die;
		}
		$version = $matches[1];
		$type = $matches[2];
		$command = "php fetch-matches.php -i $full_path -t $type -v $version";
		echo "$command\n";
		exec_p($command);
	}
	function recursiveSearch($directory) {
		$files = scandir($directory);
		foreach($files as $file) {
			if($file == '.' || $file == '..')
				continue;
			$full_path = $directory . '/' . $file;
			if(is_dir($full_path))
				recursiveSearch($full_path);
			else
				parseFile($full_path);
		}
	}
	if(!is_dir($opts["i"])) {
		echo "invalid root folder\n";
		die;
	}
	recursiveSearch($opts["i"]);
?>
