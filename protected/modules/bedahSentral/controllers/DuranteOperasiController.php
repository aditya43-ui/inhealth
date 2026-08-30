<?php

class DuranteOperasiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = "bedahSentral.views.duranteOperasi.";

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
  public function actionIndex($pasienmasukpenunjang_id, $id = null)
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

    if (!empty($id)) {
      $model = AnastesiduranteoperasiT::model()->findByPk($id);

      $model->isofluran_nilai = empty($model->isofluran_nilai) ? null : number_format($model->isofluran_nilai, 2, ",", "");
      $model->sevofluran_nilai = empty($model->sevofluran_nilai) ? null : number_format($model->sevofluran_nilai, 2, ",", "");
      $model->desfluran_nilai = empty($model->desfluran_nilai) ? null : number_format($model->desfluran_nilai, 2, ",", "");
      $model->suhutubuh = empty($model->suhutubuh) ? null : number_format($model->suhutubuh, 2, ",", "");
      $model->urine_jumlah = empty($model->urine_jumlah) ? null : number_format($model->urine_jumlah, 2, ",", "");
    }

    if (empty($model)) {
      $model = new AnastesiduranteoperasiT;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->rencanaoperasi_id = null;
      $model->genPemeriksaan();
    }

    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
    }



    if (isset($_POST['AnastesiduranteoperasiT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $model->attributes = $_POST['AnastesiduranteoperasiT'];

        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;

        $model->keterangan_jamobservasi = CJSON::encode(array(
          'anestesi' => $status->statusanestesi,
          'tindakan' => $status->status_tindakanbedah,
        ));

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        MedikasiduranteoperasiT::model()->deleteAllByAttributes(array(
          'anastesiduranteoperasi_id' => $model->anastesiduranteoperasi_id,
        ));
        CairanimduranteopT::model()->deleteAllByAttributes(array(
          'anastesiduranteoperasi_id' => $model->anastesiduranteoperasi_id,
        ));

        if (isset($_POST['medikasi'])) {
          foreach ($_POST['medikasi'] as $idx => $val) {
            if ($val != 1) {
              continue;
            }

            $det = new MedikasiduranteoperasiT();
            $det->anastesiduranteoperasi_id = $model->anastesiduranteoperasi_id;
            $det->obatalkes_id = $idx;
            $ok = $ok && $det->save();
            //                        var_dump($det->attributes);
          }
        }

        if (isset($_POST['intramuskular'])) {
          foreach ($_POST['intramuskular'] as $idx => $val) {
            if (!isset($val['ceklis']) || $val['ceklis'] == '') {
              continue;
            }

            $det = new CairanimduranteopT();
            $det->anastesiduranteoperasi_id = $model->anastesiduranteoperasi_id;
            $det->obatalkes_id = $idx;
            $det->jumlah_cairanim = $val['jumlah'];
            $ok = $ok && $det->save();

            //                        var_dump($det->attributes);
          }
        }

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
    }

    // var_dump($status->attributes); die;

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'status' => $status,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = AnastesiduranteoperasiT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'anastesiduranteoperasi-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint($id)
  {
    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $id
    ));

    $model = AnastesiduranteoperasiT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $id,
    ), array(
      'order' => 'pemeriksaanke',
    ));


    $judulLaporan = 'Grafik Observasi Durante Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'status' => $status, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'status' => $status, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'status' => $status, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
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
    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
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
    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
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
    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
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
    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
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

  public function actionGrafikDurante($pasienmasukpenunjang_id)
  {

    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    $model = AnastesiduranteoperasiT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ), array(
      'order' => 'pemeriksaanke',
    ));

    $this->render($this->path_view . 'grafik', array(
      'model' => $model,
      'status' => $status,
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));
  }
}
