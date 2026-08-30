<?php

/**
 * digunakan untuk transaksi corrective maintenance
 * @author       Elham Budianto <elhambudianto@.com>
 * @author       Rusdiyanto <rusdiyanto@.com>
 * @package      application.modules.manajemenAset
 * @subpackage   controllers
 * */
class CorrectiveMaintenanceController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'manajemenAset.views.correctiveMaintenance.';

    /**
     * Menampilkan transaksi corrective maintenance
     */
    public function actionIndex($id=null) {
        $model = new MAKorektifmaintenT();
        $format = new MyFormatter();
        
        if (!empty($id)){
            $model = MAKorektifmaintenT::model()->findByPk($id);
            $model->korektifmainten_tgl = MyFormatter::formatDateTimeForUser($model->korektifmainten_tgl);
            $model->lokasiaset_namalokasi = !empty($model->lokasi->lokasiaset_namalokasi)?$model->lokasi->lokasiaset_namalokasi:'';            
            $model->invperalatan_namabrg = $model->invperalatan->invperalatan_namabrg;
            $model->invperalatan_kode = $model->invperalatan->invperalatan_kode;
        }else{
            $model->korektifmainten_tgl = date('Y-m-d');
            $modLogiPemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
            $model->pegpemohon_id = $modLogiPemakai->pegawai_id;
        }

        if (isset($_POST['MAKorektifmaintenT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['MAKorektifmaintenT'];
                $model->korektifmainten_tgl = $format->formatDateTimeForDb($_POST['MAKorektifmaintenT']['korektifmainten_tgl']);
                $model->ruanganpemohon_id = Yii::app()->user->getState('ruangan_id');
                $model->korektifmainten_no = MyGenerator::noCorrectiveMaintenance();
                $model->korektifmainten_status = ParamsConst::STATUSDOKUMENOPEN;
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_time = date('Y-m-d H:i:s');
                $model->lokasi_id = $model->invperalatan->lokasi_id;
                $ok = $ok && $model->save();
                if ($ok) {
                    $judul = 'Permintaan Corrective Maintenance';
                    $isi = 'Peralatan '.$model->invperalatan->invperalatan_namabrg.' dengan kode '.$model->invperalatan->invperalatan_kode.' yang berada di '.$model->lokasi->lokasiaset_namalokasi.' membutuhkan maintenance';
                    $link_proses = $this->module->id . "/InfoCorrectiveMaintenance/Index";

                    $modRI = RuanganM::model()->findByPk(ParamsConst::RUANGAN_ID_SARANA_MEDIK_I);
                    $modRII = RuanganM::model()->findByPk(ParamsConst::RUANGAN_ID_SARANA_MEDIK_II);

                    $notif = [];
                    if (!empty($modRI)){
                        $notif[] = [
                            'instalasi_id' => $modRI->instalasi_id, 
                            'ruangan_id' => $modRI->ruangan_id, 
                            'modul_id' => ParamsConst::MODUL_ID_MANAJEMEN_ASET, 
                            'link_proses' => $link_proses
                        ];
                    }

                    if (!empty($modRII)){
                        $notif[] = [
                            'instalasi_id' => $modRII->instalasi_id, 
                            'ruangan_id' => $modRII->ruangan_id, 
                            'modul_id' => ParamsConst::MODUL_ID_MANAJEMEN_ASET, 
                            'link_proses' => $link_proses
                        ];
                    }
                    
                    if (!empty($notif)){
                        CustomFunction::broadcastNotif($judul, $isi, $notif);
                    }
                    
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'sukses' => 1,'id'=>$model->korektifmainten_id));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                $path = $this->path_view;
                if ($ajax == 'dialoginvperalatan-m-grid'){
                    $path .= 'grid/_no_aset';
                }else if ($ajax == 'lokasi-grid'){
                    $path .= 'grid/_lokasi';
                }else if ($ajax == 'dialoginvperalatanjnsperalatan-m-grid'){
                    $path .= 'grid/_jenis_peralatan';
                }
                
                $this->render($path, array(
                    'model' => $model,
                    'format' => $format,
                ));
            }
        }else{        
            $this->render($this->path_view . 'index', array(
                'model' => $model,
                'format' => $format,
            ));
        }
    }

}
