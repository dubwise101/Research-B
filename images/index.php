<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../index.css">
  </head>
  <body>
  <center>
  <h1>Have a look at these images</h1>
    <h3>Use your mouse to indicate which one you like most</h3>
    <?php
      $date = date('Y-m-d,H:i:s',strtotime("-1 month"));
      echo 'Click <a href="results.php?timestamp='.$date.'">here</a> when you are done';
    ?>
    </center>
    <img src="images/0.jpg" class="displayed" alt=""><br/>
    <img src="images/1.jpg" class="displayed" alt=""><br/>
    <img src="images/2.jpg" class="displayed" alt=""><br/>
    <img src="images/3.jpg" class="displayed" alt=""><br/>
    <img src="images/4.jpg" class="displayed" alt="" width="80%" height="80%"><br/>
    <img src="images/5.jpg" class="displayed" alt="" width="80%" height="80%"><br/>
    <img src="images/6.jpg" class="displayed" alt=""><br/>
    <img src="images/7.jpg" class="displayed" alt="" width="80%" height="80%"><br/>
    <img src="images/8.jpg" class="displayed" alt=""><br/>
    <img src="images/9.jpg" class="displayed" alt="">
  </body>
</html>