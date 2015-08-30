<?PHP
	require "classes/database.php";

	$data = new Database();
    $_GET["do"] = "ahri";
	echo json_encode($data->getChampionUsage($_GET["do"]));
?>