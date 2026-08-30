<?php

class PembatalanUangMukaController extends MyAuthController {

	protected $successSave = true;

	public function actionIndex() {

        Yii::import('application.modules.keuangan.models.KURekeningakuntansiV');
        Yii::import('application.modules.keuangan.models.KUPengeluaranumumT');
        Yii::import('application.modules.keuangan.models.KUJurnalrekeningT');
        Yii::import('application.modules.keuangan.models.KUJurnaldetailT');

		$frame = '';
		if (!empty($_GET['frame'])) {
//                $this->layout = 'iframe';
			$this->layout = '//layouts/iframe';
			$frame = '1';
		}

		$modBatal = new BKPembatalanUangmukaT;
		$modPendaftaran = new BKPendaftaranT;
		$modPasien = new BKPasienM;
        $modPengUmum = new KUPengeluaranumumT;
		$modBuktiKeluar = new BKTandabuktikeluarT;
		$modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = '- Otomatis -';
		$modBuktiKeluar->biayaadministrasi = 0;
		$pemakaianUangMuka = new BKPemakaianuangmukaT;
		$successSave = true;

        $modUangMuka = new BKBayaruangmukaT();

		$modPengUmum->volume = 1;
        $modPengUmum->kelompoktransaksi = Params::KELOMPOKTRANSAKSIPENGELUARAN_KAS;
		$jenispengeluanM = JenispengeluaranM::model()->findByAttributes(array('ispengembalianuangmuka'=>true));
        $modPengUmum->jenispengeluaran_id = (!empty($jenispengeluanM)? $jenispengeluanM->jenispengeluaran_id : null);
        // $modPengUmum->jenispengeluaran_id = Params::JENISPENGELUARAN_ID_PENGEMBALIANUANGMUKA;

        $modBuktiKeluar->carabayarkeluar = Params::CARAPEMBAYARAN_TUNAI;

        $modBatal->total_uangmuka = 0;

		$is_dialog = false;
		// pengecekan jika request dari iframe
		if (!empty($_GET['idBayarUangMuka']) && !isset($_POST['BKPembatalanUangmukaT'])) {
			$modUangMuka = BKBayaruangmukaT::model()->findByPk($_GET['idBayarUangMuka']);
			if (!empty($modUangMuka->pembatalanuangmuka_id)) {
				$modBatal = BKPembatalanUangmukaT::model()->findByPk($modUangMuka->pembatalanuangmuka_id);
			}
			$modPendaftaran = BKPendaftaranT::model()->findByPk($modUangMuka->pendaftaran_id);
			$modPasien = BKPasienM::model()->findByPk($modUangMuka->pasien_id);
			$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
			$modBuktiKeluar->untukpembayaran = 'Pembatalan Uang Muka - '.$modUangMuka->nouangmuka;
			$modBuktiKeluar->jmlkaskeluar = $modUangMuka->jumlahuangmuka;
			$modBuktiKeluar->namapenerima = $modPasien->nama_pasien;
			$modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;
			$modBatal->tandabuktibayar_id = $modUangMuka->tandabuktibayar_id;
            $modBatal->total_uangmuka = $modUangMuka->jumlahuangmuka;
			$cekPemakaianUangMuka = BKPemakaianuangmukaT::model()->findByPk($modUangMuka->pemakaianuangmuka_id);

			if ($cekPemakaianUangMuka) {
				$pemakaianUangMuka = $cekPemakaianUangMuka;
				$modBuktiKeluar->jmlkaskeluar = $pemakaianUangMuka->sisauangmuka;
				$modBuktiKeluar->untukpembayaran = 'Pengembalian Uang Muka';
				$modBatal->keterangan_batal = 'Kelebihan uang muka dipembayaran kasir';
			}
			$is_dialog = true;
		}

		if (isset($_POST['BKPembatalanUangmukaT']) && !empty($_POST['BKPendaftaranT']['pendaftaran_id'])) {
			$modPendaftaran = BKPendaftaranT::model()->findByPk($_POST['BKPendaftaranT']['pendaftaran_id']);
			$modPasien = BKPasienM::model()->findByPk($_POST['BKPendaftaranT']['pasien_id']);

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$cekUangMuka = BKBayaruangmukaT::model()->findByPk(
						$_POST['BKPembatalanUangmukaT']['bayaruangmuka_id']
				);

				$is_pengembalian = false;
				if (!empty($cekUangMuka)) {
					$modUangMuka = $cekUangMuka;
				}

				if (!empty($modUangMuka)) {
					$bayar = OrderbataluangmukaT::model()->findByAttributes(array(
						'bayaruangmuka_id'=>$modUangMuka->bayaruangmuka_id
					));
					if (!empty($bayar)) {
						$modUangMuka->orderbataluangmuka_id = $bayar->orderbataluangmuka_id;
						$modUangMuka->save(false, array('orderbataluangmuka_id'));
					}
				}

				// var_dump($modUangMuka->attributes); die;
					

                /*

				if ($is_pengembalian == true) {
					$format = new MyFormatter();
					$this->successSave = true;

                    if (empty($cekUangMuka->pemakaianuangmuka_id)) {
                        $modBatal = $this->savePembatalanUangMuka($_POST['BKPembatalanUangmukaT']);

                        $modBuktiKeluar = $this->saveTandaBuktiKeluar($modBatal, $_POST['BKTandabuktikeluarT']);
                        $modPengUmum = $this->savePengeluaranUmum($modPengUmum, $modBuktiKeluar, $_POST['KUPengeluaranumumT']);


                                                        //var_dump($modBuktiKeluar->save());die;
                        $this->updateBayarUangMuka($modBatal);
                        $this->updateTandaBuktiBayar($modBatal);
                        $this->updatePembatalan($modBatal->pembatalanuangmuka_id, $modBuktiKeluar);
                        // $this->successSave = true;
                    } else {
                        $pemakaianUangMuka = BKPemakaianuangmukaT::model()->findByPk(
                                $cekUangMuka->pemakaianuangmuka_id
                        );
                        $pemakaianUangMuka->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
                        if ($pemakaianUangMuka->save()) {
                            $modBatal = $this->savePembatalanUangMuka($_POST['BKPembatalanUangmukaT']);
                            $modBuktiKeluar = $this->saveTandaBuktiKeluar($modBatal, $_POST['BKTandabuktikeluarT']);
                            $modPengUmum = $this->savePengeluaranUmum($modPengUmum, $modBuktiKeluar, $_POST['KUPengeluaranumumT']);

                            $this->updateBayarUangMuka($modBatal);
                            $this->updateTandaBuktiBayar($modBatal);
                            $this->successSave = true;
                        } else {
                            $this->successSave = false;
                        }
                    }

                    if (isset($_POST['RekeningakuntansiV'])) {
                        // var_dump("Insert Jurnal...");
                        $modJurnalRekening = $this->saveJurnalRekening($modBatal, $modUangMuka, $modBuktiKeluar);
                        $this->successSave = $this->successSave && $this->saveJurnalDetail($modJurnalRekening, $_POST['RekeningakuntansiV']);
                    }
				} else {
                 *
                 */

					$this->successSave = true;

					$modBatal = $this->savePembatalanUangMuka($_POST['BKPembatalanUangmukaT']);
					$modBuktiKeluar = $this->saveTandaBuktiKeluar($modBatal, $_POST['BKTandabuktikeluarT']);
                    $modPengUmum = $this->savePengeluaranUmum($modPengUmum, $modBuktiKeluar, $_POST['KUPengeluaranumumT']);

					$this->updateBayarUangMuka($modBatal);
					$this->updateTandaBuktiBayar($modBatal);
                    if (isset($_POST['RekeningakuntansiV'])) {
                        // var_dump("Insert Jurnal...");
                        $modJurnalRekening = $this->saveJurnalRekening($modBatal, $modUangMuka, $modBuktiKeluar);
                        $this->successSave = $this->successSave && $this->saveJurnalDetail($modJurnalRekening, $_POST['RekeningakuntansiV']);
                    }

				// }

                // var_dump($modBuktiKeluar->attributes);
                // var_dump($modPengUmum->attributes);
                // var_dump($modJurnalRekening->attributes);

				$successSave = $this->successSave;
                // var_dump($successSave); die;
				if ($successSave) {
                                        //var_dump($modBatal->attributes);
                                        //var_dump($modBuktiKeluar->attributes);
                                        //die;
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$this->redirect(array('index','idBayarUangMuka'=>$modUangMuka->bayaruangmuka_id,'pembatalanuangmuka_id'=>$modBatal->pembatalanuangmuka_id,'sukses'=>'1','frame'=>$frame));
					$this->notifPembatalanUangMuka($successSave);
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}

			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}



		$this->render('index', array(
			'modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien,
			'modBuktiKeluar' => $modBuktiKeluar,
			'modBatal' => $modBatal,
			'successSave' => $successSave,
			'is_dialog' => $is_dialog,
            'modPengUmum' => $modPengUmum,
				)
		);
	}

