<?php

/**
 * Extend dari Ambulans -> InformasiPemesananAmbulansController
 *
 * @author Deni Hamdani <pii.deni.prg@gmail.com>
 */
//Yii::import("ambulans.controllers.InformasiPemesananAmbulansController");
//Yii::import("ambulans.models.*");
//Yii::import("ambulans.views.*");
Yii::import("rawatDarurat.controllers.InformasiPemesananAmbulansController");
Yii::import("rawatDarurat.models.*");
Yii::import("rawatDarurat.views.*");
class InformasiPemesananAmbulansRIController extends InformasiPemesananAmbulansController
{
  public $inisial_modul = 'RI';

  public $ambulansRS = 'PemakaianAmbulanPasienRSRI';
  public $ambulansLuar = 'PemakaianAmbulanPasienLuarRI';
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
