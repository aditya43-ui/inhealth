
<?php

class UsulanPenghapusanAsetController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.usulanPenghapusanAset.';
    public $path_tips = 'sistemAdministrator.views.tips.';    
   
    public function actionIndex($usulanpenghapusanaset_id = null) {
     
        $model = new MAUsulanpenghapusanT;  
        $model->usulanpenghapusanaset_tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->usulanpenghapusanaset_nomor = '-- Otomatis --';
        
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if (!empty($peg)){
            $model->pegpengusul_id = $peg->pegawai_id;
            $model->pegpengusul_nama = $peg->namaLengkap;
        }
        
        $modDet = new MAUsulanpenghapusanasetdetT;
        
        $pesan = '';  
                
        if (isset($_POST['MAUsulanpenghapusanT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {                                
                                
                $proses = MAUsulanpenghapusanT::simpan_data($model,$_POST['MAUsulanpenghapusanT']);
                $model = $proses['model'];
                $pesan .= $proses['pesan'];
                $ok &= $proses['sukses'];                
                                
                
                $proses = MAUsulanpenghapusanasetdetT::simpan_data($model,$_POST['MAUsulanpenghapusanasetdetT'], true);                
                $pesan .= $proses['pesan'];
                $ok &= $proses['sukses'];  
                                                                                    
                                       
                if ($ok) {                       
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('index', 'usulanpenghapusanaset_id' => $model->usulanpenghapusanaset_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>".$pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modDet' => $modDet,            
        ));
    }      
    
    /**
     * 
     */
    public function actionInformasi(){

        $model = new MAInformasiusulanpenghapusanasetV;
        $model->unsetAttributes();  // clear any default values
        $format = new MyFormatter();
        $model->tgl_awal = date("Y-m-01");
        $model->tgl_akhir = date("Y-m-d");
        
        $lokasi_id = PenanggungjawabasetM::getDropIdByPegawai(Yii::app()->user->getState('pegawai_id'));
        $model->ada_pj_aset = !empty($lokasi_id)?true:false;

        if (isset($_GET['MAInformasiusulanpenghapusanasetV'])) {
            $model->attributes = $_GET['MAInformasiusulanpenghapusanasetV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInformasiusulanpenghapusanasetV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInformasiusulanpenghapusanasetV']['tgl_akhir']);           
            $model->pegpengusul_nama = isset($_GET['MAInformasiusulanpenghapusanasetV']['pegpengusul_nama'])?$_GET['MAInformasiusulanpenghapusanasetV']['pegpengusul_nama']:null;
        }
                         

        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                $path = $this->path_view.'informasi/grid/_tabel';
                if ($ajax == 'lokasi-grid')
                    $path = $this->path_view.'informasi/grid/_lokasi';
                    
                $this->renderPartial($path, array(
                    'model' => $model,                    
                ));
            }
        }else{        
            $this->render($this->path_view . 'informasi/index', array(
                'model' => $model,
                'format' => $format,
            ));
        }    
    }
    
    /**
     * 
     * @param type $usulanpenghapusanaset_id
     */
    public function actionVerifikasi($usulanpenghapusanaset_id = null) {
     
        $model = MAUsulanpenghapusanT::model()->findByPk($usulanpenghapusanaset_id);  
        $model->usulanpenghapusanaset_tanggal = MyFormatter::formatDateTimeForUser($model->usulanpenghapusanaset_tanggal);
        $model->tanggal_verifikasi = MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s"));        
        $model->pegpengusul_nama = !empty($model->pegpengusul->namaLengkap)?$model->pegpengusul->namaLengkap:null;
        $model->lokasiaset_namalokasi =  !empty($model->lokasi->lokasiaset_namalokasi)?$model->lokasi->lokasiaset_namalokasi:null;
        
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if (!empty($peg)){
            $model->pegverifikasi_id = $peg->pegawai_id;
            $model->pegverifikasi_nama = $peg->namaLengkap;
        }
        
        $modDet = MAUsulanpenghapusanasetdetT::model()->findAll(" usulanpenghapusanaset_id = ".$usulanpenghapusanaset_id." ");
        
        $pesan = '';  
                
        if (isset($_POST['MAUsulanpenghapusanT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {                                
                $model->jenis_transaksi = 'verifikasi';          
                $proses = MAUsulanpenghapusanT::simpan_data($model,$_POST['MAUsulanpenghapusanT']);
                $model = $proses['model'];
                $pesan .= $proses['pesan'];
                $ok &= $proses['sukses'];                                               
                                
                
                $proses = MAUsulanpenghapusanasetdetT::simpan_data($model,$_POST['MAUsulanpenghapusanasetdetT'], true);                
                $pesan .= $proses['pesan'];
                $ok &= $proses['sukses'];  
                                                                                    
                                       
                if ($ok) {                       
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $trans->commit();
                    $this->redirect(array('verifikasi', 'usulanpenghapusanaset_id' => $model->usulanpenghapusanaset_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>".$pesan);
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'verifikasi/index', array(
            'model' => $model,
            'modDet' => $modDet,            
        ));
    }   
    
    /**
     * 
     * @param type $usulanpenghapusanaset_id
     */
    public function actionDetail($usulanpenghapusanaset_id = null) {
     
        $model = MAUsulanpenghapusanT::model()->findByPk($usulanpenghapusanaset_id);  
        $model->usulanpenghapusanaset_tanggal = MyFormatter::formatDateTimeForUser($model->usulanpenghapusanaset_tanggal);        
        $model->pegpengusul_nama = !empty($model->pegpengusul->namaLengkap)?$model->pegpengusul->namaLengkap:null;
        $model->lokasiaset_namalokasi =  !empty($model->lokasi->lokasiaset_namalokasi)?$model->lokasi->lokasiaset_namalokasi:null;
        $model->lokasisementara_nama =  !empty($model->lokasisementara->lokasiaset_namalokasi)?$model->lokasisementara->lokasiaset_namalokasi:null;
        
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if (!empty($peg)){
            $model->pegverifikasi_id = $peg->pegawai_id;
            $model->pegverifikasi_nama = $peg->namaLengkap;
        }
        
        $modDet = MAUsulanpenghapusanasetdetT::model()->findAll(" usulanpenghapusanaset_id = ".$usulanpenghapusanaset_id." ");
                

        $this->render($this->path_view . 'detail', array(
            'model' => $model,
            'modDet' => $modDet,            
        ));
    }  
}
