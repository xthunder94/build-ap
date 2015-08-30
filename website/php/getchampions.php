<?PHP
	require "classes/database.php";

	$data = new Database();
	echo json_encode($data->getOverallItemUsage());
?>