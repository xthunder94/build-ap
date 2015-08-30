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
			return $global_item->find();
		}
	}
?>
