<?php

class LihatHasilController extends MyAuthController
{
  public function actionHasilPeriksa($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '')
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = RMPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));
    $detailHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $unitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $perujuk = isset($unitLain->pegawai_id) ? PegawaiM::model()->findByAttributes(array('pegawai_id' => $unitLain->pegawai_id)) : '-';
    $rumahSakit = ProfilrumahsakitM::model()->findByAttributes(array('profilrs_id' => 1));

    $this->render('hasilPemeriksaan', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'unitLain' => $unitLain,
      'perujuk' => $perujuk,
      'caraPrint' => $caraPrint,
      'rumahSakit' => $rumahSakit
    ));
  }
  public function actionHasilPeriksaPrint($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '', $i = 0, $pemeriksaanrad_id = null)
  {
    $this->layout = '//layouts/printWindows';
    $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPasienMasukPenunjang->pegawai_id));
    $detailHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pemeriksaanrad_id' => $pemeriksaanrad_id));
    $unitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $perujuk = isset($unitLain->pegawai_id) ? PegawaiM::model()->findByAttributes(array('pegawai_id' => $unitLain->pegawai_id)) : '-';
    $rumahSakit = ProfilrumahsakitM::model()->findByAttributes(array('profilrs_id' => 1));

    $this->render('hasilPrint', array(
      'detailHasil' => $detailHasil,
      'masukpenunjang' => $modPasienMasukPenunjang,
      'pemeriksa' => $pemeriksa,
      'unitLain' => $unitLain,
      'perujuk' => $perujuk,
      'caraPrint' => $caraPrint,
      'rumahSakit' => $rumahSakit,
      'i' => $i,
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
