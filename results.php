<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
   	<html>
   	<head>
      <link rel="stylesheet" type="text/css" href="index.css">
   	</head>
	<body>
		<?php
			$ip = $_SERVER['REMOTE_ADDR'];
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    			$ip = $_SERVER['HTTP_CLIENT_IP'];		
			} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip = $_SERVER['REMOTE_ADDR'];
			}

			$blueCounter = 0;
			$blue = array();

			$redCounter = 0;
			$red = array();

			$greenCounter = 0;
			$green = array();

			$myFile = "log.txt";
			$handle = fopen($myFile, "r");
			if ($handle) {
    			while (($line = fgets($handle)) !== false) {
    				// find user logs
	    			if(startsWith($line,$ip)) {
	    				// find blue log
	    				if (strpos($line,'dom=abba') !== false) { 
	    					//echo 'Ik ben blauw tegengekomen...'; 
	    					$blue[$blueCounter] = array();
	    					array_push($blue[$blueCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abba') !== false) {   
	    								array_push($blue[$blueCounter],$line);
	    						} 
	    						else {
	    							//echo '...nu niet meer</br>';
	    							$blueCounter++;
	    							break;
	    						}
	    					}				
						}
						// find red log
	    				if (strpos($line,'dom=abbb') !== false) { 
	    					//echo 'Ik ben rood tegengekomen...';
	    					$red[$redCounter] = array(); 
	    					array_push($red[$redCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abbb') !== false) {   
	    								array_push($red[$redCounter],$line);
	    						} 
	    						else {
	    							//echo 'nu niet meer</br>';
	    							$redCounter++;
	    							break;
	    						}
	    					}				
						}
						// find green log
	    				if (strpos($line,'dom=abbc') !== false) { 
	    					//echo 'Ik ben groen tegengekomen...'; 
	    					$green[$greenCounter] = array();
	    					array_push($green[$greenCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abbc') !== false) {   
	    								array_push($green[$greenCounter],$line);
	    						} 
	    						else {
	    							//echo 'nu niet meer</br>';
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

			echo 'blue visited ' . count($blue) . ' times for ' . totalTimeSpent($blue) . ' seconds<br/>';
			for ($i = 0; $i < count($blue); $i++) {
    			echo $i . ': ' . count($blue[$i]) . ', ';
			} 
			echo '<br/>';
			echo '<br/>';
			echo 'red visited ' . count($red) . ' times for ' . totalTimeSpent($red) . ' seconds<br/>';
			for ($i = 0; $i < count($red); $i++) {
    			echo $i . ': ' . count($red[$i]) . ', ';
			} 
			echo '<br/>';
			echo '<br/>';
			echo 'green visited ' . count($green) . ' times for ' . totalTimeSpent($green) . ' seconds<br/>';
			for ($i = 0; $i < count($green); $i++) {
    			echo $i . ': ' . count($green[$i]) . ', ';
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

			function startsWith($haystack, $needle) {
			    $length = strlen($needle);
			    return (substr($haystack, 0, $length) === $needle);
			}
		?>
	</body>
  </html>
