<?php
/**
 * class ini digunakan untuk aplikasi ICD-9 
 */
class MICD9Controller extends Controller{
    public $defaultAction = "Index";
    public $layout = "//layouts/iframe";
    
    public function actionIndex()
    {
        $this->render('/default/index');
    }
    
    /**
     * login 
     * Issue: MA-106
     * @param : $_GET['username']
     * @param : $_GET['password']
     * @return json array
     */
    public function actionLogin()
    {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Error 404. Request tidak valid!";
        if(isset($_GET['username']) && isset($_GET['password'])){
            $password = (trim($_GET['password']));
            $data['loginpemakai_id'] = '';
            $data['pasien_id'] = '';
            $data['pegawai_id'] = '';
            $sql = "SELECT * 
                    FROM loginpemakai_k
                    WHERE loginpemakai_aktif = TRUE
                        AND LOWER(nama_pemakai) = '".strtolower($_GET['username'])."'
                        AND katakunci_pemakai = '".$password."'
                    ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryRow();
            if($loadDatas){
                $updateLogin = LoginpemakaiK::model()->updateByPk($loadDatas['loginpemakai_id'],array(
                    'statuslogin'=>'TRUE',
                    'waktuterakhiraktifitas'=>date("Y-m-d H:i:s"),
                    'lastlogin'=>date("Y-m-d H:i:s"),
                    'crudaktifitas'=>"mobile/mLogin/login",
                ));
                $data['loginpemakai_id'] = $loadDatas['loginpemakai_id'];
                $data['pasien_id'] = $loadDatas['pasien_id'];
                $data['pegawai_id'] = $loadDatas['pegawai_id'];
				if(!empty($data['pegawai_id'])){
					$sql = "SELECT * 
						FROM pegawai_m
						WHERE pegawai_id = ".$data['pegawai_id']."
						";
					$loadDataPegawai = Yii::app()->db->createCommand($sql)->queryRow();
					$data['pegawai'] = $loadDataPegawai;
				}
                $data['sukses'] = 1;
                $data['pesan'] = "Login berhasil!";
            }else{
                $data['pesan'] = "Login gagal! Username dan password yang Anda masukan salah";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * login 
     * Issue: MA-106
     * @param : $_GET['loginpemakai_id']
     * @return json array
     */
    public function actionLogout()
    {
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Error 404. Request tidak valid!";
        if(isset($_GET['loginpemakai_id'])){
            $updateLogin = LoginpemakaiK::model()->updateByPk($_GET['loginpemakai_id'],array(
                'statuslogin'=>'FALSE',
                'waktuterakhiraktifitas'=>date("Y-m-d H:i:s"),
                'lastlogin'=>date("Y-m-d H:i:s"),
                'crudaktifitas'=>"mobile/mLogin/logout",
            ));
            $data['sukses'] = 1;
            $data['pesan'] = "Anda telah logout!";
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * ganti password 
     * Issue: MA-119
     * @param : $_GET['loginpemakai_id']
     * @param : $_GET['passwordlama']
     * @param : $_GET['passwordbaru']
     * @return json array
     */
    public function actionGantiPassword(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Error 404. Request tidak valid!";
        if(isset($_GET['loginpemakai_id']) && isset($_GET['passwordlama']) && isset($_GET['passwordbaru'])){
            $loadLogin = LoginpemakaiK::model()->findByPk($_GET['loginpemakai_id']);
            if($loadLogin){
                $passwordlama = ($_GET['passwordlama']);
                if($passwordlama == $loadLogin['katakunci_pemakai']){
                    $loadLogin->katakunci_pemakai = ($_GET['passwordbaru']);
                    $loadLogin->waktuterakhiraktifitas = date("Y-m-d H:i:s");
                    $loadLogin->crudaktifitas = "mobile/mLogin/GantiPassword";
                    if($loadLogin->update()){
                        $data['sukses'] = 1;
                        $data['pesan'] = "Password ".$loadLogin->nama_pemakai." berhasil diubah!";
                    }else{
                        $data['sukses'] = 0;
                        $data['pesan'] = "Password gagal diubah!<br>".CHtml::errorSummary($loadLogin);
                    }
                    
                }else{
                    $data['sukses'] = 0;
                    $data['pesan'] = "Password lama salah!";
                }
            }else{
                $data['sukses'] = 0;
                $data['pesan'] = "Data tidak ditemukan didatabase!";
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * MA-142
     */
    public function actionGetLoginPemakaiChat(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['loginpemakai_id'])){
            $sql = "SELECT loginpemakai_id, pegawai_id, pasien_id, nama_pemakai, ruangan_m.ruangan_nama AS ruanganaktifitas_nama, crudaktifitas, waktuterakhiraktifitas
                    FROM loginpemakai_k
                    LEFT JOIN ruangan_m ON ruangan_m.ruangan_id = loginpemakai_k.ruanganaktifitas
                    WHERE loginpemakai_aktif = TRUE
                        AND statuslogin = TRUE
                        AND loginpemakai_id <> ".$_GET['loginpemakai_id']."
                    ORDER BY nama_pemakai ASC 
                    ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryRow();
            $data = $loadDatas;
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
}
?>
