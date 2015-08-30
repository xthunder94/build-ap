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
				$result_array[] = $item;
			}
			return $result_array;
		}

		function getOverallChampionUsage() {
			$global_champion = $this->db->{"ML.STATISTICS.GLOBAL.CHAMPION"};
			$champions = $global_champion->find();
			$result_array = array();
			foreach ($champions as $champion) {
				$result_array[] = $champion;
			}
			return $result_array;
		}

		function getChampionUsage($name) {
			$champion = $this->db->{"ML.STATISTICS." . strtoupper($name) . ".ITEM"};
			$items = $champion->find();
			$result_array = array();
			foreach ($items as $item) {
				$result_array[] = $item;
			}
			return $result_array;
		}
	}
?>
