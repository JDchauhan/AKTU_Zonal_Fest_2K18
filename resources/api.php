<?php

    /*
     *  Author: Jagdish Singh
     *  Github: https://github.com/JDchauhan
     *  Email : jagdish.chauhan01@gmail.com
     */
        
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.

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
    
    

    try {

        require_once 'util/config.php';
        require_once 'util/mail_util.php';
        
        function guid(){
            //generates unique id and return it
            $uuid= "" . rand(1,10000) . time() . rand(1,10000);
            return $uuid;
        }

        function validater($value,$type,$len = NULL){
            /*
            * :$value:  value to check
            * :$type:   "int/email"   to check whether value is type of or not
            * :$len :   (functionality pending)if len is passed then also limit to its value
            *
            * return true/ false accordingly
            */

            if($type == "int"){
                //number
                if (filter_var($value, FILTER_VALIDATE_INT) === 0 || !filter_var($value, FILTER_VALIDATE_INT) === false) {
                    if(strlen((string)$value) == 10){
                        return true;
                    }else{
                        return false;
                    }   
                } else {
                    return false;
                }
            }else{
                //email
                if (!filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                    return true;
                } else {
                    return false;
                }
            }

        }

        function register(){
            /*
             * function used to register a new user through POST data
             */
            global $session_get;

            $name = $_POST["name"];
            $clg = $_POST["clg_name"]; 
            $email = $_POST["email"];
            $roll = (int)$_POST["roll_no"];
            $mobile = (int)$_POST["mob_no"];
            $pass = $_POST["pass"];
            $verification_token = guid();

            $err_form = "";
            $err_status = 0;

            if(!validater($mobile,"int")){
                $err_form .= "invalid mobile <br/>";
                $err_status = 1;
            }
            if(!validater($roll,"int")){
                $err_form .= "invalid roll number <br/>";
                $err_status = 1;
            }
            if(!validater($email,"email")){
                $err_form .= "invalid email <br/>";
                $err_status = 1;
            }
            if($name == "" || $clg == "" || $email == "" || $roll == "" || $mobile == "" || $pass == ""){
                $err_form .= "Please fill all the details <br/>";
                $err_status = 1;
            }

            if($err_status){
                $_SESSION["msg"]["type"] = "error";
                $_SESSION["msg"]["head"] = "Registration Failed";
                $_SESSION["msg"]["body"] = $err_form;
                $head = "Location: ../pages/registrations.php?session=" . $session_get;                     
                header($head);
            }else{
                $conn=connections();
                
                //check if user exists
                $statement = executedStatement("SELECT email , status FROM Students WHERE
                                                email='$email' ");
                $result = $statement->Fetch(PDO::FETCH_ASSOC);
                
                if($result && $result["status"] == 0){
                    //verification pending
                    //update data for user and send verification link

                    $sql = "UPDATE Students SET roll='$roll', name='$name', password='$pass', mobile='$mobile', college='$clg', status=0  WHERE email='$email'";
                    $conn->exec($sql);
                    
                    //create Access_key for new registration-mail verification 
                    $sql = "UPDATE Access_key SET token='$verification_token' WHERE email='$email'AND service='new_registration' ";
                    $conn->exec($sql);
                    
                    //mail the new token
                    OTM($email, $roll, $name, $verification_token, "new_registration");

                    $_SESSION["msg"]["type"] = "success";
                    $_SESSION["msg"]["head"] = "Registration Successfull";
                    $_SESSION["msg"]["body"] = "Please verify your account by clicking on the link you recieved in your registered " .
                                                "email ID";
                    
                    $head = "Location: ../pages/login.php?session=" . $session_get;                     
                    header($head);

                }else if($result && $result["status"] == 1){
                    //user already exists
                    
                    $_SESSION["msg"]["type"] = "error";
                    $_SESSION["msg"]["head"] = "Registration Failed";
                    $_SESSION["msg"]["body"] = "This email id already exists. Please choose another";                
                    $head = "Location: ../pages/registrations.php?session=" . $session_get;
                    header($head);

                }else{
                    //fresh user
                    $sql = "INSERT INTO Students VALUES ('$roll', '$name', '$pass', '$email', '$mobile', '$clg', 0, NULL)"; 
                    $conn->exec($sql); 

                    $sql = "INSERT INTO Access_key VALUES ('$email', '$verification_token','new_registration')"; 
                    $conn->exec($sql);
                    
                    OTM($email, $roll, $name, $verification_token, "new_registration");//mail the new token
                    
                    $_SESSION["msg"]["type"] = "success";
                    $_SESSION["msg"]["head"] = "Registration Successfull";
                    $_SESSION["msg"]["body"] = "Please verify your account by clicking on the link you recieved in your registered " .
                                                "email ID";
                    
                    $head = "Location: ../pages/login.php?session=" . $session_get;
                    header($head);   
                }
            }
        }

        function download_event_csv(){
            global $session_get;
            //for coordinators- enter their unique id and this function download their event participations
            $token = $_POST["token"];
            $statement = executedStatement("SELECT event, event_id  FROM Events WHERE
                                             token='$token' ");
            $result = $statement->Fetch(PDO::FETCH_ASSOC);

            if($result){
                $event_id = $result["event_id"];
                $event_name = $result["event"];
                
                
                $statement = executedStatement("SELECT DISTINCT Students.roll, Students.name, Students.college, Students.email,
                                                Students.mobile FROM Students INNER JOIN
                                                Participation ON Students.email = Participation.email WHERE
                                                Participation.event_id='$event_id' ");
                //construct file
                $filepath = "downloads/" . $event_id . ".csv";
                $result = $statement->FetchAll(PDO::FETCH_ASSOC);
                $file = fopen($filepath,"w");

                $arr[0] = ",," . $event_name  ;
                $arr[1] = "";
                $arr[2] = "Roll No, Name, College, Email, Mobile"  ;
                $arr[3] = "";

                for($i=0; $i<sizeof($result); $i++ ){
                    $line = "" . $result[$i]["roll"] . ","  . $result[$i]["name"] .  ","  . $result[$i]["college"] . 
                            ","  . $result[$i]["email"] .  ","  . $result[$i]["mobile"];
                    $arr[$i + 4] = $line;   
                }
                foreach ($arr as $line){
                    fputcsv($file,explode(',',$line));
                }
                fclose($file); 
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));
                flush(); // Flush system output buffer
                readfile($filepath);

            }else{
                
                $_SESSION["msg"]["type"] = "error";
                $_SESSION["msg"]["head"] = "Access Denied";
                $_SESSION["msg"]["body"] = "Please enter the correct key";
                
                $head = "Location: ../pages/co-ordinator-panel.php?session=" . $session_get;
                header($head);
            }

        }












        //url resolving GET 
        $possible_url = array("register", "download_event_csv");

        $value = "An error has occurred";

        if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)){
        
            switch ($_GET["action"]){
        
                case "register":
                        register();
                    break;

                case "download_event_csv":
                    download_event_csv();
                break;

                default:    
                    session_unset();
                    session_destroy();
                    session_start(array($session_get));
                    $_SESSION["msg"]["type"] = "success";
                    $_SESSION["msg"]["head"] = "Reset Link sended";
                    $_SESSION["msg"]["body"] = "We have sended you a password reset link. Please click on the link to reset " .
                                                "your passeword";
                    $head = "Location: ../index.php?session=" . $session_get;
                    header($head);
                    


            }
        }
        else{
            session_unset();
            session_destroy();
            $head = "Location: ../index.php?session=" . $session_get;
            header($head);
        }
        $conn = null;
    }
	catch(PDOException $e) {
        //TODO:- exception mail to admin with timestamp and other required details
		echo "Error: " . $e->getMessage();
	}
?>
