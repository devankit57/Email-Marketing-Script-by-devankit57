<?php
//send_mail.php
// Initialize the session
session_start();
 
 //Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: index.php");


   exit;
}

if(isset($_POST['email_data']))
{
	require 'class/PHPMailerAutoload.php';
	require_once'config.php';
	#$sql = "SELECT * FROM content";
	#$result = $link->query($sql);
	#while($row = $result->fetch_assoc()) {
	#	$subject=$row["subject"]; 
	#	$content=$row["content"]; 
	#  }
	$output = '';
	foreach($_POST['email_data'] as $row)
	{
		$mail = new PHPMailer;
		$mail->IsSMTP();	
							//Sets Mailer to send message using SMTP
		$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = '465';								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'email';					//Sets SMTP username
		$mail->Password = 'Password';					//Sets SMTP password
		$mail->SMTPSecure = 'ssl';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->From = 'email';			//Sets the From email address for the message
		$mail->FromName = 'Test';					//Sets the From name of the message
		$mail->AddAddress($row["email"], $row["name"]);	//Adds a "To" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML
		$mail->Subject = "Best Deal , 20% off on all hosting purchases"; //Sets the Subject of the message
		//An HTML or plain text message body
		$mail->Body = 
		"Hostimon wishes you a very happy 2023<br>
		And here we bring you an amazing offer <br>
		20% off on all hosting purchases <br>
		<img src=C:\Users\ankit\Downloads\newyear.png <br><br>
		
		Thank you<br>
		Hostimon<br>
		Admin";

		$mail->AltBody = '';

		$result = $mail->Send();						//Send an Email. Return true on success or false on error

		if(!$mail->Send()){
			$arr="Something Went Wrong ";
					echo ("<script LANGUAGE='JavaScript'>
		window.alert('$arr');
		
		 </script>");
		}else{
			
			echo 'ok';
		}

	}
	
}

?>
