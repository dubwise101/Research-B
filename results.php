<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
   	<html>
   	<head>
      <link rel="stylesheet" type="text/css" href="index.css">
   	</head>
	<body>
		<?php
			$ip = $_SERVER['REMOTE_ADDR'];
			//$ip = '127.0.0.1';

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


			echo 'blue visited ' . count($blue) . ' times <br/>';
			for ($i = 0; $i < count($blue); $i++) {
    			echo $i . ': ' . count($blue[$i]) . ', ';
			} 
			echo '<br/>';
			echo '<br/>';
			echo 'red visited ' . count($red) . ' times <br/>';
			for ($i = 0; $i < count($red); $i++) {
    			echo $i . ': ' . count($red[$i]) . ', ';
			} 
			echo '<br/>';
			echo '<br/>';
			echo 'green visited ' . count($green) . ' times <br/>';
			for ($i = 0; $i < count($green); $i++) {
    			echo $i . ': ' . count($green[$i]) . ', ';
			} 

			function startsWith($haystack, $needle)
			{
			    $length = strlen($needle);
			    return (substr($haystack, 0, $length) === $needle);
			}
		?>
	</body>
  </html>