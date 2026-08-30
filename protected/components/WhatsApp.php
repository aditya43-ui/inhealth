<?php

/**
 * Fungsi kirim pesan via WhatsApp
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */
class WhatsApp {
    
    public $host = "https://whatsapp..com/sendwhatsapp-test";
    public $host_single = "https://whatsapp..com/sendwhatsapp";
    public $host_file = "https://whatsapp..com/sendwhatsapp-file";
    
    public function __construct() {
        $konfig = KonfigsystemK::model()->find();
        if (!empty($konfig->whatsapp_host)) {
            $this->host = $konfig->whatsapp_host;
            $this->host_single = $konfig->whatsapp_host_single;
            $this->host_file = $konfig->whatsapp_host_file;
        }
    }
    
    public function kirim($tujuan, $pesan) {
        
        $msg = array(
            "pasien"=>in_array("Pasien", $tujuan),
            "pegawai"=>in_array("Pegawai", $tujuan),
            "pesan"=>$pesan,
            "rumahsakit" => array(
                "rsdc" => false,
                "rslm" => true,
            )
        );
        
        
        // var_dump($this->host, CJSON::encode($msg)); 
        // die;
        
        $url = $this->host;
        
        $curl = curl_init();
        
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => CJSON::encode($msg),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));
        
//        var_dump($data); die;
//        print_r($data); die;
        
        $res_raw = curl_exec($curl);
        
        curl_close($curl);
        
        
        
        return $res_raw;
        
        
    }
    
    public function kirimIndividu($nomor, $pesan) {
        $msg = array(
            "data"=>$nomor,
            "pesan"=>$pesan,
        );
        
        $enc = CJSON::encode($msg);
        $url = $this->host_single;
        
        $curl = curl_init();
        
        $arr_param = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => CJSON::encode($msg),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            )
        );
        
//        var_dump($arr_param); die;
        
        
        curl_setopt_array($curl, $arr_param);
        
//         var_dump($msg); die;
//        print_r($data); die;
        
        $res_raw = curl_exec($curl);
        
        curl_close($curl);
        
//        var_dump($res_raw); die;
        
        
        
        return $res_raw;
    }
    
    
    public function kirimFile($nomor, $pesan, $file, $jenistampil, $nama_rs = '', $type = '') {
        
//        var_dump(is_file($file)); die;
        
        $msg = array(
            "file"=>new CURLFile($file),
            "namars"=>$nama_rs,
            "data"=>$nomor,
            "pesan"=>$pesan,
            "type"=>$type,
            "jenistampil"=>$jenistampil,
        );
        
//        vaR_dump($msg); die;
        
        // $enc = CJSON::encode($msg);
        $url = $this->host_file;
        
        //vaR_dump($url); die;
        
        $curl = curl_init();
        
        $arr_param = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_VERBOSE => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            // CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $msg,
//            CURLOPT_SSL_VERIFYHOST => 0,
//            CURLOPT_SSL_VERIFYPEER => 0,
//            CURLOPT_HTTPHEADER => array(
//                "Content-Type: application/json",
//            )
        );
        
//        var_dump($arr_param); die;
        
        
        curl_setopt_array($curl, $arr_param);
        
//         var_dump($msg); die;
//        print_r($data); die;
        
        $res_raw = curl_exec($curl);
        
//        var_dump("Kick", $res_raw, curl_error($curl)); die;
        
        curl_close($curl);
        
//        var_dump($res_raw); die;
        
        
        
        return $res_raw;
    }
    
    
}
