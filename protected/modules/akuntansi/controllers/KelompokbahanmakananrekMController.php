<?php

/**
 * Master Kelompok Bahan Makanan dengan Rekening COA Akuntansi
 * 
 * @author Adi Priatna H
 * @package application.modules.akuntansi
 * @subpackage controllers
 * @category controller
 */
class KelompokbahanmakananrekMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';

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
  public function actionCreate()
  {
    $model = new KelbahanmakananrekM();

    if (isset($_POST['KelbahanmakananrekM'])) {
      $model->attributes = $_POST['KelbahanmakananrekM'];


      $criteria = new CDbCriteria();
      $ispenerimaan = (($_POST['KelbahanmakananrekM']['ispenerimaan'] == 1) ? 'true' : 'false');
      $ispemakaian = (($_POST['KelbahanmakananrekM']['ispemakaian'] == 1) ? 'true' : 'false');
      $isreturpenerimaan = (($_POST['KelbahanmakananrekM']['isreturpenerimaan'] == 1) ? 'true' : 'false');
      $istokopname = (($_POST['KelbahanmakananrekM']['istokopname'] == 1) ? 'true' : 'false');
      $istokopnamebertambah = (($_POST['KelbahanmakananrekM']['istokopnamebertambah'] == 1) ? 'true' : 'false');
      $istokopnameberkurang = (($_POST['KelbahanmakananrekM']['istokopnameberkurang'] == 1) ? 'true' : 'false');

      $criteria->addCondition("kelbahanmakanan = :kelbahanmakanan");
      $criteria->params[':kelbahanmakanan'] = $_POST['KelbahanmakananrekM']['kelbahanmakanan'];
      $criteria->addCondition("kelbahanmakanan = :kelbahanmakanan2");
      $criteria->params[':kelbahanmakanan2'] = $_POST['KelbahanmakananrekM']['debitkredit'];
      $criteria->addCondition('ispenerimaan = ' . $ispenerimaan . ' OR ispemakaian = ' . $ispemakaian . ' OR isreturpenerimaan = ' . $isreturpenerimaan. ' OR istokopname = ' . $istokopname. ' OR istokopnamebertambah = ' . $istokopnamebertambah. ' OR istokopnameberkurang = ' . $istokopnameberkurang);
      $modCek = KelbahanmakananrekM::model()->findAll($criteria);
      //                        $modCek = KelbahanmakananrekM::model()->findAllByAttributes(array("kelbahanmakanan"=>$_POST['KelbahanmakananrekM']['kelbahanmakanan'], "debitkredit"=>$_POST['KelbahanmakananrekM']['debitkredit']));
      if (count((array)$modCek) > 0) {
        Yii::app()->user->setFlash('error', 'Rekening ini tidak bisa ditambahkan karena sudah ada.');
        $this->redirect(array('create'));
      } else {
        if ($model->save()) {
          Yii::app()->user->setFlash('success', 'Data ' . $model->rekening5->nmrekening5 . ' berhasil disimpan.');
          $this->redirect(array('admin'));
        } else {
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      }
    }

    $this->render('create', array(
      'model' => $model,
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


    if (isset($_POST['KelbahanmakananrekM'])) {
      $model->attributes = $_POST['KelbahanmakananrekM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->rekening5->nmrekening5 . ' berhasil disimpan.');
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
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
    $dataProvider = new CActiveDataProvider('JenisbarangrekM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new KelbahanmakananrekM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KelbahanmakananrekM'])) {
      $model->attributes = $_GET['KelbahanmakananrekM'];
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
    $model = KelbahanmakananrekM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'jenisbarangrek-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new KelbahanmakananrekM;
    if (isset($_REQUEST['KelbahanmakananrekM'])) {
      $model->attributes = $_REQUEST['KelbahanmakananrekM'];
    }

    $judulLaporan = 'Jurnal Kelompok Bahan Makanan';
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
      // //$mpdf->useOddEven = 2;  

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
