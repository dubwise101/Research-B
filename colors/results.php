<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
   		<head>
      		<link rel="stylesheet" type="text/css" href="../index.css">
   		</head>
		<body>
		<?php
			// set default time zone if not set at php.ini
			if (!date_default_timezone_get('date.timezone'))
			{
			    date_default_timezone_set('Europe/Amsterdam'); // put here default timezone
			}

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

			$myFile = "../log.txt";
			$handle = fopen($myFile, "r");
			if ($handle) {
    			while (($line = fgets($handle)) !== false) {
    				// find user logs
	    			if(startsWith($line,$ip)) {
	    				// find blue log
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
						// find red log
	    				if (strpos($line,'dom=abbb') !== false) { 
	    					$red[$redCounter] = array(); 
	    					array_push($red[$redCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abbb') !== false) {   
	    								array_push($red[$redCounter],$line);
	    						} 
	    						else {
	    							$redCounter++;
	    							break;
	    						}
	    					}				
						}
						// find green log
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
					echo '<h1>You seem to prefer the color red!</h1>';
				}
				else if (count($blue) < count($green)) {
					echo '<h1>You seem to prefer the color green!</h1>';
				}				
			}
			else {
				echo '<h1>You seem to prefer the color blue!</h1>';
			}
			echo '<center>based on how many times you visited the color with your mouse</center><br/><br/>';


			if(isset($_GET['correct'])) {
				$myFile = "results.txt";
				$fh = fopen($myFile, 'a') or die("can't open file");
				if($_GET['correct'] === 'yes') {
					fwrite($fh, $ip . ' ' . date('Y-m-d H:i:s') . ' ' . " True\n");
				} else {
					fwrite($fh, $ip . ' ' . date('Y-m-d H:i:s') . ' ' . " True\n");
				}
				fclose($fh);	
				echo '<center><p>Thank you</p><center>';
			} else {
   				echo '<center><form action="" id="hide">
				Is this correct?<br/>
				<input type="radio" name="correct" value="yes">Yes<br/>
				<input type="radio" name="correct" value="yes">No<br/>
				<input type="submit" value="Submit">
				</form></center>';
			}			

			function numberOfEvents($logs) {
				$numberOfEvents = 0;
				for($i = 0; $i < count($logs); $i++) {
					$numberOfEvents += count($logs[$i]);
				}
				return $numberOfEvents;
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
