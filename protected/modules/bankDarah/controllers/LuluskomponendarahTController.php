<?php

/**
 * Digunakan untuk Transaksi Lulus Komponen Darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class LuluskomponendarahTController extends MyAuthController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'bankDarah.views.luluskomponendarahT';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   * @param integer $kantongdarah_id
   */
  public function actionViewKantong($kantongdarah_id)
  {
    $this->layout = '//layouts/iframe';
    $model = new LuluskomponendarahT;
    if (!empty($kantongdarah_id)) {
      $modKantong = InfokantongdarahV::model()->findByAttributes(array('kantongdarah_id' => $kantongdarah_id));
      $modKantongDarah = InfokantongdarahV::model()->findAllByAttributes(array('kantongdarah_id' => $modKantong->kantongdarah_id));
    }
    $this->render('create', array(
      'modKantong' => $modKantong,
      'modKantongDarah' => $modKantongDarah,
      'model' => $model,
    ));
  }

  /**
   * Membuat data pelulusan komponen darah
   * @param type $nomorbarcode
   */
  public function actionCreate($nomorbarcode = null)
  {
    $model = new LuluskomponendarahT;
    $modelKantongDarah = new KantongdarahT;
    $modelStok = new StokkantongdarahT;
    $modKantong = new InfokantongdarahV();
    $format = new MyFormatter();
    $model->tglpelulusan = date('d M Y H:i:s');
    $modKantongDarah = ' ';
    $kepalaInstalasi = PegawaiM::model()->findByPk(Params::JABATAN_KEPALA_INSTALASI_BANK_DARAH);
    if (!empty($kepalaInstalasi)) {
      $model->kepalainstalasi_id = $kepalaInstalasi->pegawai_id;
      $model->kepalainstalasi_nama = $kepalaInstalasi->namaLengkap;
    }
    if (isset($nomorbarcode) && $nomorbarcode != null) {
      $modKantong = InfokantongdarahV::model()->findByAttributes(array('nomorbarcode' => $nomorbarcode));
      $modelKantongDarah = KantongdarahT::model()->findByAttributes(array('kantongdarah_id' => $modKantong->kantongdarah_id));
      if (!empty($modKantong->periksakomponendarah_id)) {
        $periksa = PeriksakomponendarahT::model()->findByPk($modKantong->periksakomponendarah_id);
        if (!empty($periksa)) {
          if (!empty($periksa->volume)) {
            $modKantong->volume = $periksa->volume;
          } else {
            $modKantong->volume = '';
          }
        } else {
          $modKantong->volume = '';
        }
      } else {
        $modKantong->volume = '';
      }
    }

    if (isset($_POST['LuluskomponendarahT'])) {
      $model->attributes = $_POST['LuluskomponendarahT'];
      $model->tglpelulusan = MyFormatter::formatDateTimeForDb($model->tglpelulusan);
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->statuspelulusan = $model->statuspelulusan;
      if (!empty($_POST['LuluskomponendarahT']['alasantidaklulus'])) {
        $model->alasantidaklulus = $_POST['LuluskomponendarahT']['alasantidaklulus'];
      }
      if (!empty($_POST['LuluskomponendarahT']['keteranganpelulusan'])) {
        $model->keteranganpelulusan = $_POST['LuluskomponendarahT']['keteranganpelulusan'];
      }
      // menyimpan kantongdarah_id
      $model->kantongdarah_id = $_POST['InfokantongdarahV']['kantongdarah_id'];
      $model->validate();
      if ($model->save()) {
        KantongdarahT::model()->updateByPk($model->kantongdarah_id, array('luluskomponendarah_id' => $model->luluskomponendarah_id));
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame'])) {
          $this->redirect(array('create', 'nomorbarcode' => $modKantong->no_kantongdarah, 'frame' => 1, 'sukses' => 1));
        } else {
          $this->redirect(array('create', 'nomorbarcode' => $modKantong->no_kantongdarah, 'sukses' => 1));
        }
      }
    }
    $this->render('create', array(
      'modKantong' => $modKantong,
      'modKantongDarah' => $modKantongDarah,
      'model' => $model,
    ));
  }

  /**
   * Menampilkan halaman detail lulus komponen darah
   * @param type $no_kantongdarah
   */
  public function actionDetail($no_kantongdarah)
  {
    $this->layout = '//layouts/iframe';
    $modKantong = InfokantongdarahV::model()->findByAttributes(array('no_kantongdarah' => $no_kantongdarah));
    $model = LuluskomponendarahT::model()->findByAttributes(array('luluskomponendarah_id' => $modKantong->luluskomponendarah_id));

    if (!empty($no_kantongdarah)) {
      $modelKantongDarah = KantongdarahT::model()->findByAttributes(array('no_kantongdarah' => $modKantong->no_kantongdarah));
      $modKantongDarah = InfokantongdarahV::model()->findAllByAttributes(array('no_kantongdarah' => $modKantong->no_kantongdarah));
    }
    $this->render('_detailView', array(
      'modKantong' => $modKantong,
      'modKantongDarah' => $modKantongDarah,
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
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
   * Memanggil dan menonaktifkan status 
   * * @param integer $id
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      // $model->modelaktif = false;
      // if($model->save()){
      //	$data['sukses'] = 1;
      // }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('LuluskomponendarahT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new LuluskomponendarahT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['LuluskomponendarahT'])) {
      $model->attributes = $_GET['LuluskomponendarahT'];
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = LuluskomponendarahT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'luluskomponendarah-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new LuluskomponendarahT;
    $model->attributes = $_REQUEST['LuluskomponendarahT'];
    $judulLaporan = 'Data LuluskomponendarahT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * mencari data pegawai, sesuai yang di ketikkan
   */
  public function actionAutoCompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition('instalasi_id = ' . Yii::app()->user->getState('instalasi_id'));
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
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
}