	protected function notifPembatalanUangMuka($modBatal) {
		$judul = "Pembatalan Uang Muka";

		// $pas = PasienM::model()->findByPk(Yii::app()->user->getState('pasien_id'));
		// $pasien = (isset($pas) ? $pas->no_rekam_medik : "");

		$isi = "Tgl. Pembatalan : ".MyFormatter::formatDateTimeForUser($modBatal->tglpembatalan)."<br/>";
		// $isi .= "Nama Penerima : ".$modBatal->namapenerima."<br/>";
		$isi .= "Keterangan : ".$modBatal->keterangan_batal."<br/>";

        $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
        $kasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

        $cur = array(
            array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
            array('instalasi_id'=>$kasir->instalasi_id, 'ruangan_id'=>$kasir->ruangan_id, 'modul_id'=>$kasir->modul_id)
        );
        CustomFunction::broadcastNotif($judul, $isi, $cur);
    }

    public function actionPengembalian() {

        Yii::import('application.modules.keuangan.models.KURekeningakuntansiV');
        Yii::import('application.modules.keuangan.models.KUPengeluaranumumT');
        Yii::import('application.modules.keuangan.models.KUJurnalrekeningT');
        Yii::import('application.modules.keuangan.models.KUJurnaldetailT');

		$frame = '';
		if (!empty($_GET['frame'])) {
//                $this->layout = 'iframe';
			$this->layout = '//layouts/iframe';
			$frame = '1';
		}

		$modBatal = new BKPembatalanUangmukaT;
		$modPendaftaran = new BKPendaftaranT;
		$modPasien = new BKPasienM;
        $modPengUmum = new KUPengeluaranumumT;
		$modBuktiKeluar = new BKTandabuktikeluarT;
		$modBuktiKeluar->tahun = date('Y');
		$modBuktiKeluar->untukpembayaran = 'Pembatalan Uang Muka';
        $modBuktiKeluar->nokaskeluar = '- Otomatis -';
		$modBuktiKeluar->biayaadministrasi = 0;
		$pemakaianUangMuka = new BKPemakaianuangmukaT;
		$successSave = true;

        $modUangMuka = new BKBayaruangmukaT();

		$modPengUmum->volume = 1;
        $modPengUmum->kelompoktransaksi = Params::KELOMPOKTRANSAKSIPENGELUARAN_KAS;
        $jenispengeluanM = JenispengeluaranM::model()->findByAttributes(array('ispengembalianuangmuka'=>true));
        $modPengUmum->jenispengeluaran_id = (!empty($jenispengeluanM)? $jenispengeluanM->jenispengeluaran_id : null);
        $modBuktiKeluar->carabayarkeluar = Params::CARAPEMBAYARAN_TUNAI;

        $modBatal->total_uangmuka = 0;
        $modBatal->is_pengembalian = true;
        $modBatal->keterangan_batal = 'Kelebihan uang muka dipembayaran kasir';

		$is_dialog = false;


		// pengecekan jika request dari iframe
		if (!empty($_GET['idBayarUangMuka']) && !isset($_POST['BKPembatalanUangmukaT'])) {
			$modUangMuka = BKBayaruangmukaT::model()->findByPk($_GET['idBayarUangMuka']);
			if (!empty($modUangMuka->pembatalanuangmuka_id)) {
				$modBatal = BKPembatalanUangmukaT::model()->findByPk($modUangMuka->pembatalanuangmuka_id);
			}
			$modPendaftaran = BKPendaftaranT::model()->findByPk($modUangMuka->pendaftaran_id);
			$modPasien = BKPasienM::model()->findByPk($modUangMuka->pasien_id);

			$modBuktiKeluar->jmlkaskeluar = $modUangMuka->jumlahuangmuka - $modUangMuka->uangmukadipakai;
			$modBuktiKeluar->jmlkaskeluar = MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar,2);

			$modBuktiKeluar->namapenerima = $modPasien->nama_pasien;
			$modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;
			$modBatal->tandabuktibayar_id = $modUangMuka->tandabuktibayar_id;
            $modBatal->total_uangmuka = $modUangMuka->jumlahuangmuka;
			$modBatal->total_uangmuka = MyFormatter::formatNumberForPrint($modBatal->total_uangmuka,2);
			$cekPemakaianUangMuka = BKPemakaianuangmukaT::model()->findByPk($modUangMuka->pemakaianuangmuka_id);


			if ($cekPemakaianUangMuka) {
				$pemakaianUangMuka = $cekPemakaianUangMuka;
				$pemakaianUangMuka->pemakaianuangmuka = MyFormatter::formatNumberForPrint($pemakaianUangMuka->pemakaianuangmuka,2);
				$pemakaianUangMuka->sisauangmuka = MyFormatter::formatNumberForPrint($pemakaianUangMuka->sisauangmuka,2);
				$modBuktiKeluar->untukpembayaran = 'Pengembalian Uang Muka Pasien';
			}
			$is_dialog = false;
		}

