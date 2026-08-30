<?php

class InformasiStokObatAlkesPasienController extends MyAuthController
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
	
	/**
     * actionStokObatAlkes (ngambil sampel data dari rawat inap, dikarenakan tabel untuk stok obat alkes modul ini belum ada) 
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
	public function actionStokObat($pendaftaran_id,$pasienadmisi_id=null){
	 $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
	$format = new MyFormatter();	
//        $modRincians = null;
//        if($instalasi_id == Params::INSTALASI_ID_RJ){
//            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
//            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
//            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
//        }else if($instalasi_id == Params::INSTALASI_ID_RD){
//            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
//            $criteria->order = 'ruangantindakan_id';
//            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
//            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
//        }else if($instalasi_id == Params::INSTALASI_ID_RI){
//            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
//            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
//            $criteria->order = 'ruangantindakan_id';
//            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
//        }
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $this->render('stokObatAlkes', array('format'=>$format,'modPendaftaran'=>$modPendaftaran));
    }
	
	/**
     * actionDetailStok (ngambil sampel data dari rawat inap, dikarenakan tabel untuk detail stok obat alkes modul ini belum ada) 
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
	public function actionDetailStok($pendaftaran_id,$pasienadmisi_id=null){
	 $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
	$format = new MyFormatter();	
//        $modRincians = null;
//        if($instalasi_id == Params::INSTALASI_ID_RJ){
//            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
//            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
//            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
//        }else if($instalasi_id == Params::INSTALASI_ID_RD){
//            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
//            $criteria->order = 'ruangantindakan_id';
//            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
//            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
//        }else if($instalasi_id == Params::INSTALASI_ID_RI){
//            $criteria = new CDbCriteria();
//            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
//            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
//            $criteria->order = 'ruangantindakan_id';
//            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
//        }
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $this->render('detailStokObat', array('format'=>$format,'modPendaftaran'=>$modPendaftaran));
    }
}

