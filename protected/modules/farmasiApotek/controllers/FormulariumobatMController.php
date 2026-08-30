<?php

class FormulariumobatMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'farmasiApotek.views.formulariumobatM.';
  public $path_tips = 'farmasiApotek.views.tips.';

  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }

  public function actionAdmin($sukses = '')
  {
    $this->pageTitle = Yii::app()->name . " - Formularium Obat";
    $model = new FAFormulariumobatM();
    $model->unsetAttributes();
    if (isset($_GET['FAFormulariumobatM'])) {
      $model->attributes = $_GET['FAFormulariumobatM'];
      $model->obatalkes_id = isset($_GET['FAFormulariumobatM']['obatalkes_id']) ? $_GET['FAFormulariumobatM']['obatalkes_id'] : '';
      $model->jenisformularium = isset($_GET['FAFormulariumobatM']['jenisformularium']) ? $_GET['FAFormulariumobatM']['jenisformularium'] : '';
      $model->carabayar_id = isset($_GET['FAFormulariumobatM']['carabayar_id']) ? $_GET['FAFormulariumobatM']['carabayar_id'] : '';
      $model->penjamin_id = isset($_GET['FAFormulariumobatM']['penjamin_id']) ? $_GET['FAFormulariumobatM']['penjamin_id'] : '';
    }

    $this->render($this->path_view . 'admin', array('model' => $model));
  }

  public function actionCreate()
  {
    $model = new FormulariumobatM;
    if (isset($_POST['FormulariumobatM'])) {
      $modDetails = $this->validasiTabular($model, $_POST['FormulariumobatM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        foreach ($_POST['FormulariumobatM'] as $j => $row) {
          
          $model = new FormulariumobatM();
          $model->attributes = $row;
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['FormulariumobatM'])) {
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
    $this->render($this->path_view . 'create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($model, $data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new FormulariumobatM;
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionUpdate($id)
  {
    $model = FAFormulariumobatM::model()->findByPk($id);
    $model->obatalkes = ObatalkesM::model()->findByPk($model->obatalkes_id)->obatalkes_nama;
    if (isset($_POST['FAFormulariumobatM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      
      try {
        $model->attributes = $_POST['FAFormulariumobatM'];
        $ok & $model->save();
        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
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
    $this->render($this->path_view . 'update', array('model' => $model));
  }

  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      $this->loadModel($id)->delete();

      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($id)
  {
    $model = FAFormulariumobatM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPrint()
  {
    $model = new FAFormulariumobatM;
    $model->attributes = $_REQUEST['FAFormulariumobatM'];
    $judulLaporan = 'Formulasi Obat';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionGetTabel() {
    if (Yii::app()->request->isAjaxRequest) {
        $obatalkes_id = $_POST['obatalkes_id'];
        $jenisformularium = $_POST['jenisformularium'];
        $carabayar_id = $_POST['carabayar_id'];
        $penjamin_id = $_POST['penjamin_id'];
        $is_aktif = $_POST['is_aktif'];
        
        $modObatalkes = ObatalkesM::model()->findByPK($obatalkes_id);
        $modCarabayar = CarabayarM::model()->findByPK($carabayar_id);
        $modPenjamin = PenjaminpasienM::model()->findByPK($penjamin_id);

        $model = new FormulariumobatM;
        $model->obatalkes_id = $obatalkes_id;
        $model->obatalkes_nama = $modObatalkes->obatalkes_nama;
        $model->carabayar_id = $carabayar_id;
        $model->carabayar_nama = $modCarabayar->carabayar_nama;
        $model->penjamin_id = $penjamin_id;
        $model->penjamin_nama = $modPenjamin->penjamin_nama;
        $model->jenisformularium = $jenisformularium;
        $model->is_aktif = $is_aktif;

        $return = $this->renderPartial($this->path_view . "_row", array('model' => $model, 'i' => 1), true);

        $data['return'] = $return;
        echo json_encode($data);
        Yii::app()->end();
    }
  }

  public function actionGetPenjaminPasien($encode=false)
    {
      if(Yii::app()->request->isAjaxRequest) {
          $carabayar_id = $_POST['carabayar_id'];
          if($encode)
          {
              if(empty($carabayar_id)){
                  $penjamin = array();
              } else {
                  $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
                  $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
              }
              echo CJSON::encode($penjamin);
          } else {
              if(empty($carabayar_id)){
                  echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
              } else {
                  $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
                  if(count((array)$penjamin) > 1)
                  {
                      echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                  }
                  $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
                  foreach($penjamin as $value=>$name) {
                      echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                  }
              }
          }
      }
      Yii::app()->end();
    }
}
