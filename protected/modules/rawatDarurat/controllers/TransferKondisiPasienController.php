<?php
class TransferKondisiPasienController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.transferKondisiPasien.';
    public $tersimpan = false;
    
    public function actionIndex($pendaftaran_id, $prosestransferpasien_id = null)
    {
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");
        $pasienadmisi_id = null;
        $modDetails = array();
        
        if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_IBS){
            $modPendaftaran = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
            $pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        }
        
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        if(isset($modAdmisi)){
            if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI){
                $pasienadmisi_id = $modAdmisi->pasienadmisi_id;
            }
        }
        
        $modAsesmenAwalKep = AsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'create_ruangan_id'=>$ruangan_id));
        $modEwsPasien = EwspasienT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'create_ruangan_id'=>$ruangan_id));
        
        if(!empty($prosestransferpasien_id)){
            $model = RDProsestransferpasienT::model()->findByPk($prosestransferpasien_id);
             $modDetails = PegawaipendampingtransferpasienT::model()->findAllByAttributes(array('prosestransferpasien_id'=>$prosestransferpasien_id));
             $model->sebelumtransfer_tanggal = MyFormatter::formatDateTimeForUser($model->sebelumtransfer_tanggal);
        }else{
            $model = new RDProsestransferpasienT();
            $model->sebelumtransfer_tanggal = date('d M Y H:i:s');
            
            if(isset($modAsesmenAwalKep)){
                $model->sebelumtransfer_keadaanumum = $modAsesmenAwalKep->kondisiumum;
                $model->sebelumtransfer_kesadaran = $modAsesmenAwalKep->kesadaranpasien;
                $model->sebelumtransfer_td_systolic = $modAsesmenAwalKep->td_systolic;
                $model->sebelumtransfer_td_diastolic = $modAsesmenAwalKep->td_diastolic;
                $model->sebelumtransfer_suhutubuh = $modAsesmenAwalKep->suhutubuh;
                $model->sebelumtransfer_nadi = $modAsesmenAwalKep->detaknadi;
            }
            
            if(isset($modEwsPasien)){
                $model->sebelumtransfer_skorews = $modEwsPasien->total_skor;
                $model->sebelumtransfer_klasifikasi_skorews = $modEwsPasien->klasifikasi;
            }
        }
        
        $modTransferLembarPasien = FormtransferpasienT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'create_ruangan_id'=>$ruangan_id));
        
        if(isset($modTransferLembarPasien)){
            $model->formtransferpasien_id = $modTransferLembarPasien->formtransferpasien_id;
        }

        if(isset($_POST['RDProsestransferpasienT'])){
            $transaction = Yii::app()->db->beginTransaction();
            
            try {
                $model->attributes = $_POST['RDProsestransferpasienT'];
                $model->sebelumtransfer_tanggal = (!empty($_POST['RDProsestransferpasienT']['sebelumtransfer_tanggal'])? MyFormatter::formatDateTimeForDb($_POST['RDProsestransferpasienT']['sebelumtransfer_tanggal']) : null);
                $model->sebelumtransfer_keadaanumum = isset($_POST['RDProsestransferpasienT']['sebelumtransfer_keadaanumum']) ? ((count($_POST['RDProsestransferpasienT']['sebelumtransfer_keadaanumum'])>0) ? implode(', ', $_POST['RDProsestransferpasienT']['sebelumtransfer_keadaanumum']) : '') : '';
                
                if(!empty($model->prosestransferpasien_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                
                
                if($model->save()){
                    
                    $detailSimpan = true;
                    if(isset($_POST['PegawaiPendamping']) && count($_POST['PegawaiPendamping']) > 0){
                        PegawaipendampingtransferpasienT::model()->deleteAllByAttributes(array('prosestransferpasien_id'=>$model->prosestransferpasien_id));
                        foreach ($_POST['PegawaiPendamping'] as $dataPendamping){
                            $modDetail = new PegawaipendampingtransferpasienT();
                            $modDetail->attributes = $dataPendamping;
                            $modDetail->prosestransferpasien_id = $model->prosestransferpasien_id;
                            
                            if(!$modDetail->save()){
                                $detailSimpan = false;
                            }
                        }
                    }
                    $this->tersimpan = $detailSimpan;
                }else{
                    $this->tersimpan = false;
                }
                
                 if($this->tersimpan == true){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1,'type'=>$_GET['type'],'frame'=>$_GET['frame']));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan!");
                }  
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
            }
        }
        
        $this->render($this->path_view.'index',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model,
            'modDetails'=>$modDetails
        ));
    }
    
    public function actionAutoCompletePetugasPendamping()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    
    public function actionMasterKeadaanUmum() 
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']),true);
            $criteria->order = "keadaanumum_nama ASC";
            $keluhans = KeadaanumumM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key'=>$keluhan->keadaanumum_nama,
                                  'value'=>$keluhan->keadaanumum_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
    public function actionDetail($prosestransferpasien_id) 
    {
        $model = RDProsestransferpasienT::model()->findByPk($prosestransferpasien_id);
        $this->layout='//layouts/iframe';
        $this->render($this->path_view.'detailKondisiPasien',array('model'=>$model)); 
    } 
}
