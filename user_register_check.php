<?php

include 'components/connect.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}


if(isset($_POST['submit'])){
   $password=$_POST['pass'];
   $fname = $_POST['firstName'];
   $fname = filter_var($fname, FILTER_SANITIZE_STRING);
   $lname = $_POST['lastName'];
   $lname = filter_var($lname, FILTER_SANITIZE_STRING);
   $phone = $_POST['phoneNumber'];
   $phone=filter_var($phone, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $gender= $_POST['gender'];
   $gender = filter_var($gender, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
function sendOTP($filename,$email) {
    $otp = rand(100000,999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['mail'] = $email;
    try{

        //Create instance of PHPMailer
$mail = new PHPMailer;
//Set mailer to use smtp
$mail->isSMTP();
//Define smtp host
$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
$mail->SMTPSecure = "tls";
//Port to connect smtp
$mail->Port = "587";
//Set gmail username
$mail->Username = "e.labweb2022@gmail.com";
//Set gmail password
$mail->Password = "iwbvyevhcgzoijwx";
//Email subject
$mail->Subject = "E-Lab : Email verification";
//Set sender email
$mail->setFrom('e.labweb2022@gmail.com',"User-Verification");
//Enable HTML
$mail->isHTML(true);
$mail->Body="<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
<br><br>
<p>With regrads,</p>
<b>E-Lab community</b>
";
$mail->addAddress($email);
//Send email
$mail->send();

//Closing smtp connection
$mail->smtpClose();

header("Location: verification.php");
exit();
}catch (Exception $e) {
header("Location: $filename?error=.$mail->ErrorInfo.unknown error occurred");
exit();
}
    
  }

   
	if (empty($email)) {
		header("Location: user_register.php?error=Email is required");
	    exit();
	}else if(empty($pass)){
        header("Location: user_register.php?error=Password is required");
	    exit();
	}
	else if(empty($cpass)){
        header("Location: user_register.php?error=Confirm Password is required");
	    exit();
	}

	else if(empty($fname)){
        header("Location: user_register.php?error=First Name is required");
	    exit();
	}

	else if(empty($lname)){
        header("Location: user_register.php?error=Last Name is required");
	    exit();
	}
	else if(empty($phone)){
        header("Location: user_register.php?error=Phone Number is required");
	    exit();
    }else if(empty($gender)){
        header("Location: user_register.php?error=Gender is required");
	    exit();
    }else if($pass !== $cpass){
        header("Location: user_register.php?error=The confirmation password does not match");
	    exit();
	}else{
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
        if (!preg_match ("/^[a-zA-z]*$/", $fname) || !preg_match ("/^[a-zA-z]*$/", $lname)) {  
            header("Location: user_register.php?error=Only alphabets and whitespace are allowed for First or Last Name");
            exit();
                     
        } else if(!preg_match ("/^[0-9]*$/", $phone) || strlen($phone)!=10){
            header("Location: user_register.php?error=Phone Number is not valid");
            exit();

        }else if(!preg_match ($pattern, $email)){
            header("Location: user_register.php?error=Give valid Email");
            exit();
        }else if(strlen($password)<8){
            header("Location: user_register.php?error=password length should be grater than 8");
            exit();
        }else{


        if($select_user->rowCount() > 0){
            header("Location: user_register.php?error=The email is taken try another");
	        exit();
         }else{
            $insert_user = $conn->prepare("INSERT INTO `users`(firstName,lastName,phoneNumber,gender,email,password,status) VALUES(?,?,?,?,?,?,?)");
            $insert_user->execute([$fname,$lname,$phone,$gender, $email, $cpass,0]);
            if($insert_user){
                  
            
            sendOTP("user_register.php",$email);
            



         }

        }

    }
    }

    

}
else{
        header("Location: user_register.php");
	exit();
    }

 