<?php

class KeluargaBerencanaController extends MyAuthController
{
  public function actionIndex($pendaftaran_id)
  {
    $modPendaftaran = PSPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $format = new MyFormatter();

    $modPeriksaKehamilan = PSPeriksakeHamilanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($modPeriksaKehamilan)) {
      $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
      $urlDaftarPasien =  Yii::app()->createAbsoluteUrl($module . '/DaftarPasien/index'); //
      Yii::app()->user->setFlash('error', 'Harap Isi Persalinan Terlebih Dahulu.');
      $this->redirect($urlDaftarPasien);
    }
    $modRiwayatPasienKB = new PSPasienKBT;
    $modRiwayatPasienKB->pasien_id = $modPasien->pasien_id;

    $cekPasienKB = PSPasienKBT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($cekPasienKB)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya
      $modPasienKB = $cekPasienKB;
    } else {
      ////Jika Pasien Belum Pernah Bayi Tabung
      $modPasienKB = new PSPasienKBT;
    }
    $modPasienKB->tglpelayanankb = date('Y-m-d H:i:s');

    if (isset($_POST['PSPasienKBT'])) {
      $modPasienKB->attributes = $_POST['PSPasienKBT'];
      $modPasienKB->tglpelayanankb = $format->formatDateTimeForDb($_POST['PSPasienKBT']['tglpelayanankb']);
      $modPasienKB->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPasienKB->pasien_id = $modPasien->pasien_id;
      $modPasienKB->pendaftaran_id = $modPendaftaran->pendaftaran_id;


      if ($modPasienKB->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      } else {
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }

    $modPasienKB->tglpelayanankb = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPasienKB->tglpelayanankb, 'yyyy-MM-dd hh:mm:ss')
    );


    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
      'modPasienKB' => $modPasienKB,
      'modPeriksaKehamilan' => $modPeriksaKehamilan,
      'modRiwayatPasienKB' => $modRiwayatPasienKB
    ));
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
}
