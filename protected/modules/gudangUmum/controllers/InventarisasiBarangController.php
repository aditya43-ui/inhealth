
<?php

class InventarisasiBarangController extends MyAuthController {

	public $path_view = 'gudangUmum.views.inventarisasiBarang.';
	public $inventarisasibarangtersimpan = false;
	public $inventarisasiruangantersimpan = true;
	public $inventarisasidetailtersimpan = true;
	public $updateformulirinventarisasitersimpan = true;

	public function actionIndex($formulirinvbarang_id = null, $invbarang_id = null) {
		$format = new MyFormatter();
		$modBarang = new GUInfoinventarisasiruanganV('searchBarangInventarisasi');
		$model = new GUInvbarangT();
		$modDetail = array();
		$modFormulir = new GUFormulirinvbarangR;
		$modDetailFormulir = array();
		$modInventarisasiRuangan = new GUInventarisasiruanganT();

		if (!empty($formulirinvbarang_id)) {
			$modFormulir = GUFormulirinvbarangR::model()->find('formulirinvbarang_id =' . $formulirinvbarang_id . ' and invbarang_id is null');
			if (!empty($modFormulir)) {
				$model->formulirinvbarang_id = $modFormulir->formulirinvbarang_id;
				$modDetailFormulir = GUForminvbarangdetR::model()->findAll('formulirinvbarang_id = ' . $modFormulir->formulirinvbarang_id . ' and invbarangdet_id is null');
			}
		}

		$model->invbarang_tgl = date('Y-m-d H:i:s');
		// $model->invbarang_jenis = Params::DEFAULT_JENISINVENTARISASI;
		$model->invbarang_no = "- Otomatis -";
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$model->petugas1_id = Yii::app()->user->getState('pegawai_id');
		$model->petugas1_nama = Yii::app()->user->getState('nama_pegawai');

		if (!empty($_GET['invbarang_id'])) {
			$model = GUInvbarangT::model()->findByPk($_GET['invbarang_id']);
			if ($model) {
				$modBarangDet = GUInvbarangdetT::model()->findByAttributes(array('invbarang_id' => $model->invbarang_id));
				if($modBarangDet){
					$modDetail = GUInfoinventarisasiruanganV::model()->findByAttributes(array('inventarisasi_id' => $modBarangDet->inventarisasi_id));
				}
				$model->mengetahui_nama = (isset($model->mengetahui) ? $model->mengetahui->NamaLengkap : "");
				$model->petugas2_nama = (isset($model->petugas2) ? $model->petugas2->NamaLengkap : "");
				$model->petugas1_nama = (isset($model->petugas1) ? $model->petugas1->NamaLengkap : "");
				$model->invbarang_totalharga = $format->formatNumberForUser($model->invbarang_totalharga);
				$model->invbarang_totalnetto = $format->formatNumberForUser($model->invbarang_totalnetto);
			}
		}

		if (isset($_POST['GUInvbarangT'])) {
     
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['GUInvbarangT'];
				if ($model->invbarang_jenis == "Penyesuaian") {
					if (isset($_POST['GUInvbarangdetT'])) {
						if (count((array)$_POST['GUInvbarangdetT']) > 0) {
							$model->invbarang_no = MyGenerator::noInventarisasiBarang();
							$model->invbarang_tgl = $format->formatDateTimeForDb($_POST['GUInvbarangT']['invbarang_tgl']);
							$model->create_time = date('Y-m-d H:i:s');
							$model->create_loginpemakai_id = Yii::app()->user->id;
							$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
							$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
							if ($model->save()) {
								if (isset($_POST['GUInvbarangdetT'])) {
									if (count((array)$_POST['GUInvbarangdetT']) > 0) {
										foreach ($_POST['GUInvbarangdetT'] AS $i => $detail) {
											if (isset($detail['cekList'])) {
												$modInventarisasiRuangan = GUInventarisasiruanganT::model()->findByAttributes(array('inventarisasi_id' => $detail['inventarisasi_id']));
												$modelDetail[$i] = $this->simpanInventarisasiDetailPenyesuaian($model, $detail, $modInventarisasiRuangan);
                                                if (!empty($model->formulirinvbarang_id)) {
													$modFormulir = GUFormulirinvbarangR::model()->updateByPk($model->formulirinvbarang_id, array('invbarang_id' => $model->invbarang_id));
													$modDetailFormulir = GUForminvbarangdetR::model()->find('formulirinvbarang_id = ' . $model->formulirinvbarang_id . ' and barang_id = ' . $modelDetail[$i]->barang_id)->formulirinvbarang_id;
													$this->updateFormsInventarisasi($model, $modelDetail[$i]);
												}
                                                $modInventarisasiRuangan = GUInventarisasiruanganT::model()->findByAttributes(array('inventarisasi_id' => $detail['inventarisasi_id']));

                                                    $mod_in = new GUInventarisasiruanganT();
                                                    $mod_in->attributes = $modInventarisasiRuangan->attributes;
                                                    $mod_in->inventarisasi_keadaan = $modelDetail[$i]->kondisi_barang;

                                                    InventarisasiruanganT::unsetIDStok($mod_in);

                                                     $qtyStokIn = 0;
                                                    $qtyStokOut = 0;
                                                    $qtyStokCurrent = 0;

                                                    if($mod_in->inventarisasi_keadaan == 'Baik'){
														$qtyStokIn = $modelDetail[$i]->selisih_sistem;
                                                        $qtyStokOut = $modelDetail[$i]->selisih_fisik;
                                                        $qtyStokCurrent = ($qtyStokIn - $qtyStokOut);
                                                    }
                                                    else if($mod_in->inventarisasi_keadaan == 'Dalam Perbaikan'){
                                                        $qtyStokIn = 0;
                                                        $qtyStokOut = $modelDetail[$i]->volume_fisik;
                                                        $qtyStokCurrent = ($qtyStokIn - $qtyStokOut);
                                                    }
                                                    else if($mod_in->inventarisasi_keadaan == 'Rusak'){
                                                        $qtyStokIn = 0;
                                                        $qtyStokOut = $modelDetail[$i]->volume_fisik;
                                                        $qtyStokCurrent = ($qtyStokIn - $qtyStokOut);
                                                    }

                                                    $mod_in->inventarisasiruanganasal_id = $modInventarisasiRuangan->inventarisasi_id;
                                                    $mod_in->invbarangdet_id = $modelDetail[$i]->invbarangdet_id;
                                                    $mod_in->inventarisasi_qty_in = $qtyStokIn;
                                                    $mod_in->inventarisasi_qty_out = $qtyStokOut;
                                                    $mod_in->inventarisasi_qty_skrg = $qtyStokCurrent;
                                                    $mod_in->tgltransaksi = $model->invbarang_tgl;
                                                    $mod_in->inventarisasi_kode = MyGenerator::kodePenyesuaianPersediaan();


                                                    if ($mod_in->validate() || $mod_in->validate()) {
                                                        $this->inventarisasiruangantersimpan = $this->inventarisasiruangantersimpan && $mod_in->save();
                                                    } else $this->inventarisasiruangantersimpan = false;

											}
										}
									}
								}
								$this->inventarisasibarangtersimpan = true;
							} else {
								$this->inventarisasibarangtersimpan = false;
							}
						}
					}
				} else {
					$model->invbarang_no = MyGenerator::noInventarisasiBarang();
					$model->invbarang_tgl = $format->formatDateTimeForDb($_POST['GUInvbarangT']['invbarang_tgl']);
					$model->create_time = date('Y-m-d H:i:s');
					$model->create_loginpemakai_id = Yii::app()->user->id;
					$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
					$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
					if ($model->save()) {
						if (isset($_POST['GUInvbarangdetT'])) {
							if (count((array)$_POST['GUInvbarangdetT']) > 0) {
								foreach ($_POST['GUInvbarangdetT'] AS $i => $detail) {
									if (isset($detail['cekList'])) {
										$modelDetail[$i] = $this->simpanInventarisasiDetail($model, $detail);

										if (!empty($model->formulirinvbarang_id)) {
											$modFormulir = GUFormulirinvbarangR::model()->updateByPk($model->formulirinvbarang_id, array('invbarang_id' => $model->invbarang_id));
											$modDetailFormulir = GUForminvbarangdetR::model()->find('formulirinvbarang_id = ' . $model->formulirinvbarang_id . ' and barang_id = ' . $modelDetail[$i]->barang_id)->formulirinvbarang_id;
											$this->updateFormsInventarisasi($model, $modelDetail[$i]);
										}
									}
								}
							}
						}
						$this->inventarisasibarangtersimpan = true;
					} else {
						$this->inventarisasibarangtersimpan = false;
					}
				}
                // die;

          if (Yii::app()->user->getState('isjurnalotomatis') && !empty($model->invbarang_id)) {
              $res = Yii::app()->db
                  ->createCommand("select set_afterstokopnameumum_fix(".$model->invbarang_id.") as simpan")
                  ->queryRow();

              if (!empty($res)) {
                  $this->inventarisasibarangtersimpan = $this->inventarisasibarangtersimpan && $res['simpan'];
              }
          }

        
				if ($this->inventarisasibarangtersimpan && $this->inventarisasidetailtersimpan && $this->inventarisasiruangantersimpan) {
         
					$transaction->commit();
					$model->isNewRecord = FALSE;
					$this->redirect(array('index', 'invbarang_id' => $model->invbarang_id, 'sukses' => 1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data Inventarisasi Barang gagal disimpan !");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data Inventarisasi Barang gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
			}
		}



		if (isset($_GET['GUInfoinventarisasiruanganV'])) {
			$modBarang->unsetAttributes();
			$modBarang->attributes = $_GET['GUInfoinventarisasiruanganV'];
			$modBarang->jenisbarang_id = $_GET['GUInfoinventarisasiruanganV']['jenisbarang_id'];
			$modBarang->inventarisasi_kode = $_GET['GUInfoinventarisasiruanganV']['barang_type'];
			$modBarang->invbarang_jenis = $_GET['GUInfoinventarisasiruanganV']['invbarang_jenis'];
			//$modBarang->inventarisasi_kode = $_GET['GUInfoinventarisasiruanganV']['inventarisasi_kode'];
            /*
                        $modBarang->golongan_id = $_GET['GUInfoinventarisasiruanganV']['golongan_id'];
                        $modBarang->bidang_id = $_GET['GUInfoinventarisasiruanganV']['bidang_id'];
                        $modBarang->kelompok_id = $_GET['GUInfoinventarisasiruanganV']['kelompok_id'];
                        $modBarang->subkelompok_id = $_GET['GUInfoinventarisasiruanganV']['subkelompok_id'];
                        $modBarang->subsubkelompok_id = $_GET['GUInfoinventarisasiruanganV']['subsubkelompok_id'];
             *
             */
		}

		$this->render($this->path_view . 'index', array(
			'format' => $format,
			'modBarang' => $modBarang,
			'model' => $model,
			'modDetail' => $modDetail,
			'modFormulir' => $modFormulir,
			'modDetailFormulir' => $modDetailFormulir,
		));
	}

	/**
	 * simpan GUInvbarangdetT
	 * @param type $model
	 * @param type $detail
	 * @return \GUInvbarangdetT
	 */
	public function simpanInventarisasiDetail($model, $detail) {
		$format = new MyFormatter();
		$modBarang = GUBarangM::model()->findByPk($detail['barang_id']);
		$modInventarisasiDetail = new GUInvbarangdetT;
		$modInventarisasiDetail->attributes = $detail;
		$modInventarisasiDetail->invbarang_id = $model->invbarang_id;
		$modInventarisasiDetail->barang_id = $detail['barang_id'];
		$modInventarisasiDetail->volume_fisik = $detail['inventarisasi_qty_fisik'];
		$modInventarisasiDetail->harga_satuan = $detail['inventarisasi_hargasatuan'];
		$modInventarisasiDetail->jumlah_harga = ($modInventarisasiDetail->harga_satuan * $modInventarisasiDetail->volume_fisik);
		$modInventarisasiDetail->harga_netto = $detail['inventarisasi_hargasatuan'];
		$modInventarisasiDetail->jumlah_netto = ($modInventarisasiDetail->harga_netto * $modInventarisasiDetail->volume_fisik);
		$modInventarisasiDetail->kondisi_barang = $detail['kondisi_barang'];
		// $modInventarisasiDetail->barang_satuan = isset($modBarang->barang_satuan) ? $modBarang->barang_satuan : "";
		$modInventarisasiDetail->tglperiksafisik = $format->formatDateTimeForDb($detail['tglperiksafisik']);
		$modInventarisasiDetail->volume_sistem = 0;
		$modInventarisasiDetail->selisih_sistem = $modInventarisasiDetail->volume_fisik - $modInventarisasiDetail->volume_sistem;
		$modInventarisasiDetail->selisih_fisik = 0;
		$modInventarisasiDetail->ket_inv = empty($detail['ket_inv']) ? null : $detail['ket_inv'];
		if ($modInventarisasiDetail->validate()) {
			$modInventarisasiDetail->save();
			$this->simpanInventarisasiRuangan($modInventarisasiDetail);
			$this->inventarisasidetailtersimpan &= true;
		} else {
			$this->inventarisasidetailtersimpan &= false;
		}
		return $modInventarisasiDetail;
	}

	public function simpanInventarisasiDetailPenyesuaian($model, $detail, $modInventarisasiRuangan) {
		$format = new MyFormatter();
		$modBarang = GUBarangM::model()->findByPk($detail['barang_id']);


		$modInventarisasiDetail = new GUInvbarangdetT;
		$modInventarisasiDetail->attributes = $detail;
		$modInventarisasiDetail->invbarang_id = $model->invbarang_id;
		$modInventarisasiDetail->barang_id = $detail['barang_id'];
		$modInventarisasiDetail->volume_fisik = $detail['inventarisasi_qty_fisik'];
		$modInventarisasiDetail->harga_satuan = $detail['inventarisasi_hargasatuan'];
		$modInventarisasiDetail->jumlah_harga = ($modInventarisasiDetail->harga_satuan * $modInventarisasiDetail->volume_fisik);
		$modInventarisasiDetail->harga_netto = $detail['inventarisasi_hargasatuan'];
		$modInventarisasiDetail->jumlah_netto = ($modInventarisasiDetail->harga_netto * $modInventarisasiDetail->volume_fisik);
		$modInventarisasiDetail->kondisi_barang = $detail['kondisi_barang'];
		// $modInventarisasiDetail->barang_satuan = isset($modBarang->barang_satuan) ? $modBarang->barang_satuan : "";
		$modInventarisasiDetail->inventarisasi_id = $modInventarisasiRuangan->inventarisasi_id;
		$modInventarisasiDetail->tglperiksafisik = $format->formatDateTimeForDb($detail['tglperiksafisik']);
                $va = 0;
$modInventarisasiDetail->volume_sistem = $detail['inventarisasi_qty_skrg'];
                // if($detail['kondisi_barang'] == 'Baik'){
                //      if ($detail['inventarisasi_qty_skrg'] < $detail['inventarisasi_qty_fisik']) {
                //     $modInventarisasiDetail->volume_sistem = ($detail['inventarisasi_qty_fisik'] - $detail['inventarisasi_qty_skrg']);
                //     } else {
                //         $modInventarisasiDetail->volume_sistem = ($detail['inventarisasi_qty_skrg'] + $detail['inventarisasi_qty_fisik']);
                //     }
                // }else{
                //     $modInventarisasiDetail->volume_sistem = ($detail['inventarisasi_qty_skrg'] - $detail['inventarisasi_qty_fisik']);
                // }



//		$modInventarisasiDetail->volume_sistem = ($detail['inventarisasi_qty_skrg'] - $detail['inventarisasi_qty_fisik']);
		$modInventarisasiDetail->ket_inv = empty($detail['ket_inv']) ? null : $detail['ket_inv'];

                if ($modInventarisasiDetail->volume_sistem < $modInventarisasiDetail->volume_fisik) {
									// $modInventarisasiDetail->selisih_fisik = $modInventarisasiDetail->volume_sistem - $modInventarisasiDetail->volume_fisik;
									// $modInventarisasiDetail->selisih_sistem = 0;
                    $modInventarisasiDetail->selisih_sistem = $modInventarisasiDetail->volume_fisik - $modInventarisasiDetail->volume_sistem;
                    $modInventarisasiDetail->selisih_fisik = 0;
                } else {
                    $modInventarisasiDetail->selisih_fisik = $modInventarisasiDetail->volume_sistem - $modInventarisasiDetail->volume_fisik;
                    $modInventarisasiDetail->selisih_sistem = 0;

										// $modInventarisasiDetail->selisih_sistem = $modInventarisasiDetail->volume_fisik - $modInventarisasiDetail->volume_sistem;
                    // $modInventarisasiDetail->selisih_fisik = 0;
                }

                /*

                $modInventarisasiDetail->selisih_sistem = $modInventarisasiDetail->volume_fisik - $modInventarisasiDetail->volume_sistem;
		$modInventarisasiDetail->selisih_fisik = $modInventarisasiDetail->getJmlSelisihStok($modInventarisasiRuangan->inventarisasi_id);

                */
                // var_dump($modInventarisasiDetail->attributes, $modInventarisasiDetail->validate(), $modInventarisasiDetail->errors); die;

        // var_dump($modInventarisasiDetail->attributes); die;
		if ($modInventarisasiDetail->validate()) {
			$modInventarisasiDetail->save();
//			if ($modInventarisasiRuangan->invbarangdet_id != $modInventarisasiDetail->invbarangdet_id) GUInventarisasiruanganT::model()->updateByPk($modInventarisasiRuangan->inventarisasi_id, array('invbarangdet_id' => $modInventarisasiDetail->invbarangdet_id));
			$this->inventarisasidetailtersimpan &= true;
		} else {
			$this->inventarisasidetailtersimpan &= false;
		}
		return $modInventarisasiDetail;
	}

	public function updateFormsInventarisasi($model, $modInventarisasiDet) {
		$format = new MyFormatter();
		$modFormulir = GUFormulirinvbarangR::model()->findByAttributes(array('invbarang_id' => $model->invbarang_id));
		$modDetailFormulir = GUForminvbarangdetR::model()->find('formulirinvbarang_id = ' . $modFormulir->formulirinvbarang_id . ' and barang_id = ' . $modInventarisasiDet->barang_id . '');

		$modDetailFormulir->invbarangdet_id = $modInventarisasiDet->invbarangdet_id;

		if ($modDetailFormulir->validate()) {
			$modDetailFormulir->save();
			GUInvbarangdetT::model()->updateByPk($modInventarisasiDet->invbarangdet_id, array('forminvbarangdet_id' => $modDetailFormulir->forminvbarangdet_id));
		} else {
			$this->updateformulirinventaristersimpan &= false;
		}
		return $modDetailFormulir;
	}

	public function simpanStokObatAlkes($modDetailOpname, $selisih) {

		$format = new MyFormatter;
		$modStok = new GFStokObatAlkesT;

		$loadObatAlkes = GFObatAlkesM::model()->findByPk($modDetailOpname->obatalkes_id);
		$modStok->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modStok->tglkadaluarsa = !empty($modDetailOpname->tglkadaluarsa) ? $format->formatDateTimeForDb($modDetailOpname->tglkadaluarsa) : null;
		$modStok->obatalkes_id = $modDetailOpname->obatalkes_id;
		$modStok->nobatch = "";
		$modStok->stokopnamedet_id = $modDetailOpname->stokopnamedet_id;
		$modStok->tglterima = date('Y-m-d H:i:s');
		$modStok->tglstok_in = date("Y-m-d H:i:s");
		$modStok->tglstok_out = NULL;
		if (!empty($modDetailOpname->satuanbesar_id)) {
			$modStok->qtystok_in = $selisih;
			$modStok->harganetto = ($modDetailOpname->harganetto / $modStok->qtystok_in);
			$modStok->jmlmargin = ($modDetailOpname->hargasatuan - $modDetailOpname->harganetto) / $modStok->qtystok_in;
		} else {
			$modStok->qtystok_in = $selisih;
			$modStok->harganetto = $modDetailOpname->harganetto;
			$modStok->jmlmargin = $modDetailOpname->hargasatuan - $modDetailOpname->harganetto;
		}

		$modStok->qtystok_out = 0;
		$modStok->create_time = date('Y-m-d H:i:s');
		$modStok->update_time = date('Y-m-d H:i:s');
		$modStok->create_loginpemakai_id = Yii::app()->user->id;
		$modStok->update_loginpemakai_id = Yii::app()->user->id;
		$modStok->create_ruangan = Yii::app()->user->ruangan_id;
		$modStok->satuankecil_id = (isset($modDetailOpname->satuankecil_id) ? $modDetailOpname->satuankecil_id : $loadObatAlkes->satuankecil_id);

		if ($modStok->validate()) {
			$modStok->save();
			$loadObatAlkes->tglkadaluarsa = $modStok->tglkadaluarsa;
			$loadObatAlkes->harganetto = $modStok->harganetto;
			$loadObatAlkes->discount = (($modStok->jmldiscount > 0) ? $modStok->jmldiscount : $modStok->harganetto * $modStok->persendiscount / 100);
			$loadObatAlkes->ppn_persen = $modStok->persenppn;
			$loadObatAlkes->hpp = $modStok->HPP;
			$loadObatAlkes->satuankecil_id = $modStok->satuankecil_id;
			$loadObatAlkes->satuanbesar_id = (!empty($loadObatAlkes->satuanbesar_id) ? $loadObatAlkes->satuanbesar_id : Params::DEFAULT_SATUANBESAR_ID);
			$loadObatAlkes->satuanbesar_id = (!empty($modStok->satuanbesar_id) ? $modStok->satuanbesar_id : $loadObatAlkes->satuanbesar_id);

			if ($modStok->persenmargin > 0) {
				$hargajual = ($modStok->HPP + ($modStok->HPP * ($modStok->persenmargin / 100)));
			} else {
				$hargajual = $modStok->HPP + $modStok->jmlmargin;
			}
			if ($hargajual > $loadObatAlkes->hargamaksimum) {
				$loadObatAlkes->hargamaksimum = $hargajual;
			}
			if ($loadObatAlkes->hargaminimum <= 0 || $hargajual < $loadObatAlkes->hargaminimum) {
				$loadObatAlkes->hargaminimum = $hargajual;
			}
			if ($loadObatAlkes->hargaaverage > 0 && $hargajual > 0) {
				$loadObatAlkes->hargaaverage = ($loadObatAlkes->hargaaverage + $hargajual) / 2;
			} else {
				$loadObatAlkes->hargaaverage = $hargajual;
			}
			$loadObatAlkes->hargajual = $hargajual;

			if ($loadObatAlkes->save()) {

			} else {
				$this->stokobatalkestersimpan &= false;
			}
		} else {
			$this->stokobatalkestersimpan &= false;
		}

		return $modStok;
	}

        protected function simpanInventarisasiRuangan($modInventarisasiDetail)
        {
                $inv = new InventarisasiruanganT;

                $inv->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $inv->barang_id = $modInventarisasiDetail->barang_id;
                $inv->invbarangdet_id = $modInventarisasiDetail->invbarangdet_id;
                $inv->inventarisasi_kode = MyGenerator::kodeStokAwalPersediaan();
                $inv->tgltransaksi = $modInventarisasiDetail->tglperiksafisik;
                $inv->inventarisasi_hargabeli = $modInventarisasiDetail->jumlah_harga;
                $inv->inventarisasi_hargasatuan = $modInventarisasiDetail->harga_netto;

                $qtyStokInv = 0;

                if($modInventarisasiDetail->invbarang->invbarang_jenis == "Stok Awal" && $modInventarisasiDetail->kondisi_barang == 'Baik'){
                    $qtyStokInv = ($modInventarisasiDetail->volume_sistem + $modInventarisasiDetail->volume_fisik);
                }else if($modInventarisasiDetail->invbarang->invbarang_jenis == "Stok Awal" && $modInventarisasiDetail->kondisi_barang == 'Dalam Perbaikan'){
                    $qtyStokInv = ($modInventarisasiDetail->volume_sistem - $modInventarisasiDetail->volume_fisik);
                }else if($modInventarisasiDetail->invbarang->invbarang_jenis == "Stok Awal" && $modInventarisasiDetail->kondisi_barang == 'Rusak'){
                    $qtyStokInv = ($modInventarisasiDetail->volume_sistem - $modInventarisasiDetail->volume_fisik);
                }
                $inv->inventarisasi_qty_in = $inv->inventarisasi_qty_skrg = $qtyStokInv;
//                $inv->inventarisasi_qty_in = $inv->inventarisasi_qty_skrg = $modInventarisasiDetail->volume_fisik;
                $inv->inventarisasi_keadaan = $modInventarisasiDetail->kondisi_barang;
                $inv->inventarisasi_qty_out = 0;

                $inv->save();
                $modInventarisasiDetail->inventarisasi_id = $inv->inventarisasi_id;
                $modInventarisasiDetail->save();
                //var_dump($modInventarisasiDetail->attributes, $inv->attributes, $inv->validate(), $inv->errors);
                //die;

        }


	/**
	 * simpan StokobatalkesT Jumlah Out
	 * @param type $stokobatalkesasal_id
	 * @param type $jumlah = jumlah yang dikeluarkan untuk penyesuaian stok
	 * @return \StokobatalkesT
	 */
	protected function simpanStokObatAlkesOut($modDetailOpname, $stokobatalkesasal_id, $jumlah) {
		$format = new MyFormatter;
		$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
		$modStokOaNew = new StokobatalkesT;
		$modStokOaNew->attributes = $modStokOa->attributes; //duplicate
		$modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
		$modStokOaNew->qtystok_in = 0;
		$modStokOaNew->qtystok_out = $jumlah;
		$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
		$modStokOaNew->stokopnamedet_id = $modDetailOpname->stokopnamedet_id;
		$modStokOaNew->tglstok_in = null;
		$modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
		$modStokOaNew->create_time = date('Y-m-d H:i:s');
		$modStokOaNew->update_time = date('Y-m-d H:i:s');
		$modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
		$modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
		$modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

		if ($modStokOaNew->validateStok()) {
			$modStokOaNew->save();
			$modStokOaNew->setStokOaAktifBerdasarkanStok();
		} else {
			$this->stokobatalkestersimpan &= false;
		}
		return $modStokOaNew;
	}

	public function actionPrint($invbarang_id = null) {
		$format = new MyFormatter();
		$model = GUInvbarangT::model()->findByPK($invbarang_id);
		$modDetails = GUInvbarangdetT::model()->findAllByAttributes(array('invbarang_id' => $invbarang_id));

		$judulLaporan = 'RINCIAN INVENTARISASI BARANG';
		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

		if (isset($_GET['frame'])) {
			$this->layout = '//layouts/iframe';
		}
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
		}

		$this->render($this->path_view . 'Print', array(
			'model' => $model,
			'judulLaporan' => $judulLaporan,
			'caraPrint' => $caraPrint,
			'modDetails' => $modDetails,
			'format' => $format
		));
	}

	public function actionAutocompletePegawai() {
		if (Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai';
			$criteria->limit = 5;
			$models = GUPegawaiV::model()->findAll($criteria);
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
				$returnVal[$i]['value'] = $model->pegawai_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

}
