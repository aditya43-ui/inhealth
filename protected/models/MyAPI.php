<?php

/**
 * Digunakan untuk mengirim data ke API Aplikasi Lain.
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.components
 */
class MyAPI extends CComponent {	
	
    /**
     * Melakukan request ke API yang dituju yang dimana hasil-nya diambil oleh
     * aplikasi.
     * 
     * @param string $url    URL API
     * @param string $method Method (GET/POST/Dll)
     * @param mixed  $header Header yang akan di-submit
     * @param string $body   Isi pesan
     * @return mixed         Response/Hasil yang didapat dari API yang dituju.
     */
	public function apiRequest($url, $method = 'GET', $header = array(), $body = null) {
		$session = curl_init($url);
		
		$arrHeader = array();
		
		if (empty($header['Content-Type'])) {
			$header['Content-Type'] = ' application/xml; charset=utf-8';
		}
		
		foreach ($header as $headerParam=>$value) {
			array_push($arrHeader, $headerParam.": ".$value);
		}
		
		curl_setopt($session, CURLOPT_URL, $url);
		curl_setopt($session, CURLOPT_HTTPHEADER, $arrHeader);
		curl_setopt($session, CURLOPT_VERBOSE, true);
		
		switch($method){
			case 'POST':
				curl_setopt($session, CURLOPT_POST, true );
				curl_setopt($session, CURLOPT_POSTFIELDS, $body);
				break;
			case 'PUT':
				curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($session, CURLOPT_POSTFIELDS, $body);
				break;
			case 'DELETE':
				curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($session, CURLOPT_POSTFIELDS, $body);
				break;
		}
		
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($session);

                return $response;
	}
	
}
