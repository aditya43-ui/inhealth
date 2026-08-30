<?php

class InformasiDaftarPasienRSController extends MyAuthController
{
	public function actionIndex(){
        $format = new MyFormatter();
        $model = new PCInfopasienmasukkamarV;
        $model->tgl_awal  = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if(isset ($_REQUEST['PCInfopasienmasukkamarV'])){
            $model->attributes=$_REQUEST['PCInfopasienmasukkamarV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PCInfopasienmasukkamarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PCInfopasienmasukkamarV']['tgl_akhir']);
            $model->ceklis = $_REQUEST['PCInfopasienmasukkamarV']['ceklis'];
       }
       
        $this->render('index',array('model'=>$model,'format'=>$format));
	}
}

