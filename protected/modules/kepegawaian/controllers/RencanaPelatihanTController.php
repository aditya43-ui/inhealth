<?php

/**
 * Class ini berisi menu untuk Membat/mengubah Rencana Pelatihan.
 */
class RencanaPelatihanTController extends MyAuthController
{
  public $rencDiklat = false;

  /**
   * Menu untuk membuat Rencana Pelatihan
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Pelatihan";
    $format = new MyFormatter();
    $model = new KPRencanadiklatT;
    $model->norencanadiklat = MyGenerator::noRencanaDiklat();
    $model->tglrencanadiklat = $format->formatDateTimeForUser(date("Y-m-d"));
    $model->rencanadiklat_periode = date('Y-m-d');
    $model->rencanadiklat_sampaidgn = date('Y-m-d');

    $modDet = new KPRencanadiklatdetT;
    $modBiaya = new KPBiayapelatihanT();

    $model->jenisdiklat_id = Params::JENIS_DIKLAT_EKSTERNAL;


    if (isset($_POST['KPRencanadiklatT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {

        $ok = $ok && $this->simpanRencana($_POST, $model);

        if (isset($_POST['KPRencanadiklatdetT'])) {
          $ok = $ok && $this->simpanDetail($_POST['KPRencanadiklatdetT'], $model);
        }

        if (isset($_POST['KPBiayapelatihanT'])) {
          $ok = $ok && $this->simpanBiaya($_POST['KPBiayapelatihanT'], $model, $modBiaya);
        }

        // var_dump($model->norencana);die;
        // $model->norencana
        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data  berhasil disimpan !");
          $this->redirect(array('index', 'rencanadiklat_id' => $model->rencanadiklat_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Update Data Rencana Pelatihan gagal disimpan !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Rencana Pelatihan gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modBiaya' => $modBiaya,
      'modDet' => $modDet
    ));
  }


  /**
   * Menu untuk mengubah Rencana Pelatihan
   */
  public function actionUpdate($id)
  {
    $format = new MyFormatter();
    $model = KPRencanadiklatT::model()->findByPk($id);
    $model->tglrencanadiklat = MyFormatter::formatDateTimeForUser($model->tglrencanadiklat);
    // $model->norencanadiklat = MyGenerator::noRencanaDiklat();
    // $model->tglrencanadiklat = $format->formatDateTimeForUser(date("Y-m-d"));
    // $model->rencanadiklat_periode = MyFormatter::formatDateTimeForUser($model->rencanadiklat_periode);
    // $model->rencanadiklat_sampaidgn = MyFormatter::formatDateTimeForUser($model->rencanadiklat_periode);

    $modDetail = KPRencanadiklatdetT::model()->findAllByAttributes(array(
      'rencanadiklat_id' => $id,
    ));
    $modDet = new KPRencanadiklatdetT;


    /* Mengetahui */
    if (!empty($model->pemberitugas_id)) $model->pemberitugas_nama = $model->diklatPemberitugas->namaLengkap;
    if (!empty($model->mengetahui_id)) $model->pegawaimengetahui_nama = $model->diklatMengetahui->namaLengkap;
    if (!empty($model->menyetujui_id)) $model->pegawaimenyetujui_nama = $model->diklatMenyetujui->namaLengkap;

    /* Format Biaya */
    $modBiaya = KPBiayapelatihanT::model()->findByAttributes(array(
      'rencanadiklat_id' => $id,
    ));
    $modBiaya->eksternal_totbiayapelatihan = MyFormatter::formatNumberForPrint($modBiaya->eksternal_totbiayapelatihan);
    $modBiaya->eksternal_totbiayatransportasi = MyFormatter::formatNumberForPrint($modBiaya->eksternal_totbiayatransportasi);
    $modBiaya->eksternal_totbiayapenginapan = MyFormatter::formatNumberForPrint($modBiaya->eksternal_totbiayapenginapan);
    $modBiaya->eksternal_totbiayaperjalanan = MyFormatter::formatNumberForPrint($modBiaya->eksternal_totbiayaperjalanan);
    $modBiaya->eksternal_totbiayalainlain = MyFormatter::formatNumberForPrint($modBiaya->eksternal_totbiayalainlain);
    $modBiaya->internal_biayapemateri = MyFormatter::formatNumberForPrint($modBiaya->internal_biayapemateri);
    $modBiaya->internal_biayakonsumsi = MyFormatter::formatNumberForPrint($modBiaya->internal_biayakonsumsi);
    $modBiaya->internal_biayaalatperaga = MyFormatter::formatNumberForPrint($modBiaya->internal_biayaalatperaga);
    $modBiaya->internal_biayalainlain = MyFormatter::formatNumberForPrint($modBiaya->internal_biayalainlain);
    $modBiaya->total_biaya = MyFormatter::formatNumberForPrint($modBiaya->total_biaya);


    if (isset($_POST['KPRencanadiklatT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {

        $ok = $ok && $this->simpanRencana($_POST, $model);

        if (isset($_POST['KPRencanadiklatdetT'])) {
          $ok = $ok && $this->simpanDetail($_POST['KPRencanadiklatdetT'], $model);
        }

        if (isset($_POST['KPBiayapelatihanT'])) {
          $ok = $ok && $this->simpanBiaya($_POST['KPBiayapelatihanT'], $model, $modBiaya);
        }

        //var_dump($model->attributes);die;
        if ($ok) {
          $transaction->commit();
          $this->redirect(array('informasiPelatihan/index', 'rencanadiklat_id' => $model->rencanadiklat_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Update Data Rencana Pelatihan gagal disimpan !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Rencana Pelatihan gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modBiaya' => $modBiaya,
      'modDet' => $modDet,      // data dummy
      'modDetail' => $modDetail,  // data detail peserta
    ));
  }


  /**
   * Menyimpan/update biaya rencana pelatihan.
   * 
   * @param mixed $postbiaya data post biaya dari form.
   * @param KPRencanadiklatT $model data KPRencanadiklatT
   * @param KPBiayapelatihanT $modBiaya data KPBiayapelatihanT
   * @return boolean Transaksi berhasil dijalankan
   */
  public function simpanBiaya($postbiaya, $model, &$modBiaya)
  {

    $modBiaya->attributes = $postbiaya;
    $modBiaya->rencanadiklat_id = $model->rencanadiklat_id;
    $modBiaya->total_biaya = $modBiaya->getTotalSeluruh();

    return $modBiaya->save();
  }

  /**
   * Menghapus data detail sebelumnya berdasarkan id dari data KPRencanadiklatT
   * (jika ada), kemudian menginsert kembali data-nya dari detail dari form.
   * 
   * @param mixed $postdet Data post berisi Detail Rencana
   * @param KPRencanadiklatT $model Model KPRencanadiklatT
   * @return boolean Transaksi berhasil dijalankan
   */
  public function simpanDetail($postdet, $model)
  {
    $ok = true;

    KPRencanadiklatdetT::model()->deleteAllByAttributes(array(
      'rencanadiklat_id' => $model->rencanadiklat_id
    ));

    foreach ($postdet as $key => $det) {
      $modDet = new KPRencanadiklatdetT;
      $modDet->attributes = $postdet[$key];
      $modDet->rencanadiklat_id = $model->rencanadiklat_id;
      $ok = $ok && $modDet->save();
    }

    return $ok;
  }


  /**
   * Menyimpan/update Data KPBiayapelatihanT
   * @param mixed $post data post dari form Rencana Pelatihan
   * @param KPBiayapelatihanT $model data yang akan di simpan.
   * @return boolean Transaksi berhasil dijalankan
   */
  public function simpanRencana($post, &$model)
  {
    $model->attributes = $post['KPRencanadiklatT'];
    $model->norencanadiklat = MyGenerator::noRencanaDiklat();
    $model->tglrencanadiklat = MyFormatter::formatDateTimeForDb($model->tglrencanadiklat);
    $model->rencanadiklat_periode = MyFormatter::formatDateTimeForDb($model->rencanadiklat_periode);
    $model->rencanadiklat_sampaidgn = MyFormatter::formatDateTimeForDb($model->rencanadiklat_sampaidgn);
    $model->tglmengetahui = isset($model->tglmengetahui) ? $format->formatDateTimeForDb($post['KPRencanadiklatT']['tglmengetahui']) : null;
    $model->tglmenyetujui = isset($model->tglmenyetujui) ? $format->formatDateTimeForDb($post['KPRencanadiklatT']['tglmenyetujui']) : null;
    $model->jumlah_peserta = count((array)$post['KPRencanadiklatdetT']);
    $selisih = CustomFunction::getSelisihJam($model->jam_mulai, $model->jam_akhir);
    $model->total_jam = $selisih['jam'];
    $model->total_menit = $selisih['menit'];

    $model->update_time = date("Y-m-d H:i:s");
    $model->update_loginpemakai_id = Yii::app()->user->id;

    if ($model->isNewRecord) {
      $model->create_time = date("Y-m-d H:i:s");
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->ruangan_id;
      $model->status_rencana = Params::STATUS_RENCANA_DIKLAT_RENCANA;
    }

    return $model->save();
  }

  public function actionPrintApproval($approverenanggpen_id)
  {
    $format = new MyFormatter();
    $modPenerimaan = AGRenanggpenerimaanT::model()->findByAttributes(array('approverenanggpen_id' => $approverenanggpen_id));
    $modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id' => $modPenerimaan->renanggpenerimaan_id));
    $judulLaporan = 'Anggaran Penerimaan';
    $deskripsi = $modPenerimaan->konfiganggaran->deskripsiperiode;
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printApproval', array('format' => $format, 'modPenerimaan' => $modPenerimaan, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (isset($_GET['pegawai_id'])) {
        if (!empty($_GET['pegawai_id'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
        }
      }
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = KPPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        if (!empty($model->jabatan_id)) {
          $returnVal[$i]['jabatan_nama'] = JabatanM::model()->findByPk($model->jabatan_id)->jabatan_nama;
        } else {
          $returnVal[$i]['jabatan_nama'] = '';
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePemberiTugas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->join = 'left join jabatan_m j on j.jabatan_id = t.jabatan_id';
      $criteria->addCondition("j.jabatan_nama ilike '%kepala%'");
      $criteria->order = 't.nama_pegawai';
      $criteria->limit = 5;
      $models = KPPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->join = 'left join jabatan_m j on j.jabatan_id = t.jabatan_id';
      $criteria->addCondition("j.jabatan_nama ilike '%manager%'");
      $criteria->order = 't.nama_pegawai';
      $criteria->limit = 5;
      $models = KPPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompletePegawaiMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
      $criteria->select = $criteria->group;
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->compare('jabatan_id', Params::JABATAN_ID_DIREKTUR);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = KPPegawairuanganV::model()->findAll($criteria);
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
}
