<?php

class KasuspenyakitobatMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionAdmin($sukses = '')
  {
    $this->pageTitle = Yii::app()->name . " - Kasus Penyakit Obat";
    $model = new FAKasuspenyakitobatM();
    $model->unsetAttributes();
    if (isset($_GET['FAKasuspenyakitobatM'])) {
      $model->attributes = $_GET['FAKasuspenyakitobatM'];
      $model->obatalkes_kode = isset($_GET['FAKasuspenyakitobatM']['obatalkes_kode']) ? $_GET['FAKasuspenyakitobatM']['obatalkes_kode'] : '';
      $model->obatalkes_nama = isset($_GET['FAKasuspenyakitobatM']['obatalkes_nama']) ? $_GET['FAKasuspenyakitobatM']['obatalkes_nama'] : '';
      $model->jeniskasuspenyakit_nama = isset($_GET['FAKasuspenyakitobatM']['jeniskasuspenyakit_nama']) ? $_GET['FAKasuspenyakitobatM']['jeniskasuspenyakit_nama'] : '';
    }

    $this->render('admin', array('model' => $model));
  }

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    // {
    //     throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));
    // }
    $model = new KasuspenyakitobatM;
    if (isset($_POST['KasuspenyakitobatM'])) {
      $modDetails = $this->validasiTabular($model, $_POST['KasuspenyakitobatM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        foreach ($_POST['KasuspenyakitobatM'] as $j => $row) {
          $model = new KasuspenyakitobatM();
          $model->attributes = $row;
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['KasuspenyakitobatM'])) {
          $transaction->commit();

          Yii::app()->user->setFlash('success', "Data " . $model->obatalkes->obatalkes_nama . " berhasil disimpan");
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', ' Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    } else {
      $modDetails = null;
    }
    $this->render('create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($model, $data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new KasuspenyakitobatM;
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE))
    // {
    //     throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));
    // }
    $model = new KasuspenyakitobatM;
    $modDetails = array();
    if (isset($_POST['KasuspenyakitobatM'])) {
      $modDetails = $this->validasiTabular($model, $_POST['KasuspenyakitobatM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        foreach ($_POST['KasuspenyakitobatM'] as $j => $row) {
          $model = new KasuspenyakitobatM();
          $model->attributes = $row;
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['KasuspenyakitobatM'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data " . $model->obatalkes->obatalkes_nama . " berhasil disimpan");
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render('update', array('model' => $model, 'modDetails' => $modDetails));
  }

  public function actionDelete($id, $obatalkes)
  {
    //            $model = $this->loadModel($id,$obatalkes)->delete();
    $model = KasuspenyakitobatM::model()->deleteAllByAttributes(array('jeniskasuspenyakit_id' => $id, 'obatalkes_id' => $obatalkes));
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($id, $obatalkes = null)
  {
    $criteria = new CDbCriteria;
    $criteria->select = 'obatalkes.*,t.*,jeniskasuspenyakit.*';
    if (!empty($id)) {
      $criteria->addCondition("t.jeniskasuspenyakit_id = " . $id);
    }
    $criteria->join = 'LEFT JOIN obatalkes_m obatalkes ON t.obatalkes_id = obatalkes.obatalkes_id '
      . '  LEFT JOIN jeniskasuspenyakit_m jeniskasuspenyakit ON t.jeniskasuspenyakit_id = jeniskasuspenyakit.jeniskasuspenyakit_id';
    if (empty($obatalkes)) {
      $model = FAKasuspenyakitobatM::model()->find($criteria);
    } else {
      $model = FAKasuspenyakitobatM::model()->findByAttributes(array('jeniskasuspenyakit_id' => $id, 'obatalkes_id' => $obatalkes));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPrint()
  {
    $model = new FAKasuspenyakitobatM;
    $model->attributes = $_REQUEST['FAKasuspenyakitobatM'];
    $judulLaporan = 'Data Kasus Penyakit Obat';
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

  public function actionKasuspenyakitobatM()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'];
      $obatalkes_id = $_POST['obatalkes_id'];

      $modjeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPK($jeniskasuspenyakit_id);
      $modobatalkes = ObatalkesM::model()->findByPK($obatalkes_id);

      $modKasuspenyakitobat = new KasuspenyakitobatM;
      $tr = "<tr>";
      $tr .= "<td>"
        . $modjeniskasuspenyakit->jeniskasuspenyakit_nama
        . CHtml::activehiddenField($modKasuspenyakitobat, '[]jeniskasuspenyakit_id', array('readonly' => true, 'value' => $jeniskasuspenyakit_id, 'class' => 'jenispenyakit'))
        . CHtml::activehiddenField($modKasuspenyakitobat, '[]obatalkes_id', array('readonly' => true, 'value' => $obatalkes_id))
        . "</td>";
      $tr .= "<td>" . $modobatalkes->obatalkes_kode . "</td>";
      $tr .= "<td>" . $modobatalkes->obatalkes_nama . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusBaris(this);')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
