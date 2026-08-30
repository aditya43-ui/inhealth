<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LaporanPetugasBayarUangMukaController extends MyAuthController {

	public $path_view = 'billingKasir.views.laporanPetugasBayarUangMuka.';

	public function actionIndex() {
		$format = new MyFormatter();
		$model = new BKInformasibayaruangmukaV('search');
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
		if (isset($_GET['BKInformasibayaruangmukaV'])) {
			$model->attributes = $_GET['BKInformasibayaruangmukaV'];
			$model->no_pendaftaran = $_GET['BKInformasibayaruangmukaV']['no_pendaftaran'];
			$model->no_rekam_medik = $_GET['BKInformasibayaruangmukaV']['no_rekam_medik'];
			$model->nama_pasien = $_GET['BKInformasibayaruangmukaV']['nama_pasien'];
			$model->instalasi_id = $_GET['BKInformasibayaruangmukaV']['instalasi_id'];
			$model->ruangan_id = $_GET['BKInformasibayaruangmukaV']['ruangan_id'];
			// $model->ruangan_id = $_GET['BKInformasibayaruangmukaV']['pegawai_id'];
			$model->status = $_GET['BKInformasibayaruangmukaV']['status'];

			if (!empty($_GET['BKInformasibayaruangmukaV']['tgl_awal'])) {
				$model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasibayaruangmukaV']['tgl_awal']);
			}
			if (!empty($_GET['BKInformasibayaruangmukaV']['tgl_awal'])) {
				$model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasibayaruangmukaV']['tgl_akhir']);
			}
		}

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'pencarianpasien-grid') {
                $this->renderPartial($this->path_view."_table", array('model'=>$model));
                Yii::app()->end();
            }
        }

		$this->render($this->path_view . 'index', array(
			'model' => $model,
			'format' => $format
		));
	}

    public function actionPrint() {
        $format = new MyFormatter();
		$model = new BKInformasibayaruangmukaV('search');
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');

        $judulLaporan = 'LAPORAN PENERIMAAN PEMBAYARAN UANG MUKA';

		if (isset($_GET['BKInformasibayaruangmukaV'])) {
			$model->attributes = $_GET['BKInformasibayaruangmukaV'];
			$model->no_pendaftaran = $_GET['BKInformasibayaruangmukaV']['no_pendaftaran'];
			$model->no_rekam_medik = $_GET['BKInformasibayaruangmukaV']['no_rekam_medik'];
			$model->nama_pasien = $_GET['BKInformasibayaruangmukaV']['nama_pasien'];
			$model->instalasi_id = $_GET['BKInformasibayaruangmukaV']['instalasi_id'];
			$model->ruangan_id = $_GET['BKInformasibayaruangmukaV']['ruangan_id'];
			$model->status = $_GET['BKInformasibayaruangmukaV']['status'];

			if (!empty($_GET['BKInformasibayaruangmukaV']['tgl_awal'])) {
				$model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasibayaruangmukaV']['tgl_awal']);
			}
			if (!empty($_GET['BKInformasibayaruangmukaV']['tgl_awal'])) {
				$model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasibayaruangmukaV']['tgl_akhir']);
			}
		}

        $data['title'] = 'LAPORAN PETUGAS PEMBAYARAN UANG MUKA';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

        $target = $this->path_view . 'print';

        $this->printFunction($model, $data, "PDF", $judulLaporan, $target);
    }

	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(BKRuanganM::getItems($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
				if (count((array)$models) > 1){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}
                if (count((array)$models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }


    public function actionDetailUangMuka($id, $caraPrint=null) {

        $this->layout = '//layouts/iframe';
        if (!empty($caraPrint)) {
            $this->layout = '//layouts/printWindows';
        }


        $modBayar = BayaruangmukaT::model()->findByPk($id);
        $modTandaBukti = TandabuktibayarT::model()->findByAttributes(array(
            'bayaruangmuka_id'=>$modBayar->bayaruangmuka_id,
        ));
				$modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
				$modPasienAdmisi = PasienadmisiT::model()->findByPk($modBayar->pasienadmisi_id);
				$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

				$jenispembayaran = "";
        $bank = "";
        $jmlpembayaran = 0;

        $modJnsPembayaran = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$modTandaBukti->tandabuktibayar_id));

        if(count((array)$modJnsPembayaran) > 0){
          foreach ($modJnsPembayaran as $jnsPem) {
            $jenispembayaran = (isset($jnsPem->jnspembayar)?$jnsPem->jnspembayar->jnspembayar_nama:"-");
            $bank = (isset($jnsPem->bankpenerima)?$jnsPem->bankpenerima->namabank:"-");
            $jmlpembayaran += $jnsPem->jumlahpembayaran;
          }
        }

				$jumlah_tagihan = 0;
				// uang muka
				$uangmuka = BKBayaruangmukaT::model()->findAllByAttributes(array(
						'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
				), array(
						'condition'=>'pembatalanuangmuka_id is null',
				));

				foreach ($uangmuka as $item) {
						$jumlah_tagihan -= $item->jumlahuangmuka;
				}

        $this->render($this->path_view.'detail', array(
					'modPendaftaran'=>$modPendaftaran,
					'modPasienAdmisi'=>$modPasienAdmisi,
					'modPasien'=>$modPasien,
					 'modTandaBukti'=>$modTandaBukti,
					 'modBayar'=>$modBayar,
					 'jenispembayaran'=>$jenispembayaran,
				 'bank'=>$bank,
			 'jmlpembayaran'=>$jmlpembayaran,
		 'jumlah_tagihan'=>$jumlah_tagihan
        ));
    }

    public function actionOrderBatal() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $bayar = BayaruangmukaT::model()->findByPk($_POST['bayaruangmuka_id']);

        // $trans = Yii::app()->db->beginTransaction();

        try {
            $model = new OrderbataluangmukaT;
            $model->attributes = $bayar->attributes;
            $model->create_time = $model->update_time = date('Y-m-d H:i:s');
            $model->create_login = $model->update_login = Yii::app()->user->id;

            if ($model->save()) {
                echo CJSON::encode(array(
                    'ok'=>01,
                    'msg'=>'Order batal deposit berhasil disimpan.'
                ));
            } else {
                echo CJSON::encode(array(
                    'ok'=>0,
                    'msg'=>'Order batal deposit batal disimpan.'
                ));
            }

        } catch (Exception $e) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>$e->getMessage()
            ));
        }

        // var_dump($model->attributes, $bayar->attributes);
        // die;
    }

    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
    {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
        if (empty($model->tgl_awal)) {
            $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
        }
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);

            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}
