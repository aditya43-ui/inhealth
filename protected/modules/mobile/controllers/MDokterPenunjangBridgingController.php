<?php
/**
 * Mobile untuk dokter penunjang:
 * - Laboratorium
 * - Radiologi
 * - Rehabilitasi Medis
 * - Bedah Sentral
 * - Gizi
 * - Persalinan
 */
Yii::import('mobile.controllers.MDokterBridgingController');
class MDokterPenunjangBridgingController extends MDokterBridgingController
{
	public $penunjangtersimpan = false;
	public $tindakantersimpan = true; //looping
	public $tindakankomponentersimpan = true; //looping
	public $hasilpemeriksaantersimpan = true; //looping
	
	
	/**
	 * menampilkan daftar pasien rujukan dari RS ke penunjang
	 * MA-438
	 * @param : pegawai_id, instalasi_id, ruangan_id, statusperiksa, q
	 */
	public function actionGetDaftarPasienRujukan(){
		header("content-type:application/json");
		$data = array();
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$limit = (isset($_GET['limit']) ? $_GET['limit'] : 9);
		$offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
		$sql = "SELECT pasienkirimkeunitlain_t.pasienkirimkeunitlain_id, pasien_m.pasien_id, pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.photopasien,pasien_m.nama_bin, pasien_m.jeniskelamin, pasien_m.tempat_lahir, pasien_m.tanggal_lahir, pasien_m.alamat_pasien, pasien_m.agama, pasien_m.golongandarah, pasien_m.rhesus, penanggungjawab_m.penanggungjawab_id, penanggungjawab_m.pengantar, penanggungjawab_m.hubungankeluarga, penanggungjawab_m.nama_pj, pasienkirimkeunitlain_t.tgl_kirimpasien, pasienkirimkeunitlain_t.nourut, pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_id, gelarbelakang_m.gelarbelakang_nama, pasienkirimkeunitlain_t.catatandokterpengirim, ruanganasal_m.ruangan_id AS ruanganasal_id, ruanganasal_m.ruangan_nama AS ruanganasal_nama, instalasiasal_m.instalasi_id AS instalasiasal_id, instalasiasal_m.instalasi_nama AS instalasiasal_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, pasienkirimkeunitlain_t.instalasi_id, pasienkirimkeunitlain_t.pasienmasukpenunjang_id, pasienkirimkeunitlain_t.create_time, pasienkirimkeunitlain_t.create_loginpemakai_id, pendaftaran_t.umur
					FROM pasienkirimkeunitlain_t
					JOIN pasien_m ON pasienkirimkeunitlain_t.pasien_id = pasien_m.pasien_id
					JOIN pendaftaran_t ON pasienkirimkeunitlain_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
					JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
					JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
					JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
					JOIN kelaspelayanan_m ON pasienkirimkeunitlain_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
					JOIN pegawai_m ON pasienkirimkeunitlain_t.pegawai_id = pegawai_m.pegawai_id
					LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
					LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
					JOIN ruangan_m ruanganasal_m ON pasienkirimkeunitlain_t.create_ruangan = ruanganasal_m.ruangan_id
					JOIN ruangan_m ON pasienkirimkeunitlain_t.ruangan_id = ruangan_m.ruangan_id
					JOIN instalasi_m instalasiasal_m ON ruanganasal_m.instalasi_id = instalasiasal_m.instalasi_id
					WHERE pasienkirimkeunitlain_t.pasienmasukpenunjang_id IS NULL
					AND pasienkirimkeunitlain_t.pegawai_id = ".$_GET['pegawai_id']."
					AND ruangan_m.instalasi_id = ".$_GET['instalasi_id'] 
					.(!empty($_GET['ruangan_id']) ? " AND ruangan_m.ruangan_id = ".$_GET['ruangan_id'] : " ")."
					AND (
						LOWER(pasien_m.no_rekam_medik) like '%".$req."%'
						OR LOWER(pasien_m.nama_pasien) like '%".$req."%'
						OR LOWER(pendaftaran_t.no_pendaftaran) like '%".$req."%'
						OR LOWER(ruanganasal_m.ruangan_nama) like '%".$req."%'
						OR LOWER(instalasiasal_m.instalasi_nama) like '%".$req."%'
					)
				ORDER BY pasienkirimkeunitlain_t.tgl_kirimpasien ASC
				LIMIT ".$limit."
				OFFSET ".$offset;
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$i] = $val;
				$data[$i]['photopasien'] = (!empty($val['photopasien']) ? Params::pathPasienTumbsDirectory().$val['photopasien'] : "");
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * menampilkan detail pasien rujukan dan form pemeriksaan ke penunjang
	 * MA-438
	 * @param : pasienkirimkeunitlain_id
	 */
	public function actionSetFormPasienRujukan(){
		header("content-type:application/json");
		$data = array();
		$data['permintaankepenunjangs'] = array();
		$data['jeniskasuspenyakits'] = array();
		$data['perawats'] = array();
		if(isset($_GET['pasienkirimkeunitlain_id'])){
			$sql = "SELECT permintaankepenunjang_t.*, daftartindakan_m.daftartindakan_nama, tindakanrm_m.tindakanrm_nama, pemeriksaanrad_m.pemeriksaanrad_nama, pemeriksaanlab_m.pemeriksaanlab_nama, operasi_m.operasi_nama
					FROM permintaankepenunjang_t
					LEFT JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = permintaankepenunjang_t.daftartindakan_id
					LEFT JOIN tindakanrm_m ON tindakanrm_m.tindakanrm_id = permintaankepenunjang_t.tindakanrm_id
					LEFT JOIN pemeriksaanrad_m ON pemeriksaanrad_m.pemeriksaanrad_id = permintaankepenunjang_t.pemeriksaanrad_id
					LEFT JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = permintaankepenunjang_t.pemeriksaanlab_id
					LEFT JOIN operasi_m ON operasi_m.operasi_id = permintaankepenunjang_t.operasi_id
					JOIN pasienkirimkeunitlain_t ON pasienkirimkeunitlain_t.pasienkirimkeunitlain_id = permintaankepenunjang_t.pasienkirimkeunitlain_id
					JOIN pasien_m ON pasienkirimkeunitlain_t.pasien_id = pasien_m.pasien_id
					JOIN pendaftaran_t ON pasienkirimkeunitlain_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
					JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
					JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
					JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
					JOIN kelaspelayanan_m ON pasienkirimkeunitlain_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
					JOIN pegawai_m ON pasienkirimkeunitlain_t.pegawai_id = pegawai_m.pegawai_id
					LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
					LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
					JOIN ruangan_m ruanganasal_m ON pasienkirimkeunitlain_t.create_ruangan = ruanganasal_m.ruangan_id
					JOIN ruangan_m ON pasienkirimkeunitlain_t.ruangan_id = ruangan_m.ruangan_id
					JOIN instalasi_m instalasiasal_m ON ruanganasal_m.instalasi_id = instalasiasal_m.instalasi_id
					WHERE permintaankepenunjang_t.pasienkirimkeunitlain_id = ".$_GET['pasienkirimkeunitlain_id']."
					--ORDER BY permintaankepenunjang_t.pasienkirimkeunitlain_id ASC ";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['permintaankepenunjangs'] = $loadDatas;
			}
			if(isset($_GET['ruangan_id'])){
				$data['jeniskasuspenyakits'] = $this->getJeniskasuspenyakits($_GET['ruangan_id']);
				$data['perawats'] = $this->getPerawat($_GET['ruangan_id']);
				$data['kelaspelayanans'] = $this->getKelaspelayanans($_GET['ruangan_id']);
			}
		}
		
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * menampilkan data pegawai_m (analis lab / radiografer / perawat) berdasarkan ruangan_id
	 */
	protected function getPerawat($ruangan_id){
		$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
				FROM ruanganpegawai_m
				JOIN pegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
				LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				";
				if($ruangan_id == Params::RUANGAN_ID_LAB_KLINIK || $ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
					$sql .= "WHERE pegawai_m.kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_LAB;
				}else if($ruangan_id == Params::RUANGAN_ID_RAD){
					$sql .= "WHERE pegawai_m.kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_RAD;
				}else{
					$sql .= "WHERE pegawai_m.kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
				}
		$sql .= "
				AND pegawai_m.pegawai_aktif = true
				AND ruanganpegawai_m.ruangan_id = ".$ruangan_id."
				ORDER BY pegawai_m.nama_pegawai ASC";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}
	
	/**
	 * transaksi pemeriksaan pasien rujukan agar terdaftar di informasi daftar pasien
	 * MA-438
	 * @param $_GET['pasienmasukpenunjang']
	 * @return json
	 */
	public function actionPeriksaPasienRujukan(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';

		if(isset($_GET['pasienmasukpenunjang'])){
			if(isset($_GET['pasienmasukpenunjang']['pasienkirimkeunitlain_id']))
	        {
				$format = new MyFormatter;
	            $modPasienKirim = MOPasienkirimkeunitlainT::model()->findByPk($_GET['pasienmasukpenunjang']['pasienkirimkeunitlain_id']);
				$modPermintaanDet = MOPermintaankepenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$modPasienKirim->pasienkirimkeunitlain_id));
				$errorTindakan = "";
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$modPasienMasukPenunjang = new MOPasienmasukpenunjangT;
					$modHasilPemeriksaan = new MOHasilpemeriksaanlabT;
					$modPasienMasukPenunjang->attributes = $modPasienKirim->attributes;
					$modPasienMasukPenunjang->pasienadmisi_id = (!empty($modPasienKirim->pendaftaran->pasienadmisi_id) ? $modPasienKirim->pendaftaran->pasienadmisi_id : null) ;
					$modPasienMasukPenunjang->attributes = $_GET['pasienmasukpenunjang'];
					$modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
					$modPasienMasukPenunjang->ruanganasal_id = $modPasienKirim->create_ruangan;
					$modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
					$modPasienMasukPenunjang->kunjungan = CustomFunction::getKunjungan($modPasienKirim->pasien, $modPasienMasukPenunjang->ruangan_id);
					$modPasienMasukPenunjang->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
					$instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
					$kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
					$modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
					$modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
					if($modPasienMasukPenunjang->save()){
						$this->penunjangtersimpan = true;
						$modPasienMasukPenunjang->perawat_id = isset($_GET['pasienmasukpenunjang']['perawat_id']) ? $_GET['pasienmasukpenunjang']['perawat_id']: null;
						$modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasienMasukPenunjang->pasien, $modPasienMasukPenunjang);
						$updatePasienKirim = MOPasienkirimkeunitlainT::model()->updateByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id,array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id));
						if(count((array)$_GET['tindakanpelayanan']) > 0){
							foreach($_GET['tindakanpelayanan'] AS $i => $tindakan){
								if(!empty($tindakan['tindakanpelayanan_id'])){
									$modTindakan = MOTindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
									$modTindakan->attributes = $modPasienMasukPenunjang->attributes;
									$modTindakan->qty_tindakan = $tindakan['qty_tindakan'];
									$modTindakan->tarif_tindakan = ($tindakan['tarif_tindakan']);
									$modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
									$modTindakan->update();
								}else{
									$tindakan['satuantindakan'] = (isset($tindakan['satuantindakan']) ? $tindakan['satuantindakan'] : Params::SATUAN_TINDAKAN_LABORATORIUM);
									$modTindakan = $this->simpanTindakanPelayanan($modPasienMasukPenunjang->pendaftaran, $modPasienMasukPenunjang, $tindakan);
									
									if($this->tindakantersimpan){
										if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
											if(!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)){
												$modHasilPemeriksaanDet = $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $tindakan);
											}
										}else if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
											$modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $tindakan);
										}else if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_FISIOTERAPI){
											$modHasilPemeriksaan = $this->simpanHasilTindakanRehab($modPasienMasukPenunjang, $modTindakan, $tindakan);
										}
									}else{
										$errorTindakan .= CHtml::errorSummary($modTindakan);
									}
								}
							}
						}
					}
					
					
					if($this->penunjangtersimpan && $updatePasienKirim && $this->tindakantersimpan && $this->tindakankomponentersimpan && $this->hasilpemeriksaantersimpan){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data pemeriksaan berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data tindakan gagal disimpan! <br>'.$errorTindakan;
						if(!$this->tindakankomponentersimpan){
							$data['pesan'] = 'Data komponen tindakan gagal disimpan!<br>'.$errorDetail;
						}
						if(!($this->hasilpemeriksaantersimpan)){
							$data['pesan'] = 'Data hasil pemeriksaan gagal disimpan!';
						}
					}
				}catch (Exception $exc) {
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data pemeriksaan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	
	/**
	 * proses simpan tindakan pelayanan dan tindakan komponen
	 */
	public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post){
		$modTindakan = new MOTindakanpelayananT;
		$modTindakan->attributes = $modPendaftaran->attributes;
		$modTindakan->attributes = $modPasienMasukPenunjang->attributes;
		$modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$modTindakan->attributes = $post;
		$modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
		$modTindakan->create_time = date("Y-m-d H:i:s");
		$modTindakan->create_loginpemakai_id = $modPasienMasukPenunjang->create_loginpemakai_id;
		$modTindakan->create_ruangan = $modPasienMasukPenunjang->create_ruangan;
		$modTindakan->shift_id =$this->getShift("shift_id");
		$modTindakan->dokterpemeriksa1_id=$modPasienMasukPenunjang->pegawai_id;
		$modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
		$modTindakan->tgl_tindakan = (!empty($modTindakan->tgl_tindakan) ? $format->formatDateTimeForDb($modTindakan->tgl_tindakan) : date("Y-m-d H:i:s"));
		$modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
		$modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
		$modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
		if($modTindakan->cyto_tindakan){ //true
			$modTindakan->tarifcyto_tindakan = $modTindakan->tarif_tindakan + ($modTindakan->tarif_tindakan * 10 / 100);
		}else{
			$modTindakan->tarifcyto_tindakan = 0;
		}
		$modTindakan->cyto_tindakan=0;
		$modTindakan->tarifcyto_tindakan=0;
		$modTindakan->discount_tindakan=0;
		$modTindakan->pembebasan_tindakan = 0;
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
				$this->tindakantersimpan &= true;
			}
		}else{
			$this->tindakantersimpan &= false;
		}

		return $modTindakan;
	}
	//== Rehab Medis ==

	public function actionSetFormTindakanRehabMedis(){
		return parent::actionSetFormTindakanRehabMedis();
	}

	/**
	 * set form input hasil pemeriksaan rehab medis
	 * MA-315, MA-369
	 * @params: pasienmasukpenunjang_id
	 * @return: hasilpemeriksaanrm
	 */
	public function actionSetFormHasilTindakanRehab(){
		header("content-type:application/json");
		$data = array();
		$data['hasilpemeriksaanrm'] = array();
		if(isset($_GET['pasienmasukpenunjang_id'])){
			$sql = "SELECT hasilpemeriksaanrm_t.*,
					tindakanrm_m.*
				FROM hasilpemeriksaanrm_t
				JOIN tindakanrm_m ON tindakanrm_m.tindakanrm_id = hasilpemeriksaanrm_t.tindakanrm_id
				WHERE hasilpemeriksaanrm_t.pasienmasukpenunjang_id = ".$_GET['pasienmasukpenunjang_id']."
					ORDER BY hasilpemeriksaanrm_t.nohasilrm ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['hasilpemeriksaanrm'] = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form input & ubah pemeriksaan rehab medis
	 * MA-314, MA-369
	 * @params: pasienmasukpenunjang_id
	 * @return: tindakanpelayanan
	 */
	public function actionSetFormUbahTindakanRehab(){
		header("content-type:application/json");
		$data = array();
		$data['tindakanpelayanan'] = array();
		if(isset($_GET['pasienmasukpenunjang_id'])){
			$sql = "SELECT tindakanpelayanan_t.* , tindakanrm_m.*, jenistindakanrm_m.*
				FROM tindakanpelayanan_t
				JOIN daftartindakan_m ON tindakanpelayanan_t.daftartindakan_id = daftartindakan_m.daftartindakan_id
				JOIN tindakanrm_m ON daftartindakan_m.daftartindakan_id = tinda	kanrm_m.daftartindakan_id
				JOIN jenistindakanrm_m ON jenistindakanrm_m.jenistindakanrm_id = tindakanrm_m.jenistindakanrm_id
				WHERE pasienmasukpenunjang_id = ".$_GET['pasienmasukpenunjang_id']."
					AND tindakanpelayanan_t.tindakansudahbayar_id IS NULL";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['tindakanpelayanan'] = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * set form buat jadwal rehab medis
	 * MA-381
	 * @params: ruangan_id
	 * @return: paramedis1s
	 * @return: paramedis2s
	 */
	public function actionSetFormBuatJadwalRehab(){
		header("content-type:application/json");
		$data = array();
		$data['paramedis1s'] = array();
		$data['paramedis2s'] = array();
		if(isset($_GET['ruangan_id'])){
			$ruangan_id = $_GET['ruangan_id'];
			//load paramedis
			$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
				FROM ruanganpegawai_m
				JOIN pegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
				LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				WHERE pegawai_m.kelompokpegawai_id NOT IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.", ".Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN.")
					AND pegawai_m.pegawai_aktif = true
					AND ruanganpegawai_m.ruangan_id = ".$ruangan_id."
				ORDER BY pegawai_m.nama_pegawai ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data['paramedis1s'][$i]['pegawai_id']= $val['pegawai_id'];
					$data['paramedis1s'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai'].", ".$val['gelarbelakang_nama'];
				}
			}
			$data['paramedis2s'] = $data['paramedis1s'];


		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * simpan (update) data hasil pemeriksaan rehab medis
	 * MA-369
	 */
	public function actionHasilRehabMedis(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$error = "";
		if(isset($_GET['hasilpemeriksaanrm'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				foreach($_GET['hasilpemeriksaanrm'] AS $i => $hasil){
					if(isset($hasil['hasilpemeriksaanrm_id'])){
						$model = MOHasilpemeriksaanrmT::model()->findByPk($hasil['hasilpemeriksaanrm_id']);
						$model->tglpemeriksaanrm = $hasil['tglpemeriksaanrm'];
						$model->hasilpemeriksaanrm = $hasil['hasilpemeriksaanrm'];
						$model->keteranganhasilrm = $hasil['keteranganhasilrm'];
						$model->peralatandigunakan = $hasil['peralatandigunakan'];
						$model->update_time = date('Y-m-d H:i:s');
						if($model->update()){
							$this->hasilpemeriksaantersimpan &= true;
						}else{
							$this->hasilpemeriksaantersimpan = false;
							$error .= CHtml::errorSummary($model);
						}
					}
				}
				if($this->hasilpemeriksaantersimpan){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data hasil pemeriksaan berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data hasil pemeriksaan gagal disimpan!'.$error;
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data hasil pemeriksaan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi pemeriksaan rehabilitas medis
	 * MA-211, MA-369
	 * @param $_GET['tindakanpelayanan'] array
	 * @return json
	 */
	public function actionTindakanRehabMedis(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';

		if(isset($_GET['tindakanpelayanan'])){
			if(isset($_GET['pasienmasukpenunjang_id']))
	        {
				$format = new MyFormatter;
	            $modPasienMasukPenunjang = MOPasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
				$errorTindakan = "";
				$errorDetail = "";
				$transaction = Yii::app()->db->beginTransaction();
				try{
					if(count((array)$_GET['tindakanpelayanan']) > 0){
						foreach($_GET['tindakanpelayanan'] AS $i => $tindakan){
							if(empty($tindakan['tindakanpelayanan_id'])){
								$model = new MOTindakanpelayananT;
								$tindakan['satuantindakan'] = (isset($tindakan['satuantindakan']) ? $tindakan['satuantindakan'] : Params::SATUAN_TINDAKAN_REHAB_MEDIS);
								$model = $this->simpanTindakanPelayanan($modPasienMasukPenunjang->pendaftaran, $modPasienMasukPenunjang, $tindakan);

								if($this->tindakantersimpan){
									$modHasilPemeriksaan = $this->simpanHasilTindakanRehab($modPasienMasukPenunjang, $model, $tindakan);
								}else{
									$errorTindakan .= CHtml::errorSummary($model);
								}
							}
						}
					}
					if($this->tindakantersimpan && $this->tindakankomponentersimpan && $this->hasilpemeriksaantersimpan){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data tindakan / pelayanan berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data tindakan gagal disimpan! <br>'.$errorTindakan;
						if(!$this->tindakankomponentersimpan){
							$data['pesan'] = 'Data komponen tindakan / pelayanan gagal disimpan!<br>'.$errorDetail;
						}
						if(!($this->hasilpemeriksaantersimpan)){
							$data['pesan'] = 'Data hasil tindakan gagal disimpan!';
						}
					}
				}catch (Exception $exc) {
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data tindakan / pelayanan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	/**
     * simpan hasil pemeriksaan rehabilitasi medis
	 * MA-369
     */
    public function simpanHasilTindakanRehab($modPasienMasukPenunjang, $modTindakan, $post){
		$modHasilPemeriksaan = new MOHasilpemeriksaanrmT;
        $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
        $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modHasilPemeriksaan->jenistindakanrm_id = $post['jenistindakanrm_id'];
        $modHasilPemeriksaan->tindakanrm_id = $post['tindakanrm_id'];
        $modHasilPemeriksaan->tglpemeriksaanrm = $modPasienMasukPenunjang->tglmasukpenunjang;
        $modHasilPemeriksaan->kunjunganke = 1; //di default untuk kunjungan pertama
        $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
        $modHasilPemeriksaan->create_loginpemakai_id = $modTindakan->create_loginpemakai_id;
        $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
        $modHasilPemeriksaan->nohasilrm = MyGenerator::noHasilPemeriksaanRM();
        if($modHasilPemeriksaan->save()){
            $modTindakan->hasilpemeriksaanrm_id = $modHasilPemeriksaan->hasilpemeriksaanrm_id;
            $modTindakan->save(); //update
            $this->hasilpemeriksaantersimpan &= true;
        }else{
            $this->hasilpemeriksaantersimpan = false;
        }
		return $modHasilPemeriksaan;

    }
	/**
	 * Untuk hapus pemeriksaan rehab
	 * MA-369
	 * @params : 'tindakanpelayanan_id'
	 */
	public function actionHapusTindakanRehab(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['tindakanpelayanan_id'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$tindakanpelayanan_id = $_GET['tindakanpelayanan_id'];
				$hapusdetail = MOTindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan_id));
				$ubah = MOTindakanpelayananT::model()->updateByPk($tindakanpelayanan_id,array('hasilpemeriksaanrm_id'=>null));
				$hapushasil = MOHasilpemeriksaanrmT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan_id));
				$hapus = MOTindakanpelayananT::model()->deleteByPk($tindakanpelayanan_id);
//				BELUM ADA INSERT OBAT >> $hapusObatAlkes = ObatalkespasienT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan_id));
				if($hapus && $hapushasil){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data tindakan / pelayanan gagal dihapus!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	//== End Rehab Medis ==

	//== Laboratorium ==
	public function actionSetFormPemeriksaanLab(){
		return parent::actionSetFormPemeriksaanLab();
	}

	/**
	 * set form input & ubah pemeriksaan laboratorium
	 * MA-320
	 * @params: pasienmasukpenunjang_id
	 * @params: ruangan_id
	 * @return: tindakanpelayanan
	 * @return: perawats //untuk dropdown perawat / analis lab
	 * @return: perawat_id //untuk nilai dropdown perawat / analis lab
	 */
	public function actionSetFormUbahPemeriksaanLab(){
		header("content-type:application/json");
		$data = array();
		$data['tindakanpelayanan'] = array();
		$data['perawats'] = array();
		$data['perawat_id'] = "";
		if(isset($_GET['pasienmasukpenunjang_id']) && isset($_GET['ruangan_id'])){
			$data['perawat_id'] = $this->getPerawatId($_GET['pasienmasukpenunjang_id']);
			$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
				FROM ruanganpegawai_m
				JOIN pegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
				LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				WHERE pegawai_m.kelompokpegawai_id NOT IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.", ".Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN.")
					AND pegawai_m.pegawai_aktif = true
					AND ruanganpegawai_m.ruangan_id = ".$_GET['ruangan_id']."
				ORDER BY pegawai_m.nama_pegawai ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data['perawats'][$i]['pegawai_id']= $val['pegawai_id'];
					$data['perawats'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai'].", ".$val['gelarbelakang_nama'];
				}
			}

			$sql = "SELECT tindakanpelayanan_t.* , pemeriksaanlab_m.*, jenispemeriksaanlab_m.*
				FROM tindakanpelayanan_t
				JOIN daftartindakan_m ON tindakanpelayanan_t.daftartindakan_id = daftartindakan_m.daftartindakan_id
				JOIN pemeriksaanlab_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
				JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
				WHERE pasienmasukpenunjang_id = ".$_GET['pasienmasukpenunjang_id']."
					AND tindakanpelayanan_t.tindakansudahbayar_id IS NULL";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['tindakanpelayanan'] = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * menampilkan perawat_id penunjang
	 * @param type $pasienmasukpenunjang_id
	 */
	public function getPerawatId($pasienmasukpenunjang_id){
		$sql = "SELECT perawat_id
				FROM tindakanpelayanan_t
				WHERE pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id."
					AND perawat_id IS NOT NULL
					AND tindakansudahbayar_id IS NULL
				LIMIT 1";
		$loadData = Yii::app()->db->createCommand($sql)->queryRow();
		if(!empty($loadData['perawat_id'])){
			return $loadData['perawat_id'];
		}else{
			return null;
		}
	}

	/**
	 * transaksi pemeriksaan laboratorium
	 * MA-320
	 * @param $_GET['pasienmasukpenunjang_id']
	 * @param $_GET['tindakanpelayanan'] array
	 * @return json
	 */
	public function actionPemeriksaanLab(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';

		if(isset($_GET['tindakanpelayanan'])){
			if(isset($_GET['pasienmasukpenunjang_id']))
	        {
				$format = new MyFormatter;
	            $modPasienMasukPenunjang = MOPasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
				$modHasilPemeriksaan = MOHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id));

				$errorTindakan = "";
				$errorDetail = "";
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$modPasienMasukPenunjang->perawat_id = $this->getPerawatId($_GET['pasienmasukpenunjang_id']);
					if(isset($_GET['perawat_id'])){
						$modPasienMasukPenunjang->perawat_id = $_GET['perawat_id'];
					}
					if(count((array)$_GET['tindakanpelayanan']) > 0){
						foreach($_GET['tindakanpelayanan'] AS $i => $tindakan){
							if(!empty($tindakan['tindakanpelayanan_id'])){
								$model = MOTindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
								$model->attributes = $modPasienMasukPenunjang->attributes;
                                $model->qty_tindakan = $tindakan['qty_tindakan'];
                                $model->tarif_tindakan = ($tindakan['tarif_tindakan']);
								$model->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                                $model->update();
							}else{
								$tindakan['satuantindakan'] = (isset($tindakan['satuantindakan']) ? $tindakan['satuantindakan'] : Params::SATUAN_TINDAKAN_LABORATORIUM);
								$model = $this->simpanTindakanPelayanan($modPasienMasukPenunjang->pendaftaran, $modPasienMasukPenunjang, $tindakan);

								if($this->tindakantersimpan){
									if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
										if(!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)){
											$modHasilPemeriksaanDet = $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $model, $tindakan);
										}
									}else if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
										$modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $model, $tindakan);
									}
								}else{
									$errorTindakan .= CHtml::errorSummary($model);
								}
							}
						}
					}
					if($this->tindakantersimpan && $this->tindakankomponentersimpan && $this->hasilpemeriksaantersimpan){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data pemeriksaan berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data tindakan gagal disimpan! <br>'.$errorTindakan;
						if(!$this->tindakankomponentersimpan){
							$data['pesan'] = 'Data komponen tindakan gagal disimpan!<br>'.$errorDetail;
						}
						if(!($this->hasilpemeriksaantersimpan)){
							$data['pesan'] = 'Data hasil pemeriksaan gagal disimpan!';
						}
					}
				}catch (Exception $exc) {
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data pemeriksaan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * Untuk hapus pemeriksaan laboratorium
	 * MA-320
	 * @params : 'tindakanpelayanan_id'
	 */
	public function actionHapusPemeriksaanLab(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['tindakanpelayanan_id'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$tindakanpelayanan_id = $_GET['tindakanpelayanan_id'];
				$hapusdetail = MOTindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan_id));
				$ubah = MOTindakanpelayananT::model()->updateByPk($tindakanpelayanan_id,array('detailhasilpemeriksaanlab_id'=>null));
				$hapushasil = MODetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan_id));
				$hapus = MOTindakanpelayananT::model()->deleteByPk($tindakanpelayanan_id);
//				BELUM ADA INSERT OBAT >> $hapusObatAlkes = ObatalkespasienT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan_id));
				if($hapus){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					if(!$hapus)
						$data['pesan'] = 'Data tindakan gagal dihapus!';
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data gagal dihapus!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	* simpan hasil pemeriksaan
	*/
	public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang){
		$modHasilPemeriksaan = new MOHasilpemeriksaanlabT;
		$modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
		$modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
		$modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
		$modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
		if($modHasilPemeriksaan->validate()){
			$modHasilPemeriksaan->save();
		}else{
			$this->hasilpemeriksaantersimpan &= false;
		}
		return $modHasilPemeriksaan;
	}

	/**
     * simpan detail hasil pemeriksaan laboratorium
	 * MA-320
     */
	public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post){
		$modDetailHasilPemeriksaans = array();
		$date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
		$date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
		$umurhari = $date2->diff($date1)->format("%a");
		$criteria = new CDbCriteria;
		$criteria->addCondition('pemeriksaanlab_id = '.$post['pemeriksaanlab_id']);
		$criteria->addCondition("'".$umurhari."' BETWEEN hariminlab AND harimakslab");
		$criteria->compare('LOWER(nilairujukan_jeniskelamin)',strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
		$criteria->order = 'pemeriksaanlabdet_nourut ASC';
		$modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);
		if(count((array)$modPemeriksaanLadDet) > 0){
			foreach($modPemeriksaanLadDet AS $i=>$pemeriksaanDet){
				$modDetailHasilPemeriksaans[$i] = new MODetailhasilpemeriksaanlabT;
				$modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
				$modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
				$modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
				$modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
				$modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
				$modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
				$modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
				$modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
				$modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = $modTindakan->create_loginpemakai_id;
				$modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
				if($modDetailHasilPemeriksaans[$i]->validate()){
					$modDetailHasilPemeriksaans[$i]->save();
				}else{
					$this->hasilpemeriksaantersimpan &= false;
				}
			}
		}
		return $modDetailHasilPemeriksaans;
	}
	
	/**
	 * simpan hasil pemeriksaan lab anatomi
	 */
	public function simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $post){
		$modHasilPemeriksaanPA = new MOHasilpemeriksaanpaT;
		$modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
		$modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
		$modHasilPemeriksaanPA->nosediaanpa = MyGenerator::noSediaanPA();
		$modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
		$modHasilPemeriksaanPA->create_loginpemakai_id = $modTindakan->create_loginpemakai_id;
		$modHasilPemeriksaanPA->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

		if($modHasilPemeriksaanPA->validate()){
			$modHasilPemeriksaanPA->save();
			$modTindakan->hasilpemeriksaanpa_id = $modHasilPemeriksaanPA->hasilpemeriksaanpa_id;
			$modTindakan->update();
		}else{
			$this->hasilpemeriksaantersimpan = false;
		}

	}
	/**
	 * set form untuk pengambilan / kirim sampel lab (multi sampel)
	 * MA-320, MA-428
	 * @params pasienmasukpenunjang_id
	 * @return pengambilansamples //sampel yg sudah diinputkan sebelumnya
	 * @return samplelabs //untuk dropdown sample
	 * @return labklinikrujukans //untuk dropdown rujukan lab
	 */
	public function actionSetFormPengambilanSample(){
		header("content-type:application/json");
		$data = array();
		$data['pengambilansamples'] = array();
		$data['samplelabs'] = array();
		$data['labklinikrujukans'] = array();
		if(isset($_GET['pasienmasukpenunjang_id'])){
			$sql = "SELECT samplelab_id, samplelab_nama
				FROM samplelab_m
				WHERE samplelab_aktif = TRUE
				ORDER BY samplelab_nama ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['samplelabs'] = $loadDatas;
			}
			$sql = "SELECT labklinikrujukan_id, labklinikrujukan_nama
				FROM labklinikrujukan_m
				WHERE labklinikrujukan_aktif = TRUE
				ORDER BY labklinikrujukan_nama ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['labklinikrujukans'] = $loadDatas;
			}
			$sql = "SELECT *
				FROM pengambilansample_t
				WHERE pasienmasukpenunjang_id = ".$_GET['pasienmasukpenunjang_id'];
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data['pengambilansamples'][$i] = $val;
					$sql = "SELECT *
						FROM kirimsamplelab_t
						WHERE pengambilansample_id = ".$val['pengambilansample_id'];
					$loadData = Yii::app()->db->createCommand($sql)->queryRow();
					$data['kirimsamplelab'][$i] = array();
					if($loadData){
						$data['kirimsamplelab'][$i] = $loadData;
					}
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * simpan (update) data pengambilan / kirim sample
	 * MA-320
	 * @params pasienmasukpenunjang_id
	 * @params pengambilansample = array()
	 */
	public function actionPengambilanSample(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$error = "";
		$format = new MyFormatter();
		if(isset($_GET['pasienmasukpenunjang_id']) && isset($_GET['pengambilansample'])){
			$transaction = Yii::app()->db->beginTransaction();
			$sampletersimpan = true; //looping
			try{
				foreach($_GET['pengambilansample'] AS $i => $sample){
					if(!empty($sample['pengambilansample_id'])){
						$model = MOPengambilansampleT::model()->findByPk($sample['pengambilansample_id']);
						$model->samplelab_id = $sample['samplelab_id'];
						$model->tglpengambilansample = $format->formatDateTimeForDb($sample['tglpengambilansample']);
						$model->jmlpengambilansample = $sample['jmlpengambilansample'];
						$model->tempatsimpansample = $sample['tempatsimpansample'];
						$model->keterangansample = $sample['keterangansample'];
						$model->update_loginpemakai_id = $sample['update_loginpemakai_id'];
						$model->update_time = date('Y-m-d H:i:s');
						if($model->update()){
							$sampletersimpan &= true;
						}else{
							$sampletersimpan = false;
							$error .= CHtml::errorSummary($model);
						}
					}else{
						$model = new MOPengambilansampleT;
						$model->attributes = $sample;
						$model->tglpengambilansample = $format->formatDateTimeForDb($sample['tglpengambilansample']);
						$model->jmlpengambilansample = $sample['jmlpengambilansample'];
						$model->no_pengambilansample = MyGenerator::noPengambilanSample($model->alatmedis_id);
						$model->pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
						$model->create_time = date('Y-m-d H:i:s');
						if($model->save()){
							$sampletersimpan &= true;
						}else{
							$sampletersimpan = false;
							$error .= CHtml::errorSummary($model);
						}
					}
					if(isset($_GET['kirimsamplelab'][$i]['is_kirimsample'])){
						if(empty($_GET['kirimsamplelab'][$i]['kirimsamplelab_id'])){
							$modKirim = new MOKirimsamplelabT;
							$modKirim->create_time = date("Y-m-d H:i:s");
							$modKirim->pengambilansample_id = $model->pengambilansample_id;
						}else{
							$modKirim = MOKirimsamplelabT::model()->findByPk($_GET['kirimsamplelab'][$i]['kirimsamplelab_id']);
							$modKirim->update_time = date("Y-m-d H:i:s");
						}
						$modKirim->attributes = $_GET['kirimsamplelab'][$i];
						$modKirim->tglkirimsample = $format->formatDateTimeForDb($modKirim->tglkirimsample);
						if($modKirim->save()){
							$sampletersimpan &= true;
						}else{
							$sampletersimpan = false;
							$error .= CHtml::errorSummary($modKirim);
						}
					}
					
				}
				if($sampletersimpan){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data sampel lab berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data sampel lab gagal disimpan!'.$error;
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data sampel lab gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	
	/**
	 * Untuk hapus sampel lab
	 * MA-320
	 * @params : 'pengambilansample_id'
	 */
	public function actionHapusSampleLab(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pengambilansample_id'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$hapusKirim = MOKirimsamplelabT::model()->deleteAllByAttributes(array('pengambilansample_id'=>$_GET['pengambilansample_id']));
				$hapus = MOPengambilansampleT::model()->deleteByPk($_GET['pengambilansample_id']);
				if($hapus){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data gagal dihapus!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form input hasil pemeriksaan laboratorium
	 * MA-320
	 * @params: pasienmasukpenunjang_id
	 * @return: hasilpemeriksaanlab
	 * @return: detailhasilpemeriksaanlab = array
	 */
	public function actionSetFormHasilPemeriksaanLab(){
		header("content-type:application/json");
		$data = array();
		$data['hasilpemeriksaanlab'] = array();
		$data['detailhasilpemeriksaanlab'] = array();
		if(isset($_GET['pasienmasukpenunjang_id'])){
			$sql = "SELECT hasilpemeriksaanlab_t.*
				FROM hasilpemeriksaanlab_t
				WHERE hasilpemeriksaanlab_t.pasienmasukpenunjang_id = ".$_GET['pasienmasukpenunjang_id'];
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if($loadData){
				$data['hasilpemeriksaanlab'] = $loadData;
				$sql = "SELECT detailhasilpemeriksaanlab_t.*, pemeriksaanlab_m.pemeriksaanlab_nama, nilairujukan_m.* 
					FROM detailhasilpemeriksaanlab_t
					JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id
					JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = detailhasilpemeriksaanlab_t.pemeriksaanlab_id
					JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
					WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = ".$loadData['hasilpemeriksaanlab_id']."
					ORDER BY detailhasilpemeriksaanlab_t.detailhasilpemeriksaanlab_id ASC";
				$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
				if(count((array)$loadDatas) > 0){
					$data['detailhasilpemeriksaanlab'] = $loadDatas;
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * simpan (update) data hasil pemeriksaan laboratorium
	 * MA-320
	 */
	public function actionHasilPemeriksaanLab(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$error = "";
		$format = new MyFormatter();
		if(isset($_GET['hasilpemeriksaanlab'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$modelPemeriksaan = MOHasilpemeriksaanlabT::model()->findByPk($_GET['hasilpemeriksaanlab']['hasilpemeriksaanlab_id']);
				$modelPemeriksaan->tglhasilpemeriksaanlab = $format->formatDateTimeForDb($_GET['hasilpemeriksaanlab']['tglhasilpemeriksaanlab']);
				$modelPemeriksaan->tglpengambilanhasil = $format->formatDateTimeForDb($_GET['hasilpemeriksaanlab']['tglpengambilanhasil']);
				$modelPemeriksaan->kesimpulan = $_GET['hasilpemeriksaanlab']['kesimpulan'];
				$modelPemeriksaan->catatanlabklinik = $_GET['hasilpemeriksaanlab']['catatanlabklinik'];
				$modelPemeriksaan->statusperiksahasil = $_GET['hasilpemeriksaanlab']['statusperiksahasil'];
				$modelPemeriksaan->update_time = date('Y-m-d H:i:s');
				if($modelPemeriksaan->update()){
					$this->hasilpemeriksaantersimpan = true;
				}else{
					$this->hasilpemeriksaantersimpan = false;
					$error .= CHtml::errorSummary($modelPemeriksaan);
				}
				if(isset($_GET['detailhasilpemeriksaanlab'])){
					foreach($_GET['detailhasilpemeriksaanlab'] AS $i => $hasil){
						$model = MODetailhasilpemeriksaanlabT::model()->findByPk($hasil['detailhasilpemeriksaanlab_id']);
						$model->hasilpemeriksaan = $hasil['hasilpemeriksaan'];
						$model->nilairujukan = $hasil['nilairujukan'];
						$model->hasilpemeriksaan_satuan = $hasil['hasilpemeriksaan_satuan'];
						$model->hasilpemeriksaan_metode = $hasil['hasilpemeriksaan_metode'];
						$model->update_time = date('Y-m-d H:i:s');
						if($model->update()){
							$this->hasilpemeriksaantersimpan &= true;
						}else{
							$this->hasilpemeriksaantersimpan = false;
							$error .= CHtml::errorSummary($model);
						}
					}
				}
				if($this->hasilpemeriksaantersimpan){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data hasil pemeriksaan berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data hasil pemeriksaan gagal disimpan!'.$error;
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data hasil pemeriksaan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	//== End Laboratorium ==
}
