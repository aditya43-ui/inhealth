<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InfoOrderBatalUangMukaController extends MyAuthController {

	public $path_view = 'keuangan.views.infoOrderBatalUangMuka.';

	public function actionIndex() {
		$format = new MyFormatter();
		$model = new KUInformasiorderbatalbayaruangmukaV('search');
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
		if (isset($_GET['KUInformasiorderbatalbayaruangmukaV'])) {
			$model->attributes = $_GET['KUInformasiorderbatalbayaruangmukaV'];
			$model->no_pendaftaran = $_GET['KUInformasiorderbatalbayaruangmukaV']['no_pendaftaran'];
			$model->no_rekam_medik = $_GET['KUInformasiorderbatalbayaruangmukaV']['no_rekam_medik'];
			$model->nama_pasien = $_GET['KUInformasiorderbatalbayaruangmukaV']['nama_pasien'];
			$model->instalasi_id = $_GET['KUInformasiorderbatalbayaruangmukaV']['instalasi_id'];
			$model->ruangan_id = $_GET['KUInformasiorderbatalbayaruangmukaV']['ruangan_id'];
			$model->ruangan_id = $_GET['KUInformasiorderbatalbayaruangmukaV']['pegawai_id'];
			$model->status = $_GET['KUInformasiorderbatalbayaruangmukaV']['status'];

			if (!empty($_GET['KUInformasiorderbatalbayaruangmukaV']['tgl_awal'])) {
				$model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasiorderbatalbayaruangmukaV']['tgl_awal']);
			}
			if (!empty($_GET['KUInformasiorderbatalbayaruangmukaV']['tgl_awal'])) {
				$model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasiorderbatalbayaruangmukaV']['tgl_akhir']);
			}
		}

		$this->render($this->path_view . 'index', array(
			'model' => $model,
			'format' => $format
		));
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

    public function actionVerifikasiBatal() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $bayar = OrderbataluangmukaT::model()->findByPk($_POST['orderbataluangmuka_id']);

        // $trans = Yii::app()->db->beginTransaction();

        try {
            $model = BayaruangmukaT::model()->findByPk($bayar->bayaruangmuka_id);
            $model->orderbataluangmuka_id = true;

            if ($model->save(array('orderbataluangmuka_id'))) {
                echo CJSON::encode(array(
                    'ok'=>1,
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

}
