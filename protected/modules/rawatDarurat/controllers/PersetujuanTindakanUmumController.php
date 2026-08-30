<?php

/**
 * Inform Consent
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.rawatDarurat
 * @subpackage controllers
 * @category Controller
 */
class PersetujuanTindakanUmumController extends MyAuthController {
    
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.persetujuanTindakanUmum.';
    public $path_view_keterangan = 'rawatDarurat.views.persetujuanTindakanTRD.';
    
    public $url_persetujuan = 'persetujuanTindakanTRD';
    public $url_inform_consent = 'persetujuanTindakanUmum';
    
    
    public function actionIndex($pendaftaran_id = null, $persetujuan_id = null, $frame = 0) {
        
        if ($frame) {
            $this->layout = '//layouts/iframe';
        }
        
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        
        $model = new SuratpersetujuantmT;
        $inform = new InformconsentT();
       
        $model->pendaftaran_id = $pendaftaran_id;
        $model->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;
        
        $model->dokter_id = $modPendaftaran->pegawai_id;
        
        if (!empty($modPendaftaran->pasienmasukpenunjang_id)) {
            $admisi = PasienmasukpenunjangT::model()->findByPk($modPendaftaran->pasienmasukpenunjang_id);
            $model->dokter_id = $admisi->pegawai_id;
        }
        
        
        if (!empty($persetujuan_id)) {
            $model = SuratpersetujuantmT::model()->findByPk($persetujuan_id);
            $inform = InformconsentT::model()->findByAttributes(array(
                'suratpersetujuantm_id'=>$persetujuan_id,
            ));
            
            $inform->informasi_tindakan_medis = CJSON::decode($inform->informasi_tindakan_medis);
        }
        
        if (isset($_POST['SuratpersetujuantmT']) && isset($_POST['InformconsentT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try {
                
                $model->attributes = $_POST['SuratpersetujuantmT'];
                $model->tglpersetujuan = $model->create_time = date('Y-m-d H:i:s');
                $model->nopersetujuan = MyGenerator::noPersetujuan();
                $model->nama_menyetujui = $model->nama_yangmenyetujui;
                
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->ruangan_id = $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->tindakanterhadap = "-";
                $model->alamat_menyetujui = "-";
                $model->jeniskelamin_menyetujui = "-";
                $model->umur_menyetujui = "-";
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                    
                    $inform->attributes = $_POST['InformconsentT'];
                    $inform->informasi_tindakan_medis = CJSON::encode($inform->informasi_tindakan_medis);
                    $inform->suratpersetujuantm_id = $model->suratpersetujuantm_id;
                    
                    $ok = $ok && $inform->save();
                    
                } else {
                    $ok = false;
                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Inform Consent berhasil disimpan.");
                    $this->redirect(array($this->action->id, 'pendaftaran_id'=>$pendaftaran_id, 'persetujuan_id'=>$model->suratpersetujuantm_id, 'frame'=>$frame));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Inform Consent gagal disimpan.");
                    $this->redirect(array($this->action->id, 'pendaftaran_id'=>$pendaftaran_id, 'frame'=>$frame));
                }
                
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Inform Consent gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        
        
        $this->render($this->path_view.'index', array(
            'modPendaftaran'=>$modPendaftaran,
            'model'=>$model,
            'inform'=>$inform,
            'frame'=>$frame,
        ));
        
    }
    
    public function actionPenolakan($pendaftaran_id = null, $persetujuan_id = null, $frame = 0) {
        
        if ($frame) {
            $this->layout = '//layouts/iframe';
        }
        
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        
        $model = new SuratpersetujuantmT;
        $inform = new InformconsentT();
        
        $model->pendaftaran_id = $pendaftaran_id;
        $model->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;
        
        $model->dokter_id = $modPendaftaran->pegawai_id;
        
        if (!empty($modPendaftaran->pasienadmisi_id)) {
            $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $model->dokter_id = $admisi->pegawai_id;
        }
        
        
        if (!empty($persetujuan_id)) {
            $model = SuratpersetujuantmT::model()->findByPk($persetujuan_id);
            $inform = InformconsentT::model()->findByAttributes(array(
                'suratpersetujuantm_id'=>$persetujuan_id,
            ));
            
            $inform->informasi_tindakan_medis = CJSON::decode($inform->informasi_tindakan_medis);
        }
        
        if (isset($_POST['SuratpersetujuantmT']) && isset($_POST['InformconsentT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try {
                
                $model->attributes = $_POST['SuratpersetujuantmT'];
                $model->tglpersetujuan = $model->create_time = date('Y-m-d H:i:s');
                $model->nopersetujuan = MyGenerator::noPersetujuan();
                $model->nama_menyetujui = $model->nama_yangmenyetujui;
                
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->ruangan_id = $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->tindakanterhadap = "-";
                $model->alamat_menyetujui = "-";
                $model->jeniskelamin_menyetujui = "-";
                $model->umur_menyetujui = "-";
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                    
                    $inform->attributes = $_POST['InformconsentT'];
                    $inform->informasi_tindakan_medis = CJSON::encode($inform->informasi_tindakan_medis);
                    $inform->suratpersetujuantm_id = $model->suratpersetujuantm_id;
                    
                    $ok = $ok && $inform->save();
                    
                } else {
                    $ok = false;
                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Inform Consent berhasil disimpan.");
                    $this->redirect(array($this->action->id, 'pendaftaran_id'=>$pendaftaran_id, 'persetujuan_id'=>$model->suratpersetujuantm_id, 'frame'=>$frame));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Inform Consent gagal disimpan.");
                    $this->redirect(array($this->action->id, 'pendaftaran_id'=>$pendaftaran_id, 'frame'=>$frame));
                }
                
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Inform Consent gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        
        
        $this->render($this->path_view.'index', array(
            'modPendaftaran'=>$modPendaftaran,
            'model'=>$model,
            'inform'=>$inform,
            'frame'=>$frame,
        ));
    }
    
    public function actionPrint($pendaftaran_id, $suratpersetujuantm_id) {
        
        $this->layout = '//layouts/printWindows';
        
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $model = SuratpersetujuantmT::model()->findByPk($suratpersetujuantm_id);
        $inform = InformconsentT::model()->findByAttributes(array(
            'suratpersetujuantm_id'=>$suratpersetujuantm_id,
        ));
        
        if (empty($inform)) {
            $inform = new InformconsentT();
            $inform->informasi_tindakan_medis = array();
        } else {
            $inform->informasi_tindakan_medis = CJSON::decode($inform->informasi_tindakan_medis);
        }
        
        $this->render($this->path_view.'print', array(
            'modPendaftaran'=>$modPendaftaran,
            'model'=>$model,
            'inform'=>$inform,
        ));
    }
    
    
}
