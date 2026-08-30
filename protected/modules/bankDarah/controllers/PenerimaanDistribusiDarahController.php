<?php
/**
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class PenerimaanDistribusiDarahController extends MyAuthController {
    public $path_view ='bankDarah.views.penerimaanDistribusiDarah.';
    
    /**
     * digunakan untuk insert data
     * @param integer $distribusidarah_id
     * @param integer $terimadistribusidarah_id
     * @param string $link
     */
    public function actionIndex($distribusidarah_id = null,$terimadistribusidarah_id = null,$link=null){
        $format = new MyFormatter();
        if(empty($terimadistribusidarah_id)) {
            $model = new BDTerimadistribusidarahT();
            $model->tgl_terima = date('Y-m-d H:i:s');
            $model->nomor_terima = '-- Otomatis --';
            $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $model->petugas_nama = $modPegawai->namaLengkap;
            $model->petugasdistribusi_pelayanandarah = $modPegawai->pegawai_id;
        }else{
            $model = BDTerimadistribusidarahT::model()->findByPk($terimadistribusidarah_id); 
            $modDetail = DistribusidarahdetT::model()->findAllByAttributes(array('terimadistribusidarah_id'=>$terimadistribusidarah_id));
        }
        
        
        if(isset($_POST['BDTerimadistribusidarahT'])) {
            $simpan_terima = false;
            $update_distribusi = false;
            $update_stok = false;
            $update_kantong = false;
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['BDTerimadistribusidarahT'];
                $model->nomor_terima = $_POST['BDTerimadistribusidarahT']['nomor_terima'];
                $model->tgl_terima = $format->formatDateTimeForDb($_POST['BDTerimadistribusidarahT']['tgl_terima']);
                $model->create_time = date('Y-m-d H:i:s');
                $model->nomor_terima = MyGenerator::NoPenerimaanDistribusiDarah();
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->ruangan_id;
                // echo '<pre>';var_dump($_POST);die;
                if($model->save()) {
                if(isset($_POST['DistribusidarahdetT'])) {
                    if(count($_POST['DistribusidarahdetT']) > 0) {
                        foreach ($_POST['DistribusidarahdetT'] as $data) {
                            if($data['checklist'] == 1) {
                            $updateDistribusi = DistribusidarahdetT::model()->findByPk($data['distribusidarahdet_id']);
                            $updateDistribusi->terimadistribusidarah_id = $model->terimadistribusidarah_id;                          
                            if($updateDistribusi->update()) {
                                $update_distribusi = true;
                                $Kantongdarah = KantongdarahT::model()->findByAttributes(array('no_kantongdarah'=>$updateDistribusi->nomorbarcode));
                                $modLulus = LuluskomponendarahT::model()->findByAttributes(['kantongdarah_id' => $Kantongdarah->kantongdarah_id]);
                                $modStokKantong = new StokkantongdarahT();
                                $modStokKantong->kantongdarah_id = $Kantongdarah->kantongdarah_id ?? null;
                                $modStokKantong->komponendarah_id = $Kantongdarah->komponendarah_id ?? null;
                                $modStokKantong->luluskomponendarah_id = $modLulus->luluskomponendarah_id ?? null;
                                $modStokKantong->jeniskantongdarah_id = $updateDistribusi->jeniskantongdarah_id;
                                $modStokKantong->nomorbarcode = $updateDistribusi->nomorbarcode;
                                $modStokKantong->jmlkantongdarah = 1;
                                $modStokKantong->golongan_darah = $updateDistribusi->golongan_darah;
                                $modStokKantong->rhesus = $updateDistribusi->rhesus;
                                $modStokKantong->distribusidarah_id = $updateDistribusi->distribusidarah_id;
                                $modStokKantong->distribusidarahdet_id = $updateDistribusi->distribusidarahdet_id;
                                $modStokKantong->ruangan_id = Yii::app()->user->ruangan_id;
                                $modStokKantong->create_time = date('Y-m-d H:i:s');
                                $modStokKantong->create_loginpemakai_id = Yii::app()->user->id;
                                $modStokKantong->create_ruangan = Yii::app()->user->ruangan_id;
                                if($modStokKantong->save()) {
                                    $update_stok = true;
                                }
                            }  
                            }
                        }
                    }
                }
                $simpan_terima = true;
                }
                die;
                if ($simpan_terima == true || $update_distribusi == true || $update_stok == true) {
                    $transaction->commit();
                    $model->isNewRecord = false;
                    if(empty($link)){
                        $this->redirect(array('index','distribusidarah_id'=>$updateDistribusi->distribusidarah_id,'terimadistribusidarah_id'=>$model->terimadistribusidarah_id,'sukses'=>1));
                    }else{
                        $this->redirect(array('/bankDarah/InformasiDistribusiDarah/index','sukses'=>1));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Penerimaan Distribusi kantong Darah gagal disimpan !");
                    $this->redirect(array('index','distribusidarah_id'=>$updateDistribusi->distribusidarah_id));
                }
                
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Penerimaan Distribusi Pelayanan Darah gagal disimpan ! ".MyExceptionMessage::getMessage($exc,true));
            }
            
            
        }
        if(empty($terimadistribusidarah_id)) {
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'model'=>$model,
            'distribusidarah_id'=>$distribusidarah_id
        ));
        }else{
             $this->render($this->path_view.'index',array(
            'format'=>$format,
            'model'=>$model,
            'distribusidarah_id'=>$distribusidarah_id,
            'modDetail'=>$modDetail,
            'link'=>$link,
            ));
        }
    }
    
    /**
     * digunakan untuk select data distribusi kantong
     */
    public function actionGetData() {
        if(Yii::app()->request->isAjaxRequest){
            $distribusi_id = isset($_POST['distribusi_id']) ? $_POST['distribusi_id'] : ' ';
            $format = new MyFormatter();
              if($distribusi_id != ' ') {
                  $modDistribusi = DistribusidarahT::model()->findByPk($distribusi_id);
                  $modPegawaiDistribusi = PegawaiM::model()->findByPk($modDistribusi->petugasdistribusi_id);
                  $modPetugasKoordinator = PegawaiM::model()->findByPk($modDistribusi->petugaskoordinator_id);
                  $modInstalasi = InstalasiM::model()->findByPk($modDistribusi->instalasi_id);
                  $modRuangan = RuanganM::model()->findByPk($modDistribusi->ruangan_id);
                  $data['tgl_distribusi'] = $format->formatDateTimeForUser($modDistribusi->tgl_distribusi);
                  $data['shift_distribusi'] = $modDistribusi->shift_distribusi;
                  $data['keterangan_distribusi'] = $modDistribusi->ketrangan_distribusi;
                  $data['petugasdistribusi'] = $modPegawaiDistribusi->nama_pegawai;
                  $data['petugaskoordinator'] = $modPetugasKoordinator->nama_pegawai;
                  $data['instalasi'] = $modInstalasi->instalasi_nama;
                  $data['ruangan'] = $modRuangan->ruangan_nama;
                  $data['sukses'] = true;
     
              }
            
            echo json_encode($data);
            Yii::app()->end();
        }   
    }
    
    /**
     * digunakan untuk get data detail
     */
    public function actionGetDetail() {
        if(Yii::app()->request->isAjaxRequest) {
            $distribusidarah_id = isset($_POST['distribusidarah_id']) ? $_POST['distribusidarah_id'] : ' ';
            $modDistribusiDetail = DistribusidarahdetT::model()->findAllByAttributes(array('distribusidarah_id'=>$distribusidarah_id,'terimadistribusidarah_id'=>null));
            $format = new MyFormatter();
            $no = 1;
            $i = 0;
            $tr ='';
            if(count($modDistribusiDetail) > 0) {
                foreach($modDistribusiDetail as $data) {
                    $modDetail = new DistribusidarahdetT();
                    $modDetail->distribusidarahdet_id = $data->distribusidarahdet_id;
                    $komponenDarah = KomponendarahM::model()->findByPk($data->komponendarah_id);
                    $jenisKantong = JeniskantongdarahM::model()->findByPk($data->jeniskantongdarah_id);
                    $tr .=  $this->renderPartial($this->path_view.'_rowPengirimanDistribusi',array(
                            'modDetail'=>$modDetail,
                            'data'=>$data,
                            'komponenDarah'=>$komponenDarah,
                            'jenisKantong'=>$jenisKantong,
                            'format'=>$format,
                            'no'=>$no,
                            'i'=>$i,
                    ),true);
                    $no++;
                    $i++;
                }   
            }
            echo json_encode($tr);
            Yii::app()->end();
        }        
    }
    
     /**
     * digunakan untuk autocomplete pegawai
     */
     public function actionAutocompletePetugas()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama), true);;
            $criteria->addCondition('ruangan_id ='.Yii::app()->user->ruangan_id);
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai." - ".$model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}

