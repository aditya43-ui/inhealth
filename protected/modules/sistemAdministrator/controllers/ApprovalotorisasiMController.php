<?php

class ApprovalotorisasiMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column2';
  // public $layout='//layouts/column1';
  public $defaultAction = 'update';
  public $path_view = 'sistemAdministrator.views.approvalotorisasiM.';

  /**
   * @return array action filters
   */
  // public function filters()
  // {
  // 	return array(
  // 		'accessControl', // perform access control for CRUD operations
  // 	);
  // }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  // public function accessRules()
  // {
  // 	return array(
  // 		array('allow',  // allow all users to perform 'index' and 'view' actions
  // 			'actions'=>array('index','view'),
  // 			'users'=>array('*'),
  // 		),
  // 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
  // 			'actions'=>array('create','update'),
  // 			'users'=>array('@'),
  // 		),
  // 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
  // 			'actions'=>array('admin','delete'),
  // 			'users'=>array('admin'),
  // 		),
  // 		array('deny',  // deny all users
  // 			'users'=>array('*'),
  // 		),
  // 	);
  // }

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
    $model = new SAApprovalotorisasiM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAApprovalotorisasiM'])) {
      $model->attributes = $_POST['SAApprovalotorisasiM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data Approval berhasil disimpan");
        // $this->redirect(array('view','id'=>$model->approvalotorisasi_id));
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
  public function actionUpdate($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Konfigurasi Otorisasi Approval";
    if ($id == null) {
      $id = 1;
    }
    $model = $this->loadModel($id);
    $dataApprovalBatalTindakan = $this->getDataApprovalKeuangan(Params::MENU_ID_BATAL_TINDAKAN);
    $dataApprovalBatalVerifikasi = $this->getDataApprovalKeuangan(Params::MENU_ID_BATAL_VERIFIKASI);
    $dataApprovalBatalAlokasi = $this->getDataApprovalKeuangan(Params::MENU_ID_BATAL_ALOKASI);
    $dataApprovalBatalPembayaran = $this->getDataApprovalKeuangan(Params::MENU_ID_BATAL_PEMBAYARAN);
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAApprovalotorisasiM'])) {
      // echo '<pre>';var_dump($_POST);die;
      try {
        $transaction = Yii::app()->db->beginTransaction();

        $this->deteleApprovalKeuangan();

        $approvalKeuangan = $this->inserApprovalKeuangan($_POST);
        $model->attributes = $_POST['SAApprovalotorisasiM'];

        if ($model->save() && $approvalKeuangan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Approval berhasil disimpan");
          // $this->redirect(array('view','id'=>$model->approvalotorisasi_id));
          $this->redirect(array('update'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan" . $exc->getMessage());
      }
    }

    $this->render('update', array(
      'model' => $model,
      'dataApprovalBatalTindakan' => $dataApprovalBatalTindakan,
      'dataApprovalBatalVerifikasi' => $dataApprovalBatalVerifikasi,
      'dataApprovalBatalAlokasi' => $dataApprovalBatalAlokasi,
      'dataApprovalBatalPembayaran' => $dataApprovalBatalPembayaran
    ));
  }

  function inserApprovalKeuangan($post) {
    $save = true;
    if(isset($_POST['pegawai_id_bataltindakan'])) {
      foreach($_POST['pegawai_id_bataltindakan'] as $i => $val) {
        $modApprovalKeuangan = new ApprovalkeuanganK();
        $modApprovalKeuangan->menu_id = Params::MENU_ID_BATAL_TINDAKAN;
        $modApprovalKeuangan->pegawai_id = $val;
        if($modApprovalKeuangan->save()) {
          $save = true;
        } else {
          $save = false;
        }
      }
    }
    if(isset($_POST['pegawai_id_batalverifikasi'])) {
      foreach($_POST['pegawai_id_batalverifikasi'] as $i => $val) {
        $modApprovalKeuangan = new ApprovalkeuanganK();
        $modApprovalKeuangan->menu_id = Params::MENU_ID_BATAL_VERIFIKASI;
        $modApprovalKeuangan->pegawai_id = $val;
        if($modApprovalKeuangan->save()) {
          $save = true;
        } else {
          $save = false;
        }
      }
    }
    if(isset($_POST['pegawai_id_batalalokasi'])) {
      foreach($_POST['pegawai_id_batalalokasi'] as $i => $val) {
        $modApprovalKeuangan = new ApprovalkeuanganK();
        $modApprovalKeuangan->menu_id = Params::MENU_ID_BATAL_ALOKASI;
        $modApprovalKeuangan->pegawai_id = $val;
        if($modApprovalKeuangan->save()) {
          $save = true;
        } else {
          $save = false;
        }
      }
    }
    if(isset($_POST['pegawai_id_batalpembayaran'])) {
      foreach($_POST['pegawai_id_batalpembayaran'] as $i => $val) {
        $modApprovalKeuangan = new ApprovalkeuanganK();
        $modApprovalKeuangan->menu_id = Params::MENU_ID_BATAL_PEMBAYARAN;
        $modApprovalKeuangan->pegawai_id = $val;
        if($modApprovalKeuangan->save()) {
          $save = true;
        } else {
          $save = false;
        }
      }
    }

    return $save;
  }

  function getDataApprovalKeuangan($menu_id) {
    $model = ApprovalkeuanganK::model()->findAllByAttributes(['menu_id' => $menu_id]);
    if(empty($model)) {
      $model = [];
    } else {
      foreach ($model as $val) {
          $arrPegawai[] = $val->pegawai_id;
      }
      $model = $arrPegawai;
    }
    return $model;
  }

  function deteleApprovalKeuangan() {
    $criteria = new CDbCriteria();
    $criteria->addInCondition('menu_id', [Params::MENU_ID_BATAL_ALOKASI, Params::MENU_ID_BATAL_PEMBAYARAN, Params::MENU_ID_BATAL_TINDAKAN, Params::MENU_ID_BATAL_VERIFIKASI]);
    ApprovalkeuanganK::model()->deleteAll($criteria);
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
    $dataProvider = new CActiveDataProvider('SAApprovalotorisasiM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new SAApprovalotorisasiM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAApprovalotorisasiM']))
      $model->attributes = $_GET['SAApprovalotorisasiM'];

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
    $model = SAApprovalotorisasiM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'approvalotorisasi-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionAutocompletePenanggungjawabApoteker()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->select = "pegawai_id, nama_pegawai";
      $criteria->group = $criteria->select;

      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addInCondition("ruangan_id", array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_APOTEK_1));
      $criteria->addCondition('pegawai_aktif = true');
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawairuanganV::model()->findAll($criteria);
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
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->select = "pegawai_id, nama_pegawai, gelardepan, gelarbelakang_nama";
      //            $criteria->group = $criteria->select;

      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addCondition('pegawai_aktif = true');
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      //            $models = PegawairuanganV::model()->findAll($criteria);
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
