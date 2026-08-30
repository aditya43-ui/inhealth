
<?php

class AsesmenPraInduksiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = "bedahSentral.views.asesmenPraInduksi.";

  /**
   * Melihat daftar data.
   */
  public function actionIndex($pasienmasukpenunjang_id)
  {
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $penunjang->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = AsesmenprainduksiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    if (empty($model)) {
      $model = new AsesmenprainduksiT;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->rencanaoperasi_id = null;

      if (!empty($rencana)) {
        $anestesi = PasienanastesiT::model()->findByAttributes(array(
          'rencanaoperasi_id' => $rencana->rencanaoperasi_id,
        ));
        if (!empty($anestesi)) {
          $model->jenisanastesi_id = $anestesi->jenisanastesi_id;
        }
      }
    }

    if (isset($_POST['AsesmenprainduksiT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {

        $model->attributes = $_POST['AsesmenprainduksiT'];
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          $ok = $ok && $model->save();
        }
        /*
                PremedikasiprainduksiT::model()->deleteAllByAttributes(array(
                    'asesmenprainduksi_id'=>$model->asesmenprainduksi_id,
                ));
                */
        if (isset($_POST['PremedikasiprainduksiT']['detail'])) {
          foreach ($_POST['PremedikasiprainduksiT']['detail'] as $item) {

            $premedikasiprainduksi_id = isset($item['premedikasiprainduksi_id']) ? $item['premedikasiprainduksi_id'] : null;

            if (!empty($premedikasiprainduksi_id)) {
              $det = PremedikasiprainduksiT::model()->findByPk($premedikasiprainduksi_id);
            } else {
              $det = new PremedikasiprainduksiT();
            }

            $det->attributes = $item;
            $det->asesmenprainduksi_id = $model->asesmenprainduksi_id;

            $ok = $ok && $det->save();

            if (empty($premedikasiprainduksi_id)) {
              $ok = $ok && $this->simpanOaPramedikasi($det, $penunjang);
            }
          }
        }


        //                var_dump($model->attributes, $_POST); die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }



      //            if ($model->save()) {
      //                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      //                $this->redirect(array('view', 'id' => $model->asesmenprainduksi_id));
      //            }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  protected function simpanOaPramedikasi($pramedikasi, $penunjang)
  {

    $oa = ObatalkesM::model()->findByPk($pramedikasi->obatalkes_id);
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
    $modPakaiBahan->tglpelayanan = date('Y-m-d') . " " . $pramedikasi->premedikasi_jam;
    $modPakaiBahan->qty_oa = $pramedikasi->premedikasi_jumlah;
    $modPakaiBahan->harganetto_oa = $oa->harganetto;
    $modPakaiBahan->hargasatuan_oa = $oa->hargajual;
    $modPakaiBahan->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
    $modPakaiBahan->premedikasiprainduksi_id = $pramedikasi->premedikasiprainduksi_id;
    $modPakaiBahan->hargajual_oa = $modPakaiBahan->hargasatuan_oa * $modPakaiBahan->qty_oa; //$bmhp['subtotal'];
    $modPakaiBahan->oa = "OA";
    $valid = $modPakaiBahan->validate() && $valid;

    if ($valid) {
      $modPakaiBahan->save();
      $this->simpanStokKeluar($modPakaiBahan);
    }

    return $valid;
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new AsesmenprainduksiT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['AsesmenprainduksiT'])) {
      $model->attributes = $_GET['AsesmenprainduksiT'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = AsesmenprainduksiT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'asesmenprainduksi-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint($pasienmasukpenunjang_id)
  {

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array(
      'pendaftaran_id' => $penunjang->pendaftaran_id,
      'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
    ), array(
      'condition' => "tglmorbiditas::date <= '" . MyFormatter::formatDateTimeForDB($rencana->tglrencanaoperasi) . "'::date",
    ));

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = AsesmenprainduksiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $judulLaporan = 'Asesmen Pra Induksi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'penunjang' => $penunjang, 'rencana' => $rencana, 'anestesi' => $anestesi, 'diagnosa' => $diagnosa, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'penunjang' => $penunjang, 'rencana' => $rencana, 'anestesi' => $anestesi, 'diagnosa' => $diagnosa, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'penunjang' => $penunjang, 'rencana' => $rencana, 'anestesi' => $anestesi, 'diagnosa' => $diagnosa, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
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

  public function actionHapusPramedikasi()
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
        'premedikasiprainduksi_id' => $id,
      ));

      foreach ($oa as $item) {
        StokobatalkesT::model()->deleteAllByAttributes(array(
          'obatalkespasien_id' => $item->obatalkespasien_id,
        ));
        $item->delete();
      }

      PremedikasiprainduksiT::model()->deleteByPk($id);

      $trans->commit();
    } catch (Exception $e) {
      $ok = 0;
      $msg = "Data gagal dihapus. " . $e->getMessage();
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }
}
