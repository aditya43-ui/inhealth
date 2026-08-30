<?php

class CatatanIntraOperasiController extends MyAuthController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'create';
  public $path_view = "bedahSentral.views.catatanIntraOperasi.";

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($pasienmasukpenunjang_id, $id = null)
  {


    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (!empty($id)) {

      $model = BedahanastesilokalIntraopT::model()->findByPk($id);
    }


    if (empty($model)) {
      $model = new BedahanastesilokalIntraopT;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->rencanaoperasi_id = null;
      $model->genPemeriksaan();
    }


    $status = StatusbedahanastesilokalT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($status)) {
      $status = new StatusbedahanastesilokalT;
    }


    if (isset($_POST['BedahanastesilokalIntraopT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;


      try {

        $model->attributes = $_POST['BedahanastesilokalIntraopT'];
        $model->penentuanStatusAnestesi($status);
        // $model->status_anestesi = $status->statusanestesi;
        // $model->status_tindakanbedah = $status->status_tindakanbedah;

        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        
        if ($model->pasienadmisi_id == 0) {
            $model->pasienadmisi_id = null;
        }

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }


        // BedahanastesilokalMedikasiintraopT::model()->deleteAllByAttributes(array(
        //     'bedahanastesilokal_intraop_id'=>$model->bedahanastesilokal_intraop_id,
        // ));
        if (isset($_POST['BedahanastesilokalMedikasiintraopT']['detail'])) {
          foreach ($_POST['BedahanastesilokalMedikasiintraopT']['detail'] as $item) {

            $bedahanastesilokal_medikasiintraop_id = isset($item['bedahanastesilokal_medikasiintraop_id']) ? $item['bedahanastesilokal_medikasiintraop_id'] : null;

            if (!empty($bedahanastesilokal_medikasiintraop_id)) {
              $det = BedahanastesilokalMedikasiintraopT::model()->findByPk($bedahanastesilokal_medikasiintraop_id);
              if (!empty($det)) {
                continue;
              }
            }

            $det = new BedahanastesilokalMedikasiintraopT;
            $det->attributes = $item;
            $det->obatalkes_dosis = $item['pemakaian_jumlah'];
            $det->bedahanastesilokal_intraop_id = $model->bedahanastesilokal_intraop_id;

            $ok = $ok && $det->save();

            $ok = $ok && $this->simpanOaIntraOperasi($det, $model, $penunjang);

            // var_dump($det->attributes); die;
          }
        }

        // var_dump($ok); die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('create', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $ex) {
//          print_r($ex->getMessage()); die;
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'status' => $status,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['BedahanastesilokalIntraopT'])) {
      $model->attributes = $_POST['BedahanastesilokalIntraopT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->bedahanastesilokal_intraop_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Memanggil dan menonaktifkan status
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example:
      // $model->modelaktif = false;
      // if($model->save()){
      //	$data['sukses'] = 1;
      // }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('BedahanastesilokalIntraopT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new BedahanastesilokalIntraopT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['BedahanastesilokalIntraopT'])) {
      $model->attributes = $_GET['BedahanastesilokalIntraopT'];
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = BedahanastesilokalIntraopT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'bedahanastesilokal-intraop-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint($id)
  {


    $status = StatusbedahanastesilokalT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $id
    ));

    $model = BedahanastesilokalIntraopT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $id,
    ), array(
      'order' => 'pemeriksaanke',
    ));

    //        var_dump($model->attributes); die;

    $obat = array();


    foreach ($model as $item) {
      //            var_dump($item->attributes); die;
      $sub_obat = BedahanastesilokalMedikasiintraopT::model()->findAllByAttributes(array(
        'bedahanastesilokal_intraop_id' => $item->bedahanastesilokal_intraop_id,
      ));

      $obat = array_merge($obat, $sub_obat);
    }

    $judulLaporan = 'Grafik Observasi Intra Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'status' => $status, 'obat' => $obat, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'status' => $status, 'obat' => $obat, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'status' => $status, 'obat' => $obat, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }



  public function actionMulaiAnestesi()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $waktu = $_POST['waktu'];
    $pasienmasukpenunjang_id = $_POST['pasienmasukpenunjang_id'];

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $status = StatusbedahanastesilokalT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusbedahanastesilokalT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;

      $status->create_time = date('Y-m-d H:i:s');
      $status->create_loginpemakai_id = Yii::app()->user->id;
      $status->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    $status->update_time = date('Y-m-d H:i:s');
    $status->update_loginpemakai_id = Yii::app()->user->id;

    $status->jam_mulaianestesi = $waktu;
    $status->statusanestesi = Params::STATUSDURANTEANESTESI_SEDANG_ANESTESI;

    $ok = 1;
    $msg = "Anestesi Dimulai.";



    if (!$status->validate() || !$status->save()) {
      $ok = 0;
      $msg = "Status gagal di ubah";
    }

    echo CJSON::encode(array(
      'ok' => $ok, 'msg' => $msg
    ));
  }


  public function actionSelesaiAnestesi()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $waktu = $_POST['waktu'];
    $pasienmasukpenunjang_id = $_POST['pasienmasukpenunjang_id'];

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $status = StatusbedahanastesilokalT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusbedahanastesilokalT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;

      $status->create_time = date('Y-m-d H:i:s');
      $status->create_loginpemakai_id = Yii::app()->user->id;
      $status->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    $status->update_time = date('Y-m-d H:i:s');
    $status->update_loginpemakai_id = Yii::app()->user->id;

    $status->jam_selesaianestesi = $waktu;
    $status->statusanestesi = Params::STATUSDURANTEANESTESI_AKHIR_ANESTESI;

    $ok = 1;
    $msg = "Anestesi Selesai.";

    if (!$status->validate() || !$status->save()) {
      $ok = 0;
      $msg = "Status gagal di ubah";
    }

    echo CJSON::encode(array(
      'ok' => $ok, 'msg' => $msg
    ));
  }



  public function actionMulaiTindakan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $waktu = $_POST['waktu'];
    $pasienmasukpenunjang_id = $_POST['pasienmasukpenunjang_id'];

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $status = StatusbedahanastesilokalT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusbedahanastesilokalT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;

      $status->create_time = date('Y-m-d H:i:s');
      $status->create_loginpemakai_id = Yii::app()->user->id;
      $status->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    $status->update_time = date('Y-m-d H:i:s');
    $status->update_loginpemakai_id = Yii::app()->user->id;

    $status->jam_mulaitindakanbedah = $waktu;
    $status->status_tindakanbedah = Params::STATUSDURANTEANESTESI_SEDANG_TINDAKAN;

    $ok = 1;
    $msg = "Tindakan Dimulai.";

    if (!$status->validate() || !$status->save()) {
      $ok = 0;
      $msg = "Status gagal di ubah";
    }

    echo CJSON::encode(array(
      'ok' => $ok, 'msg' => $msg
    ));
  }


  public function actionSelesaiTindakan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $waktu = $_POST['waktu'];
    $pasienmasukpenunjang_id = $_POST['pasienmasukpenunjang_id'];

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $status = StatusbedahanastesilokalT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusbedahanastesilokalT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;

      $status->create_time = date('Y-m-d H:i:s');
      $status->create_loginpemakai_id = Yii::app()->user->id;
      $status->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    $status->update_time = date('Y-m-d H:i:s');
    $status->update_loginpemakai_id = Yii::app()->user->id;

    $status->jam_selesaitindakanbedah = $waktu;
    $status->status_tindakanbedah = Params::STATUSDURANTEANESTESI_AKHIR_TINDAKAN;

    $ok = 1;
    $msg = "Tindakan Selesai.";

    if (!$status->validate() || !$status->save()) {
      $ok = 0;
      $msg = "Status gagal di ubah";
    }

    echo CJSON::encode(array(
      'ok' => $ok, 'msg' => $msg
    ));
  }


  public function actionGrafikIntra($pasienmasukpenunjang_id)
  {

    $status = StatusbedahanastesilokalT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    $model = BedahanastesilokalIntraopT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ), array(
      'order' => 'pemeriksaanke',
    ));

    //        var_dump($model->attributes); die;

    $obat = array();


    foreach ($model as $item) {
      //            var_dump($item->attributes); die;
      $sub_obat = BedahanastesilokalMedikasiintraopT::model()->findAllByAttributes(array(
        'bedahanastesilokal_intraop_id' => $item->bedahanastesilokal_intraop_id,
      ));

      $obat = array_merge($obat, $sub_obat);
    }

    $this->render($this->path_view . 'grafik', array(
      'model' => $model,
      'status' => $status,
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
      'obat' => $obat,
    ));
  }



  protected function simpanOaIntraOperasi($medikasi, $model, $penunjang)
  {

    $oa = ObatalkesM::model()->findByPk($medikasi->obatalkes_id);
    $valid = true;

    $modPakaiBahan = new ObatalkespasienT();
    $modPakaiBahan->attributes = $oa->attributes;
    $modPakaiBahan->pendaftaran_id = $penunjang->pendaftaran_id;
    $modPakaiBahan->penjamin_id = $penunjang->penjamin_id;
    $modPakaiBahan->carabayar_id = $penunjang->carabayar_id;
    if (!empty($modPendaftaran->pasienadmisi_id)) {
      $modPakaiBahan->pasienadmisi_id = $penunjang->pasienadmisi_id;
    }
    //$modPakaiBahan->daftartindakan_id = $bmhp['daftartindakan_id'];
    //$modPakaiBahan->sumberdana_id = $bmhp['sumberdana_id'];
    $modPakaiBahan->pasien_id = $penunjang->pasien_id;
    //$modPakaiBahan->satuankecil_id = $bmhp['satuankecil_id'];
    $modPakaiBahan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //$modPakaiBahan->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    $modPakaiBahan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    //$modPakaiBahan->obatalkes_id = $bmhp['obatalkes_id'];
    $modPakaiBahan->pegawai_id = $penunjang->pegawai_id;
    $modPakaiBahan->kelaspelayanan_id = $penunjang->kelaspelayanan_id;
    $modPakaiBahan->shift_id = Yii::app()->user->getState('shift_id');

    $modPakaiBahan->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;

    $modPakaiBahan->qty_oa = $medikasi->obatalkes_dosis;
    $modPakaiBahan->harganetto_oa = $oa->harganetto;
    $modPakaiBahan->hargasatuan_oa = $oa->hargajual;
    $modPakaiBahan->hargajual_oa = $modPakaiBahan->hargasatuan_oa * $modPakaiBahan->qty_oa;

    $modPakaiBahan->tglpelayanan = date('Y-m-d') . " " . $model->observasi_jam;
    $modPakaiBahan->bedahanastesilokal_medikasiintraop_id = $medikasi->bedahanastesilokal_medikasiintraop_id;
    //$bmhp['subtotal'];
    $modPakaiBahan->oa = "OA";

    $valid = $modPakaiBahan->validate() && $valid;

    if ($valid) {
      $modPakaiBahan->save();
      $this->simpanStokKeluar($modPakaiBahan);
    }

    // var_dump($modPakaiBahan->attributes, $model->attributes); die;

    return $valid;
  }


  function simpanStokKeluar($modPemakaianBahan)
  {
    $format = new MyFormatter;
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modPemakaianBahan->obatalkes_id);
    //var_dump($oa->attributes);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes;
    $modStokOaNew->attributes = $modPemakaianBahan->attributes; //duplicate
    //$modStokOaNew->unsetIdTransaksi();
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = ceil($modPemakaianBahan->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
    $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
    $modStokOaNew->obatalkespasien_id = $modPemakaianBahan->obatalkespasien_id;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    //$modStokOaNew->validate();
    //var_dump($modStokOaNew->errors);


    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
    }

    // var_dump($this->stokobatalkestersimpan);

    return $modStokOaNew;
  }


  public function actionHapusMedikasi()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];

    $trans = Yii::app()->db->beginTransaction();
    $ok = 1;
    $msg = "Data berhasil dihapus";

    try {
      $oa = ObatalkespasienT::model()->findAllByAttributes(array(
        'bedahanastesilokal_medikasiintraop_id' => $id,
      ));

      foreach ($oa as $item) {
        StokobatalkesT::model()->deleteAllByAttributes(array(
          'obatalkespasien_id' => $item->obatalkespasien_id,
        ));
        $item->delete();
      }

      BedahanastesilokalMedikasiintraopT::model()->deleteByPk($id);

      $trans->commit();
    } catch (Exception $e) {
      $ok = 0;
      $msg = "Data gagal dihapus. " . $e->getMessage();
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }
}
