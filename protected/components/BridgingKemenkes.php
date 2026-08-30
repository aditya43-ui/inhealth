<?php

class BridgingKemenkes {

    var $mode = 1;
    var $uid = ""; //ex: 2603
    var $secret = ""; //ex: 1rs2hs3
    var $url = "";
    var $urlAplicare = "";
    var $port = "";
    var $bpjs_server_lokal = "";
    var $server = array();

    function __construct() {
        if(isset(Yii::app()->user)){
            $this->uid = Yii::app()->user->getState('kemenkes_idrs');
            $this->secret = Yii::app()->user->getState('kemenkes_password');
            $this->url = Yii::app()->user->getState('kemenkes_host');
        }else{
            $modKofig = KonfigsystemK::model()->find();
            if(isset($modKofig)){
                $this->uid = $modKofig->kemenkes_idrs;
                $this->secret = $modKofig->kemenkes_password;
                $this->url = $modKofig->kemenkes_host;
            }
        }
        
        

//        $this->urlAplicare = Yii::app()->user->getState('bpjs_aplicare_host');
//        $this->port = Yii::app()->user->getState('bpjs_port');
//        $this->servicename_bpjs = Yii::app()->user->getState('servicename_bpjs');
//        $this->bpjs_server_lokal = Yii::app()->user->getState('is_bpjs_server_local');
        
        $urlport = $this->url;
            
            $this->server_new = array(
                'status_rawat' => $urlport . '/Referensi/status_rawat',
                'status_isolasi' => $urlport . '/Referensi/status_isolasi',
                'status_keluar' => $urlport . '/Referensi/status_keluar',
                'sebab_penularan' => $urlport . '/Referensi/sebab_penularan',
                'kewarganegaraan' => $urlport . '/Referensi/kewarganegaraan',
                'gender' => $urlport . '/Referensi/gender',
                'Provinsi' => $urlport . '/Referensi/Provinsi',
                'Kabupaten' => $urlport . '/Referensi/Kabupaten',
                'Kecamatan' => $urlport . '/Referensi/Kecamatan',
                'Pasien' => $urlport . '/Pasien',
                'diagnosis' => $urlport . '/Pasien/diagnosis',
                'tempat_tidur' => $urlport . '/Referensi/tempat_tidur',
                'fasyankes' => $urlport . '/Fasyankes',
                'kebutuhan_sdm' => $urlport . '/Referensi/kebutuhan_sdm',
                'sdm' => $urlport . '/Fasyankes/sdm',
                'kebutuhan_apd' => $urlport . '/Referensi/kebutuhan_apd',
                'fasyankes_apd' => $urlport . '/Fasyankes/apd',
                
                'lapv2_pasienmasuk' => $urlport . '/LapV2/PasienMasuk',
                'lapv2_pasienkeluar' => $urlport . '/LapV2/PasienKeluar',
                
//                'fasilitas_kesehatan' => $urlport . '/referensi/faskes',
//                'search_diagnosa' => $urlport . '/referensi/diagnosa',
//                'search_procedure' => $urlport . '/referensi/procedure',
//                'search_kelas_rawat' => $urlport . '/referensi/kelasrawat',
//                'search_dokter' => $urlport . '/referensi/dokter',
//                'search_dpjp' => $urlport . '/referensi/dokter/pelayanan',
//                'search_spesialistik' => $urlport . '/referensi/spesialistik',
//                'search_ruangrawat' => $urlport . '/referensi/ruangrawat',
//                'search_carakeluar' => $urlport . '/referensi/carakeluar',
//                'search_pascapulang' => $urlport . '/referensi/pascapulang',
//                'search_propinsi' => $urlport . '/referensi/propinsi',
//                'search_kabupaten' => $urlport . '/referensi/kabupaten/propinsi',
//                'search_kecamatan' => $urlport . '/referensi/kecamatan/kabupaten',
//                'search_kartu' => $urlport . '/Peserta/nokartu',
//                'search_nik' => $urlport . '/Peserta/nik',
//                'search_sep' => $urlport . '/SEP',
//                'search_rujukan_no_rujukan_pcare' => $urlport . '/Rujukan',
//                'search_rujukan_no_rujukan_rs' => $urlport . '/Rujukan/RS',
//                'search_rujukan_no_bpjs_pcare' => $urlport . '/Rujukan/Peserta',
//                'search_rujukan_no_bpjs_rs' => $urlport . '/Rujukan/RS/Peserta',
//                'search_rujukan_multi_pcare' => $urlport . '/Rujukan/List/Peserta',
//                'search_rujukan_multi_rs' => $urlport . '/Rujukan/RS/Peserta',
//                'search_suplesi_jasa_raharja' => $urlport . '/sep/JasaRaharja/Suplesi',
//                'create_sep' => $urlport . '/SEP/1.1/insert',
//                'update_sep' => $urlport . '/SEP/1.1/Update',
//                'update_sep_pulang' => $urlport . '/SEP/updtglplg',
//                'delete_transaksi_sep' => $urlport . '/SEP/Delete',
//                'create_rujukan' => $urlport . '/Rujukan/insert',
//                'update_rujukan' => $urlport . '/Rujukan/update',
//                'delete_rujukan' => $urlport . '/Rujukan/delete',
//                'pengajuan_approval' => $urlport . '/Sep/pengajuanSEP',
//                'approval_sep' => $urlport . '/Sep/aprovalSEP',
//                'monitoring_kunjungan' => $urlport . '/Monitoring/Kunjungan',
//                'monitoring_klaim' => $urlport . '/Monitoring/Klaim',
//                'monitoring_histori_pelayanan' => $urlport . '/monitoring/HistoriPelayanan',
//                'monitoring_jasa_raharja' => $urlport . '/monitoring/JasaRaharja',
//                            /* Load service Aplicare*/
//            'aplicaresws_referensiKamar' => $this->urlAplicare . '/aplicaresws/rest/ref/kelas',
//            'aplicaresws_tambahKamar' => $this->urlAplicare . '/aplicaresws/rest/bed/create/',
//            'aplicaresws_updateKamar' => $this->urlAplicare . '/aplicaresws/rest/bed/update/',

            );
//        }
    }

