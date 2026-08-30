<?php

class PenjaminPasienMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.penjaminPasienM.';
  public $tips = 'sistemAdministrator.views.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new SAPenjaminPasienM;

    if (isset($_POST['SAPenjaminPasienM'])) {
      //var_dump($_POST['SAPenjaminPasienM']);//die();
      //var_dump(CUploadedFile::getInstance($model, 'path_logoasuransi')); 
      $model->attributes = $_POST['SAPenjaminPasienM'];
      $model->carabayar_id = $_POST['SAPenjaminPasienM']['carabayar_id'];
      $model->diskon_tagihan = MyFormatter::formatNumberForDb($model->diskon_tagihan, 2);
      $model->diskon_klaim = MyFormatter::formatNumberForDb($model->diskon_klaim, 2);
      $model->diskon_rj = MyFormatter::formatNumberForDb($model->diskon_rj, 2);
      $model->diskon_ri = MyFormatter::formatNumberForDb($model->diskon_ri, 2);
      $model->diskon_rd = MyFormatter::formatNumberForDb($model->diskon_rd, 2);
      $model->biaya_administrasi = MyFormatter::formatNumberForDb($model->biaya_administrasi, 2);
      $model->penjamin_aktif = true;

      $random = rand(0000000, 9999999);
      $model->path_logoasuransi = CUploadedFile::getInstance($model, 'path_logoasuransi');
      $gambar = $model->path_logoasuransi;

      $file = $model->lampiranpks;
      $model->lampiranpks = CUploadedFile::getInstance($model, 'lampiranpks');
      $lampiranpks = $model->lampiranpks;

      //pengecekan file photo pelamar
      if (!empty($model->path_logoasuransi)) { //Klo User Memasukan Logo
        $model->path_logoasuransi = $random . $model->path_logoasuransi;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->path_logoasuransi;
        $fullImgSource = Params::pathLogoAsuransiDirectory() . $fullImgName;
        $fullThumbSource = Params::pathLogoAsuransiThumbsDirectory() . 'kecil_' . $fullImgName;

        $model->path_logoasuransi = $fullImgName;
      }

      //pengecekan file lamaran
      if (!empty($model->lampiranpks)) {
        $model->lampiranpks = $random . $model->lampiranpks;
        $namaFile = $model->lampiranpks;
        $dataLampiran = Params::pathLampiranpksFilesDirectory() . $namaFile;

        // if (!isset($model->lampiranpks)) {
        // 	$model->lampiranpks = $temLayar;
        // } else {
        // 	$model->lampiranpks = $fullImgNameD;
        // }
      }

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($model->save()) {

            // ini digunakan untuk menyimpan logo
            if (!empty($model->path_logoasuransi)) {
              $gambar->saveAs($fullImgSource);

              // $thumb->create($fullThumbSource)
              // 	 ->resize(200,200)
              // 	 ->save($fullThumbSource);
            }

            //ini digunakan untuk menyimpan file
            if (!empty($model->lampiranpks)) {
              $lampiranpks->saveAs($dataLampiran);
            }
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Penjamin " . $model->penjamin_nama . " berhasil disimpan");
          $this->redirect(array('admin'));
        } catch (Exception $e) {
          // var_dump($model->getErrors()); die();
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan" . $e->getMessage());
        }
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan. Silakan Periksa Kembali Data Penjamin !");
        $this->redirect(array('admin', $model->carabayar_id));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $itemLogo = $model->path_logoasuransi;
    $lamp = $model->lampiranpks;
    $model->biaya_administrasi = MyFormatter::formatNumberForUser($model->biaya_administrasi, 2);
    // $model->diskon_tagihan = MyFormatter::formatNumberForUser($model->diskon_tagihan);
    // $model->diskon_klaim = MyFormatter::formatNumberForUser($model->diskon_klaim);
    // $model->diskon_rj = MyFormatter::formatNumberForUser($model->diskon_rj);
    // $model->diskon_ri = MyFormatter::formatNumberForUser($model->diskon_ri);
    // $model->diskon_rd = MyFormatter::formatNumberForUser($model->diskon_rd);
    // if(!empty($model->path_logoasuransi)){
    // }

    if (isset($_POST['SAPenjaminPasienM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      //$model = $this->loadModel($id);
      $model->attributes = $_POST['SAPenjaminPasienM'];
      $model->biaya_administrasi = MyFormatter::formatNumberForDb($_POST['SAPenjaminPasienM']['biaya_administrasi']);
      // $model->diskon_tagihan = MyFormatter::formatNumberForDb($_POST['SAPenjaminPasienM']['diskon_tagihan']);
      // $model->diskon_klaim = MyFormatter::formatNumberForDb($_POST['SAPenjaminPasienM']['diskon_klaim']);
      // $model->diskon_rj = MyFormatter::formatNumberForDb($_POST['SAPenjaminPasienM']['diskon_rj']);
      // $model->diskon_ri = MyFormatter::formatNumberForDb($_POST['SAPenjaminPasienM']['diskon_ri']);
      // $model->diskon_rd = MyFormatter::formatNumberForDb($_POST['SAPenjaminPasienM']['diskon_rd']);



      if ($model->validate()) {
        try {
          $random = rand(0000000, 9999999);
          $model->path_logoasuransi = CUploadedFile::getInstance($model, 'path_logoasuransi');
          $gambar = $model->path_logoasuransi;

          $file = $model->lampiranpks;
          $model->lampiranpks = CUploadedFile::getInstance($model, 'lampiranpks');
          $lampiranpks = $model->lampiranpks;

          // pengecekan file lamaran
          if (isset($model->lampiranpks) && ($model->lampiranpks != $lamp)) {
            if (!empty($lamp)) {
              if ($model->lampiranpks != $lamp) {
                if (file_exists(Params::pathLampiranpksFilesDirectory() . $lamp)) {
                  unlink(Params::pathLampiranpksFilesDirectory() . $lamp);
                }
              }
            }

            $model->lampiranpks = $random . $model->lampiranpks;
            $namaFile = $model->lampiranpks;
            $dataLampiran = Params::pathLampiranpksFilesDirectory() . $namaFile;
            if (!empty($model->lampiranpks)) {
              $lampiranpks->saveAs($dataLampiran);
            }
          } else {
            $model->lampiranpks = $lamp;
            $model->save();
          }

          //Klo User Memasukan Logo
          if (isset($model->path_logoasuransi) && ($model->path_logoasuransi != $itemLogo)) {
            if (!empty($itemLogo)) {
              if ($model->path_logoasuransi != $itemLogo) {
                if (file_exists(Params::pathLogoAsuransiDirectory() . $itemLogo)) {
                  unlink(Params::pathLogoAsuransiDirectory() . $itemLogo);
                }
              }
            }
            $model->path_logoasuransi = $random . $model->path_logoasuransi;

            Yii::import("ext.EPhpThumb.EPhpThumb");

            // $thumb=new EPhpThumb();
            // $thumb->init(); //this is needed

            $fullImgName = $model->path_logoasuransi;
            $fullImgSource = Params::pathLogoAsuransiDirectory() . $fullImgName;
            $fullThumbSource = Params::pathLogoAsuransiThumbsDirectory() . 'kecil_' . $fullImgName;

            if (!isset($model->path_logoasuransi)) {
              $model->path_logoasuransi = $itemLogo;
            } else {
              $model->path_logoasuransi = $fullImgName;
            }

            if ($model->save()) {
              if (!empty($itemLogo)) {
                // unlink(Params::pathLogoAsuransiDirectory() . $itemLogo);
                // unlink(Params::pathLogoAsuransiThumbsDirectory() . 'kecil_' . $itemLogo);
              }

              $gambar->saveAs($fullImgSource);

              //ini digunakan untuk menyimpan file
            }
          } else {
            $model->path_logoasuransi = $itemLogo;

            $model->save();
          }

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Penjamin " . $model->penjamin_nama . " berhasil disimpan");
          $this->redirect(array('admin', 'sukses' => 1));
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAPenjaminPasienM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {
    $this->pageTitle = Yii::app()->name . " - Penjamin Pasien";
    if ($id == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;
    $model = new SAPenjaminPasienM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPenjaminPasienM'])) {
      $model->attributes = $_GET['SAPenjaminPasienM'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SAPenjaminPasienM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapenjamin-pasien-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      if (!empty($id)) {
        TanggunganpenjaminM::model()->deleteAllByAttributes(array('penjamin_id' => $id));
        JenistarifpenjaminM::model()->deleteAllByAttributes(array('penjamin_id' => $id));
        $this->loadModel($id)->delete();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
          $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      }
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAPenjaminPasienM::model()->updateByPk($id, array('penjamin_aktif' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }

  public function actionPrint()
  {
    $model = new SAPenjaminPasienM;
    $model->unsetAttributes();

    if (isset($_REQUEST['SAPenjaminPasienM'])) {
      $model->attributes = $_REQUEST['SAPenjaminPasienM'];
    }
    $judulLaporan = 'Daftar Penjamin Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionPrintLampiranLogo()
  {

    $model = PenjaminpasienM::model()->findByPk($_GET['penjamin_id']);

    if (isset($model)) {
      $fileLogo = Params::urlLogoAsuransiDirectory() . $model->path_logoasuransi;
      $fileLogoPath = Params::pathLogoAsuransiDirectory() . $model->path_logoasuransi;
      echo '<img src="' . $fileLogo . '" />';
      exit();
      //            if(file_exists($fileLogoPath)){
      ////                header('Content-Description: File Transfer');
      //                header('Content-Type: '.mime_content_type ($fileLogoPath));
      //                header('Content-Disposition: filename="'.basename($fileLogoPath).'"');
      ////                header('Expires: 0');
      ////                header('Cache-Control: must-revalidate');
      ////                header('Pragma: public');
      //                header('Content-Length: ' . filesize($fileLogoPath));
      //                header("Accept-Ranges: bytes");
      //                header("Content-Transfer-Encoding: Binary"); 
      //                flush();
      ////                readfile($fileLogo);
      //            imagejpeg($fileLogoPath);
      //                die();
      //            }
    }
  }

  public function actionPrintLampiranPdf()
  {

    $model = PenjaminpasienM::model()->findByPk($_GET['penjamin_id']);

    if (isset($model)) {
      $fileLogo = Params::pathLampiranpksFilesDirectory() . $model->lampiranpks;

      if (file_exists($fileLogo)) {
        header('Content-Description: File Transfer');
        header('Content-Type: ' . mime_content_type($fileLogo));
        header('Content-Disposition: attachment; filename="' . basename($fileLogo) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileLogo));
        header("Accept-Ranges: bytes");
        header("Content-Transfer-Encoding: Binary");
        flush();
        readfile($fileLogo);
        die();
      }
    }
  }
}
