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
            
            $clg_code = 123;
            $clg = $_POST["clg_name"]; 
            $event_id = $_POST["event"] + 1;
            $teamSize = $_POST["no_of_participants"];  
            $cordinator = $_POST["co-ordinator_name"];
            $cordinator_email = "hdh2@dh.com";
            $cordinator_mobile = 9953841590;

            $team = guid();

            $course[0] = "B.tech";
            $branch[0] = "IT";
            $year[0] = "3";

            $name = $_POST["name"];
            $email = $_POST["email"];
            $roll = $_POST["roll_no"];
            $mobile = $_POST["mob_no"];
            
            $err_form = "";
            $err_status = 0;

            if( $clg_code == "" ||$clg == "" || $cordinator == "" || $cordinator_email == "" || $cordinator_mobile == ""){
                $err_status = 1;
            }
            if( validater((int)$cordinator_mobile,"int") && validater($cordinator_email,"email") ){
                
            }else{
                $err_status = 1;
            }
            
            

            for($i = 0; $i < $teamSize; $i++){
                if(! validater((int)$mobile[$i],"int")  ){
                    $err_status = 1;
                }
                if(! validater((int)$roll[$i],"int")){
                    $err_status = 1;
                }
                if(! validater($email[$i],"email") ){
                    $err_status = 1;
                }
                if($name[$i] == "" || $email[$i] == "" || $roll[$i] == "" || $mobile[$i] == "" || 
                        $course[$i] == "" || $branch[$i] == "" || $year[$i] == "" ){
                    $err_status = 1;
                }
            }

            if($err_status){
                $_SESSION["msg"]["type"] = "error";
                $_SESSION["msg"]["head"] = "Registration Failed";
                $_SESSION["msg"]["body"] = "Please Fill The Correct Details";
                
                $head = "Location: ../pages/registrations.php?session=" . $session_get;                     
                header($head);
            }else{

                $_SESSION["clg_details"]["clg_code"] = $clg_code;
                $_SESSION["clg_details"]["clg_name"] = $clg;
                $_SESSION["clg_details"]["cord_name"] = $cordinator;
                $_SESSION["clg_details"]["cord_email"] = $cordinator_email;
                $_SESSION["clg_details"]["cord_mob"] = $cordinator_mobile;


                $conn=connections();
                
                //check if user exists
                if($teamSize == 1){
                    $statement = executedStatement("SELECT email FROM Student WHERE
                                                email='$email[0]' ");
                }else if($teamSize == 2){
                    $statement = executedStatement("SELECT email FROM Student WHERE
                                                email='$email[0]' OR email='$email[1]' ");
                
                }else if($teamSize == 3){
                    $statement = executedStatement("SELECT email FROM Student WHERE
                                                email='$email[0]'  OR email='$email[1]' OR  email='$email[2]' ");
                }else if($teamSize == 4){
                    $statement = executedStatement("SELECT email FROM Student WHERE
                                                email='$email[0]'  OR email='$email[1]'  OR email='$email[2]'  OR email='$email[3]' ");
                }

                $result = $statement->Fetch(PDO::FETCH_ASSOC);

                if($result){
                    
                    $_SESSION["msg"]["type"] = "error";
                    $_SESSION["msg"]["head"] = "Email ID already exists";
                    $_SESSION["msg"]["body"] = "One of the email ID you entered already exists in our DataBase";
                    
                    $head = "Location: ../pages/registrations.php?session=" . $session_get;                     
                    header($head);

                }else{
                    //fresh user
                    for($i = 0; $i < $teamSize; $i++){
                        $sql = "INSERT INTO Student VALUES ('', '$roll[$i]', '$name[$i]', '$course[$i]', '$branch[$i]', '$year[$i]',
                                  '$email[$i]' , '$mobile[$i]', '$clg_code' ,'$clg', '$cordinator' ,
                                 '$cordinator_email', '$cordinator_mobile' ,'$event_id', '$team')"; 
                        $conn->exec($sql); 
                    }
                    
                    $events_all = $_SESSION["clg_details"]["events"];
                    unset($events_all[$event_id-1]);
                    $_SESSION["clg_details"]["events"] = $events_all;
                    
                    $_SESSION["msg"]["type"] = "success";
                    $_SESSION["msg"]["head"] = "Registration Successfull";
                    $_SESSION["msg"]["body"] = "Participants successfully Registered for this event";
                    
                    $head = "Location: ../pages/registrations.php?session=" . $session_get;
                    header($head);   
                }
            }
        }

        function event_data($token, $types){
            global $session_get;
            if($types == "admin"){
                $statement = executedStatement("SELECT token  FROM Zonal_Event WHERE
                                             token='$token' AND event = 'admin' ");
                $result = $statement->Fetch(PDO::FETCH_ASSOC);
                if($result){
                    $statement = executedStatement("SELECT * FROM Student NATURAL JOIN Zonal_Event ORDER BY team DESC ");
                    $result = $statement->FetchAll(PDO::FETCH_ASSOC);
                
                    $filepath = "downloads/aktu_zonal.csv";
                
                }
            }else{
                global $session_get;
                //for coordinators- enter their unique id and this function download their event participations
                $token = $_POST["token"];
                $statement = executedStatement("SELECT event, event_id  FROM Zonal_Event WHERE
                                                token='$token' ");
                $result = $statement->Fetch(PDO::FETCH_ASSOC);
                if($result){
                    $event_id = $result["event_id"];
                    $event_name = $result["event"];
                    
                    
                    $statement = executedStatement("SELECT * FROM Student WHERE event_id = '$event_id' ORDER BY college ");
                    //construct file
                    $filepath = "downloads/" . $event_id . ".csv";
                    $result = $statement->FetchAll(PDO::FETCH_ASSOC);
                }        
            }

            if($result && $types == "cordinator"){
                $file = fopen($filepath,"w");
                $arr[0] = ",,,," . $event_name  ;
                $arr[1] = "";
                $arr[2] = "Sno ,Roll No, Name, College, Course, Year, Branch, Email, Mobile, Team"  ;
                $arr[3] = "";

                for($i=0; $i<sizeof($result); $i++ ){
                    $line = "". ($i + 1) . "," . $result[$i]["roll"] . ","  . $result[$i]["name"] .  ","  . $result[$i]["college"] . 
                            "," . $result[$i]["course"] . "," . $result[$i]["year"] . "," . $result[$i]["branch"] . 
                            ","  . $result[$i]["email"] .  ","  . $result[$i]["mobile"] .  ","  . "TID-" .$result[$i]["team"];
                    $arr[$i + 4] = $line;   
                }
            }else if($result && $types == "admin"){
                $file = fopen($filepath,"w");
                $arr[0] = ",,,,," . "AKTU ZONAL FEST 2K18"  ;
                $arr[1] = "";
                $arr[2] = "Sno,Event, Roll No, Name, College code, College, Course, Year, Branch, Email, Mobile, Cordinator, Cordinator Email, Cordinator Mobile, Team"  ;
                $arr[3] = "";

                for($i=0; $i<sizeof($result); $i++ ){
                    $line = ""  . ($i + 1) . ","  . $result[$i]["event"]  .","  . $result[$i]["roll"] . ","  . $result[$i]["name"] .
                            "," . $result[$i]["college_code"] . "," . $result[$i]["college"] .
                            "," . $result[$i]["course"] . "," . $result[$i]["year"] . "," . $result[$i]["branch"] . 
                            "," . $result[$i]["email"] .  ","  . $result[$i]["mobile"] . "," . $result[$i]["cordinator_name"] .
                            "," . $result[$i]["cordinator_email"] . "," . $result[$i]["cordinator_mobile"] . 
                            "," . "TID-" .$result[$i]["team"];
                    $arr[$i + 4] = $line;   
                }
            }
            if($result){
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
        $possible_url = array("register", "download_event_csv", "download_event_csv_all");

        $value = "An error has occurred";

        if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)){
        
            switch ($_GET["action"]){
        
                case "register":
                        register();
                    break;

                case "download_event_csv":
                    event_data($_POST["token"],"cordinator");
                break;

                case "download_event_csv_all":
                    event_data($_POST["token"],"admin");
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
