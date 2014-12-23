<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
   	<html>
   	<head>
      <link rel="stylesheet" type="text/css" href="../index.css">
   	</head>
	<body>
		<h1>Thank you!</h1>
		<h2>You took part in an experiment</h2>
		I tried to analyse which image you like most, based on you interactions.
		I think this is your preferred order:<br/><br/>
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

			//for ($i = 0; $i < $amountOfImages; $i++) {
			//	echo $i . ': ' . $counters[$i] . '<br/>';
    		//}
			
			while(true) {
				if(max($counters)!==-1) {
					$maxs = array_keys($counters, max($counters));
					echo '<img src="images/'.$maxs[0].'.jpg" class="displayed" alt="">';
					$counters[$maxs[0]]=-1;
				}
				else {
					break;
				}
			}
			
			//$maxs = array_keys($counters, max($counters));
			//echo $maxs[0] . '<br/>';


			
			

			/*$blueCounter = 0;
			$blue = array();

			$redCounter = 0;
			$red = array();

			$greenCounter = 0;
			$green = array();

			$myFile = "log.txt";
			$handle = fopen($myFile, "r");
			if ($handle) {
    			while (($line = fgets($handle)) !== false) {
	    			if(startsWith($line,$ip)) {
	    				if (strpos($line,'dom=abba') !== false) { 
	    					$blue[$blueCounter] = array();
	    					array_push($blue[$blueCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abba') !== false) {   
	    								array_push($blue[$blueCounter],$line);
	    						} 
	    						else {
	    							$blueCounter++;
	    							break;
	    						}
	    					}				
						}
	    				if (strpos($line,'dom=abbb') !== false) { 
	    					$red[$redCounter] = array(); 
	    					array_push($red[$redCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abbb') !== false) {   
	    								array_push($red[$redCounter],$line);
	    						} 
	    						else 
{	    							$redCounter++;
	    							break;
	    						}
	    					}				
						}
	    				if (strpos($line,'dom=abbc') !== false) { 
	    					$green[$greenCounter] = array();
	    					array_push($green[$greenCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abbc') !== false) {   
	    								array_push($green[$greenCounter],$line);
	    						} 
	    						else {
	    							$greenCounter++;
	    							break;
	    						}
	    					}				
						}
	    			}    			
    			}
			} else {
			    // error opening the file.
			    echo "There was an error opening the log file!";
			} 
			fclose($handle);


			if(count($blue) < count($red)) {
				if(count($green) < count($red)) {
					echo '<h1>You prefer the color red!</h1>';
				}
				else if (count($blue) < count($green)) {
					echo '<h1>You prefer the color green!</h1>';
				}				
			}
			else {
				echo '<h1>You prefer the color blue!</h1>';
			}
			echo 'based on how many times you entered the color with your mouse<br/><br/>';

			printStatistics('blue',$blue);
			printStatistics('red',$red);
			printStatistics('green',$green);*/

			function startsWith($haystack, $needle) {
			    $length = strlen($needle);
			    return (substr($haystack, 0, $length) === $needle);
			}

			function totalTimeSpent($logs) {
				$totalTimeSpent = 0;
				for($i = 0; $i < count($logs); $i++) {
					$lastLogEntry = count($logs[$i]) - 1;
					$lastLog = $logs[$i][$lastLogEntry];
					$splitLastLog = explode(",", $lastLog);
					$lastLogTime = explode(" ", $splitLastLog[1]);

					$firstLog = $logs[$i][0];
					$splitFirstLog = explode(",", $firstLog);
					$firstLogTime = explode(" ", $splitFirstLog[1]);

					$totalTimeSpent += strtotime($lastLogTime[0]) - strtotime($firstLogTime[0]);
				}
				return $totalTimeSpent;
			}

			function printStatistics($color,$logs) {
				echo $color . ' visited ' . count($logs) . ' times for ' . totalTimeSpent($logs) . ' seconds<br/>';
				for ($i = 0; $i < count($logs); $i++) {
    				echo $i . ': ' . count($logs[$i]) . ', ';
    			}
    			echo '<br/><br/>';
			}
		?>
	</body>
  </html>
