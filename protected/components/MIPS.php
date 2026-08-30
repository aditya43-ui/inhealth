<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MIPS
 *
 * @author developer
 */
class MIPS {
    
    const REG_PASIEN = 1;
    const REG_BLACKLIST = 2;
    const REG_PEGAWAI = 3;
    
    
    public $ip_address = "http://192.168.100.130:8080";
    public $pass = "123456";
    
    public function __construct() {
        $konfig = KonfigsystemK::model()->find();
        
        if (!empty($konfig) && $konfig->is_mips) {
            
            $name = "";
            
            // cek IP Lokal
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            socket_connect($sock, "8.8.8.8", 53);
            socket_getsockname($sock, $name); // $name passed by reference
            
            // load IP Publik
            $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
//            var_dump($ip, $name); die;
            
            
            // load data scan
            $alat = AlatscanwajahM::model()->findByAttributes(array(
                'user_ip'=>$ip,
            )) 
            ?? AlatscanwajahM::model()->findByAttributes(array(
                'user_ip'=>$name,
            ));
            
            if (!empty($alat)) {
                $this->ip_address = $alat->alat_ip;
                $this->pass = $alat->alat_password;
            } else {
                $this->ip_address = $konfig->mips_host;
                $this->pass = $konfig->mips_password;
            }
            
//            var_dump($this->ip_address, $this->pass); die;
        }
    }
    
    public function newFindRecords($startTime, $endTime) {
        $curl = curl_init();
        
        $param = array(
            'pass'=>$this->pass,
            'startTime'=>$startTime,
            'endTime'=>$endTime,
        );
        
        $url = $this->ip_address."/newFindRecords?". http_build_query($param);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_HTTPHEADER => array(
//                ": ",
//                "Content-Type: application/x-www-form-urlencoded"
//            ),
        ));

        $response = CJSON::decode(curl_exec($curl));
        curl_close($curl);
        
        if ($response['success'] == true) {
            $response['data'] = CJSON::decode($response['data']);
        } else {
            $response['data'] = "Data yang dicari tidak ditemukan";
        }
        
        // var_dump($response); die;
        
        return $response;
    }
    
    public function getRecordImg($imgName) {
        $curl = curl_init();
        
        $param = array(
            'pass'=>$this->pass,
            'imgName'=>$imgName,
        );
        
        $url = $this->ip_address."/getRecordImg?". http_build_query($param);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_HTTPHEADER => array(
//                ": ",
//                "Content-Type: application/x-www-form-urlencoded"
//            ),
        ));

        $response = CJSON::decode(curl_exec($curl));
        curl_close($curl);
        
        if ($response['success'] == true) {
            //$response['data'] = CJSON::decode($response['data']);
        } else {
            $response['data'] = "Data tidak ditemukan";
        }
        
        // var_dump($response);
        
        return $response;
        
    }
    
    
    public function register($person) {
        
        $curl = curl_init();
        
        $param = array(
            'pass'=>$this->pass,
        );
        
        $person = CJSON::encode($person);
//        echo($person)."\n"; die;
        
        $url = $this->ip_address."/person/create?". http_build_query($param);
        
        // var_dump($url, $person);
        
        //echo($person)."\n"; die;
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'pass'=>$this->pass,
                'person'=>$person,
            )
//            CURLOPT_HTTPHEADER => array(
//                ": ",
//                "Content-Type: application/x-www-form-urlencoded"
//            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        $response = CJSON::decode($response);
        
        // var_dump($response); die;
        
//        if ($response['success'] == true) {
//            //$response['data'] = CJSON::decode($response['data']);
//        } else {
//            $response['data'] = "Data gagal didaftarkan";
//        }
        
        // var_dump($response);
        
        return $response;
    }
    
}
