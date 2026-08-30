<?php

require_once __DIR__ . '/../../vendor/autoload.php';

class BpjsVklaim {

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
    var $servicename_bpjs = "";
    var $servicename_bpjs_ehealty = "";



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

            $this->uid = Yii::app()->user->getState('bpjs_uid');
            $this->secret = Yii::app()->user->getState('bpjs_secret');
            $this->url = Yii::app()->user->getState('bpjs_host');
            $this->urlAplicare = Yii::app()->user->getState('bpjs_aplicare_host');
            $this->port = Yii::app()->user->getState('bpjs_port');
            $this->servicename_bpjs = Yii::app()->user->getState('servicename_bpjs');
            $this->bpjs_server_lokal = Yii::app()->user->getState('is_bpjs_server_local');
            $this->user_key = Yii::app()->user->getState('bpjs_userkey');
            $this->bpjs_v2 = Yii::app()->user->getState('bpjs_v2');
            $this->is_encrypt = Yii::app()->user->getState('bpjs_terenkripsi');
            $this->kode_faskes = Yii::app()->user->getState('antreanonline_kodefaskes');
            $this->url_hend =  Yii::app()->user->getState('antreanonline_url');
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
            $serviceName = (!empty($this->servicename_bpjs)? "/" . $this->servicename_bpjs:(!empty($this->servicename_bpjs_ehealty)? "/" . $this->servicename_bpjs_ehealty:""));
            $urlport = $this->url_hend; //versi 1.1 url terbaru
            $this->server_new = array(
                'search_poli' => $urlport . '/vklaim/poli/'.$this->kode_faskes,//done
                'fasilitas_kesehatan' => $urlport . '/vklaim/faskes/'.$this->kode_faskes,//done
                'search_diagnosa' => $urlport . '/vklaim/diagnosa/'.$this->kode_faskes,// tanya
                'search_procedure' => $urlport . '/vklaim/procedure/'.$this->kode_faskes,//done
                'search_kelas_rawat' => $urlport . '/vklaim/kelasrawat/'.$this->kode_faskes,// tidak ada form pencarian
                'search_dokter' => $urlport . '/vklaim/refdokter/'.$this->kode_faskes,//done
                'search_dpjp' => $urlport . '/vklaim/dokter/'.$this->kode_faskes,
                'search_spesialistik' => $urlport . '/vklaim/spesialistik/'.$this->kode_faskes,// tidak ada form cari
                'search_ruangrawat' => $urlport . '/vklaim/ruangrawat/'.$this->kode_faskes,// tida from cari
                'search_carakeluar' => $urlport . '/vklaim/carakeluar/'.$this->kode_faskes,//
                'search_pascapulang' => $urlport . '/vklaim/pascapulang/'.$this->kode_faskes,// tdk ad cari
                'search_propinsi' => $urlport . '/vklaim/propinsi/'.$this->kode_faskes,//
                'search_kabupaten' => $urlport . '/vklaim/kabupaten/'.$this->kode_faskes,//done
                'search_kecamatan' => $urlport . '/vklaim/kecamatan/'.$this->kode_faskes,// doe tapi tidak ad data
                'search_kartu' => $urlport . '/vklaim/search_nokartu/'.$this->kode_faskes,// ada tanggal harus ditannyakembali? hasil nya null
                'search_nik' => $urlport . '/vklaim/search_nik/'.$this->kode_faskes,//ada tanggal harus ditannyakembali?
                'search_sep' => $urlport . '/vklaim/sep/'.$this->kode_faskes,
                'search_rujukan_no_rujukan_pcare' => $urlport . '/vklaim/search_rujukan_no_rujukan_pcare/'.$this->kode_faskes,
                'search_rujukan_no_rujukan_rs' => $urlport . '/vklaim/search_rujukan_no_rujukan_rs/'.$this->kode_faskes,
                'search_rujukan_no_bpjs_pcare' => $urlport . '/vklaim/search_rujukan_no_bpjs_pcare/'.$this->kode_faskes,
                'search_rujukan_no_bpjs_rs' => $urlport . '/vklaim/search_rujukan_no_bpjs_rs/'.$this->kode_faskes,
                'search_rujukan_multi_pcare' => $urlport . '/vklaim/search_rujukan_multi_pcare/'.$this->kode_faskes,
                'search_rujukan_multi_rs' => $urlport . '/vklaim/search_rujukan_multi_rs/'.$this->kode_faskes,
                'search_suplesi_jasa_raharja' => $urlport . '/vklaim/suplesi_jasa_raharja/'.$this->kode_faskes,// ada tanggal harus ditannyakembali
                'create_sep' => $urlport . '/vklaim/insert_sep/'.$this->kode_faskes,
                'create_sep_2' => $urlport . '/vklaim/insert_sep_2_0/'.$this->kode_faskes,
                'update_sep' => $urlport . '/vklaim/update_sep/'.$this->kode_faskes,
                'update_sep_2' => $urlport . '/vklaim/update_sep_2_0/'.$this->kode_faskes,
                'update_sep_pulang' => $urlport . '/vklaim/update_tanggal_pulang/'.$this->kode_faskes,
                'update_sep_pulang_2' => $urlport . '/vklaim/update_tanggal_pulang_2_0/'.$this->kode_faskes,
                'delete_transaksi_sep' => $urlport . '/vklaim/hapus_sep/'.$this->kode_faskes,
                'delete_transaksi_sep_2' => $urlport . '/vklaim/delete_sep_2_0/'.$this->kode_faskes,
                'create_rujukan' => $urlport . '/vklaim/insert_rujukan/'.$this->kode_faskes,
                'update_rujukan' => $urlport . '/vklaim/update_rujukan/'.$this->kode_faskes,
                'delete_rujukan' => $urlport . '/vklaim/delete_rujukan/'.$this->kode_faskes,
                'pengajuan_approval' => $urlport . '/vklaim/pengajuan/'.$this->kode_faskes,
                'approval_sep' => $urlport . '/vklaim/aproval_pengajuan_sep/'.$this->kode_faskes,
                'monitoring_kunjungan' => $urlport . '/vklaim/data_kunjungan/'.$this->kode_faskes,//ada tanggal harus ditannyakembali //null
                'monitoring_klaim' => $urlport . '/vklaim/data_klaim/'.$this->kode_faskes,//ada tanggal harus ditannyakembali null
                'search_no_surat_kontrol' => $urlport . '/vklaim/search_rencanakontrol/'.$this->kode_faskes,
                'search_spesialtik_kontrol' => $urlport . '/vklaim/data_nomor_surat_kontrol_berdasarkan_no_kartu/'.$this->kode_faskes,// harus ditanya kembali
                'search_jadwal_praktek_dokter' => $urlport . '/vklaim/data_dokter/'.$this->kode_faskes, // tanya
                'create_rencana_kontrol' => $urlport . '/vklaim/insert_rencana_kontrol/'.$this->kode_faskes,
                'update_rencana_kontrol' => $urlport . '/vklaim/update_rencana_kontrol/'.$this->kode_faskes,
                'hapus_rencana_kontrol' => $urlport . '/vklaim/hapus_rencana_kontrol/'.$this->kode_faskes,
                'list_rencana_kontrol' => $urlport . '/RencanaKontrol/ListRencanaKontrol',
                'create_spri' => $urlport . '/vklaim/data_nomor_surat_kontrol/'.$this->kode_faskes, // harus ditanya
                'update_spri' => $urlport . '/vklaim/insert_spri/'.$this->kode_faskes,
                'monitoring_histori_pelayanan' => $urlport . '/vklaim/data_histori_pelayanan_peserta/'.$this->kode_faskes,
                'tabel_obat_prb' => $urlport . '/vklaim/obatprb/'.$this->kode_faskes, //tanya
                'list_diagnosa_prb' => $urlport . '/vklaim/diagnosaprb/' . $this->kode_faskes,
                'insert_prb' => $urlport . '/PRB/insert',
                'update_prb' => $urlport . '/PRB/Update',
                'delete_prb' => $urlport . '/PRB/Delete',
                'search_rujukan_spesialistik' => $urlport . '/vklaim/list_spesialistik_rujukan/'.$this->kode_faskes,//tanya
                /* Load service Aplicare*/
                'aplicaresws_referensiKamar' => $this->urlAplicare . '/vklaim/refkamar/'.$this->kode_faskes,
                'aplicaresws_tambahKamar' => $this->urlAplicare . '/vklaim/create_bed/'.$this->kode_faskes,
                'aplicaresws_updateKamar' => $this->urlAplicare . '/vklaim/update_bed/'.$this->kode_faskes,
                'aplicaresws_hapusKamar' => $this->urlAplicare . '/vklaim/delete_bed/'.$this->kode_faskes,
            );
        }else{
            $portBpjs = (!empty($this->port)? ':'.$this->port:"");
            $serviceName = (!empty($this->servicename_bpjs)? "/" . $this->servicename_bpjs:(!empty($this->servicename_bpjs_ehealty)? "/" . $this->servicename_bpjs_ehealty:""));
            $urlport = $this->url .$portBpjs . $serviceName; //versi 1.1 url terbaru

            $this->server_new = array(
                'search_poli' => $urlport . '/referensi/poli',
                'fasilitas_kesehatan' => $urlport . '/referensi/faskes',
                'search_diagnosa' => $urlport . '/referensi/diagnosa',
                'search_procedure' => $urlport . '/referensi/procedure',
                'search_kelas_rawat' => $urlport . '/referensi/kelasrawat',
                'search_dokter' => $urlport . '/referensi/dokter',
                'search_dpjp' => $urlport . '/referensi/dokter/pelayanan',
                'search_spesialistik' => $urlport . '/referensi/spesialistik',
                'search_ruangrawat' => $urlport . '/referensi/ruangrawat',
                'search_carakeluar' => $urlport . '/referensi/carakeluar',
                'search_pascapulang' => $urlport . '/referensi/pascapulang',
                'search_propinsi' => $urlport . '/referensi/propinsi',
                'search_kabupaten' => $urlport . '/referensi/kabupaten/propinsi',
                'search_kecamatan' => $urlport . '/referensi/kecamatan/kabupaten',
                'search_kartu' => $urlport . '/Peserta/nokartu',
                'search_nik' => $urlport . '/Peserta/nik',
                'search_sep' => $urlport . '/SEP',
                'search_rujukan_no_rujukan_pcare' => $urlport . '/Rujukan',
                'search_rujukan_no_rujukan_rs' => $urlport . '/Rujukan/RS',
                'search_rujukan_no_bpjs_pcare' => $urlport . '/Rujukan/Peserta',
                'search_rujukan_no_bpjs_rs' => $urlport . '/Rujukan/RS/Peserta',
                'search_rujukan_multi_pcare' => $urlport . '/Rujukan/List/Peserta',
                'search_rujukan_multi_rs_list' => $urlport . '/Rujukan/RS/List/Peserta',
                'search_suplesi_jasa_raharja' => $urlport . '/sep/JasaRaharja/Suplesi',
                'create_sep' => $urlport . '/SEP/1.1/insert',
                'create_sep_2' => $urlport . '/SEP/2.0/insert',
                'update_sep' => $urlport . '/SEP/1.1/Update',
                'update_sep_2' => $urlport . '/SEP/2.0/update',
                'update_sep_pulang' => $urlport . '/SEP/updtglplg',
                'update_sep_pulang_2' => $urlport . '/SEP/2.0/updtglplg',
                'delete_transaksi_sep' => $urlport . '/SEP/Delete',
                'delete_transaksi_sep_2' => $urlport . '/SEP/2.0/delete',
                'create_rujukan' => $urlport . '/Rujukan/insert',
                'create_rujukan_new' => $urlport . '/Rujukan/2.0/insert',
                'update_rujukan' => $urlport . '/Rujukan/update',
                'delete_rujukan' => $urlport . '/Rujukan/delete',
                'pengajuan_approval' => $urlport . '/Sep/pengajuanSEP',
                'approval_sep' => $urlport . '/Sep/aprovalSEP',
                'monitoring_kunjungan' => $urlport . '/Monitoring/Kunjungan',
                'monitoring_klaim' => $urlport . '/Monitoring/Klaim',
                'search_no_surat_kontrol' => $urlport . '/RencanaKontrol/noSuratKontrol',
                'search_spesialtik_kontrol' => $urlport . '/RencanaKontrol/ListSpesialistik',
                'search_jadwal_praktek_dokter' => $urlport . '/RencanaKontrol/JadwalPraktekDokter',
                'create_rencana_kontrol' => $urlport . '/RencanaKontrol/insert',
                'update_rencana_kontrol' => $urlport . '/RencanaKontrol/Update',
                'hapus_rencana_kontrol' => $urlport . '/RencanaKontrol/Delete',
                'list_rencana_kontrol' => $urlport . '/RencanaKontrol/ListRencanaKontrol',
                'create_spri' => $urlport . '/RencanaKontrol/InsertSPRI',
                'update_spri' => $urlport . '/RencanaKontrol/UpdateSPRI',
                'monitoring_histori_pelayanan' => $urlport . '/monitoring/HistoriPelayanan',
                'tabel_obat_prb' => $urlport . '/referensi/obatprb/',    
                'search_rujukan_spesialistik' => $urlport . '/Rujukan/ListSpesialistik',
                /* Load service Aplicare*/
                'aplicaresws_referensiKamar' => $this->urlAplicare . '/aplicaresws/rest/ref/kelas',
                'aplicaresws_tambahKamar' => $this->urlAplicare . '/aplicaresws/rest/bed/create/',
                'aplicaresws_updateKamar' => $this->urlAplicare . '/aplicaresws/rest/bed/update/',
                'aplicaresws_hapusKamar' => $this->urlAplicare . '/aplicaresws/rest/bed/delete/',
                'update_rujukan_2' => $urlport . '/Rujukan/2.0/Update',
                'search_rujukan_khusus' => $urlport . '/Rujukan/Khusus/List',
                'list_diagnosa_prb' => $urlport . '/referensi/diagnosaprb',
                'insert_prb' => $urlport . '/PRB/insert',
                'update_prb' => $urlport . '/PRB/Update',
                'delete_prb' => $urlport . '/PRB/Delete',
                'jmlsep_rujukan' => $urlport . '/Rujukan/JumlahSEP',
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

    private function request($api,$url, $hashsignature, $uid, $timestmp, $method = '', $myvars = '', $contentType = 'Application/x-www-form-urlencoded') {
        $start_time = microtime(true);
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
        
        //tambahan untuk set timeout
        $config = KonfigsystemK::model()->find();
        $timeout = isset($config->apitransactiontimeout)  ? $config->apitransactiontimeout : 15;
        $connecttimeout = isset($config->apiconnectiontimeout)  ? $config->apiconnectiontimeout : 5;

        // Set the maximum time to wait for a response to 10 seconds
        curl_setopt($session, CURLOPT_TIMEOUT, $timeout);

        // Set the maximum time to wait for a connection to be established to 5 seconds
        curl_setopt($session, CURLOPT_CONNECTTIMEOUT, $connecttimeout); 


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
        curl_close($session);

        // var_dump($url, $myvars, $response, $err); die;
        // echo $response; die;
        //get Response Time
        $end_time = microtime(true);
        $response_time = ($end_time - $start_time) * 1000;

        if ($config->dashboardbpjs_aktif == true){
            $modAPiBpjs = ApibpjsK::model()->findByAttributes(array('api' => $api));
            if (!empty($modAPiBpjs)) {
                ApibpjsK::model()->updateByPk($modAPiBpjs->apibpjs_id, array('resposnse_time' => $response_time));
            } else {
                $modAPiBpjs = new ApibpjsK();
                $modAPiBpjs->api = $api;
                $modAPiBpjs->keterangan = 'vclaim';
                $modAPiBpjs->resposnse_time = $response_time;
                $modAPiBpjs->save(false);
            }
        }

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

    function search_kartu($query, $tgl = null) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();

            if (empty($tgl)) {
                $tgl = date('Y-m-d');
            }

            $completeUrl = $this->server_new['search_kartu'] . '/' . $query . '/' . $tgl;
            return $this->request($this->server_new['search_kartu'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();

            if (empty($tgl)) {
                $tgl = date('Y-m-d');
            }
            $completeUrl = $this->server_new['search_kartu'] . '/' . $query . '/tglSEP/' . $tgl;
            return $this->request($this->server_new['search_kartu'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }
    
    function list_rencana_kontrol3($tglawal, $tglakhir, $filter)
    {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2) {
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/" . $tglawal . "/" . $tglakhir . "/" . $filter;
            // var_dump($query, $completeUrl);

            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        } else {
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/tglAwal/" . $tglawal . "/tglAkhir/" . $tglakhir . "/filter/" . $filter;
            // var_dump($query, $completeUrl);

            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function search_sep($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_sep'] . '/' . $query;
        return $this->request($this->server_new['search_sep'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_nik($query) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_nik'] . '/' . $query . '/' . date('Y-m-d');
            return $this->request($this->server_new['search_nik'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_nik'] . '/' . $query . '/tglSEP/' . date('Y-m-d');
            return $this->request($this->server_new['search_nik'], $completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function search_rujukan_no_rujukan($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_no_rujukan_pcare'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_no_rujukan_pcare'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_rujukan_no_rujukan_rs($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_no_rujukan_rs'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_no_rujukan_pcare'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_rujukan_no_bpjs($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_no_bpjs_pcare'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_no_rujukan_pcare'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_rujukan_rs_no_rujukan($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_no_rujukan_rs'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_no_rujukan_rs'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_rujukan_rs_no_bpjs($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_no_bpjs_rs'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_no_bpjs_rs'], $completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_rujukan_pcare_multi($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_multi_pcare'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_multi_pcare'],$completeUrl, $hashsignature, $uid, $timestmp);
    }


    function search_rujukan_multi_rs_list($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_multi_rs_list'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_multi_rs_list'], $completeUrl, $hashsignature, $uid, $timestmp);
    }


    function search_rujukan_rs_multi($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_multi_rs_list'] . "/" . $query;
        return $this->request($this->server_new['search_rujukan_multi_rs_list'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_suplesi($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_suplesi_jasa_raharja'] . "/" . $query;
        return $this->request($this->server_new['search_suplesi_jasa_raharja'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_monitoring_kunjungan($query1, $query2) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_kunjungan'] . '/' . $query1 . '/' . $query2;
            return $this->request($this->server_new['monitoring_kunjungan'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_kunjungan'] . '/Tanggal/' . $query1 . '/JnsPelayanan/' . $query2;
            return $this->request($this->server_new['monitoring_kunjungan'],$completeUrl, $hashsignature, $uid, $timestmp);
        }    
    }

    //insert prb
    function insert_prb($arr)
    {

        $arr = array_replace([
            'noSep' => '',
            'noKartu' => '',
            'alamat' => '',
            'email' => '',
            'programPRB' => '',
            'kodeDPJP' => '',
            'keterangan' => '',
            'saran' => '',
            'user' => '',
            'detailobat' => '
                { 
                    "kdObat":"",
                    "signa1":"",
                    "signa2":"",
                    "jmlObat":""
                }
            '
        ], $arr);

        $query = '{
              "request":
               {
              "t_prb":
                {  
                  "noSep":"' . $arr['noSep'] . '",
                  "noKartu":"' . $arr['noKartu'] . '",
                  "alamat":"' . $arr['alamat'] . '",
                  "email":"' . $arr['email'] . '",
                  "programPRB":"' . $arr['programPRB'] . '",
                  "kodeDPJP":"' . $arr['kodeDPJP'] . '",
                  "keterangan":"' . $arr['keterangan'] . '",
                  "saran":"' . $arr['saran'] . '",
                  "user":"' . $arr['user'] . '",
                  "obat":
                    [
                        ' . $arr['detailobat'] . '
                    ]      
                }
               }
            }        
        ';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['insert_prb'];

        return $this->request($this->server_new['insert_prb'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }


    /**
     * 
     * @param type $arr
     * @return type
     */
    function update_prb($arr)
    {

        $arr = array_replace([
            'noSrb' => '',
            'noSep' => '',
            'alamat' => '',
            'email' => '',
            'kodeDPJP' => '',
            'keterangan' => '',
            'saran' => '',
            'user' => '',
            'detailobat' => '
                { 
                    "kdObat":"",
                    "signa1":"",
                    "signa2":"",
                    "jmlObat":""
                }
            '
        ], $arr);

        $query = '{
              "request":
               {
              "t_prb":
                {  
                  "noSrb":"' . $arr['noSrb'] . '",
                  "noSep":"' . $arr['noSep'] . '",
                  "alamat":"' . $arr['alamat'] . '",
                  "email":"' . $arr['email'] . '",
                  "kodeDPJP":"' . $arr['kodeDPJP'] . '",
                  "keterangan":"' . $arr['keterangan'] . '",
                  "saran":"' . $arr['saran'] . '",
                  "user":"' . $arr['user'] . '",
                  "obat":
                    [
                        ' . $arr['detailobat'] . '
                    ]      
                }
               }
            }        
        ';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_prb'];

        // var_dump($query); die;

        return $this->request($this->server_new['update_prb'], $completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }

    /**
     * 
     * @param type $arr
     * @return type
     */
    function delete_prb($noSrb, $noSep, $user)
    {

        $query = '{
              "request":
               {
              "t_prb":
                {  
                  "noSrb":"' . $noSrb . '",
                  "noSep":"' . $noSep . '",
                  "user":"' . $user . '"     
                }
               }
            }        
        ';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['delete_prb'];

        // var_dump($query); die;

        return $this->request($this->server_new['delete_prb'],$completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
    }

    function search_monitoring_klaim($query1, $query2, $query3) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_klaim'] . '/' . $query1 . '/' . $query2 . '/' . $query3;
            return $this->request($this->server_new['monitoring_klaim'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_klaim'] . '/Tanggal/' . $query1 . '/JnsPelayanan/' . $query2 . '/Status/' . $query3;
            return $this->request($this->server_new['monitoring_klaim'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function search_monitoring_historipelayanan($query1, $query2, $query3) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_histori_pelayanan'] . '/' . $query1 . '/' . $query2 . '/' . $query3;
            return $this->request($this->server_new['monitoring_histori_pelayanan'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_histori_pelayanan'] . '/NoKartu/' . $query1 . '/tglMulai/' . $query2 . '/tglAkhir/' . $query3;
            return $this->request($this->server_new['monitoring_histori_pelayanan'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function search_monitoring_jasaraharja($query1, $query2) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_jasa_raharja'] . '/' . $query1 . '/' . $query2;
            return $this->request($this->server_new['monitoring_jasa_raharja'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_jasa_raharja'] . '/tglMulai/' . $query1 . '/tglAkhir/' . $query2;
            return $this->request($this->server_new['monitoring_jasa_raharja'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function create_sep_new($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak, $modSep = null) {
        
        if ($this->bpjs_v2) {
            return $this->create_sep_new2($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak, $modSep);
        }

        $query = '{
            "request":
             {
            "t_sep":
                {
                    "noKartu":"' . $nokartu . '",
                    "tglSep":"' . $tglsep . '",
                    "ppkPelayanan":"' . $ppkpelayanan . '",
                    "jnsPelayanan":"' . $jnspelayanan . '",
                    "klsRawat":"' . $klsrawat . '",
                    "noMR":"' . $nomr . '",
                    "rujukan": {
                        "asalRujukan":"' . $asalrujukan . '",
                        "tglRujukan":"' . $tglrujukan . '",
                        "noRujukan":"' . $norujukan . '",
                        "ppkRujukan":"' . $ppkrujukan . '"
                    },
                    "catatan":"' . $catatan . '",
                    "diagAwal":"' . $diagawal . '",
                    "poli": {
                        "tujuan":"' . $politujuan . '",
                        "eksekutif":"' . $eksekutif . '"
                    },
                    "cob": {
                        "cob":"' . $cob . '"
                    },
                    "katarak": {
                        "katarak": "'.$katarak.'"
                    },
                    "jaminan": {
                        "lakaLantas": "' . $lakalantas . '",
                        "penjamin": {
                            "penjamin": "' . $penjamin . '",
                            "tglKejadian": "' . $tglKejadian . '",
                            "keterangan": "' . $keterangan . '",
                            "suplesi": {
                                "suplesi": "' . $suplesi . '",
                                "noSepSuplesi": "' . $noSepSuplesi . '",
                                "lokasiLaka": {
                                    "kdPropinsi": "' . $kdPropinsi . '",
                                    "kdKabupaten": "' . $kdKabupaten . '",
                                    "kdKecamatan": "' . $kdKecamatan . '"
                                    }
                            }
                        }
                    },
                    "skdp": {
                       "noSurat": "' . $noSurat . '",
                       "kodeDPJP": "' . $kodeDPJP . '"
                    },
                    "noTelp":"' . $notlp . '",
                    "user":"' . $user . '"
                }
            }
        }';


        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['create_sep_new'];
        $completeUrl = $this->server_new['create_sep'];

        return $this->request($this->server_new['create_sep'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    function create_sep_new2($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak, $modSep = null) {
        $tujuanKunj = "";
        $kdPenunjang = "";
        $flagProcedure = "";
        $assesmentPel = "";
        $cob = empty($cob) ? 0 : $cob;
        $dpjpLayan = "";
        $pembiayaan = "";
        $penanggungJawab = "";
        $klsRawatNaik = "";

        // var_dump($modSep->attributes); die;

        // var_dump($_POST); die;
        if (!empty($modSep)) {
            $tujuanKunj = (empty($modSep->jenis_kunjungan) ? "0" :$modSep->jenis_kunjungan);
            $flagProcedure = $modSep->flag_procedure;
            $kdPenunjang = $modSep->kode_penunjang;
            $assesmentPel = !empty($modSep->asesmen_pelayanan)?$modSep->asesmen_pelayanan:"";
            $dpjpLayan = $modSep->dpjpygmelayani_kode;
            $klsRawatNaik = $modSep->klsRawatNaik;
            $pembiayaan = !empty($modSep->penanggungjwb_naikkls_id) ?$modSep->penanggungjwb_naikkls_id :"";
            $penanggungJawab = !empty($modSep->penanggungjwb_naikkls_nama) ?$modSep->penanggungjwb_naikkls_nama:"";
            
        }

        if (isset($_POST['PPPasienAdmisiT']['is_titipan']) && $_POST['PPPasienAdmisiT']['is_titipan'] == 1){
            $klsRawatNaik = "";
            $pembiayaan = "";
            $penanggungJawab = "";
        }

        if (isset($_POST['PPPasienAdmisiT']['ruangan_id']) && !empty($_POST['PPPasienAdmisiT']['ruangan_id'])){
            $modRuangan = RuanganM::model()->findByPk($_POST['PPPasienAdmisiT']['ruangan_id']);
            if ($modRuangan->is_nonkelas == true){
                $klsRawatNaik = "";
                $pembiayaan = "";
                $penanggungJawab = "";
            }
        }

        if ($politujuan == "IGD") {
            $norujukan = "";
        }

        if($jnspelayanan == 1){
            $dpjpLayan = "";
        }

        $nolakalantas = "";
        // "klsRawat":"' . $klsrawat . '",
        $query = '{
            "request":
             {
            "t_sep":
                {
                    "noKartu":"' . $nokartu . '",
                    "tglSep":"' . $tglsep . '",
                    "ppkPelayanan":"' . $ppkpelayanan . '",
                    "jnsPelayanan":"' . $jnspelayanan . '",
                    "klsRawat":{
                        "klsRawatHak":"' . $klsrawat . '",
                        "klsRawatNaik":"'. $klsRawatNaik .'",
                        "pembiayaan":"'. $pembiayaan .'",
                        "penanggungJawab":"'. $penanggungJawab .'"
                    },
                    "noMR":"' . $nomr . '",
                    "rujukan": {
                        "asalRujukan":"' . $asalrujukan . '",
                        "tglRujukan":"' . $tglrujukan . '",
                        "noRujukan":"' . $norujukan . '",
                        "ppkRujukan":"' . $ppkrujukan . '"
                    },
                    "catatan":"' . $catatan . '",
                    "diagAwal":"' . $diagawal . '",
                    "poli": {
                        "tujuan":"' . $politujuan . '",
                        "eksekutif":"' . $eksekutif . '"
                    },
                    "cob": {
                        "cob":"' . $cob . '"
                    },
                    "katarak": {
                        "katarak": "'.$katarak.'"
                    },
                    "jaminan": {
                        "lakaLantas": "' . $lakalantas . '",
                        "noLP": "'.$nolakalantas.'",
                        "penjamin": {
                            "tglKejadian": "' . $tglKejadian . '",
                            "keterangan": "' . $keterangan . '",
                            "suplesi": {
                                "suplesi": "' . $suplesi . '",
                                "noSepSuplesi": "' . $noSepSuplesi . '",
                                "lokasiLaka": {
                                    "kdPropinsi": "' . $kdPropinsi . '",
                                    "kdKabupaten": "' . $kdKabupaten . '",
                                    "kdKecamatan": "' . $kdKecamatan . '"
                                    }
                            }
                        }
                    },
                    "tujuanKunj":"'.$tujuanKunj.'",
                    "flagProcedure":"'.$flagProcedure.'",
                    "kdPenunjang":"'.$kdPenunjang.'",
                    "assesmentPel":"'.$assesmentPel.'",
                    "skdp": {
                       "noSurat": "' . $noSurat . '",
                       "kodeDPJP": "' . $kodeDPJP . '"
                    },
                    "dpjpLayan": "'.$dpjpLayan.'",
                    "noTelp":"' . $notlp . '",
                    "user":"' . $user . '"
                }
            }
        }';
        // "penjamin": "' . $penjamin . '",
        // echo "<pre>";
        // var_dump($query); die;
        
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['create_sep_new'];
        $completeUrl = $this->server_new['create_sep_2'];

        return $this->request($this->server_new['create_sep_2'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    function update_sep_new_2($noSep, $klsrawat, $nomr,  $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $notlp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $kodeDPJP, $katarak,$klsRawatNaik ,$model=null)
    {
        $pembiayaan = !empty($model->penanggungjwb_naikkls_id) ? $model->penanggungjwb_naikkls_id : "";
        $penanggungJawab = !empty($model->penanggungjwb_naikkls_nama) ? $model->penanggungjwb_naikkls_nama : "";
        $query = '
        {
     "request": {
        "t_sep": {
                "noSep": "'.$noSep.'",
                "klsRawat":{
                                "klsRawatHak":"'.$klsrawat. '",
                                "klsRawatNaik":"'.$klsRawatNaik. '",
                                "pembiayaan":"'.$pembiayaan. '",
                                "penanggungJawab":"'.$penanggungJawab. '"
                              },
                "noMR": "' . $nomr . '",
                "catatan": "' . $catatan . '",
                "diagAwal": "' . $diagawal . '",
                "poli": {
                        "tujuan": "' . $politujuan . '",
                        "eksekutif": "' . $eksekutif . '"
                },
                "cob": {
                        "cob": "' . $cob . '"
                },
                "katarak": {
                        "katarak": "' . $katarak . '"
                },
                "jaminan": {
                        "lakaLantas": "' . $lakalantas . '",
                        "penjamin": {
                                "tglKejadian": "' . $tglKejadian . '",
                                "keterangan": "' . $keterangan . '",
                                "suplesi": {
                                        "suplesi": "' . $suplesi . '",
                                        "noSepSuplesi": "' . $noSepSuplesi . '",
                                        "lokasiLaka": {
                                                "kdPropinsi": "'. $kdPropinsi. '",
                                                "kdKabupaten": "' . $kdKabupaten . '",
                                                "kdKecamatan": "' . $kdKecamatan . '"
                                        }
                                }
                        }
                },
                "dpjpLayan":"' . $kodeDPJP . '",
                "noTelp": "' . $notlp . '",
                "user": "' . $user . '"
        }
      }
    }   ';


        
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_sep_2'];
        return $this->request($this->server_new['update_sep_2'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }

    
    function update_sep_new($noSep, $nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak) {
    $query11 = '{
        {
            "request": {
               "t_sep": {
                       "noSep": "'. $noSep .'",
                       "klsRawat":{
                                       "klsRawatHak":"' . $klsrawat . '",
                                       "klsRawatNaik":"",
                                       "pembiayaan":"",
                                       "penanggungJawab":""
                                     },
                       "noMR": "'.$nomr.'",
                       "catatan": "'.$catatan.'",
                       "diagAwal": "'.$diagawal.'",
                       "poli": {
                               "tujuan": "'.$politujuan.'",
                               "eksekutif": "'.$eksekutif.'"
                       },
                       "cob": {
                               "cob": "'.$cob.'"
                       },
                       "katarak": {
                               "katarak": "'.$katarak.'"
                       },
                       "jaminan": {
                               "lakaLantas":"'.$lakalantas.' ",
                               "penjamin": {
                                       "tglKejadian": "'.$tglKejadian.'",
                                       "keterangan": "'.$keterangan.'",
                                       "suplesi": {
                                               "suplesi": "'.$suplesi.'",
                                               "noSepSuplesi": "'.$noSepSuplesi.'",
                                               "lokasiLaka": {
                                                "kdPropinsi": "' . $kdPropinsi . '",
                                                "kdKabupaten": "' . $kdKabupaten . '",
                                                "kdKecamatan": "' . $kdKecamatan . '"
                                            }
                                       }
                               } 
                       },
                       "dpjpLayan":"' . $kodeDPJP . '",
                       "noTelp":"' . $notlp . '",
                        "user":"' . $user . '"
               }
             }
           }        
    }';
        $query = '{
            "request":
             {
            "t_sep":
                {
                    "noSep":"' . $noSep . '",
                    "klsRawat":"' . $klsrawat . '",
                    "noMR":"' . $nomr . '",
                    "rujukan": {
                        "asalRujukan":"' . $asalrujukan . '",
                        "tglRujukan":"' . $tglrujukan . '",
                        "noRujukan":"' . $norujukan . '",
                        "ppkRujukan":"' . $ppkrujukan . '"
                    },
                    "catatan":"' . $catatan . '",
                    "diagAwal":"' . $diagawal . '",
                    "poli": {
                        "eksekutif":"' . $eksekutif . '"
                    },
                    "cob": {
                        "cob":"' . $cob . '"
                    },
                    "katarak": {
                        "katarak": "'.$katarak.'"
                    },
                    "jaminan": {
                        "lakaLantas": "' . $lakalantas . '",
                        "penjamin": {
                            "penjamin": "' . $penjamin . '",
                            "tglKejadian": "' . $tglKejadian . '",
                            "keterangan": "' . $keterangan . '",
                            "suplesi": {
                                "suplesi": "' . $suplesi . '",
                                "noSepSuplesi": "' . $noSepSuplesi . '",
                                "lokasiLaka": {
                                    "kdPropinsi": "' . $kdPropinsi . '",
                                    "kdKabupaten": "' . $kdKabupaten . '",
                                    "kdKecamatan": "' . $kdKecamatan . '"
                                }
                            }
                        }
                    },
                    "skdp": {
                       "noSurat": "' . $noSurat . '",
                       "kodeDPJP": "' . $kodeDPJP . '"
                    },
                    "noTelp":"' . $notlp . '",
                    "user":"' . $user . '"
                }
            }
        }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
//        $completeUrl = $this->server_new['update_sep_new'];
        $completeUrl = $this->server_new['update_sep_2'];
        // var_dump($completeUrl);die;
        return $this->request($this->server_new['update_sep_2'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query11);
    }

    function update_sep_pulang($noSep, $tglPulang, $user) {
        $query = '{
                        "request":
                         {
                        "t_sep":
                            {
                                "noSep":"' . $noSep . '",
                                "tglPulang":"' . $tglPulang . '",
                                "user":"' . $user . '",
                            }
                        }
                    }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_sep_pulang'];

        return $this->request($this->server_new['update_sep_pulang'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }


    function update_sep_pulang_2($noSep, $tglPulang, $statusPulang, $tglMeninggal, $noSuratMeninggal, $user, $noLPManual = '') {
        $query = '{
                        "request":
                        {
                        "t_sep":
                        {
                            "noSep":"' . $noSep . '",
                            "statusPulang":"' . $statusPulang . '",
                            "noSuratMeninggal":"' . $noSuratMeninggal . '",
                            "tglMeninggal":"' . $tglMeninggal . '",
                            "tglPulang":"' . $tglPulang . '",
                            "noLPManual":"' . $noLPManual . '",
                            "user":"' . $user . '",
                        }
                    }
                }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_sep_pulang_2'];

        // var_dump($query); die;   

        return $this->request($this->server_new['update_sep_pulang_2'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }

    function insert_rujukan_bpjs($noSep, $tglRujukan, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user) {
        $query = '{
                        "request":
                         {
                            "t_rujukan": {
                                "noSep": "' . $noSep . '",
                                "tglRujukan": "' . $tglRujukan . '",
                                "ppkDirujuk": "' . $ppkDirujuk . '",
                                "jnsPelayanan": "' . $jnsPelayanan . '",
                                "catatan": "' . $catatan . '",
                                "diagRujukan": "' . $diagRujukan . '",
                                "tipeRujukan": "' . $tipeRujukan . '",
                                "poliRujukan": "' . $poliRujukan . '",
                                "user": "' . $user . '"
                             }
                        }
                    }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['create_rujukan'];

        return $this->request($this->server_new['create_rujukan'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    function insert_rujukan_bpjs_new($noSep, $tglRujukan, $tglRencanaKunjungan, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user)
    {
        $query = '{
                    "request": {
                                    "t_rujukan": {
                                            "noSep": "' . $noSep . '",
                                            "tglRujukan": "' . $tglRujukan . '",
                                            "tglRencanaKunjungan":"' . $tglRencanaKunjungan . '",
                                            "ppkDirujuk": "' . $ppkDirujuk . '",
                                            "jnsPelayanan": "' . $jnsPelayanan . '",
                                            "catatan": "' . $catatan . '",
                                            "diagRujukan": "' . $diagRujukan . '",
                                            "tipeRujukan": "' . $tipeRujukan . '",
                                            "poliRujukan": "' . $poliRujukan . '",
                                            "user": "' . $user . '"
                                    }
                    }
                }           ';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['create_rujukan_new'];

        return $this->request($this->server_new['create_rujukan_new'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }


    function update_rujukan_bpjs($noRujukan, $noSep, $tglRujukan, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user) {
        $query = '{
                        "request":
                         {
                            "t_rujukan": {
                                "noRujukan": "' . $noRujukan . '",
                                "ppkDirujuk": "' . $ppkDirujuk . '",
                                "tipe": "' . $tipeRujukan . '",
                                "jnsPelayanan": "' . $jnsPelayanan . '",
                                "catatan": "' . $catatan . '",
                                "diagRujukan": "' . $diagRujukan . '",
                                "tipeRujukan": "' . $tipeRujukan . '",
                                "poliRujukan": "' . $poliRujukan . '",
                                "user": "' . $user . '"
                             }
                        }
                    }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_rujukan'];

        return $this->request($this->server_new['update_rujukan'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }

    function update_rujukan_bpjs_2($noRujukan, $tglRujukan, $tglRencanaKunjungan, $ppkDirujuk, $jnsPelayanan, $catatan, $diagRujukan, $tipeRujukan, $poliRujukan, $user)
    {
        $query = '{
                    "request": {
                            "t_rujukan": {
                                        "noRujukan": "' . $noRujukan . '",
                                        "tglRujukan": "' . $tglRujukan . '",
                                        "tglRencanaKunjungan":"' . $tglRencanaKunjungan . '",
                                        "ppkDirujuk": "' . $ppkDirujuk . '",
                                        "jnsPelayanan": "' . $jnsPelayanan . '",
                                        "catatan": "' . $catatan . '",
                                        "diagRujukan": "' . $diagRujukan . '",
                                        "tipeRujukan": "' . $tipeRujukan . '",
                                        "poliRujukan": "' . $poliRujukan . '",
                                        "user": "' . $user . '"
                            }
                    }
                }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_rujukan_2'];

        return $this->request($this->server_new['update_rujukan_2'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }

    function delete_rujukan($noRujukan, $nama) {
        $query = '{
                            "request":
                             {
                            "t_rujukan":
                                {
                                    "noRujukan":"' . $noRujukan . '",
                                    "user":"' . $nama . '",
                                }
                            }
                        }';
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['delete_rujukan'];
        return $this->request($this->server_new['delete_rujukan'],$completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
    }

    function pengajuan_approval($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user) {
        $query = '{
                        "request":
                         {
                        "t_sep":
                            {
                                "noKartu":"' . $nokartu . '",
                                "tglSep":"' . $tglsep . '", 
                                "ppkPelayanan":"' . $ppkpelayanan . '",
                                "jnsPelayanan":"' . $jnspelayanan . '",
                                "keterangan":"' . $catatan . '",
                                "user":"' . $user . '",
                            }
                        }
                    }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['pengajuan_approval'];

        return $this->request($this->server_new['pengajuan_approval'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    function pengajuan_approval2($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $catatan, $user) {
        $query = '{
                        "request":
                         {
                        "t_sep":
                            {
                                "noKartu":"' . $nokartu . '",
                                "tglSep":"' . $tglsep . '", 
                                "jnsPelayanan":"' . $ppkpelayanan . '",
                                "jnsPengajuan":"' . $jnspelayanan . '",
                                "keterangan":"' . $catatan . '",
                                "user":"' . $user . '"
                            }
                        }
                    }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['pengajuan_approval'];

        return $this->request($this->server_new['pengajuan_approval'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    function approval_sep($noKartu, $tglSep, $jnsPelayanan, $catatan, $user) {
        $query = '{
                        "request":
                         {
                        "t_sep":
                            {
                                "noKartu":"' . $noKartu . '",
                                "tglSep":"' . $tglSep . '",
                                "jnsPelayanan":"' . $jnsPelayanan . '",
                                "keterangan":"' . $catatan . '",
                                "user":"' . $user . '"
                            }
                        }
                    }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['approval_sep'];

        return $this->request($this->server_new['approval_sep'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    function approval_sep_2($noKartu, $tglSep, $jnsPelayanan, $jnsPengajuan, $catatan, $user) {
        $query = '{
            "request":
             {
            "t_sep":
                {
                    "noKartu":"' . $noKartu . '",
                    "tglSep":"' . $tglSep . '",
                    "jnsPelayanan":"' . $jnsPelayanan . '",
                    "jnsPengajuan":"' . $jnsPengajuan . '",
                    "keterangan":"' . $catatan . '",
                    "user":"' . $user . '",
                }
            }
        }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['approval_sep'];

        return $this->request($this->server_new['approval_sep'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    //tambahan
    function approvalnew_sep($nokartu,$tglsep,$jnspelayanan,$jnsPengajuan,$catatan,$user) {
        $query = '{
            "request":
             {
            "t_sep":
                {
                    "noKartu":"' . $nokartu . '",
                    "tglSep":"' . $tglsep . '",
                    "jnsPelayanan":"' . $jnspelayanan . '",
                    "jnsPengajuan":"' . $jnsPengajuan . '",
                    "keterangan":"' . $catatan . '",
                    "user":"' . $user . '",
                }
            }
        }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['approval_sep'];

        return $this->request($this->server_new['approval_sep'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    //clone rswb
    public function search_rujukan_khusus($bulan, $tahun)
    {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_rujukan_khusus'] . '/Bulan/' . $bulan . '/Tahun/' . $tahun;
        return $this->request($this->server_new['search_rujukan_khusus'],$completeUrl, $hashsignature, $uid, $timestmp);
    }
    
    function delete_transaksi_sep($nosep, $nama) {
        $query = '{
                            "request":
                             {
                            "t_sep":
                                {
                                    "noSep":"' . $nosep . '",
                                    "user":"' . $nama . '",
                                }
                            }
                        }';
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['delete_transaksi_sep'];
        return $this->request($this->server_new['delete_transaksi_sep'],$completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
    }

    function delete_transaksi_sep2($nosep, $nama) {
        $query = '{
                            "request":
                             {
                            "t_sep":
                                {
                                    "noSep":"' . $nosep . '",
                                    "user":"' . $nama . '",
                                }
                            }
                        }';
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['delete_transaksi_sep_2'];
        return $this->request($this->server_new['delete_transaksi_sep_2'],$completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
    }

    function search_poli($query) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_poli'] . '/' . $query;
            return $this->request($this->server_new['search_poli'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_poli'] . '/' . $query;
            return $this->request($this->server_new['search_poli'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function fasilitas_kesehatan($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['fasilitas_kesehatan'] . '/' . $query;
        return $this->request($this->server_new['fasilitas_kesehatan'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_diagnosa($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_diagnosa'] . '/' . $query;
        return $this->request($this->server_new['search_diagnosa'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_procedure($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_procedure'] . '/' . $query;
        return $this->request($this->server_new['search_procedure'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_kelas_rawat($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_kelas_rawat'];
        return $this->request($this->server_new['search_kelas_rawat'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_dokter($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_dokter'] . '/' . $query;
        return $this->request($this->server_new['search_dokter'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_dpjp($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_dpjp'] . '/' . $query;
        return $this->request($this->server_new['search_dpjp'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_spesialistik($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_spesialistik'];
        return $this->request($this->server_new['search_spesialistik'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_ruangrawat($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_ruangrawat'];
        return $this->request($this->server_new['search_ruangrawat'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_carakeluar($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_carakeluar'];
        return $this->request($this->server_new['search_carakeluar'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_pascapulang($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_pascapulang'];
        return $this->request($this->server_new['search_pascapulang'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_propinsi($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_propinsi'];
        return $this->request($this->server_new['search_propinsi'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_kabupaten($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_kabupaten'] . '/' . $query;
        return $this->request($this->server_new['search_kabupaten'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_kecamatan($query, $start, $limit) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_kecamatan'] . '/' . $query;
        return $this->request($this->server_new['search_kecamatan'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

    function search_no_surat_kontrol($query) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['search_no_surat_kontrol'] . '/' . $query;
        return $this->request($this->server_new['search_no_surat_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
    }
    function search_spesialtik_kontrol($jenis_kontrol, $nomor, $tanggal) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_spesialtik_kontrol'] . "/".$jenis_kontrol."/".$nomor."/".$tanggal;
            // var_dump($completeUrl); die;
            return $this->request($this->server_new['search_spesialtik_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_spesialtik_kontrol'] . "/JnsKontrol/".$jenis_kontrol."/nomor/".$nomor."/TglRencanaKontrol/".$tanggal;
            // var_dump($completeUrl); die;
            return $this->request($this->server_new['search_spesialtik_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
        /*
        return '
        {
            "metaData": {
                "code": "200",
                "message": "Sukses"
            },
            "response": {
                "list": [
                    {
                        "kodePoli": "ANA",
                        "namaPoli": "Klinik Anak",
                        "kapasitas": "30",
                        "jmlRencanaKontroldanRujukan": "0",
                        "persentase": "0.00"
                    },
                    {
                        "kodePoli": "005",
                        "namaPoli": "Gastroenterologi-Hepatologi ",
                        "kapasitas": "12",
                        "jmlRencanaKontroldanRujukan": "0",
                        "persentase": "0.00"
                    },
                    {
                        "kodePoli": "008",
                        "namaPoli": "Hematologi - Onkologi Medik ",
                        "kapasitas": "24",
                        "jmlRencanaKontroldanRujukan": "0",
                        "persentase": "0.00"
                    },
                    {
                        "kodePoli": "013",
                        "namaPoli": "Reumatologi ",
                        "kapasitas": "24",
                        "jmlRencanaKontroldanRujukan": "0",
                        "persentase": "0.00"
                    },
                    {
                        "kodePoli": "015",
                        "namaPoli": "Kardiovaskular ",
                        "kapasitas": "24",
                        "jmlRencanaKontroldanRujukan": "0",
                        "persentase": "0.00"
                    },
                    {
                        "kodePoli": "023",
                        "namaPoli": "obstetri ginekologi sosial",
                        "kapasitas": "12",
                        "jmlRencanaKontroldanRujukan": "0",
                        "persentase": "0.00"
                    }
                ]
            }
        }
        ';
        // */
    }

    function search_jadwal_dokter_kontrol($jenis_kontrol, $poli, $tanggal) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_jadwal_praktek_dokter'] . "/".$jenis_kontrol."/".$poli."/".$tanggal;
            // var_dump($completeUrl);
            return $this->request($this->server_new['search_jadwal_praktek_dokter'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_jadwal_praktek_dokter'] . "/JnsKontrol/".$jenis_kontrol."/KdPoli/".$poli."/TglRencanaKontrol/".$tanggal;
            // var_dump($completeUrl);
            return $this->request($this->server_new['search_jadwal_praktek_dokter'],$completeUrl, $hashsignature, $uid, $timestmp);
        }

        /*
        return '
        {
            "metaData": {
                "code": "200",
                "message": "Sukses"
            },
            "response": {
                "list": [
                    {
                        "kodeDokter": "31528",
                        "namaDokter": "Dr.John Wick",
                        "jadwalPraktek": "16:00 - 18:00",
                        "kapasitas": "12"
                    },
                    {
                        "kodeDokter": "31348",
                        "namaDokter": "Dr. Luffy",
                        "jadwalPraktek": "10:00 - 12:00",
                        "kapasitas": "12"
                    }
                ]
            }
        }
        ';
        // */
    }


    function create_rencana_kontrol($no_sep, $kode_dokter, $poli_kontrol, $tgl_rencana, $user) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['create_rencana_kontrol'];
        $query = '{
            "request":
            {
                    "noSEP":"' . $no_sep . '",
                    "kodeDokter":"' . $kode_dokter . '",
                    "poliKontrol":"' . $poli_kontrol . '",
                    "tglRencanaKontrol":"' . $tgl_rencana . '",
                    "user":"' . $user . '"
            }
        }';

        // var_dump($query); die;

        return $this->request($this->server_new['create_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
         /*
        return '
        {
            "metaData": {
                "code": "200",
                "message": "Ok"
            },
            "response": {
                "noSuratKontrol": "0301R0110520K000013",
                "tglRencanaKontrol": "2020-05-15",
                "namaDokter": "Dr. John Wick",
                "noKartu": "0001328186441",
                "nama": "ARIS",
                "kelamin": "Laki-laki",
                "tglLahir": "1947-12-31"
            }
        }
        ';
        // */
    }

    function update_rencana_kontrol($no_surat_kontrol, $no_sep, $kode_dokter, $poli_kontrol, $tgl_rencana, $user) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_rencana_kontrol'];
        // var_dump($completeUrl);
        $query = '{
            "request":
            {
                    "noSuratKontrol":"' . $no_surat_kontrol . '",
                    "noSEP":"' . $no_sep . '",
                    "kodeDokter":"' . $kode_dokter . '",
                    "poliKontrol":"' . $poli_kontrol . '",
                    "tglRencanaKontrol":"' . $tgl_rencana . '",
                    "user":"' . $user . '"
            }
        }';
        // var_dump($query); die;


        return $this->request($this->server_new['update_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
        /*
        return '
        {
            "metaData": {
                "code": "200",
                "message": "Ok"
            },
            "response": {
                "noSuratKontrol": "0301R0110520K000013",
                "tglRencanaKontrol": "2020-05-15",
                "namaDokter": "Dr. John Wick",
                "noKartu": "0001328186441",
                "nama": "ARIS",
                "kelamin": "Laki-laki",
                "tglLahir": "1947-12-31"
            }
        }
        ';
        // */
    }

    function hapus_rencana_kontrol($no_surat_kontrol, $user) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['hapus_rencana_kontrol'];
        $query = '{
            "request":
            {
                "t_suratkontrol": {
                    "noSuratKontrol":"' . $no_surat_kontrol . '",
                    "user":"' . $user . '"
                }
            }
        }';
        // var_dump($query, $completeUrl);

        return $this->request($this->server_new['hapus_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp, 'DELETE', $query);
    }

    function list_rencana_kontrol($format, $tgl_awal = null, $tgl_akhir = null) {

        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            if (empty($tgl_awal)) {
                $tgl_awal = date('Y-m-d');
            }

            if (empty($tgl_akhir)) {
                $tgl_akhir = $tgl_awal;
            }

            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/".$tgl_awal."/".$tgl_akhir."/".$format;
            // var_dump($query, $completeUrl);

            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            if (empty($tgl_awal)) {
                $tgl_awal = date('Y-m-d');
            }

            if (empty($tgl_akhir)) {
                $tgl_akhir = $tgl_awal;
            }

            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/tglAwal/".$tgl_awal."/tglAkhir/".$tgl_akhir."/filter/".$format;
            // var_dump($query, $completeUrl);

            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function list_rencana_kontrol_kartu($format, $bulan, $tahun, $nokartu) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/".$bulan."/".$tahun."/".$nokartu."/".$format;
            // var_dump($query, $completeUrl);
            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/Bulan/".$bulan."/Tahun/".$tahun."/NoKartu/".$nokartu."/filter/".$format;
            // var_dump($query, $completeUrl);
            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
    }

    function list_rencana_kontrol2($bulan, $tahun, $nokartu, $filter) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/".$bulan."/".$tahun."/".$nokartu."/".$filter;
            // var_dump($query, $completeUrl);

            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['list_rencana_kontrol'] . "/Bulan/".$bulan."/Tahun/".$tahun."/Nokartu/".$nokartu."/filter/".$filter;
            // var_dump($query, $completeUrl);

            return $this->request($this->server_new['list_rencana_kontrol'],$completeUrl, $hashsignature, $uid, $timestmp); 
        }
    }

    function create_spri($no_kartu, $kode_dokter, $poli_kontrol, $tgl_rencana, $user) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['create_spri'];
        $query = '{
            "request":
            {
                    "noKartu":"' . $no_kartu . '",
                    "kodeDokter":"' . $kode_dokter . '",
                    "poliKontrol":"' . $poli_kontrol . '",
                    "tglRencanaKontrol":"' . $tgl_rencana . '",
                    "user":"' . $user . '"
            }
        }';

        // var_dump($query); die;

        return $this->request($this->server_new['create_spri'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    function update_spri($no_spri, $kode_dokter, $poli_kontrol, $tgl_rencana, $user) {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['update_spri'];
        $query = '{
            "request":
            {
                    "noSPRI":"' . $no_spri . '",
                    "kodeDokter":"' . $kode_dokter . '",
                    "poliKontrol":"' . $poli_kontrol . '",
                    "tglRencanaKontrol":"' . $tgl_rencana . '",
                    "user":"' . $user . '"
            }
        }';

        // var_dump($query); die;

        return $this->request($this->server_new['update_spri'],$completeUrl, $hashsignature, $uid, $timestmp, 'PUT', $query);
    }

    function monitoring_histori_pelayanan($no_kartu, $tgl_awal = null, $tgl_akhir = null) {
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            if (empty($tgl_awal)) {
                $tgl_awal = date('Y-m-d');
            }

            if (empty($tgl_akhir)) {
                $tgl_akhir = $tgl_awal;
            }

            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_histori_pelayanan'] . "/".$no_kartu."/".$tgl_awal."/".$tgl_akhir;
            // var_dump($completeUrl);
            return $this->request($this->server_new['monitoring_histori_pelayanan'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            if (empty($tgl_awal)) {
                $tgl_awal = date('Y-m-d');
            }

            if (empty($tgl_akhir)) {
                $tgl_akhir = $tgl_awal;
            }

            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['monitoring_histori_pelayanan'] . "/NoKartu/".$no_kartu."/tglMulai/".$tgl_awal."/tglAkhir/".$tgl_akhir;
            // var_dump($completeUrl);
            return $this->request($this->server_new['monitoring_histori_pelayanan'],$completeUrl, $hashsignature, $uid, $timestmp);  
        }
    }

    /**
     * @author Tantowi J <tantowijaya@.com>
     * Menampilkan daftar kelas ruangan
     */
    function aplicaresws_referensiKamar() {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['aplicaresws_referensiKamar'];
        return $this->request($this->server_new['aplicaresws_referensiKamar'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

     /**
     * @author Tantowi J <tantowijaya@.com>
     * Membuat ketersediaan kamar applicare
     */
    function aplicaresws_tambahKamar($kodeppk, $kodekelas, $koderuang, $namaruang, $kapasitas, $tersedia, $tersediapria, $tersediawanita, $tersediapriawanita) {

        $query = '{
            "kodekelas":"'.$kodekelas.'",
            "koderuang":"'.$koderuang.'",
            "namaruang":"'.$namaruang.'",
            "kapasitas":"'.$kapasitas.'",
            "tersedia":"'.$tersedia.'",
            "tersediapria":"'.$tersediapria.'",
            "tersediawanita":"'.$tersediawanita.'",
            "tersediapriawanita":"'.$tersediapriawanita.'"
        }';


        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['aplicaresws_tambahKamar'].$kodeppk;
        // var_dump($query, $completeUrl, $uid, $timestmp, $hashsignature); die;

        return $this->request($this->server_new['aplicaresws_tambahKamar'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query, "application/json");
    }

     /**
     * @author Tantowi J <tantowijaya@.com>
     * Update ketersediaan kamar applicare
     */
    function aplicaresws_updateKamar($kodeppk, $kodekelas, $koderuang, $namaruang, $kapasitas, $tersedia, $tersediapria, $tersediawanita, $tersediapriawanita) {

        $query = '{
            "kodekelas":"'.$kodekelas.'",
            "koderuang":"'.$koderuang.'",
            "namaruang":"'.$namaruang.'",
            "kapasitas":"'.$kapasitas.'",
            "tersedia":"'.$tersedia.'",
            "tersediapria":"'.$tersediapria.'",
            "tersediawanita":"'.$tersediawanita.'",
            "tersediapriawanita":"'.$tersediapriawanita.'"
        }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['aplicaresws_updateKamar'].$kodeppk;

        return $this->request($this->server_new['aplicaresws_updateKamar'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query, "application/json");
    }

     /**
     * @author Tantowi J <denihamdani@piindonesia.co.id>
     * Hapus ketersediaan kamar applicare
     */
    function aplicaresws_hapusKamar($kodeppk, $kodekelas, $koderuang) {

        $query = '{
            "kodekelas":"'.$kodekelas.'",
            "koderuang":"'.$koderuang.'"
        }';

        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['aplicaresws_hapusKamar'].$kodeppk;

        return $this->request($this->server_new['aplicaresws_hapusKamar'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query, "application/json");
    }

    function detail_ppk_rujukan($query, $start, $limit){
			list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
			$completeUrl = $this->url.'/provider/ref/provider/query?nama='.$query.'&start='.$start.'&limit='.$limit;
			return $this->request($this->url.'/provider/ref/provider/query?nama=',$completeUrl, $hashsignature, $uid, $timestmp);
		}
                
    /**
     * $arr['obatprb'] obat prb     
     * @param type $arr
     * @return type
     */
    public function tabel_obat_prb($arr){
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['tabel_obat_prb']. '/' . $arr['obatprb'];
        return $this->request($this->server_new['tabel_obat_prb'],$completeUrl, $hashsignature, $uid, $timestmp);
    } 
    
    function list_diagnosa_prb() {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['list_diagnosa_prb'] ;
        return $this->request($this->server_new['list_diagnosa_prb'], $completeUrl, $hashsignature, $uid, $timestmp);
    }

    public function search_rujukan_spesialistik($kodeppk, $tglrujukan){
        $config = KonfigsystemK::model()->find();
        if ($config->tipe_bridging == 2){
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_rujukan_spesialistik']. '/' . $kodeppk.'/'.$tglrujukan;
            return $this->request($this->server_new['search_rujukan_spesialistik'],$completeUrl, $hashsignature, $uid, $timestmp);
        }else{
            list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
            $completeUrl = $this->server_new['search_rujukan_spesialistik']. '/PPKRujukan/' . $kodeppk.'/TglRujukan/'.$tglrujukan;
            return $this->request($this->server_new['search_rujukan_spesialistik'],$completeUrl, $hashsignature, $uid, $timestmp);
        }
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

    /**
     * fungsi yang di copy dari aplikasi e-asuransi create sep versi 2
     * @param type $nokartu
     * @param type $tglsep
     * @param type $ppkpelayanan
     * @param type $jnspelayanan
     * @param type $klsrawat
     * @param type $nomr
     * @param type $asalrujukan
     * @param type $tglrujukan
     * @param string $norujukan
     * @param type $ppkrujukan
     * @param type $catatan
     * @param type $diagawal
     * @param string $politujuan
     * @param type $eksekutif
     * @param type $cob
     * @param type $lakalantas
     * @param type $penjamin
     * @param type $lokasilakalantas
     * @param type $notlp
     * @param type $user
     * @param type $tglKejadian
     * @param type $keterangan
     * @param type $suplesi
     * @param string $noSepSuplesi
     * @param type $kdPropinsi
     * @param type $kdKabupaten
     * @param type $kdKecamatan
     * @param type $noSurat
     * @param type $kodeDPJP
     * @param type $katarak
     * @param type $modSep
     * @return type
     */
    function create_sep_versi2($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalrujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasilakalantas, $notlp, $user, $tglKejadian,$keterangan,$suplesi,$noSepSuplesi,$kdPropinsi,$kdKabupaten,$kdKecamatan,$noSurat,$kodeDPJP,$katarak, $modSep = null) {
        $tujuanKunj = "";
        $kdPenunjang = "";
        $flagProcedure = "";
        $assesmentPel = "";
        $cob = empty($cob) ? 0 : $cob;
        $dpjpLayan = "";
        $pembiayaan = "";
        $penanggungJawab = "";
        $klsRawatNaik = "";
        $nolakalantas = "";

        // var_dump($modSep->attributes); die;

        // var_dump($_POST); die;
        
        if (!empty($modSep)) {
            $tujuanKunj = $modSep->jenis_kunjungan;
            $flagProcedure = $modSep->flag_procedure;
            $kdPenunjang = $modSep->kode_penunjang;
            $assesmentPel = $modSep->asesmen_pelayanan;
            $dpjpLayan = $modSep->dpjpygmelayani_kode;
            $klsRawatNaik = $modSep->klsRawatNaik;
            $modPenjamin = PenjaminpasienM::model()->findByPk($modSep->penanggungjwb_naikkls_id);
            if (!empty($modPenjamin)) {
                $pembiayaan = $modPenjamin->bpjs_kodepenjamin;
                $penanggungJawab = $modPenjamin->bpjs_namapenjamin;
            }

            $keterangan = (!empty($modSep->keterangan_kejadian)? $modSep->keterangan_kejadian : "");
            $nolakalantas = (!empty($modSep->kll_nolaporan_polisi)? $modSep->kll_nolaporan_polisi : "");
        }

        if($jnspelayanan == 1){
            $politujuan = "";
        }
        

        if ($politujuan == "IGD") {
            $norujukan = "";
        }

        if($lakalantas == 3){
            $noSepSuplesi = "";
        }

        

        // "klsRawat":"' . $klsrawat . '",
        $query = '{
            "request":
             {
            "t_sep":
                {
                    "noKartu":"' . $nokartu . '",
                    "tglSep":"' . $tglsep . '",
                    "ppkPelayanan":"' . $ppkpelayanan . '",
                    "jnsPelayanan":"' . $jnspelayanan . '",
                    "klsRawat":{
                        "klsRawatHak":"' . $klsrawat . '",
                        "klsRawatNaik":"'. $klsRawatNaik .'",
                        "pembiayaan":"'. $pembiayaan .'",
                        "penanggungJawab":"'. $penanggungJawab .'"
                    },
                    "noMR":"' . $nomr . '",
                    "rujukan": {
                        "asalRujukan":"' . $asalrujukan . '",
                        "tglRujukan":"' . $tglrujukan . '",
                        "noRujukan":"' . $norujukan . '",
                        "ppkRujukan":"' . $ppkrujukan . '"
                    },
                    "catatan":"' . $catatan . '",
                    "diagAwal":"' . $diagawal . '",
                    "poli": {
                        "tujuan":"' . $politujuan . '",
                        "eksekutif":"' . $eksekutif . '"
                    },
                    "cob": {
                        "cob":"' . $cob . '"
                    },
                    "katarak": {
                        "katarak": "'.$katarak.'"
                    },
                    "jaminan": {
                        "lakaLantas": "' . $lakalantas . '",
                        "noLP": "' . $nolakalantas . '",
                        "penjamin": {
                            "tglKejadian": "' . $tglKejadian . '",
                            "keterangan": "' . $keterangan . '",
                            "suplesi": {
                                "suplesi": "' . $suplesi . '",
                                "noSepSuplesi": "' . $noSepSuplesi . '",
                                "lokasiLaka": {
                                    "kdPropinsi": "' . $kdPropinsi . '",
                                    "kdKabupaten": "' . $kdKabupaten . '",
                                    "kdKecamatan": "' . $kdKecamatan . '"
                                    }
                            }
                        }
                    },
                    "tujuanKunj":"'.$tujuanKunj.'",
                    "flagProcedure":"'.$flagProcedure.'",
                    "kdPenunjang":"'.$kdPenunjang.'",
                    "assesmentPel":"'.$assesmentPel.'",
                    "skdp": {
                       "noSurat": "' . $noSurat . '",
                       "kodeDPJP": "' . $kodeDPJP . '"
                    },
                    "dpjpLayan": "'.$dpjpLayan.'",
                    "noTelp":"' . $notlp . '",
                    "user":"' . $user . '"
                }
            }
        }';
        // "penjamin": "' . $penjamin . '",
               
        // var_dump(CJSON::decode($query)); die;
        
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['create_sep_2'];

        return $this->request($this->server_new['create_sep_2'],$completeUrl, $hashsignature, $uid, $timestmp, 'POST', $query);
    }

    // function lzstring decompress 
    // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
    private function decompress($string){
  
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

    }

    function jmlsep_rujukan($noRujukan, $jenis)
    {
        list($uid, $timestmp, $hashsignature) = $this->HashBPJS();
        $completeUrl = $this->server_new['jmlsep_rujukan'] . "/" . $jenis . "/" . $noRujukan;
        return $this->request($this->server_new['jmlsep_rujukan'],$completeUrl, $hashsignature, $uid, $timestmp);
    }

}

?>