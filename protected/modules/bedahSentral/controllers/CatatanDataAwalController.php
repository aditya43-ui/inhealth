
<?php

class CatatanDataAwalController extends MyAuthController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = "bedahSentral.views.catatanDataAwal.";

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($pasienmasukpenunjang_id)
  {
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $model = BedahanastesilokalpasienT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));
    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($model)) {
      $model = new BedahanastesilokalpasienT;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
    }
    if (isset($_POST['BedahanastesilokalpasienT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {

        $model->attributes = $_POST['BedahanastesilokalpasienT'];
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

        SpesimenhasiloperasiT::model()->deleteAllByAttributes(array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
        ), array(
          'condition' => 'laporanoperasipasien_id is null'
        ));
        if (isset($_POST['SpesimenhasiloperasiT']['detail'])) {
          foreach ($_POST['SpesimenhasiloperasiT']['detail'] as $item) {
            $det = new SpesimenhasiloperasiT;
            $det->attributes = $model->attributes;
            $det->attributes = $item;

            $ok = $ok && $det->save();

            // var_dump($det->errors, $det->attributes);
          }
        }

        // var_dump($ok, $model->errors, $model->attributes, $_POST); die;

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
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->bedahanastesilokalpasien_id));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'penunjang' => $penunjang,
    ));
  }



  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = BedahanastesilokalpasienT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'bedahanastesilokalpasien-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new BedahanastesilokalpasienT;
    $model->attributes = $_REQUEST['BedahanastesilokalpasienT'];
    $judulLaporan = 'Data BedahanastesilokalpasienT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
