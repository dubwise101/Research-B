<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
   	<html>
   	<head>
      <link rel="stylesheet" type="text/css" href="../index.css">     
   	</head>
	<body>
		<h1>Thank you!</h1>
		<h2>You just took part in an experiment</h2>
		<center>
		I tried to analyse which image you like most, based on you interactions.
		I think this is your top three:</center><br/><br/>
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

			$maxs = array_keys($counters, max($counters));
			echo '<img src="images/'.$maxs[0].'.jpg" class="displayed" alt=""><br/>';
			$counters[$maxs[0]]=-1;
			$maxs = array_keys($counters, max($counters));
			echo '<img src="images/'.$maxs[0].'.jpg" class="displayed" alt=""><br/>';
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
