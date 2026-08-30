<?php

class KomponenGajiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.komponenGaji.';

  /**
   * Lists all models.
   */
  public function actionIndex($id = null)
  {
    $format = new MyFormatter;
    $modelGaji = new KPKomponengajipegawaiM();
    $modPeg = new KPPegawaiM;
    $modKomGajiDet = new KPKomponengajipegawaiM;
    $cekKomGaji = KPKomponengajipegawaiM::model()->findAllByAttributes(array('pegawai_id' => $id));
    if (count((array)$cekKomGaji) > 0) {
      $modKomGajiDet = $cekKomGaji;
    }


    if (isset($_POST['KPKomponengajipegawaiM'])) {
      $ok = false;
      $transaction = Yii::app()->db->beginTransaction();
      try {

        foreach ($_POST['KPKomponengajipegawaiM'] as $iv => $value) {
          if (!empty($value['komponengajipegawai_id'])) {
            $modKomGajiDet = KPKomponengajipegawaiM::model()->findByPk($value['komponengajipegawai_id']);
          } else {
            $modKomGajiDet = new KPKomponengajipegawaiM;
          }

          $modKomGajiDet->attributes = $value;
          $modKomGajiDet->pegawai_id = $id;
          if ($modKomGajiDet->save()) {
            $ok = true;
          }
          //var_dump($modKomGajiDet->attributes);
        }

        if ($ok == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'id' => $id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "<strong>Gagal!</strong> Data Gagal Disimpan.");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if (!empty($id)) {
      $modPeg = KPPegawaiM::model()->findByPk($id);
      $modPeg->jabatan_id = (isset($modPeg->jabatan_id) ? $modPeg->jabatan_id : null);
      $modPeg->jabatan_nama = (isset($modPeg->jabatan_id) ? $modPeg->jabatan->jabatan_nama : "-");
      $modPeg->pangkat_id = (isset($modPeg->pangkat_id) ? $modPeg->pangkat_id : null);
      $modPeg->pangkat_nama = (isset($modPeg->pangkat_id) ? $modPeg->pangkat->pangkat_nama : "-");
      $modPeg->kelompokpegawai_id = (isset($modPeg->kelompokpegawai_id) ? $modPeg->kelompokpegawai_id : null);
      $modPeg->kelompokpegawai_nama = (isset($modPeg->kelompokpegawai_id) ? $modPeg->kelompokpegawai->kelompokpegawai_nama : "-");
      $modPeg->pendidikan_id = (isset($modPeg->pendidikan_id) ? $modPeg->pendidikan_id : null);
      $modPeg->pendidikan_nama = (isset($modPeg->pendidikan_id) ? $modPeg->pendidikan->pendidikan_nama : "-");
      $modPeg->tgl_lahirpegawai = (isset($modPeg->tgl_lahirpegawai) ? $format->formatDateTimeForUser($modPeg->tgl_lahirpegawai) : "-");
    }



    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modelGaji' => $modelGaji,
      'modPeg' => $modPeg,
      'modKomGajiDet' => $modKomGajiDet,
    ));
  }

  public function actionGetKomponenGaji()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = isset($_POST['id']) ? $_POST['id'] : null;

      $data = array();

      $kom = KomponengajiM::model()->findByPk($id);

      $data['sukses'] = 0;
      $data['pesan'] = 0;
      //var_dump($id);
      if (!empty($kom)) {
        $data['sukses'] = 1;
        $data['tipekomponen'] = $kom->tipekomponengaji;
        $data['jeniskomponen'] = ($kom->ispotongan == true) ? 'Potongan' : 'Gaji';
      } else {
        $data['sukses'] = 1;
        $data['tipekomponen'] = '';
        $data['jeniskomponen'] = '';
      }

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function actionDeleteKomponen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $data['sukses'] = 0;
      $model = KPKomponengajipegawaiM::model()->deleteByPk($id);
      if ($model) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }
}
