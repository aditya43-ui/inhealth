<?php

class PenulisanResepController extends MyAuthController
{
  public $reseptur_id;
  public $successSave = false;
  public function actionIndex()
  {
    $modPendaftaran = new FAPendaftaranT;
    $modReseptur = new FAResepturT;
    $modPasien = new FAPasienM;
    $modInfoRI = new FAInfopasienmasukkamarV;
    $modResepturDetail = new FAResepturDetailT;

    if (isset($_GET['reseptur_id'])) {
      $modReseptur = FAResepturT::model()->findByPk($_GET['reseptur_id']);
      $modObatAlkesPasien = FAObatalkesPasienT::model()->findByAttributes(array('pendaftaran_id' => $modReseptur->pendaftaran_id));
      $modResepturDetail = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $_GET['reseptur_id']));
      $modPendaftaran = FAPendaftaranT::model()->findByPk($modReseptur->pendaftaran_id);
    }

    if (isset($_POST['FAResepturT'])) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $this->saveReseptur($_POST, $modPendaftaran);
        if ($this->successSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Resep berhasil disimpan");
          //                        $this->redirect(array('index', 'status'=>1, 'pendaftaran_id'=>$pendaftaran_id, 'smspasien'=>$smspasien));
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'reseptur_id' => $this->reseptur_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          $this->redirect(array('index', 'status' => 2, 'pendaftaran_id' => $pendaftaran_id));
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();

        $this->redirect(array('index', 'status' => 2, 'pendaftaran_id' => $pendaftaran_id));
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modReseptur' => $modReseptur,
      'modInfoRI' => $modInfoRI,
      'modResepturDetail' => $modResepturDetail,
    ));
  }

  protected function saveReseptur($post)
  {

    $reseptur = new FAResepturT;
    $reseptur->pendaftaran_id = $post['pendaftaran_id'];
    $reseptur->tglreseptur = $post['FAResepturT']['tglreseptur'];
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $reseptur->noresep = MyGenerator::noResep($instalasi_id);
    $reseptur->noresep_depan = MyGenerator::noResepReseptur($instalasi_id);
    $reseptur->noresep_depan = $reseptur->noresep_depan . '/';
    $reseptur->noresep = $reseptur->noresep_depan . "" . (isset($post['FAResepturT']['noresep_belakang']) ? $post['FAResepturT']['noresep_belakang'] : '');
    $reseptur->pegawai_id = $post['FAResepturT']['pegawai_id'];
    $reseptur->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $reseptur->ruanganreseptur_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $reseptur->pasien_id = $post['pasien_id'];
    $reseptur->pasienadmisi_id = !empty($post['pasienadmisi_id']) ? $post['pasienadmisi_id'] : null;
    $reseptur->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $reseptur->create_loginpemakai_id = Yii::app()->user->id;
    if ($reseptur->validate()) {
      $reseptur->save();
      $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $post['pendaftaran_id'], 'ruangan_id' => isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id')));
      if (!empty($konsulPoli)) {
        $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
      }
      $modReseptur = $this->saveDetailReseptur($post, $reseptur);
    } else {
      $this->successSave = false;
    }
  }

  protected function saveDetailReseptur($post, $reseptur)
  {
    $valid = true;
    foreach ($post['FAResepturDetailT'] as $i => $detailreseptur) {
      $detail = new FAResepturDetailT;

      $detail->reseptur_id = $reseptur->reseptur_id;
      $detail->attributes = $detailreseptur;
      $detail->signa_reseptur = $post['signa'];
      $detail->iter = $detailreseptur['iter'];
      $detail->satuansediaan = $detailreseptur['satuansediaan'];
      $this->reseptur_id = $reseptur->reseptur_id;
      $valid = $detail->validate() && $valid;
      if ($valid) {
        $detail->save();
      }
    }

    $this->successSave = ($valid) ? true : false;
  }


  public function actionGetDataInfoPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      if (!empty($instalasi_id)) {
        $criteria->addCondition("instalasi_id = " . $instalasi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $model = FAInfoKunjunganRDV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $model = FAInfoKunjunganRJV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $model = FAInfopasienmasukkamarV::model()->find($criteria);
      }
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new FAPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionAutoCompleteTherapiObat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = $_GET['term'];
      $criteria = new CDbCriteria();
      $criteria->addCondition("therapiobat_nama ILIKE '%" . $term . "%'");
      $criteria->addCondition('therapiobat_aktif = true');
      $models = FATherapiobatM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();

        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->therapiobat_nama;
        $returnVal[$i]['value'] = $model->therapiobat_id;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionSetTherapiobatid()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $modTherapi = FATherapimapobatM::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id));
      if (!empty($modTherapi)) {
        $data = $modTherapi->therapiobat_id;
      } else {
        $data = null;
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $isRacikan = $_POST['isRacikan'];
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $therapiobat_id = isset($_POST['therapiobat_id']) ? $_POST['therapiobat_id'] : null;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modResepturDetail = new FAResepturDetailT;
      $jmlStok = StokobatalkesT::getJumlahStok($obatalkes_id, $ruangan_id);

      $modObatAlkes = FAObatalkesM::model()->findByPk($obatalkes_id);
      if ($jmlStok > 0) {
        $modResepturDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
        $modResepturDetail->sumberdana_id = $modObatAlkes->sumberdana_id;
        $modResepturDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
        $modResepturDetail->racikan_id = ($isRacikan == 0) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
        $modResepturDetail->r = 'R/';
        $modResepturDetail->qty_reseptur = $jumlah;
        $modResepturDetail->jmlstok = $jmlStok;
        $modResepturDetail->kekuatan_reseptur = $modObatAlkes->kekuatan;
        $modResepturDetail->satuankekuatan = $modObatAlkes->satuankekuatan;

        $modResepturDetail->hargasatuan_reseptur = $modObatAlkes->hargajual;
        $modResepturDetail->harganetto_reseptur = $modObatAlkes->harganetto;
        $modResepturDetail->hargajual_reseptur = $modObatAlkes->hargajual * $modResepturDetail->qty_reseptur;
        $modResepturDetail->therapiobat_id = $therapiobat_id;

        //                $modResepturDetail->permintaan_reseptur = $post['jmlpermintaan'][$i];
        //                $modResepturDetail->jmlkemasan_reseptur = $post['jmlkemasan'][$i];

        $form .= $this->renderPartial('_rowDetail', array('modResepturDetail' => $modResepturDetail), true);
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $criteria = new CDbCriteria;
    $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
    $maxtime = FAResepturT::model()->find($criteria);
    $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
    $modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modReseptur = FAResepturT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $judulLaporan = '';

    $criteriakl = new CDbCriteria;
    $criteriakl->addCondition("reseptur_t.pendaftaran_id = " . $pendaftaran_id);
    $criteriakl->select = 'racikan_id, rke, iter, reseptur_t.reseptur_id';
    $criteriakl->group = 'racikan_id, rke, iter, reseptur_t.reseptur_id';
    $criteriakl->join = 'join reseptur_t on reseptur_t.reseptur_id = t.reseptur_id';
    $criteriakl->order = 'rke';
    $kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);

    $caraPrint = $_REQUEST['caraPrint'];
    if (isset($_GET['idReseptur'])) {
      $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $_GET['idReseptur']));
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('_viewDetailResep', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDetailResep' => $modDetailResep));
      }
    } else {
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('Print', array(
          'modPendaftaran' => $modPendaftaran,
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint,
          "modDetailResep" => $modDetailResep,
          'modReseptur' => $modReseptur,
          'kerangkaLooping' => $kerangkaLooping
        ));
      }
    }
  }
}
