<?php

class PetunjukPenggunaanDetailMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */


  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
  
    $model = new PetunjukpenggunaandetailM;

    if (isset($_POST['PetunjukpenggunaandetailM'])) {
        $model = new PetunjukpenggunaandetailM;
        $model->attributes = $_POST['PetunjukpenggunaandetailM'];
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if ($model->validate()) {
        
        $random = rand(0000000, 9999999);
        $model->petunjukpenggunaandetail_image = CUploadedFile::getInstance($model, 'petunjukpenggunaandetail_image');
        $x = $model->petunjukpenggunaandetail_image;
        
        // $video = $model->videoantrian;
       
        //
        if (isset($model->petunjukpenggunaandetail_image)) {//jika data lama dan baru tidaksama;
          
            $model->petunjukpenggunaandetail_image = $random . $model->petunjukpenggunaandetail_image;
            
            Yii::import("ext.EPhpThumb.EPhpThumb");
            $fullImgName = $model->petunjukpenggunaandetail_image;
            $fullImgSource = Params::pathPetunjukPenggunaanDirectory() . $fullImgName;
            $model->petunjukpenggunaandetail_image = $fullImgName;
            $x->saveAs($fullImgSource);
            
        }
        $model->save();
        
        
        
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->petunjukpenggunaandetail_id));
      }else{
        var_dump($model->getErrors());die;
      }
    }

    $this->render('create', array(
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

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PetunjukpenggunaandetailM'])) {
      $model->attributes = $_POST['PetunjukpenggunaandetailM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->shift_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }


  function actionSetMenuByModul(){
    if (Yii::app()->request->isAjaxRequest) {
        $modul_id = $_POST['modul_id'];

        $modMenuModules = MenumodulK::model()->findAllByAttributes(array('modul_id' => $modul_id));
        
        $str = '<option value="">-- Pilih --</option>';
        
        foreach ($modMenuModules as $item) {
        	// //();die;
            $str .= '<option value="'.$item->menu_id.'" >'.$item->menu_nama.'</option>';
        }
        
        echo CJSON::encode(array(
            'option'=>$str,
        ));
  
        
       
        Yii::app()->end();
      }
  }
  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
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
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('PetunjukpenggunaandetailM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    
    $model = new PetunjukpenggunaandetailM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PetunjukpenggunaandetailM']))
      $model->attributes = $_GET['PetunjukpenggunaandetailM'];

    $this->render('admin', array(
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
    $model = PetunjukpenggunaandetailM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sashift-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {

    PetunjukpenggunaandetailM::model()->updateByPk($id, array('shift_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {

    $model = new PetunjukpenggunaandetailM;
    // $model->attributes = $_REQUEST['PetunjukpenggunaandetailM'];
    $judulLaporan = 'Data Petunjuk Penggunaan Detail';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
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
