<?php
Yii::import('farmasiApotek.controllers.PenjualanResepRSController');
/**
 * @package application.modules.farmasiApotek
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class VerifikasiObatController extends PenjualanResepRSController
{
	public $obatalkespasientersimpan = true;
	public $is_trracikan = false;
	public $ada_penjualan = false;
	public $obatkronis = false;
	public $list_tempat_layanan_api = null;
	public function actionIndex($reseptur_id = null, $penjualanresep_id = null, $frame = 0)
	{
		// if ($frame == 1) {
		    $this->layout = '//layouts/iframe';
		// }

		$modReseptur = FAResepturT::model()->findByPk($reseptur_id);
		$modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $reseptur_id), array('order' => 'rke ASC, resepturdetail_id ASC'));
		$ruangan_id = Yii::app()->user->getState('ruangan_id');
		$instalasi_id = $modReseptur->ruanganreseptur->instalasi_id;
		$modPegawai = PegawaiM::model()->findByPk($modReseptur->pegawai_id);
		$modAntrian = FAAntrianFarmasiT::model()->findByAttributes(array('reseptur_id' => $reseptur_id));
		$modPendaftaran = FAPendaftaranT::model()->findByPk($modReseptur->pendaftaran_id);

		$modReseptur->jml = !empty($modReseptur) ? ResepturdetailT::getJmlRaciakan($reseptur_id) : 0;
		$modReseptur->admracikan = KonfigfarmasiK::model()->find()->admracikan;
		$modReseptur->administrasi = KonfigfarmasiK::model()->find()->administrasi;

		$modTindakan = new TindakanpelayananT;

		if (empty($modAntrian)) {
			$modAntrian = new FAAntrianFarmasiT();
		}

		// load obatalkes_m, ambil data harga. untuk detailreseptur yang baru
		foreach ($modDetailReseptur as $ii => $detail) {

			$terapi = TherapimapobatM::model()->findByAttributes(array(
				'obatalkes_id' => $detail->obatalkes_id,
			));
			$modOA = FAObatalkesM::model()->findByPk($detail->obatalkes_id);
			$modDetailReseptur[$ii]->hargasatuan_reseptur = $detail->hargasatuan_reseptur;
			$modDetailReseptur[$ii]->hargajual_reseptur = $detail->hargajual_reseptur;
			$modDetailReseptur[$ii]->persen_discount = $detail->persdiskon;

			$modDetailReseptur[$ii]->ppnpersen = $detail->persenppnjual;
			$modDetailReseptur[$ii]->jumlahppn = $detail->jumlahppn;
			$modDetailReseptur[$ii]->subtotal = $detail->hargajual_reseptur;
			$modDetailReseptur[$ii]->biayaadministrasi = $detail->biayaadministrasi;
			$konfigFarmasi = KonfigfarmasiK::model()->find();
			$modDetailReseptur[$ii]->ppnpersen = 0;
			if (!in_array($modOA->jenisobatalkes_id, array(Params::JENISOBATALKES_ID_ALKES, Params::JENISOBATALKES_ID_BHP))) {
				if ($instalasi_id == Params::INSTALASI_ID_RJ || $instalasi_id == Params::INSTALASI_ID_HD || $instalasi_id == 74) {
					$modDetailReseptur[$ii]->ppnpersen = $konfigFarmasi->rj_persjualppn;
				} else if ($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
					$modDetailReseptur[$ii]->ppnpersen = $konfigFarmasi->ri_persjualppn;
				} else if ($instalasi_id == Params::INSTALASI_ID_RD || $instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
					$modDetailReseptur[$ii]->ppnpersen = $konfigFarmasi->rd_persjualppn;
				} else {
					$modDetailReseptur[$ii]->ppnpersen = 0;
				}
			}

			$penjamin_id = !empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi->penjamin_id : $modPendaftaran->penjamin_id;

			// if ($konfigFarmasi->ishargaperpenjamin == true) {
			// 	if (!empty($modPendaftaran->pen																								jamin_id)) {
			$obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id' => $detail->obatalkes->jenisobatalkes_id, 'penjamin_id' => $penjamin_id));
			$persmargin = !empty($obatalkesPenjamin->persmargin) ? $obatalkesPenjamin->persmargin : 0;
			// 		if (!empty($obatalkesPenjamin)) {
			$marginRp = round((($detail->obatalkes->hargajual * $persmargin) / 100), 2);
			$hargaSatuan = round(($detail->obatalkes->hargajual + $marginRp), 2);
			// 			$modDetailReseptur[$ii]->hargasatuan_reseptur = $hargaSatuan;
			// 			$modDetailReseptur[$ii]->biayaadministrasi = $obatalkesPenjamin->biayaadministrasi;
			// 			$modDetailReseptur[$ii]->persen_discount = $obatalkesPenjamin->persdiskon;
			// 		}
			// 	}
			// }

			$modDetailReseptur[$ii]->jumlahppn = $hargaSatuan * $modDetailReseptur[$ii]->ppnpersen;
			$modDetailReseptur[$ii]->hargasatuan_reseptur = $detail->hargasatuan_reseptur;
			$modDetailReseptur[$ii]->hargajual_reseptur = $detail->hargajual_reseptur;

			// $modDetailReseptur[$ii]->subtotal = $detail->hargajual_reseptur;
			$modDetailReseptur[$ii]->qty_dilayani = ceil($detail->qty_reseptur);

			$modDetailReseptur[$ii]->harganetto_reseptur = round($modOA->harganetto);
			$modDetailReseptur[$ii]->jasadokterresep = $modOA->jasadokter;
			$modDetailReseptur[$ii]->discount = $modOA->discount;
			$modDetailReseptur[$ii]->iurbiaya = $modDetailReseptur[$ii]->hargasatuan_reseptur * $modDetailReseptur[$ii]->qty_reseptur;

			if (!empty($terapi)) {
				$modDetailReseptur[$ii]->therapiobat_id = $terapi->therapiobat_id;
			}

			$modFormularium = FormulariumobatM::model()->findByAttributes([
				'obatalkes_id' => $detail->obatalkes_id,
				'carabayar_id' => $modReseptur->pendaftaran->carabayar_id,
				'penjamin_id' => $modReseptur->pendaftaran->penjamin_id,
			]);

			$modDetailReseptur[$ii]->formulariumobat_id = !empty($modFormularium) ? $modFormularium->formulariumobat_id : null;


			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($modDetailReseptur[$ii]->obatalkes_id, $modDetailReseptur[$ii]->qty_reseptur, $ruangan_id);
		}

		$modInfoRI = new FAInfopasienmasukkamarV;
		// var_dump($data->pendaftaran_id);
		$cr = new CDbCriteria;
		$cr->join = "join pendaftaran_t p on p.sep_id = t.sep_id";
		$cr->compare("p.pendaftaran_id", $modReseptur->pendaftaran_id);
		$as = SepT::model()->find($cr);
		// echo '<pre>';var_dump($as);die;
		if (!empty($as->nosep)) {
			$modInfoRI->nosep = $as->nosep;
			$modInfoRI->nokartuasuransi = $as->nokartuasuransi;
		} else {
			$modInfoRI->nosep ='-';
			$modInfoRI->nokartuasuransi = '-';
		}
		$modObatAlkesPasien = new FAObatalkesPasienT();

		// load penjualan resep berdasarkan reseptur_id (bisa ada data bisa juga tidak)
		$modPenjualan = FAPenjualanResepT::model()->findByAttributes(array('reseptur_id' => $reseptur_id));

		if (!empty($modPenjualan->tglpenjualan))
			$modPenjualan->tglpenjualan = MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan);
		if (!empty($modPenjualan->tglresep))
			$modPenjualan->tglresep = MyFormatter::formatDateTimeForUser($modPenjualan->tglresep);
		if (!empty($modPenjualan)) {
			$this->ada_penjualan = true;
		} else {
			$modPenjualan = new FAPenjualanResepT;
			$modPenjualan->antrianfarmasi_id = $modAntrian->antrianfarmasi_id;
			$modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
			$modPenjualan->tglresep = MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur);
			$modPenjualan->noresep = MyGenerator::noResep($instalasi_id);
			$modPenjualan->pegawai_id = $modReseptur->pegawai_id;
			$modPenjualan->jasapelayanan_farmasi = $modReseptur->jasapelayanan_farmasi;
			$modPenjualan->totharganetto = 0;
			$modPenjualan->totalhargajual = 0;
			$modPenjualan->totaltarifservice = 0;
			$modPenjualan->biayaadministrasi = 0;
			$modPenjualan->biayakonseling = 0;
			$modPenjualan->pembulatanharga = 0;
			$modPenjualan->jasadokterresep = 0;
			$modPenjualan->discount = 0;
			$modPenjualan->subsidiasuransi = 0;
			$modPenjualan->subsidipemerintah = 0;
			$modPenjualan->subsidirs = 0;
			$modPenjualan->iurbiaya = 0;
			$modPenjualan->isresepperawatan = 1;
			$modPenjualan->iter = empty($modDetailReseptur[0]->iter) ? 1 : $modDetailReseptur[0]->iter;
			$modPenjualan->is_cito = ($modReseptur->is_cito == true) ? 1 : 0;
			$modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
			// $modPenjualan->is_resepemergency = ($modReseptur->is_resepemergency == true) ? 1 : 0;
			if(!empty($modPegawai)) {
				$modPenjualan->kodedokter_inventory = $modPegawai->kodedokter_inventory;
			}

			$petugas = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
			if(!empty($petugas)) {
				$modPenjualan->kodepetugas_inv = $petugas->kodepetugas_inventory;
			}
			if(!empty($modPendaftaran->ruangan)) {
				$modPenjualan->jenislayanan_inv = $modPendaftaran->ruangan->kodeJL_inventory;
				$modPenjualan->tempatlayanan_inv = $modPendaftaran->ruangan->kodeTL_inventory;
			}
		}


		if ($this->ada_penjualan) {
			if (!empty($penjualanresep_id)) {
				$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
			}
			$modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
			$modInfoDataRI = FAObatalkesPasienT::model()->findByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
			$modInfoRI->no_pendaftaran = $modInfoDataRI->pendaftaran->no_pendaftaran;
			$modInfoRI->tgl_pendaftaran = $modInfoDataRI->pendaftaran->tgl_pendaftaran;
			$modInfoRI->ruangan_nama = $modInfoDataRI->pendaftaran->ruangan->ruangan_nama;
			$modInfoRI->instalasi_id = $modInfoDataRI->pendaftaran->instalasi_id;
			$modInfoRI->kelaspelayanan_nama = $modInfoDataRI->pendaftaran->kelaspelayanan->kelaspelayanan_nama;
			$modInfoRI->jeniskasuspenyakit_id = $modInfoDataRI->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_id;
			$modInfoRI->jeniskasuspenyakit_nama = $modInfoDataRI->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
			$modInfoRI->carabayar_nama = $modInfoDataRI->pendaftaran->carabayar->carabayar_nama;
			$modInfoRI->penjamin_nama = $modInfoDataRI->pendaftaran->penjamin->penjamin_nama;
			$modInfoRI->no_rekam_medik = $modInfoDataRI->pendaftaran->pasien->no_rekam_medik;
			$modInfoRI->namadepan = $modInfoDataRI->pendaftaran->pasien->namadepan;
			$modInfoRI->nama_pasien = $modInfoDataRI->pendaftaran->pasien->nama_pasien;
			$modInfoRI->nama_bin = $modInfoDataRI->pendaftaran->pasien->nama_bin;
			$modInfoRI->tanggal_lahir = MyFormatter::formatDateTimeForUser($modInfoDataRI->pendaftaran->pasien->tanggal_lahir);
			$modInfoRI->umur = $modInfoDataRI->pendaftaran->umur;
			$modInfoRI->jeniskelamin = $modInfoDataRI->pendaftaran->pasien->jeniskelamin;
			$modInfoRI->penanggungjawab_id = $modInfoDataRI->pendaftaran->penanggungjawab_id;
			$modInfoRI->alamat_pasien = $modInfoDataRI->pendaftaran->pasien->alamat_pasien;
		}

		$modPenjualan->noresep = "-Otomatis-";

		$transaction = Yii::app()->db->beginTransaction();
		$verifikasi = false;
		if (isset($_POST['FAResepturDetailT'])) {
			// echo '<pre>';var_dump($_POST);die;
			try {
				if (count((array) $_POST['FAResepturDetailT']) > 0) {
				
					foreach ($_POST['FAResepturDetailT'] as $i => $postDetail) {
						if(!empty($postDetail['resepturdetail_id'])) {
							// update
							$modResepturDetail = ResepturdetailT::model()->findByPk($postDetail['resepturdetail_id']);

							// tambahan
							$modResepturDetail->attributes = $postDetail;
							$modResepturDetail->qty_reseptur = $postDetail['qty_dilayani'];
							$modResepturDetail->permintaan_dosis = isset($postDetail['permintaan_reseptur']) ?  MyFormatter::formatNumberForDb($postDetail['permintaan_reseptur']) : '';
							if($postDetail['racikan_id'] == Params::RACIKAN_ID_RACIKAN) {
								// racikan
								$modResepturDetail->jumlahpermintaan_obatracikan = MyFormatter::formatNumberForDb($postDetail['jumlahpermintaan_obatracikan']);

							} else {
								// non racikan
								$modResepturDetail->jumlahpermintaan_obatnonracikan = MyFormatter::formatNumberForDb($postDetail['jumlahpermintaan_obatnonracikan']);
							}
							$modResepturDetail->signa_reseptur = $postDetail['signa_reseptur'];
							$modResepturDetail->formulaobatkronis_id = !empty($postDetail['formulaobatkronis_id']) ? $postDetail['formulaobatkronis_id'] : null;
							$modResepturDetail->is_obatkronis = !empty($postDetail['is_obatkronis']) ? $postDetail['is_obatkronis'] : 0;

							$modResepturDetail->satuansediaan = $postDetail['satuansediaan'];
							$modResepturDetail->satuankekuatan = !empty($postDetail['satuankekuatan']) ? $postDetail['satuankekuatan'] : null;
							if (isset($postDetail['permintaan_reseptur'])) {
								$modResepturDetail->permintaan_reseptur = $postDetail['permintaan_reseptur'];
							}
							if (isset($postDetail['kadaluarsa'])) {
								$modResepturDetail->kadaluarsa = MyFormatter::formatDateTimeForDb($postDetail['kadaluarsa']);
							}


							$modResepturDetail->qty_reseptur = is_numeric($modResepturDetail->qty_reseptur) ? $modResepturDetail->qty_reseptur : MyFormatter::formatRupiahForDB($modResepturDetail->qty_reseptur);
							// tambahan karena ada data bisa diedit

							$modResepturDetail->is_verifkasiapoteker = $postDetail['is_verifkasiapoteker'];
							if($modResepturDetail->save()) {
								$verifikasi = true;
							}
						} else {
							// tambahan dari apoteker
							$detail = new ResepturdetailT();
							$detail->reseptur_id = $reseptur_id;
							$detail->attributes = $postDetail;
							$detail->is_verifkasiapoteker = $postDetail['is_verifkasiapoteker'];
							$detail->is_tambahanapoteker = $postDetail['is_tambahanapoteker'];
							$detail->qty_reseptur = $postDetail['qty_dilayani'];
							$detail->obatlain_nama = $postDetail['obatalkes_nama_api'];
							$detail->permintaan_dosis = isset($postDetail['permintaan_reseptur']) ? $postDetail['permintaan_reseptur'] : null;
							if($postDetail['racikan_id'] == Params::RACIKAN_ID_RACIKAN) {
								// racikan
								$detail->jumlahpermintaan_obatracikan = MyFormatter::formatNumberForDb($postDetail['jumlahpermintaan_obatracikan']);

							} else {
								// non racikan
								$detail->jumlahpermintaan_obatnonracikan = MyFormatter::formatNumberForDb($postDetail['jumlahpermintaan_obatnonracikan']);
							}
							$detail->signa_reseptur = $postDetail['signa_reseptur'];
							$detail->formulaobatkronis_id = !empty($postDetail['formulaobatkronis_id']) ? $postDetail['formulaobatkronis_id'] : null;
							$detail->is_obatkronis = !empty($postDetail['is_obatkronis']) ? $postDetail['is_obatkronis'] : 0;

							$detail->satuansediaan = $postDetail['satuansediaan'];
							$detail->satuankekuatan = !empty($postDetail['satuankekuatan']) ? $postDetail['satuankekuatan'] : null;
							if (!empty($postDetail['permintaan_reseptur'])) {
								$detail->permintaan_reseptur = $postDetail['permintaan_reseptur'];
							}


							$detail->qty_reseptur = is_numeric($detail->qty_reseptur) ? $detail->qty_reseptur : MyFormatter::formatRupiahForDB($detail->qty_reseptur);

							if (empty($detail->permintaandosis_pembilang) && empty($detail->permintaandosis_penyebut)) {
								$detail->is_permitaandosispecahan = false;
							}

							if (!empty($postDetail['formulaobatkronis_id'])) {
								$this->is_obatkronis = 1;
							}
							if (isset($postDetail['kadaluarsa'])) {
								$detail->kadaluarsa = MyFormatter::formatDateTimeForDb($postDetail['kadaluarsa']);
							}
							
							$valid = $detail->validate();
							if ($valid) {
								$verifikasi = $valid && $detail->save();
							} else {
								$verifikasi = false;
							}
						}
					}
					
					
				}
				$ii = 0;


				if ($verifikasi) {
					$transaction->commit();
					// die;
					Yii::app()->user->setFlash('success', "Data Berhasil disimpan !");
					$this->redirect(array('index', 'reseptur_id' => $reseptur_id,  'sukses' => 1, 'frame' => $frame));
					
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan 1!");
				}
			} catch (Exception $e) {
				// echo '<pre>'; var_dump($e); die;
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan 2! " . MyExceptionMessage::getMessage($e, true));
			}
			
		}

		if(Yii::app()->request->isAjaxRequest) {
			if(isset($_GET['ajax']) && $_GET['ajax'] == 'obat-api-grid') {
				$this->renderPartial('_dialogObatApi', ['modReseptur' => $modReseptur]);
				Yii::app()->end();
			}
		}

		$this->render('index', array(
			'modReseptur' => $modReseptur,
			'modDetailReseptur' => $modDetailReseptur,
			'modInfoRI' => $modInfoRI,
			'modPenjualan' => $modPenjualan,
			'modAntrian' => $modAntrian,
			'modObatAlkesPasien' => $modObatAlkesPasien,
			'instalasi_id' => $instalasi_id,
			'modPendaftaran' => $modPendaftaran,
			'konfigFarmasi' => $konfigFarmasi,
		));
	}

	public function actionAjaxAPITempatLayanan() {
		
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}

		$jenis_kode = $_POST['jenis_kode'];

		$this->getAPITempatLayananMain();


		$html = '<option value="">-- Pilih --</option>';

		if (!empty($this->list_tempat_layanan_api)) {
			foreach ($this->list_tempat_layanan_api as $item) {

				if (!empty($jenis_kode) && $item['KodeJL'] != $jenis_kode) {
					continue;
				}

				$html .= '<option value="'.$item['Kode'].'">'.$item['Nama'].'</option>';

				// $res_item[$item['Kode']] = $item['Nama'];
			}
		}

		echo $html;


	}

	function getBridgingHost() {
        $konfig = KonfigsystemK::model()->find();
        return $konfig->bridging_host;
    }

	public function getAPITempatLayananMain() {

		if (!empty($this->list_tempat_layanan_api)) {
			return;
		}

		$api = new MyAPI;
		$header = array(
			"Accept" => "application/json",
			"Content-type" => "application/json"
		);

		$res_jenis = CJSON::decode($api->apiRequest(
			$this->getBridgingHost() . "/tempatlayanan/1", 
			"GET", $header) ?? "{}");


		$this->list_tempat_layanan_api = $res_jenis['data']['recordset'] ?? null;
	}

	public function getAPIJenisLayanan() {

		$res_item = array();

		if (empty($this->list_tempat_layanan_api)) {
			$this->getAPITempatLayananMain();
		}

		if (!empty($this->list_tempat_layanan_api)) {
			foreach ($this->list_tempat_layanan_api as $item) {
				$res_item[$item['KodeJL']] = $item['NamaJL'];
			}
		}

		return $res_item;

		// var_dump($res_item, $res_jenis); die;

	}

	public function getAPITempatLayanan($kode_jenis) {
		if (empty($this->list_tempat_layanan_api)) {
			$this->getAPITempatLayananMain();
		}

		$res_item = array();

		if (!empty($this->list_tempat_layanan_api)) {
			foreach ($this->list_tempat_layanan_api as $item) {

				// var_dump($item);

				if (!empty($kode_jenis) && $item['KodeJL'] != $kode_jenis) {
					continue;
				}

				$res_item[$item['Kode']] = $item['Nama'];
			}
		}

		return $res_item;
	}

	public function getAPIDokterFarmasi() {
		$api = new MyAPI;

		$header = array(
			"Accept" => "application/json",
			"Content-type" => "application/json"
		);

		$res = array();
		$res_kode = CJSON::decode($api->apiRequest(
			$this->getBridgingHost() . "/provider", 
			"GET", $header) ?? "{}");

		if (!empty(
			$res_kode['status']['OK']) 
			&& $res_kode['status']['OK'] == 1 
			&& !empty($res_kode['data']['recordsets'][0])
			&& is_array($res_kode['data']['recordsets'][0])
		) {
			foreach ($res_kode['data']['recordsets'][0] as $item) {
				$res[$item['Kode']] = $item['Nama'];
			}
		}

		return $res;


		// var_dump($res_kode); die;

		
	}

	public function setAPIPenjualanResepOA($penjualan, $detail) {

		$ok = true;

		$api = new MyAPI;
		$ruangan = RuanganM::model()->findByPk($penjualan->ruangan_id);
		$kode = $ruangan->kodedepo_inventory.date('Ym');

		$jualAPI = InslogjualfarmasiInvV::model()->findByAttributes(array(
			'penjualanresep_id'=>$penjualan->penjualanresep_id
		));

		// echo "Kode Depo : ".$ruangan->kodedepo_inventory."<br/>";
		// echo "Kode Depo Layanan : ".$kode."<br/>";
		
		// var_dump($kode, $ruangan->attributes); die;
		
		$header = array(
			"Accept" => "application/json",
			"Content-type" => "application/json"
		);



		// get nomor Kode
		$res_kode = CJSON::decode($api->apiRequest(
			$this->getBridgingHost() . "/getkode", 
			"POST", $header, CJSON::encode(array(
				'kode'=>$kode
			))) ?? "{}");

		// get Nomor Singkatan
		$res_inisial = CJSON::decode($api->apiRequest(
			$this->getBridgingHost() . "/getInisial", 
			"POST", $header, CJSON::encode(array(
				'kode'=>$ruangan->kodedepo_inventory,
			))) ?? "{}");

		$kode_cur = $res_kode['data']['recordset'][0]['Kode'] ?? null;
		if (!empty($kode_cur)) {
			// var_dump($kode_cur, $kode);
			$nomor = substr($kode_cur, strlen($kode));

			$penjualan->kodedepo_inv = $kode.str_pad((int)$nomor + 1, strlen($nomor), "0", STR_PAD_LEFT);
		} else {
			$penjualan->kodedepo_inv = $kode."000001";
		}
			


		// $penjualan->kodedepo_inv = $res_kode['data']['recordset'][0]['Kode'] ?? null;
		$penjualan->inisialjual_inv = $res_inisial['data']['recordset'][0]['Inisial'] ?? null;
		


		// get Nomor Jual
		$kodejual_head = $penjualan->inisialjual_inv.date('Ym');
		$res_nojual = CJSON::decode($api->apiRequest(
			$this->getBridgingHost() . "/getNoJual", 
			"POST", $header, CJSON::encode(array(
				'NoJual'=>$kodejual_head
			))) ?? "{}");

		$nojual_cur = $res_nojual['data']['recordset'][0]['NoJual'] ?? null;
		if (!empty($nojual_cur)) {
			$nomor = substr($nojual_cur, strlen($kodejual_head));

			$penjualan->nojual_inv = $kodejual_head.str_pad((int)$nomor + 1, strlen($nomor), "0", STR_PAD_LEFT);
			// var_dump($penjualan->nojual_inv);
		} else {
			$penjualan->nojual_inv = $kodejual_head."000001";
		}

		// var_dump($kode, $res_kode, $penjualan->kodedepo_inv, 
		// $res_inisial, $res_nojual, $penjualan->nojual_inv); die;



		$ok = $ok && $penjualan->save(false, array('kodedepo_inv', 'inisialjual_inv', 'nojual_inv'));

		// var_dump($ok, $penjualan->kodedepo_inv, $penjualan->inisialjual_inv, $penjualan->nojual_inv); // die;
		// die;

		// Log Jual Resep	
		$penjualanAPI = InslogjualfarmasiInvV::model()->findByAttributes(array(
			'penjualanresep_id'=>$penjualan->penjualanresep_id
		));

		// var_dump($penjualanAPI->attributes); die;

		$petugas = empty($penjualanAPI->idpetugas) ? "PTG08120001" : $penjualanAPI->idpetugas;

		if (!empty($penjualanAPI)) {
			$query = array(
				'NoRMPx'=>$penjualanAPI->normpx,
				'NamaPx'=>$penjualanAPI->namapx,
				'TglLahir'=>$penjualanAPI->tgllahir,
				'UmurPx'=>$penjualanAPI->umurpx,
				'KetUmur'=>$penjualanAPI->ketumur,
				'AlamatPx'=>$penjualanAPI->alamatpx,
				'NoTT'=>$penjualanAPI->nott ?? "",
				'NoBilling'=>$penjualanAPI->nobilling,
				'KodeDepo'=>$penjualanAPI->kodedepo,
				'KodeJamin'=>$penjualanAPI->kodejamin,
				'KodeDokter'=>$penjualanAPI->kodedokter,
				'KodeTL'=>$penjualanAPI->kodetl ?? " ",
				'IdPetugas'=>$petugas,
				'Kode'=>$penjualanAPI->kode,
				'NoJual'=>$penjualanAPI->nojual,
				'TglJual'=>$penjualanAPI->tgljual,
				'NoMinta'=>$penjualanAPI->nominta,
				'Aktif'=>$penjualanAPI->aktif,
				'StCetak'=>$penjualanAPI->stcetak,
				'StJual'=>$penjualanAPI->stjual,
				'TotJual'=>$penjualanAPI->totjual,
			);

			// var_dump($query, $penjualanAPI->attributes); die;

			$res_logjual = CJSON::decode($api->apiRequest(
				$this->getBridgingHost() . "/TTLogJual", 
				"POST", $header, CJSON::encode($query)) ?? "{}");


			// var_dump($kode, $res_kode, $res_inisial, $res_nojual, $res_logjual, $query); die;

			if (!empty($res_logjual) && !empty($res_logjual['status']['OK']) && $res_logjual['status']['OK'] == true) {
				// var_dump("MULAI SET DETAIL JUAL");

				$det = InslogjualdfarmasiInvV::model()->findAllByAttributes(array(
					'kodejual'=>$penjualan->nojual_inv,
					'kode'=>$penjualan->kodedepo_inv
				));

				// var_dump(count($det)); die;

				$cnt = 1;
				foreach ($det as $idx => $item) {

					// for ($k = 0; $k < 2; $k++) {

					// insert log detail obat alkes

					$kode_det = $penjualanAPI->kode.str_pad($cnt, 4, "0", STR_PAD_LEFT);
					$kode_jual = $penjualanAPI->kode;
					// var_dump($kode_det); die;

					$query_detail = array(
						'kodebarang'=>$item->kodebarang,
						'hpp'=>$item->hpp,
						'satuan'=>$item->satuan,
						'ststock'=>$item->ststock,
						'stracik'=>$item->stracik,
						'signa'=>$item->signa,
						'frek'=>'', //$item->frek,
						'jfrek'=>'', //$item->jfrek ?? 1,
						'peng'=>0,
						'penf'=>0,
						'sp'=>0,
						'ss'=>0,
						'ssr'=>0,
						'sm'=>0,
						'jumlah'=>$item->jumlah,
						'harga'=>$item->harga,
						'hargaretur'=>$item->hargaretur,
						'kode'=>$kode_det,
						'kodejual'=>$kode_jual, //$penjualanAPI->nojual,
					);

					// var_dump($query_detail); die;

					$res_logjual_detail = CJSON::decode($api->apiRequest(
						$this->getBridgingHost() . "/TTLogjualD", 
						"POST", $header, CJSON::encode($query_detail)) ?? "{}");

					// var_dump($query_detail, $res_logjual_detail);

					if (!empty($res_logjual_detail['status']['OK']) && $res_logjual_detail['status']['OK'] == true) {
						// update stok

						$kodeDepo = $ruangan->kodedepo_inventory;
						$kodeBarang = $item->kodebarang;
						$periode = date('Ym');

						// $kodeDepo = "DEPO0808001";
						// $kodeBarang = "OBORAL3098";
						// $periode = "202305";


						$query_cek_stok = array(
							"jmlItem"=>$item->jumlah,
							"KodePeriode"=>$periode,
							"KodeDepo"=>$kodeDepo,
							"KodeBarang"=>$kodeBarang,
							"StStock"=>$item->ststock,
						);
	
						$res_cek_stok = CJSON::decode($api->apiRequest(
							$this->getBridgingHost() . "/cekstok", 
							"POST", $header, CJSON::encode($query_cek_stok)) ?? "{}");

						// var_dump("https://ihdev-apisim.rssa.my.id/simgosfarmasirssa/cekstok", $query_cek_stok, $res_cek_stok);
	
							// TODO : Validasi ?
						if (
							!empty($res_cek_stok['status']['OK']) 
							&& $res_cek_stok['status']['OK'] == true
						) {
		
							$jml_stok = $res_cek_stok['data']['recordset'][0]['stok_akhir'] ?? 0;

							if ($jml_stok > 0) {
								$res_update_stok = CJSON::decode($api->apiRequest(
									$this->getBridgingHost() . "/updatestok", 
									"PUT", $header, CJSON::encode($query_cek_stok)) ?? "{}");

								// var_dump("https://ih-apisim.rssa.my.id/simgosfarmasirssa/updatestok", $query_cek_stok, $res_update_stok);
							}



						}

					}

					$cnt++;

					// }


				}

			}

				


			// var_dump($res_logjual, $query, $penjualanAPI->attributes);

		}

		// die;
		// load oa ruangan
		

		// var_dump($oa->attributes); die;
	}

	  /**
   * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienAdmisi, $post)
  {
    $modTindakan = new BKTindakanPelayananT;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->pasien_id = $modPendaftaran->pasien_id;
    $modTindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
    $modTindakan->jeniskasuspenyakit_id = (!empty($modPasienAdmisi->jeniskasuspenyakit_id) ? $modPasienAdmisi->jeniskasuspenyakit_id : $modPendaftaran->jeniskasuspenyakit_id);
    $modTindakan->kelaspelayanan_id = (!empty($modPasienAdmisi->kelaspelayanan_id) ? $modPasienAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id);
    $modTindakan->carabayar_id = (!empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id);
    $modTindakan->penjamin_id = (!empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
    $modTindakan->ruangan_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan_id : $modPendaftaran->ruangan_id);
    $modTindakan->attributes = $post;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($modTindakan->tgl_tindakan);
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

    if(!empty($md_noawal)) {
      $noawal = intval($md_noawal->nopelayanan) + 1;
    } else {
      $noawal = 1;
    }

    $modTindakan->nopelayanan = str_pad($noawal,3,"0",STR_PAD_LEFT);
    
    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }
    
    return $modTindakan;
  }

	public function actionSetObatAlkesPasien()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$obatalkes_id = $_POST['obatalkes_id'];
			$jumlah = $_POST['jumlah'];
			$therapiobat_id = isset($_POST['therapiobat_id']) ? $_POST['therapiobat_id'] : null;
			$instalasi = $_POST['instalasi_id'];
			// $penjamin_id = $_POST['penjamin_id'];
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			$modObatAlkesPasien = new FAObatalkesPasienT;
			$otherdata = array();
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
			$oa = FAObatalkesM::model()->findByPk($obatalkes_id);
			$otherdata = array();
			$konfigFarmasi = KonfigfarmasiK::model()->find();
			$modObatAlkesPasien->hargasatuan_oa = $oa->hargajual;

			$modObatAlkesPasien->ppnpersen = 0;
			if ($oa->jenisobatalkes_id !== Params::JENISOBATALKES_ID_BHP && $oa->jenisobatalkes_id !== Params::JENISOBATALKES_ID_ALKES) {
				if ($instalasi == Params::INSTALASI_ID_RJ || $instalasi == Params::INSTALASI_ID_HD || $instalasi == 74) {
					$modObatAlkesPasien->ppnpersen = $konfigFarmasi->rj_persjualppn;
				} else if ($instalasi == Params::INSTALASI_ID_RI || $instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
					$modObatAlkesPasien->ppnpersen = $konfigFarmasi->ri_persjualppn;
				} else if ($instalasi == Params::INSTALASI_ID_RD || $instalasi == Params::INSTALASI_ID_PERSALINAN) {
					$modObatAlkesPasien->ppnpersen = $konfigFarmasi->rd_persjualppn;
				}
			}

			$modObatAlkesPasien->jumlahppn = 0;

			if ($konfigFarmasi->ishargaperpenjamin == true) {
				if (!empty($penjamin_id)) {
					$obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id' => $oa->jenisobatalkes_id, 'penjamin_id' => $penjamin_id));

					if (!empty($obatalkesPenjamin)) {
						$marginRp = round((($oa->hargajual * $obatalkesPenjamin->persmargin) / 100), 2);
						$hargaSatuan = round(($oa->hargajual + $marginRp), 2);
						$modObatAlkesPasien->hargasatuan_oa = $hargaSatuan;
						// $modResepturDetail->biayaadministrasi = $obatalkesPenjamin->biayaadministrasi;
						// $modResepturDetail->persdiskon = $obatalkesPenjamin->persdiskon;
					}
				}
			}

			//if(count((array)$modStokOAs) > 0){
			//foreach($modStokOAs AS $i => $stok){
			$modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
			$modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
			$modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
			$modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
			//$stok->HargaJualSatuan;
			$modObatAlkesPasien->jmlstok = $oa->StokObatRuangan; //$stok->qtystok;
			$modObatAlkesPasien->r = 'R/';
			$modObatAlkesPasien->hargajual_oa = round(($modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa) * 100) / 100;
			$modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
			$modObatAlkesPasien->biayaservice = 0;
			$modObatAlkesPasien->biayakonseling = 0;
			$modObatAlkesPasien->jasadokterresep = 0;
			$modObatAlkesPasien->biayakemasan = 0;
			$modObatAlkesPasien->biayaadministrasi = 0;
			$modObatAlkesPasien->tarifcyto = 0;
			$modObatAlkesPasien->discount = 0;
			$modObatAlkesPasien->subsidiasuransi = 0;
			$modObatAlkesPasien->subsidipemerintah = 0;
			$modObatAlkesPasien->subsidirs = 0;
			$modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
			$modObatAlkesPasien->therapiobat_id = $therapiobat_id;
			$otherdata['stok'] = $oa->StokObatRuangan;

			$modObatAlkesPasien->hargasatuan_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->hargasatuan_oa, 2);
			$modObatAlkesPasien->hargajual_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->hargajual_oa, 2);
			// $modObatAlkesPasien->subtotal = MyFormatter::formatNumberForPrint($modObatAlkesPasien->subtotal, 2);

			$otherdata['instalasi_id'] = $instalasi;
			$otherdata['ppnpersen'] = $modObatAlkesPasien->ppnpersen;
			$otherdata['obatalkes_kode'] = $oa->obatalkes_kode;

			// $modFormularium = FormulariumobatM::model()->findByAttributes(['penjamin_id' => $penjamin_id, 'obatalkes_id' => $obatalkes_id]);
			// if (!empty($modFormularium)) {
			// 	$modObatAlkesPasien->formulariumobat_id = $modFormularium->formulariumobat_id;
			// }

			//$otherdata['stokobatalkes_id'] = $stok->stokobatalkes_id;
			//}
			//}else{
			//    $pesan = "Stok tidak mencukupi!";
			//}

			echo CJSON::encode(array('modObatAlkesPasien' => $modObatAlkesPasien, 'pesan' => $pesan, 'otherdata' => $otherdata));
			Yii::app()->end();
		}
	}

	public function actionPrintResepDokter()
	{
		$reseptur_id = $_GET['id'];
		$modReseptur = FAResepturT::model()->findByPk($reseptur_id);
		$pendaftaran_id = $modReseptur->pendaftaran_id;
		$criteria = new CDbCriteria;
		$criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
		$maxtime = FAResepturT::model()->find($criteria);
		$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
		$modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

		$judulLaporan = '';

		$criteriakl = new CDbCriteria;
		$criteriakl->addCondition("reseptur_id = " . $reseptur_id);
		$criteriakl->select = 'racikan_id, rke, iter, reseptur_id';
		$criteriakl->group = 'racikan_id, rke, iter, reseptur_id';
		$criteriakl->order = 'rke';
		$kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);

		$caraPrint = $_REQUEST['caraPrint'];
		if (isset($_GET['idReseptur'])) {
			$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $_GET['idReseptur']));
			if ($caraPrint == 'PRINT') {
				$this->layout = '//layouts/printWindows';
				$this->render('_viewDetailResep', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDetailResep' => $modDetailResep));
			}
		} else {
			if ($caraPrint == 'PRINT') {
				$this->layout = '//layouts/printWindows';
				$this->render('Print', array(
					'modPendaftaran' => $modPendaftaran,
					'judulLaporan' => $judulLaporan,
					'caraPrint' => $caraPrint,
					"modDetailResep" => $modDetailResep,
					'modReseptur' => $modReseptur,
					'kerangkaLooping' => $kerangkaLooping
				));
			}
		}
	}

	public function actionCopyResep($penjualanresep_id, $pasien_id, $sukses = null)
	{
		$this->layout = '//layouts/iframe';
		$modObatAlkesPasien = array();

		$model = FACopyResepR::model()->findByAttributes(array('penjualanresep_id' => $penjualanresep_id));
		if (empty($model)) {
			$model = new FACopyResepR();
		}
		$tersimpan = 'Tidak';

		$modelPenjualanResep = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		$modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id, 'pasien_id' => $pasien_id));
		$modPasien = FAPasienM::model()->findByPk($pasien_id);
		$modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $modelPenjualanResep->reseptur_id), array('order' => 'rke ASC'));
		$modCopy = CopyresepR::model()->findAll('penjualanresep_id=' . $penjualanresep_id . ' order by copyresep_id desc limit 1');
		$modPendaftaran = FAPendaftaranT::model()->findByPk($modelPenjualanResep->pendaftaran_id);

		foreach ($modCopy as $i => $data) {
			$copy = $data->jmlcopy;
			$penjualanresep = $data->penjualanresep_id;
			$copyresep = $data->copyresep_id;
		}
		if (isset($_POST['FACopyResepR'])) {
			if ($modCopy == null) {
				$copy = 1;
				$jmlCopy = $copy;
				$model->attributes = $_POST['FACopyResepR'];
				$model->tglcopy = date('Y-m-d');
				$model->penjualanresep_id = $_POST['FAPenjualanResepT']['penjualanresep_id'];
				$model->keterangancopy = $_POST['FACopyResepR']['keterangancopy'];
				$model->jmlcopy = $jmlCopy;
				$model->create_time = date('Y-m-d');
				$model->update_time = date('Y-m-d');
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->update_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				if (!empty($modelPenjualanResep->reseptur_id)) {
					$model->reseptur_id = $modelPenjualanResep->reseptur_id;
				} else {
					$model->reseptur_id = null;
				}
			} else {
				$copy = $copy + 1;
			}

			$penjualanresep = (isset($penjualanresep) ? $penjualanresep : null);
			if ($penjualanresep == $penjualanresep_id) {
				$update = CopyresepR::model()->UpdateAll(array(
					'jmlcopy' => $copy,
					'tglcopy' => date('Y-m-d'),
					'keterangancopy' => $_POST['FACopyResepR']['keterangancopy'],
					'create_time' => date('Y-m-d'),
					'update_time' => date('Y-m-d'),
					'create_loginpemakai_id' => Yii::app()->user->id,
					'update_loginpemakai_id' => Yii::app()->user->id,
					'create_ruangan' => Yii::app()->user->getState('ruangan_id')
				), 'penjualanresep_id=:penjualanresep_id and copyresep_id=:copyresep_id', array(':penjualanresep_id' => $_POST['FAPenjualanResepT']['penjualanresep_id'], ':copyresep_id' => $copyresep));

				if ($update) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$tersimpan = 'Ya';
					$model = FACopyResepR::model()->findByAttributes(array('penjualanresep_id' => $penjualanresep_id));
				} else {
					//                            $transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan");
				}
			} else {
				if ($model->save()) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$tersimpan = 'Ya';
				} else {
					// $transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan");
				}
			}
		}

		$model->tglcopy = Yii::app()->dateFormatter->formatDateTime(
			CDateTimeParser::parse($model->tglcopy, 'yyyy-MM-dd')
		);

		$this->render('formCopyResep', array(
			'modelPenjualanResep' => $modelPenjualanResep,
			'modPasien' => $modPasien,
			'model' => $model,
			'modCopy' => $modCopy,
			'modObatAlkesPasien' => $modObatAlkesPasien,
			'tersimpan' => $tersimpan,
			'modDetailReseptur' => $modDetailReseptur,
			'modPendaftaran' => $modPendaftaran
		));
	}

	public function actionPrintCopyResep($idPenjualanResep)
	{

		$modPenjualan = FAPenjualanResepT::model()->findByPk($idPenjualanResep);
		$reseptur_id = $modPenjualan->reseptur_id;
		$modReseptur = FAResepturT::model()->findByPk($reseptur_id);
		$pendaftaran_id = $modPenjualan->pendaftaran_id;
		$modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modDetailResep = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $reseptur_id), array('order' => 'rke ASC, resepturdetail_id ASC'));

		$criteria = new CDbCriteria;
		$criteria->addCondition("resepturdetail_id IS NOT NULL");
		$criteria->addCondition("penjualanresep_id = " . $modPenjualan->penjualanresep_id);
		$criteria->order = "resepturdetail_id ASC";
		$modObatAlkes = FAObatalkesPasienT::model()->findAll($criteria);

		$judulLaporan = '';

		$criteriakeliter = new CDbCriteria;
		$criteriakeliter->addCondition("reseptur_id = " . $reseptur_id);
		$criteriakeliter->select = 'iter';
		$criteriakeliter->group = 'iter';
		$criteriakeliter->order = 'iter DESC';
		$kelompokiter = ResepturdetailT::model()->findAll($criteriakeliter);

		$caraPrint = $_REQUEST['caraPrint'];

		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
		} else if ($caraPrint == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial('PrintCopyResep', array(
				'modPendaftaran' => $modPendaftaran,
				'judulLaporan' => $judulLaporan,
				"modDetailResep" => $modDetailResep,
				'modReseptur' => $modReseptur,
				'modPenjualan' => $modPenjualan,
				'modObatAlkes' => $modObatAlkes,
				'kelompokiter' => $kelompokiter,
				'caraPrint' => $caraPrint
			), true));
			$mpdf->Output();
			exit;
		}
		$this->render('PrintCopyResep', array(
			'modPendaftaran' => $modPendaftaran,
			'judulLaporan' => $judulLaporan,
			"modDetailResep" => $modDetailResep,
			'modReseptur' => $modReseptur,
			'modPenjualan' => $modPenjualan,
			'modObatAlkes' => $modObatAlkes,
			'kelompokiter' => $kelompokiter,
			'caraPrint' => $caraPrint
		));
	}

	protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
	{
		$format = new MyFormatter();
		$periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
		if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	public function GetJumlahDilayani($resepturdetail_id)
	{
		$return = 0;
		$modObatAlkesPasiens = FAObatalkesPasienT::model()->findAllByAttributes(array('resepturdetail_id' => $resepturdetail_id));
		foreach ($modObatAlkesPasiens as $i => $modObatAlkesPasien) {
			$return += $modObatAlkesPasien->qty_oa;
		}
		return $return;
	}

	protected function savePenjualanResepRS($modPendaftaran, $penjualanResep, $modReseptur = null)
	{
		//var_dump($modReseptur->attributes);
		$format = new MyFormatter();
		$modPenjualan = new FAPenjualanResepT;
		$modPenjualan->attributes = $penjualanResep;
		$modPenjualan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modPenjualan->penjamin_id = $modPendaftaran->penjamin_id;
		$modPenjualan->carabayar_id = $modPendaftaran->carabayar_id;
		$modPenjualan->antrianfarmasi_id = isset($penjualanResep['antrianfarmasi_id']) ? $penjualanResep['antrianfarmasi_id'] : null;
		$modPenjualan->pegawai_id = isset($_POST['FAPenjualanResepT']['pegawai_id']) ? $_POST['FAPenjualanResepT']['pegawai_id'] : $_POST['FAResepturT']['pegawai_id'];
		$modPenjualan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
		$modPenjualan->pasien_id = $modPendaftaran->pasien_id;
		$modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array("pendaftaran_id" => $modPendaftaran->pendaftaran_id, "pasien_id" => $modPendaftaran->pasien_id));
		$modPenjualan->pasienadmisi_id = (empty($modPasienAdmisi->pasienadmisi_id)) ? null : $modPasienAdmisi->pasienadmisi_id;
		$modPenjualan->tglpenjualan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
		$modPenjualan->tglresep = !empty($modReseptur) ? $format->formatDateTimeForDb($modReseptur->tglreseptur) : date('Y-m-d H:i:s');
		$modPenjualan->ruanganasal_nama = Yii::app()->user->getState('ruangan_nama');
		$modPenjualan->instalasiasal_nama = Yii::app()->user->getState('instalasi_nama');
		$modPenjualan->reseptur_id = (!empty($modReseptur->reseptur_id) ? $modReseptur->reseptur_id : null);
		$modPenjualan->is_cito = isset($penjualanResep['is_cito']) ? $penjualanResep['is_cito'] : 0;
		$modPenjualan->statusobat = 'SEDANG DILAYANI';
		$modPenjualan->kiepenyerahan = CJSON::encode($_POST['FAPenjualanResepT']['kiepenyerahan']);
		$modPenjualan->kodepetugas_inv = $_POST['FAPenjualanResepT']['kodepetugas_inv'];

		if(isset($_POST['telaah_resep'])) {
			// echo '<pre>'; var_dump($_POST['telaah_resep']); die;
			// $modPenjualan->penelaahanresep = !empty($_POST['telaah_resep']) ? '[' . implode($_POST['telaah_resep'], ', ') . ']' : null;

			$telaah = $_POST['telaah_resep'];

			$telres = [];

			$i = 0;
			foreach($telaah as $t => $tel) {

				$telres[$i] = ucwords(str_replace('_', ' ', $t));
				$i++;

			}
			$modPenjualan->penelaahanresep = "[" . implode(', ', $telres) .  "]";

		}

		if (isset($_POST['ruangan_id'])) { //dari form
			$ruangan = RuanganM::model()->findByPk($_POST['ruangan_id']);
			$modPenjualan->ruanganasal_nama = $ruangan->ruangan_nama;
			$modPenjualan->instalasiasal_nama = $ruangan->instalasi->instalasi_nama;
		}
		$modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
		$modPenjualan->noresep = !empty($modReseptur) ? $modReseptur->noresep : MyGenerator::noResep($_POST['instalasi_id']);
		$modPenjualan->subsidiasuransi = 0;
		$modPenjualan->subsidipemerintah = 0;
		$modPenjualan->subsidirs = 0;
		$modPenjualan->iurbiaya = 0;
		$modPenjualan->discount = 0;
		$modPenjualan->jasapelayanan_farmasi = isset($penjualanResep['jasapelayanan_farmasi']) ? $penjualanResep['jasapelayanan_farmasi'] : null;
		$modPenjualan->create_time = date("Y-m-d H:i:s");
		$modPenjualan->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
		$modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modPenjualan->jasaembalase = isset($penjualanResep['jasaembalase']) ? $penjualanResep['jasaembalase'] : 0;
		$modPenjualan->totalinacbg = isset($penjualanResep['totalinacbg']) ? $penjualanResep['totalinacbg'] : 0;
		// $modPenjualan->grandtotal = isset	($penjualanResep['grandtotal']) ? $penjualanResep['grandtotal'] : 0;
		$modPenjualan->totalkronis = isset($penjualanResep['totalkronis']) ? $penjualanResep['totalkronis'] : 0;

		if ($modPenjualan->validate()) {
			$modPenjualan->save();
			PendaftaranT::model()->updateByPk($modPenjualan->pendaftaran_id, array('pembayaranpelayanan_id' => null));
			if (!empty($modReseptur->reseptur_id))
				ResepturT::model()->updateByPk($modReseptur->reseptur_id, array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
			$this->penjualantersimpan = true;
		} else {
			$this->penjualantersimpan = false;
			Yii::app()->user->setFlash('error', "Data Penjualan Resep Tidak valid");
		}

		return $modPenjualan;
	}

	/**
	 * menghitung proporsi obat
	 */
	public function actionSetProporsiTakaranResep()
	{
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$takaran = $_POST['takaran'];
			parse_str($_POST['data'], $dataOAs);
			$data['pesan'] = '';
			//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jml jika obat sama
			$detailGroups = array();
			foreach ($dataOAs['FAResepturDetailT'] as $i => $postDetail) {
				$obatalkes_id = $postDetail['obatalkes_id'];
				if (isset($detailGroups[$obatalkes_id])) {
					$detailGroups[$obatalkes_id]['qty_reseptur'] += $postDetail['qty_reseptur'];
				} else {
					$detailGroups[$obatalkes_id] = $postDetail;
					$detailGroups[$obatalkes_id]['qty_reseptur'] = $postDetail['qty_reseptur'];
				}
			}
			//END GROUP
			//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
			$form = "";
			foreach ($detailGroups as $i => $detail) {
				$qtyoa = round(($detail['qty_reseptur'] * $takaran), 2);
				$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $qtyoa, Yii::app()->user->getState('ruangan_id'));
				if (count((array)$modStokOAs) > 0) {
					foreach ($modStokOAs as $i => $stok) { //copy dari function actionSetFormObatAlkesPasien
						$modResepturDetail = new FAResepturDetailT();
						$modResepturDetail->attributes = $detail;
						$modResepturDetail->jmlstok = $stok->qtystok;
						$modResepturDetail->qty_dilayani = ceil($qtyoa);
						$form .= $this->renderPartial('_rowDetail', array('modResepturDetail' => $modResepturDetail, 'takaranresep' => true), true);
					}
				} else {
					$data['pesan'] .= 'Jumlah Stok ' . $detail['obatalkes_nama'] . ' tidak mencukupi.<br>';
				}
			}
			$data['form'] = $form;
			echo json_encode($data);
		}
		Yii::app()->end();
	}

	/**
	 * fungsi cetak etiket
	 * @param type $penjualanresep_id
	 * @param type $caraPrint
	 */
	public function actionPrintEtiket($penjualanresep_id, $caraPrint = null, $racikan = null, $obatalkespasien_id = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);

		$racikan_id = ($racikan == 1) ? Params::RACIKAN_ID_RACIKAN : Params::RACIKAN_ID_NONRACIKAN;

		$crJual = new CDbCriteria;
		$crJual->compare('penjualanresep_id', $penjualanresep_id);
		$crJual->compare('racikan_id', $racikan_id);
		$crJual->compare('obatalkespasien_id', $obatalkespasien_id);
		$crJual->order = 'rke asc';

		$modPenjualanDetail = FAObatalkesPasienT::model()->findAll($crJual);


		$judul_print = 'Penjualan Resep Rumah Sakit';


		$modReseptur = ResepturT::model()->findByPk($modPenjualan->reseptur_id);
		$modResepturDet = ResepturdetailT::model()->findByPk($modPenjualan->reseptur_id);

		$view = ($racikan == 1) ? "PrintEtiketRacikan" : "PrintEtiketV2";

		if(isset($_GET['pdf'])) {
			$view .= "PDF";
		}

		if ($caraPrint == "PRINT") {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = 'L'; //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', array(40, 65));
			$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
			ob_clean();
			$mpdf->WriteHTML($formatkonten, 1);
			ob_clean();
			$mpdf->mirrorMargins = 0;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 0, 0, -3, 0, 0, 0);
			$mpdf->SetHTMLFooter('<span></span>');
			$mpdf->WriteHTML(
				$this->renderPartial($view, array(
					'format' => $format,
					'judul_print' => $judul_print,
					'modPenjualan' => $modPenjualan,
					'modPenjualanDetail' => $modPenjualanDetail,
					'caraPrint' => $caraPrint,
					'modReseptur' => $modReseptur,
					'modResepturDet' => $modResepturDet,
					'racikan' => $racikan_id,
				), true)
			);
			$mpdf->SetJS('this.print();');
			$mpdf->Output();
		} else {
			$this->render($view, array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint,
				'modReseptur' => $modReseptur,
				'modResepturDet' => $modResepturDet,
				'racikan' => $racikan_id,
			));
		}
	}

	public function actionPrintEtiketRanap($penjualanresep_id, $caraPrint = null, $racikan = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		
		// $racikan_id = ($racikan == 1) ? Params::RACIKAN_ID_RACIKAN : Params::RACIKAN_ID_NONRACIKAN;

		$modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array(
			'penjualanresep_id' => $penjualanresep_id,
			// 'racikan_id'=>$racikan_id,
		), array('order' => 'rke asc'));
		$modCatatanpemberianobat = CatatanpemberianobatT::model()->findAllByAttributes(array(
			// 'obatalkes_id' => $modPenjualan->obatalkes_id,
			'pendaftaran_id' => $modPenjualan->pendaftaran_id,
			'pasien_id' => $modPenjualan->pasien_id,
		), array('order' => 'pendaftaran_id asc'));
		foreach ($modCatatanpemberianobat as $mod) {
			$modCatatanpemberianobatdet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id' => $mod->catatanpemberianobat_id), array('order' => 'jadwal asc'));
		}

		// $modObt = FAObatalkesM::model()->findByPk($modPenjualan->obatalkes_id);
		// $modSubjenis = SubjenisM::model()->findByPk($modObt->subjenis_id);

		// $cri = new CDbCriteria();
		// if (!empty($subjenis_id)){
		// 	$cri->addCondition(" subjenis_id = ".$subjenis_id." ");
		// }else{
		// 	$cri->addCondition(" jadwalpemberianobat_id IS NULL ");
		// }
		// $cri->addCondition(" signa_oa = '".$signa."'  AND jadwalpemberianobat_aktif = TRUE ");

		// $jadwal = JadwalpemberianobatM::model()->findAll($cri);
		// if (empty($jadwal)){
		// 	$jadwal = JadwalpemberianobatM::model()->findAll(" signa_oa IS NULL AND subjenis_id IS NULL AND jadwalpemberianobat_aktif = TRUE ");
		// }

		$judul_print = 'Penjualan Resep Rumah Sakit';
		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			//	$this->layout='//layouts/printWindows';
		}


		$modReseptur = ResepturT::model()->findByPk($modPenjualan->reseptur_id);

		if (empty($modReseptur)) {
			$modReseptur = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		}

		$view = "PrintEtiketRanap";

		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', array(60, 50));
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->setHTMLFooter('<span></span>');
		$mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
		$mpdf->WriteHTML(
			$this->renderPartial($view, array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint,
				'modReseptur' => $modReseptur,
				'modCatatanpemberianobat' => $modCatatanpemberianobat,
				'modCatatanpemberianobatdet' => $modCatatanpemberianobatdet,
			), true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}

	public function actionPrintEtiketRanapNew($penjualanresep_id, $caraPrint = null, $racikan = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);

		$modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array(
			'penjualanresep_id' => $penjualanresep_id,
		), array('order' => 'rke asc'));
		
		// echo '<pre>';var_dump($modObatAlkesPasien);die;

		// untuk membuat etiket sejumlah signa atau frekuensinya
		$dataObat = [];
		if(count($modObatAlkesPasien) > 0) {
			foreach ($modObatAlkesPasien as $i => $data) {
				if(!empty($data->signa_oa)) {
					$signa_oa = explode('x', $data->signa_oa);

					if(isset($signa_oa[0])) {
						$frekuensi = trim($signa_oa[0]);

						if($frekuensi > 0) {
							for ($i=1; $i <= $frekuensi; $i++) { 
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['obatalkes_nama'] = $data->obatalkes->obatalkes_nama;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['permintaan_oa'] = $data->permintaan_oa;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['jumlahpermintaan_obatnonracikan'] = $data->jumlahpermintaan_obatnonracikan;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['satuankekuatan'] = $data->satuankekuatan;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['satuansediaan'] = $data->satuansediaan;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['kadaluarsa'] = $data->kadaluarsa;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['rke'] = $data->rke;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['etiket'] = $data->etiket;

								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['obatalkes_id'] = $data->obatalkes_id;
								$dataObat[$data->obatalkespasien_id . '_' . $frekuensi][$i]['racikan_id'] = $data->racikan_id;
							}
						}
					}
				}
			}
		}

		// echo '<pre>';var_dump($dataObat);die;
		// die;


		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = 'L'; //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', array(40, 65));
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->AddPage($posisi, '', '', '', '', 0, 0, -3, 0, 0, 0);
		$mpdf->SetHTMLFooter('<span></span>');
		$mpdf->WriteHTML(
			$this->renderPartial('printEtiketRawatInap/print', array(
				'format' => $format,
				'modPenjualan' => $modPenjualan,
				'dataObat' => $dataObat
			), true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}

	public function actionPrintNotaPenjualan($penjualanresep_id, $caraPrint = null, $racikan = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		$modReseptur = ResepturT::model()->findByPk($modPenjualan->reseptur_id);
		$modResepturDet = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." order by obatalkespasien_id asc");
		$modPendaftaran = $modPenjualan->pendaftaran;
		$modPasien = $modPenjualan->pasien;

		$view = "PrintNotaPenjualan";

		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', array(200, 80));
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->setHTMLFooter('<span></span>');
		$mpdf->AddPage('L', '', '', '', '', 0, 0, 0, 0, 0, 0);
		$mpdf->WriteHTML(
			$this->renderPartial($view, array(
				'format' => $format,
				'modPenjualan' => $modPenjualan,
				'modReseptur' => $modReseptur,
				'modResepturDet' => $modResepturDet,
				'modPendaftaran' => $modPendaftaran,
				'modPasien' => $modPasien,
			), true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}

	public function actionPrintTelaah($penjualanresep_id, $caraPrint = null, $racikan = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		$modReseptur = ResepturT::model()->findByPk($modPenjualan->reseptur_id);

		$rke_max = ObatalkespasienT::model()->find("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke desc");
		$modResepturDet1 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke, obatalkespasien_id");

		$modResepturDet1 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke, obatalkespasien_id");
		$modResepturDet2 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 2 order by rke, obatalkespasien_id asc");
		$modPendaftaran = $modPenjualan->pendaftaran;
		$modPasien = $modPenjualan->pasien;
		$modSep = $modPendaftaran->sepTs ?? null;
		$modAnamnesa = AnamnesaT::model()->findAll("pendaftaran_id = $modPendaftaran->pendaftaran_id and riwayatalergiobat is not null");
		$modFisik = PemeriksaanfisikT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id order by pemeriksaanfisik_id desc");

		$view = "PrintTelaah";



		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', array(120, 540));
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->setHTMLFooter('<span></span>');
		$mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
		$mpdf->WriteHTML(
			$this->renderPartial($view, array(
				'format' => $format,
				'modPenjualan' => $modPenjualan,
				'modReseptur' => $modReseptur,
				'modResepturDet1' => $modResepturDet1,
				'modResepturDet2' => $modResepturDet2,
				'modPendaftaran' => $modPendaftaran,
				'modPasien' => $modPasien,
				'modAnamnesa' => $modAnamnesa,
				'modFisik' => $modFisik,
				'rke_max' => $rke_max,
				'modSep' => $modSep
			), true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}

	public function actionAutocompleteObatFarmasi()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$term = explode(';', $_GET['term']);
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			$obatalkes_nama = isset($term[0]) ? $term[0] : '';
			$hargajual = isset($term[1]) ? $term[1] : '';
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
			if ($hargajual != '') {
				$criteria->addCondition('hargajual =' . $hargajual, 'or');
			}
			$criteria->addCondition('obatalkes_farmasi = TRUE');
			$criteria->addCondition('obatalkes_aktif = true');
			$criteria->order = 'obatalkes_nama';
			$criteria->limit = 5;
			$models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
			$persenjual = $this->persenJualRuangan();
			$format = new MyFormatter();
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();

				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, $ruangan_id);
				$returnVal[$i]['label'] = $model->obatalkes_nama . " - Jumlah Stok " . $qtyStok;
				$returnVal[$i]['value'] = $model->obatalkes_nama;
				$returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
				$returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
				$returnVal[$i]['qtyStok'] = $qtyStok;
				$returnVal[$i]['hargajual'] = floor(($persenjual + 100) / 100 * $model->hargajual);
				$returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
				$returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
				$returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
				$returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionGetJumlahObat()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$data = [];
			$qty = intval($_POST['qty']);
			$models = FormulaobatkronisM::model()->findByAttributes(['jumlahobat' => $qty]);

			$data['formulaobatkronis_id'] = !empty($models) ? $models->formulaobatkronis_id : "";
			$data['jml_min'] = !empty($models) ? $models->jumlahobat_minimal : "";
			$data['jml_max'] = !empty($models) ? $models->jumlahobat_maksimal : "";

			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}

	public function actionSetMarginObat()
	{
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
			$is_tanggungan = isset($_POST['is_tanggungan']) ? $_POST['is_tanggungan'] : null;
			$penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;

			$modObat = ObatalkesM::model()->findByPk($obatalkes_id);
			if (empty($modObat)) {
				$modObat = new ObatalkesM();
			}
			$hargasatuan = $harga_setelah_margin = $margin = 0;
			$modPenjamin = ObatalkespenjaminM::model()->findByAttributes(['jenisobatalkes_id' => $modObat->jenisobatalkes_id, 'penjamin_id' => Params::PENJAMIN_ID_UMUM]);
			$data['formulariumobat_id'] = "";
			if ($is_tanggungan == 0) {
				$modPenjamin = ObatalkespenjaminM::model()->findByAttributes(['jenisobatalkes_id' => $modObat->jenisobatalkes_id, 'penjamin_id' => $penjamin_id]);
				if (empty($modPenjamin)) {
					$modPenjamin = new ObatalkespenjaminM();
				}
				$modFormularium = FormulariumobatM::model()->findByAttributes(['obatalkes_id' => $modObat->obatalkes_id, 'penjamin_id' => $penjamin_id]);
				$data['formulariumobat_id'] = !empty($modFormularium->formulariumobat_id) ? $modFormularium->formulariumobat_id : "";
			} else {
				$data['formulariumobat_id'] = "";
			}
			$margin = $modPenjamin->persmargin;
			$hargasatuan = ($margin / 100) * $modObat->hargajual;
			$harga_setelah_margin = $modObat->hargajual + $hargasatuan;

			$data['sukses'] = 1;
			$data['harga_satuan'] = MyFormatter::formatNumberForPrint($harga_setelah_margin, 2);
			$data['margin'] = $margin;

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionPrintKronisMin($penjualanresep_id, $caraPrint = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		$modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

		$judul_print = 'RINCIAN PENJUALAN RESEP RUMAH SAKIT';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'PrintKronis', array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint
			));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'PrintKronis', array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint
			));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$posisi = 'P';
			$mpdf = new MyPDF60('', [217, 140]);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->SetHTMLFooter('<span></span>');
			$mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintKronis', array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint
			), true));
			$mpdf->Output();
		}
	}

	public function actionPrintKronisMax($penjualanresep_id, $caraPrint = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
		$modPenjualan->printed_by = isset($modPenjualan->printed_by) ? $modPenjualan->printed_by + 1 : 0;
		$modPenjualan->save();

		$modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));
		$modPendaftaran = PendaftaranT::model()->findByattributes(array('pendaftaran_id' => $modPenjualanDetail[0]->pendaftaran_id));
		$modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
		$judul_print = 'RINCIAN PENJUALAN RESEP RUMAH SAKIT';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'PrintRS_kronis', array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint,
				'modPenanggungjawab' => $modPenanggungjawab
			));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'PrintRS_kronis', array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint
			));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$posisi = 'P';
			$mpdf = new MyPDF60('', [217, 140]);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->SetHTMLFooter('<span></span>');
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 10, 10, 10, 10);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintRS_kronis', array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint
			), true));
			$mpdf->Output();
		}
	}

	/**
	 * fungsi cetak etiket
	 * @param type $penjualanresep_id
	 * @param type $caraPrint
	 */
	public function actionPrintKronis($penjualanresep_id, $caraPrint = null, $racikan = null)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;
		$modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);

		// $racikan_id = ($racikan == 1) ? Params::RACIKAN_ID_RACIKAN : Params::RACIKAN_ID_NONRACIKAN;

		$modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array(
			'penjualanresep_id' => $penjualanresep_id,
			// 'racikan_id'=>$racikan_id,
		), array('order' => 'rke asc'));


		$judul_print = 'Penjualan Resep Rumah Sakit';
		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if ($caraPrint == 'PRINT') {
			//            $this->layout='//layouts/printWindows';
		}


		$modReseptur = ResepturT::model()->findByPk($modPenjualan->reseptur_id);
		$modResepturDet = ResepturdetailT::model()->findByPk($modPenjualan->reseptur_id);

		$view = "PrintKronis";

		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = 'L'; //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', array(40, 60));
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
		$mpdf->SetHTMLFooter('<span></span>');
		$mpdf->WriteHTML(
			$this->renderPartial($view, array(
				'format' => $format,
				'judul_print' => $judul_print,
				'modPenjualan' => $modPenjualan,
				'modPenjualanDetail' => $modPenjualanDetail,
				'caraPrint' => $caraPrint,
				'modReseptur' => $modReseptur,
				'modResepturDet' => $modResepturDet
			), true)
		);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}


	public function actionLoadJadwalPemberian()
	{
		if (Yii::app()->request->isAjaxRequest) {

			$signa = isset($_GET['signa']) ? $_GET['signa'] : null;
			$subjenis_id = isset($_GET['subjenis_id']) ? $_GET['subjenis_id'] : null;
			$no = isset($_GET['no']) ? $_GET['no'] : null;

			$cri = new CDbCriteria();
			if (!empty($subjenis_id)) {
				$cri->addCondition(" subjenis_id = " . $subjenis_id . " ");
			} else {
				$cri->addCondition(" jadwalpemberianobat_id IS NULL ");
			}
			$cri->addCondition(" signa_oa = '" . $signa . "'  AND jadwalpemberianobat_aktif = TRUE ");

			$jadwal = JadwalpemberianobatM::model()->findAll($cri);
			if (empty($jadwal)) {
				$jadwal = JadwalpemberianobatM::model()->findAll(" signa_oa IS NULL AND subjenis_id IS NULL AND jadwalpemberianobat_aktif = TRUE ");
			}

			$listJadwal = $jadwal;

			$list = '';

			if (!empty($listJadwal)) {
				foreach ($listJadwal as $key => $jadwal) {
					$list .= '  <input type="hidden" name="CatatanPemberianObat[' . $no . '][jadwal_pemberian][' . $key . '][jadwal]" value="' . $jadwal->jadwal . '" />
                                    <input type="checkbox" value="' . $jadwal->jadwalpemberianobat_id . '" name="CatatanPemberianObat[' . $no . '][jadwal_pemberian][' . $key . '][jadwalpemberianobat_id]">
                                ' . $jadwal->jadwal;
				}
			}

			echo json_encode([
				'listJadwal' => $list
			]);
			Yii::app()->end();
		}
	}

	public function actionGetCatatanDet()
	{
		if (Yii::app()->request->isAjaxRequest) {

			// echo '<pre>'; var_dump($_POST, $_GET); die;

			$data = [];
			$penjualanresep_id = $_POST['penjualanresep_id'];
			$crit1 = new CDbCriteria();
			$crit1->select = 't.catatanpemberianobatdet_t, t.catatanpemberianobat_id, t.jadwal, t.jadwalpemberianobat_id,
							  catatanpemberianobat_t.obatalkes_id';
			$crit1->join = ' JOIN catatanpemberianobat_t ON catatanpemberianobat_t.catatanpemberianobat_id = t.catatanpemberianobat_id
			 JOIN obatalkespasien_t oap ON oap.obatalkespasien_id = catatanpemberianobat_t.obatalkespasien_id';
			$crit1->addCondition(' oap.penjualanresep_id = ' . $penjualanresep_id);
			$crit1->order = 't.jadwal';
			$catatandet = CatatanpemberianobatdetT::model()->findAll($crit1);

			if (count($catatandet) > 0) {
				foreach ($catatandet as $i => $det) {
					$data[$i]['catatanpemberianobatdet_t'] = $det->catatanpemberianobatdet_t;
					$data[$i]['catatanpemberianobat_id'] = $det->catatanpemberianobat_id;
					$data[$i]['jadwal_id'] = $det->jadwalpemberianobat_id;
					$data[$i]['jadwal'] = $det->jadwal;
					$data[$i]['obatalkes_id'] = $det->obatalkes_id;
				}
			}

			$data2 = [];

			// echo '<pre>';

			$jadwal = null;
			$obat = [];

			foreach ($data as $j => $dt) {

				$data2[$dt['jadwal_id']]['jadwal'] = $dt['jadwal'];


				$obatalkes = ObatalkesM::model()->findByPk($dt['obatalkes_id']);

				if ($dt['jadwal'] != $jadwal) {

					$obat = [];
					array_push($obat, substr($obatalkes->obatalkes_nama, 0, 5));

					$data2[$dt['jadwal_id']]['obatalkes_id'] = str_replace(' ', '-',  $obat);
					$jadwal = $dt['jadwal'];
				} else {

					array_push($obat, substr($obatalkes->obatalkes_nama, 0, 5));

					$data2[$dt['jadwal_id']]['obatalkes_id'] = str_replace(' ', '-',  $obat);
					$jadwal = $dt['jadwal'];
				}
			}

			$data3 = [];
			foreach ($data2 as $i => $dt2) {

				$data3[$i]['jadwalke'] = $dt2['jadwal'];

				// var_dump($dt['obatalkes_id']); die;
				$data3[$i]['daftar_obat'] = is_array($dt2['obatalkes_id']) ? implode('_', $dt2['obatalkes_id']) : $dt2['obatalkes_id'];
			}

			// var_dump($data3);

			// die;

			echo CJSON::encode($data3);
		}
		Yii::app()->end();
	}

	public function actionAutocompleteObatApi()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $term = explode(';', $_GET['term']);
			// var_dump($term);die;
            $obatalkes_nama = isset($term[0]) ? $term[0] : '';
            $models = new ObatAPI;
            $models->Nama = $obatalkes_nama;
            $returnVal = [];
            foreach ($models->searchObatRuangan(Yii::app()->user->getState('ruangan_id'))->data as $i => $model) {
                if(empty($model['StFornas']) || $model['StFornas'] == 0) {
                    $jenisFornas = 'Non Fornas';
                } else {
                    $jenisFornas = 'Fornas';
                }
                $returnVal[$i]['label'] = $model['Nama'] . ' - ' . $jenisFornas . ' - ' . $model['jenis'] . ' - ' . $model['jmlStok'];
                $returnVal[$i]['value'] = $model['Nama'];
                $returnVal[$i]['kode'] = $model['Kode'];
                $returnVal[$i]['sumberdana'] = $model['jenis'];
                $returnVal[$i]['stok'] = $model['jmlStok'];
                $returnVal[$i]['StFornas'] = $model['StFornas'] ?? 0;
                $returnVal[$i]['hargajual'] = str_replace('.', ',', $model['HJual']);
                
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
