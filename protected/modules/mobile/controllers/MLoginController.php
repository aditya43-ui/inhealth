<?php
/**
 * class ini digunakan untuk login mobile
 */
class MLoginController extends Controller{
    public $defaultAction = "Index";
    public $layout = "//layouts/iframe";

    public function actionIndex()
    {
        $this->render('/default/index');
    }

    /**
     * login
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
	      $data['is_found'] = 0;
        $data['data'] = array();
        $data['pesan'] = "Error 404. Request tidak valid!";        
        $model = new LoginpemakaiK;
          
        
        if(isset($_GET['username']) && isset($_GET['password'])){
//            var_dump("Masuk");die;
            $pasien = new PasienM();
            $rekam_medik=isset($_GET['type'])?$_GET['type']:null;
//            var_dump($rekam_medik);die;
 
            
            $criteria=new CDbCriteria();
            if($rekam_medik!= 'pasien'){
            $criteria->addCondition("t.loginpemakai_aktif = True and t.nama_pemakai ilike '".$_GET['username']."'");
            }else{
            $criteria->join="join pasien_m on pasien_m.pasien_id = t.pasien_id";
            $criteria->addCondition("t.loginpemakai_aktif = True and pasien_m.no_rekam_medik ilike '".$_GET['username']."'");
            }
            $loadData = LoginpemakaiK::model()->find($criteria);	
            
            $log = $loadData;
            $data['loginpemakai_id'] = '';
            $data['pasien_id'] = '';
            $data['pegawai_id'] = '';
            
            if(!empty($loadData)){
                
                 $cek = $loadData->cekPassword3($_GET['password']);
                
                if($cek){
                    
                    $updateLogin = LoginpemakaiK::model()->updateByPk($loadData['loginpemakai_id'],array(
                        'statuslogin'=>'TRUE',
                        'waktuterakhiraktifitas'=>date("Y-m-d H:i:s"),
                        'lastlogin'=>date("Y-m-d H:i:s"),
                        'crudaktifitas'=>"mobile/mLogin/login",

                    ));
                     
                    $data['data']['pasien_id'] = $loadData->pasien_id;
                    
                    $data['data']['pegawai_id'] = $loadData->pegawai_id;
                    
                    $data['pasien_id'] = $loadData->pasien_id;
                    $data['pegawai_id'] = $loadData->pegawai_id;
                     
                        if(!empty($data['pegawai_id'])){
                            $sql = "SELECT *
                                    FROM pegawai_m
                            LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
                                WHERE pegawai_id = ". $data['data']['pegawai_id']."
                                ";
                            $loadDataPegawai = Yii::app()->db->createCommand($sql)->queryRow();
                            $data['data'] = $loadDataPegawai;
                            $data['data']['nama_lengkap'] = $loadDataPegawai['gelardepan'].' '.$loadDataPegawai['nama_pegawai'].' '.$loadDataPegawai['gelarbelakang_nama'];
                        }
                    $data['data']['loginpemakai_id'] = $loadData->loginpemakai_id;
                    $data['loginpemakai_id'] = $loadData->loginpemakai_id;
                    $data['sukses'] = 1;
                                            $data['is_found'] = 1;
                    $data['pesan'] = "Login berhasil!";
                }else{
                    $data['pesan'] = "Login gagal! Username dan password yang anda masukan salah";
                }
           }else{
            $data['pesan'] = "Login gagal! Username dan password yang anda masukan salah";
           }
        }
        
        $encode = CJSON::encode($data);
        echo "jsonCallbackLogin(".$encode.")";
        Yii::app()->end();
    }
    
//    public function actionLog()
//    {
//        header("content-type:application/json");
//        $format = new MyFormatter();
//        $data = array();
//        $data['sukses'] = 0;
//	      $data['is_found'] = 0;
//        $data['data'] = array();
//        $data['pesan'] = "Error 404. Request tidak valid!";        
//        $model = new LoginpemakaiK;
////        var_dump("Masuk");die;
//        
//        if(isset($_GET['username']) && isset($_GET['password'])){
//           
//            $sql = "select * from loginpemakai_k
//                    join pasien_m on pasien_m.pasien_id = loginpemakai_k.pasien_id
//                    where pasien_m.no_rekam_medik ilike '".$_GET['username']."' or loginpemakai_k.nama_pemakai ilike '".$_GET['username']."' and loginpemakai_k.loginpemakai_aktif = 't'";
//            $loadData = Yii::app()->db->createCommand($sql)->queryAll();			
//            $log = $loadData;
//            $data['loginpemakai_id'] = '';
//            $data['pasien_id'] = '';
//            $data['pegawai_id'] = '';
//            
//            if(!empty($loadData)){
//                
//                 $cek = $loadData->cekPassword3($_GET['password']);
//                
//                if($cek){
//                    
//                    $updateLogin = LoginpemakaiK::model()->updateByPk($loadData['loginpemakai_id'],array(
//                        'statuslogin'=>'TRUE',
//                        'waktuterakhiraktifitas'=>date("Y-m-d H:i:s"),
//                        'lastlogin'=>date("Y-m-d H:i:s"),
//                        'crudaktifitas'=>"mobile/mLogin/log",
//
//                    ));
//                     
//                    $data['data']['pasien_id'] = $loadData->pasien_id;
//                    
//                    $data['data']['pegawai_id'] = $loadData->pegawai_id;
//                    
//                    $data['pasien_id'] = $loadData->pasien_id;
//                    $data['pegawai_id'] = $loadData->pegawai_id;
//                     
//                        if(!empty($data['pegawai_id'])){
//                            $sql = "SELECT *
//                                    FROM pegawai_m
//                            LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
//                                WHERE pegawai_id = ". $data['data']['pegawai_id']."
//                                ";
//                            $loadDataPegawai = Yii::app()->db->createCommand($sql)->queryRow();
//                            $data['data'] = $loadDataPegawai;
//                            $data['data']['nama_lengkap'] = $loadDataPegawai['gelardepan'].' '.$loadDataPegawai['nama_pegawai'].' '.$loadDataPegawai['gelarbelakang_nama'];
//                        }
//                    $data['data']['loginpemakai_id'] = $loadData->loginpemakai_id;
//                    $data['loginpemakai_id'] = $loadData->loginpemakai_id;
//                    $data['sukses'] = 1;
//                                            $data['is_found'] = 1;
//                    $data['pesan'] = "Login berhasil!";
//                }else{
//                    $data['pesan'] = "Login gagal! Username dan password yang anda masukan salah";
//                }
//           }else{
//            $data['pesan'] = "Login gagal! Username dan password yang anda masukan salah";
//           }
//        }
//        
//        $encode = CJSON::encode($data);
//        echo "jsonCallbackLogin(".$encode.")";
//        Yii::app()->end();
//    }
    
    /**
     * daftar
     * @param : $_GET['no_rekam_medik']
     * @param : $_GET['tgl_lahir']
     * @return json array
     */
    
