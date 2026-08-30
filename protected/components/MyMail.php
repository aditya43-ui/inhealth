<?php
Yii::import('application.extensions.PHPMailer.*');
Yii::import('application.extensions.PHPMailer.phpmailer.phpmailer.PHPMailerAutoload');
require ("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");

class MyMail extends PHPMailer
{				
	public static function  setup(){
		$data = KonfigemailK::model()->find();
		
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		if ($data->konfigemail_ishtml){
			$mail->Debugoutput = 'html';		
		}
		$mail->Host = $data->konfigemail_host;	
		$mail->Port = $data->konfigemail_port;
		$mail->SMTPAuth = $data->konfigemail_smtp_auth;
		$mail->SMTPSecure = $data->konfigemail_smtp_secure;
		$mail->Username = $data->konfigemail_username;
		$mail->Password = $data->konfigemail_password;
		
		return $mail;
	}
}
?>
