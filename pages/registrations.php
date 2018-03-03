<?php
	if(!isset($_REQUEST["session"])){
		if(!isset($_SESSION)){
			session_start();
		}
	}else{
		if(!isset($_SESSION)){
			session_start(array($_REQUEST["session"]));
		}
	}
	$session_get = session_id();
    
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ebullience 2K18</title>

	<meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, minimum-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="theme-color" content="#030710">

    <meta name="description" content="NIET Zonal Techfest Website">
    
    <meta name="keywords" content="NIET, Zonal, Techfest, Ebullience, 2018, AKTU, Jagdish, Ashish">
    
    <meta name="author" content="Jagdish Singh, Ashish Gupta">

    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <link rel="stylesheet" type="text/css" href="../css/style-extended.css">

    <script>
		var countDownDate = new Date("Mar 22, 2018 09:30:00").getTime();
		var x = setInterval(function() {
  		var now = new Date().getTime();
  		var distance = countDownDate - now;
		  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  		document.getElementById("timer").innerHTML = days + "  days   " + hours + " hours "
  		+ minutes + " mins " + seconds + " secs ";
  		if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "Get Set Go For The TechFest";
  		}
		}, 1000);
	</script>
</head>

<body>
	<div id="overlayer">
		<div class='triangles'>
      		<div class='tri invert'></div>
      		<div class='tri invert'></div>
      		<div class='tri'></div>
      		<div class='tri invert'></div>
      		<div class='tri invert'></div>
      		<div class='tri'></div>
      		<div class='tri invert'></div>
      		<div class='tri'></div>
      		<div class='tri invert'></div>
    	</div>
	</div>

	<div class="last" style="background-color: #030710; height: 100%; width: 100%;position:absolute;z-index:-5">
		<canvas id="waves"></canvas>
	</div>

	<div id="skill" style="min-height: 100%; min-width: 100%; position: absolute;z-index: -3"></div>

	<div class="main-cont">
		 <div class="line"></div>
		<h1>ARK 2K18</h1>
		<center><div class="line_2"></div></center>
    <div class="menu-2">
      <a href="#">HOME</a>
      <a href="#">ABOUT</a>
      <a href="#">EVENTS</a>
      <a href="#">REGISTRATION</a>
      <a href="#">SCHEDULE</a>
    </div>
    <div class="navigator">
    	REGISTRATIONS
    </div>
    <center><div class="line_2"></div></center>  
    <div class="menu-2">
        <a href="../index.php">INDEX | </a>
        <a href="events.php">EVENTS | </a>
        <a href="devpage.php">DEV PAGE | </a>
        <a href="login.php">Login | </a>
        <a href="forget-pwd.php">Forgot-Password | </a> 
        <a href="co-ordinator-panel.php">CONSOLE</a>
    </div>
		<br>
    <div class="error" id="message">
    
    </div>

    <div id="timer" class="timer">
          
    </div>
    <form action="../resources/api.php?action=register&amp;session=<?php echo $session_get;?>" method="POST">

    	<input type="text" name="name" placeholder="Name" class="txt-sml" style="margin-top: 10px;"><br>
    	<input type="text" name="clg_name" placeholder="College" class="txt-sml"><br>
    	<input type="text" name="email" placeholder="Email" class="txt-sml"><br>
    	<input type="text" name="roll_no" placeholder="Roll Number" class="txt-sml"><br>
    	<input type="text" name="mob_no" placeholder="Mobile Number" class="txt-sml"><br>
    	<input type="password" name="pass" placeholder="Password" class="txt-sml"><br>

    	<input type="submit" name="submit" placeholder="Register" value="Register" class="btn-sml">

    </form>
    <div class="footer">
		<div class="line_3"></div>
			Designed And Developed By 

			<a class="author" target="_blank" href="https://github.com/ashigupta007"> Ashish Gupta </a>
			and
			<a class="author" target="_blank" href="https://github.com/JDchauhan"> Jagdish Singh </a>
		
		</div>

      	<div class="menu">
           <a href="../index.php"><button><div class="btn-text">HOME</div></button></a><br><br><br>
           <a href="events.php"><button><div class="btn-text">EVENTS</div></button></a><br><br><br>
           <a href="devpage.php"><button><div class="btn-text">DEV PAGE</div></button></a><br><br><br>
           <a href="login.php"><button><div class="btn-text">LOGIN</div></button></a><br><br><br>
           <a href="forget-pwd.php"><button><div class="btn-text" style="font-size: 13px">FORGOT-PASSWORD</div></button></a><br><br><br>
           <a href="co-ordinatior-panel.php"><button><div class="btn-text">CONSOLE</div></button></a><br><br><br>
      </div>
    </div>
</body>
	  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">

    <script type="text/javascript" src="../js/jquery.particleground.js"></script>

    <script type="text/javascript" src="../js/sine-waves.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Audiowide" rel="stylesheet">

    <script type="text/javascript" src="../js/main.js"></script>

	<?php 
		if(isset($_SESSION["msg"])){
			echo "<script>alert('" . $_SESSION["msg"]["type"] . "\\n" . $_SESSION["msg"]["head"] . "\\n" .
									$_SESSION["msg"]["body"] .
				"');</script>" ;
			unset($_SESSION["msg"]);
		}
		
	?>
    
</html>