    function output($content) {
        echo $content;
    }

    private function HashBPJS($args = '') {
        $uid = $this->uid;
        date_default_timezone_set('UTC');
        $timestmp = strval(time() - strtotime('1970-01-01 00:00:00'));
//        $str = $uid . "&" . $timestmp;
        $hasher = $this->secret;
//        $secret = $this->secret;
//        $hasher = base64_encode(hash_hmac('sha256', utf8_encode($str), utf8_encode($secret), TRUE)); //signature;
//			echo $uid."-".$timestmp."-".$hasher;exit;
        return array($uid, $timestmp, $hasher);
    }

    private function request($url, $hashsignature, $uid, $timestmp, $method = '', $myvars = '', $paramHeader = null) {
        $session = curl_init($url);
        $arrheader = array(
             'X-rs-id: ' . $uid,
//            'X-cons-id: ' . $uid,
            'X-Timestamp: ' . $timestmp,
            'X-pass: ' . $hashsignature,
//            'Accept: application/json',
//            'Content-Type: Application/x-www-form-urlencoded',
                        'Content-Type: text/plain',
        );
        
        if(!empty($paramHeader)){
            // example $paramHeader = x:aaa
            if(count($paramHeader) > 0){
                foreach ($paramHeader as $dataparamheader){
                    array_push($arrheader, $dataparamheader);
                }
                
            }
            
        }
//        echo '<pre>';
//        print_r($arrheader);
//        exit();
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

        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
       
        curl_close($session);
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
    
    

    function status_rawat($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['status_rawat'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function status_isolasi($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['status_isolasi'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function status_keluar($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['status_keluar'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function sebab_penularan($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['sebab_penularan'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function kewarganegaraan($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['kewarganegaraan'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function gender($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['gender'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function Provinsi($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['Provinsi'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function Kabupaten($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['Kabupaten'] . '/' . $query;
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function Kecamatan($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['Kecamatan'] . '/' . $query;
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function search_pasien($query, $paramHeader = null) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['Pasien'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'GET', $query, $paramHeader);
    }
   
    function create_pasien($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['Pasien'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }
    
     function update_pasien($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['Pasien'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }
    
    function delete_pasien($query, $paramHeader = null) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['Pasien'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE',$query, $paramHeader);
    }
    
    function search_diagnosis($query, $paramHeader) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['diagnosis'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'GET', $query,$paramHeader);
    }
    
    function create_diagnosis($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['diagnosis'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }
    
     function update_diagnosis($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['diagnosis'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }
    
    function delete_diagnosis($query, $paramHeader) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['diagnosis'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE',$query, $paramHeader);
    }
    
    function tempattindur($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['tempat_tidur'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    function search_fasyankes($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'GET', $query);
    }
    
    function create_fasyankes($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }
    
     function update_fasyankes($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }
    
    function delete_fasyankes($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE',$query);
    }
    
    function kebutuhanSdm($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['kebutuhan_sdm'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function search_sdm($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['sdm'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'GET', $query);
    }
    
    function create_sdm($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['sdm'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }
    
     function update_sdm($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['sdm'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }
    
    function delete_sdm($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['sdm'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE',$query);
    }
    
    function kebutuhan_apd($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['kebutuhan_apd'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function search_apd($query, $paramHeader=null) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes_apd'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'GET', $query, $paramHeader);
    }
    
    function create_apd($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes_apd'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }
    
     function update_apd($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes_apd'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }
    
    function delete_apd($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasyankes_apd'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE',$query);
    }
    
    function createUpdateLapv2PasienMasuk($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['lapv2_pasienmasuk'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }
    
    function getLapv2PasienMasuk($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['lapv2_pasienmasuk'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'GET', $query);
    }
    
    function deleteLapv2PasienMasuk($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['lapv2_pasienmasuk'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
    }
    
    function createUpdateLapv2PasienKeluar($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['lapv2_pasienkeluar'];
        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }
    
    function getLapv2PasienKeluar($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['lapv2_pasienkeluar'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'GET', $query);
    }
    
    function deleteLapv2PasienKeluar($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['lapv2_pasienkeluar'];

        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
    }
    
//    
//    
//    
//    
//    function search_kartu($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_kartu'] . '/' . $query . '/tglSEP/' . date('Y-m-d');
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_sep($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_sep'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_nik($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_nik'] . '/' . $query . '/tglSEP/' . date('Y-m-d');
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_rujukan_no_rujukan($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_rujukan_no_rujukan_pcare'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_rujukan_no_rujukan_rs($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_rujukan_no_rujukan_rs'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_rujukan_no_bpjs($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_rujukan_no_bpjs_pcare'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_rujukan_rs_no_rujukan($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_rujukan_no_rujukan_rs'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_rujukan_rs_no_bpjs($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_rujukan_no_bpjs_rs'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_rujukan_pcare_multi($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_rujukan_multi_pcare'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_rujukan_rs_multi($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_rujukan_multi_rs'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_suplesi($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_suplesi_jasa_raharja'] . "/" . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_monitoring_kunjungan($query1, $query2) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['monitoring_kunjungan'] . '/Tanggal/' . $query1 . '/JnsPelayanan/' . $query2;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_monitoring_klaim($query1, $query2, $query3) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['monitoring_klaim'] . '/Tanggal/' . $query1 . '/JnsPelayanan/' . $query2 . '/Status/' . $query3;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_monitoring_historipelayanan($query1, $query2, $query3) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['monitoring_histori_pelayanan'] . '/NoKartu/' . $query1 . '/tglMulai/' . $query2 . '/tglAkhir/' . $query3;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_monitoring_jasaraharja($query1, $query2) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['monitoring_jasa_raharja'] . '/tglMulai/' . $query1 . '/tglAkhir/' . $query2;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);        
//    }
//
//    function create_sep_new($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak) {
//        $query = '{
//            "request":
//             {
//            "t_sep":
//                {
//                    "noKartu":"' . $nokartu . '",
//                    "tglSep":"' . $tglsep . '",
//                    "ppkPelayanan":"' . $ppkpelayanan . '",
//                    "jnsPelayanan":"' . $jnspelayanan . '",
//                    "klsRawat":"' . $klsrawat . '",
//                    "noMR":"' . $nomr . '",
//                    "rujukan": {
//                        "asalRujukan":"' . $asalrujukan . '",
//                        "tglRujukan":"' . $tglrujukan . '",
//                        "noRujukan":"' . $norujukan . '",
//                        "ppkRujukan":"' . $ppkrujukan . '"
//                    },
//                    "catatan":"' . $catatan . '",
//                    "diagAwal":"' . $diagawal . '",
//                    "poli": {
//                        "tujuan":"' . $politujuan . '",
//                        "eksekutif":"' . $eksekutif . '"
//                    },
//                    "cob": {
//                        "cob":"' . $cob . '"
//                    },
//                    "katarak": {
//                        "katarak": "'.$katarak.'"
//                    },
//                    "jaminan": {
//                        "lakaLantas": "' . $lakalantas . '",
//                        "penjamin": {
//                            "penjamin": "' . $penjamin . '",
//                            "tglKejadian": "' . $tglKejadian . '",
//                            "keterangan": "' . $keterangan . '",
//                            "suplesi": {
//                                "suplesi": "' . $suplesi . '",
//                                "noSepSuplesi": "' . $noSepSuplesi . '",
//                                "lokasiLaka": {
//                                    "kdPropinsi": "' . $kdPropinsi . '",
//                                    "kdKabupaten": "' . $kdKabupaten . '",
//                                    "kdKecamatan": "' . $kdKecamatan . '"
//                                    }
//                            }
//                        }
//                    },
//                    "skdp": {
//                       "noSurat": "' . $noSurat . '",
//                       "kodeDPJP": "' . $kodeDPJP . '"
//                    },
//                    "noTelp":"' . $notlp . '",
//                    "user":"' . $user . '"
//                }
//            }
//        }';
//
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
////        $completeUrl = $this->server_new['create_sep_new'];
//        $completeUrl = $this->server_new['create_sep'];
//
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
//    }
//
//    function update_sep_new($noSep, $nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak) {
//        $query = '{
//            "request":
//             {
//            "t_sep":
//                {
//                    "noSep":"' . $noSep . '",
//                    "klsRawat":"' . $klsrawat . '",
//                    "noMR":"' . $nomr . '",
//                    "rujukan": {
//                        "asalRujukan":"' . $asalrujukan . '",
//                        "tglRujukan":"' . $tglrujukan . '",
//                        "noRujukan":"' . $norujukan . '",
//                        "ppkRujukan":"' . $ppkrujukan . '"
//                    },
//                    "catatan":"' . $catatan . '",
//                    "diagAwal":"' . $diagawal . '",
//                    "poli": {
//                        "eksekutif":"' . $eksekutif . '"
//                    },
//                    "cob": {
//                        "cob":"' . $cob . '"
//                    },
//                    "katarak": {
//                        "katarak": "'.$katarak.'"
//                    },
//                    "jaminan": {
//                        "lakaLantas": "' . $lakalantas . '",
//                        "penjamin": {
//                            "penjamin": "' . $penjamin . '",
//                            "tglKejadian": "' . $tglKejadian . '",
//                            "keterangan": "' . $keterangan . '",
//                            "suplesi": {
//                                "suplesi": "' . $suplesi . '",
//                                "noSepSuplesi": "' . $noSepSuplesi . '",
//                                "lokasiLaka": {
//                                    "kdPropinsi": "' . $kdPropinsi . '",
//                                    "kdKabupaten": "' . $kdKabupaten . '",
//                                    "kdKecamatan": "' . $kdKecamatan . '"
//                                }
//                            }
//                        }
//                    },
//                    "skdp": {
//                       "noSurat": "' . $noSurat . '",
//                       "kodeDPJP": "' . $kodeDPJP . '"
//                    },
//                    "noTelp":"' . $notlp . '",
//                    "user":"' . $user . '"
//                }
//            }
//        }';
//
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
////        $completeUrl = $this->server_new['update_sep_new'];
//        $completeUrl = $this->server_new['update_sep'];
//
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
//    }
//
//    function update_sep_pulang($noSep, $tglPulang, $user) {
//        $query = '{
//                        "request":
//                         {
//                        "t_sep":
//                            {
//                                "noSep":"' . $noSep . '",
//                                "tglPulang":"' . $tglPulang . '",
//                                "user":"' . $user . '",
//                            }
//                        }
//                    }';
//
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['update_sep_pulang'];
//
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
//    }
//
//    function insert_rujukan_bpjs($noSep, $tglRujukan, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user) {
//        $query = '{
//                        "request":
//                         {
//                            "t_rujukan": {
//                                "noSep": "' . $noSep . '",
//                                "tglRujukan": "' . $tglRujukan . '",
//                                "ppkDirujuk": "' . $ppkDirujuk . '",
//                                "jnsPelayanan": "' . $jnsPelayanan . '",
//                                "catatan": "' . $catatan . '",
//                                "diagRujukan": "' . $diagRujukan . '",
//                                "tipeRujukan": "' . $tipeRujukan . '",
//                                "poliRujukan": "' . $poliRujukan . '",
//                                "user": "' . $user . '"
//                             }
//                        }
//                    }';
//
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['create_rujukan'];
//
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
//    }
//
//    function update_rujukan_bpjs($noRujukan, $noSep, $tglRujukan, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user) {
//        $query = '{
//                        "request":
//                         {
//                            "t_rujukan": {
//                                "noRujukan": "' . $noRujukan . '",
//                                "ppkDirujuk": "' . $ppkDirujuk . '",
//                                "tipe": "' . $tipeRujukan . '",
//                                "jnsPelayanan": "' . $jnsPelayanan . '",
//                                "catatan": "' . $catatan . '",
//                                "diagRujukan": "' . $diagRujukan . '",
//                                "tipeRujukan": "' . $tipeRujukan . '",
//                                "poliRujukan": "' . $poliRujukan . '",
//                                "user": "' . $user . '"
//                             }
//                        }
//                    }';
//
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['update_rujukan'];
//
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
//    }
//
//    function delete_rujukan($noRujukan, $nama) {
//        $query = '{
//                            "request":
//                             {
//                            "t_rujukan":
//                                {
//                                    "noRujukan":"' . $noRujukan . '",
//                                    "user":"' . $nama . '",
//                                }
//                            }
//                        }';
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['delete_rujukan'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
//    }
//
//    function pengajuan_approval($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user) {
//        $query = '{
//                        "request":
//                         {
//                        "t_sep":
//                            {
//                                "noKartu":"' . $nokartu . '",
//                                "tglSep":"' . $tglsep . '",
//                                "ppkPelayanan":"' . $ppkpelayanan . '",
//                                "jnsPelayanan":"' . $jnspelayanan . '",
//                                "keterangan":"' . $catatan . '",
//                                "user":"' . $user . '",
//                            }
//                        }
//                    }';
//
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['pengajuan_approval'];
//
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
//    }
//
//    function approval_sep($noKartu, $tglSep, $jnsPelayanan, $catatan, $user) {
//        $query = '{
//                        "request":
//                         {
//                        "t_sep":
//                            {
//                                "noKartu":"' . $noKartu . '",
//                                "tglSep":"' . $tglSep . '",
//                                "jnsPelayanan":"' . $jnsPelayanan . '",
//                                "keterangan":"' . $catatan . '",
//                                "user":"' . $user . '",
//                            }
//                        }
//                    }';
//
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['approval_sep'];
//
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
//    }
//
//    function delete_transaksi_sep($nosep, $nama) {
//        $query = '{
//                            "request":
//                             {
//                            "t_sep":
//                                {
//                                    "noSep":"' . $nosep . '",
//                                    "user":"' . $nama . '",
//                                }
//                            }
//                        }';
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['delete_transaksi_sep'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
//    }
//
//    function search_poli($query) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_poli'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function fasilitas_kesehatan($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['fasilitas_kesehatan'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_doagnosa($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_diagnosa'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_procedure($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_procedure'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_kelas_rawat($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_kelas_rawat'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_dokter($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_dokter'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_dpjp($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_dpjp'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_spesialistik($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_spesialistik'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_ruangrawat($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_ruangrawat'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_carakeluar($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_carakeluar'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//
//    function search_pascapulang($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_pascapulang'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_propinsi($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_propinsi'];
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_kabupaten($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_kabupaten'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }
//    
//    function search_kecamatan($query, $start, $limit) {
//        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['search_kecamatan'] . '/' . $query;
//        return $this->request($completeUrl, $hashsignature, $uid, $timestmp);
//    }

}

?>