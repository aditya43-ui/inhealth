<?php

class SuratKeteranganController extends MyAuthController
{
  public function actionSuratKematian($pendaftaran_id = '')
  {
    $this->layout = '//layouts/iframe';
    if (!empty($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modPasienPulang = PJPasienpulangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $model = new PJSuratketeranganR;
      $model->pendaftaran_id = $pendaftaran_id;
      $model->pasien_id = $modPendaftaran->pasien_id;
      $model->nourutsurat = $model->getNoUrut();
      //                $model->nomorsurat = $model->getNoSurat($modPasien->no_rekam_medik);
      //                RSSP-669
      $model->nomorsurat = $model->getNoSuratKematian(Yii::app()->user->getState('ruangan_id'));
      $model->tglsurat = date('d M Y H:i:s');
      $model->judulsurat = 'SURAT KETERANGAN KEMATIAN';
      $model->jmlprint_surat = 1;
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->profilrs_id = Params::getDefaultProfilRS();
      $model->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;
    }
    //            else {
    //                $modPendaftaran = new PendaftaranT;
    //                $modPasien = new PasienM;
    //                $model = new PJSuratketeranganR;
    //            }

    if (isset($_POST['PJSuratketeranganR'])) {
      //echo "<pre>".print_r($_SESSION,1)."</pre>";
      $model->attributes = $_POST['PJSuratketeranganR'];
      $model->penyebabkematian = $_POST['PJSuratketeranganR']['penyebabkematian'];
      $model->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;
      if ($model->validate()) {
        $model->save();
        //                    $this->layout = '//layouts/printWindows';
        //                    $this->render('CetakSuratKematian',array('model'=>$model,
        $this->render('SuratKematian', array(
          'model' => $model,
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'modPasienPulang' => $modPasienPulang
        ));
      } else {
        $this->render('SuratKematian', array(
          'model' => $model,
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'modPasienPulang' => $modPasienPulang
        ));
      }
    } else {
      $this->render('SuratKematian', array(
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modPasienPulang' => $modPasienPulang
      ));
    }
  }

  public function actionPrintSuratMeninggal($pendaftaran_id, $suratketerangan_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienPulang = PJPasienpulangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $model = PJSuratketeranganR::model()->findByPk($suratketerangan_id);

    $this->render(
      'printSuratMeninggal',
      array(
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modPasienPulang' => $modPasienPulang
      )
    );
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
