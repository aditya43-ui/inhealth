<?php
spl_autoload_unregister(array('YiiBase','autoload'));
require_once realpath(Yii::getPathOfAlias('webroot').'/protected/extensions/GoogleApi/vendor/autoload.php');
spl_autoload_register(array('YiiBase','autoload'));

Yii::import('application.extensions.GoogleApi.*');
//require 'vendor/google/apiclient/src/Google/autoload.php';




class MyGmailToken extends Google_Client
{
	
	
	public function getToken(){
		if (!isset($_GET['state'])){
			$client = new Google_Client();
			$client->setAuthConfigFile(Yii::getPathOfAlias('webroot.token-access.googleApi') . DIRECTORY_SEPARATOR .'gmail-xoauth2-credentials.json');		
			$client->addScope('https://mail.google.com/');
			$client->setAccessType('offline');
			$client->setRedirectUri($this->cekRedirect($_SERVER['HTTP_HOST'],'getToken'));//$_SERVER['HTTP_HOST']		

			if (! isset($_GET['code'])) {
			  $auth_url = $client->createAuthUrl();
			//  var_dump($auth_url);die;
			  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
			} else {			
				$client->authenticate($_GET['code']);
				$new_access_token = $client->getAccessToken();

				if (strpos(Yii::app()->request->getBaseUrl(), '.xip.io') == false){				
					if (file_put_contents(Yii::getPathOfAlias('webroot').'/token-access/googleApi/gmail-token-temp.json', $new_access_token)) {				
						header('Location: ' . filter_var($this->changeRedirect($_SERVER['HTTP_HOST'],'getToken').'&state=save', FILTER_SANITIZE_URL));				
					}

				}

				//if (file_put_contents(Yii::getPathOfAlias('webroot').'/token-access/googleApi/gmail-xoauth2-token.json', $new_access_token)) {				
					echo "Token Access Has Been Copied <br/>";
					echo '<script>window.opener.$("#SAKonfigemailK_access_token").val(\''.$new_access_token.'\');</script>';
				//}
			}		
		}else{
			$new_access_token = file_get_contents(Yii::getPathOfAlias('webroot.token-access.googleApi') . DIRECTORY_SEPARATOR .'gmail-token-temp.json');
				
			echo "Token Access Has Been Copied <br/>";
			echo '<script>window.opener.$("#SAKonfigemailK_access_token").val(\''.$new_access_token.'\');</script>';
		}
		
	}
	
	public function getNewToken(){
		if (!isset($_GET['state'])){
			$client = new Google_Client();
			$client->setAuthConfigFile(Yii::getPathOfAlias('webroot.token-access.googleApi') . DIRECTORY_SEPARATOR .'gmail-xoauth2-credentials.json');		
			$client->addScope('https://mail.google.com/');
			$client->setAccessType('offline');
			if (isset($_GET['client']) AND isset($_GET['secret'])){
				$client->setClientId($_GET['client']);
				$client->setClientSecret($_GET['secret']);		
				$client->setRedirectUri($this->cekRedirect($_SERVER['HTTP_HOST'],'getNewToken'));//$_SERVER['HTTP_HOST']

				$creden = '{"client": "'.$_GET['client'].'","secret": "'.$_GET['secret'].'","uri": "'.$this->cekRedirect($_SERVER['HTTP_HOST'],'getNewToken').'"}';

				file_put_contents(Yii::getPathOfAlias('webroot').'/token-access/googleApi/gmail-temp.json', $creden);
			}

			if (isset($_GET['code'])){				
				$gmail_credentials = json_decode(file_get_contents(Yii::getPathOfAlias('webroot.token-access.googleApi') . DIRECTORY_SEPARATOR .'gmail-temp.json'), true);
				$client->setClientId($gmail_credentials['client']);
				$client->setClientSecret($gmail_credentials['secret']);		
				$client->setRedirectUri($gmail_credentials['uri']);//$_SERVER['HTTP_HOST']
			}



			if (! isset($_GET['code'])) {
			  $auth_url = $client->createAuthUrl();
			  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
			} else {			
				$client->authenticate($_GET['code']);
				$new_access_token = $client->getAccessToken();
				
				if (strpos(Yii::app()->request->getBaseUrl(), '.xip.io') == false){				
					if (file_put_contents(Yii::getPathOfAlias('webroot').'/token-access/googleApi/gmail-token-temp.json', $new_access_token)) {				
						header('Location: ' . filter_var($this->changeRedirect($_SERVER['HTTP_HOST'],'getToken').'&state=save', FILTER_SANITIZE_URL));				
					}

				}
				
				//if (file_put_contents(Yii::getPathOfAlias('webroot').'/token-access/googleApi/gmail-xoauth2-token.json', $new_access_token)) {				
					echo "Token Access Has Been Copied <br/>";
					echo '<script>window.opener.$("#SAKonfigemailK_access_token").val(\''.$new_access_token.'\');</script>';
			}
				//}
		}else{
			$new_access_token = file_get_contents(Yii::getPathOfAlias('webroot.token-access.googleApi') . DIRECTORY_SEPARATOR .'gmail-token-temp.json');

			echo "Token Access Has Been Copied <br/>";
			echo '<script>window.opener.$("#SAKonfigemailK_access_token").val(\''.$new_access_token.'\');</script>';
		}			
		
	}
	
	public function cekRedirect($hostname,$tok='getToken'){
		$ip = gethostbyname($hostname);
		$host = $hostname;
		$uri = Yii::app()->request->getBaseUrl().'/index.php?r=site/'.$tok;
		$isSecure = false;

		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			$isSecure = true;
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
			$isSecure = true;
		}
		
		$REQUEST_PROTOCOL = $isSecure ? 'https://' : 'http://';
		
		if ($ip == $hostname){
			return $REQUEST_PROTOCOL.$ip.'.xip.io'.$uri;
		}else{
			return $REQUEST_PROTOCOL.$host.$uri;
		}
	}
	
	public function changeRedirect($hostname,$tok='getToken'){
		$ip = str_replace('.xip.io','',gethostbyname($hostname));
		$host = str_replace('.xip.io','',$hostname);
		$uri = Yii::app()->request->getBaseUrl().'/index.php?r=site/'.$tok;
		$isSecure = false;

		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			$isSecure = true;
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
			$isSecure = true;
		}
		
		$REQUEST_PROTOCOL = $isSecure ? 'https://' : 'http://';
		
		if ($ip == $hostname){
			return $REQUEST_PROTOCOL.$ip.$uri;
		}else{
			return $REQUEST_PROTOCOL.$host.$uri;
		}
	}
		
			
}


?>
