<?php
class PencatatanPekerjaanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex($id = null)
  {
    $model = new KPPegawaiM;
    if (!empty($id)) {
      $model = KPPegawaiM::model()->findByPk($id);
    }
    $this->render('index', array('model' => $model));
  }

  public function actionPegawairiwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      $reutrnVal = array();

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPegawairiwayatNip()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nomorindukpegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      $reutrnVal = array();

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = PegawaiM::model()->findByAttributes(array('pegawai_id' => $_POST['idPegawai']));
      $post = array(
        'nomorindukpegawai' => $data->nomorindukpegawai,
        'pegawai_id' => $data->pegawai_id,
        'nama_pegawai' => $data->nama_pegawai,
        'tempatlahir_pegawai' => $data->tempatlahir_pegawai,
        'tgl_lahirpegawai' => $data->tgl_lahirpegawai,
        'jabatan_nama' => (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
        'pangkat_nama' => (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
        'kategoripegawai' => $data->kategoripegawai,
        'kategoripegawaiasal' => $data->kategoripegawaiasal,
        'kelompokpegawai_nama' => (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
        'pendidikan_nama' => (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'alamat_pegawai' => $data->alamat_pegawai,
        'tglditerima' => $data->tglditerima,
        'jabatan_id' => $data->jabatan_id,
        'unitkerja_id' => $data->unitkerja_id,
        'photopegawai' => (!is_null($data->photopegawai) ? $data->photopegawai : ''),
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }
}
