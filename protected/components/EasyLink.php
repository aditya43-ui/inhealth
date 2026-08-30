<?php


/**
 * Bridging Pemanggilan via API untuk Absensi EasyLink
 *
 * @author Deni Hamdani <denihamdani@.com>
 */
class EasyLink {
    
    public $ip, $port, $sn;
    
    public $err_msg;
    
    public function __construct($perangkat_id) {
        $perangkat = PerangkateasylinkM::model()->findByPk();
        
        if (empty($perangkat)) {
            return false;
        }
        
        $this->ip = $perangkat->perangkat_ip;
        $this->port = $perangkat->perangkat_port;
        $this->sn = $perangkat->perangkat_sn;
    }
    
    public function request($service, $parameter = null) {
        $url = $this->ip.":".$this->port."/".$service;
        
        $curl = curl_init();
        
        if (!empty($parameter)) {
            $parameter = http_build_query($parameter);
        }
        
        set_time_limit(0);
        curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $parameter,
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
			),
		)
	);
        
        $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
        
        if ($err) {
            $this->err_msg = ("Error #:" . $err);
            return false;
	}else{
            return $response;
	}
    }
    
    
    public function downloadUser() {
        return $this->request("user/all/paging", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function uploadUser($pin, $nama, $pwd, $rfid, $priv, $tmp) {
        return $this->request("user/all/set", array(
            'sn'=>$this->sn,
            'nama'=>$nama,
            'pwd'=>$pwd,
            'rfid'=>$rfid,
            'priv'=>$priv,
            'tmp'=>$tmp
        ));
    }
    
    public function deleteAllUser() {
        return $this->request("user/delall", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function deleteUserByPIN($pin) {
        return $this->request("user/del", array(
            'sn'=>$this->sn,
            'pin'=>$pin,
        ));
    }
    
    public function downloadScanLog() {
        return $this->request("scanlog/all/paging", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function downloadLatestScanLog() {
        return $this->request("scanlog/new", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function deleteScanLog() {
        return $this->request("scanlog/del", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function infoPerangkat() {
        return $this->request("dev/info", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function syncDateTime() {
        return $this->request("dev/settime", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function deleteAdmin() {
        return $this->request("dev/deladmin", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function deleteLog() {
        return $this->request("log/del", array(
            'sn'=>$this->sn,
        ));
    }
    
    public function initPerangkat() {
        return $this->request("dev/init", array(
            'sn'=>$this->sn,
        ));
    }
    
    
    
    
}
