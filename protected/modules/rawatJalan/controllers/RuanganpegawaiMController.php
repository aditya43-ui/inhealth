<?php

class RuanganpegawaiMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'rawatJalan.views.ruanganpegawaiM.';

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionAdmin()
  {
    $model = new RJRuanganpegawaiM('search');
    $model->unsetAttributes();
    if (isset($_GET['RJRuanganpegawaiM']))
      $model->attributes = $_GET['RJRuanganpegawaiM'];
    $this->render($this->path_view . 'admin', array('model' => $model));
  }

  public function actionCreate()
  {
    $model = new RJRuanganpegawaiM;
    $modDetails = array();
    $ruangansession = Yii::app()->user->ruangan_id;
    if (isset($_POST['pegawai_id'])) {
      $modDetails = $this->validasiTabular($_POST['pegawai_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['pegawai_id']); $i++) {
          $model = new RJRuanganpegawaiM;
          $model->ruangan_id = $ruangansession;
          $model->pegawai_id = $_POST['pegawai_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['pegawai_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new RJRuanganpegawaiM;
      $modDetails[$i]->instalasi_id = Yii::app()->user->instalasi_id;
      $modDetails[$i]->ruangan_id = Yii::app()->user->ruangan_id;
      $modDetails[$i]->pegawai_id = $row;
      $modDetails[$i]->validate();
    }

    return $modDetails;
  }

  public function actionUpdate()
  {
    $model = new RJRuanganpegawaiM;
    $modDetails = array();
    $ruangansession = Yii::app()->user->ruangan_id;
    if (isset($_POST['pegawai_id'])) {
      $modDetails = $this->validasiTabular($_POST['pegawai_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['pegawai_id']); $i++) {
          $model = new RJRuanganpegawaiM;
          $model->ruangan_id = $ruangansession;
          $model->pegawai_id = $_POST['pegawai_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['pegawai_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'update', array('model' => $model, 'modDetails' => $modDetails));
  }

  public function actionDelete($ruangan_id, $pegawai_id)
  {
    $this->loadModel($ruangan_id, $pegawai_id)->delete();

    if (!isset($_GET['ajax'])) {
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
  }

  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($ruangan_id, $pegawai = null)
  {
    if (empty($pegawai)) {
      $model = RJRuanganpegawaiM::model()->findByAttributes(array('ruangan_id' => $ruangan_id));
    } else {
      $model = RJRuanganpegawaiM::model()->findByAttributes(array('ruangan_id' => $ruangan_id, 'pegawai_id' => $pegawai));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPrint()
  {
    $model = new RJRuanganpegawaiM;
    if (isset($_REQUEST['RJRuanganpegawaiM'])) {
      $model->attributes = $_REQUEST['RJRuanganpegawaiM'];
    }
    $judulLaporan = 'Data Pegawai Ruangan';
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionRuanganpegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST['instalasi_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;

      $modinstalasi = InstalasiM::model()->findByPK($instalasi_id);
      $modruangan = RuanganM::model()->findByPK($ruangan_id);
      $modpegawai = PegawaiM::model()->findByPK($pegawai_id);

      $modkelasruangan = new KelasruanganM;
      $tr = "<tr>";
      $tr .= "<td>"
        . $modinstalasi->instalasi_nama
        . CHtml::hiddenField('ruangan_id[]', $ruangan_id, array('readonly' => true))
        . CHtml::hiddenField('pegawai_id[]', $pegawai_id, array('readonly' => true))
        . "</td>";
      $tr .= "<td>" . $modruangan->ruangan_nama . "</td>";
      $tr .= "<td>" . $modruangan->ruangan_namalainnya . "</td>";
      $tr .= "<td>" . $modpegawai->NamaLengkap . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='icon-remove'></i>", '#', array('onclick' => 'hapusBaris(this); return false;')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