		if (isset($_POST['BKPembatalanUangmukaT']) && !empty($_POST['BKPendaftaranT']['pendaftaran_id'])) {
			$modPendaftaran = BKPendaftaranT::model()->findByPk($_POST['BKPendaftaranT']['pendaftaran_id']);
			$modPasien = BKPasienM::model()->findByPk($_POST['BKPendaftaranT']['pasien_id']);

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$cekUangMuka = BKBayaruangmukaT::model()->findByPk(
						$_POST['BKPembatalanUangmukaT']['bayaruangmuka_id']
				);

                if (!empty($cekUangMuka)) {
					$modUangMuka = $cekUangMuka;
				}

                $this->successSave = true;

                $modBatal = $this->savePembatalanUangMuka($_POST['BKPembatalanUangmukaT'], true);
                $modBuktiKeluar = $this->saveTandaBuktiKeluar($modBatal, $_POST['BKTandabuktikeluarT']);
                $modPengUmum = $this->savePengeluaranUmum($modPengUmum, $modBuktiKeluar, $_POST['KUPengeluaranumumT']);

                $this->updateBayarUangMuka($modBatal);
                $this->updateTandaBuktiBayar($modBatal);
                if (isset($_POST['RekeningakuntansiV'])) {
                    $modJurnalRekening = $this->saveJurnalRekening($modBatal, $modUangMuka, $modBuktiKeluar, true);
                    $this->successSave = $this->successSave && $this->saveJurnalDetail($modJurnalRekening, $_POST['RekeningakuntansiV']);
                }

				$successSave = $this->successSave;
				if ($successSave) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$this->redirect(array('Pengembalian','idBayarUangMuka'=>$modUangMuka->bayaruangmuka_id,'pembatalanuangmuka_id'=>$modBatal->pembatalanuangmuka_id,'sukses'=>'1','frame'=>$frame));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render('pengembalian', array(
			'modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien,
			'modBuktiKeluar' => $modBuktiKeluar,
			'modBatal' => $modBatal,
			'successSave' => $successSave,
			'is_dialog' => $is_dialog,
            'modPengUmum' => $modPengUmum,
			'pemakaianUangMuka'=>$pemakaianUangMuka
				)
		);
	}


