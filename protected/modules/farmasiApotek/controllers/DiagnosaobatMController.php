<?php

class DiagnosaobatMController extends MyAuthController
{
  public $defaultAction = 'admin';
  public $layout = '//layouts/column1';

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionAdmin($sukses = '')
  {


    $this->pageTitle = Yii::app()->name . " - Diagnosa Obat";
    $model = new FADiagnosaobatM('search');
    $model->unsetAttributes();
    if (isset($_GET['FADiagnosaobatM'])) {
      $model->attributes = $_GET['FADiagnosaobatM'];
      $model->diagnosa_kode = isset($_GET['FADiagnosaobatM']['diagnosa_kode']) ? $_GET['FADiagnosaobatM']['diagnosa_kode'] : '';
      $model->diagnosa_nama = isset($_GET['FADiagnosaobatM']['diagnosa_nama']) ? $_GET['FADiagnosaobatM']['diagnosa_nama'] : '';
      $model->obatalkes_nama = isset($_GET['FADiagnosaobatM']['obatalkes_nama']) ? $_GET['FADiagnosaobatM']['obatalkes_nama'] : '';
      $model->obatalkes_id = isset($_GET['FADiagnosaobatM']['obatalkes_id']) ? $_GET['FADiagnosaobatM']['obatalkes_id'] : '';
      $model->diagnosa_id = isset($_GET['FADiagnosaobatM']['diagnosa_id']) ? $_GET['FADiagnosaobatM']['diagnosa_id'] : '';
    }
    $this->render('admin', array('model' => $model));
  }

  public function actionCreate()
  {
    //                    if (!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) {
    //                       throw new CHttpException(401,Yii::t('mds','You are probihited to acces this page. Contact Super Administrator')); 
    //                    }

    $model = new FADiagnosaobatM;
    if (isset($_POST['FADiagnosaobatM'])) {
      $modDetails = $this->validasiTabular($model, $_POST['FADiagnosaobatM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        foreach ($_POST['FADiagnosaobatM'] as $i => $row) {
          $model = new FADiagnosaobatM;
          $model->attributes = $row;
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['FADiagnosaobatM'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', ' Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', ' Data Gagal disimpan');
      }
    } else {
      $modDetails = null;
    }
    $this->render('create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($model, $data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new FADiagnosaobatM;
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionUpdate($id)
  {
    //                    if (!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) {
    //                       throw new CHttpException(401,Yii::t('mds','You are probihited to acces this page. Contact Super Administrator')); 
    //                    }
    $modDetails = array();
    $model = new FADiagnosaobatM;
    if (isset($_POST['FADiagnosaobatM'])) {
      $modDetails = $this->validasiTabular($model, $_POST['FADiagnosaobatM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        foreach ($_POST['FADiagnosaobatM'] as $i => $row) {
          $model = new FADiagnosaobatM;
          $model->attributes = $row;
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['FADiagnosaobatM'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', ' Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', ' Data Gagal disimpan');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', ' Data Gagal disimpan');
      }
    }
    $this->render('update', array('model' => $model, 'modDetails' => $modDetails));
  }

  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function actionDelete($id, $obatalkes)
  {
    $this->loadModel($id, $obatalkes)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function loadModel($id, $obatalkes = null)
  {
    if (empty($obatalkes)) {
      $model = DiagnosaobatM::model()->findByAttributes(array('diagnosa_id' => $id));
    } else {
      $model = DiagnosaobatM::model()->findByAttributes(array('diagnosa_id' => $id, 'obatalkes_id' => $obatalkes));
    }
    if ($model === null) {
      throw new CHttpException(404, 'The request Page does not exist');
    }
    return $model;
  }

  public function actionPrint()
  {
    $model = new FADiagnosaobatM;
    $model->attributes = $_REQUEST['FADiagnosaobatM'];
    $judulLaporan = 'Data Diagnosa Obat';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionKasuspenyakitdiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $diagnosa_id = $_POST['diagnosa_id'];
      $obatakes_id = $_POST['obatalkes_id'];

      $moddiagnosa = DiagnosaM::model()->findByPK($diagnosa_id);
      $modobatalkes = ObatalkesM::model()->findByPK($obatakes_id);
      $model = new DiagnosaobatM;
      $tr = "<tr>";
      $tr .= "<td>"
        . $moddiagnosa->diagnosa_kode
        . CHtml::activehiddenField($model, '[]diagnosa_id', array('readonly' => true, 'value' => $diagnosa_id, 'class' => 'diagnosa'))
        . CHtml::activehiddenField($model, '[]obatalkes_id', array('readonly' => true, 'value' => $obatakes_id))
        . "</td>";
      $tr .= "<td>" . $moddiagnosa->diagnosa_nama . "</td>";
      $tr .= "<td>" . $modobatalkes->obatalkes_nama . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusBaris(this);')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
