<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
   	<html>
   	<head>
      <link rel="stylesheet" type="text/css" href="../index.css">
   	</head>
	<body>
		<h1>Thank you!</h1>
		<h2>You took part in an experiment</h2>
		I tried to analyse which image you like most, based on you interactions.
		I think this is your top three:<br/><br/>
		<?php
			$ip = $_SERVER['REMOTE_ADDR'];
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    			$ip = $_SERVER['HTTP_CLIENT_IP'];		
			} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip = $_SERVER['REMOTE_ADDR'];
			}

			$amountOfImages = 10;

			$counters = array();
			for ($i = 0; $i < $amountOfImages; $i++) {
    			$counters[$i] = 0;
    		}

			$myFile = "../log.txt";
			$handle = fopen($myFile, "r");
			if ($handle) {
				while (($line = fgets($handle)) !== false) {
					if(startsWith($line,$ip)) {
						for($i = 0; $i < $amountOfImages; $i++) {
							if (strpos($line, $i . '.jpg') !== false) {
    							$counters[$i] += 1;
    						}
						}
					}
				}
			} else {
			    // error opening the file.
			    echo "There was an error opening the log file!";
			} 
			fclose($handle);

			$maxs = array_keys($counters, max($counters));
			echo '<img src="images/'.$maxs[0].'.jpg" class="displayed" alt="">';
			$counters[$maxs[0]]=-1;
			$maxs = array_keys($counters, max($counters));
			echo '<img src="images/'.$maxs[0].'.jpg" class="displayed" alt="">';
			$counters[$maxs[0]]=-1;
			$maxs = array_keys($counters, max($counters));
			echo '<img src="images/'.$maxs[0].'.jpg" class="displayed" alt="">';
			$counters[$maxs[0]]=-1;

			function startsWith($haystack, $needle) {
			    $length = strlen($needle);
			    return (substr($haystack, 0, $length) === $needle);
			}			
		?>
	</body>
  </html>
