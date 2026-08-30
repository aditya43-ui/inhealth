<?php
/**
 * -Informasi Daftar Pasien
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-2086
 */

class DaftarPasienATController extends MyAuthController
{
        /**
	 * @return array action filters
	 */
        public $path_view = 'anestesi.views.daftarPasien.';
	
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Daftar Pasien";
            $modPasienMasukPenunjang = new ATMasukPenunjangV;
            $format = new MyFormatter();
            $modPasienMasukPenunjang->tgl_awal = date("Y-m-d");
            $modPasienMasukPenunjang->tgl_akhir = date('Y-m-d');
            $modPasienMasukPenunjang->ceklis = true;
            if(isset ($_REQUEST['ATMasukPenunjangV'])){
                $modPasienMasukPenunjang->attributes=$_REQUEST['ATMasukPenunjangV'];
                $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ATMasukPenunjangV']['tgl_awal']);
                $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ATMasukPenunjangV']['tgl_akhir']);
                $modPasienMasukPenunjang->statuspendaftaran = isset($_REQUEST['ATMasukPenunjangV']['statuspendaftaran'])?$_REQUEST['ATMasukPenunjangV']['statuspendaftaran']:null;
            }
            $this->render($this->path_view.'index',array(
                'modPasienMasukPenunjang'=>$modPasienMasukPenunjang                                 
            ));
	}
        	
}