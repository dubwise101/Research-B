<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
   		<head>
      		<link rel="stylesheet" type="text/css" href="../index.css">
   		</head>
		<body>
		<h1>Thank you!</h1>
		<h2>You just took part in an experiment</h2>
		<center>
		I tried to analyse which color you like most, based on you interactions.
	</center><br/><br/>	
		<?php
			require_once '../functions.php';

			// get user IP to find corresponding logs in log.txt
			$ip = getUserIP();

			$startTime;
			if(isset($_GET['timestamp'])) {
				$startTime = $_GET['timestamp'];
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
	    			if(startsWith($line,$ip) && datePast($line,$startTime)) {
	    				// find red log
	    				if (strpos($line,'dom=abba') !== false) {
	    					$red[$redCounter] = array();
	    					array_push($red[$redCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abba') !== false) {   
	    							array_push($red[$redCounter],$line);
	    						} 
	    						else {
	    							$redCounter++;
	    							break;
	    						}
	    					}				
						}
						// find green log
	    				if (strpos($line,'dom=abbb') !== false) { 
	    					$green[$greenCounter] = array(); 
	    					array_push($green[$greenCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abbb') !== false) {   
	    								array_push($green[$greenCounter],$line);
	    						} 
	    						else {
	    							$greenCounter++;
	    							break;
	    						}
	    					}				
						}
						// find blue log
	    				if (strpos($line,'dom=abbc') !== false) { 
	    					$blue[$blueCounter] = array();
	    					array_push($blue[$blueCounter],$line);
	    					while (($line = fgets($handle)) !== false) {
	    						if (strpos($line,'dom=abbc') !== false) {   
	    								array_push($blue[$blueCounter],$line);
	    						} 
	    						else {
	    							$blueCounter++;
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

			if(!isset($_GET['correct'])) {
				echo '<center><h3>';
				if(count($red) <= count($blue) && count($green) <= count($blue)) {
					echo 'You seem to prefer the color blue!';
				}
				else if(count($blue) < count($red) && count($green) < count($red)) {
					echo 'You seem to prefer the color red!';
				}
				else if(count($blue) < count($green) && count($red) < count($green)) {
					echo 'You seem to prefer the color green!';				
				}
				echo '</h3></center>';
			}

			if(isset($_GET['correct'])) {
				$myFile = "results.txt";
				$fh = fopen($myFile, 'a') or die("can't open file");
				if($_GET['correct'] === 'yes') {
					fwrite($fh, $ip . ' ' . date('Y-m-d,H:i:s') . ' ' . " True\n");
				} else {
					fwrite($fh, $ip . ' ' . date('Y-m-d,H:i:s') . ' ' . " False\n");
				}
				fclose($fh);	
				echo '<center><p>Thank you</p><center>';
				echo '<center><a href="index.php">Redo experiment</a></center>';
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

			function printStats() {
				echo '<table width=100%>';
				echo '<tr>';
				echo '<td></td>';
				echo '<td>Number of events</td>';
				echo '<td>Times visited</td>';
				echo '<td>Time spent</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Blue</td>';
				echo '<td>'.numberOfEvents($blue).'</td>';
				echo '<td></td>';
				echo '<td>'.totalTimeSpent($blue).'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Red</td>';
				echo '<td>'.numberOfEvents($red).'</td>';
				echo '<td></td>';
				echo '<td>'.totalTimeSpent($red).'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Green</td>';
				echo '<td>'.numberOfEvents($green).'</td>';
				echo '<td></td>';
				echo '<td>'.totalTimeSpent($green).'</td>';
				echo '</tr>';
				echo '</table>';
			}
		?>
	</body>
  </html>