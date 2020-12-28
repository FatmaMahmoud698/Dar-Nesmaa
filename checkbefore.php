<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['btncheck'])) {
	include_once "client.php";
	$cl= new client();
	$cl->setemail($_POST['txtmail']);
	$client=$cl->getByEmail();
	if($row=mysqli_fetch_assoc($client)){
		$no=rand(1111,9999);
		$link="https://localhost/NTI2021/DarNesmaa/updatePassword.php?id=".$row["ClientID"];
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	// Instantiation and passing `true` enables exceptions
		// Load Composer's autoloader
		require 'vendor/autoload.php';
		$mail = new PHPMailer(true);

		try {
		    //Server settings
		    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;        // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = 'darnesmaa@gmail.com';                     // SMTP username
		    $mail->Password   = 'Fatma123@123';                               // SMTP password
		    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 465;                                    // TCP port to connect to, use 465,587 for `PHPMailer::ENCRYPTION_SMTPS` above

		    //Recipients
		    $mail->setFrom('darnesmaa@gmail.com', 'Dar Nesmaa');
		    $mail->addAddress($_POST["txtmail"], 'User');     // Add a recipient
		    // $mail->addAddress('ellen@example.com');               // Name is optional
		    // $mail->addReplyTo('info@example.com', 'Information');
		    // $mail->addCC('cc@example.com');
		    // $mail->addBCC('bcc@example.com');

		    // Attachments
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Forget Password';
		    $mail->Body ="Dears : \n Your Verfication Code is ".$no."\n";//.$link;
		    // $mail->AltBody = '';

		    $mail->send();
		    $_SESSION["code"]=$no;
		 	// echo("<div class='alert alert-success'> Check Your Email </div>");	
		 	header("location: updatePassword.php"); //write where u want to go 
		 	// echo("<div class='alert alert-success'> Check Your Email </div>");	
		 	} catch (Exception $e) {
		 		echo ("<script> alert('Message could not be sent . Mailer Error: {$mail->ErrorInfo})'; </script>");
		    // header("location: index.php");
		}
	}	
}