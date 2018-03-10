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
	<title>AKTU Zonal Fest 2K18</title>

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
	
  
  <style type="text/css">
    .txt-sml
    {
      margin-top: 20px;
    }
  </style>
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
		<img src="../images/biglogo.png" class="aktu">

    <h1 class="head-expanded">
    NOIDA INSTITUTE OF ENGINEERING AND TECHNOLOGY  
    </h1>

    

    <img src="../images/niet.png" class="aktu2">
    <h5 class="subhead-expanded">
      Accredited by NAAC (A Grade) | CSE, ECE, ME, &amp; B.Pharm are NBA accredited | 99th Rank by NIRF (2016)
    </h5>
    <h1 class="head-compressed">NIET, GR. NOIDA</h1>
		<center><div class="line_2"></div></center>
     <h3 class="head-expanded">Dr. APJ ABDUL KALAM TECHNICAL UNIVERSITY</h3>

      <h3 class="head-compressed">AKTU ZONAL FEST</h3>
    <center><div class="line_2"></div></center>  
    <div class="menu-2">
        <a href="../index.php">HOME | </a>
        <a href="events.php">EVENTS | </a>
        <a href="co-ordinator-panel.php">CONSOLE |</a>
		<a href="devpage.php">DEV PAGE </a>
        
    </div>
		<br>
    <div class="error" id="message">
    
    </div>

    <div id="timer" class="timer">
          
    </div>
    <form name="reg-form" action="../resources/api.php?action=register&amp;session=<?php echo $session_get;?>" onsubmit="return validateForm()" method="POST" style="padding-bottom: 80px; max-width: 700px;margin: auto;">
			<input type="text" name="clg_name" value='<?php if(isset($_SESSION["clg_details"]["clg_name"])){ echo $_SESSION["clg_details"]["clg_name"]; };?>'  placeholder="College" class="txt-sml">
			<input type="text" name="co-ordinator_name" value='<?php if(isset($_SESSION["clg_details"]["cord_name"])){ echo $_SESSION["clg_details"]["cord_name"]; };?>' placeholder="Cordinator Name" class="txt-sml">
			<br>
      <input type="text" name="co-ordinator_email" value='<?php if(isset($_SESSION["clg_details"]["cord_email"])){ echo $_SESSION["clg_details"]["cord_email"]; };?>' placeholder="Cordinator email" class="txt-sml">
      <input type="text" name="co-ordinator_mob_no" value='<?php if(isset($_SESSION["clg_details"]["cord_mob"])){ echo $_SESSION["clg_details"]["cord_mob"]; };?>' placeholder="Cordinator Contact No." class="txt-sml">
      <br>
      <select name="event" class="select" id="event_name" onchange="hide_form()">
				<?php
					if(isset($_SESSION["clg_details"])){
						
					}else{
						$_SESSION["clg_details"]["events"] = array(
															"0"=>"BUSINESS PLAN",
															"1"=>"BRIDGE KRITI",
															"2"=>"CHECK YOUR KNOWLEDGE",
															"3"=>"CODING CONTEST",
															"4"=>"DEBATE ENGLISH",
															"5"=>"FRUGAL ENGINEERING",
															"6"=>"JUST A MINUTE",
															"7"=>"ROBO RACE",
															"8"=>"ROBO WAR",
															"9"=>"TECHNICAL POSTER",
															"10"=>"DEBATE HINDI"
													);
					}
					$events_rem = $_SESSION["clg_details"]["events"];
					foreach($events_rem as $eve_id => $eve_name){
						echo "<option value='". $eve_id ." '>" . $eve_name  ."</option>";
					}

				?>
				</select>
      <select name="no_of_participants" class="select" onchange="disable()" id="select">
		<option value="null">-- Select Team Size--</option>
		<option value="1" id="option1">Team Size = 1</option>
        <option value="2" id="option2">Team Size = 2</option>
        <option value="3" id="option3">Team Size = 3</option>
        <option value="4" id="option4">Team Size = 4</option>
      </select>

    <div class="row" style="height:150px; overflow-y:scroll;">
    <div class="col-sm-12" id="form1">

    	<input type="text" name="name[0]" placeholder="Name 1" class="txt-sml" style="margin-top: 10px;"><br>
    	<input type="text" name="email[0]" placeholder="Email 1" class="txt-sml"><br>
    	<input type="text" name="roll_no[0]" placeholder="Roll Number 1" class="txt-sml"><br>
    	<input type="text" name="mob_no[0]" placeholder="Mobile Number 1" class="txt-sml"><br>
			<input type="text" name="branch[0]" placeholder="Branch 1" class="txt-sml"><br>
			<input type="text" name="year[0]" placeholder="Year 1" class="txt-sml"><br>
			<input type="text" name="course[0]" placeholder="Course 1" class="txt-sml"><br>
    </div>
    <div class="col-sm-12" id="form2">
      <input type="text" name="name[1]" placeholder="Name 2" class="txt-sml" style="margin-top: 10px;"><br>
      <input type="text" name="email[1]" placeholder="Email 2" class="txt-sml"><br>
      <input type="text" name="roll_no[1]" placeholder="Roll Number 2" class="txt-sml"><br>
      <input type="text" name="mob_no[1]" placeholder="Mobile Number 2" class="txt-sml"><br>
			<input type="text" name="branch[1]" placeholder="Branch 2" class="txt-sml"><br>
			<input type="text" name="year[1]" placeholder="Year 2" class="txt-sml"><br>
			<input type="text" name="course[1]" placeholder="Course 2" class="txt-sml"><br>
    </div>
		
		<div class="col-sm-12" id="form3">
      <input type="text" name="name[2]" placeholder="Name 3" class="txt-sml" style="margin-top: 10px;"><br>
      <input type="text" name="email[2]" placeholder="Email 3" class="txt-sml"><br>
      <input type="text" name="roll_no[2]" placeholder="Roll Number 3" class="txt-sml"><br>
      <input type="text" name="mob_no[2]" placeholder="Mobile Number 3" class="txt-sml"><br>
			<input type="text" name="branch[2]" placeholder="Branch 3" class="txt-sml"><br>
			<input type="text" name="year[2]" placeholder="Year 3" class="txt-sml"><br>
			<input type="text" name="course[2]" placeholder="Course 3" class="txt-sml"><br>
    </div>

		<div class="col-sm-12" id="form4">
      <input type="text" name="name[3]" placeholder="Name 4" class="txt-sml" style="margin-top: 10px;"><br>
      <input type="text" name="email[3]" placeholder="Email 4" class="txt-sml"><br>
      <input type="text" name="roll_no[3]" placeholder="Roll Number 4" class="txt-sml"><br>
      <input type="text" name="mob_no[3]" placeholder="Mobile Number 4" class="txt-sml"><br>
			<input type="text" name="branch[3]" placeholder="Branch 4" class="txt-sml"><br>
			<input type="text" name="year[3]" placeholder="Year 4" class="txt-sml"><br>
			<input type="text" name="course[3]" placeholder="Course 4" class="txt-sml"><br>
    </div>
    	
    </div>
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
           <a href="co-ordinator-panel.php"><button><div class="btn-text">CONSOLE</div></button></a><br><br><br>
		   <a href="devpage.php"><button><div class="btn-text">DEV PAGE</div></button></a><br><br><br>
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

		<script>
			hide_form();
		</script>

	<?php 
		if(isset($_SESSION["msg"])){
			if($_SESSION["msg"]["type"] == "error"){
				echo '<script>document.getElementById("message").className="";
						document.getElementById("message").className="error";
						document.getElementById("message").innerHTML="<b>' 
							. $_SESSION["msg"]["head"] . '</b><br/>'
							. $_SESSION["msg"]["body"] . '";
					</script>';
			}else if($_SESSION["msg"]["type"] == "success"){
				echo '<script>document.getElementById("message").className="";
						document.getElementById("message").className="success";
						document.getElementById("message").innerHTML="<b>' 
							. $_SESSION["msg"]["head"] . '</b><br/>'
							. $_SESSION["msg"]["body"] . '";
					</script>';
			}
			unset($_SESSION["msg"]);
		}
		
	?>
    
</html>