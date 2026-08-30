<?php

// require_once __DIR__ . '/../../vendor/autoload.php';

class AntrianOnlineBpjs {

    var $mode = 1;
    var $uid = ""; //ex: 2603
    var $secret = ""; //ex: 1rs2hs3
    var $faskes_key = "";
    var $url = "";
    var $server_new = array();


    function setInit() {
        $config = KonfigsystemK::model()->find();
        if (empty($config)) {
            return false;
        }

        $this->url = $config->antreanonline_url;
        $this->faskes_key = $config->antreanonline_kodefaskes;

        $this->setServer();

        return true;
    }

    function __construct() {

        if (!empty(Yii::app()->user)) {
            $this->url = Yii::app()->user->getState('antreanonline_url');
            $this->faskes_key = Yii::app()->user->getState('antreanonline_kodefaskes');
        } else {
            $this->setInit();
        }

        $this->setServer();
    }


    private function setServer() {
        $this->server_new = array(
            'tambah_antrian' => $this->url . '/tambahantrian/'.$this->faskes_key,
            'updatewaktu' => $this->url . '/updatewaktu/'.$this->faskes_key,
            'dashboard_harian' => $this->url . '/getdashboardpertanggal/'.$this->faskes_key,
            'dashboard_bulanan' => $this->url . '/getdashboardperbulan/'.$this->faskes_key,
            'list_riwayat' => $this->url . '/getlisttask/'.$this->faskes_key,
            'batal_antrian' => $this->url . '/batalantrian/'.$this->faskes_key,
            'ref_jadwaldokter' => $this->url . '/refjadwaldokter/'.$this->faskes_key,
            'antreanPerKodeBooking' => $this->url . '/antreanPerKodeBooking/' . $this->faskes_key,
            'tambahAntreanFarmasi' => $this->url . '/tambahAntreanFarmasi/' . $this->faskes_key,
            'ref_poli' => $this->url . '/refpoli/' . $this->faskes_key,
        );
    }

    function output($content) {
        echo $content;
    }

    private function HashBPJS($args = '') {
        $uid = $this->uid;
        date_default_timezone_set('UTC');
        $timestmp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $str = $uid . "&" . $timestmp;
        $secret = $this->secret;
        $hasher = base64_encode(hash_hmac('sha256', utf8_encode($str), utf8_encode($secret), TRUE)); //signature;

        return array($uid, $timestmp, $hasher);
    }

    private function request($api,$url, $method = '', $myvars = '') {
        $start_time = microtime(true);
        $session = curl_init($url);
        $arrheader = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $jsonBody = $myvars;
           
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session,CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($session,CURLOPT_SSL_VERIFYPEER, 0);

        switch ($method) {
            case 'POST':
                curl_setopt($session, CURLOPT_POST, true);
                curl_setopt($session, CURLOPT_POSTFIELDS, $jsonBody);
                break;
            case 'PUT':
                curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($session, CURLOPT_POSTFIELDS, $jsonBody);
                break;
            case 'DELETE':
                curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($session, CURLOPT_POSTFIELDS, $jsonBody);
                break;
        }

        curl_setopt($session, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        $err = curl_errno($session);
        $err_msg = curl_error($session);
        curl_close($session);

        
        $json_res = CJSON::decode($response);
        
        $code = 0;
        $msg = "";
        $rsp_back = array();
        if(!empty($json_res) && !empty($json_res['metadata'])){
            $code = $json_res['metadata']['code'];
            $msg = $json_res['metadata']['message'];
            $rsp_back = (!empty($json_res['response'])?$json_res['response']:array());
        }
        
        //get Response Time
        $end_time = microtime(true);
        $response_time = ($end_time - $start_time) * 1000;

        $config = KonfigsystemK::model()->find();
        if ($config->dashboardbpjs_aktif == true) {
            $modAPiBpjs = ApibpjsK::model()->findByAttributes(array('api' => $api));
            if (!empty($modAPiBpjs)) {
                ApibpjsK::model()->updateByPk($modAPiBpjs->apibpjs_id, array('resposnse_time' => $response_time));
            } else {
                $modAPiBpjs = new ApibpjsK();
                $modAPiBpjs->api = $api;
                $modAPiBpjs->keterangan = 'antrol';
                $modAPiBpjs->resposnse_time = $response_time;
                $modAPiBpjs->save(false);
            }
        }
        
        return CJSON::encode(array(
            'metaData'=>array(
                'code'=>$code,
                'message'=>$msg
            ),
            'request_vars'=>$myvars,
            'response'=>$rsp_back,
        ));

        return $response;
    }

    function tambah_antrian($query) {
        $query_json = json_encode($query, JSON_UNESCAPED_SLASHES);

        $completeUrl = $this->server_new['tambah_antrian'];
        return $this->request($this->server_new['tambah_antrian'],$completeUrl, 'POST', $query_json);
    }

    function tambahAntreanFarmasi($query)
    {
        $query_json = json_encode($query, JSON_UNESCAPED_SLASHES);
        $completeUrl = $this->server_new['tambahAntreanFarmasi'];
        return $this->request($this->server_new['tambahAntreanFarmasi'],$completeUrl, 'POST', $query_json);
    }

    function update_waktu($query) {
        $query_json     = json_encode($query, JSON_UNESCAPED_SLASHES);
        $completeUrl = $this->server_new['updatewaktu'];
        return $this->request($this->server_new['updatewaktu'],$completeUrl, 'POST', $query_json);
    }

    function dashboard_harian($query) {

        $completeUrl = $this->server_new['dashboard_harian'].'/'.$query;
        return $this->request($this->server_new['dashboard_harian'],$completeUrl, 'GET');
    }

    function dashboard_bulanan($query) {

        $completeUrl = $this->server_new['dashboard_bulanan'].'/'.$query;
        return $this->request($this->server_new['dashboard_bulanan'],$completeUrl, 'GET', $query);
    }

    function list_riwayat($query) {
        $query_json     = json_encode($query, JSON_UNESCAPED_SLASHES);
        $completeUrl = $this->server_new['list_riwayat'];
        return $this->request($this->server_new['list_riwayat'],$completeUrl, 'POST', $query_json);
    }

    function batal_antrian($query) {
        $query_json     = json_encode($query, JSON_UNESCAPED_SLASHES);
        $completeUrl = $this->server_new['batal_antrian'];
        return $this->request($this->server_new['batal_antrian'],$completeUrl, 'POST', $query_json);
    }

    function ref_jadwaldokter($query) {
        $completeUrl = $this->server_new['ref_jadwaldokter'].'/'.$query;
        return $this->request($this->server_new['ref_jadwaldokter'],$completeUrl, 'GET');
    }

    function ref_poli()
    {
        $completeUrl = $this->server_new['ref_poli'];
        return $this->request($this->server_new['ref_poli'],$completeUrl, 'GET');
    }

    function antreanPerKodeBooking($query)
    {
        $completeUrl = $this->server_new['antreanPerKodeBooking'] . '/' . $query;
        return $this->request($this->server_new['antreanPerKodeBooking'],$completeUrl, 'GET');
    }
    
}

?>
