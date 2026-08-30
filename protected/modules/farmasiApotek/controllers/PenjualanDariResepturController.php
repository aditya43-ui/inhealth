<?php
Yii::import('farmasiApotek.controllers.PenjualanResepRSController');
/**
 * @package application.modules.farmasiApotek
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class PenjualanDariResepturController extends PenjualanResepRSController
{
	public $obatalkespasientersimpan = true;
	public $is_trracikan = false;
	public $ada_penjualan = false;
	public $obatkronis = false;
	public $list_tempat_layanan_api = null;
	public function actionIndex($reseptur_id = null, $penjualanresep_id = null, $frame = 0)
	{
		// if ($frame == 1) {
		//     $this->layout = '//layouts/iframe';
		// }
		if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'obat-api-grid') {
                $this->renderPartial('_dialogObatAPI');
                Yii::app()->end();
            }
           
        }

		$modReseptur = FAResepturT::model()->findByPk($reseptur_id);

		// var_dump($modReseptur); die;

		$modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $reseptur_id), array('order' => 'rke ASC, resepturdetail_id ASC'));
		$ruangan_id = Yii::app()->user->getState('ruangan_id');
		$instalasi_id = !empty($modReseptur->ruanganreseptur) ? $modReseptur->ruanganreseptur->instalasi_id : "";
		$modPegawai = PegawaiM::model()->findByPk($modReseptur->pegawai_id);
		$modAntrian = FAAntrianFarmasiT::model()->findByAttributes(array('reseptur_id' => $reseptur_id));
		$modPendaftaran = FAPendaftaranT::model()->findByPk($modReseptur->pendaftaran_id);
		if(!empty($modPendaftaran->pasienadmisi_id)) {
			$modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $reseptur_id, 'is_verifkasiapoteker' => '1'), array('order' => 'rke ASC, resepturdetail_id ASC'));
		}
		$modReseptur->jml = !empty($modReseptur) ? ResepturdetailT::getJmlRaciakan($reseptur_id) : 0;
		$modReseptur->admracikan = KonfigfarmasiK::model()->find()->admracikan;
		$modReseptur->administrasi = KonfigfarmasiK::model()->find()->administrasi;

		$modTindakan = new TindakanpelayananT;

		if (empty($modAntrian)) {
			$modAntrian = new FAAntrianFarmasiT();
		}

		// load obatalkes_m, ambil data harga. untuk detailreseptur yang baru
		$konfigFarmasi = KonfigfarmasiK::model()->find();
		foreach ($modDetailReseptur as $ii => $detail) {

			$terapi = TherapimapobatM::model()->findByAttributes(array(
				'obatalkes_id' => $detail->obatalkes_id,
			));
			$modOA = FAObatalkesM::model()->findByPk($detail->obatalkes_id);
			$modDetailReseptur[$ii]->hargasatuan_reseptur = $detail->hargasatuan_reseptur;
			$modDetailReseptur[$ii]->hargajual_reseptur = $detail->hargajual_reseptur;
			$modDetailReseptur[$ii]->persen_discount = $detail->persdiskon;
			// set verifikasi menjadi kosong
			$modDetailReseptur[$ii]->is_verifkasiapoteker = '';

			$modDetailReseptur[$ii]->ppnpersen = $detail->persenppnjual;
			$modDetailReseptur[$ii]->jumlahppn = $detail->jumlahppn;
			$modDetailReseptur[$ii]->subtotal = $detail->hargajual_reseptur;
			$modDetailReseptur[$ii]->biayaadministrasi = $detail->biayaadministrasi;
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

			// $modDetailReseptur[$ii]->waktupemberian_ranap = explode(", ", $modDetailReseptur[$ii]->waktupemberian_ranap);
			$waktu = explode(", ", $modDetailReseptur[$ii]->waktupemberian_ranap);

			if(count($waktu) <= 1) {
				$waktu = explode(",", $modDetailReseptur[$ii]->waktupemberian_ranap);

				if(end($waktu) == "") {
					array_pop($waktu);
				}
				// echo '<pre>'; var_dump($waktu); die;
				$modDetailReseptur[$ii]->waktupemberian_ranap = implode(", ", $waktu);
			} else {
				$modDetailReseptur[$ii]->waktupemberian_ranap = implode(", ", $waktu);
			}

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

			// jika pasien rawat inap
			if(!empty($modPendaftaran->admisi)) {
				$modAdmisi = $modPendaftaran->admisi;
				$modPenjualan->kodedokter_inventory = $modAdmisi->pegawai->kodedokter_inventory;
				$modPenjualan->jenislayanan_inv = $modAdmisi->ruangan->kodeJL_inventory;
				$modPenjualan->tempatlayanan_inv = $modAdmisi->ruangan->kodeTL_inventory;
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
		if (isset($_POST['FAResepturDetailT'])) {
			// echo '<pre>';var_dump($_POST);die;
			$modPenjualan = $this->savePenjualanResepRS($modPendaftaran, $_POST['FAPenjualanResepT'], $modReseptur);
			$modPendaftaran = $modReseptur->pendaftaran;
			$racikancek = 0;
			$racikannoncek = 0;
			$ruangan = RuanganM::model()->findByPk($modPenjualan->ruangan_id);

			if ($this->penjualantersimpan) {
				if (count((array) $_POST['FAResepturDetailT']) > 0) {
					//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
					$detailGroups = array();
					foreach ($_POST['FAResepturDetailT'] as $i => $postDetail) {

						if(isset($postDetail['is_verifkasiapoteker']) && $postDetail['is_verifkasiapoteker'] == '1') {
							// jika verivikasi disetujui
							$modDetails[$i] = new FAObatalkesPasienT;
							$modDetails[$i]->attributes = $postDetail;
							$modDetails[$i]->is_verifikasiapoteker = $postDetail['is_verifkasiapoteker'];
							$modDetails[$i]->permintaan_oa = isset($postDetail['permintaan_reseptur']) ? $postDetail['permintaan_reseptur'] : "";
							$modDetails[$i]->permintaan_dosis = isset($postDetail['permintaan_reseptur']) ? MyFormatter::formatNumberForDb($postDetail['permintaan_reseptur']) : 0;
							$modDetails[$i]->satuankekuatan_oa = $postDetail['satuankekuatan'];
							$modDetails[$i]->satuansediaan = $postDetail['satuansediaan'];
							$modDetails[$i]->penjualanresep_id = $modPenjualan->penjualanresep_id;
							$modDetails[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
							$modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
							$modDetails[$i]->shift_id = Yii::app()->user->getState('shift_id');
							$modDetails[$i]->pendaftaran_id = $modPenjualan->pendaftaran_id;
							$modDetails[$i]->pasien_id = $modPenjualan->pasien_id;
							$modDetails[$i]->carabayar_id = $modPenjualan->carabayar_id;
							$modDetails[$i]->penjamin_id = $modPenjualan->penjamin_id;
							$modDetails[$i]->pegawai_id = $modPenjualan->pegawai_id;
							$modDetails[$i]->tglpelayanan = MyFormatter::formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
							$modDetails[$i]->r = "R/";
							$modDetails[$i]->qty_oa = MyFormatter::formatNumberForDb($postDetail['qty_dilayani']);
							$modDetails[$i]->qty_jual = $modDetails[$i]->qty_oa;
							$modDetails[$i]->harganetto_oa = $postDetail['harganetto_reseptur'];
							$modDetails[$i]->signa_oa = !empty($postDetail['signa_oa']) ? $postDetail['signa_oa'] : null;
							$modDetails[$i]->hargasatuan_oa = is_numeric($postDetail['hargasatuan_reseptur']) ? $postDetail['hargasatuan_reseptur'] : MyFormatter::formatRupiahForDB($postDetail['hargasatuan_reseptur']);
							$modDetails[$i]->hargajual_oa = $postDetail['subtotal'];
							$modDetails[$i]->create_time = date("Y-m-d H:i:s");
							$modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
							$modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
							$modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
							$modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;
							// $modDetails[$i]->etiket = implode(" - ", $modDetails[$i]->etiket);
							$modDetails[$i]->etiket = $modDetails[$i]->etiket;
							$modDetails[$i]->keterangan = $postDetail['resepturketerangan'];
	
							$modDetails[$i]->persenppnjual = $postDetail['ppnpersen'];
							$modDetails[$i]->jumlahppn = $postDetail['jumlahppn'];
							$modDetails[$i]->persen_discount = $postDetail['persen_discount'];
							$modDetails[$i]->discount = $postDetail['discount'];
							$modDetails[$i]->biayaadministrasi = $postDetail['biayaadministrasi'];
							$modDetails[$i]->signa_oa = $postDetail['signa_reseptur'];
							$modDetails[$i]->waktupemberian_ranap = isset($postDetail['waktupemberian_ranap']) ? $postDetail['waktupemberian_ranap'] : null;
							// $modDetails[$i]->ppnperobat = $postDetail['ppnperobat'];
							$modDetails[$i]->permintaan_oa = !empty($postDetail['permintaan_dosis']) ? MyFormatter::formatNumberForDb($postDetail['permintaan_dosis']) : 0;
							
							$modDetails[$i]->jmlkemasan_oa = !empty($postDetail['jmlkemasan_reseptur']) ? $postDetail['jmlkemasan_reseptur'] : "";
							$modDetails[$i]->kekuatan_oa = !empty($postDetail['kekuatan_reseptur']) ? $postDetail['kekuatan_reseptur'] : "";
							$modDetails[$i]->satuankekuatan_oa = !empty($postDetail['satuankekuatan']) ? $postDetail['satuankekuatan'] : "";
							$modDetails[$i]->jumlahpermintaan_obatracikan = !empty($postDetail['jumlahpermintaan_obatracikan']) ? $postDetail['jumlahpermintaan_obatracikan'] : "";
							$modDetails[$i]->jumlahpermintaan_obatnonracikan = !empty($postDetail['jumlahpermintaan_obatnonracikan']) ? $postDetail['jumlahpermintaan_obatnonracikan'] : "";
							$modDetails[$i]->kadaluarsa = !empty($postDetail['kadaluarsa']) ? MyFormatter::formatDateTimeForDb($postDetail['kadaluarsa']) : null;
	
							if (!empty($modDetails[$i]->permintaandosis_pembilang) && !empty($modDetails[$i]->permintaandosis_penyebut)) {
								$modDetails[$i]->is_permintaandosispecahan = true;
							}
	
							//insert pajak_id = 6 //pajak ppn
							if (!empty($modDetails[$i]->jumlahppn) && $modDetails[$i]->jumlahppn > 0) {
								$modDetails[$i]->pajak_id = 6; //pajak ppn
							}
	
							if (!empty($modDetails[$i]->formulaobatkronis_id)) {
								$this->obatkronis = true;
							}
	
							$modDetails[$i]->formulariumobat_id = !empty($postDetail['formulariumobat_id']) ? $postDetail['formulariumobat_id'] : null;
							$modDetails[$i]->formulaobatkronis_id = !empty($postDetail['formulaobatkronis_id']) ? $postDetail['formulaobatkronis_id'] : null;
	
							if (!empty($postDetail['is_tanggungan'])) {
								$modDetails[$i]->is_ditanggungpasien = $postDetail['is_tanggungan'];
							}
	
							if ($modDetails[$i]->validate()) {
								if ($modDetails[$i]->racikan_id == Params::RACIKAN_ID_RACIKAN) {
									$racikancek += 1;
								}
								if ($modDetails[$i]->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
									$racikannoncek += 1;
								}
	
								$this->obatalkespasientersimpan &= $modDetails[$i]->save();
							} else {
								$this->obatalkespasientersimpan &= false;
							}
							$this->simpanStokObatAlkesOut2($modDetails[$i]);

						} else if(isset($postDetail['is_verifkasiapoteker']) && $postDetail['is_verifkasiapoteker'] == '0') {
							// jika veifikasi tidak disetujui

							$modVerifikasiPenjualan = new VerifikasipenjualanfarmasiT();
							$modVerifikasiPenjualan->reseptur_id = isset($_GET['reseptur_id']) ? $_GET['reseptur_id'] : null;
							$modVerifikasiPenjualan->resepturdetail_id = $postDetail['resepturdetail_id'];
							$modVerifikasiPenjualan->create_time = date('Y-m-d H:i:s');
							$modVerifikasiPenjualan->create_pegawai_id = Yii::app()->user->getState('pegawai_id');
							$modVerifikasiPenjualan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
							$modVerifikasiPenjualan->is_jual = false;
							$modVerifikasiPenjualan->pendaftaran_id = $modPendaftaran->pendaftaran_id;

							if($modVerifikasiPenjualan->save()) {
								$this->obatalkespasientersimpan &= true;
								$this->stokobatalkestersimpan &= true;
							} else {
								$this->obatalkespasientersimpan &= false;
							}
							
						}

						// $this->simpanTindakanPelayanan();
						// var_dump($modDetails[$i]->qty_oa);
						
					}
					//END GROUP
				}
				
				

				// die;

				$ii = 0;


				$this->broadcastPenjualanKeKasir($modPenjualan);

				try {


					if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
						if (!empty($modPendaftaran) && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ && (empty($modPendaftaran->pasienadmisi_id))) {
							$kodebooking = $modPendaftaran->no_pendaftaran;

							if (!empty($modPendaftaran->buatjanjipoli_id)) {
								$buatjanjipoli = BuatjanjipoliT::model()->findByPk($modPendaftaran->buatjanjipoli_id);

								if (!empty($buatjanjipoli)) {
									$kodebooking = $buatjanjipoli->no_buatjanji;
								}
							}
							// var_dump('test');die;
							$waktutunggupelayanan = new WaktutunggupelayananT();
							$waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
							$waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
							$waktutunggupelayanan->task_id = 6;
							$lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
							$waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
							$dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
							$waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));

							$waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
							$waktutunggupelayanan->kode_booking = $kodebooking; //$modPendaftaran->no_pendaftaran;
							$waktutunggupelayanan->statuskirim = 0;
							$waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
							$waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
							$waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
							$waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

							$antrianonlinebpjs = new AntrianOnlineBpjs();
							$body = array(
								"kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
							);
							$response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

							if (
								!empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
							) {
								$waktutunggupelayanan->statuskirim = 1;
								$waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
								$waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
							} else {
								$waktutunggupelayanan->statuskirim = 0;
								$waktutunggupelayanan->response_list = $response['metaData']['message'];
							}
							$waktutunggupelayanan->save();

							// task_id 7
							$waktutunggupelayanan = new WaktutunggupelayananT();
							$waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
							$waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
							$waktutunggupelayanan->task_id = 7;
							$lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
							$waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
							$dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+20 minutes"))));
							$waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));

							$waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
							$waktutunggupelayanan->kode_booking = $kodebooking; //$modPendaftaran->no_pendaftaran;
							$waktutunggupelayanan->statuskirim = 0;
							$waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
							$waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
							$waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
							$waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

							$antrianonlinebpjs = new AntrianOnlineBpjs();
							$body = array(
								"kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
							);
							$response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

							if (
								!empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
							) {
								$waktutunggupelayanan->statuskirim = 1;
								$waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
								$waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
							} else {
								$waktutunggupelayanan->statuskirim = 0;
								$waktutunggupelayanan->response_list = $response['metaData']['message'];
							}
							$waktutunggupelayanan->save();
						}

						//end proses

						/**
						 * PROSES SIMPAN JADWAL PEMBERIAN OBAT
						 */
						if (isset($_POST['CatatanPemberianObat'])) {
							$post_catatan_pemberian_obat = $_POST['CatatanPemberianObat'];

							foreach ($post_catatan_pemberian_obat as $key => $value) {
								if(isset($modDetails[$key]->obatalkespasien_id)) {
									$catatanpemberianobat = new CatatanpemberianobatT();
									$catatanpemberianobat->attributes = $value;
									$catatanpemberianobat->isalergiobat = ($catatanpemberianobat->isalergiobat === null) ? false : $catatanpemberianobat->isalergiobat;
									$catatanpemberianobat->pendaftaran_id = $modPenjualan->pendaftaran_id;
									$catatanpemberianobat->pasienadmisi_id = $modPenjualan->pasienadmisi_id;
									$catatanpemberianobat->pasien_id = $modPenjualan->pasien_id;
									if (empty($catatanpemberianobat->catatanpemberianobat_id)) {
										//                                                               if (!empty($value['resepturdetail_id'])){
										//                                                                    $oapasien = ObatalkespasienT::model()->findByAttributes(['resepturdetail_id'=>$value['resepturdetail_id']]);
										//                                                                    $catatanpemberianobat->obatalkespasien_id = $oapasien->obatalkespasien_id;
										//                                                               }else{
										// if ($catatanpemberianobat->obatalkespasien_id == $modDetails[$i]->obatalkespasien_id) {
										$catatanpemberianobat->obatalkespasien_id = $modDetails[$key]->obatalkespasien_id;
										// }
										//                                                               }
										$catatanpemberianobat->create_time = date('Y-m-d H:i:s');
										$catatanpemberianobat->create_loginpemakai = Yii::app()->user->getState('loginpemakai_id');
										$catatanpemberianobat->create_ruangan = Yii::app()->user->getState('ruangan_id');
									} else {
										$catatanpemberianobat->update_time = date('Y-m-d H:i:s');
										$catatanpemberianobat->update_loginpemakai = Yii::app()->user->getState('loginpemakai_id');
									}
	
									$this->obatalkespasientersimpan &= $catatanpemberianobat->save();
	
									if (!empty($value['jadwal_pemberian'])) {
										foreach ($value['jadwal_pemberian'] as $k => $v) {
											if (isset($v['jadwalpemberianobat_id'])) {
												$catatanpemberianobatdet = new CatatanpemberianobatdetT();
												$catatanpemberianobatdet->attributes = $v;
												$catatanpemberianobatdet->catatanpemberianobat_id = $catatanpemberianobat->catatanpemberianobat_id;
	
												$this->obatalkespasientersimpan &= $catatanpemberianobatdet->save();
											}
										}
									}
								}
							}
						}

						$query_lookup = CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'instalasipemberianobatrutin')), 'lookup_value', 'lookup_value');

						$isclosereseptur = ResepturT::model()->findByPk($reseptur_id);

						$found_key = array_search($isclosereseptur->ruanganreseptur->instalasi_id, $query_lookup);
						if (!$found_key) {
							$isclosereseptur->isclose = true;
							$isclosereseptur->petugasclose_id = Yii::app()->user->getState('pegawai_id');
							$isclosereseptur->waktu_close = date('Y-m-d H:i:s');
							$isclosereseptur->save();
						}
						/**
						 * END PROSES SIMPAN JADWAL PEMBERIAN OBAT
						 */

						 /** Simpan tindakan pelayanan dengan daftartindakan_id = 74, tarif_tindakan = penjualanresep_t.totalhargajual
						  * dan penjualanresep_id =  penjualanresep_t.penjualanresep_id */

						  $tindakantersimpan = true;
						// echo '<pre>';var_dump($this->obatalkespasientersimpan);die;
						if ($this->obatalkespasientersimpan) {

							$modTindakan = new TindakanpelayananT;
							$modTindakan->attributes = $modPendaftaran->attributes;
							$modTindakan->daftartindakan_id = 74;
							$modTindakan->penjualanresep_id = $modPenjualan->penjualanresep_id;
							$modTindakan->tarif_tindakan = $modPenjualan->totalhargajual;
							$modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
							$modTindakan->create_time = date('Y-m-d H:i:s');
							$modTindakan->create_loginpemakai_id = Yii::app()->user->id;
							$modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');

							$modTindakan->qty_tindakan = 1;
							$modTindakan->shift_id = Yii::app()->user->getState('shift_id');
							$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
							$modTindakan->discount_tindakan = 0;
							$modTindakan->subsidiasuransi_tindakan = 0;
							$modTindakan->subsidipemerintah_tindakan = 0;
							$modTindakan->subsisidirumahsakit_tindakan = 0;
							$modTindakan->iurbiaya_tindakan = 0;
							$modTindakan->tarif_rsakomodasi = 0;
							$modTindakan->tarif_medis = 0;
							$modTindakan->tarif_paramedis = 0;
							$modTindakan->tarif_bhp = 0;
							$modTindakan->tarifcyto_tindakan = 0;


							$modTindakan->satuantindakan = 'KALI'; 

							$md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

    						if(!empty($md_noawal)) {
    						  $noawal = intval($md_noawal->nopelayanan) + 1;
    						} else {
    						  $noawal = 1;
    						}
						
    						$modTindakan->nopelayanan = str_pad($noawal,3,"0",STR_PAD_LEFT);

							$tindakantersimpan = $modTindakan->save();

						}

						// var_dump($modPenjualan->attributes, $modTindakan->attributes); die;

						if ($tindakantersimpan) {
							$transaction->commit();
							$this->setAPIPenjualanResepOA($modPenjualan, $modDetails);
							// die;
							// cek apakah penjualan api berhasil apa tidak 
							$cekPenjualan = PenjualanresepT::model()->findByPk($modPenjualan->penjualanresep_id);
							if(!empty($cekPenjualan)) {
								Yii::app()->user->setFlash('success', "Data Berhasil disimpan !");
								$this->redirect(array('index', 'reseptur_id' => $reseptur_id, 'penjualanresep_id' => $modPenjualan->penjualanresep_id, 'sukses' => 1, 'frame' => $frame, 'kronis' => ($this->obatkronis == true) ? 1 : 0));
							} else {
								Yii::app()->user->setFlash('error', "Data gagal disimpan [4 Cek Log Api]!");
							}
						} else {
							$transaction->rollback();
							Yii::app()->user->setFlash('error', "Data gagal disimpan 3!");
						}
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', "Data gagal disimpan 1!");
					}
				} catch (Exception $e) {
					echo '<pre>'; var_dump($e); die;
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan 2! " . MyExceptionMessage::getMessage($e, true));
				}
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
					$transaction->rollback();
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
		$modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
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
	public function actionPrintEtiket($penjualanresep_id, $caraPrint = null, $racikan = null, $obatalkespasien_id = null, $pdf = null)
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
			$obatalkes_nama = '';
			foreach ($modObatAlkesPasien as $i => $data) {
				if(!empty($data->waktupemberian_ranap)) {
					$input = rtrim($data->waktupemberian_ranap, ",");
					$waktupemberian_ranap = explode(',', $input);
					$signa_oa = explode('x', $data->signa_oa);

					$frekuensi = '';
					$instruksi = '';
					$jam = '';
					if(isset($signa_oa[1])) {
						$frekuensi = trim($signa_oa[1]);
					}

					$etiket = $data->etiket;
					if($data->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
						$res = explode('-', $etiket);
						$instruksi = isset($res[2]) ? $res[2] : '';
					} else {
						$res = explode('-', $etiket);
						$jam = isset($res[2]) ? $res[2]: '';
						$obatalkes_nama .= $data->obatalkes->obatalkes_nama . ' ' .  $data->permintaan_dosis  . ' ' .$data->satuankekuatan_oa . ' / ';
					}
					// echo '<pre>';var_dump($jam);die;
					$page = count($waktupemberian_ranap);
					if( $page > 0 ) {
						for ($i=0; $i < $page; $i++) { 
							if($data->racikan_id == Params::RACIKAN_ID_NONRACIKAN) {
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['obatalkes_nama'] = $data->obatalkes->obatalkes_nama;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['permintaan_oa'] = $data->permintaan_oa;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['jumlahpermintaan_obatnonracikan'] = $data->jumlahpermintaan_obatnonracikan;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['satuankekuatan'] = $data->satuankekuatan;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['satuansediaan'] = $data->satuansediaan;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['kadaluarsa'] = $data->kadaluarsa;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['rke'] = $data->rke;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['etiket'] = $frekuensi . ' ' . $data->satuansediaan . ' ' . $waktupemberian_ranap[$i] .  ' ' . substr($instruksi, 0, 14) . ' ' . $jam;
	
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['obatalkes_id'] = $data->obatalkes_id;
								$dataObat[$data->obatalkespasien_id . '_' . $waktupemberian_ranap[$i]][$i]['racikan_id'] = $data->racikan_id;
							} else {
								
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['obatalkes_nama'] = $obatalkes_nama;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['permintaan_oa'] = $data->permintaan_oa;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['jumlahpermintaan_obatnonracikan'] = $data->jumlahpermintaan_obatnonracikan;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['satuankekuatan'] = $data->satuankekuatan;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['satuansediaan'] = $data->satuankekuatan_oa;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['kadaluarsa'] = $data->kadaluarsa;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['rke'] = $data->rke;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['etiket'] = $frekuensi . ' ' . $data->satuansediaan . ' ' . $waktupemberian_ranap[$i] .  ' ' . substr($instruksi, 0, 14) . ' ' . $jam;
	
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['obatalkes_id'] = $data->obatalkes_id;
								$dataObat[$data->rke . '_' . $waktupemberian_ranap[$i]][$i]['racikan_id'] = $data->racikan_id;
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
		$mpdf = new MyPDF60('', 'A4');
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->setHTMLFooter('<span></span>');
		$mpdf->AddPage('P', '', '', '', '', 0, 0, 0, 0, 0, 0);
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
		// echo '<pre>';var_dump($modPenjualan);die;
		$rke_max = ObatalkespasienT::model()->find("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke desc");
		$modResepturDet1 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke, obatalkespasien_id");

		$modResepturDet1 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke, obatalkespasien_id");

		if(empty($modPenjualan->reseptur_id)) {
			// jika penjualan dari triage

			$modResepturDet1 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." order by rke, obatalkespasien_id");
			$rke_max = ObatalkespasienT::model()->find("penjualanresep_id = " . $modPenjualan->penjualanresep_id."   order by rke desc");
			$rke_max->rke = 1;
		}

		$modResepturDet2 = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 2 order by rke, obatalkespasien_id asc");
		$modPendaftaran = $modPenjualan->pendaftaran;
		$modPasien = $modPenjualan->pasien;
		$modSep = $modPendaftaran->sepTs ?? null;
		$modAnamnesa = AnamnesaT::model()->findAll("pendaftaran_id = $modPendaftaran->pendaftaran_id and riwayatalergiobat is not null");
		$modFisik = PemeriksaanfisikT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id order by pemeriksaanfisik_id desc");

		$view = "PrintTelaah";



		$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
		$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
		$mpdf = new MyPDF60('', 'A4');
		$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
		ob_clean();
		$mpdf->WriteHTML($formatkonten, 1);
		ob_clean();
		$mpdf->mirrorMargins = 0;
		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->setHTMLFooter('<span></span>');
		$mpdf->AddPage($posisi, '', '', '', '', 3, 105, 0, 0, 0, 0);
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
