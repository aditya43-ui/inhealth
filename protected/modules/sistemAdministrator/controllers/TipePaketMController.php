<?php

class TipePaketMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.tipePaketM.';

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
    //                if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SATipePaketM;
    $model->tglkesepakatantarif = date('d M Y');
    $model->tarifpaket = 0;
    $model->paketiurbiaya = 0;
    $model->paketsubsidiasuransi = 0;
    $model->paketsubsidipemerintah = 0;
    $model->paketsubsidirs = 0;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SATipePaketM'])) {
      $format = new MyFormatter();

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {

        if (isset($_POST['SATipePaketM']['kelaspelayanan_id']) && isset($_POST['SATipePaketM']['penjamin_id'])) {
          foreach ($_POST['SATipePaketM']['kelaspelayanan_id'] as $kelaspelayanan_id) {
            foreach ($_POST['SATipePaketM']['penjamin_id'] as $penjamin_id) {
              // var_dump($_POST);die;
              $modelNew = new SATipePaketM;
              $modelNew->attributes = $model->attributes;
              $modelNew->attributes = $_POST['SATipePaketM'];
              $modelNew->kelaspelayanan_id = $kelaspelayanan_id;
              $modelNew->penjamin_id = $penjamin_id;
              $modelNew->tglkesepakatantarif = $format->formatDateTimeForDB($modelNew->tglkesepakatantarif);
              $jenis_paket = $_POST['SATipePaketM']['jenis_paket'];
              if ($jenis_paket == 'is_rad') {
                  $modelNew->is_rad = true;
              } elseif ($jenis_paket == 'is_mikro') {
                  $modelNew->is_mikro = true;
              } elseif ($jenis_paket == 'is_darah') {
                  $modelNew->is_darah = true;
              } elseif ($jenis_paket == 'is_pk') {
                $modelNew->is_pk = true;
              } elseif ($jenis_paket == 'is_pa') {
              $modelNew->is_pa = true;
              }
              // var_dump($modelNew->attributes);

              $ok = $ok && $modelNew->save();
            }
          }
        }

        // var_dump($ok, $_POST); die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data " . $modelNew->tipepaket_nama . " berhasil disimpan");
          $this->redirect(array('admin'));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }

      } catch (Exception $e) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan. ".$e->getMessage());
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
    //                if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    $model->jenistarif_nama = (isset($model->jenistarif) ? $model->jenistarif->jenistarif_nama : "");
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SATipePaketM'])) {
      $model->attributes = $_POST['SATipePaketM'];
      $format = new MyFormatter();
      $model->tglkesepakatantarif = $format->formatDateTimeForDb($model->tglkesepakatantarif);
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data " . $model->tipepaket_nama . " berhasil disimpan");
        $this->redirect(array('admin', 'id' => $model->tipepaket_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
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
      //                        if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
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
    $dataProvider = new CActiveDataProvider('SATipePaketM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    //                if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SATipePaketM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SATipePaketM']))
      $model->attributes = $_GET['SATipePaketM'];

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
    $model = SATipePaketM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'satipe-paket-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      $model->tipepaket_aktif = false;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
    //		if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //		SATipePaketM::model()->updateByPk($id, array('tipepaket_aktif'=>false));
    //		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    //             if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                         
    $model = new SATipePaketM();
    $model->attributes = $_REQUEST['SATipePaketM'];
    $judulLaporan = 'Data Paket';
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
      $mpdf->Output();
    }
  }

  public function actionGetJenisTarifPejamin()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $penjamin = $_POST['penjamin_id'];

      $criteria = new CDbCriteria();
      $criteria->select = "jenistarif_m.jenistarif_id, jenistarif_m.jenistarif_nama";
      $criteria->join = "JOIN jenistarif_m ON jenistarif_m.jenistarif_id = t.jenistarif_id";
      $criteria->addCondition('t.penjamin_id = ' . $penjamin);
      $model = JenistarifpenjaminM::model()->find($criteria);

      $data = array();

      if (isset($model)) {
        $data['jenistarif_id'] = $model->jenistarif_id;
        $data['jenistarif_nama'] = $model->jenistarif_nama;
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetDropdownPenjaminPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!isset($_POST['nopilih'])) {
        $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        $option = "";
      }
      if (!empty($_POST['carabayar_id'])) {
        $data = $data = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $_POST['carabayar_id'], 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
        $data = CHtml::listData($data, 'penjamin_id', 'penjamin_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listPenjamin'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }
}
