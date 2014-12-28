<?php
	function getUserIP() {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];		
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		return $ip;
	}

	function startsWith($haystack, $needle) {
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	function datePast($line,$startTime) {
		$splitLine = explode(" ", $line);
		$logTime = date('Y-m-d,H:i:s',strtotime($splitLine[1]));
		if($logTime > $startTime) {
			return true;
		} else {
			return false;
		}				
	}
?>