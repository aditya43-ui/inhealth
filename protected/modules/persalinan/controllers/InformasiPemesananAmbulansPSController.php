<?php

/**
 * Extend dari Ambulans -> InformasiPemesananAmbulansController
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */
Yii::import("rawatDarurat.controllers.InformasiPemesananAmbulansController");
Yii::import("rawatDarurat.models.*");
Yii::import("rawatDarurat.views.*");
class InformasiPemesananAmbulansPSController extends InformasiPemesananAmbulansController
{
  public $inisial_modul = 'PS';
  public $ambulansRS = 'PemakaianAmbulanPasienRSPS';
  public $ambulansLuar = 'PemakaianAmbulanPasienLuarPS';

  public function actionIndex($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(3330);
      return InformasiPemesananAmbulansController::actionIndex($linkHalaman);
  }
  /*
        public function actionIndex(){
                $model = new AMInformasipesanambulansV;
		$format = new MyFormatter;
                $model->tgl_awal  = date('Y-m-d');
                $model->tgl_akhir  = date('Y-m-d');
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		if(isset($_GET['AMInformasipesanambulansV'])){
			$model->unsetAttributes();
			$model->attributes=$_GET['AMInformasipesanambulansV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_awal']);
                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMInformasipesanambulansV']['tgl_akhir']);
		}
		$this->render($this->pathView.'index',array('model'=>$model,'format'=>$format));
	} */
}
