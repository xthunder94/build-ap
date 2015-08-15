<?PHP
	class RateLimit {
		private $long_delay;
		private $rp10s;

		function __construct($rp10s = 9) {
			$this->rp10s = $rp10s;
			$this->long_delay = false;
		}

		function delay() {
			$delay = 10 / $this->rp10s * 1000000;
			if ($this->long_delay) {
				$delay += 1000000;
				$this->long_delay = false;
			}
			usleep($delay);
		}

		function exceed() {
			$this->long_delay = true;
		}
	}
?>
