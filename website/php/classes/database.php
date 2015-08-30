<?PHP
	class Database {
		private $mongo;
		private $db;

		function __construct() {
			$this->mongo = new MongoClient();
		    $this->db = $this->mongo->{"build-ap"};
		}

		function getOverallItemUsage() {
			$global_item = $this->db->{"ML.STATISTICS.GLOBAL.ITEM"};
			$items = $global_item->find();
			$result_array = array();
			foreach ($items as $item) {
				print_r($item);
				$result_array[] = $item;
			}
			return $result_array;
		}
	}
?>
