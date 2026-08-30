<?php

class AmbilJenazahController extends MyAuthController
{
  protected $successSaveBarang;
  protected $validBarang = true;

  public function actionIndex($pendaftaran_id = '')
  {
    $this->pageTitle = Yii::app()->name . " - Pengambilan Jenazah";
    if (!empty($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $model = new PJAmbiljenazahT;
      $model->pendaftaran_id = $pendaftaran_id;
      $model->pasien_id = $modPendaftaran->pasien_id;
      $model->no_pendaftaran = $modPendaftaran->no_pendaftaran;
      $model->no_rekam_medik = $modPasien->no_rekam_medik;
    } else {
      $model = new PJAmbiljenazahT;
    }

    $model->tglmeninggal = date('d M Y H:i:s');
    $model->tglpengambilan = date('d M Y H:i:s');
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));
    $instalasi = CHtml::listData(InstalasiM::model()->findAll(), 'instalasi_id', 'instalasi_nama');
    $ruanganMeninggal = CHtml::listData(RuanganM::model()->getRuanganByInstalasi($model->instalasi_id), 'ruangan_id', 'ruangan_nama');
    $model->ruanganmeninggal_id = Yii::app()->user->getState('ruangan_id');

    $modPenyBarang = new PJPenyerahanbarangpasienT;
    $modPenyBarang->no_urutbrg = 1;
    $modPenyBarangs = array();
    if (isset($_POST['PJAmbiljenazahT'])) {
      $instalasi = $_POST['PJAmbiljenazahT']['instalasi_id'];
      $format = new MyFormatter;
      $model->attributes = $_POST['PJAmbiljenazahT'];
      $model->tglpengambilan = $format->formatDateTimeForDb($_POST['PJAmbiljenazahT']['tglpengambilan']);
      $model->tglmeninggal = $format->formatDateTimeForDb($_POST['PJAmbiljenazahT']['tglmeninggal']);
      $model->ruangan_id = Yii::app()->user->ruangan_id;
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $model->save();
          $modPenyBarangs = $this->savePenyerahanBarang($model, $_POST['PJPenyerahanbarangpasienT']);
          if ($this->validBarang) {
            foreach ($modPenyBarangs as $i => $penyBarang) {
              $penyBarang->save();
            }
            $this->updatePasien($model);
            $transaction->commit();
            $sukses = 1;

            $this->redirect(array('index', 'sukses' => $sukses));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal disimpan." . '<pre>' . print_r($modPenyBarangs[0]->getErrors(), 1) . '</pre>');
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modInstalasi' => $modInstalasi,
      'instalasi' => $instalasi,
      'ruanganMeninggal' => $ruanganMeninggal,
      'modPenyBarang' => $modPenyBarang,
      'modPenyBarangs' => $modPenyBarangs
    ));
  }

  protected function savePenyerahanBarang($modAmbilJenazah, $post)
  {
    $valid;
    foreach ($post as $i => $item) {
      $modPenyBarangs[$i] = new PJPenyerahanbarangpasienT;
      $modPenyBarangs[$i]->attributes = $item;
      $modPenyBarangs[$i]->ambiljenazah_id = $modAmbilJenazah->ambiljenazah_id;
      $valid = $modPenyBarangs[$i]->validate();
      $this->validBarang = $this->validBarang && $valid;
    }

    return $modPenyBarangs;
  }

  protected function updatePasien($modAmbilJenazah)
  {
    PasienM::model()->updateByPk($modAmbilJenazah->pasien_id, array('tgl_meninggal' => $modAmbilJenazah->tglmeninggal));
  }

  public function actionDynamicRuangan()
  {
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => (int) $_POST['PJAmbiljenazahT']['instalasi_id'])
    );

    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }
  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::model()->getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_rekam_medik
   */
  public function actionAutocompletePasienJenazah()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->limit = 5;
      $models = PJPasienmasukpenunjangV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->pendaftaran_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
