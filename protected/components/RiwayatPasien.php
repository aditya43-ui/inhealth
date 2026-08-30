<?php

require_once __DIR__ . '/../../vendor/autoload.php';

class RiwayatPasien {

    var $mode = 1;
    var $uid = ""; //ex: 2603
    var $secret = ""; //ex: 1rs2hs3
    var $user_key = "";
    var $is_encrypt = true;   
    var $url = "";
    var $urlAplicare = "";
    var $port = "";
    var $bpjs_server_lokal = "";
    var $server = array();
    var $server_new = array();
    var $bpjs_v2 = false;
    var $bpjs_terenkripsi = false;
    var $kode_faskes = "";
    var $url_hend="";
    var $servicename_bpjs= "";
    var $servicename_bpjs_riwayat = "";



    function setInit() {
        $config = KonfigsystemK::model()->find();
        if (empty($config)) {
            return false;
        }

        $this->uid = $config->bpjs_uid;
        $this->secret = $config->bpjs_secret;
        $this->url = $config->bpjs_host;
        $this->urlAplicare = $config->bpjs_aplicare_host;
        $this->port = $config->bpjs_port;
        $this->servicename_bpjs = $config->servicename_bpjs;
        $this->servicename_bpjs_riwayat = $config->servicename_bpjs_riwayat;
        $this->bpjs_server_lokal = null;
        $this->user_key = $config->bpjs_userkey;
        $this->bpjs_v2 = $config->bpjs_v2;
        $this->is_encrypt = $config->bpjs_terenkripsi;
        $this->kode_faskes = $config->antreanonline_kodefaskes;
        $this->url_hend = $config->bridging_host;

        $this->setServer();

        return true;
    }

    function __construct() {

        if (!empty(Yii::app()->user) && Yii::app()->user->guestName != "Guest") {
            $this->setInit();
        } else {
            $this->setInit();
        }

        $this->setServer();
    }


    private function setServer() {
        $config = KonfigsystemK::model()->find();
        if (empty($config)) {
            return false;
        }
        if ($config->tipe_bridging == 2){
            $portBpjs = (!empty($this->port)? ':'.$this->port:"");
            $serviceName = '/'.$this->servicename_bpjs_riwayat;
            $urlport = $this->url_hend; //versi 1.1 url terbaru
            $this->server_new = array(
                'search_riwayat' => $urlport . '/api/rs/validate/'.$this->kode_faskes
            );
        }else{
            $portBpjs = (!empty($this->port)? ':'.$this->port:"");
            $serviceName = '/' . $this->servicename_bpjs_riwayat;
            $urlport = $this->url .$portBpjs . $serviceName; //versi 1.1 url terbaru
            $this->server_new = array(
                'search_riwayat' => $urlport . '/api/rs/validate/',
            );
        }
    }

    function output($content) {
        echo $content;
    }

    private function HashBPJS($args = '') {
        $timezone_from = Yii::app()->timeZone;
        $uid = $this->uid;
        date_default_timezone_set('UTC');
        $timestmp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $str = $uid . "&" . $timestmp;
        $secret = $this->secret;
        $hasher = base64_encode(hash_hmac('sha256', utf8_encode($str), utf8_encode($secret), TRUE)); //signature;
//			echo $uid."-".$timestmp."-".$hasher;exit;
        date_default_timezone_set($timezone_from);
        return array($uid, $timestmp, $hasher);
    }

    private function request($url, $hashsignature, $uid, $timestmp, $method = '', $myvars = '', $contentType = 'Application/json') {
        $session = curl_init($url);
        $arrheader = array(
            'X-cons-id: ' . $uid,
            'X-timestamp: ' . $timestmp,
            'X-signature: ' . $hashsignature,
            'Accept: application/json',
            'Content-Type: '.$contentType,
        );

        if ($this->bpjs_v2 && !empty($this->user_key)) {
            $arrheader[] = 'user_key: ' . $this->user_key;
        }
        
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session,CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($session,CURLOPT_SSL_VERIFYPEER, 0);

        switch ($method) {
            case 'POST':
                curl_setopt($session, CURLOPT_POST, true);
                curl_setopt($session, CURLOPT_POSTFIELDS, $myvars);
                break;
            case 'PUT':
                curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($session, CURLOPT_POSTFIELDS, $myvars);
                break;
            case 'DELETE':
                curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($session, CURLOPT_POSTFIELDS, $myvars);
                break;
        }

        curl_setopt($session, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        $err = curl_errno($session);
        $err_msg = curl_error($session);
        $requestHeaders = curl_getinfo($session);
        curl_close($session);

        // echo "<pre>";
        // var_dump($url, $myvars, $response, $err); die;
        // echo $response; die;

        if ($err == 0) {
            if ($this->is_encrypt) {
                $json_res = CJSON::decode($response);
                // var_dump($json_res); die;
    
                if (!empty($json_res['metaData']) && $json_res['metaData']['code'] == 200 && !empty($json_res['response']) && !is_array($json_res['response'])) {
                    $str_dec = $this->stringDecrypt($this->uid.$this->secret.$timestmp, $json_res['response']);
                    $res = $this->decompress($str_dec);
                    $res2 = CJSON::decode($res);
    
                    if (!empty($res2)) {
                        $json_res['response'] = $res2;
                    } else {
                        $json_res['response'] = "";
                    }
    
                    
                }

                $json_res['request_vars'] = $myvars;
                
                $response = CJSON::encode($json_res);
                // die;

            }


        } else {
            return CJSON::encode(array(
                'metaData'=>array(
                    'code'=>$err,
                    'message'=>'[CURL] '.$err_msg,
                ),
                'request_vars'=>$myvars,
            ));
        }

        // var_dump($response); die;

        return $response;
    }

    function identity_magic() {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
    }

    function help() {
        $url = $this->url . '/help';
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($session);
        return $response;
    }

    function search_riwayat($noka, $kode) {
        
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $query = '{
                "param" : "'. $noka.'",
                "kodedokter" : '.$kode.'
            }';

            $completeUrl = $this->server_new['search_riwayat'];
            return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
        
    }           

    // function decrypt
    private function stringDecrypt($key, $string){
            
      
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));
  
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
  
        return $output;
    }

    // function lzstring decompress 
    // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
    private function decompress($string){
  
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

    }

}
