<?PHP
	class RiotLeagueAPI {
		private $key;
		private $region;
		private $responseCode;

		private function getData($url) {
			$cparams = array(
				'http' => array(
					'method' => 'GET',
					'ignore_errors' => true
				)
			);
			$context = stream_context_create($cparams);
			$fp = fopen($url, 'rb', false, $context);
			if (!$fp) {
				$res = "";
			} else {
				var_dump($meta['wrapper_data']);
				$res = stream_get_contents($fp);
			}
			$this->responseCode = 200;
			if ($res == "")
				$this->responseCode = 429;
			return $res;
		}

		/*private function getData($url) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			$data = curl_exec($ch);
			$this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			return $data;
		}*/

		private function getDataRegion($url) {
			$url = str_replace("{region}", $this->region, $url);
			$sigil = "&";
			if (strpos($url, "?") === false)
				$sigil = "?";
			$url =  "https://" . $this->region  . ".api.pvp.net" . $url . "{$sigil}api_key=" . $this->key;
			return $this->getData($url);
		}

		private function getDataGlobal($url) {
			$url = str_replace("{region}", $this->region, $url);
			$sigil = "&";
			if (strpos($url, "?") === false)
				$sigil = "?";
			$url = "https://global.api.pvp.net" . $url  . "{$sigil}api_key=" . $this->key;
			return $this->getData($url);
		}

		function __construct($region, $key) {
			$this->key = trim($key);
			$this->region = strtolower(trim($region));
		}

		function getSuccess() {
			if($this->responseCode != 200)
				return false;
			return true;
		}

		function getMatch($match_id) {
			return $this->getDataRegion("/api/lol/{region}/v2.2/match/$match_id");
		}

		function getChampions() {
			return $this->getDataGlobal("/api/lol/static-data/{region}/v1.2/champion?champData=all");
		}

		function getItems() {
			return $this->getDataGlobal("/api/lol/static-data/na/v1.2/item?itemListData=all");
		}
	}
?>
