<?php
//mark your gmail account to enable low security apps-> https://myaccount.google.com/security
// https://support.google.com/accounts/answer/3466521?hl=en


//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

function sendEmail($email, $userName, $text, $verificationCode=0)
{
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	//Enable SMTP debugging
	$mail->SMTPDebug = SMTP::DEBUG_OFF;
	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';
	// use
	$mail->Port = 587;
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->SMTPAuth = true;
	$mail->Username = 'steampunkshoopofsteam@gmail.com';
	$mail->Password = 'steampunk-cyber';
	$mail->setFrom('steampunkshoopofsteam@gmail.com', 'Steampunk Shoop of Steam');

	$mail->addAddress('steampunkshoopofsteam@gmail.com', $userName);

	$mail->Subject = $text;

	$txtHTML="";

	if($text=="registration")
	{
		$txtHTML="Hello, thanks to reggister ".$userName." your verification code is: ".$verificationCode.' if you click <a href="http://localhost/PAPI/OnlineShop/index.php?page=verification&user='.$userName.'&code='.$verificationCode.'&validation">here</a> you will finish the registration';
	}
	else if($text=="forgot")
	{
		$txtHTML='Hello, '.$userName.' your verification code is: '.$verificationCode.' if you click <a href="http://localhost/PAPI/OnlineShop/index.php?page=verification&user='.$userName.'&code='.$verificationCode.'&forgot">here</a> you can reset your password';
	}

	$mail->msgHTML($txtHTML);
	//Replace the plain text body with one created manually
	$mail->AltBody = 'Para ctivar tu cuenta entra en activate.php y pon el codigo';
	//Attach an image file
	//send the message, check for errors
	if (!$mail->send()) {
	    echo 'Mailer Error: '. $mail->ErrorInfo;
	} else {
	    echo 'Message sent!';
	}
}


?>