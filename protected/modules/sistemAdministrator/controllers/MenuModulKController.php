<?php

class MenuModulKController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.menuModulK.';
  public $path_tips = 'sistemAdministrator.views.';
  //public $arrMenuModul = array();

  public function beforeAction($action)
  {
    //$this->arrMenuModul = MenuModul::getMenuModul($this->module->menu);
    return parent::beforeAction($action);
  }

  public function actionGetControllers($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $namaModul = $_POST['namaModul'];
      $controllers = Yii::app()->metadata->getControllers($namaModul);
      if ($encode) {
        echo CJSON::encode($controllers);
      } else {
        foreach ($controllers as $value => $name) {
          $nameController = str_replace("Controller", "", $name);
          echo CHtml::tag('option', array('value' => $nameController), CHtml::encode($nameController), true);
        }
        exit;
      }
    }
    Yii::app()->end();
  }

  public function actionGetActions($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $namaModul = $_POST['namaModul'];
      $controllerId = $_POST['namaController'] . "Controller";
      $actions = Yii::app()->metadata->getActions(ucfirst($controllerId), $namaModul);

      if ($encode) {
        echo CJSON::encode($actions);
      } else {
        foreach ($actions as $value => $name) {
          echo CHtml::tag('option', array('value' => $name), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SAMenuModulK;

    if (isset($_POST['SAMenuModulK'])) {
      $model->attributes = $_POST['SAMenuModulK'];
      /**
       * dicomment untuk upload menu_icon - RND-4955
       */
      //                 $model->menu_icon = CUploadedFile::getInstance($model, 'menu_icon');
      //                 $gambar = $model->menu_icon;
      //                 $random = rand(000000, 999999);

      //                echo print_r($model->getAttributes());
      //                exit;

      //                    ==========pengecekan file icon menu
      //                  if(!empty($model->menu_icon))//Klo User Memasukan Logo
      //                  { 
      //                        Yii::import("ext.EPhpThumb.EPhpThumb");
      //
      //                         $thumb=new EPhpThumb();
      //                         $thumb->init(); //this is needed
      //                         $model->menu_icon = $random.$model->menu_icon; 
      //                         $fullImgName =$model->menu_icon;   
      //                         $fullImgSource = Params::pathIconMenuDirectory().$fullImgName;
      //
      //                         $fullThumbSource = Params::pathIconMenuThumbsDirectory().$fullImgName;
      //                  }

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        //                        try{    

        if ($model->save()) {

          //                              ==========ini digunakan untuk menyimpan icon menu
          //                                if (!empty($model->menu_icon)){  
          //                                  $gambar->saveAs($fullImgSource);
          //
          //                                   $thumb->create($fullImgSource)
          //                                         ->resize(24,24)
          //                                         ->save($fullThumbSource);
          //                                 }

        }
        if ($model) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Berhasil Disimpan.');
          $this->redirect(array('admin', 'id' => $model->menu_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
        }
        //                         } catch (Exception $e){
        //                            $transaction->rollback();
        //                            Yii::app()->user->setFlash('error',"Data Gagal Disimpan". $e->getMessage());
        //                        }
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan. Silakan Periksa Kembali Data Pelamar !");
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    //            $tempIcon = $model->menu_icon;
    $model->menu_icon = $model->menu_icon;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAMenuModulK'])) {
      /**
       * dicomment untuk upload menu_icon - RND-4955
       */
      //                $instance = CUploadedFile::getInstance($model, 'menu_icon');
      //
      //                if($instance){
      //                    Yii::import("ext.EPhpThumb.EPhpThumb");
      //
      //                    $Objthumb=new EPhpThumb();
      //                    $Objthumb->init(); //this is needed
      //
      //                    $fullImgName = time().'_image.'.$instance->getExtensionName();   
      //                    $fullImgSource = Params::pathIconMenuDirectory().$fullImgName; 
      //                    $fullThumbSource = Params::pathIconMenuThumbsDirectory().$fullImgName;
      //
      //                    $image = Params::pathIconMenuDirectory().$model->menu_icon;
      //                    $thumb = Params::pathIconMenuThumbsDirectory().$model->menu_icon;
      //
      //                    $removeFile = true;
      //                    if(!empty($tempIcon)){
      //                        if(file_exists($image))
      //                            if(!(unlink($image) && unlink($thumb)))
      //                                $removeFile = false;
      //                    }
      //                    
      //                    if($removeFile){
      //                        $model->menu_icon = $fullImgName;
      //                        $model->menu_icon = $fullImgName;
      //
      //                        if($model->save()){
      //                            $instance->saveAs($fullImgSource);
      //                            $Objthumb->create($fullImgSource)
      //                                     ->resize(24,24)
      //                                     ->save($fullThumbSource);
      //
      //                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      //                            $this->redirect(array('admin','id'=>$model->menu_id));
      //                        }
      //                    }
      //                }

      $model->attributes = $_POST['SAMenuModulK'];
      //                $model->menu_icon = $tempIcon;
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->menu_id));
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
    $dataProvider = new CActiveDataProvider('SAMenuModulK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Menu";
    $model = new SAMenuModulK('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAMenuModulK']))
      $model->attributes = $_GET['SAMenuModulK'];

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
    $model = SAMenuModulK::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(401, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'samenu-modul-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
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
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAMenuModulK::model()->updateByPk($id, array('menu_aktif' => false));
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
    //            if (!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) {
    //                throw new CHttpException(401, Yii::t('mds', 'You are prohibited to access this page. Contact Super Administrator'));
    //            }
    $model = new SAMenuModulK;
    $model->attributes = $_REQUEST['SAMenuModulK'];
    $judulLaporan = 'Data Menu Modul';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;  
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
