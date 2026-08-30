<?php

class RencanaTindakanObatController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view='anestesi.views.rencanaTindakanObat.';
	public $path_tips='anestesi.views.tips.';
	
	public $pasienanestesitersimpan = false;
	public $praanestesitersimpan = false;
	public $tindakananestesitersimpan = true;
	public $tindakanpelayanantersimpan = true;
	public $obatalkesanestesitersimpan = true;
	public $obatalkespasientersimpan = true;
	public $successSaveBmhp = true;
	public $successSavePemakaianBahan = true;
	public $stokobatalkestersimpan = true;

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionIndex()
	{
		$format = new MyFormatter();
		$model = new ATPasienanastesiT();
		$modPraAnestesi = new ATPraanestesiT();
		$modTindakanAnestesi = new ATTindakananestesiT();
		$modTindakanPelayanan = new ATTindakanpelayananT();
		$modObatAnestesi = new ATObatalkesanestesiT();
		$modObatAlkes = new ATObatalkespasienT();	
		$modPemeriksaanAnestesi = new ATTarifanestesiruanganV();
		
		$modPraAnestesi->tglpraanestesi = date('Y-m-d H:i:s');
		$modPraAnestesi->tglpuasa = date('Y-m-d H:i:s');
		$modPraAnestesi->instalasipasca_id = Yii::app()->user->getState('instalasi_id');
		$modPraAnestesi->ruanganpasca_id = Yii::app()->user->getState('ruangan_id');
		
		$pasienanastesi_id = isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null;
		if(!empty($pasienanastesi_id)){
			$model = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);
		}
		
		$praanestesi_id = isset($_GET['praanestesi_id']) ? $_GET['praanestesi_id'] : null;
		if(!empty($praanestesi_id)){
			$modPraAnestesi = ATPraanestesiT::model()->findByPk($praanestesi_id);
		}
		
		
		if(isset($_POST['ATPasienanastesiT']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$pasienanastesi_id = isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null;
				$model = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);
				$model = $this->simpanPasienAnestesi($model, $_POST['ATPasienanastesiT']);
				
				$modPraAnestesi = $this->simpanPraAnestesi($model, $modPraAnestesi, $_POST['ATPraanestesiT']);
				if(isset($_POST['ATTindakananestesiT'])){
					if(count($_POST['ATTindakananestesiT']) > 0){
						foreach($_POST['ATTindakananestesiT'] as $i=>$tindakan){
							$modDetailsTindakan[$i] = $this->simpanTindakanPelayanan($model, $modPraAnestesi, $tindakan);																												
							
							
							if(isset($_POST['paketBmhp'])){
								if(count($_POST['paketBmhp']) > 0){
								//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
									$detailGroups = array();
									foreach($_POST['paketBmhp'] AS $i => $postDetail){
										if(empty($postDetail['obatalkespasien_id'])){
											$modDetails[$i] = new ATObatalkespasienT();
											$modDetails[$i]->attributes = $postDetail;
											$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
											$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
											$obatalkes_id = $postDetail['obatalkes_id'];
											if(isset($detailGroups[$obatalkes_id])){
												$detailGroups[$obatalkes_id]['qtypemakaian'] += $postDetail['qtypemakaian'];
											}else{
												$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
												$detailGroups[$obatalkes_id]['qtypemakaian'] = $postDetail['qtypemakaian'];
											}
										}
									}
									//END GROUP
								}

								$obathabis = "";
								//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
								foreach($detailGroups AS $i => $detail){
									$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qtypemakaian'], Yii::app()->user->getState('ruangan_id'));
									if(count($modStokOAs) > 0){
										foreach($modStokOAs AS $i => $stok){
											$modDetailObats[$i] = $this->savePaketBmhp($model,$stok, $_POST['paketBmhp'],$modDetailsTindakan[$i]);
											$this->simpanObatAnestesi($modPraAnestesi,$modDetailObats[$i]);
											$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetailObats[$i]);
										}
									}else{
										$this->stokobatalkestersimpan &= false;
										$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

									}
								}
							}
							
							if(isset($_POST['ATObatalkespasienT'])){
								if(count($_POST['ATObatalkespasienT']) > 0){
								//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
									$detailGroups = array();
									foreach($_POST['ATObatalkespasienT'] AS $i => $postDetail){
										if(empty($postDetail['obatalkespasien_id'])){
											$modDetails[$i] = new ATObatalkespasienT();
											$modDetails[$i]->attributes = $postDetail;
											$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
											$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
											$obatalkes_id = $postDetail['obatalkes_id'];
											if(isset($detailGroups[$obatalkes_id])){
												$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
											}else{
												$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
												$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
											}
										}
									}
									//END GROUP
								}

								$obathabis = "";
								//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
								foreach($detailGroups AS $i => $detail){
									$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
									if(count($modStokOAs) > 0){
										foreach($modStokOAs AS $i => $stok){
											$modDetails[$i] = $this->savePemakaianBahan($model,$stok, $_POST['ATObatalkespasienT'],$tindakan);
											$this->simpanObatAnestesi($modPraAnestesi,$modDetails[$i]);
											$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
										}
									}else{
										$this->stokobatalkestersimpan &= false;
										$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

									}
								}
							}
						}
					}
				}
				
				if($this->pasienanestesitersimpan && $this->praanestesitersimpan && $this->tindakananestesitersimpan && $this->tindakanpelayanantersimpan && $this->obatalkesanestesitersimpan && $this->obatalkespasientersimpan && $this->successSaveBmhp && $this->successSavePemakaianBahan){
					$transaction->commit();
					$model->isNewRecord = FALSE;
					$this->redirect(array('index','id'=>$model->pasienanastesi_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data Rencana Tindakan Obat dan Alkes gagal disimpan !");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
						. "<i class='icon-refresh icon-white'></i> Simpan Ulang"
						. "</a>";
				Yii::app()->user->setFlash('error',"Data Rencana Tindakan Obat dan Alkes gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model,
			'modPraAnestesi'=>$modPraAnestesi,
			'modTindakanAnestesi'=>$modTindakanAnestesi,
			'modTindakanPelayanan'=>$modTindakanPelayanan,
			'modObatAnestesi'=>$modObatAnestesi,
			'modObatAlkes'=>$modObatAlkes,
			'modPemeriksaanAnestesi'=>$modPemeriksaanAnestesi
		));
	}
	
	
	/**
	* proses simpan / ubah data pasien anastesi
	* @param type $model
	* @param type $post
	* @return type
	*/
	public function simpanPasienAnestesi($model, $post){
		$format = new MyFormatter();
		$modPendaftaran = array();
		if(isset($model->pasienanastesi_id) && (!empty($post['pasienanastesi_id']))){
			$load = new $model;
			$model = ATPasienanastesiT::model()->findByPk($model->pasienanastesi_id);
			$modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
		}
		$model->attributes = $post;
		$model->tglanastesi = isset($model->tglanestesi) ? $model->tglanestesi : date('Y-m-d H:i:s');
		$model->statusanestesi = 'Pra Anestesia';

		if(empty($model->pasienanastesi_id)){
			$model->pasien_id = $modPendaftaran->pasien_id;
			$model->pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
			$model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->create_time = date('Y-m-d H:i:s');
			$model->noanestesi = MyGenerator::noAnestesi();
		}else{
			$model->update_loginpemakai_id = Yii::app()->user->id;
			$model->update_time = date('Y-m-d H:i:s');
			if(empty($model->noanestesi)){
				$model->noanestesi = MyGenerator::noAnestesi();
			}
		}

		if($model->save()){
			$this->pasienanestesitersimpan = true;
		}

		return $model;
	}
	
	
	/**
	* proses simpan / ubah data pra pasien anastesi
	* @param type $model
	* @param type $post
	* @return type
	*/
	public function simpanPraAnestesi($model, $modPraAnestesi, $post){
		
		$format = new MyFormatter();
		$modPendaftaran = array();
		if(isset($modPraAnestesi->praanestesi_id) && (!empty($post['praanestesi_id']))){
			$load = new $modPraAnestesi;
			$modPraAnestesi = ATPraanestesiT::model()->findByPk($modPraAnestesi->praanestesi_id);
			$modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
		}
		$modPraAnestesi->attributes = $post;
		$modPraAnestesi->tglpraanestesi = $format->formatDateTimeForDb($post['tglpraanestesi']);
		$modPraAnestesi->tglpuasa = $format->formatDateTimeForDb($post['tglpuasa']);
		$modPraAnestesi->monitoring = isset($post['monitoring']) ? ((count($post['monitoring'])>0) ? implode(', ', $post['monitoring']) : '') : '';
		
		if(empty($modPraAnestesi->pasienanastesi_id)){
			$modPraAnestesi->pasienanastesi_id = $model->pasienanastesi_id;
			$modPraAnestesi->nopraanestesi = MyGenerator::noPraAnestesi();
			$modPraAnestesi->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modPraAnestesi->create_loginpemakai_id = Yii::app()->user->id;
			$modPraAnestesi->create_time = date('Y-m-d H:i:s');		   
		}else{
			$modPraAnestesi->update_loginpemakai_id = Yii::app()->user->id;
			$modPraAnestesi->update_time = date('Y-m-d H:i:s');
		}

		if($modPraAnestesi->save()){
			$this->praanestesitersimpan = true;
		}

                die;
		return $modPraAnestesi;
	}
	
	/**
	* proses simpan TindakanpelayananT
	*/
	public function simpanTindakanPelayanan($model, $modPraAnestesi, $post){		
		if($post['tindakanpelayanan_id'] != ''){
			$modTindakan = ATTindakanpelayananT::model()->findByPk($post['tindakanpelayanan_id']);
		}else{
			$modTindakan = new ATTindakanpelayananT();
		}
		$modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
		$modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($model->pasienmasukpenunjang_id);
		$modTindakan->attributes = $modPendaftaran->attributes;
		$modTindakan->attributes = $modPasienMasukPenunjang->attributes;
		$modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modTindakan->attributes = $post;
		$modTindakan->daftartindakan_id = $post['daftartindakan_id'];
		$modTindakan->alatmedis_id = $this->cekAlatmedis($post['daftartindakan_id']);
		$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
		$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan();
		$modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
		$modTindakan->create_time = date("Y-m-d H:i:s");
		$modTindakan->create_loginpemakai_id = Yii::app()->user->id;
		$modTindakan->shift_id =Yii::app()->user->getState('shift_id');
		$modTindakan->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
		$modTindakan->tgl_tindakan=date('Y-m-d H:i:s');
		$modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
		$modTindakan->cyto_tindakan=0;
		$modTindakan->tarifcyto_tindakan=0;
		$modTindakan->discount_tindakan=0;
		$modTindakan->subsidiasuransi_tindakan=0;
		$modTindakan->subsidipemerintah_tindakan=0;
		$modTindakan->subsisidirumahsakit_tindakan=0;
		$modTindakan->iurbiaya_tindakan=0;
		$modTindakan->tarif_rsakomodasi=0;
		$modTindakan->tarif_medis=0;
		$modTindakan->tarif_paramedis=0;
		$modTindakan->tarif_bhp=0;

		if($modTindakan->validate()){
			if($modTindakan->save()){
				$modDetailsAnestesi = $this->simpanTindakanAnestesi($model,$modPraAnestesi,$modTindakan,$post);																					
				$this->tindakanpelayanantersimpan &= true;
			}
		}else{
			$this->tindakanpelayanantersimpan &= false;
		}

		return $modTindakan;
   }
   
   /**
	* proses simpan TindakananestesiT
	*/
	public function simpanTindakanAnestesi($model, $modPraAnestesi, $tindakan, $post){
		$modTindakanAnestesi = ATTindakananestesiT::model()->findByAttributes(array('tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id));
		if(empty($modTindakanAnestesi)){
			$modTindakanAnestesi = new ATTindakananestesiT();
		}		
		$modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
		$modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($model->pasienmasukpenunjang_id);
		$modTindakanAnestesi->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
		$modTindakanAnestesi->daftartindakan_id = $tindakan->daftartindakan_id;
		$modTindakanAnestesi->alatmedis_id = $this->cekAlatmedis($tindakan->daftartindakan_id);
		$modTindakanAnestesi->anastesi_id = $post['anastesi_id'];
		$modTindakanAnestesi->praanestesi_id = $modPraAnestesi->praanestesi_id;
		$modTindakanAnestesi->ruangan_id = $modPraAnestesi->ruanganpasca_id;
		$modTindakanAnestesi->tgl_tindakananestesi = date('Y-m-d H:i:s');
		$modTindakanAnestesi->qty_tindakan = $tindakan->qty_tindakan;
		$modTindakanAnestesi->tarif_tindakan = $tindakan->tarif_tindakan;
		$modTindakanAnestesi->create_time = date("Y-m-d H:i:s");
		$modTindakanAnestesi->create_loginpemakai_id = Yii::app()->user->id;
		$modTindakanAnestesi->create_ruangan = Yii::app()->user->getState('ruangan_id');

		if($modTindakanAnestesi->validate()){
			if($modTindakanAnestesi->save()){
				$this->tindakanpelayanantersimpan &= true;
			}
		}else{
			$this->tindakanpelayanantersimpan &= false;
		}

		return $modTindakanAnestesi;
   }

   protected function cekAlatmedis($daftartindakan_id)
	{
		$alatmedis_id = null;
		if(!empty($_POST['pemakaianAlat'])){
			foreach($_POST['pemakaianAlat'] as $k=>$item){
				if($item['daftartindakan_id']==$daftartindakan_id){
					$alatmedis_id = $item['alatmedis_id'];
				}
			}
		}

		return $alatmedis_id;
	}
	
	protected function savePaketBmhp($model,$stokOa,$paketBmhp,$tindakan)
	{
		$modObatAlkesPasien = new ATObatalkespasienT();
        $modObatAlkesPasien->attributes = $stokOa->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //$tindakan->tipepaket_id;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $model->pendaftaran_id;
        $modObatAlkesPasien->pasienadmisi_id = $model->pendaftaran->pasienadmisi_id;
        $modObatAlkesPasien->carabayar_id = $model->pendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $model->pendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $model->pendaftaran->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $model->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $model->pendaftaran->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
        $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
        $modObatAlkesPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
		$totalBmhp = 0;
		
         foreach ($paketBmhp AS $i => $bmhp) {
			 if ($stokOa->obatalkes_id==$bmhp['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $bmhp['sumberdana_id'];                
                $modObatAlkesPasien->satuankecil_id = $bmhp['satuankecil_id'];                
                $modObatAlkesPasien->qty_stok = $bmhp['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $bmhp['subtotal'];
				$modObatAlkesPasien->qty_oa = $bmhp['qtypemakaian'];
				$modObatAlkesPasien->hargajual_oa = $bmhp['hargapemakaian'];
				$modObatAlkesPasien->harganetto_oa = $bmhp['harganetto'];
				$modObatAlkesPasien->hargasatuan_oa = $bmhp['hargasatuan']; //$bmhp['hargasatuan'];
				$modObatAlkesPasien->daftartindakan_id = $bmhp['daftartindakan_id'];				
				$modObatAlkesPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
				$totalBmhp = $totalBmhp + $bmhp['hargapemakaian'];		
			 }
        }
		
		if($modObatAlkesPasien->save()){
			$this->successSaveBmhp &= true;
			$totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
			$tindakan->tarif_bhp = $totalBmhp;
			$tindakan->update();
		}else{
			$this->successSaveBmhp &= false;
		}
		return $modObatAlkesPasien;
	}
        
	protected function savePemakaianBahan($model,$stokOa,$pemakaianBahan,$tindakan)
	{
		$modObatAlkesPasien = new ATObatalkespasienT();
        $modObatAlkesPasien->attributes = $stokOa->attributes;
        $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->pendaftaran_id = $model->pendaftaran_id;
        $modObatAlkesPasien->pasienadmisi_id = $model->pendaftaran->pasienadmisi_id;
        $modObatAlkesPasien->carabayar_id = $model->pendaftaran->carabayar_id;
        $modObatAlkesPasien->penjamin_id = $model->pendaftaran->penjamin_id;
        $modObatAlkesPasien->pegawai_id = $model->pendaftaran->pegawai_id;
        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
        $modObatAlkesPasien->pasien_id = $model->pasien_id;
        $modObatAlkesPasien->kelaspelayanan_id = $model->pendaftaran->kelaspelayanan_id;
        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
        $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
        $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
        $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
        $modObatAlkesPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
        $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
         foreach ($pemakaianBahan AS $i => $postDetail) {
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
                $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
                $modObatAlkesPasien->daftartindakan_id = $postDetail['daftartindakan_id'];                
                $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
            }
        }

        if($modObatAlkesPasien->save()){
            $this->successSavePemakaianBahan &= true;
        }else{
            $this->successSavePemakaianBahan &= false;
        }
        return $modObatAlkesPasien;
	}
	
	protected function simpanObatAnestesi($modPraAnestesi,$obatalkes)
	{
		$modObatAnestesi = new ATObatalkesanestesiT();
        $modObatAnestesi->attributes = $obatalkes->attributes;
        $modObatAnestesi->praanestesi_id = $modPraAnestesi->praanestesi_id;
        $modObatAnestesi->obatalkespasien_id = $obatalkes->obatalkespasien_id;
        $modObatAnestesi->ruangan_id = Yii::app()->user->getState('ruangan_id');               
        $modObatAnestesi->qty_oa = $obatalkes->qty_oa;
        $modObatAnestesi->hargasatuan_oa = $obatalkes->hargasatuan_oa;
        $modObatAnestesi->create_loginpemakai_id = Yii::app()->user->id;
        $modObatAnestesi->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modObatAnestesi->create_time = date ('Y-m-d H:i:s');
        if($modObatAnestesi->save()){
            $this->obatalkesanestesitersimpan &= true;
        }else{
            $this->obatalkesanestesitersimpan &= false;
        }
        return $modObatAnestesi;
	}
	
	/**
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $modObatAlkesPasien
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut($stokobatalkesasal_id,$modObatAlkesPasien){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
        $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
        $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
		$modStokOaNew->tglstok_in = null;
		$modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
        
        if($modStokOaNew->validateStok()){ 
            $modStokOaNew->save();
            $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }
	
	/**
	*penggunaannya
	* 1. digunakan di rencana tindakan obat dan alkes - Pra Anestesia
	* @param type $encode
	* @param type $namaModel
	* @param type $attr 
	*/
   public function actionSetDropdownKamarKosong($encode=false,$namaModel='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
		   if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
			   $ruangan_id = $_POST[$namaModel]['ruangan_id'];

		   $kamarKosong = array();
		   
		   if(!empty($ruangan_id)) {
				$kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
				$kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
		   }

		   if($encode){
			   echo CJSON::encode($kamarKosong);
		   } else {
			   if(empty($kamarKosong)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
				   foreach($kamarKosong as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   
   /**
	*penggunaannya
	* 1. digunakan di rencana tindakan obat dan alkes - Pra Anestesia
	* @param type $encode
	* @param type $namaModel
	* @param type $attr 
	*/
   public function actionSetDropDownRuangan($encode=false,$namaModel='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $instalasi_id = (isset($_POST['instalasipasca_id']) ? $_POST['instalasipasca_id'] : null);
		   if (empty($instalasi_id) && isset($_POST[$namaModel]['instalasipasca_id']))
			   $instalasi_id = $_POST[$namaModel]['instalasipasca_id'];

		   $ruangan = array();
		   
		   if(!empty($instalasi_id)) {
				$ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id,'ruangan_aktif'=>true),array('order'=>'ruangan_nama ASC'));
				$ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
		   }

		   if($encode){
			   echo CJSON::encode($ruangan);
		   } else {
			   if(empty($ruangan)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
				   foreach($ruangan as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   
   /**
	* set checklist pemeriksaan rad
	*/
	public function actionSetChecklistPemeriksaanAnestesi(){
	   if (Yii::app()->request->isAjaxRequest){
		   $content = "";
		   parse_str($_POST['data'], $post);
		   $postPemeriksaan = $post['ATTarifanestesiruanganV'];
		   if(!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])){
			   $criteria = new CdbCriteria();
//			   $criteria->addCondition('ruangan_id = '.$postPemeriksaan['ruangan_id']);
//			   $criteria->addCondition('kelaspelayanan_id = '.$postPemeriksaan['kelaspelayanan_id']);
//			   $criteria->addCondition('penjamin_id = '.$postPemeriksaan['penjamin_id']);
			   
			   $criteria->compare('LOWER(jenisanastesi_nama)',strtolower($postPemeriksaan['jenisanastesi_nama']), true);
			   $criteria->compare('LOWER(anastesi_nama)',strtolower($postPemeriksaan['anastesi_nama']), true);
			   $criteria->order = "jenisanastesi_nama, anastesi_nama";
			   $modPemeriksaanAnestesis = ATTarifanestesiruanganV::model()->findAll($criteria);
			   $content = $this->renderPartial($this->path_view.'_checklistPemeriksaanAnestesi',array('modPemeriksaanAnestesis'=>$modPemeriksaanAnestesis), true);
		   }
		   echo CJSON::encode(array(
			   'content'=>$content));
		   Yii::app()->end();
	   }
	}
	/**
	* get data pasien anastesi
	*/
	public function actionGetDataPasien(){
	   if (Yii::app()->request->isAjaxRequest){
		   $format = new MyFormatter();
		   $returnVal = array();
		   $pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;
		   if(!empty($pasienanastesi_id)){
				$criteria = new CdbCriteria();
				$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
				$model = ATInformasipasienanestesiV::model()->find($criteria);				
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal["$attribute"] = $model->$attribute;
				}
				$returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
				$returnVal["tglanastesi"] = $format->formatDateTimeForUser($model->tglanastesi);
		   }
		   echo CJSON::encode($returnVal);
		   Yii::app()->end();
	   }
	}
	
	/**
	* get riwayat anamnesa
	*/
    public function actionSetRiwayatAnamnesa(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $pasienanastesi_id = (isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null);
			$criteria = new CdbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			$model = ATInformasipasienanestesiV::model()->find($criteria);
            $pendaftaran_id = $model->pendaftaran_id;
            $anamnesa = ATAnamnesaT::model()->find('pendaftaran_id = '.$pendaftaran_id);
            if(!empty($anamnesa)){
                $modAnamnesa = $anamnesa;
            }else{
                $modAnamnesa= new ATAnamnesaT();
                $modAnamnesa->pendaftaran_id = $pendaftaran_id;
            }
            $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;
            $rows .= $this->renderPartial($this->path_view."_riwayatAnamnesa",array('i'=>0, 'modAnamnesa'=>$modAnamnesa), true);
            echo CJSON::encode(array(
                    'rows'=>$rows));
        }
        Yii::app()->end();
    }
    
	/**
	* get riwayat pemeriksaan fisik
	*/
    public function actionSetRiwayatPemeriksaanFisik(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $pasienanastesi_id = (isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null);
			$criteria = new CdbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			$model = ATInformasipasienanestesiV::model()->find($criteria);
			$pendaftaran_id = $model->pendaftaran_id;
            $periksafisik = ATPemeriksaanfisikT::model()->find('pendaftaran_id = '.$pendaftaran_id);
            if(!empty($periksafisik)){
                $modPemeriksaan = $periksafisik;
            }else{
                $modPemeriksaan= new ATPemeriksaanfisikT;
                $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
            }
			$modPemeriksaanGambar = ATPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			$modGambarTubuh = new ATGambartubuhM();
			$modBagianTubuh = new ATBagiantubuhM();
		
            $rows .= $this->renderPartial($this->path_view."_riwayatPemeriksaanFisik",array(
						'i'=>0,
						'modPemeriksaan'=>$modPemeriksaan,
						'modPemeriksaanGambar'=>$modPemeriksaanGambar,
						'modGambarTubuh'=>$modGambarTubuh,
						'modBagianTubuh'=>$modBagianTubuh
					), true);
            echo CJSON::encode(array(
                    'rows'=>$rows));
        }
        Yii::app()->end();
    }
    
	/**
	* get riwayat pemeriksaan penunjang
	*/
    public function actionSetRiwayatPemeriksaanPenunjang(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $pasienanastesi_id = (isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null);
			$criteria = new CdbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			$model = ATInformasipasienanestesiV::model()->find($criteria);
			$pendaftaran_id = $model->pendaftaran_id;
			$criteriaPenunjang = new CdbCriteria();
			$criteriaPenunjang->addCondition('pendaftaran_id = '.$pendaftaran_id);
			$criteriaPenunjang->order = 'pasienmasukpenunjang_id DESC';
            $modPasienMasukPenunjang = ATPasienmasukpenunjangT::model()->find($criteriaPenunjang);
			$modTindakanPelayanan = ATTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id));
			$modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
			$modHasilPemeriksaanRad = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
            $rows .= $this->renderPartial($this->path_view."_riwayatPasienPenunjang",array('i'=>0, 'model'=>$model,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang, 'modTindakanPelayanan'=>$modTindakanPelayanan,'modHasilPemeriksaan'=>$modHasilPemeriksaan,'modHasilPemeriksaanRad'=>$modHasilPemeriksaanRad), true);
            
			echo CJSON::encode(array(
				'rows'=>$rows
			));
        }
        Yii::app()->end();
    }
	
	public function actionSetSatuanObat()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
            $form = "";
            $pesan = "";
			$satuankecil_nama="";
			$satuanterkecil_nama="";
            $format = new MyFormatter();
            $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
            
            if(!empty($modObatAlkes)){
				$satuankecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
				$satuanterkecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
            }else{
                $pesan = "Obat tidak ditemukan!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan,
				'satuankecil'=>$satuankecil_nama,
				'satuanterkecil'=>$satuanterkecil_nama
			));
            Yii::app()->end(); 
        }
    }
	
	 /**
    * menampilkan obat
    * @return row table 
    */
    public function actionSetFormObatAlkesPasien()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
            $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
			$pasienanastesi_id = (isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null);
			$criteria = new CdbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			$model = ATInformasipasienanestesiV::model()->find($criteria);
			$penjamin_id = $model->penjamin_id;
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modObatAlkesPasien = new ATObatalkespasienT;
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);

            if(count($modStokOAs) > 0){
                foreach($modStokOAs AS $i => $stok){
                    $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                    $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
                    $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
                    $modObatAlkesPasien->harganetto_oa = $stok->HPP;
                    $modObatAlkesPasien->hargasatuan_oa = $stok->getHargaJualSatuan($penjamin_id);
                    $modObatAlkesPasien->qty_stok = $stok->qtystok;
                    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
                    $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
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
                    $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
                    $modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;
                    
                    $form .= $this->renderPartial($this->path_view.'_rowObatAlkesPasien', array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
                }
            }else{
                $pesan = "Stok tidak mencukupi!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	/**
	 * untuk mencari paket bmhp di autocomplete
	 */
	public function actionAutocompletePemakaianBmhp()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->with = array('obatalkes','daftartindakan','kelompokumur');
			$criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
			$criteria->order = 'obatalkes.obatalkes_nama';
			$criteria->limit = 5;
			$models = PaketbmhpM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				 $attributes = $model->attributeNames();
				 foreach($attributes as $j=>$attribute) {
					 $returnVal[$i]["$attribute"] = $model->$attribute;
				 }
				 $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama.' - '.$model->daftartindakan->daftartindakan_nama.' ('.$model->kelompokumur->kelompokumur_nama.')';
				 $returnVal[$i]['value'] = $model->obatalkes->obatalkes_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionSetFormPemakaianBmhp()
	{
		if(Yii::app()->request->isAjaxRequest) { 
			$anastesi_id = (isset($_POST['anastesi_id']) ? $_POST['anastesi_id'] : null);
			$pasienanastesi_id = (isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null);
			$criteria = new CdbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			$model = ATInformasipasienanestesiV::model()->find($criteria);
			$pendaftaran_id = $model->pendaftaran_id;
			$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
			$kelompokumur_id = $modPendaftaran->kelompokumur_id;
			$daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);            
			$modPaketBmhp = PaketbmhpM::model()->with('daftartindakan','obatalkes')->findAllByAttributes(array('daftartindakan_id'=>$daftartindakan_id,
																		'kelompokumur_id'=>$kelompokumur_id,));
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			$modObatAlkesPasien = new ATObatalkespasienT();
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
			$persenjual = $this->persenJualRuangan();
			
			$modAnastesi = ATAnastesiM::model()->findByPk($anastesi_id);
			
			foreach($modPaketBmhp AS $j => $paket){				
				$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($paket->obatalkes_id, $paket->qtypemakaian, $ruangan_id);			
				if(count($modStokOAs) > 0){
					foreach($modStokOAs AS $i => $stok){
						$modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
						$modObatAlkesPasien->daftartindakan_id = $paket->daftartindakan_id;
						$modObatAlkesPasien->daftartindakan_nama = $paket->daftartindakan->daftartindakan_nama;
						$modObatAlkesPasien->anastesi_nama = isset($modAnastesi->anastesi_nama) ? $modAnastesi->anastesi_nama : "";
						$modObatAlkesPasien->anastesi_id = isset($modAnastesi->anastesi_id) ? $modAnastesi->anastesi_id : "";
						$modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
						$modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
						$modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;
						$modObatAlkesPasien->qtypemakaian = $stok->qtystok_terpakai;
						$modObatAlkesPasien->hargapemakaian = $paket->hargapemakaian;
						$modObatAlkesPasien->harganetto_oa = $stok->HPP;
						$modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
						$modObatAlkesPasien->hargasatuan_oa = $stok->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
						$modObatAlkesPasien->qty_stok = $stok->qtystok;
						$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
						$modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
						$modObatAlkesPasien->hargajual = floor(($persenjual + 100 ) / 100 * $modObatAlkesPasien->hargajual);
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
						$modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
						$modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;

						$form .= $this->renderPartial($this->path_view.'_rowPemakaianBmhp', array(
							'paketBmhp'=>$modObatAlkesPasien,
							'modDaftartindakan'=>$modDaftartindakan,
							'modPendaftaran'=>$modPendaftaran
						), true);
					}
				}else{
					$pesan = "Obat : ". $paket->obatalkes->obatalkes_nama." Stok tidak mencukupi!"	;
				}				
			}			
			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
	}
	
	public function actionSetFormPemakaianAlat()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$alatmedis_id = $_POST['alatmedis_id'];
			$anastesi_id = $_POST['anastesi_id'];
			$modAnastesi = ATAnastesiM::model()->findByPk($anastesi_id);
			$daftartindakan_id = isset($modAnastesi->daftartindakan_id) ? $modAnastesi->daftartindakan_id : null;
			$modAlat = AlatmedisM::model()->findByPk($alatmedis_id);
			$modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
			$modObatAlkes = new ObatalkesM;
			echo CJSON::encode(array(
				'namaAlat'=>$modAlat->alatmedis_nama,
				'form'=>$this->renderPartial($this->path_view.'_rowPemakaianAlatMedis', array('modAlat'=>$modAlat,'modDaftartindakan'=>$modDaftartindakan,'modObatAlkes'=>$modObatAlkes
					), true),
				));
			exit;               
		}
	}

	public function actionAutocompleteObatAlkes()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
			$criteria->order = 'obatalkes_nama';
			$criteria->addCondition('obatalkes_farmasi is true');
			$criteria->limit = 5;
			$models = ObatalkesM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->obatalkes_nama;
				$returnVal[$i]['value'] = $model->obatalkes_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	/**
	* untuk mencari pemakaian alat medis di autocomplete
	*/
	public function actionAutocompleteAlatMedis()
	{
	   if(Yii::app()->request->isAjaxRequest) {
		   $returnVal = array();
		   $criteria = new CDbCriteria();
		   $criteria->compare('LOWER(alatmedis_nama)', strtolower($_GET['term']), true);
//		   $criteria->addCondition('instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
		   $criteria->order = 'alatmedis_nama';
		   $models = AlatmedisM::model()->findAll($criteria);
		   foreach($models as $i=>$model)
		   {
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->alatmedis_nama;
				$returnVal[$i]['value'] = $model->alatmedis_id;
		   }

		   echo CJSON::encode($returnVal);
	   }
	   Yii::app()->end();
   }
   
	protected function persenJualRuangan()
	{
		switch(Yii::app()->user->getState('instalasi_id')){
			case Params::INSTALASI_ID_RI : $persen = Yii::app()->user->getState('ri_persjual');
											break;
			case Params::INSTALASI_ID_RJ : $persen = Yii::app()->user->getState('rj_persjual');
											break;
			case Params::INSTALASI_ID_RD : $persen = Yii::app()->user->getState('rd_persjual');
											break;
										default : $persen = 0; break;
		}

		return $persen;
	}
	
	/**
     * untuk print data rencana tindakan anestesia
     */
    public function actionPrintHasil($pasienanastesi_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);     
        $modPraAnestesi = ATPraanestesiT::model()->findByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id),array('order'=>'praanestesi_id DESC'));     
        $modTindakanAnestesi = ATTindakananestesiT::model()->findAllByAttributes(array('praanestesi_id'=>$modPraAnestesi->praanestesi_id));
        $modObatAlkesAnestesi = ATObatalkesanestesiT::model()->findAllByAttributes(array('praanestesi_id'=>$modPraAnestesi->praanestesi_id));
		
        $judul_print = 'Rencana Tindakan Anastesi';
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPasienAnestesi'=>$modPasienAnestesi,
                'modPraAnestesi'=>$modPraAnestesi,
                'modTindakanAnestesi'=>$modTindakanAnestesi,
                'modObatAlkesAnestesi'=>$modObatAlkesAnestesi,
                'caraprint'=>$caraprint
        ));
    } 
	
	/*
	 * untuk load data anestesi
	 * - praanestesi_id
	 */
	public function actionSetDataTindakanAnestesi()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			
			$praanestesi_id = (isset($_POST['praanestesi_id']) ? $_POST['praanestesi_id'] : null);
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			
			$criteria = new CdbCriteria();
			if(!empty($praanestesi_id)){
				$criteria->addCondition('praanestesi_id = '.$praanestesi_id);
			}
			
			$modTindakanAnestesi = ATTindakananestesiT::model()->findAll($criteria);			
			if(count($modTindakanAnestesi) > 0){
				foreach($modTindakanAnestesi AS $i => $tindakan){
					$modTindakanAnestesi = new ATTindakananestesiT();
					$modTindakanPelayanan = ATTindakanpelayananT::model()->findByPk($tindakan->tindakanpelayanan_id);
					
					$modTindakanAnestesi->tindakansudahbayar_id = $modTindakanPelayanan->tindakansudahbayar_id;
					$modTindakanAnestesi->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
					$modTindakanAnestesi->daftartindakan_id = $tindakan->daftartindakan_id;
					$modTindakanAnestesi->anastesi_id = $tindakan->anastesi_id;
					$modTindakanAnestesi->ruangan_id = $tindakan->ruangan_id;
					$modTindakanAnestesi->qty_tindakan = $tindakan->qty_tindakan;
					$modTindakanAnestesi->satuantindakan = $modTindakanPelayanan->satuantindakan;
					$modTindakanAnestesi->tarif_satuan = $modTindakanPelayanan->tarif_satuan;
					$modTindakanAnestesi->tarif_tindakan = $tindakan->tarif_tindakan;
					$modTindakanAnestesi->qty_tindakan = $tindakan->qty_tindakan;
					
					$form .= $this->renderPartial($this->path_view.'_rowTindakanPemeriksaan', array('modTindakanAnestesi'=>$modTindakanAnestesi), true);
				}
			}else{
				$pesan = "Stok tidak mencukupi!"	;
			}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}

	}
	
	public function actionSetDataPemakaianBahan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			
			$praanestesi_id = (isset($_POST['praanestesi_id']) ? $_POST['praanestesi_id'] : null);
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			
			$criteria = new CdbCriteria();
			if(!empty($praanestesi_id)){
				$criteria->addCondition('praanestesi_id = '.$praanestesi_id);
			}
			
			$modPemakaianBahan = ATObatalkesanestesiT::model()->findAll($criteria);			
			if(count($modPemakaianBahan) > 0){
				foreach($modPemakaianBahan AS $i => $bahan){
					$modObatAlkes = ATObatalkespasienT::model()->findByPk($bahan->obatalkespasien_id);
					$tindakanpelayanan_id = $modObatAlkes->tindakanpelayanan_id;
					if(!empty($tindakanpelayanan_id)){
						$modTindakanPelayanan = ATTindakanpelayananT::model()->findByPk($tindakanpelayanan_id);
					}
					$modObatAlkesPasien = new ATObatalkespasienT();
					$modStokObat = StokobatalkesT::model()->findByAttributes(array('obatalkespasien_id'=>$modObatAlkes->obatalkespasien_id));
					
					if(empty($tindakanpelayanan_id)){
						$modObatAlkesPasien->obatalkespasien_id = $bahan->obatalkespasien_id;
						$modObatAlkesPasien->obatalkes_id = $modObatAlkes->obatalkes_id;
						$modObatAlkesPasien->satuankecil_id = $modObatAlkes->satuankecil_id;
						$modObatAlkesPasien->sumberdana_id = $modObatAlkes->sumberdana_id;
						$modObatAlkesPasien->stokobatalkes_id = $modStokObat->stokobatalkes_id;
						$modObatAlkesPasien->daftartindakan_id = $modObatAlkes->daftartindakan_id;
						$modObatAlkesPasien->iurbiaya = $modObatAlkes->iurbiaya;
						$modObatAlkesPasien->subtotal = $modObatAlkes->hargajual_oa;
						$modObatAlkesPasien->qty_oa = $modObatAlkes->qty_oa;

						$form .= $this->renderPartial($this->path_view.'_rowObatAlkesPasien', array('modObatAlkesPasien'=>$modObatAlkesPasien), true);
					}
				}
			}else{
				$pesan = "Stok tidak mencukupi!"	;
			}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
	}
	
	public function actionSetDataPemakaianBmhp()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			
			$praanestesi_id = (isset($_POST['praanestesi_id']) ? $_POST['praanestesi_id'] : null);
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			
			$modPraAnestesi = ATPraanestesiT::model()->findByPk($praanestesi_id);
			$modPasienAnestesi = ATPasienanastesiT::model()->findByPk($modPraAnestesi->pasienanastesi_id);
			$modPendaftaran = ATPendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
			
			$criteria = new CdbCriteria();
			if(!empty($praanestesi_id)){
				$criteria->addCondition('praanestesi_id = '.$praanestesi_id);
			}
			
			$modPemakaianBahan = ATObatalkesanestesiT::model()->findAll($criteria);			
			if(count($modPemakaianBahan) > 0){
				foreach($modPemakaianBahan AS $i => $bahan){
					$modObatAlkes = ATObatalkespasienT::model()->findByPk($bahan->obatalkespasien_id);
					$tindakanpelayanan_id = $modObatAlkes->tindakanpelayanan_id;
					if(!empty($tindakanpelayanan_id)){
						$modTindakanPelayanan = ATTindakanpelayananT::model()->findByPk($tindakanpelayanan_id);
					}
					$modObatAlkesPasien = new ATObatalkespasienT();
					$modDaftartindakan = DaftartindakanM::model()->findByPk($modObatAlkes->daftartindakan_id);
					
					$modStokObat = StokobatalkesT::model()->findByAttributes(array('obatalkespasien_id'=>$modObatAlkes->obatalkespasien_id));
					if(!empty($tindakanpelayanan_id)){
						$modObatAlkesPasien->obatalkespasien_id = $bahan->obatalkespasien_id;
						$modObatAlkesPasien->obatalkes_id = $modObatAlkes->obatalkes_id;
						$modObatAlkesPasien->obatalkes_nama = $modObatAlkes->obatalkes->obatalkes_nama;
						$modObatAlkesPasien->satuankecil_id = $modObatAlkes->satuankecil_id;
						$modObatAlkesPasien->sumberdana_id = $modObatAlkes->sumberdana_id;
						$modObatAlkesPasien->stokobatalkes_id = $modStokObat->stokobatalkes_id;
						$modObatAlkesPasien->daftartindakan_id = $modObatAlkes->daftartindakan_id;
						$modObatAlkesPasien->daftartindakan_nama = isset($modDaftartindakan->daftartindakan_nama) ? $modDaftartindakan->daftartindakan_nama : "";
						$modObatAlkesPasien->iurbiaya = $modObatAlkes->iurbiaya;
						$modObatAlkesPasien->subtotal = $modObatAlkes->hargajual_oa;
						$modObatAlkesPasien->qty_oa = $modObatAlkes->qty_oa;

						$form .= $this->renderPartial($this->path_view.'_rowPemakaianBmhp', array('paketBmhp'=>$modObatAlkesPasien,'modPendaftaran'=>$modPendaftaran), true);
					}
				}
			}else{
				$pesan = "Stok tidak mencukupi!";
			}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
	}
	
	public function actionSetDataAlatMedis()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$form = "";
			$pesan = "";
			$format = new MyFormatter();
			
			$praanestesi_id = (isset($_POST['praanestesi_id']) ? $_POST['praanestesi_id'] : null);
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			
			$modPraAnestesi = ATPraanestesiT::model()->findByPk($praanestesi_id);
			$modPasienAnestesi = ATPasienanastesiT::model()->findByPk($modPraAnestesi->pasienanastesi_id);
			$modPendaftaran = ATPendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
			
			$criteria = new CdbCriteria();
			if(!empty($praanestesi_id)){
				$criteria->addCondition('praanestesi_id = '.$praanestesi_id);
				$criteria->addCondition('alatmedis_id is not null');
			}
			
			$modAlatMedis = ATTindakananestesiT::model()->findAll($criteria);			
			if(count($modAlatMedis) > 0){
				foreach($modAlatMedis AS $i => $alatmedis){
					$modAlat = AlatmedisM::model()->findByPk($alatmedis->alatmedis_id);
					$tindakanpelayanan_id = $alatmedis->tindakanpelayanan_id;
					if(!empty($tindakanpelayanan_id)){
						$modTindakanPelayanan = ATTindakanpelayananT::model()->findByPk($tindakanpelayanan_id);
					}
					$modDaftartindakan = DaftartindakanM::model()->findByPk($modTindakanPelayanan->daftartindakan_id);

					$form .= $this->renderPartial($this->path_view.'_rowPemakaianAlatMedis', array('modAlat'=>$modAlat,'modDaftartindakan'=>$modDaftartindakan), true);
				}
			}else{
				$pesan = "Alat Medis tidak ditemukan!";
			}

			echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
			Yii::app()->end(); 
		}
	}
	
	public function actionMasterMonitoring() 
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']),true);
			$criteria->addCondition("lookup_type = 'anestesimonitoring' ");
            $monitorings = LookupM::model()->findAll($criteria);
            $data = array();
            foreach ($monitorings as $i => $monitoring) {
                $data[$i] = array('key'=>$monitoring->lookup_name,
                                  'value'=>$monitoring->lookup_name);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
}
