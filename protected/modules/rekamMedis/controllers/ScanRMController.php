<?php
/**
 * Menampilkan data hasil scan Rekam Medis.
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.rekamMedis
 * @subpackage controllers
 */
class ScanRMController extends MyAuthController
{
    public $path_view = "application.modules.rekamMedis.views.scanRM.";

    /**
     * Menampilkan view data hasil scan.
     */
	public function actionIndex()
	{
            $instalasi_id = Yii::app()->user->getState('instalasi_id');
        if ($instalasi_id == Params::INSTALASI_ID_RJ || $instalasi_id == Params::INSTALASI_ID_RD || 
            $instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_LAB || 
            $instalasi_id == Params::INSTALASI_ID_RAD||$instalasi_id == Params :: INSTALASI_ID_TINDAKAN || in_array($instalasi_id, Params::INSTALASI_ID_RI_ARR) || isset($_GET['lihat'])) {
            $this->layout = "//layouts/iframe";
        }

        if(isset($_GET['frame'])) {
            $this->layout = "//layouts/iframe";
        }

        if (!empty($_GET['pendaftaran_id'])) {
            $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
            $modFile = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modFile->nama_pasien;
            $modFile->tanggal_lahir;
            $modFile->jeniskelamin;
            $modFile->alamat_pasien;
           
        }

        $model = new DokfilermR;

		$this->render($this->path_view.'index' , array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modFile'=>$modFile));
	}
    
    
    // AJAX ACTION
    /**
     * Autocomplete untuk load Pasien berdasarkan No. RM
     * 
     * @param string $no_rm No. RM yang dicari.
     */
    public function actionAutocompleteNoRM($no_rm = "") {
		if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->compare('statusrekammedis', Params::STATUSREKAMMEDIS_AKTIF);
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rm), true);
			$criteria->order = 'no_rekam_medik';
			$criteria->limit = 5;

			$models = PasienM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				
				
				$returnVal[$i]['pasien_id'] = $model->pasien_id;
				$returnVal[$i]['no_rekam_medik'] = $model->no_rekam_medik;
				$returnVal[$i]['nama_pasien'] = $model->nama_pasien;
				$returnVal[$i]['nama_bin'] = $model->nama_bin;
				$returnVal[$i]['jeniskelamin'] = $model->jeniskelamin;
				$returnVal[$i]['alamat_pasien'] = $model->alamat_pasien;
				$returnVal[$i]['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($model->tanggal_lahir);
				
				
				$returnVal[$i]['label'] = $model->no_rekam_medik." - ".$model->nama_pasien;
				$returnVal[$i]['value'] = $model->nama_pasien;
			}
			
			$returnVal = CHtml::encodeArray($returnVal);

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
    
    /**
     * Dilakukan ketika pada input No.RM ketik enter/tab.
     * Kemudian mengambil data pasien berdasarkan No.RM Lengkap.
     */
    public function actionAjaxNoRM() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $ok = 1;
        
        $no_rm = $_POST['no_rm'];
        
        
        $model = PasienM::model()->findByAttributes(array(
            'no_rekam_medik'=>$no_rm,
        ));
        
        if (empty($model)) {
            echo CJSON::encode(array(
                'ok'=>0,
            ));
            Yii::app()->end();
        }
        
        $res['pasien_id'] = $model->pasien_id;
        $res['no_rekam_medik'] = $model->no_rekam_medik;
        $res['nama_pasien'] = $model->nama_pasien;
        $res['nama_bin'] = $model->nama_bin;
        $res['jeniskelamin'] = $model->jeniskelamin;
        $res['alamat_pasien'] = $model->alamat_pasien;
        $res['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($model->tanggal_lahir);

        $res['label'] = $model->no_rekam_medik." - ".$model->nama_pasien;
        $res['value'] = $model->nama_pasien;
        
        echo CJSON::encode(array(
            'ok'=>1,
            'pasien'=>$res,
        ));
    }

    /**
     * Menampilkan data hasil scan beserta fungsi detail dari hasil scan tersebut.
     */
    public function actionLoadFileScan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        $lihat = $_POST['lihat'];
        $pasien = PasienM::model()->findByAttributes(array(
            'no_rekam_medik'=>$_POST['no_rm']
        ));
        $file = DokfilermR::model()->findAllByAttributes(array(
            'pasien_id'=>$pasien->pasien_id,
        ), array(
            'order'=>'dokfilerm_nourut',
        ));
        
        $str = "";

        if($lihat == 1) {
            $view = '_fileScanLihat';
        } else {
            $view = '_fileScan';
        }
        foreach ($file as $item) {                                
            $str .= $this->renderPartial($this->path_view.$view, array(
                'item'=>$item,
                'pasien'=>$pasien,
            ), true);
        }
        
