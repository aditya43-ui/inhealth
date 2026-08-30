<?php
spl_autoload_unregister(array('YiiBase','autoload'));
require_once realpath(Yii::getPathOfAlias('webroot').'/protected/extensions/GoogleApi/vendor/autoload.php');
spl_autoload_register(array('YiiBase','autoload'));

Yii::import('application.extensions.GoogleApi.*');
//require 'vendor/google/apiclient/src/Google/autoload.php';




class MyGmail extends PHPMailerOAuth
{
	
	
	public function getToken(){
		
		
	}
	
	/**
	 * 
	 * @param type $opts 
	 * @return string
	 * $opts => menampung data array
	 * $opts['subject']
	 * $opts['body']
	 */
	
	/*public static function sendMail() {
		
		$mail = MyGmail::setup();
		
		//Set who the message is to be sent from
		
		
		//Set an alternative reply-to address
		//$mail->addReplyTo('reply_to@gmail.ug', 'James Scott');
		
		//Set who the message is to be sent to
		
		
		$mail->setForm('dummy.table01@gmail.com','Dummy Table');		
		
		//Set the subject line
		$mail->Subject = 'PHPMailer GMail XOAuth SMTP';
		
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		
		$mail->Body = "
				<!DOCTYPE html>
				<html>
				<head>
				<meta charset='ISO-8859-1'>
				<title>Datum :: PHPMailer Testing</title>
				</head>
				<body>
					<h3>Test email</h3>
					<p>This is a test email using phpmailer library 5.1.12</p>
					<hr/>
					<p>Using Google API Client instead of League OAuth2 client </p>
				</body>
				</html>";
		
		//Replace the plain text body with one created manually
		$mail->AltBody = 'AltBody :: This is a plain-text message body';
		$mail->addAddress('retakanes@gmail.com', 'John Doe');
		//send the message, check for errors
		if (!$mail->send()) {
			return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return "Message sent!";
		}
	}*/
	
	
	public static function setup() {
		$konfig_email = KonfigemailK::model()->find();
		// Create a new PHPMailer instance
		$mail = new PHPMailerOAuth; /* this must be the custom class we created */
	
		// Tell PHPMailer to use SMTP
		$mail->isSMTP();
	
		// Enable SMTP debugging
		$mail->SMTPDebug = 0;
	
		// Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
	
		// Set AuthType
		$mail->AuthType = 'XOAUTH2';
	
		// Whether to use SMTP authentication
		$mail->SMTPAuth = true;
	
		// Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';
	
		// Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
	
		// Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;
		
		// User Email to use for SMTP authentication - Use the same Email used in Google Developer Console
		$mail->oauthUserEmail = (!empty($konfig_email->konfigemail_email_name))?$konfig_email->konfigemail_email_name:Params::KONFIG_EMAIL_DEFAULT;
		
		$gmail_credentials = json_decode(file_get_contents(Yii::getPathOfAlias('webroot.token-access.googleApi') . DIRECTORY_SEPARATOR .'gmail-xoauth2-credentials.json'), true);
	
		//Obtained From Google Developer Console
		$mail->oauthClientId = $gmail_credentials['web']['client_id'];
		
		//Obtained From Google Developer Console
		$mail->oauthClientSecret = $gmail_credentials['web']['client_secret'];
		
		$gmail_token = json_decode(file_get_contents(Yii::getPathOfAlias('webroot.token-access.googleApi') . DIRECTORY_SEPARATOR .'gmail-xoauth2-token.json'), true);
	
	
		$mail->oauthRefreshToken = $gmail_token['refresh_token'];
	
		return $mail;
	}
			
}


?>
