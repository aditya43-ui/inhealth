<?php
/**
 * - digunakan sebagai controller utama untuk memanggil fungsi - fungsi utama finger pasien
 * - 
 * 
 */
class FingerPasienController extends Controller
{
    
	/**
	 * - digunakan untuk memverifikasi pasien
	 * - jika pasien ditemukan melalui scan sidik jari, otomatis data akan diloag
	 * - jika pasien tidak ditemukan tidak ada reaksi yang terjadi
	 * - PII-137
	 */
    public function actionVerifikasiFP()
    {        
        if(Yii::app()->request->isAjaxRequest) { 
                if (!empty($_SERVER["HTTP_CLIENT_IP"])) 
                {
                    $ip = $_SERVER["HTTP_CLIENT_IP"]; 
                    
                }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) 
                {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
                    
                }
                else
                {
                    $ip = $_SERVER["REMOTE_ADDR"];                    
                }

                
                    
                    $host = Yii::app()->user->getState('finger_pasien_hostserver');  //'192.168.0.5' ip debuga
                    $port = CustomFunction::incPortFinger($ip);                    
                    //$port = Yii::app()->user->getState('finger_pasien_portserver');  //'192.168.0.5' ip debuga
                                                            
                    set_time_limit(0); 	                                        
                    

                    // create socket
                    $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
                    
                    
                    if (!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
                            echo socket_strerror(socket_last_error($socket));
                            exit;
                    }
                    
                    
                    // bind socket to port
                    $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
                    // start listening for connections
                    $result = socket_listen($socket, SOMAXCONN) or die("Could not set up socket listener\n");
                    // accept incoming connections
                    // spawn another socket to handle communication
                    $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
                    // read client input
                    
                    
                        if (false ===  ($buf = @socket_read($spawn, 10000, PHP_NORMAL_READ)))
                        {
                            $data['pesan'] = 'clientclose';

                        }else{
                          //  $input = socket_read($spawn, 10000, PHP_NORMAL_READ) or die("Could not read input\n");
                            $input = trim($buf); //(pasien_id[0] /// no rekam medik[1] /// nofingerprint[2] /// ip[3])
                            $ipfinger = explode(" /// ", $input); 
                            $data = array();
                            if($ipfinger[3] == $ip) {	
                                    $data['no_rekam_medik'] = $ipfinger[1]; 
                                    $data['pasien_id'] = $ipfinger[0]; 
                                    $data['nofingerprint'] = $ipfinger[2]; 
                                    $data['pesan'] = 'sukses';
                            }else{ 
                                $data['pesan'] = 'gagal';                            
                            
                            }

                        }
                    
                    socket_close($spawn);
                    socket_close($socket);
            
            echo json_encode($data);
            Yii::app()->end();
        }        
    }
    
	/**
	 * - digunakan untuk mendaftaran sidik jari pasien, untuk pasien yang sudah terdaftarkan atau belum
	 * - PII-137
	 */
    public function actionPendaftaranFP()
    {        
        if(Yii::app()->request->isAjaxRequest) { 
            if (!empty($_SERVER["HTTP_CLIENT_IP"])){
                $ip = $_SERVER["HTTP_CLIENT_IP"];                 
            }
            elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
                
            }else{ 
                $ip = $_SERVER["REMOTE_ADDR"];                 
            }
            
            $data = array();
            
            $no_rm = isset($_POST['no_rekam_medik'])?$_POST['no_rekam_medik']:null;
                        
            
            
            $host    = $ip;
            //$port    = CustomFunction::incPortFinger($ip);
            $port    = CustomFunction::incPortFinger($ip);
            //$port = Yii::app()->user->getState('finger_pasien_portserver');             
            
            if ($no_rm == null){
                $data['pesan'] = 'gagal-norm';
            }else{
                // create socket
                //$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
                $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
                
                
//socket_set_nonblock($socket);
                // connect to server
                if (!@socket_connect($socket, $host, $port)){
                    $data['pesan'] = 'gagal';                    
                    echo json_encode($data);
                    Yii::app()->end();
                    //die("Could not connect to server\n");  
                }
                // send string to server
                $cek = @socket_write($socket, $no_rm);// or die("Could not send data to server\n")
                
                if ($cek !== false){                                    
                    socket_close($socket);
                    $data['pesan'] = 'kirim';                    
                }
                 
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionBatalVerifFP(){
        //if (Yii::app()->request->isAjaxRequest){
            if (!empty($_SERVER["HTTP_CLIENT_IP"])){
                $ip = $_SERVER["HTTP_CLIENT_IP"];                 
            }
            elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
                
            }else{ 
                $ip = $_SERVER["REMOTE_ADDR"];                 
            }
            
            $data = array();
            
            $no_rm = isset($_POST['no_rekam_medik'])?$_POST['no_rekam_medik']:null;
                        
            //Surely there isn't any server behind
            //$host = "127.0.0.1";
           // $host = "10.1.28.24";
           // $port = 6001;

            //var_dump(CustomFunction::incPortFinger($ip));die;

          //  if(!$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))
             //   exit("ERROR creating the socket.");

         //   if(!socket_connect($socket, $host, $port))
            //    exit("ERROR connecting.");

         //   socket_close($socket);

         //   exit("Success connecting!");
            
            $host    = Yii::app()->user->getState('finger_pasien_hostserver');            
            $port    = CustomFunction::incPortFinger($ip);
            //$port = Yii::app()->user->getState('finger_pasien_portserver');
            
            
            
            
            $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

            $ok = @socket_connect($socket, $host, $port);
                socket_close($socket);exit;
            $cek = @socket_write($socket, 'batal');

            if ($cek !== false){                                    
                socket_close($socket);
                $data['pesan'] = 'kirim';                    
            }
                 
            
            
            echo json_encode($data);
            
            
            Yii::app()->end();
        //}
    }
	
	
}
?>
