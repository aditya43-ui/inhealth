<?php

/**
 * Proses pertukaran data SIMRS dengan Web Service Mandiri Inhealth dengan menggunakan REST (RestFull).
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.components
 * @version 2.0.1-000
 * @link http://development.inhealth.co.id/pelkesws2 URL dummy WS dengan menggunakan REST (RestFull)
 * @link http://app.inhealth.co.id/pelkesws2 URL Production WS dengan menggunakan REST (RestFull)
 */
class Inhealth {
    
    var $bridging_inhealth = false;
    var $api_inhealth = "";
    var $token_inhealth = "";
    var $provider_inhealth = "";
    
    /**
     * Inisialisasi class
     */
    function __construct() {
        $this->bridging_inhealth = Yii::app()->user->getState('bridging_inhealth');
        $this->api_inhealth = Yii::app()->user->getState('api_inhealth');
        $this->token_inhealth = Yii::app()->user->getState('token_inhealth');
        $this->provider_inhealth = Yii::app()->user->getState('provider_inhealth');
    }
    
    /**
     * Proses request response module Inhealth
     * @param array $data Ini merupakan variabel array request sesuai dengan nama module
     * @param string $nama_module Berisikan nama module inhealth seperti : EligibilitasPeserta, CetakSJP , dsb
     * @return json $result Hasil nya adalah response json dari WS sesuai dengan nama modul dan validasinya
     */
    private function request($data,$nama_module){
        $data_string = json_encode($data);
        $ch = curl_init(Yii::app()->user->getState('api_inhealth').'/api/'.$nama_module);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        
        return json_encode($result);
    }
    
    /**
     * Method ini digunakan untuk melakukan pengecekan status eligibilitas peserta. 
     * Output dari method ini adalah status peserta, masih dijaminan atau tidak.
     * 
     * @param string $noka
     * @param datetime $tanggal
     * @param string $jnsPel
     * @param string $poli
     * @return json
     */
    function EligibilitasPeserta($noka, $tanggal, $jnsPel, $poli){
        $module = "EligibilitasPeserta";
        $data = array(
            "token" => $this->token_inhealth,
            "kodeprovider" => $this->provider_inhealth,
            "nokainhealth" => $noka,
            "tglpelayanan" => $tanggal,
            "jenispelayanan" => $jnsPel,
            "poli" => $poli
        );
        
        return $this->request($data, $module);
    }
    
    /**
     * Modul ini digunakan untuk mencetak Surat Jaminan Pelayanan. 
     * Hasil yang didapat dari fungsi ini berupa file byte (encoded base64) 
     * yang bisa dikonversi menjadi file pdf atau file jpg.
     * 
     * @param string $nosjp
     * @param string $tkp
     * @param string $tipefile
     * @return json
     */
    function CetakSJP($nosjp, $tkp, $tipefile=".pdf"){
        $module = "CetakSJP";
        $data = array(
            "token" => $this->token_inhealth,
            "kodeprovider" => $this->provider_inhealth,
            "nosjp" => $nosjp,
            "tkp" => $tkp,
            "tipefile" => $tipefile
        );
        
        return $this->request($data, $module);
    }
    
    /**
     * Modul ini digunakan untuk mendapatkan data SJP yang ada di database INHEALTH.
     * 
     * @param string $nokainhealth
     * @param datetime $tanggalsjp
     * @param string $poli
     * @param string $tkp
     * @return type
     */
    function CekSjp($nokainhealth, $tanggalsjp, $poli, $tkp){
        $module = "CekSjp";
        $data = array(
            "token" => $this->token_inhealth,
            "kodeprovider" => $this->provider_inhealth,
            "nokainhealth" => $nokainhealth,
            "tanggalsjp" => $tanggalsjp,
            "poli" => $poli,
            "tkp" => $tkp
        );
        
        return $this->request($data, $module);
    }
    
    /**
     * Modul ini digunakan untuk membuat jaminan pelayanan (SJP). 
     * Output dari proses ini adalah terbentuknya sebuah nomer SJP di applikasi pelkes online.
     * 
     * @param datetime $tanggalpelayanan
     * @param string $jenispelayanan
     * @param string $nokainhealth
     * @param string $nomormedicalreport
     * @param string $nomorasalrujukan
     * @param string $kodeproviderasalrujukan
     * @param datetime $tanggalasalrujukan
     * @param string $kodediagnosautama
     * @param string $poli
     * @param string $username
     * @param string $informasitambahan
     * @param string $kodediagnosatambahan
     * @param string $kecelakaankerja
     * @param string $kelasrawat
     * @param string $kodejenpelruangrawat
     * @return json
     */
    function SimpanSJP($tanggalpelayanan, $jenispelayanan, $nokainhealth, $nomormedicalreport, $nomorasalrujukan, $kodeproviderasalrujukan, $tanggalasalrujukan, 
            $kodediagnosautama, $poli, $username, $informasitambahan, $kodediagnosatambahan, $kecelakaankerja, $kelasrawat, $kodejenpelruangrawat){
        $module = "SimpanSJP";
        $data = array(
            "token" => $this->token_inhealth,
            "kodeprovider" => $this->provider_inhealth,
            "tanggalpelayanan" => $tanggalpelayanan,
            "jenispelayanan" => $jenispelayanan,
            "nokainhealth" => $nokainhealth,
            "nomormedicalreport" => $nomormedicalreport,
            "nomorasalrujukan" => $nomorasalrujukan,
            "kodeproviderasalrujukan" => $kodeproviderasalrujukan,
            "tanggalasalrujukan" => $tanggalasalrujukan,
            "kodediagnosautama" => $kodediagnosautama,
            "poli" => $poli,
            "username" => $username,
            "informasitambahan" => $informasitambahan,
            "kodediagnosatambahan" => $kodediagnosatambahan,
            "kecelakaankerja" => $kecelakaankerja,
            "kelasrawat" => $kelasrawat,
            "kodejenpelruangrawat" => $kodejenpelruangrawat
        );
        
        return $this->request($data, $module);
    }
    
    /**
     * Modul ini digunakan untuk mendapatkan data SJP beserta seluruh detail tindakan yang ada di pada SJP yang dimaksud. 
     * Perbedaan dengan modul CekSJP adalah pada modul CekSJP return value yang didapatkan hanya detail SJP sedangkan pada modul ini, 
     * selain detail SJP juga didapatkan detail tindakan yang ada di SJP tersebut.
     * 
     * @return json
     */
    function InfoSjp(){
        $module = "InfoSjp";
        $data = array(
            "token" => $this->token_inhealth,
            "kodeprovider" => $this->provider_inhealth,
            "nosjp" => $nosjp,
        );
        
        return $this->request($data, $module);
    }
}
