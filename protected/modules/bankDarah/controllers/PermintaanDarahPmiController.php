<?php

/**
 * Proses permintaan darah ke PMI.
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class PermintaanDarahPmiController extends MyAuthController 
{
    /**
     * Default menu transaksi permintaan darah PMI
     * @param integer $permintaandarahpmi_id
     */
    public function actionIndex($permintaandarahpmi_id = null){
        $format = new MyFormatter;
        $model = new BDPermintaandarahpmiT;
        $modDetail = new BDPermintaandarahpmidetT;
        $arrDetail = array();
        
        $model->tgl_permintaan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->no_permintaan = "-- Otomatis --";
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $ruangan = RuanganM::model()->findByPk($model->ruangan_id);
        $model->petugas_id = Yii::app()->user->getState('pegawai_id');
        $petugas = PegawaiM::model()->findByPk($model->petugas_id);
        $model->petugas_nama = $petugas->namaLengkap;
        $model->ruangan_nama = $ruangan->ruangan_nama;
        $model->instalasi_id = $ruangan->instalasi_id;
        $model->instalasi_nama = $ruangan->instalasi->instalasi_nama;
        
        if(!empty($permintaandarahpmi_id)){
            $model = BDPermintaandarahpmiT::model()->findByPk($permintaandarahpmi_id);
            $model->ruangan_nama = $model->ruangan->ruangan_nama;
            $model->instalasi_nama = $model->ruangan->instalasi->instalasi_nama;
            $model->petugas_nama = $model->petugas->nama_pegawai;
            
            $arrDetail = BDPermintaandarahpmidetT::model()->findAllByAttributes(array('permintaandarahpmi_id'=>$permintaandarahpmi_id));
        }

        if(isset($_POST['BDPermintaandarahpmiT'])){
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try{
                $model->attributes = $_POST['BDPermintaandarahpmiT'];
                //$model->no_permintaan_pmi = $_POST['BDPermintaandarahpmiT']['no_permintaan_pmi'];
                $model->tgl_permintaan = $format->formatDateTimeForDb($model->tgl_permintaan);
                $model->no_permintaan = MyGenerator::noPermintaanKantongDarahPmi();
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_time = date ('Y-m-d H:i:s');
                if($model->save()){
                    if(isset($_POST['BDPermintaandarahpmidetT'])){
                        foreach ($_POST['BDPermintaandarahpmidetT'] as $key => $value) {
                            $modDetail = new BDPermintaandarahpmidetT;
                            $modDetail->attributes = $value;
                            $modDetail->rhesus = CustomFunction::cekNamaRhesus($modDetail->rhesus);
                            $modDetail->permintaandarahpmi_id = $model->permintaandarahpmi_id;
                            //$modDetail->tgl_perlu = $format->formatDateTimeForDb($modDetail->tgl_perlu);
                            if($modDetail->save()){
                                $ok &= true;
                            }else{
                                $ok &= false;
                            }
                        }
                    }
                }else{
                    $ok &= false;
                }
                
                if($ok){                                                                                                                                                                        
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('index', 'permintaandarahpmi_id' => $model->permintaandarahpmi_id, 'sukses'=>1));       
                }else{      
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ");
            }
        }
        
        $this->render('index',array(
            'format'=>$format,
            'model'=>$model,
            'modDetail'=>$modDetail,
            'arrDetail'=>$arrDetail
        ));
    }
}

