<?php

class VerifikasiKeluarRuangPulihController extends MyAuthController
{

  public $layout = '//layouts/iframe';

  function actionIndex($pasienmasukpenunjang_id)
  {
    $model = PasienruangpulihT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($model)) {
      echo "Harus dilakukan masuk ke ruang pulih terlebih dahulu";
      Yii::app()->end();
    }

    $verifikasi = VerifikasikeluarRuangpulihT::model()->findByAttributes(array(
      'pasienruangpulih_id' => $model->pasienruangpulih_id,
    ));

    if(empty($verifikasi)){
      $verifikasi = New VerifikasikeluarRuangpulihT;
    }

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $admisi = PasienadmisiT::model()->findByPk($penunjang->pasienadmisi_id);

    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $skor = AldrettepasienruangpulihT::model()->findByAttributes(array(
      'pasienruangpulih_id' => $model->pasienruangpulih_id,
      'jenisaldrette' => 'Keluar Ruang Pulih',
    ));
    if(empty($skor)){
      $skor = New AldrettepasienruangpulihT;
    }

    $modelNyeri = AsesmentnyeriT::model()->findByPk($model->asesmentnyeri_id);
    if(empty($modelNyeri)){
      $modelNyeri = New AsesmentnyeriT;
    }


    if (isset($_POST['VerifikasikeluarRuangpulihT'])) {
      $pegawai_login = Yii::app()->user->getState('pegawai_id');
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $verifikasi->attributes = $_POST['VerifikasikeluarRuangpulihT'];

        if ($verifikasi->dokteranastesi_id == $pegawai_login) {
          $verifikasi->verifikasidokteranastesi_status = true;
        }
        if ($verifikasi->perawatanastesi_id == $pegawai_login) {
          $verifikasi->verifikasiperawatanastesi_status = true;
        }
        if ($verifikasi->verifikasidokteranastesi_status && $verifikasi->verifikasiperawatanastesi_status) {
          $verifikasi->serahterima_status = true;
        }

        $verifikasi->verifikasiperawatanastesi_jam = empty($verifikasi->verifikasiperawatanastesi_jam) ? null : $verifikasi->verifikasiperawatanastesi_jam;
        $verifikasi->verifikasidokteranastesi_jam = empty($verifikasi->verifikasidokteranastesi_jam) ? null : $verifikasi->verifikasidokteranastesi_jam;
        $verifikasi->serahterima_jam = empty($verifikasi->serahterima_jam) ? null : $verifikasi->serahterima_jam;

        // var_dump($verifikasi->attributes); die;

        if ($verifikasi->validate()) {
          $ok = $ok && $verifikasi->save();
        } else {
          $ok = false;
        }

        //                var_dump($ok, $verifikasi->attributes);
        //                die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }


    $this->render('index', array(
      'model' => $model,
      'verifikasi' => $verifikasi,
      'penunjang' => $penunjang,
      'admisi' => $admisi,
      'anestesi' => $anestesi,
      'rencana' => $rencana,
      'skor' => $skor,
      'modelNyeri' => $modelNyeri,
    ));
  }
}
