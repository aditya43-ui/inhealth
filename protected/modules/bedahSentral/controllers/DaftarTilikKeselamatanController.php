<?php

class DaftarTilikKeselamatanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = "bedahSentral.views.daftarTilikKeselamatan.";

  /**
   * Membuat dan menyimpan data baru.
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

    $model = DaftartilikanestesipasienT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($model)) {
      $model = new DaftartilikanestesipasienT;
      $model->tanggal_pengkajian = date('Y-m-d H:i:s');
      $model->pasien_id = $penunjang->pasien_id;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->rencanaoperasi_id = null;
    }
    // echo '<pre>';
    // print_r($model->pasienadmisi_id); exit;

    $model->tanggal_pengkajian = MyFormatter::formatDateTimeForUser($model->tanggal_pengkajian);

    if (isset($_POST['DaftartilikanestesipasienT'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();

      try {
        // echo '<pre>';
        // print_r($_POST); exit;

        $model->attributes = $_POST['DaftartilikanestesipasienT'];
        $model->rencanaoperasi_id = null;
        $model->tanggal_pengkajian = MyFormatter::formatDateTimeForDb($_POST['DaftartilikanestesipasienT']['tanggal_pengkajian']);

        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->id;
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
          $model->update_time = date('Y-m-d H:i:s');
          $model->update_loginpemakai_id = Yii::app()->user->id;
        }

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        CairanpasienanestesiT::model()->deleteAllByAttributes(array(
          'daftartilikanestesipasien_id' => $model->daftartilikanestesipasien_id,
        ));

        if (isset($_POST['CairanpasienanestesiT'])) {
          foreach ($_POST['CairanpasienanestesiT'] as $idx => $item) {

            $det = new CairanpasienanestesiT;
            $det->attributes = $item;
            $det->daftartilikanestesipasien_id = $model->daftartilikanestesipasien_id;
            $ok = $ok && $det->save();
            // var_dump($item, $det->attributes);

          }
        }
        // var_dump($model->attributes); die;

        // var_dump($ok, $model->attributes); die;

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

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'penunjang' => $penunjang,
      'rencana' => $rencana,
      'diagnosa' => $diagnosa,
      'anestesi' => $anestesi
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = DaftartilikanestesipasienT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'daftartilikanestesipasien-t-form') {
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
    $model = DaftartilikanestesipasienT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $det = CairanpasienanestesiT::model()->findAllByAttributes(array(
      'daftartilikanestesipasien_id' => $model->daftartilikanestesipasien_id,
    ));
    $judulLaporan = 'Daftar Tilik Keselamatan Pasien dan Persiapan Mesin';

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('penunjang' => $penunjang, 'model' => $model, 'det' => $det, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('penunjang' => $penunjang, 'model' => $model, 'det' => $det, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //            //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('penunjang' => $penunjang, 'model' => $model, 'det' => $det, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
