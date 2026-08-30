<?php

class KeperawatanJiwaController extends MyAuthController
{
  public $path_view = "rawatJalan.views.keperawatanJiwa.";

  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $model = PengkajiankeperawatanjiwaT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    if (empty($model)) {
      $model = new PengkajiankeperawatanjiwaT;
      $model->pendaftaran_id = $pendaftaran_id;
      $model->tgl_pengkajian = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    }

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    if (isset($_POST['PengkajiankeperawatanjiwaT'])) {

      try {
        $ok = true;
        $trans = Yii::app()->db->beginTransaction();

        $model->attributes = $_POST['PengkajiankeperawatanjiwaT'];
        $model->tgl_pengkajian = MyFormatter::formatDateTimeForDb($model->tgl_pengkajian);


        if (empty($model->mekanismekoping_adaptif) || !is_array($model->mekanismekoping_adaptif_lainnya) || !in_array('Lainnya', $model->mekanismekoping_adaptif)) {
          $model->mekanismekoping_adaptif_lainnya = "";
        }
        if (empty($model->mekanismekoping_maladaptif) || !is_array($model->mekanismekoping_maladaptif) || !in_array('Lainnya', $model->mekanismekoping_maladaptif)) {
          $model->mekanismekoping_maladaptif_lainnya = "";
        }
        if (empty($model->pengetahuankurang) || !is_array($model->pengetahuankurang) || !in_array('Lainnya', $model->pengetahuankurang)) {
          $model->pengetahuankurang_lainnya = "";
        }

        $mod_istirahat = $model->kebutuhanpulang_istirahat;

        if (is_array($mod_istirahat)) {
          if (isset($mod_istirahat['siang_lama'])) {
            if (!isset($mod_istirahat['siang_lama']['nilai'])) {
              unset($mod_istirahat['siang_lama']);
            }
          }
          if (isset($mod_istirahat['malam_lama'])) {
            if (!isset($mod_istirahat['malam_lama']['nilai'])) {
              unset($mod_istirahat['malam_lama']);
            }
          }
        }

        $model->kebutuhanpulang_istirahat = $mod_istirahat;

        foreach ($model->jsonColumn as $attr) {
          if (is_array($model->$attr)) {
            $model->$attr = CJSON::encode($model->$attr);
          }
        }

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id));
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    if (!empty($model)) {

      if (!$model->prediosposisi_anggotakeluraga_gangguan) {
        $model->prediosposisi_anggotakeluraga_gangguan = 0;
      }
      if (!$model->prediosposisi_gangunajiwa_masalalu) {
        $model->prediosposisi_gangunajiwa_masalalu = 0;
      }

      foreach ($model->jsonColumn as $attr) {
        $model->$attr = CJSON::decode($model->$attr);
      }
    }


    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien
    ));
  }

  public function actionPrint($id, $print = true)
  {

    $this->layout = '//layouts/iframe';

    if ($print) {
      $this->layout = '//layouts/printWindows';
    }

    $model = PengkajiankeperawatanjiwaT::model()->findByAttributes(array(
      'pendaftaran_id' => $id
    ));
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $model->tgl_pengkajian = MyFormatter::formatDateTimeForUser($model->tgl_pengkajian);

    if (!$model->prediosposisi_anggotakeluraga_gangguan) {
      $model->prediosposisi_anggotakeluraga_gangguan = 0;
    }
    if (!$model->prediosposisi_gangunajiwa_masalalu) {
      $model->prediosposisi_gangunajiwa_masalalu = 0;
    }

    foreach ($model->jsonColumn as $attr) {
      $model->$attr = CJSON::decode($model->$attr);
    }

    $this->render($this->path_view . 'print', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien
    ));
  }
}
