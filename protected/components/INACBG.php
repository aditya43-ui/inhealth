<?php

/**
 * Fungsi INACBG untuk Klaim BPJS.
 *
 * @author Deni Hamdani
 */
class INACBG {
	public $key = "ea11b439e95c95d21a96a45bdc3c43bcd6b3a908e5e2754c888ed19ebfa8ff5c";
	public $url = "http://192.168.0.234/E-Klaim/ws.php";
	
	
	
	public function sendRequestSEP($nosep) {
		$nosep = 
		$req = '{
			"metadata":
			{
				"method":"get_claim_data"
			},
			"data":
			{
				"nomor_sep": "'.$nosep.'"
			}
		}';
			/*
		CJSON::encode(array(
			'metadata'=>array(
				'method'=>'get_claim_data'
			),
			'data'=>array(
				'nomor_sep'=>"2601R00209160000002",
			)
		));
			 * 
			 */
		// var_dump($req);
		// data yang akan dikirimkan dengan method POST adalah encrypted:
		$payload = $this->mc_encrypt($req, $this->key);
		
		// tentukan Content-Type pada http header
		$header = array("Content-Type: application/x-www-form-urlencoded");
		// url server aplikasi E-Klaim,
		// silakan disesuaikan instalasi masing-masing
		// setup curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		// request dengan curl
		$response = curl_exec($ch);
		
		$first  = strpos($response, "\n")+1;
		$last   = strrpos($response, "\n")-1;
		$response = substr($response, $first, strlen($response) - $first - $last);

		// decrypt dengan fungsi mc_decrypt
		$response = $this->mc_decrypt($response,$this->key);
		// hasil decrypt adalah format json, ditranslate kedalam array

		// echo $response;
		
		return CJSON::decode($response);
	}
	
	private function mc_encrypt($data, $key) {
		/// make binary representasion of $key
		$key = hex2bin($key);
		/// check key length, must be 256 bit or 32 bytes
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}
		/// create initialization vector
		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		$iv = openssl_random_pseudo_bytes($iv_size); // dengan catatan dibawah
		/// encrypt
		$encrypted = openssl_encrypt($data,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv );

		  /// create signature, against padding oracle attacks
		$signature = mb_substr(hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit"); 

		/// combine all, encode, and format
		$encoded = chunk_split(base64_encode($signature.$iv.$encrypted));

		return $encoded;
	}  
	
	private function mc_decrypt($str, $strkey){
		/// make binary representation of $key
		$key = hex2bin($strkey);
		/// check key length, must be 256 bit or 32 bytes
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}
		/// calculate iv size
		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		/// breakdown parts
		$decoded = base64_decode($str);
		$signature = mb_substr($decoded,0,10,"8bit");
		$iv = mb_substr($decoded,10,$iv_size,"8bit");
		$encrypted = mb_substr($decoded,$iv_size+10,NULL,"8bit");
		/// check signature, against padding oracle attack
		$calc_signature = mb_substr(hash_hmac(
			"sha256",
			$encrypted,
			$key,
			true),0,10,"8bit"); 
		if(!$this->mc_compare($signature,$calc_signature)) {
			return "SIGNATURE_NOT_MATCH"; /// signature doesn't match
		}
		$decrypted = openssl_decrypt(
			$encrypted,
			"aes-256-cbc",
			$key,
			OPENSSL_RAW_DATA,
			$iv
		);
		return $decrypted;
   }

      /// Compare Function
	private function mc_compare($a, $b) {
		/// compare individually to prevent timing attacks
		/// compare length
		if (strlen($a) !== strlen($b)) return false;
		
		/// compare individual
		$result = 0;
		for($i = 0; $i < strlen($a); $i ++) {
			$result |= ord($a[$i]) ^ ord($b[$i]);
		}
		return $result == 0;
	}
	
	

}
