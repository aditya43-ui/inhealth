<?php

/**
 * controller dimodifikasi karena ada perubahan layout 
 * BMB-166
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            <http://.com>
 * @package         application.modules.sistemAdministrator
 * @subpackage      controllers
 * 
 */
class RuanganpegawaiMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.ruanganpegawaiM.';

  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }

  public function actionAdmin()
  {
    $model = new SARuanganpegawaiM('search');
    $model->unsetAttributes();
    if (isset($_GET['SARuanganpegawaiM'])) {
      $model->attributes = $_GET['SARuanganpegawaiM'];
      $model->nama_pegawai = $_GET['SARuanganpegawaiM']['nama_pegawai'];
    }
    $this->render($this->path_view . 'admin', array('model' => $model));
  }

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    // {
    //     throw new CHttpException(401,'mds','You are probihited to access this page. Contact Super Administrator');
    // }
    $model = new RuanganpegawaiM;
    $modDetails = array();
    $ruangansession = Yii::app()->user->ruangan_id;
    if (isset($_POST['pegawai_id'])) {
      $modDetails = $this->validasiTabular($_POST['pegawai_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['pegawai_id']); $i++) {
          $model = new RuanganpegawaiM;
          $model->ruangan_id = $ruangansession;
          $model->pegawai_id = $_POST['pegawai_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['pegawai_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', ' Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', ' Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new RuanganpegawaiM;
      $modDetails[$i]->instalasi_id = Yii::app()->user->instalasi_id;
      $modDetails[$i]->ruangan_id = Yii::app()->user->ruangan_id;
      $modDetails[$i]->pegawai_id = $row;
      $modDetails[$i]->validate();
    }

    return $modDetails;
  }

  public function actionUpdate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    // {
    //     throw new CHttpException(401,'mds','You are probihited to access this page. Contact Super Administrator');
    // }
    $model = new RuanganpegawaiM;
    $modDetails = array();
    $ruangansession = Yii::app()->user->ruangan_id;
    if (isset($_POST['pegawai_id'])) {
      $modDetails = $this->validasiTabular($_POST['pegawai_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['pegawai_id']); $i++) {
          $model = new RuanganpegawaiM;
          $model->ruangan_id = $ruangansession;
          $model->pegawai_id = $_POST['pegawai_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['pegawai_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', ' Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', 'Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'update', array('model' => $model, 'modDetails' => $modDetails));
  }

  // public function actionDelete($id, $pegawai)
  // {
  //         $this->loadModel($id, $pegawai)->delete();
  //         if(!isset($_GET['ajax']))
  //                 $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  // }

  public function actionDelete()
  {
    $id = $_GET['id'];
    $this->loadModel($id['ruangan_id'], $id['pegawai_id'])->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($id, $pegawai = null)
  {
    if (empty($pegawai)) {
      $model = RuanganpegawaiM::model()->findByAttributes(array('ruangan_id' => $id));
    } else {
      $model = RuanganpegawaiM::model()->findByAttributes(array('ruangan_id' => $id, 'pegawai_id' => $pegawai));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPrint()
  {
    $model = new SARuanganpegawaiM;
    $model->attributes = $_REQUEST['SARuanganpegawaiM'];
    $model->ruangan_nama = isset($_REQUEST['SARuanganpegawaiM']['ruangan_nama']) ? $_REQUEST['SARuanganpegawaiM']['ruangan_nama'] : null;
    $model->nama_pegawai = isset($_REQUEST['SARuanganpegawaiM']['nama_pegawai']) ? $_REQUEST['SARuanganpegawaiM']['nama_pegawai'] : null;

    // echo "<pre>"; print_r($model->attributes);exit();
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
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      // $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      // $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

  public function actionRuanganpegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST['instalasi_id'];
      $ruanganid = $_POST['ruanganid'];
      $pegawai_id = $_POST['pegawai_id'];

      $modinstalasi = InstalasiM::model()->findByPK($instalasi_id);
      $modruangan = RuanganM::model()->findByPK($ruanganid);
      $modpegawai = PegawaiM::model()->findByPK($pegawai_id);

      $modkelasruangan = new KelasruanganM;
      $tr = "<tr>";
      $tr .= "<td>"
        . $modinstalasi->instalasi_nama
        . CHtml::hiddenField('ruangan_id[]', $ruanganid, array('readonly' => true))
        . CHtml::hiddenField('pegawai_id[]', $pegawai_id, array('class' => 'pegawai', 'readonly' => true))
        . "</td>";
      $tr .= "<td>" . $modruangan->ruangan_nama . "</td>";
      $tr .= "<td>" . $modruangan->ruangan_namalainnya . "</td>";
      $tr .= "<td>" . $modpegawai->NamaLengkap . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusBaris(this); return false;')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