	protected function savePembatalanUangMuka($postPembatalan, $is_kembali = false) {
		$modBatal = new BKPembatalanUangmukaT;
		$modBatal->attributes = $postPembatalan;
		$modBatal->tglpembatalan = MyFormatter::formatDateTimeForDb($postPembatalan['tglpembatalan']);
		$modBatal->ruangan_id = Yii::app()->user->ruangan_id;
		$modBatal->create_ruangan = Yii::app()->user->ruangan_id;
		$modBatal->create_time = date('Y-m-d H:i:s');
        if ($is_kembali) {
            $modBatal->keterangan_batal = 'Kelebihan uang muka dipembayaran kasir';
            $modBatal->is_pengembalian = true;
        }
		if ($modBatal->validate()) {
			$modBatal->save();
			$this->successSave = $this->successSave && true;
			$this->notifPembatalanUangMuka($modBatal);
		} else {
			$this->successSave = false;
		}

		return $modBatal;
	}


    protected function savePengeluaranUmum($modPengUmum, $modBuktiKeluar, $post) {
        $ok = true;

        $modPengUmum->attributes = $post;
        $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
        $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
        $modPengUmum->tglpengeluaran = $modBuktiKeluar->tglkaskeluar;
        $modPengUmum->hargasatuan = $modPengUmum->totalharga = $modBuktiKeluar->jmlkaskeluar;
        $modPengUmum->keterangankeluar = $modBuktiKeluar->keterangan_pengeluaran;
        $modPengUmum->biayaadministrasi = 0;
        $modPengUmum->satuanvol = 'KALI';
        

        if ($modPengUmum->validate()) {
            $ok = $ok && $modPengUmum->save();
            $modBuktiKeluar->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
            $ok = $ok && $modBuktiKeluar->save();
        } else $ok = false;

        $this->successSave = $ok;

        return $modPengUmum;
    }