    public function actionCekPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['sukses'] = 0;
        $data['is_found'] = 0;
        $data['data'] = array();
        $data['pesan'] = "Error 404. Request tidak valid!";
        if(isset($_GET['no_rekam_medik']) && isset($_GET['tanggal_lahir'])){
            $tgl_lahir = $format->formatDateTimeForDb($_GET['tanggal_lahir']);
            $sql = "SELECT *
                    FROM pasien_m
                    WHERE  no_rekam_medik = '".strtolower($_GET['no_rekam_medik'])."'              
                    AND tanggal_lahir = '".$tgl_lahir."'";
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if(!empty($loadData)){
                $data['pasien_id'] = $loadData['pasien_id']; 
                $data['no_rekam_medik'] = $loadData['no_rekam_medik']; 
                $data['nama_pasien'] = $loadData['nama_pasien']; 
                $data['jeniskelamin'] = $loadData['jeniskelamin']; 
                $data['alamat_pasien'] = $loadData['alamat_pasien'];
                $data['no_mobile_pasien'] = $loadData['no_mobile_pasien'];
                $data['alamatemail'] = $loadData['alamatemail'];
                $data['pesan'] = "Pasien Ada!";
                $data['sukses'] = 1; 
                $data['is_found'] = 1;
            }else{
                $data['pesan'] = "Pasien Tidak Ada";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackTes(".$encode.")";
        Yii::app()->end();
    } 
    
     /**
     * simpan
     * @param : $_GET['no_rekam_medik']
     * @param : $_GET['nama_pemakai'] 
     * @param : $_GET['photouser']
     * @param : $_GET['katakunci_pemakai']
     * @param : $_GET['katakunci_pemakai_ulang']
     * @return json array
     */
    public function actionSimpanLoginPemakai(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        $cekPasien = FALSE;
        if(isset($_GET['no_rekam_medik']) && isset($_GET['loginpemakai']) && isset($_GET['pasien'])) { 
            $modPasien = PasienM::model()->findByAttributes(array('no_rekam_medik'=>$_GET['no_rekam_medik']));
            $transaction = Yii::app()->db->beginTransaction(); 
            try{    
                $model=new LoginpemakaiK;
                $model->attributes = $_GET['loginpemakai'];
                $model->pasien_id = $modPasien->pasien_id;
                $model->waktuterakhiraktifitas = date("Y-m-d H:i:s");
                $model->photouser = $modPasien->photopasien;
                $model->nama_pemakai = $modPasien->no_rekam_medik;; 
                $model->new_password = $_GET['loginpemakai']['katakunci_pemakai']; 
                $model->new_password_repeat = $_GET['loginpemakai']['katakunci_pemakai'];
                $sql = " SELECT * from loginpemakai_k
                    WHERE pasien_id = ".$model->pasien_id." ";
                $loadAntrian = MOBuatjanjipoliT::model()->findBySql($sql);
                if(!empty($loadAntrian)){
                    $cekPasien = TRUE;
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Mohon maaf anda sudah memiliki akun sebelumnya";
                    $data['pesanerror'] = "Mohon maaf anda sudah memiliki akun sebelumnya";
                }               
                if($cekPasien == FALSE){
                    if($model->save()){
                        if(!empty($model->alamatemail)&&!empty($model->no_mobile_pasien)){
                            $transaction->commit();
                            $data['sukses'] = 1;
                            $data['pesan'] = 'Pendaftaran akun berhasil!';
                            $data['pesanerror'] = "Pendaftaran akun berhasil";
                        }else{
                            $pasien = PasienM::model()->findByPk($model->pasien_id);
                            $pasien->alamatemail = $_GET['pasien']['alamatemail'];
                            $pasien->no_mobile_pasien = $_GET['pasien']['no_mobile_pasien'];
                            if($pasien->save()){
                                if($pasien->alamatemail !="TIDAK DIKETAHUI"&&$pasien->alamatemail !=""&&$pasien->no_mobile_pasien !=''){
                                    $transaction->commit();
                                    $data['sukses'] = 1;
                                    $data['pesan'] = 'Pendaftaran akun berhasil!';
                                    $data['pesanerror'] = "Pendaftaran akun berhasil";
                                }else if($pasien->alamatemail =="TIDAK DIKETAHUI"){
                                    $transaction->rollback();
                                    $data['sukses'] = 0;
                                    $data['pesan'] = "Mohon maaf email anda salah";
                                    $data['pesanerror'] ="Mohon maaf email anda salah";
                                }else if($pasien->alamatemail ==""){
                                    $transaction->rollback();
                                    $data['sukses'] = 0;
                                    $data['pesan'] = "Mohon maaf email Tidak Boleh Kosong!";
                                    $data['pesanerror'] ="Mohon maaf email Tidak Boleh Kosong!";
                                }else if($pasien->no_mobile_pasien ==''){
                                    $transaction->rollback();
                                    $data['sukses'] = 0;
                                    $data['pesan'] = 'No. Handphone Tidak Boleh Kosong!';
                                    $data['pesanerror'] ='No. Handphone tidak boleh kosong!';
                                }
                            }
                        }
                    }else{
                        $transaction->rollback();
                        $data['sukses'] = 0;
                        $data['pesan'] = 'Password Tidak Boleh Kosong!';
                        $data['pesanerror'] ='Password tidak boleh kosong!';
                    }
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                $data['pesan'] = 'Pendaftaran gagal!';
            }            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackSimpanLogin(".$encode.")";
        Yii::app()->end();
    } 
    
    /**
     * kode verifikasi
     * MA-60
     * @param $_GET['pasien_id']
     * @param $_GET['longitude']
     * @param $_GET['latitude']
     * @param $_GET['alamattujuan']
     * @param $_GET['nomobile']
     * @return json
     */
    public function actionKirimKodeVerifikasi(){
        header("content-type:application/json");
        $ok = 1;
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        
        if(isset($_GET['no_mobile_pasien'])&& isset($_GET['no_rekam_medik'])){
            $modPasien = PasienM::model()->findByAttributes(array('no_rekam_medik'=>$_GET['no_rekam_medik']));
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $length = 6;
                $model=new LoginaktivasiK();
                $model->pasien_id = $modPasien->pasien_id;
                $model->loginaktivasi_nomobile = $modPasien->no_mobile_pasien;
                $model->loginaktivasi_email = $modPasien->alamatemail;
                $model->create_ruangan = 1;
                $model->loginaktivasi_active = true;
                $model->loginaktivasi_token = GenerateTokenPass::generateRandomBase62String($length);
                $model->loginaktivasi_expired = date("Y-m-d H:i:s",strtotime('+10 minutes'));
                $model->create_loginpemakai_id = 1;
                $model->create_iphost = 1;
                $model->create_time = date("Y-m-d H:i:s");                
                if($model->save()){
                    $nama_modul = Yii::app()->controller->module->id;                   
                    $nama_controller = Yii::app()->controller->id;
                    $nama_action = Yii::app()->controller->action->id;
                    $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;               
                    $criteria = new CDbCriteria;
                    $criteria->compare('modul_id',$modul_id);
                    $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
                    $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
                    $criteria->addCondition("tujuansms ='".Params::TUJUANSMS_PASIEN."' ");
                    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
                    $modPasien = $model->pasien;
                    $sms = new Sms();
                    $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;                                
                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $model->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{nama_pasien}}",$modPasien->nama_pasien,$isiPesan);
                            $isiPesan = str_replace("{{no_mobile}}",$model->loginaktivasi_nomobile,$isiPesan);
                            $isiPesan = str_replace("{{kode_verifikasi}}",$model->loginaktivasi_token,$isiPesan);
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                $verifToken = LoginaktivasiK::model()->findByAttributes(array('loginaktivasi_token'=>$token));
                                    if (!empty($verifToken)){
                                        if ($verifToken->loginaktivasi_active == false){
                                             $model->loginaktivasi_active = false;
                                        }elseif($verifToken->loginaktivasi_expired < date("Y-m-d H:i:s",strtotime('+2 minutes'))){
                                             $model->loginaktivasi_active = false;
                                        }
                                    }else{
                                         $model->loginaktivasi_active = false;
                                    }
                                if(!empty($model->loginaktivasi_nomobile)){
                                    $sms->kirimOtomatis($model->loginaktivasi_nomobile,$isiPesan);                                                  
                                }else{
                                    $smspasien = 0;
                                }
                            }
                        }
                        $transaction->commit();
                        $data['sukses'] = 1;
                        $data['pesan'] = 'Kirim Kode Verifikasi Berhasil!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Kirim Kode Verifikasi Gagal!';
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Kirim Kode Verifikasi Gagal Dilakukan!';
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackKirimKode(".$encode.")";
        Yii::app()->end();
      
        
    }
    
    

    /**
     * cekPendaftaran
     * Issue: MA-1125
     * @param : $_GET['pasien_id']
     * @return json array
     */
    public function actionCekPendaftaran()
    {
        header('content-type:application/json');
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = "Error 404. Request tidak valid!";
        if(isset($_GET['pasien_id'])){
            if(!empty($_GET['pasien_id'])){
                $sql = "SELECT ruangan_m.ruangan_nama, ruangan_m.ruangan_id, instalasi_m.instalasi_nama,instalasi_m.instalasi_id,no_pendaftaran,pendaftaran_id,pasien_id,statusperiksa,to_char(tgl_pendaftaran,'d Mon YYYY HH24:MI'),tglselesaiperiksa
                    FROM pendaftaran_t 
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
                    WHERE pasien_id = ".$_GET['pasien_id']."";
                $modPendaftaran = Yii::app()->db->createCommand($sql)->queryAll();
                if(count($modPendaftaran)>0){
                    foreach ($modPendaftaran as $i => $value) {
                        $data['pendaftaran'][$i] = $value;
                    }  
                    $data['sukses'] = 1;
                    $data['pesan'] = "Sukses";                  
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPendaftaran(".$encode.")";
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
        echo "jsonCallbackLogout(".$encode.")";
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
            if(!empty($loadLogin)){
                $cek = $loadLogin->cekPassword3($_GET['passwordlama']);
                if($cek == $loadLogin['katakunci_pemakai']){
                    $loadLogin->katakunci_pemakai = $loadLogin->encrypt($_GET['passwordbaru']);
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
        echo "jsonCallbackGantiPassword(".$encode.")";
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
