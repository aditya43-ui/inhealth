<?php 

require_once __DIR__ . '/../../vendor/autoload.php';
	class ListAllOrder	{

        const URL_PORTAL = "http://10.10.123.24/portal";

        public $err_msg;
        public function request($url,$method, $parameter = null) {
            
            $curl = curl_init();
            
            if (!empty($parameter)) {
                $parameter = http_build_query($parameter);
            }
            
            $link = 'https://ris-test.rssa.my.id/api/'. $url;
            $token = 'MTC4cYDLY0ZPj41Ugbh1NcCvBfHHrtUP9CBecMJAKAA5zUxgSS5drJJTROkA';
            

            set_time_limit(0);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $link,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POST => true,
                CURLOPT_VERBOSE => true,
                CURLOPT_POSTFIELDS => $parameter,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                    'Authorization: Bearer ' . $token,
                    'Accept: application/json',
                    
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


        
        public function getData(){
            $url = 'listallorder';
            return $this->request($url,"GET");
        }


        public function postData($dataRad){
            $url = 'registerpasien';

            return $this->request($url,"POST",$dataRad);
        }

        public static function generateURLHasil($no_register, $nofoto) {

            // var_dump($no_register, $nofoto); die;

            //$date = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $date = date('Y-m-d H:i:s');

            $url = self::URL_PORTAL."?";
            $url .= "force_all_browsers=true"
            . "&patient_id=".$no_register
            . "&accession_number=".$nofoto
            . "&tz=".password_hash($date, PASSWORD_DEFAULT)
            . "&password_encrypted=true"
            . "&user_name=hisris&password=HIIFALMMAHFLAOCN";
		// var_dump($url); die;
            return $url;
        }

        public static function getLoadHasilList($no_register) {
            $list = array();
            try {

        $sql = "SELECT a.nofoto,a.reques,a.mulai,a.akhir,a.status "
                ."from periksa a "
                //."left join riwayatjawaban b on b.nofoto = a.nofoto "
                ."where a.noregister = '".$no_register."' and a.verifikasi is not null";

                $list = Yii::app()->db_ris->createCommand($sql)->queryAll();

		foreach ($list as $idx => $item) {
                    $sqlj = "SELECT jawaban from riwayatjawaban where nofoto='".$item['nofoto']."'";
                    $j = Yii::app()->db_ris->createCommand($sqlj)->queryRow();
                    $list[$idx]['jawaban'] = $j['jawaban'] ?? "";
		}


            } catch (Exception $e) { var_dump($e->getMessage()); die;
                $list = array();
            }

            return $list;

        }

        public static function getLoadHasil($nofoto) {
            
            try {
                $sql = "SELECT a.daftar,a.nofoto,a.noregister,d.nama as namapasien,d.jk,d.tgl_lahir,a.reques,a.mulai,a.akhir,a.status,b.jawaban,c.nama as namadokter,a.asalpasien from periksa a
                left join riwayatjawaban b on a.nofoto = b.nofoto
                left join dokter c on a.dokter_id = c.id
                left join pasien d on a.pasien_id = d.id
                where a.nofoto = '".$nofoto."'
                order by b.id desc";
                return Yii::app()->db_ris->createCommand($sql)->queryRow();

            } catch (CException $e) {

                // var_dump($e->getMessage()); die;

                return array(
                    "daftar" => "",
                    "nofoto" => "",
                    "noregister" => "",
                    "namapasien" => "",
                    "jk" => "",
                    "tgl_lahir" => null,
                    "reques" => "",
                    "mulai" => "",
                    "akhir" => "",
                    "status" => "",
                    "jawaban" => "",
                    "namadokter" => "",
                    "asalpasien" => ""
                );
            } 
            
            /*
            return CJSON::decode('
            {
                "daftar" : "2022-05-24 01:10:52",
                "nofoto" : "FNK-IGD22-012789",
                "noregister" : "10014832",
                "namapasien" : "DJONI AMSARI",
                "jk" : "L",
                "tgl_lahir" : "1959-07-15",
                "reques" : "Thorak PA",
                "mulai" : "2022-05-24 01:10:52",
                "akhir" : "2022-05-24 01:16:52",
                "status" : "Selesai",
                "jawaban" : "<p><strong>Foto Thorax AP (kurang inspirasi)<\/strong><\/p>\n\n<table cellspacing=\"0\" style=\"width:727px\">\n\t<tbody>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Cor<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Ukuran membesar, CTR &plusmn;64%<\/td>\n\t\t<\/tr>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Aorta<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Tidak tampak elongasi dan dilatasi. Tampak kalsifikasi (+)<\/td>\n\t\t<\/tr>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Trachea<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Ditengah<\/td>\n\t\t<\/tr>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Pulmo<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Tampak peningkatan corakan vaskuler dengan infiltrat perivaskuler dominan sentral membentuk gambaran batwing.&nbsp;<\/td>\n\t\t<\/tr>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Sudut costophrenicus D\/S<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Lancip<\/td>\n\t\t<\/tr>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Hemidiaphragma D\/S<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Dome shape<\/td>\n\t\t<\/tr>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Skeleton<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Intak, tidak tampak lesi osteolitik\/osteoblastik\/garis fraktur<\/td>\n\t\t<\/tr>\n\t\t<tr>\n\t\t\t<td style=\"width: 178px; vertical-align: top;\">Soft tissue<\/td>\n\t\t\t<td style=\"width: 18px; vertical-align: top;\">:<\/td>\n\t\t\t<td style=\"width: 525px; vertical-align: top;\">Normal<\/td>\n\t\t<\/tr>\n\t<\/tbody>\n<\/table>\n\n<p><strong>Kesimpulan :<\/strong><\/p>\n\n<ul>\n\t<li><strong>Cardiomegaly dengan&nbsp;<strong>edema pulmonum<\/strong><\/strong><\/li>\n\t<li><strong>Aorta sklerosis<\/strong><\/li>\n<\/ul>",
                "namadokter" : "dr. Irma Darinafitri, Sp.Rad(K)",
                "asalpasien" : "Ruangan IGD"
            }
            ');
            */
        }

    }


 
    ?>
