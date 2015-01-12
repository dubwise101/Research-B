<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
   	<html>
   	<head>
      <link rel="stylesheet" type="text/css" href="../index.css">
   	</head>
<body>
	<center>
		<h1>Have a look at these colors</h1>
    <h2>Use your mouse to indicate which one you like most</h2>			
  <?php
    $date = date('Y-m-d,H:i:s');
    echo 'Click <a href="results.php?timestamp='.$date.'">here</a> when you are done';
  ?>
  </center>
  <div align="center" id="container">
<div id="left"></div>
<div align="center" id="center"></div>
<div id="right"></div>
</div>
  </body>
  </html>