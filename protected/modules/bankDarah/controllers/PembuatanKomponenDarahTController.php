<?php

/**
 * digunakan sebagai Transaksi Pembuatan Komponen Darah
 * 
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class PembuatanKomponenDarahTController extends MyAuthController
{
  /**
   * action ini digunakan untuk masuk ke transaksi pembuatan komponen
   * @param type $id
   * @param type $periksakomponendarah_id
   */
  public function actionIndex($id = null, $periksakomponendarah_id = null)
  {
    $model = new PeriksakomponendarahT();
    $modKantong = new InfokantongdarahV();
    $model->petugasperiksakomp_id = Yii::app()->user->getState('pegawai_id');
    $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    $model->petugasperiksakomp_nama = $pegawai->namaLengkap;
    $model->terimakantongdarah_id = $modKantong->terimakantongdarah_id;
    $modKomponenDarah = new KomponendarahM();
    $modelKantongDetail = new KantongdarahT();
    $model->tglkadaluarsa = date("d M Y H:i:s", strtotime("+30 days"));
    /* Deklarasi nilai awal */
    $model->komponen_wb = 'BERHASIL';
    $model->komponen_ffp = 'BERHASIL';
    $model->komponen_prc = 'BERHASIL';
    $model->komponen_tc = 'BERHASIL';
    $model->komponen_pcr = 'BERHASIL';
    /* Load data kantong darah dan komponen */
    if (!empty($id)) {
      $modKantong = InfokantongdarahV::model()->findByAttributes(array('no_kantongdarah' => $id));
      $modelKantongDetail = KantongdarahT::model()->findByAttributes(array('no_kantongdarah' => $id));
      $modKantong->daftarpendonor_id = $modelKantongDetail->daftarpendonor_id;
      $modKomponenDarah = KomponendarahM::model()->findByPk($modelKantongDetail->komponendarah_id);
      $modTerima = TerimakantongdetT::model()->findByAttributes(array('terimakantongdarah_id' => $modelKantongDetail->terimakantongdarah_id));
    }

    /* Load data sesudah submit */
    if (isset($_GET['periksakomponendarah_id'])) {
      $model = PeriksakomponendarahT::model()->findByPk($_GET['periksakomponendarah_id']);
      $model->petugasperiksakomp_nama = $model->pegawai->NamaLengkap;
    }

    //assign data ke model
    if (isset($_POST['PeriksakomponendarahT'])) {
      try {
        $model->attributes = $_POST['PeriksakomponendarahT'];
        if ($modKomponenDarah->komponendarah_id == 7) {
          $model->komponen_wb = $_POST['PeriksakomponendarahT']['komponen_wb'];
          $model->komponen_ffp = 'NONE';
          $model->komponen_prc = 'NONE';
          $model->komponen_tc = 'NONE';
          $model->komponen_pcr = 'NONE';
        } else if ($modKomponenDarah->komponendarah_id == 8 || $modKomponenDarah->komponendarah_id == 10) {
          $model->komponen_wb = 'NONE';
          $model->komponen_ffp = 'NONE';
          $model->komponen_prc = $_POST['PeriksakomponendarahT']['komponen_prc'];
          $model->komponen_tc = 'NONE';
          $model->komponen_pcr = 'NONE';
        } else if ($modKomponenDarah->komponendarah_id == 9 || $modKomponenDarah->komponendarah_id == 11 || $modKomponenDarah->komponendarah_id == 13) {
          $model->komponen_wb = 'NONE';
          $model->komponen_ffp = $_POST['PeriksakomponendarahT']['komponen_ffp'];
          $model->komponen_prc = 'NONE';
          $model->komponen_tc = 'NONE';
          $model->komponen_pcr = 'NONE';
        } else if ($modKomponenDarah->komponendarah_id == 14 || $modKomponenDarah->komponendarah_id == 12) {
          $model->komponen_wb = 'NONE';
          $model->komponen_ffp = 'NONE';
          $model->komponen_prc = 'NONE';
          $model->komponen_tc = $_POST['PeriksakomponendarahT']['komponen_tc'];
          $model->komponen_pcr = 'NONE';
        } else if ($modKomponenDarah->komponendarah_id == 15) {
          $model->komponen_wb = 'NONE';
          $model->komponen_ffp = 'NONE';
          $model->komponen_prc = 'NONE';
          $model->komponen_tc = 'NONE';
          $model->komponen_pcr = $_POST['PeriksakomponendarahT']['komponen_pcr'];
        }

        /* Ambil penerimaan kantong - transaksi komponen darah langsung */
        if (!empty($id)) {
          $modTerima = TerimakantongdetT::model()->findByAttributes(array('nobarcodekantong' => $id, 'terimakantongdarah_id' => $modKantong->terimakantongdarah_id));
          $model->terimakantongdet_id = $modTerima->terimakantongdet_id;
          $model->asalruangan_id = $modKantong->ruangancatat_id;
        } else {
          $modTerima = TerimakantongdetT::model()->findByAttributes(array('nobarcodekantong' => $_POST['InfokantongdarahV']['nomorbarcode'], 'terimakantongdarah_id' => $_POST['InfokantongdarahV']['terimakantongdarah_id']));
          $model->terimakantongdet_id = $modTerima->terimakantongdet_id;
          $model->asalruangan_id = $_POST['InfokantongdarahV']['ruangancatat_id'];
        }

        $model->kantongdarah_id = $_POST['InfokantongdarahV']['kantongdarah_id'];
        $model->shift_id = Yii::app()->user->getState('shift_id');
        $model->tglkadaluarsa = MyFormatter::formatDateTimeForDb($model->tglkadaluarsa);
        $model->tglperiksakompdarah = MyFormatter::formatDateTimeForDb($_POST['PeriksakomponendarahT']['tglperiksakompdarah']);
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->create_time = date('Y-m-d H:i:s');

        if ($model->validate()) {
          $model->save();
          $modelKantongDetail->periksakomponendarah_id = $model->periksakomponendarah_id;
          $modelKantongDetail->save();
          if (isset($_GET['frame'])) {
            $this->redirect(array('index', 'id' => $id, 'periksakomponendarah_id' => $model->periksakomponendarah_id, 'frame' => 1, 'sukses' => 1));
          } else {
            $this->redirect(array('index', 'id' => $modKantong->no_kantongdarah, 'periksakomponendarah_id' => $model->periksakomponendarah_id, 'sukses' => 1));
          }
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $ex) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render(
      'index',
      array(
        'model' => $model,
        'modKantong' => $modKantong,
        'modKomponenDarah' => $modKomponenDarah,
        'modelKantongDetail' => $modelKantongDetail,
      )
    );
  }

  /**
   * mencari data pegawai, sesuai yang di ketikkan
   */
  public function actionAutoCompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition('instalasi_id = ' . Yii::app()->user->getState('instalasi_id'));
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawairuanganV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * mencari data pegawai
   */
  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = PegawaiM::model()->findByAttributes(array('pegawai_id' => $_POST['idPegawai']));
      $post = array(
        'namaLengkap' => $data->namaLengkap,
        'pegawai_id' => $data->pegawai_id,
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  /**
   * Load halaman detail 
   * @param type $no_kantongdarah
   */
  public function actionDetail($no_kantongdarah)
  {
    $this->layout = '//layouts/iframe';
    $modKantong = InfokantongdarahV::model()->findByAttributes(array('no_kantongdarah' => $no_kantongdarah));

    $model = PeriksakomponendarahT::model()->findByAttributes(array('kantongdarah_id' => $modKantong->kantongdarah_id));
    $modelKantongDarah = KantongdarahT::model()->findByAttributes(array('no_kantongdarah' => $modKantong->no_kantongdarah));
    $modKantongDarah = InfokantongdarahV::model()->findAllByAttributes(array('no_kantongdarah' => $modKantong->no_kantongdarah));

    if (!empty($no_kantongdarah)) {
      $modKantong = InfokantongdarahV::model()->findByAttributes(array('no_kantongdarah' => $no_kantongdarah));
      $modelKantongDarah = KantongdarahT::model()->findByAttributes(array('no_kantongdarah' => $modKantong->no_kantongdarah));
    }

    $this->render('_detailView', array(
      'modKantong' => $modKantong,
      'modKantongDarah' => $modKantongDarah,
      'model' => $model,
    ));
  }

  /**
   * Autocomplete kantong darah
   * @author Tantowi J <tantowijaya@.com>
   * @param type $no_kantongdarah
   */
  public function actionAutocompleteKantongDarah($nomorbarcode = "")
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['nomorbarcode'])) {
        $_GET['nomorbarcode'] = null;
      }
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition("nomorbarcode = :nomorbarcode");
                    $criteria->params[':nomorbarcode'] = $_GET['nomorbarcode'] . '%';

      $criteria->compare(':nomorbarcode', $_GET['nomorbarcode'], true);
      $criteria->order = 'nomorbarcode ASC';
      $criteria->condition = "terimakantongdarah_id IS NOT NULL";
      $criteria->condition = "periksakomponendarah_id IS NULL";
      $criteria->limit = 5;
      $models = InfokantongdarahV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorbarcode . " - " . $model->gol_darah;
        $returnVal[$i]['value'] = $model->nomorbarcode;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
