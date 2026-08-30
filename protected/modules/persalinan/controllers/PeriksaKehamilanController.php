<?php

class PeriksaKehamilanController extends MyAuthController
{
  public function actionIndex($pendaftaran_id)
  {
    $modPendaftaran = PSPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $format = new MyFormatter();

    $modRiwayatKehamilan = new PSPeriksakeHamilanT;
    $modRiwayatKehamilan->pasien_id = $modPasien->pasien_id;

    $cekPeriksaKehamilan = PSPeriksakeHamilanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($cekPeriksaKehamilan)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya
      $modPeriksaKehamilan = $cekPeriksaKehamilan;
    } else {
      ////Jika Pasien Belum Pernah melakukan Anamnesa
      $modPeriksaKehamilan = new PSPeriksakeHamilanT;
    }

    $temLogo = $modPeriksaKehamilan->filefotousg;

    if (isset($_POST['PSPeriksakeHamilanT'])) {
      $modPeriksaKehamilan->attributes = $_POST['PSPeriksakeHamilanT'];
      $modPeriksaKehamilan->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPeriksaKehamilan->pasien_id = $modPasien->pasien_id;
      $modPeriksaKehamilan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPeriksaKehamilan->tglpemeriksaaan = $format->formatDateTimeForDb($_POST['PSPeriksakeHamilanT']['tglpemeriksaaan']);
      $modPeriksaKehamilan->tglkehamilan = $format->formatDateTimeForDb($_POST['PSPeriksakeHamilanT']['tglkehamilan']);
      $modPeriksaKehamilan->tglakhirmenstruasi = $format->formatDateTimeForDb($_POST['PSPeriksakeHamilanT']['tglakhirmenstruasi']);
      $modPeriksaKehamilan->tglperkiraankelahiran = $format->formatDateTimeForDb($_POST['PSPeriksakeHamilanT']['tglperkiraankelahiran']);

      $modPeriksaKehamilan->filefotousg = CUploadedFile::getInstance($modPeriksaKehamilan, 'filefotousg');
      $gambar = $modPeriksaKehamilan->filefotousg;
      if (!empty($modPeriksaKehamilan->filefotousg)) //Klo User Memasukan Logo
      {
        $random = rand(000000, 999999);
        $modPeriksaKehamilan->filefotousg = $random . $modPeriksaKehamilan->filefotousg;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $modPeriksaKehamilan->filefotousg;
        $fullImgSource = Params::pathUSGDirectory() . $fullImgName;
        $fullThumbSource = Params::pathUSGTumbsDirectory() . 'kecil_' . $fullImgName;

        $modPeriksaKehamilan->filefotousg = $fullImgName;

        if ($modPeriksaKehamilan->save()) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');

          if (!empty($temLogo)) {
            unlink(Params::pathUSGDirectory() . $temLogo);
            unlink(Params::pathUSGTumbsDirectory() . 'kecil_' . $temLogo);
          }

          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);
        } else {
          Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
        }
      }

      if ($modPeriksaKehamilan->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      } else {
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }

    $modPeriksaKehamilan->tglpemeriksaaan = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPeriksaKehamilan->tglpemeriksaaan, 'yyyy-MM-dd hh:mm:ss')
    );

    $modPeriksaKehamilan->tglkehamilan = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPeriksaKehamilan->tglkehamilan, 'yyyy-MM-dd hh:mm:ss')
    );

    $modPeriksaKehamilan->tglakhirmenstruasi = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPeriksaKehamilan->tglakhirmenstruasi, 'yyyy-MM-dd'),
      'medium',
      null
    );

    $modPeriksaKehamilan->tglperkiraankelahiran = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPeriksaKehamilan->tglperkiraankelahiran, 'yyyy-MM-dd'),
      'medium',
      null
    );

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
      'modPeriksaKehamilan' => $modPeriksaKehamilan,
      'modRiwayatKehamilan' => $modRiwayatKehamilan
    ));
  }
}
