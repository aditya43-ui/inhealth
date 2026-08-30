<?php
class TravelingController extends MyAuthController {
    
    public $path_view = 'hemodialisa.views.traveling.';
    
    public function actionIndex($pendaftaran_id) {
                
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax  = $_GET['ajax'];
                
                if ($ajax == 'daftar-petugas-grid')
                    $path = 'grid/_daftarPetugas';
                
                $this->renderPartial($path,[]);
            }
            exit;
        }                
        
        $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
        
        $model = new SurattravellinghdT;
        $cekTrav = SurattravellinghdT::model()->findByAttributes([
           'no_pendaftaran' => $modDaftar->no_pendaftaran 
        ]);
        if (!empty($cekTrav)){
            $model = $cekTrav;
            $model->loadInput();
        }else{
            $model->tanggal = date('d M Y');
            $model->no_rekam_medik = $modPasien->no_rekam_medik;
            $model->nama_pasien = $modPasien->nama_pasien;
            
            $umur = explode(' ', $modDaftar->umur);
            $model->umur_pasien = $umur[0];
            $model->jk_pr = ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN)?true:false;
            $model->jk_lk = ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI)?true:false;
            $model->alamat_pasien = $modPasien->alamat_pasien;
        }
        
        if (isset($_POST['SurattravellinghdT'])) {                           
            $pesan = '';
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;            
            try{
                
                $post = $_POST['SurattravellinghdT'];
                $post['no_pendaftaran'] = $modDaftar->no_pendaftaran;
                
                $proses = SurattravellinghdT::simpanData($model, $post);
                
                $model = $proses['model'];                
                $ok &= $proses['sukses'];
                $pesan .= $proses['pesan'];
                
                if ($ok) {                                                           
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
                    $this->redirect(['index','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1,'id'=>$model->travellinghd_id]);
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan".$pesan);
                }
            }catch(Exception $e){
                $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan". MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('index', array(
            'model' => $model,            
        ));
    }
    
    public function actionCetakSurat($id){
        $this->layout = '//layouts/printWindows';
        
        $model = SurattravellinghdT::model()->findByPk($id);       
        
        $model->loadInput();
        
        $this->render('print', array(
            'model'=>$model
        ));
    }
}
