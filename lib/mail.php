<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require '../lib/PHPMailer/Exception.php';
	require '../lib/PHPMailer/PHPMailer.php';
	require '../lib/PHPMailer/SMTP.php';
	class Mail
	{
		
		public static function sendMail($mailFrom,$mailFromName,$mailTo,$mailSubject,$mailText)
		{
			try
			{
				$mail = new PHPMailer(true); 
				//Server settings
				$mail->SMTPDebug = 0;                                 // disable verbose debug output
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'mail.kouize.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'contact@kouize.com';                 // SMTP username
				$mail->Password = 'geii7805ER';                           // SMTP password
				$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 465;                                    // TCP port to connect to
				//Recipients
				$mail->setFrom('admin@kouize.com', 'Contact Kouize.com');
				$mail->addAddress($mailTo);     // Add a recipient
				$mail->addReplyTo($mailFrom, $mailFromName);
				$mail->addCC('philippe.lucidarme@univ-angers.fr');
				//$mail->addBCC('bcc@example.com');
			
				//Attachments
				//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			
				//Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $mailSubject;
				$mail->Body    = $mailText;
				$mail->AltBody = $mailText;
			
				//$mail->send();
				return (true);
			}
			catch (Exception $e)
			{
				return(false);
			}
		}
	
	}
?>