	protected function saveTandaBuktiKeluar($modPembatalan, $postBuktiKeluar) {
		$modBuktiKeluar = new BKTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
		$modBuktiKeluar->tglkaskeluar = MyFormatter::formatDateTimeForDb($postBuktiKeluar['tglkaskeluar']);
		$modBuktiKeluar->keterangan_pengeluaran = $modPembatalan->keterangan_batal;
		$modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->pembatalanuangmuka_id = $modPembatalan->pembatalanuangmuka_id;
		// $modBuktiKeluar->jmlkaskeluar = str_replace(',', '', $_POST['BKTandabuktikeluarT']['jmlkaskeluar']);
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');

		if ($modBuktiKeluar->validate()) {
			$modBuktiKeluar->save();
			$this->updatePembatalan($modPembatalan->pembatalanuangmuka_id, $modBuktiKeluar);
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}


		return $modBuktiKeluar;
	}



    protected function saveJurnalRekening($modBatal, $modUangMuka, $modBukti, $is_kembali = false) {

        // var_dump($modUangMuka->attributes); die;

        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }

		$modJurnalRekening = new KUJurnalrekeningT;
		$modJurnalRekening->tglbuktijurnal = $modBukti->tglkaskeluar;
		$modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
		$modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modBukti->tglkaskeluar, 'JKK');
		$modJurnalRekening->noreferensi = $modBukti->nokaskeluar;
		$modJurnalRekening->tglreferensi = $modBukti->tglkaskeluar;
        if ($is_kembali) {
            $modJurnalRekening->urianjurnal = "Pengembalian Uang Muka - ".$modUangMuka->nouangmuka;
        } else {
            $modJurnalRekening->urianjurnal = "Pembatalan Uang Muka - ".$modUangMuka->nouangmuka;
        }
		$modJurnalRekening->nobku = "";
        $modJurnalRekening->pembatalanuangmuka_id = $modBatal->pembatalanuangmuka_id;


		/*
		  $attributes = array(
		  'jenisjurnal_aktif' => true
		  );
		  $jenisjurnal_id = JenisjurnalM::model()->findByAttributes($attributes);
		  $modJurnalRekening->jenisjurnal_id = $jenisjurnal_id->jenisjurnal_id;
		 *
		 */

		$modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
		$periodeID = $period;
		$modJurnalRekening->rekperiod_id = $periodeID;
		$modJurnalRekening->create_time = date('Y-m-d H:i:s');
		$modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
		$modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

		if ($modJurnalRekening->validate()) {
			$modJurnalRekening->save();
			// $this->succesSave = true;
		} else {
			// $this->succesSave = false;

            if (empty($modJurnalRekening->rekperiod_id)) {
                throw new CDbException("Periode Akuntansi Belum di-set");
            } else {
                throw new CDbException($modJurnalRekening->getErrors());
            }
		}
        //var_dump($modJurnalRekening->attributes, $modBukti->attributes, $modPetty->attributes); die;
		return $modJurnalRekening;
	}


    protected function saveJurnalDetail($modJurnalRekening, $rekeningakuntansi) {
		$valid = true;
		foreach($rekeningakuntansi as $i=>$data){

			$model = new KUJurnaldetailT();
			// $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
			$model->rekperiod_id = $modJurnalRekening->rekperiod_id;
			$model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
			$model->uraiantransaksi = $modJurnalRekening->urianjurnal; //isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
			$model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit']:0;
			$model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit']:0;
			$model->nourut = $i+1;
			$model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;

			$model->catatan = "";
			if($model->validate())
			{
				$model->save();

                // var_dump($data, $model->attributes);
			}else{
				throw new CDbException($model->getErrors());
				$valid = false;
				break;
			}
		}

        return $valid;

		// $this->succesSave = $valid;
	}


	protected function updateTandaBuktiBayar($modPembatalan) {
		TandabuktibayarT::model()->updateByPk(
				$modPembatalan->tandabuktibayar_id, array(
			'pembatalanuangmuka_id' => $modPembatalan->pembatalanuangmuka_id
				)
		);
	}

	protected function updateBayarUangMuka($modPembatalan) {
		BKBayaruangmukaT::model()->updateByPk(
				$modPembatalan->bayaruangmuka_id, array(
			'pembatalanuangmuka_id' => $modPembatalan->pembatalanuangmuka_id
				)
		);
	}

	protected function updatePembatalan($idPembatalan, $modBuktiKeluar) {
		BKPembatalanUangmukaT::model()->updateByPk(
				$idPembatalan, array(
			'tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id
				)
		);
	}

	public function actionDaftarPasienBatalUangMuka($nama = false) {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->with = array('pasien', 'pendaftaran', 'ruangan');
                        $pencarian = isset($_GET['cari'])?$_GET['cari']:null;
                        //var_dump($nama);
			if ($pencarian == 'nama') {
				$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($_GET['term']), true);
			} elseif ($pencarian == 'norekammedik') {
				$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($_GET['term']), true);
			}
			$criteria->addCondition('pembatalanuangmuka_id IS NULL');
			$criteria->order = 'tgluangmuka DESC';
			$models = BayaruangmukaT::model()->findAll($criteria);

			$returnVal = array();

            loop_ac:
			foreach ($models as $i => $model) {

                $bayar = PembayaranpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id' => $model->pendaftaran_id
                ));

                if (!empty($bayar)) continue;

                $pakai = PemakaianuangmukaT::model()->findAllByAttributes(array(
                    'bayaruangmuka_id'=>$model->bayaruangmuka_id
                ));
                $is_tandabukti = false;

                $totalpakai = 0;
                foreach ($pakai as $item) {

                    $totalpakai += $item->pemakaianuangmuka;


                }

                if ($model->jumlahuangmuka == $totalpakai) continue;
                if ($is_tandabukti) continue;


				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				if ($pencarian == 'nama') {
					$returnVal[$i]['label'] = $model->pasien->nama_pasien . ' - ' . $model->ruangan->ruangan_nama . ' - ' . MyFormatter::formatDateTimeForUser($model->tgluangmuka);
					$returnVal[$i]['value'] = $model->pasien->nama_pasien;
					$returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
				} else {
					$returnVal[$i]['label'] = $model->pasien->no_rekam_medik . ' - ' . $model->ruangan->ruangan_nama . ' - ' . MyFormatter::formatDateTimeForUser($model->tgluangmuka);
					$returnVal[$i]['value'] = $model->pasien->no_rekam_medik;
				}
				$returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
				$returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
				$returnVal[$i]['namabin'] = $model->pasien->nama_bin;
				$returnVal[$i]['alamatpasien'] = $model->pasien->alamat_pasien;
				$returnVal[$i]['jeniskasuspenyakit'] = $model->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
				$returnVal[$i]['namainstalasi'] = $model->pendaftaran->instalasi->instalasi_nama;
				$returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
				$returnVal[$i]['tglpendaftaran'] = MyFormatter::formatDateTimeForUser($model->pendaftaran->tgl_pendaftaran);
				$returnVal[$i]['nopendaftaran'] = $model->pendaftaran->no_pendaftaran;
				$returnVal[$i]['umur'] = $model->pendaftaran->umur;
				$returnVal[$i]['tandabuktibayar_id'] = $model->tandabuktibayar_id;
				$returnVal[$i]['bayaruangmuka_id'] = $model->bayaruangmuka_id;
				$returnVal[$i]['carabayar_nama'] = $model->pendaftaran->carabayar->carabayar_nama;
				$returnVal[$i]['penjamin_nama'] = $model->pendaftaran->penjamin->penjamin_nama;
				$returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
                $returnVal[$i]['total_uangmuka'] = $model->jumlahuangmuka;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionGetRekeningPembatalan() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$carabayar = isset($_POST['carabayarkeluar']) ? $_POST['carabayarkeluar'] : null;
			$bankid = isset($_POST['bankid']) ? $_POST['bankid'] : null;
		  $model = array();
			$detmodel = array(
					'D'=>array(),
					'K'=>array(),
			);


			$rekeningColumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_PEMBATALANUANGMUKAT,'column_name'=>Params::REKENINGCOLUMN_COLUMN_PEMBATALANUANGMUKAID, 'debitkredit'=>'D'));

			if(isset($rekeningColumn) && !empty($rekeningColumn)){
				$rekD = Rekening5M::model()->findByAttributes(array('rekening5_id'=>$rekeningColumn->rekening5_id));

				if(isset($rekD) && !empty($rekD)){
					$rekD->rek_column = $rekeningColumn;
					$detmodel[$rekeningColumn->debitkredit][] = $rekD;
				}
			}

			if(!empty($bankid)){
					 $modRekCarabayar = BankrekM::model()->findByAttributes(array('bank_id'=>$bankid,'debitkredit'=>'K'));
			 }else{
				if (!empty($carabayar)) {
						$modRekCarabayar = CarabayarkeluarrekM::model()->findByAttributes(array('carabayarkeluar'=>$carabayar,'debitkredit'=>'K'));
				}
			 }

			 if(isset($modRekCarabayar) && !empty($modRekCarabayar)){
				 $rekK = Rekening5M::model()->findByAttributes(array('rekening5_id'=>$modRekCarabayar->rekening5_id));

				 if(isset($rekK) && !empty($rekK)){
					 $rekK->rek_column = $modRekCarabayar;
					 $detmodel[$modRekCarabayar->debitkredit][] = $rekK;
				 }
			 }
        $model = array_merge($detmodel['D'], $detmodel['K']);
			 
			if ($model) {
				echo CJSON::encode(
						$this->renderPartial('__formKodeRekening', array('model' => $model, 'dariDialog'=>true), true)
				);
			}
			Yii::app()->end();
		}
	}

	public function actionPrintPembatalan($id) {
		$model = PembatalanuangmukaT::model()->findByPk($id);
		$modUangMuka = BayaruangmukaT::model()->findByPk($model->bayaruangmuka_id);
		$modBuktiKeluar = TandabuktikeluarT::model()->findByPk($model->tandabuktikeluar_id);
		$pemakaianUangMuka = BKPemakaianuangmukaT::model()->findByPk($modUangMuka->pemakaianuangmuka_id);

		$this->layout = '//layouts/printWindows';
		$this->render('printPembatalan', array(
			'model' => $model,
			'modBuktiKeluar' => $modBuktiKeluar,
			'modUangMuka' => $modUangMuka,
			'pemakaianUangMuka'=>$pemakaianUangMuka

		));
	}

}
