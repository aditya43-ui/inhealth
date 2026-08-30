<?php
class InformasiDaftarDokterController extends MyAuthController
{
  public function actionIndex()
  {
    $format = new MyFormatter();
    $modDokter = new PPPegawaiM();

    if (isset($_REQUEST['PPPegawaiM'])) {
      $modDokter->attributes = $_REQUEST['PPPegawaiM'];
    }

    $this->render('index', array('modDokter' => $modDokter));
  }

  /**
   * untuk menampilkan data dokter dari autocomplete
   * - nomorindukpegawai
   * - nama_pegawai
   */
  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nomorindukpegawai, nama_pegawai';
      $criteria->limit = 5;

      $models = PPPegawaiM::model()->findAll($criteria); //default

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->nomorindukpegawai;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Ajax untuk mengubah status dokter dari informasi
   */
  public function actionUbahStatusDokter($pegawai_id)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $model = PPPegawaiM::model()->findByPk($pegawai_id);
    if (isset($_POST['PPPegawaiM'])) {
      $update = PPPegawaiM::model()->updateByPk($pegawai_id, array('pegawai_aktif' => $_POST['PPPegawaiM']['pegawai_aktif']));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->refresh();
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $this->render('_formUbahStatusDokter', array(
      'model' => $model,
    ));
  }

  /**
   * untuk mengambil data pegawai
   */
  public function actionGetDataDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $model = PPPegawaiM::model()->findByPk($pegawai_id);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal['nama_pegawai'] = $model->NamaLengkap;
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }
}
