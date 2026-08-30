<?php

class InformasiPasienPenunjangController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'billingKasir.views.informasiPasienPenunjang.';

	public function actionIndex()
	{
            $format = new MyFormatter();
            $model = new BKRinciantagihanpasienpenunjangV('searchRincianTagihan');
            $model->tgl_awal = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            $model->unsetAttributes();  // clear any default values
            $model->statusBayar = "BELUM LUNAS";

            if(isset($_GET['BKRinciantagihanpasienpenunjangV'])){
                $model->attributes=$_GET['BKRinciantagihanpasienpenunjangV'];
                //$model->statusBayar=$_GET['BKRinciantagihanpasienpenunjangV']['statusBayar'];
                $model->statusperiksa=$_GET['BKRinciantagihanpasienpenunjangV']['statusperiksa'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKRinciantagihanpasienpenunjangV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKRinciantagihanpasienpenunjangV']['tgl_akhir']);
            }


            $this->render($this->path_view.'index',array(
                    'model'=>$model,'format'=>$format
            ));
	}

    public function actionRincian($id){
        $model = new BKRinciantagihanpasienpenunjangV('searchRincianTagihan');
        $this->layout = '//layouts/iframe';
        $data['judulLaporan'] = 'Rincian Tagihan Pasien';
        $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
        $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
        if(empty($modPenunjang)){
            $criteria = new CDbCriteria;
            $criteria->with = array('pasienadmisi');
			if(!empty($id)){
				$criteria->addCondition("pasienadmisi.pendaftaran_id = ".$id);
			}
            $modPenunjang = PasienmasukpenunjangT::model()->find($criteria);
        }
        $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));

        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
           // $modRincian->pendaftaran_id = $id;
        $this->render('billingKasir.views.pasienLaboratorium.rincian', array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
    }

    public function actionPrint()
    {
        $id = $_REQUEST['id'];
        $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
        $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
        $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
        $data['judulLaporan']='Data Rincian Tagihan Pasien';
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render('billingKasir.views.rinciantagihanpasienpenunjangV.rincian', array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
            //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render('billingKasir.views.rinciantagihanpasienpenunjangV.rincian',array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF);
            //$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);
            $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
            $mpdf->WriteHTML($style, 1);
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            $mpdf->WriteHTML($this->renderPartial('billingKasir.views.rinciantagihanpasienpenunjangV.rincian',array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint),true));
            $mpdf->Output();
        }
    }


    public function actionCekStatusPasienPenunjang() {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();

        $id = $_POST['id'];

        $reseptur_full = ResepturT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $id,
        ));
        $reseptur = ResepturT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $id,
                ), array(
            'condition' => 'penjualanresep_id is not null',
        ));

        $model = PendaftaranT::model()->findByAttributes(array(
            'pendaftaran_id' => $id,
        ));
        $pasien = PasienM::model()->findByPk($model->pasien_id);

        $nama = $pasien->namadepan . $pasien->nama_pasien;

        $notif = array(
            'ok' => 1,
            'msg' => '',
        );
        if (count((array)$reseptur) > 0) {
            $notif['ok'] = 0;
            $notif['msg'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";

            $this->breadcastNotifResepturPasien($model, $reseptur);
        }
        // *
        // */
        echo CJSON::encode($notif);
    }


    /**
     *
     * @param mixed $model Data yang berhubungan dengan Pasien dan Pendaftaran.
     * @param ResepturT $reseptur Data ResepturT
     * @return boolean Status keberhasilan Broadcast reseptur ke farmasi
     */
    protected function breadcastNotifResepturPasien($model, $reseptur) {
        $judul = "Verifikasi Reseptur Rawat Inap";
        $msg = "Harap Reseptur dibawah ini di diselesaikan :<br/>";
        $noresep = array();
        foreach ($reseptur as $item) {
            $msg .= "- " . $item->noresep . '<br/>';
            $noresep[] = $item->noresep;
        }

        $link = $this->createUrl('/farmasiApotek/InformasiPasienResep/Index', array(
            'FAInformasiresepturV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'FAInformasiresepturV[tgl_akhir]' => date('Y-m-d'),
            'FAInformasiresepturV[no_pendaftaran]' => $model->no_pendaftaran,
            'FAInformasiresepturV[statusJual]' => 2,
        ));

        $cur = array(
            array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK, 'link_proses' => $link),
        );

        // var_dump($modKunjungan->attributes); die;
        // var_dump($judul, $isi, $cur, $modKunjungan->attributes); die;

        return CustomFunction::broadcastNotif($judul, $msg, $cur);
    }

}
