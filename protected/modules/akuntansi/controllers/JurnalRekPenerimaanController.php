<?php

class JurnalRekPenerimaanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function init()
  {
    if (isset($_GET['tab'])) {
      if ($_GET['tab'] == 'frame') {
        $this->layout = '//layouts/iframe';
      }
    }
  }

  public function actionView($id)
  {
    $model = AKJenispenerimaanM::model()->findByAttributes(array('jenispenerimaan_id' => $id));

    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($id = '')
  {

    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}


    $model = new AKJenispenerimaanM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJenispenerimaanM'])) {
      // var_dump($_POST);
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      if (!empty($_POST['AKJenispenerimaanM']['jenispenerimaan_id'])) {
        $model = AKJenispenerimaanM::model()->findByPk($_POST['AKJenispenerimaanM']['jenispenerimaan_id']);
      }
      //$model->attributes = $_POST['AKJenispenerimaanM'];
      //$model->create_time = date('Y-m-d');
      //$model->create_ruangan= Yii::app()->user->getState('ruangan_id');
      //$model->create_loginpemakai_id= Yii::app()->user->getState('loginpemakai_id');

      //if ($model->validate()) $ok = $ok && $model->save();
      //else $ok = false;

      // var_dump($ok);

      if (isset($_POST['detail'])) {
        foreach ($_POST['detail']['rekening5_id'] as $idx => $item) {
          if (!empty($item)) {
            $det = new AKJnsPenerimaanRekM;
            $det->jenispenerimaan_id = $model->jenispenerimaan_id;
            $det->debitkredit = $det->saldonormal = $_POST['detail']['debitkredit'][$idx];
            $det->rekening5_id = $item;

            // $r5 = Rekening5M::model()->findByPk($item);
            // $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
            // $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
            // $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
            // $r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

            // $det->rekening4_id = $r5->rekening4_id;
            // $det->rekening3_id = $r4->rekening3_id;
            // $det->rekening2_id = $r3->rekening2_id;
            // $det->rekening1_id = $r2->rekening1_id;
            $det->create_time = date('Y-m-d H:i:s');
            $det->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $det->create_ruangan = Yii::app()->user->getState('ruangan_id');

            if ($det->validate()) $ok = $ok && $det->save();
            else $ok = false;
          }
        }
        $model->save();
      }

      if ($ok) {
        $trans->commit();
        Yii::app()->user->setFlash('success', 'Data ' . $model->jenispenerimaan_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '', 'modul_id' => Yii::app()->session['modul_id'], 'sukses' => 1));
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        $this->redirect(array('create'));
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

    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJenispenerimaanM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      $model->attributes = $_POST['AKJenispenerimaanM'];
      $model->update_time = date('Y-m-d');
      $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

      if ($model->validate()) $ok = $ok && $model->save();
      else $ok = false;

      AKJnsPenerimaanRekM::model()->deleteAllByAttributes(array(
        'jenispenerimaan_id' => $model->jenispenerimaan_id,
      ));

      if (isset($_POST['detail'])) {
        foreach ($_POST['detail']['rekening5_id'] as $idx => $item) {
          if (!empty($item)) {
            $det = new AKJnsPenerimaanRekM;
            $det->jenispenerimaan_id = $model->jenispenerimaan_id;
            $det->debitkredit = $det->saldonormal = $_POST['detail']['debitkredit'][$idx];
            $det->rekening5_id = $item;

            // $r5 = Rekening5M::model()->findByPk($item);
            // $r4 = Rekening4M::model()->findByPk($r5->rekening4_id);
            // $r3 = Rekening3M::model()->findByPk($r4->rekening3_id);
            // $r2 = Rekening2M::model()->findByPk($r3->rekening2_id);
            // $r1 = Rekening1M::model()->findByPk($r2->rekening1_id);

            // $det->rekening4_id = $r5->rekening4_id;
            // $det->rekening3_id = $r4->rekening3_id;
            // $det->rekening2_id = $r3->rekening2_id;
            // $det->rekening1_id = $r2->rekening1_id;
            $det->create_time = date('Y-m-d H:i:s');
            $det->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $det->create_ruangan = Yii::app()->user->getState('ruangan_id');

            // var_dump($_POST['detail'], $det->attributes, $det->validate(), $det->errors);

            if ($det->validate()) $ok = $ok && $det->save();
            else $ok = false;
          }
        }
        $model->save();
      }

      if ($ok) {
        $trans->commit();
        Yii::app()->user->setFlash('success', 'Data ' . $model->jenispenerimaan_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '', 'modul_id' => Yii::app()->session['modul_id'], 'sukses' => 1));
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        $this->redirect(array('update'));
      }

      /*
                        if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin', 'id' => 1));
			} */
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  public function actionUbahRekeningDebitKredit($view = null, $id = null)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}


    $model = AKJenispenerimaanM::model()->findByPk($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJenispenerimaanM'])) {
      $model->attributes = $_POST['AKJenispenerimaanM'];

      $view = 'UbahRekeningDebitKredit';
      $update = AKJenispenerimaanM::model()->updateByPk($id, array('rekeningdebit_id' => $_POST['AKJenispenerimaanM']['rekeningdebit_id'], 'rekeningkredit_id' => $_POST['AKJenispenerimaanM']['rekeningkredit_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPenerimaan'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebitKredit'), 'id' => $model->jenispenerimaan_id, 'frame' => $_GET['frame'], 'idPenerimaan' => $_GET['idPenerimaan']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispenerimaan_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebitKredit'), array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {

      $trans = Yii::app()->db->beginTransaction();
      $data = array('sukses' => 0);

      $ok = true;
      $ok = $ok && AKJnsPenerimaanRekM::model()->deleteAllByAttributes(array('jenispenerimaan_id' => $_POST['id']));

      if ($ok) {
        $trans->commit();
        $data['sukses'] = 1;
      } else {
        $trans->rollback();
        $data['sukses'] = 0;
      }


      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      //if(!isset($_GET['ajax']))
      //	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


      echo CJSON::encode($data);
      //$model = 
      //AKJenispenerimaanM::model()->deleteByPk($id);


    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionDeleteMaster()
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $trans = Yii::app()->db->beginTransaction();
      $data = array('sukses' => 0);

      $ok = true;
      AKJnsPenerimaanRekM::model()->deleteAllByAttributes(array('jenispenerimaan_id' => $_POST['id']));
      $ok = $ok && AKJenispenerimaanM::model()->deleteAllByAttributes(array('jenispenerimaan_id' => $_POST['id']));

      if ($ok) {
        $trans->commit();
        $data['sukses'] = 1;
      } else {
        $trans->rollback();
        $data['sukses'] = 0;
      }


      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      //if(!isset($_GET['ajax']))
      //	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


      echo CJSON::encode($data);
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('AKJenispenerimaanM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($tab = null)
  {
    // if ($tab != 'frame'):
    //  $this->redirect(array('index','modul_id'=>Yii::app()->session['modul_id']));
    //  else:
    //      $this->layout='//layouts/iframe';        
    //  endif;

    $model = new AKJenispenerimaanM('searchJenisPenerimaan');
    $model->unsetAttributes();
    if (isset($_GET['AKJenispenerimaanM'])) {
      $model->attributes = $_GET['AKJenispenerimaanM'];
      $model->jenispenerimaan_nama = $_GET['AKJenispenerimaanM']['jenispenerimaan_nama'];
      $model->rekDebit =  isset($_GET['AKJenispenerimaanM']['rekDebit']) ? $_GET['AKJenispenerimaanM']['rekDebit'] : null;
      $model->rekKredit = isset($_GET['AKJenispenerimaanM']['rekKredit']) ? $_GET['AKJenispenerimaanM']['rekKredit'] : null;
    }
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
    $model = AKJenispenerimaanM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'jenispenerimaan-m-form') {
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
    $data = array('sukses' => 0);
    if (JenispenerimaanM::model()->updateByPk($id, array('jenispenerimaan_aktif' => false))) {
      $data['sukses'] = 1;
    }
    echo CJSON::encode($data);
  }

  public function actionPrint()
  {
    $model = new AKJenispenerimaanM;
    if (isset($_GET['AKJenispenerimaanM'])) {
      $model->attributes = $_GET['AKJenispenerimaanM'];
      $model->jenispenerimaan_nama = $_GET['AKJenispenerimaanM']['jenispenerimaan_nama'];
      $model->rekDebit =  isset($_GET['AKJenispenerimaanM']['rekDebit']) ? $_GET['AKJenispenerimaanM']['rekDebit'] : null;
      $model->rekKredit = isset($_GET['AKJenispenerimaanM']['rekKredit']) ? $_GET['AKJenispenerimaanM']['rekKredit'] : null;
    }
    $judulLaporan = 'Data Jurnal Rekening Penerimaan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');    //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');     //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $footer = '
            <table width="100%">
            <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
             <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
            </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }


  public function actionFormRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $r = Rekening5M::model()->findByPk($_POST['id']);
      $dk = $_POST['debitkredit'];
      $res = array();
      $res['dat'] = $this->renderPartial('_rowRekeningPenerimaan', array('r' => $r, 'dk' => $dk), true);

      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }
}
