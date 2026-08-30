<?php

class RekonsiliasiObatAdmisiController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatJalan.views.rekonsiliasiObatAdmisi.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id = null) {
      $modPendaftaran= RJPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $ruangan_id = Yii::app()->user->getState("ruangan_id");
      $modPenanggungJawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
      if(empty($modPenanggungJawab)){
        $modPenanggungJawab = new PenanggungjawabM();
      }

      $model = new RekonobatadmisiT();
      $model->tanggal_pengisian = date('d M Y');
      $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $model->pasien_id = $modPasien->pasien_id;
      $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        if (isset($_POST['RekonobatadmisiT']) && isset($_POST['RekonobatadmisidetT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
              $model = new RekonobatadmisiT();
              $model->attributes = $_POST['RekonobatadmisiT'];
              $model->tanggal_pengisian = MyFormatter::formatDateTimeForDb($_POST['RekonobatadmisiT']['tanggal_pengisian']);
              if (!empty($model->rekonobatadmisi_id)) {
                  $model->update_time = date('Y-m-d H:i:s');
                  $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
              } else {
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
              }
              $model->create_ruangan = Yii::app()->user->getState("ruangan_id");

              $tersimpanData = true;
              if($model->save()){
                $this->tersimpan = true;
                  if(count($_POST['RekonobatadmisidetT']) > 0){
                    foreach ($_POST['RekonobatadmisidetT'] as $dataDet) {
                      $modDet = new RekonobatadmisidetT();
                      $modDet->attributes = $dataDet;
                      $modDet->waktu_pemberian = (!empty($dataDet['waktu_pemberian'])? MyFormatter::formatDateTimeForDb($dataDet['waktu_pemberian']) : null);
                      $modDet->rekonobatadmisi_id = $model->rekonobatadmisi_id;

                      if (!empty($modDet->rekonobatadmisidet_id)) {
                          $modDet->update_time = date('Y-m-d H:i:s');
                          $modDet->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                      } else {
                          $modDet->create_time = date('Y-m-d H:i:s');
                          $modDet->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                      }
                      $modDet->create_ruangan = Yii::app()->user->getState("ruangan_id");

                      if(!$modDet->save()){
                        $tersimpanData = false;
                      }
                    }
                  }
              }else{
                $this->tersimpan = false;
              }

              if($this->tersimpan == true && $tersimpanData == true){
                $transaction->commit();
                 Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                 $this->redirect(array('index','pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
              }else{
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan!");
              }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modPenanggungJawab'=>$modPenanggungJawab
        ));
    }

    public function actionAutocompletePegawaiRuangan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->addCondition("ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->NamaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAutocompleteObatPelayanan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            $pasienadmisi_id = null;

            if(isset($_GET['instalasi_id']) && $_GET['instalasi_id'] == Params::INSTALASI_ID_RI){
              $pasienadmisi_id = $_GET['pasienadmisi_id'];
            }

            $criteria = new CDbCriteria;
        		$criteria->select = "oa.obatalkes_kode, oa.obatalkes_nama, oa.obatalkes_namalain";
        		$criteria->group = $criteria->select;
        		$criteria->join = "JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id ".
            "JOIN penjualanresep_t penj ON penj.penjualanresep_id = t.penjualanresep_id ";
        		$criteria->order = "oa.obatalkes_nama ASC";

            if(!empty($_GET['pendaftaran_id'])){
        			$criteria->addCondition('t.pendaftaran_id = '.$_GET['pendaftaran_id']);
        		}

        		if(!empty($pasienadmisi_id)){
        			$criteria->addCondition('t.pasienadmisi_id = '.$pasienadmisi_id);
        		}

            if(!empty($_GET['ruangan_nama'])){
        			$criteria->compare('LOWER(penj.ruanganasal_nama)',strtolower($_GET['ruangan_nama']),true);
        		}

            $criteria->limit = 5;
            $models = RJObatalkesPasienT::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->obatalkes_nama;
                $returnVal[$i]['value'] = $model->obatalkes_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
