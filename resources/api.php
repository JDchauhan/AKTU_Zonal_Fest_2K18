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
            
            $clg = $_POST["clg_name"]; 
            $event_id = $_POST["event"] + 1;
            $teamSize = $_POST["no_of_participants"];  
            

            $name_1 = $_POST["name_1"];
            $email_1 = $_POST["email_1"];
            $roll_1 = (int)$_POST["roll_no_1"];
            $mobile_1 = (int)$_POST["mob_no_1"];
            
            $name_2 = $_POST["name_2"];
            $email_2 = $_POST["email_2"];
            $roll_2 = (int)$_POST["roll_no_2"];
            $mobile_2 = (int)$_POST["mob_no_2"];
            
            $team = guid();

            $err_form = "";
            $err_status = 0;

            if($teamSize == 2){
                if(!( validater($mobile_1,"int") && validater($mobile_1,"int") ) ){
                    $err_form .= "invalid mobile <br/>";
                    $err_status = 1;
                }
                if(!(validater($roll_1,"int") && validater($roll_2,"int"))){
                    $err_form .= "invalid roll number <br/>";
                    $err_status = 1;
                }
                if(!(validater($email_1,"email") && validater($email_2,"email") )){
                    $err_form .= "invalid email <br/>";
                    $err_status = 1;
                }
                if($name_1 == "" || $clg == "" || $email_1 == "" || $roll_1 == "" || $mobile_1 == "" ||
                    $name_1 == "" ||  $email_1 == "" || $roll_1 == "" || $mobile_1 == ""){
                    $err_form .= "Please fill all the details <br/>";
                    $err_status = 1;
                }
            }else{
                if(!( validater($mobile_1,"int")) ){
                    $err_form .= "invalid mobile <br/>";
                    $err_status = 1;
                }
                if(!(validater($roll_1,"int") )){
                    $err_form .= "invalid roll number <br/>";
                    $err_status = 1;
                }
                if(!(validater($email_1,"email") )){
                    $err_form .= "invalid email <br/>";
                    $err_status = 1;
                }
                if($name_1 == "" || $clg == "" || $email_1 == "" || $roll_1 == "" || $mobile_1 == "" ){
                    $err_form .= "Please fill all the details <br/>";
                    $err_status = 1;
                }
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
                if($teamSize == 2){
                    $statement = executedStatement("SELECT email FROM Student WHERE
                                                email='$email_1' OR email='$email_2' ");
                    $result = $statement->Fetch(PDO::FETCH_ASSOC);
                
                }else{
                    $statement = executedStatement("SELECT email FROM Student WHERE
                                                email='$email_1' ");
                    $result = $statement->Fetch(PDO::FETCH_ASSOC);
                }
                
                if($result){
                    
                    $_SESSION["msg"]["type"] = "error";
                    $_SESSION["msg"]["head"] = "Email ID already exists";
                    $_SESSION["msg"]["body"] = "One of the email ID you entered already exists in our DataBase";
                    
                    $head = "Location: ../pages/registrations.php?session=" . $session_get;                     
                    header($head);

                }else{
                    //fresh user
                    if($teamSize == 2){
                        $sql = "INSERT INTO Student VALUES ('$roll_1', '$name_1', '$email_1', '$mobile_1', '$clg', '$event_id', '$team')"; 
                        $conn->exec($sql); 
                        $sql = "INSERT INTO Student VALUES ('$roll_2', '$name_2', '$email_2', '$mobile_2', '$clg', '$event_id', '$team')"; 
                        $conn->exec($sql);  
                    

                    }else{
                        $sql = "INSERT INTO Student VALUES ('$roll_1', '$name_1', '$email_1', '$mobile_1', '$clg', '$event_id', '$team')"; 
                        $conn->exec($sql); 
                    }
                    
                    $_SESSION["msg"]["type"] = "success";
                    $_SESSION["msg"]["head"] = "Registration Successfull";
                    $_SESSION["msg"]["body"] = "Participants successfully Registered for this event";
                    
                    $head = "Location: ../pages/registrations.php?session=" . $session_get;
                    header($head);   
                }
            }
        }

        function download_event_csv(){
            global $session_get;
            //for coordinators- enter their unique id and this function download their event participations
            $token = $_POST["token"];
            $statement = executedStatement("SELECT event, event_id  FROM Zonal_Event WHERE
                                             token='$token' ");
            $result = $statement->Fetch(PDO::FETCH_ASSOC);

            if($result){
                $event_id = $result["event_id"];
                $event_name = $result["event"];
                
                
                $statement = executedStatement("SELECT * FROM Student WHERE event_id = '$event_id' ORDER BY team DESC ");
                //construct file
                $filepath = "downloads/" . $event_id . ".csv";
                $result = $statement->FetchAll(PDO::FETCH_ASSOC);

                $file = fopen($filepath,"w");

                $arr[0] = ",," . $event_name  ;
                $arr[1] = "";
                $arr[2] = "Roll No, Name, College, Email, Mobile, Team"  ;
                $arr[3] = "";

                for($i=0; $i<sizeof($result); $i++ ){
                    $line = "" . $result[$i]["roll"] . ","  . $result[$i]["name"] .  ","  . $result[$i]["college"] . 
                            ","  . $result[$i]["email"] .  ","  . $result[$i]["mobile"] .  ","  . "TID-" .$result[$i]["team"];
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