        echo CJSON::encode(array('html'=>$str));
    }
    
    /**
     * Menampilkan detail hasil scanning.
     * 
     * @param integer $dokfilerm_id ID File Hasil Scan.
     */
    public function actionDetailScanRM($dokfilerm_id) {
        $this->layout = '//layouts/iframe';
        
        $file = DokfilermR::model()->findByPk($dokfilerm_id);
               
        if (strpos($file->dokfilerm_filepath,'.pdf') !== false){
            $this->redirect(Params::urlFileRMPasienDirectory().$file->namafolder.'/'.$file->dokfilerm_filepath);
        }else{
            $this->render($this->path_view."detail", array(
                'file'=>$file,
            ));
        }
        
    }
    
    /**
     * Menentukan lokasi file untuk mengeload gambar hasil scan.
     * Bisa di konfigurasikan via sysadmin -> Konfig System.
     * 
     * @return string
     */
    public function getPathScanRM() {
        return "data/images/pasien/rekammedis/";
    }
    

    
    public function actionSimpanGambar(){
        if (Yii::app()->request->isAjaxRequest){
            $ok = true;
          
           
               
                
                $i=0;
                $a = 1;
                // echo '<pre>';
                // // print_r($_FILES['DokfilermR']);
                // var_dump ($_FILES); die;

            if(!empty($_POST['Detailscan'])){
                foreach ($_POST['Detailscan'] as $i => $dataPost) {
                    // var_dump ($_POST); die;
                    $pasien = RKPasienM::model()->findByPk($_POST['pasien']['pasien_id']);

                    if (!file_exists(Params::pathFileRMPasienDirectory())) {
                        mkdir(Params::pathFileRMPasienDirectory(), 0755, true);
                    }
                    if (!file_exists(Params::pathFileRMPasienDirectory().$pasien->no_rekam_medik.'/')) {
                        mkdir(Params::pathFileRMPasienDirectory().$pasien->no_rekam_medik.'/', 0755, true);
                    }

                    // untuk gambar thumbs
                    if (!file_exists(Params::pathFileRMTumbsDirectory())) {
                        mkdir(Params::pathFileRMTumbsDirectory(), 0755, true);
                    }
                    if (!file_exists(Params::pathFileRMTumbsDirectory().$pasien->no_rekam_medik.'/')) {
                        mkdir(Params::pathFileRMTumbsDirectory().$pasien->no_rekam_medik.'/', 0755, true);
                    }
                    $nama_file = $dataPost['file_gambar_nama'];
                    $bin = strtolower(basename($nama_file));
                   
                    
                    // exit();
                    



                      
                    $count = DokfilermR::model()->findAllByAttributes(array('pasien_id' => $pasien->pasien_id));
                    
                    $model = new DokfilermR;
                    $model->pasien_id = $pasien->pasien_id;
                  // $model->pasien_id = Yii::app()->user->getState('pasien_id');  
                   
                   $model->instalasi_ids = (!empty($dataPost['instalasi_ids'])? implode(",",$dataPost['instalasi_ids']) : null);
                    $model->dokfilerm_nourut = count($count)+1;                         
                    $model->dokfilerm_tgl = date('Y-m-d H:i:s');
                    $model->dokfilerm_filepath = $nama_file;
                    $model->upload_tgl = date('Y-m-d H:i:s');
                    $model->namafolder = $pasien->no_rekam_medik;
                    $model->dokfilerm_keterangan = 'Upload Manual';
                    $model->pegawaiscan_id = Yii::app()->user->getState('pegawai_id');
                    $model->create_time = date('Y-m-d H:i:s');                
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');  
                    $model->dokfilerm_nama = $dataPost['dokfilerm_nama'];
                    
                    $ok = $ok && $model->save();

                //    var_dump($ok); die;
                    
                    if ($ok){
              
                        
                        $image = $_FILES['Detailscan'];
                        
                        $temp_file = $image['tmp_name'][$a]['files'];
                        $name = $image['name'][$a]['files'];
                        $target_file = Params::pathFileRMPasienDirectory().$pasien->no_rekam_medik.'/'.$name;
                        if(move_uploaded_file($temp_file, $target_file)){
                            $data['sukses'] = 1;
                            $data['pesan'] = 'Data berhasil di simpan';
                        } else {
                            $data['sukses'] = 0;
                            $data['pesan'] = 'Data gagal di Upload';
                        }

                        
                        
                        $data['sukses'] = 1;
                        $data['pesan'] = 'Data berhasil di simpan';
                        
                    }else{
                        $data['sukses'] = 0;
                        $data['pesan'] = 'Data gagal di simpan';
                        // $trans->rollback();
                    }
                    $i++;
                    $a++;
                    
                }
            }
               
                       
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionHapusGambar(){
        if (Yii::app()->request->isAjaxRequest){
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $dokfilerm_id = isset($_POST['dokfilerm_id'])?$_POST['dokfilerm_id']:null;
                
                $modDok = DokfilermR::model()->findByPk($dokfilerm_id);                                                               
                $target_dir = Params::pathFileRMPasienDirectory();                            
                                
                if (file_exists($target_dir.$modDok->namafolder.'/'.$modDok->dokfilerm_filepath)){                    
                    unlink($target_dir.$modDok->namafolder.'/'.$modDok->dokfilerm_filepath);
                }

                 
                $ok = $ok && $modDok->delete();
                
                if ($ok){                    
                    $data['sukses'] = 1;
                    $data['pesan'] = 'File berhasil di hapus';
                    $trans->commit();                    
                }else{                    
                    $data['sukses'] = 0;
                    $data['pesan'] = 'File gagal di hapus';
                    $trans->rollback();
                }
            }catch(Exception $e){                
                $data['sukses'] = 0;
                $data['pesan'] = 'File gagal di hapus';
                $trans->rollback();
            }
                       
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionLoadPasien(){
        if (Yii::app()->request->isAjaxRequest){
            $data = [];
            $pendaftaran_id = $_GET['pendaftaran_id'];
                
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);     
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id); 
            
            $data['nama_pasien'] = $modPasien->nama_pasien;
            $data['pasien_id'] = $modPasien->pasien_id;
            $data['no_rekam_medik'] = $modPasien->no_rekam_medik;
            $data['alamat_pasien'] = $modPasien->alamat_pasien;
            $data['jeniskelamin'] = $modPasien->jeniskelamin;
            $data['tanggal_lahir'] = !empty($modPasien->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) : null;
           
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
}