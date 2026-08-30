<?php
/**
 * class ini digunakan untuk bridging mobile apps dengan sistem utama
 */
ini_set('memory_limit', '128M');
Yii::import('rawatJalan.controllers.DaftarPasienController');

class MDokterBridgingController extends MyMobileAuthController
{
		public $defaultAction = "Index";
	public $layout = "//layouts/iframe";


	public function actionIndex()
	{
		$this->render('index');
	}


	/**
	 * transaksi anamnesa
	 * MA-91, MA-246
	 * @param $_GET['anamnesa'] array
	 * @return json
	 */
	public function actionAnamnesa(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['anamnesa'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model = new MOAnamnesaT;
				$model->attributes = $_GET['anamnesa'];
				if(!empty($model->anamesa_id)){
					$model = MOAnamnesaT::model()->findByPk($model->anamesa_id);
					$model->update_time = date("Y-m-d H:i:s");
				}else{
					$model->anamesa_id = null; //agar auto sequence tidak error
				}
				$model->create_time = date("Y-m-d H:i:s");
				if($model->save()){
					MOPendaftaranT::model()->updateByPk($model->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>$model->create_loginpemakai_id));
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data anamnesa berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data anamnesa gagal disimpan! <br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data anamnesa gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form anamnesa (pertama load)
	 * MA-98, MA-246
	 * @params: ruangan_id, pendaftaran_id, pasienadmisi_id
	 * @return:
	 * -
	 */
	public function actionSetFormAnamnesa(){
		header("content-type:application/json");
		$data = array();
		$data['paramedis'] = array();
		$data['anamnesa'] = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id'])){
			$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
				FROM pegawai_m
				JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
				LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				WHERE pegawai_m.kelompokpegawai_id <> 1
					AND ruanganpegawai_m.ruangan_id = ".$_GET['ruangan_id'];
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data['paramedis'][$i]['pegawai_id'] = $val['pegawai_id'];
					$data['paramedis'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai'].", ".$val['gelarbelakang_nama'];
				}
			}

			$sql = "SELECT *
					FROM anamnesa_t
					WHERE pendaftaran_id = ".$_GET['pendaftaran_id'].
					 (!empty($_GET['pasienadmisi_id']) ? " AND pasienadmisi_id = ".$_GET['pasienadmisi_id'] : "");
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if($loadData){
				$data['anamnesa'] = $loadData;
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * untuk dialog diagnosa
	 * MA-99
	 * @param : q , diagnosa_imunisasi
	 */
	public function actionSetDialogDiagnosa(){
		header("content-type:application/json");
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$diagnosa_imunisasi = (isset($_GET['diagnosa_imunisasi']) ? "TRUE" : "FALSE");
		$data = array();
		$sql = "SELECT *
				FROM diagnosa_m
				WHERE
					diagnosa_aktif = TRUE AND diagnosa_imunisasi = ".$diagnosa_imunisasi."
					AND (LOWER(diagnosa_kode) like '%".$req."%'
						OR LOWER(diagnosa_nama) like '%".$req."%')
				LIMIT 5";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data = $loadDatas;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * untuk set form pencarian informasi daftar pasien
	 * MA-101
	 * @params : pegawai_id
	 */
	public function actionSetFormDaftarPasien(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['pegawai_id'])){
			//ruangan dan instalasi
			$sql = "SELECT instalasi_m.instalasi_id, instalasi_m.instalasi_nama, ruangan_m.ruangan_id, ruangan_m.ruangan_nama
					FROM ruanganpegawai_m
					JOIN ruangan_m ON ruangan_m.ruangan_id = ruanganpegawai_m.ruangan_id
					JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id
					WHERE ruangan_m.ruangan_aktif = TRUE
						AND ruanganpegawai_m.pegawai_id = ".$_GET['pegawai_id']."
					ORDER BY instalasi_m.instalasi_nama ASC, ruangan_m.ruangan_nama ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $ii => $val){
					$data['ruangans'][$val['ruangan_id']]['ruangan_id'] = $val['ruangan_id'];
					$data['ruangans'][$val['ruangan_id']]['ruangan_nama'] = $val['ruangan_nama'];
					$data['ruangans'][$val['ruangan_id']]['instalasi_id'] = $val['instalasi_id'];
					$data['instalasis'][$val['instalasi_id']]['instalasi_id'] = $val['instalasi_id'];
					$data['instalasis'][$val['instalasi_id']]['instalasi_nama'] = $val['instalasi_nama'];
				}
			}
			//status periksa
			$sql = "SELECT lookup_name, lookup_value
				FROM lookup_m
				WHERE LOWER(lookup_type) = 'statusperiksa'
					AND lookup_aktif = TRUE
				ORDER BY lookup_urutan ASC, lookup_name ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			$data['statusperiksas'] = $loadDatas;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menampilkan semua data pasien
	 * MA-297
	 */
	public function actionGetDataPasien(){
		header("content-type:application/json");
		$data = array();
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$limit = (isset($_GET['limit']) ? $_GET['limit'] : 9);
		$offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
		$sql = "SELECT pasien_m.*,
					propinsi_m.propinsi_nama,
					kabupaten_m.kabupaten_nama,
					kecamatan_m.kecamatan_nama,
					kelurahan_m.kelurahan_nama,
					pekerjaan_m.pekerjaan_nama
				FROM pasien_m
				JOIN propinsi_m ON pasien_m.propinsi_id = propinsi_m.propinsi_id
				JOIN kabupaten_m ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id
				JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
				LEFT JOIN kelurahan_m ON pasien_m.kelurahan_id = kelurahan_m.kelurahan_id
				LEFT JOIN pekerjaan_m ON pasien_m.pekerjaan_id = pekerjaan_m.pekerjaan_id
				WHERE (
					LOWER(pasien_m.no_rekam_medik) like '%".$req."%'
					OR LOWER(pasien_m.no_identitas_pasien) like '%".$req."%'
					OR LOWER(pasien_m.nama_pasien) like '%".$req."%'
					OR LOWER(pasien_m.nama_bin) like '%".$req."%'
				)
				ORDER BY pasien_m.no_rekam_medik ASC, pasien_m.nama_pasien ASC
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
	 * menampilkan daftar pasien rawat jalan, rawat darurat, rawat inap dan penunjang
	 * MA-103
	 * @param : pegawai_id, instalasi_id, ruangan_id, statusperiksa, q
	 */
	public function actionGetDaftarPasien(){
		header("content-type:application/json");
		$data = array();
		if($_GET['instalasi_id'] == Params::INSTALASI_ID_RJ){
			$data = $this->getDaftarPasienRJ();
		}else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RD){
			$data = $this->getDaftarPasienRD();
		}else if($_GET['instalasi_id'] == Params::INSTALASI_ID_RI){
			$data = $this->getDaftarPasienRI();
		}else{
			$data = $this->getDaftarPasienPenunjang();
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * menampilkan daftar pasien rawat jalan
	 * @return type
	 */
	protected function getDaftarPasienRJ(){
		$data = array();
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$limit = (isset($_GET['limit']) ? $_GET['limit'] : 9);
		$offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
		$sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa, pendaftaran_t.panggilantrian,
					pasien_m.pasien_id, pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pendaftaran_t.umur, pendaftaran_t.kelompokumur_id, pendaftaran_t.golonganumur_id, pasien_m.photopasien,
					ruangan_m.ruangan_id, ruangan_m.ruangan_nama,
					kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama,
					jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
					carabayar_m.carabayar_id, carabayar_m.carabayar_nama,
					penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama
				FROM pendaftaran_t
				JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
				LEFT JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = pendaftaran_t.jeniskasuspenyakit_id
				JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
				JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = pendaftaran_t.kelaspelayanan_id
				JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				WHERE
					pendaftaran_t.pegawai_id = ".$_GET['pegawai_id']."
					AND ruangan_m.instalasi_id = ".$_GET['instalasi_id']
					.(!empty($_GET['ruangan_id']) ? " AND ruangan_m.ruangan_id = ".$_GET['ruangan_id'] : " ")."
					AND DATE(pendaftaran_t.tgl_pendaftaran) = '".date("Y-m-d")."'
					AND (
						LOWER(pasien_m.no_rekam_medik) like '%".$req."%'
						OR LOWER(pasien_m.nama_pasien) like '%".$req."%'
						OR LOWER(pendaftaran_t.no_urutantri) like '%".$req."%'
						OR LOWER(pendaftaran_t.no_pendaftaran) like '%".$req."%'
						OR LOWER(kelaspelayanan_m.kelaspelayanan_nama) like '%".$req."%'
					)
					".(!empty($_GET['statusperiksa']) ? "AND LOWER(pendaftaran_t.statusperiksa) like '%".strtolower($_GET['statusperiksa'])."%'" : "")."
				ORDER BY pendaftaran_t.no_urutantri ASC, pendaftaran_t.statusperiksa ASC
				LIMIT ".$limit."
				OFFSET ".$offset;

		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$i] = $val;
				$data[$i]['photopasien'] = (!empty($val['photopasien']) ? Params::pathPasienTumbsDirectory().$val['photopasien'] : "");
			}
		}
		return $data;
	}
	/**
	 * menampilkan daftar pasien rawat darurat
	 * MA-105
	 * @return type
	 */
	protected function getDaftarPasienRD(){
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$data = array();
		$limit = (isset($_GET['limit']) ? $_GET['limit'] : 9);
		$offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
		$sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_urutantri, pendaftaran_t.statusperiksa,
					pasien_m.pasien_id, pasien_m.no_rekam_medik, pasien_m.namadepan, pasien_m.nama_pasien, pendaftaran_t.umur, pendaftaran_t.kelompokumur_id, pendaftaran_t.golonganumur_id, pasien_m.photopasien,
					ruangan_m.ruangan_id, ruangan_m.ruangan_nama,
					kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama,
					jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, statusmasuk, transportasi, keadaanmasuk,
					carabayar_m.carabayar_id, carabayar_m.carabayar_nama,
					penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama
				FROM pendaftaran_t
				JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
				LEFT JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = pendaftaran_t.jeniskasuspenyakit_id
				JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
				JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = pendaftaran_t.kelaspelayanan_id
				JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				WHERE
					pendaftaran_t.pegawai_id = ".$_GET['pegawai_id']."
					AND ruangan_m.instalasi_id = ".$_GET['instalasi_id']
					.(!empty($_GET['ruangan_id']) ? " AND ruangan_m.ruangan_id = ".$_GET['ruangan_id'] : " ")."
					AND (
						LOWER(pasien_m.no_rekam_medik) like '%".$req."%'
						OR LOWER(pasien_m.nama_pasien) like '%".$req."%'
						OR LOWER(pendaftaran_t.no_pendaftaran) like '%".$req."%'
						OR LOWER(kelaspelayanan_m.kelaspelayanan_nama) like '%".$req."%'
					)
					".(!empty($_GET['statusperiksa']) ? "AND LOWER(pendaftaran_t.statusperiksa) like '%".strtolower($_GET['statusperiksa'])."%'" : "")."
				ORDER BY pendaftaran_t.tgl_pendaftaran ASC, pendaftaran_t.statusperiksa ASC
				LIMIT ".$limit."
				OFFSET ".$offset;
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$i] = $val;
				$data[$i]['photopasien'] = (!empty($val['photopasien']) ? Params::pathPasienTumbsDirectory().$val['photopasien'] : "");
			}
		}
		return $data;
	}
	/**
	 * menampilkan daftar pasien rawat inap
	 * MA-105
	 * @return type
	 */
	protected function getDaftarPasienRI(){
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$data = array();
		$limit = (isset($_GET['limit']) ? $_GET['limit'] : 9);
		$offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
		$sql = "SELECT pasienadmisi_t.pasienadmisi_id, pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.statusperiksa,
					pasien_m.pasien_id, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.jeniskelamin, pendaftaran_t.umur, pendaftaran_t.kelompokumur_id, pendaftaran_t.golonganumur_id, pasien_m.photopasien,
					ruangan_m.ruangan_id, ruangan_m.ruangan_nama, kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed,
					kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama,
					jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
					carabayar_m.carabayar_id, carabayar_m.carabayar_nama,
					penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama,
					masukkamar_t.nomasukkamar, masukkamar_t.tglmasukkamar
				FROM masukkamar_t
				JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
				JOIN pasien_m ON pasien_m.pasien_id = pasienadmisi_t.pasien_id
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
				JOIN ruangan_m ON ruangan_m.ruangan_id = masukkamar_t.ruangan_id
				JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = masukkamar_t.kelaspelayanan_id
				JOIN carabayar_m ON carabayar_m.carabayar_id = masukkamar_t.carabayar_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = masukkamar_t.penjamin_id
				LEFT JOIN kamarruangan_m ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
				LEFT JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = pendaftaran_t.jeniskasuspenyakit_id
				WHERE
					masukkamar_t.pegawai_id = ".$_GET['pegawai_id']."
					AND ruangan_m.instalasi_id = ".$_GET['instalasi_id']
					.(!empty($_GET['ruangan_id']) ? " AND ruangan_m.ruangan_id = ".$_GET['ruangan_id'] : " ")."
					AND (
						LOWER(pasien_m.no_rekam_medik) like '%".$req."%'
						OR LOWER(pasien_m.nama_pasien) like '%".$req."%'
						OR LOWER(pendaftaran_t.no_pendaftaran) like '%".$req."%'
						OR LOWER(kamarruangan_m.kamarruangan_nokamar) like '%".$req."%'
						OR LOWER(kamarruangan_m.kamarruangan_nobed) like '%".$req."%'
						OR LOWER(kelaspelayanan_m.kelaspelayanan_nama) like '%".$req."%'
					)
					".(!empty($_GET['statusperiksa']) ? "AND LOWER(pendaftaran_t.statusperiksa) like '%".strtolower($_GET['statusperiksa'])."%'" : "")."
				ORDER BY masukkamar_t.tglmasukkamar ASC
				LIMIT ".$limit."
				OFFSET ".$offset;
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$i] = $val;
				$data[$i]['photopasien'] = (!empty($val['photopasien']) ? Params::pathPasienTumbsDirectory().$val['photopasien'] : "");
			}
		}
		return $data;
	}
	/**
	 * menampilkan daftar pasien penunjang
	 * MA-105
	 * @return type
	 */
	protected function getDaftarPasienPenunjang(){
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$data = array();
		$limit = (isset($_GET['limit']) ? $_GET['limit'] : 9);
		$offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
		$sql = "SELECT pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.tglmasukpenunjang, pasienmasukpenunjang_t.no_urutperiksa, pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.panggilantrian, pendaftaran_t.pendaftaran_id, pendaftaran_t.pasienadmisi_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,
					pasien_m.pasien_id, pasien_m.namadepan, pasien_m.nama_pasien, pasien_m.jeniskelamin, pendaftaran_t.umur, pendaftaran_t.kelompokumur_id, pendaftaran_t.golonganumur_id, pasien_m.photopasien,
					ruangan_m.ruangan_id, ruangan_m.ruangan_nama,
					kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama,
					jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
					carabayar_m.carabayar_id, carabayar_m.carabayar_nama,
					penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama
				FROM pasienmasukpenunjang_t
				JOIN pasien_m ON pasien_m.pasien_id = pasienmasukpenunjang_t.pasien_id
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
				LEFT JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = pasienmasukpenunjang_t.jeniskasuspenyakit_id
				JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
				JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = pasienmasukpenunjang_t.kelaspelayanan_id
				JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				WHERE
					AND pasienmasukpenunjang_t.pegawai_id = ".$_GET['pegawai_id']."
					AND DATE(pasienmasukpenunjang_t.tglmasukpenunjang) = '".date("Y-m-d")."'
					AND ruangan_m.instalasi_id = ".$_GET['instalasi_id']
					.(!empty($_GET['ruangan_id']) ? " AND ruangan_m.ruangan_id = ".$_GET['ruangan_id'] : " ")."
					AND (
						LOWER(pasien_m.no_rekam_medik) like '%".$req."%'
						OR LOWER(pasien_m.nama_pasien) like '%".$req."%'
						OR LOWER(pendaftaran_t.no_pendaftaran) like '%".$req."%'
						OR LOWER(pasienmasukpenunjang_t.no_masukpenunjang) like '%".$req."%'
						OR LOWER(kelaspelayanan_m.kelaspelayanan_nama) like '%".$req."%'
					)
					".(!empty($_GET['statusperiksa']) ? "AND LOWER(pendaftaran_t.statusperiksa) like '%".strtolower($_GET['statusperiksa'])."%'" : "")."
				ORDER BY pasienmasukpenunjang_t.tglmasukpenunjang, pasienmasukpenunjang_t.no_urutperiksa ASC
				LIMIT ".$limit."
				OFFSET ".$offset;
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$i] = $val;
				$data[$i]['photopasien'] = (!empty($val['photopasien']) ? Params::pathPasienTumbsDirectory().$val['photopasien'] : "");
			}
		}
		return $data;
	}

	/**
	 * panggil pasien ke poliklinik / penunjang
	 * MA-367
	 * @param $_GET['instalasi_id'] not null
	 * @param $_GET['pendaftaran_id'] not null
	 * @param $_GET['pasienmasukpenunjang_id']
	 * @return json
	 */
	public function actionPanggilPasien(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['instalasi_id']) && isset($_GET['pendaftaran_id'])){
			if($_GET['instalasi_id'] == Params::INSTALASI_ID_RJ){
				$data = $this->actionPanggilPasienPoliklinik($_GET['pendaftaran_id']);
			}else{
				if(isset($_GET['pasienmasukpenunjang_id'])){
					$data = $this->actionPanggilPasienPenunjang($_GET['pasienmasukpenunjang_id']);
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * panggil pasien ke penunjang
	 * MA-367
	 * @param $pasienmasukpenunjang_id
	 * @return json
	 */
	public function actionPanggilPasienPenunjang($pasienmasukpenunjang_id){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$updatePenunjang = MOPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
			$updatePenunjang->panggilantrian = TRUE;
			$updatePenunjang->update_time = date("Y-m-d H:i:s");
			if($updatePenunjang->update()){
				$transaction->commit();
				$data['sukses'] = 1;
				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
				$data_telnet = $updatePenunjang->ruangan->ruangan_nama.", ".$updatePenunjang->ruangan->ruangan_singkatan."-".$updatePenunjang->no_urutperiksa;
				DaftarPasienController::postTelnet($data_telnet);
			}else{
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!<br>'.CHtml::errorSummary($updatePenunjang);
			}
		}catch (Exception $exc) {
			$transaction->rollback();
			$data['sukses'] = 0;
			$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
		}
		return $data;
	}
	/**
	 * panggil pasien ke poliklinik
	 * MA-157
	 * @param $pendaftaran_id
	 * @return json
	 */
	public function actionPanggilPasienPoliklinik($pendaftaran_id){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$transaction = Yii::app()->db->beginTransaction();
		try{
			$updatePendaftaran = MOPendaftaranT::model()->findByPk($pendaftaran_id);
			$updatePendaftaran->panggilantrian = TRUE;
			$updatePendaftaran->update_time = date("Y-m-d H:i:s");
			if($updatePendaftaran->update()){
				$transaction->commit();
				$data['sukses'] = 1;
				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
				$data_telnet = $updatePendaftaran->ruangan->ruangan_nama.", ".$updatePendaftaran->ruangan->ruangan_singkatan."-".$updatePendaftaran->no_urutantri;
				DaftarPasienController::postTelnet($data_telnet);
			}else{
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!<br>'.CHtml::errorSummary($updatePendaftaran);
			}
		}catch (Exception $exc) {
			$transaction->rollback();
			$data['sukses'] = 0;
			$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
		}
		return $data;
	}
	/**
	 * rencana kontrol pasien ke poliklinik
	 * MA-158
	 * @param $_GET['pendaftaran_id']
	 * @param $_GET['tglrenkontrol']
	 * @return json
	 */
	public function actionRencanaKontrol(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pendaftaran_id']) && isset($_GET['tglrenkontrol'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$updatePendaftaran = MOPendaftaranT::model()->updateByPk($_GET['pendaftaran_id'],array('tglrenkontrol'=>$format->formatDateTimeForDb($_GET['tglrenkontrol']),'update_time'=>date("Y-m-d H:i:s")));
				if($updatePendaftaran){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data rencana kontrol berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rencana kontrol gagal disimpan!<br>'.CHtml::errorSummary($updatePendaftaran);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rencana kontrol gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form anamnesa (pertama load)
	 * MA-92, MA-247
	 * @params: ruangan_id
	 * @return:
	 * -
	 */
	public function actionSetFormPemeriksaanFisik(){
		header("content-type:application/json");
		$data = array();
		$data['pemeriksaanfisik'] = array();
		$data['paramedis'] = array();
		$data['denyutjantungs'] = array();
		$data['gcs_eyes'] = array();
		$data['gcs_motoriks'] = array();
		$data['gcs_verbals'] = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id'])){
			$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
				FROM pegawai_m
				JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
				LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				WHERE pegawai_m.kelompokpegawai_id <> 1
					AND ruanganpegawai_m.ruangan_id = ".$_GET['ruangan_id'];
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data['paramedis'][$i]['pegawai_id'] = $val['pegawai_id'];
					$data['paramedis'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai'].", ".$val['gelarbelakang_nama'];
				}
			}
			$sql = "SELECT lookup_m.lookup_name, lookup_m.lookup_value
				FROM lookup_m
				WHERE LOWER(lookup_m.lookup_type) = '".strtolower(Params::LOOKUPTYPE_DENYUTJANTUNG)."'
					AND lookup_m.lookup_aktif = TRUE
				ORDER BY lookup_m.lookup_urutan ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data['denyutjantungs'][$i] = $val;
				}
			}
			$sql = "SELECT metodegcs_nama, metodegcs_nilai, metodegcs_singkatan
				FROM metodegcs_m
				WHERE LOWER(metodegcs_m.metodegcs_singkatan) IN ('e','m','v')
				AND metodegcs_aktif = TRUE
				ORDER BY metodegcs_nama ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					if(strtolower($val['metodegcs_singkatan']) == 'e'){
						$data['gcs_eyes'][$i] = $val;
					}else if(strtolower($val['metodegcs_singkatan']) == 'm'){
						$data['gcs_motoriks'][$i] = $val;
					}else if(strtolower($val['metodegcs_singkatan']) == 'v'){
						$data['gcs_verbals'][$i] = $val;
					}
				}
			}

			$sql = "SELECT *
					FROM pemeriksaanfisik_t
					WHERE pendaftaran_id = ".$_GET['pendaftaran_id'].
					 (!empty($_GET['pasienadmisi_id']) ? " AND pasienadmisi_id = ".$_GET['pasienadmisi_id'] : "");
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if($loadData){
				$data['pemeriksaanfisik'] = $loadData;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * get gcs
	 * MA-92,
	 * @params: gcs_eye, gcs_motorik, gcs_verbal (harus semua terisi)
	 * @return:
	 * -
	 */
	public function actionGetGCS(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['gcs_eye']) && isset($_GET['gcs_motorik']) && isset($_GET['gcs_verbal'])){
			$gcs_eye=$_GET['gcs_eye'];
			$gcs_motorik=$_GET['gcs_motorik'];
			$gcs_verbal=$_GET['gcs_verbal'];
			$jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
			$sql = "SELECT gcs_id, gcs_nama
				FROM gcs_m
				WHERE ".$jumlah." >= gcs_nilaimin
					AND ".$jumlah." <= gcs_nilaimax
					AND gcs_aktif = TRUE";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if($loadData){
				$data = $loadData;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * get hasil tekanan darah
	 * MA-172,
	 * @params: diastolic, systolic (harus terisi)
	 * @return:
	 * -
	 */
	public function actionGetHasilTekananDarah(){
		header("content-type:application/json");
		$data = array();

		if(isset($_GET['systolic']) && isset($_GET['diastolic'])){
			$systolic = $_GET['systolic'];
			$diastolic = $_GET['diastolic'];
			$meanarteripressure = ($systolic+(2*$diastolic))/3;
			$sql = "SELECT sysdia_id, sysdia_nama
				FROM sysdia_m
				WHERE ".$systolic." >= systolic_min
					AND ".$systolic." < (systolic_max + 1)
					AND ".$diastolic." >= diastolic_min
					AND ".$diastolic." < (diastolic_max + 1)
					AND sysdia_aktif = TRUE";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if($loadData){
				$data = $loadData;
				$data['meanarteripressure'] = $meanarteripressure;
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * get BMI (Body Mass Index)
	 * MA-172,
	 * @params: tinggibadan_cm, beratbadan_kg, pasien_id
	 * @return:
	 * -
	 */
	public function actionGetBMI(){
		header("content-type:application/json");
		$data = array();

		if(isset($_GET['tinggibadan_cm']) && isset($_GET['beratbadan_kg']) && isset($_GET['pasien_id'])){
			$tinggibadan_cm = (float)$_GET['tinggibadan_cm'];
			$beratbadan_kg = (float)$_GET['beratbadan_kg'];
			$bmi = ($beratbadan_kg/(($tinggibadan_cm*$beratbadan_kg)/10000));
			$sql = "SELECT nama_pasien, jeniskelamin
				FROM pasien_m
				WHERE pasien_id = ".$_GET['pasien_id'];
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();

			if(strtolower(trim($loadData['jeniskelamin'])) == strtolower(trim(Params::JENIS_KELAMIN_PEREMPUAN))){
				$bb_ideal = ($tinggibadan_cm - 100) - ((15/100)*($tinggibadan_cm-100));
			}else{
				$bb_ideal = ($tinggibadan_cm - 100) - ((10/100)*($tinggibadan_cm-100));
			}

			$sql = "SELECT bodymassindex_id, bmi_sign, bmi_defenisi, bmi_pesan
				FROM bodymassindex_m
				WHERE ".$bmi." >= bmi_minimum
					AND ".$bmi." < (bmi_maksimum + 1)
					AND bodymassindex_aktif = TRUE";
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();
			if($loadData){
				$data = $loadData;
				$data['bmi'] = $bmi;
				$data['bb_ideal'] = $bb_ideal;
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * transaksi pemeriksaan fisik
	 * MA-162, MA-247
	 * @param $_GET['pemeriksaanfisik'] array
	 * @return json
	 */
	public function actionPemeriksaanFisik(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pemeriksaanfisik'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model = new MOPemeriksaanfisikT;
				$model->attributes = $_GET['pemeriksaanfisik'];
				if(!empty($model->pemeriksaanfisik_id)){
					$model = MOPemeriksaanfisikT::model()->findByPk($model->pemeriksaanfisik_id);
					$model->update_time = date("Y-m-d H:i:s");
				}else{
					$model->pemeriksaanfisik_id = null; //agar auto sequence tidak error
				}
				$model->create_time = date("Y-m-d H:i:s");
				if($model->save()){
					MOPendaftaranT::model()->updateByPk($model->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>$model->create_loginpemakai_id));
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data pemeriksaan fisik berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data pemeriksaan fisik gagal disimpan!<br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data pemeriksaan fisik gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan pemeriksaan lab klinik
	 * MA-174,
	 * @return:
	 * - ruangan_id
	 * - kelaspelayanans
	 */
	public function actionSetFormRujukanLabKlinik(){
		header("content-type:application/json");
		$data = array();
		$data['ruangan_id'] = Params::RUANGAN_ID_LAB_KLINIK;
		$data['kelaspelayanans'] = $this->getKelaspelayanans($data['ruangan_id']);
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * set form rujuk ke lab anatomi
	 * MA-174,
	 * @return:
	 * - ruangan_id
	 * - kelaspelayanans
	 */
	public function actionSetFormRujukanLabAnatomi(){
		header("content-type:application/json");
		$data = array();
		$data['ruangan_id'] = Params::RUANGAN_ID_LAB_ANATOMI;
		$data['kelaspelayanans'] = $this->getKelaspelayanans($data['ruangan_id']);

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * set form pemilihan pemeriksaan lab klinik
	 * MA-174,
	 * @params: ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return:
	 * -
	 */
	public function actionSetFormPemeriksaanLab(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id,
						jenispemeriksaanlab_m.jenispemeriksaanlab_id, jenispemeriksaanlab_m.jenispemeriksaanlab_kode, jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
						pemeriksaanlab_m.pemeriksaanlab_id, pemeriksaanlab_m.pemeriksaanlab_kode, pemeriksaanlab_m.pemeriksaanlab_nama,
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind, tariftindakan_m.persencyto_tind
					FROM pemeriksaanlab_m
					JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
						AND jenispemeriksaanlab_m.jenispemeriksaanlab_aktif = true
						AND pemeriksaanlab_m.pemeriksaanlab_aktif = true
						AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
						AND jenistarifpenjamin_m.penjamin_id = ".$_GET['penjamin_id']."
						AND tindakanruangan_m.ruangan_id = ".$_GET['ruangan_id']."
						AND(
							LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_kode) like '%".$req."%'
							OR LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_nama) like '%".$req."%'
							OR LOWER(pemeriksaanlab_m.pemeriksaanlab_kode) like '%".$req."%'
							OR LOWER(pemeriksaanlab_m.pemeriksaanlab_nama) like '%".$req."%'
						)
					ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC
					";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$val['jenispemeriksaanlab_id']][] = $val;
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi rujuk ke laboratorium
	 * MA-176
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionRujukKeLaboratorium(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);

				if($model->save()){
					if(count((array)$_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "LB");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);
							if($modPermintaan->save()){

							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke laboratorium berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail pemeriksaan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke laboratorium gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * set form rujuk ke radiologi
	 * MA-174,
	 * @return:
	 * - ruangan_id
	 * - kelaspelayanans
	 */
	public function actionSetFormRujukanRadiologi(){
		header("content-type:application/json");
		$data = array();
		$data['ruangan_id'] = Params::RUANGAN_ID_RAD;
		$data['kelaspelayanans'] = $this->getKelaspelayanans($data['ruangan_id']);

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan pemeriksaan radiologi
	 * MA-174,
	 * @params: ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return:
	 * -
	 */
	public function actionSetFormPemeriksaanRad(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id,
						jenispemeriksaanrad_m.jenispemeriksaanrad_id, jenispemeriksaanrad_m.jenispemeriksaanrad_kode, jenispemeriksaanrad_m.jenispemeriksaanrad_nama,
						pemeriksaanrad_m.pemeriksaanrad_id, pemeriksaanrad_m.pemeriksaanrad_kode, pemeriksaanrad_m.pemeriksaanrad_nama,
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
						FROM pemeriksaanrad_m
						JOIN jenispemeriksaanrad_m ON jenispemeriksaanrad_m.jenispemeriksaanrad_id = pemeriksaanrad_m.jenispemeriksaanrad_id
						JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanrad_m.daftartindakan_id
						JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
						JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
						JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
						WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
						AND jenispemeriksaanrad_m.jenispemeriksaanrad_aktif = TRUE
						AND pemeriksaanrad_m.pemeriksaanrad_aktif = TRUE
						AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
						AND jenistarifpenjamin_m.penjamin_id = ".$_GET['penjamin_id']."
						AND tindakanruangan_m.ruangan_id = ".$_GET['ruangan_id']."
						AND(
							LOWER(jenispemeriksaanrad_m.jenispemeriksaanrad_kode) like '%".$req."%'
							OR LOWER(jenispemeriksaanrad_m.jenispemeriksaanrad_nama) like '%".$req."%'
							OR LOWER(pemeriksaanrad_m.pemeriksaanrad_kode) like '%".$req."%'
							OR LOWER(pemeriksaanrad_m.pemeriksaanrad_nama) like '%".$req."%'
						)
					ORDER BY jenispemeriksaanrad_m.jenispemeriksaanrad_urutan ASC, pemeriksaanrad_m.pemeriksaanrad_urutan ASC
					";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$val['jenispemeriksaanrad_id']][$i] = $val;
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi rujuk ke radiologi
	 * MA-189
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionRujukKeRadiologi(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->create_ruangan = $model->ruangan_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				if($model->save()){
					if(count((array)$_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "RO");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);
							if($modPermintaan->save()){

							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke radiologi berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail pemeriksaan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke radiologi gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke radiologi gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form rujuk ke rehab medis
	 * MA-196,
	 * @return:
	 * - ruangan_id
	 * - kelaspelayanans
	 */
	public function actionSetFormRujukanRehabMedis(){
		header("content-type:application/json");
		$data = array();
		$data['ruangan_id'] = Params::RUANGAN_ID_FISIOTERAPI;
		$data['kelaspelayanans'] = $this->getKelaspelayanans($data['ruangan_id']);

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan tindakan rehab medis
	 * yang belum punya tarif tetap muncul
	 * MA-197
	 * @params: ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return:
	 * -
	 */
	public function actionSetFormTindakanRehabMedis(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id,
					jenistindakanrm_m.jenistindakanrm_id, jenistindakanrm_m.jenistindakanrm_kode, jenistindakanrm_m.jenistindakanrm_nama,
					tindakanrm_m.tindakanrm_id, tindakanrm_m.tindakanrm_kode, tindakanrm_m.tindakanrm_nama,
					tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
					FROM tindakanrm_m
					JOIN jenistindakanrm_m ON jenistindakanrm_m.jenistindakanrm_id = tindakanrm_m.jenistindakanrm_id
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanrm_m.daftartindakan_id
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND jenistindakanrm_m.jenistindakanrm_aktif = TRUE
					AND tindakanrm_m.tindakanrm_aktif = TRUE
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
					AND jenistarifpenjamin_m.penjamin_id = ".$_GET['penjamin_id']."
					AND tindakanruangan_m.ruangan_id = ".$_GET['ruangan_id']."
					AND(
						LOWER(jenistindakanrm_m.jenistindakanrm_kode) like '%".$req."%'
						OR LOWER(jenistindakanrm_m.jenistindakanrm_nama) like '%".$req."%'
						OR LOWER(tindakanrm_m.tindakanrm_kode) like '%".$req."%'
						OR LOWER(tindakanrm_m.tindakanrm_nama) like '%".$req."%'
					)
					ORDER BY jenistindakanrm_m.jenistindakanrm_urutan ASC, tindakanrm_m.tindakanrm_urutan ASC
					";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$val['jenistindakanrm_id']][] = $val;
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi rujuk ke rehab medis
	 * MA-198
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionRujukKeRehabMedis(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->create_ruangan = $model->ruangan_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				if($model->save()){
					if(count((array)$_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "RM");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);
							if($modPermintaan->save()){

							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke rehab medis berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail tindakan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke rehab medis gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke rehab medis gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form rujuk gizi
	 * MA-200
	 * @return:
	 * - ruangan_id
	 * - kelaspelayanans
	 * - ahligizis
	 */
	public function actionSetFormRujukanGizi(){
		header("content-type:application/json");
		$data = array();
		$data['ruangan_id'] = Params::RUANGAN_ID_GIZI;
		$data['kelaspelayanans'] = $this->getKelaspelayanans($data['ruangan_id']);
		$data['ahligizis'] = array();

		//load pegawai ahli gizi
		$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
			FROM pegawai_m
			JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
			LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
			WHERE pegawai_m.kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_AHLI_GIZI."
				AND pegawai_m.pegawai_aktif = TRUE
				AND ruanganpegawai_m.ruangan_id = ".$data['ruangan_id'];
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data['ahligizis'][$i]['pegawai_id'] = $val['pegawai_id'];
				$data['ahligizis'][$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai'].", ".$val['gelarbelakang_nama'];
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan tindakan konsul gizi
	 * MA-201
	 * @params: ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return:
	 * -
	 */
	public function actionSetFormTindakanPelayananGizi(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama,
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
					FROM daftartindakan_m
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND daftartindakan_m.daftartindakan_aktif = TRUE
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
					AND jenistarifpenjamin_m.penjamin_id = ".$_GET['penjamin_id']."
					AND tindakanruangan_m.ruangan_id = ".$_GET['ruangan_id']."
					AND(
						LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
						OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
					)
					ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC
					";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi rujuk ke gizi
	 * MA-202
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionRujukKeGizi(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->create_ruangan = $model->ruangan_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				if($model->save()){
					if(count((array)$_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "GZ");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);
							if($modPermintaan->save()){

							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data konsul pasien ke gizi berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail tindakan pelayanan gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data konsul pasien ke gizi gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data konsul pasien ke gizi gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form konsul poli
	 * MA-204
	 * @params: pendaftaran_id, pasienadmisi_id
	 * @return:
	 * - ruangans
	 */
	public function actionSetFormKonsulPoli(){
		header("content-type:application/json");
		$data = array();
		$data['ruangans'] = array();

		//load poliklinik
		$sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama
			FROM ruangan_m
			WHERE ruangan_m.instalasi_id = ".Params::INSTALASI_ID_RJ."
				AND ruangan_m.ruangan_aktif = TRUE
				ORDER BY ruangan_m.ruangan_nourut ASC, ruangan_m.ruangan_nama ASC";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['ruangans'] = $loadDatas;
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi konsul poli
	 * MA-205
	 * @param $_GET['konsulpoli'] array
	 * @return json
	 */
	public function actionKonsulPoli(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['konsulpoli'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOKonsulpoliT();
				$model->attributes = $_GET['konsulpoli'];
				$model->tglkonsulpoli = $format->formatDateTimeForDb($_GET['konsulpoli']['tglkonsulpoli']);
				$model->statusperiksa = PARAMS::STATUSPERIKSA_ANTRIAN;
				$model->catatan_dokter_konsul = str_replace("'","",str_replace('"', '', $_GET['konsulpoli']['catatan_dokter_konsul']));
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->create_ruangan = $model->ruangan_id;
				$model->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($model->ruangan_id);
				if($model->save()){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data konsul poli berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data konsul poli gagal disimpan!<br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data konsul poli gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form tindakan
	 * MA-210, MA-253
	 * @params: carabayar_id, kelaspelayanan_id, penjamin_id
	 * @return:
	 * - tipepakets
	 * - tindakanpelayanans // yg sudah tersimpan (riwayat)
	 */
	public function actionSetFormTindakan(){
		header("content-type:application/json");
		$data = array();
		$data['tipepakets'] = array();
		$data['tindakanpelayanans'] = array();
		if(isset($_GET['carabayar_id']) && isset($_GET['kelaspelayanan_id']) && isset($_GET['penjamin_id'])){
			$sql = "SELECT tipepaket_id, tipepaket_nama, tipepaket_singkatan, tarifpaket, paketsubsidiasuransi, paketsubsidirs, paketiurbiaya
					FROM
					tipepaket_m
					WHERE tipepaket_aktif = TRUE
						AND (
							(carabayar_id = ".$_GET['carabayar_id']." AND kelaspelayanan_id = ".$_GET['kelaspelayanan_id']." AND penjamin_id = ".$_GET['penjamin_id'].")
							OR tipepaket_id = ".Params::TIPEPAKET_ID_NONPAKET."
						)
					ORDER BY tipepaket_id ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['tipepakets'] = $loadDatas;
			}
		}
		//riwayat tindakan
		if(isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id']) && isset($_GET['ruangan_id'])){
			$sql = "SELECT tindakanpelayanan_t.tindakanpelayanan_id, tindakanpelayanan_t.tgl_tindakan, tindakanpelayanan_t.tarif_satuan, tindakanpelayanan_t.qty_tindakan, tindakanpelayanan_t.tarif_tindakan, tindakanpelayanan_t.cyto_tindakan, tindakanpelayanan_t.tarifcyto_tindakan, tindakanpelayanan_t.satuantindakan,
						daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama,
						kategoritindakan_m.kategoritindakan_id, kategoritindakan_m.kategoritindakan_nama,
						kelompoktindakan_m.kelompoktindakan_id, kelompoktindakan_m.kelompoktindakan_nama
					FROM tindakanpelayanan_t
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
					LEFT JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id
					LEFT JOIN kelompoktindakan_m ON kelompoktindakan_m.kelompoktindakan_id = daftartindakan_m.kelompoktindakan_id
					WHERE tindakanpelayanan_t.tindakansudahbayar_id IS NULL
						AND tindakanpelayanan_t.karcis_id IS NULL
						AND tindakanpelayanan_t.pendaftaran_id = ".$_GET['pendaftaran_id']."
						".(($_GET['pasienadmisi_id'] > 0) ? "AND tindakanpelayanan_t.pasienadmisi_id = ".$_GET['pasienadmisi_id'] : "AND tindakanpelayanan_t.pasienadmisi_id IS NULL")."
						AND tindakanpelayanan_t.ruangan_id = ".$_GET['ruangan_id']."
					ORDER BY tgl_tindakan ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['tindakanpelayanans'] = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan tindakan
	 * MA-201
	 * @params: ruangan_id, penjamin_id, kelaspelayanan_id, tipepaket_id, q
	 * @return:
	 * -
	 */
	public function actionSetFormPilihTindakan(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id']) && isset($_GET['tipepaket_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			if($_GET['tipepaket_id'] == Params::TIPEPAKET_ID_NONPAKET){
				$sql = "SELECT daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama,
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
					FROM daftartindakan_m
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON tariftindakan_m.jenistarif_id = jenistarifpenjamin_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND daftartindakan_m.daftartindakan_aktif = TRUE
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
					AND jenistarifpenjamin_m.penjamin_id = ".$_GET['penjamin_id']."
					AND tindakanruangan_m.ruangan_id = ".$_GET['ruangan_id']."
					AND(
						LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
						OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
					)
					ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC
					";
			}else{
				$sql = "SELECT daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama,
							paketpelayanan_m.tarifpaketpel, paketpelayanan_m.subsidiasuransi, paketpelayanan_m.subsidipemerintah, paketpelayanan_m.subsidirumahsakit, paketpelayanan_m.iurbiaya
						FROM daftartindakan_m
					JOIN paketpelayanan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
					JOIN tipepaket_m ON tipepaket_m.tipepaket_id = paketpelayanan_m.tipepaket_id
					JOIN penjaminpasien_m ON tipepaket_m.penjamin_id = penjaminpasien_m.penjamin_id
					WHERE tipepaket_m.tipepaket_aktif = true
						AND daftartindakan_m.daftartindakan_aktif = TRUE
						AND tipepaket_m.tipepaket_id = ".$_GET['tipepaket_id']."
						AND(
							LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
							OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
						)
					ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC
					";
			}
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi tindakan pelayanan
	 * MA-211
	 * @param $_GET['tindakanpelayanan'] array
	 * @return json
	 */
	public function actionTindakanPelayanan(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['tindakanpelayanan'])){
			$transaction = Yii::app()->db->beginTransaction();
			$format = new MyFormatter;
			$errorTindakan = "";
			$errorDetail = "";
			$tersimpan = true; //di looping tindakan pelayanan + tindakan komponen
			try{
				if(count((array)$_GET['tindakanpelayanan']) > 0){
					foreach($_GET['tindakanpelayanan'] AS $i => $tindakan){
						$model = new MOTindakanpelayananT;
						$model->attributes = $tindakan;
						$model->tgl_tindakan = (!empty($model->tgl_tindakan) ? $format->formatDateTimeForDb($model->tgl_tindakan) : date("Y-m-d H:i:s"));
						$model->create_time = date("Y-m-d H:i:s");
						$model->shift_id = $this->getShift("shift_id");
						$model->tarif_satuan = $model->getTarifSatuan(); //RND-7250
						$model->tarif_tindakan = $model->tarif_satuan * $model->qty_tindakan;
						if(!$model->cyto_tindakan){ //false
							$model->tarifcyto_tindakan = 0;
						}else{
							$model->tarifcyto_tindakan = $model->tarif_tindakan + ($model->tarif_tindakan * 10 / 100);
						}

						$model->pembebasan_tindakan = 0;
						$model->subsidiasuransi_tindakan = 0;
						$model->subsidipemerintah_tindakan = 0;
						$model->subsisidirumahsakit_tindakan = 0;
						$model->iurbiaya_tindakan = 0;

						$model->tarif_rsakomodasi = 0;
						$model->tarif_medis = 0;
						$model->tarif_paramedis = 0;
						$model->tarif_bhp = 0;

						if($model->save()){
							$tersimpan &= true;
						}else{
							$tersimpan = false;
							$errorTindakan .= CHtml::errorSummary($model);
						}
					}
				}
				if($tersimpan){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data tindakan / pelayanan berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data tindakan gagal disimpan! <br>'.$errorTindakan;
					if(!empty($errorDetail)){
						$data['pesan'] = 'Data komponen tindakan / pelayanan gagal disimpan!<br>'.$errorDetail;
					}
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data tindakan / pelayanan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * menampilkan data shift_m
	 * @param type $attribute
	 * @return type
	 */
	protected function getShift($attribute = "", $jam = ""){
		$jam = (!empty($jam) ? $jam : date("H:i"));
		$sql = "SELECT *
			FROM shift_m
			WHERE '".$jam."' BETWEEN shift_jamawal AND shift_jamakhir";
		$loadData = Yii::app()->db->createCommand($sql)->queryRow();
		if(!empty($attribute)){
			return $loadData[$attribute];
		}else{
			return $loadData;
		}
	}

	/**
	 * transaksi hapus tindakan pelayanan
	 * MA-253
	 * @param $_GET['tindakanpelayanan_id']
	 * @return json
	 */
	public function actionHapusTindakanPelayanan(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['tindakanpelayanan_id'])){
			$transaction = Yii::app()->db->beginTransaction();
			$format = new MyFormatter;
			$errorDetail = "";
			try{
				$hapus = false;
				$hapusDetail = MOTindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$_GET['tindakanpelayanan_id']));
				if($hapusDetail){
					$hapus = MOTindakanpelayananT::model()->deleteByPk($_GET['tindakanpelayanan_id']);
				}
				if($hapus){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data tindakan pelayanan berhasil dihapus!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data tindakan pelayanan gagal dihapus!<br>'.CHtml::errorSummary($hapus)."<br>".CHtml::errorSummary($hapusDetail);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data tindakan pelayanan gagal dihapus!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form rujuk ke bedah sentral
	 * MA-213,
	 * @params: pendaftaran_id, pasienadmisi_id
	 * @return:
	 * - kelaspelayanans
	 */
	public function actionSetFormRujukanBedahSentral(){
		header("content-type:application/json");
		$data = array();
		$data['ruangan_id'] = Params::RUANGAN_ID_BEDAH;
		$data['kelaspelayanans'] = $this->getKelaspelayanans($data['ruangan_id']);

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan tindakan operasi untuk bedah
	 * MA-214
	 * @params: ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return:
	 * -
	 */
	public function actionSetFormTindakanOperasi(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id,
						kegiatanoperasi_m.kegiatanoperasi_id, kegiatanoperasi_m.kegiatanoperasi_kode, kegiatanoperasi_m.kegiatanoperasi_nama,
						operasi_m.operasi_id, operasi_m.operasi_kode, operasi_m.operasi_nama,
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
					FROM operasi_m
					JOIN kegiatanoperasi_m ON kegiatanoperasi_m.kegiatanoperasi_id = operasi_m.kegiatanoperasi_id
					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = operasi_m.daftartindakan_id
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
						AND kegiatanoperasi_m.kegiatanoperasi_aktif = TRUE
						AND operasi_m.operasi_aktif = TRUE
						AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
						AND jenistarifpenjamin_m.penjamin_id = ".$_GET['penjamin_id']."
						AND tindakanruangan_m.ruangan_id = ".$_GET['ruangan_id']."
						AND(
							LOWER(kegiatanoperasi_m.kegiatanoperasi_kode) like '%".$req."%'
							OR LOWER(kegiatanoperasi_m.kegiatanoperasi_nama) like '%".$req."%'
							OR LOWER(operasi_m.operasi_kode) like '%".$req."%'
							OR LOWER(operasi_m.operasi_nama) like '%".$req."%'
						)
					ORDER BY kegiatanoperasi_m.kegiatanoperasi_nama ASC, operasi_m.operasi_nama ASC
					";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$val['kegiatanoperasi_id']][$i] = $val;
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi rujuk ke bedah sentral / kamar operasi
	 * MA-215
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionRujukKeBedah(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
				$model->create_ruangan = $model->ruangan_id;
				$model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
				if($model->save()){
					if(count((array)$_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
							$modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$prefix = (!empty($model->ruangan->ruangan_singkatan) ? $model->ruangan->ruangan_singkatan : "BS");
							$modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($prefix);
							if($modPermintaan->save()){

							}else{
								$errorDetail .= CHtml::errorSummary($modPermintaan);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data rujuk pasien ke bedah berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail rencana operasi gagal disimpan!<br>'.$errorDetail;
					}

				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujuk pasien ke bedah gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujuk pasien ke bedah gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	/**
	 * set form diagnosa / diagnosis
	 * MA-235,
	 * @params: ruangan_id, pendaftaran_id, pasienadmisi_id
	 * @return:
	 * - kelaspelayanans
	 */
	public function actionSetFormDiagnosa(){
		header("content-type:application/json");
		$data = array();
		$data['kelaspelayanans'] = array();
		$data['pasienmorbiditas'] = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id'])){

			$data['kelaspelayanans'] = $this->getKelaspelayanans($data['ruangan_id']);

			$sql = "SELECT pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pasienmorbiditas_id,
						kelompokdiagnosa_m.kelompokdiagnosa_id, kelompokdiagnosa_m.kelompokdiagnosa_nama,
						diagnosa_m.diagnosa_id,
						diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
						FROM pasienmorbiditas_t
						JOIN kelompokdiagnosa_m ON kelompokdiagnosa_m.kelompokdiagnosa_id = pasienmorbiditas_t.kelompokdiagnosa_id
						JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
						WHERE pasienmorbiditas_t.pendaftaran_id = ".$_GET['pendaftaran_id']."
							".(!empty($_GET['pasienadmisi_id']) ? " AND pasienmorbiditas_t.pasienadmisi_id = ".$_GET['pasienadmisi_id']: "");
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data['pasienmorbiditas'] = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan diagnosa
	 * MA-217
	 * @params: jeniskasuspenyakit_id, q
	 * @return:
	 * -
	 */
	public function actionSetFormPilihDiagnosa(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['jeniskasuspenyakit_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");


			if($_GET['jeniskasuspenyakit_id'] > 0){
				$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama, diagnosa_m.diagnosa_namalainnya, diagnosa_m.diagnosa_katakunci
						FROM diagnosa_m
						JOIN kasuspenyakitdiagnosa_m ON kasuspenyakitdiagnosa_m.diagnosa_id = diagnosa_m.diagnosa_id
						WHERE diagnosa_m.diagnosa_aktif = TRUE
							AND diagnosa_m.diagnosa_imunisasi = FALSE
							AND(
								LOWER(diagnosa_m.diagnosa_kode) like '%".$req."%'
								OR LOWER(diagnosa_m.diagnosa_nama) like '%".$req."%'
								OR LOWER(diagnosa_m.diagnosa_namalainnya) like '%".$req."%'
								OR LOWER(diagnosa_m.diagnosa_katakunci) like '%".$req."%'
							)
						ORDER BY diagnosa_m.diagnosa_nourut ASC
						LIMIT 9";
			}else{
				$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama, diagnosa_m.diagnosa_namalainnya, diagnosa_m.diagnosa_katakunci
						FROM diagnosa_m
						WHERE diagnosa_m.diagnosa_aktif = TRUE
							AND diagnosa_m.diagnosa_imunisasi = FALSE
							AND(
								LOWER(diagnosa_m.diagnosa_kode) like '%".$req."%'
								OR LOWER(diagnosa_m.diagnosa_nama) like '%".$req."%'
								OR LOWER(diagnosa_m.diagnosa_namalainnya) like '%".$req."%'
								OR LOWER(diagnosa_m.diagnosa_katakunci) like '%".$req."%'
							)
						ORDER BY diagnosa_m.diagnosa_nourut ASC
						LIMIT 9";
			}
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();

			$sql = "SELECT *
					FROM kelompokdiagnosa_m
					WHERE kelompokdiagnosa_aktif = TRUE";
			$loadDataKelompoks = Yii::app()->db->createCommand($sql)->queryAll();

			if(count((array)$loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$i] = $val;
					$data[$i]['kelompokdiagnosas'] = $loadDataKelompoks;
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	/**
	 * transaksi simpan diagnosa pasien (pasien morbiditas)
	 * MA-236
	 * @param $_GET['pasienmorbiditas'] array
	 * @return json
	 */
	public function actionPasienMorbiditas(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pasienmorbiditas'])){
			$transaction = Yii::app()->db->beginTransaction();
			$format = new MyFormatter;
			$errorDetail = "";
			try{
				if(count((array)$_GET['pasienmorbiditas']) > 0){
					foreach($_GET['pasienmorbiditas'] AS $i => $diagnosa){
						$model = new MOPasienmorbiditasT;
						$model->attributes = $diagnosa;
						$model->tglmorbiditas = (!empty($model->tglmorbiditas) ? $format->formatDateTimeForDb($model->tglmorbiditas) : date("Y-m-d H:i:s"));
						$model->kasusdiagnosa = $this->getKasusDiagnosa($model->pasien_id);
						$model->pasienadmisi_id = (empty($model->pasienadmisi_id) ? null : $model->pasienadmisi_id);
						$model->kamarruangan_id = (empty($model->kamarruangan_id) ? null : $model->kamarruangan_id);
						if($model->save()){

						}else{
							$errorDetail .= CHtml::errorSummary($model);
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data diagnosis berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data diagnosis gagal disimpan!<br>'.$errorDetail;
					}
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data diagnosis gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi hapus diagnosa pasien (pasien morbiditas)
	 * MA-245
	 * @param $_GET['pasienmorbiditas_id']
	 * @return json
	 */
	public function actionHapusPasienMorbiditas(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pasienmorbiditas_id'])){
			$transaction = Yii::app()->db->beginTransaction();
			$format = new MyFormatter;
			$errorDetail = "";
			try{
				$hapus = MOPasienmorbiditasT::model()->deleteByPk($_GET['pasienmorbiditas_id']);
				if($hapus){
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data diagnosis berhasil dihapus!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data diagnosis gagal dihapus!<br>'.CHtml::errorSummary($hapus);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data diagnosis gagal dihapus!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menentukan data kasus diagnosa (Baru atau Lama)
	 * @param type $pasien_id
	 * @return type
	 */
	protected function getKasusDiagnosa($pasien_id){
		$sql = "SELECT pasienmorbiditas_id
			FROM pasienmorbiditas_t
			WHERE pasien_id = ".$pasien_id;
		$loadData = Yii::app()->db->createCommand($sql)->queryRow();
		if(isset($loadData['pasienmorbiditasi_id'])){
			return Params::KASUSDIAGNOSA_KASUS_LAMA;
		}else{
			return Params::KASUSDIAGNOSA_KASUS_BARU;
		}
	}

	/**
	 * set form rujukan ke luar
	 * MA-218,
	 * @return:
	 * - rujukankeluars
	 */
	public function actionSetFormRujukanKeLuar(){
		header("content-type:application/json");
		$data = array();
		$data['rujukankeluars'] = array();
		$sql = "SELECT *
				FROM rujukankeluar_m
				WHERE rujukankeluar_aktif = TRUE
				ORDER BY rumahsakitrujukan ASC";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['rujukankeluars'] = $loadDatas;
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form pemilihan diagnosa sementara
	 * MA-218
	 * @return:
	 * - array(array())
	 */
	public function actionSetFormPilihDiagnosaSementara(){
		header("content-type:application/json");
		$data = array();
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama, diagnosa_m.diagnosa_namalainnya, diagnosa_m.diagnosa_katakunci
				FROM diagnosa_m
				WHERE diagnosa_m.diagnosa_aktif = TRUE
					AND(
						LOWER(diagnosa_m.diagnosa_kode) like '%".$req."%'
						OR LOWER(diagnosa_m.diagnosa_nama) like '%".$req."%'
						OR LOWER(diagnosa_m.diagnosa_namalainnya) like '%".$req."%'
						OR LOWER(diagnosa_m.diagnosa_katakunci) like '%".$req."%'
					)
				ORDER BY diagnosa_m.diagnosa_nourut ASC
				LIMIT 10";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data = $loadDatas;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	/**
	 * transaksi rujukan keluar
	 * MA-223
	 * @param $_GET['pasiendirujukkeluar'] array
	 * @return json
	 */
	public function actionRujukanKeLuar(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pasiendirujukkeluar'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model = new MOPasiendirujukkeluarT;
				$model->attributes = $_GET['pasiendirujukkeluar'];
				$model->create_time = date("Y-m-d H:i:s");
				if($model->save()){
					MOPendaftaranT::model()->updateByPk($model->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>$model->create_loginpemakai_id));
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data rujukan ke luar berhasil disimpan!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data rujukan ke luar gagal disimpan! <br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data rujukan ke luar gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set form rujukan ke luar
	 * MA-220, MA-266
	 * @return:
	 * - rujukankeluars
	 */
	public function actionSetFormReseptur(){
		header("content-type:application/json");
		$data = array();
		$data['ruangan_id'] = Params::RUANGAN_ID_APOTEK_1;
		$data['ruangans'] = array();
		$data['satuankecils'] = array();
		$data['etikets'] = array();
		$sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama
			FROM ruangan_m
			WHERE ruangan_m.instalasi_id = ".Params::INSTALASI_ID_FARMASI."
				AND ruangan_m.ruangan_aktif = TRUE
				AND ruangan_m.ruangan_id <> ".Params::RUANGAN_ID_GUDANG_FARMASI."
				ORDER BY ruangan_m.ruangan_nourut ASC, ruangan_m.ruangan_nama ASC";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['ruangans'] = $loadDatas;
		}
		$sql = "SELECT satuankecil_id, satuankecil_nama
			FROM satuankecil_m
			WHERE satuankecil_aktif = TRUE
			ORDER BY satuankecil_nama ASC";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['satuankecils'] = $loadDatas;
		}
		$sql = "SELECT lookup_name, lookup_value
			FROM lookup_m
			WHERE lookup_aktif = TRUE
				AND LOWER(lookup_type) = 'etiket'
			ORDER BY lookup_urutan ASC";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['etikets'] = $loadDatas;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * set dialog obat alkes (pilih obat)
	 * MA-221
	 * @return:
	 * - array(array())
	 */
	public function actionSetDialogObatAlkes(){
		header("content-type:application/json");
		$data = array();
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
		$sql = "SELECT obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_barcode, obatalkes_m.obatalkes_kode, obatalkes_m.obatalkes_nama, obatalkes_m.obatalkes_namalain, obatalkes_m.obatalkes_golongan, obatalkes_m.obatalkes_kategori, obatalkes_m.obatalkes_kadarobat, obatalkes_m.harganetto, obatalkes_m.hargajual,
				sumberdana_m.sumberdana_id, sumberdana_m.sumberdana_nama,
				satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama,
				generik_m.generik_id, generik_m.generik_nama
				FROM obatalkes_m
				JOIN sumberdana_m ON sumberdana_m.sumberdana_id = obatalkes_m.sumberdana_id
				JOIN satuankecil_m ON satuankecil_m.satuankecil_id = obatalkes_m.satuankecil_id
				LEFT JOIN generik_m ON generik_m.generik_id = obatalkes_m.generik_id
				WHERE obatalkes_m.obatalkes_aktif = TRUE
				AND obatalkes_m.obatalkes_farmasi = TRUE
				AND (
					LOWER(obatalkes_m.obatalkes_barcode) = '".$req."'
					OR LOWER(obatalkes_m.obatalkes_kode) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_nama) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_namalain) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_golongan) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_kategori) like '%".$req."%'
					OR LOWER(obatalkes_m.obatalkes_kadarobat) like '%".$req."%'
					OR LOWER(sumberdana_m.sumberdana_nama) like '%".$req."%'
					OR LOWER(satuankecil_m.satuankecil_nama) like '%".$req."%'
					OR LOWER(generik_m.generik_nama) like '%".$req."%'
				)
				LIMIT 10";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data = $loadDatas;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi simpan reseptur
	 * MA-265
	 * @param $_GET['reseptur'] array
	 * @param $_GET['resepturdetail'] array(array()) //detail resep
	 * @return json
	 */
	public function actionReseptur(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['reseptur']) && isset($_GET['resepturdetail'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOResepturT;
				$model->attributes = $_GET['reseptur'];
				$model->tglreseptur = (!empty($_GET['reseptur']['tglreseptur']) ? $format->formatDateTimeForDb($_GET['reseptur']['tglreseptur']) : date("Y-m-d H:i:s"));
				$model->create_time = date("Y-m-d H:i:s");
				$model->noresep = MyGenerator::noResep(Params::INSTALASI_ID_RJ).$_GET['reseptur']['noresep'];
				if($model->save()){
					if(count((array)$_GET['resepturdetail']) > 0){
						foreach($_GET['resepturdetail'] AS $i => $detail){
							$modDetail = new MOResepturdetailT();
							$modDetail->attributes = $detail;
							$modDetail->reseptur_id = $model->reseptur_id;
							$modDetail->hargajual_reseptur = $modDetail->qty_reseptur * $modDetail->hargasatuan_reseptur;
							if($modDetail->save()){

							}else{
								$errorDetail .= CHtml::errorSummary($modDetail);
							}
						}
					}
					if(empty($errorDetail)){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data resep berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data detail resep gagal disimpan!<br>'.$errorDetail;
					}
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data resep gagal disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data resep gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * tindak lanjut pasien ke Rawat Inap
	 * MA-268
	 */
	public function actionTindakLanjutRI()
	{
		header("content-type:application/json");
		//inputan masuk $_GET['pendaftaran_id'], $_GET['pasien_id'], $_GET['ruangan_id'], $_GET['loginpemakai_id']
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pendaftaran_id']) && isset($_GET['pasien_id']) && isset($_GET['ruangan_id']) && isset($_GET['loginpemakai_id'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model = new MOPasienpulangT;
				$model->pendaftaran_id = $_GET['pendaftaran_id'];
				$model->pasien_id = $_GET['pasien_id'];
				$model->tglpasienpulang = date('Y-m-d H:i:s');
				$model->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
				$model->kondisikeluar_id = Params::KONDISIKELUAR_ID_RAWATINAP;
				$model->ruanganakhir_id = $_GET['ruangan_id'];
				$model->lamarawat = 1;
				$model->satuanlamarawat = Params::SATUAN_LAMARAWAT_RJ;
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = $_GET['loginpemakai_id'];
				$model->create_ruangan = $_GET['ruangan_id'];
				if($model->save()){
					MOPendaftaranT::model()->updateByPk($model->pendaftaran_id, array('pasienpulang_id'=>$model->pasienpulang_id,'statusperiksa'=>Params::STATUSPERIKSA_SEDANG_DIRAWATINAP));
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Tindak lanjut pasien ke rawat inap berhasil!';
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Tindak lanjut pasien ke rawat inap gagal!<br>'.CHtml::errorSummary($model);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Tindak lanjut pasien ke rawat inap gagal!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();

	}

	/**
	 * set form pendaftaran rawat jalan
	 * MA-281
	 * @params: ruangan_id, pendaftaran_id, pasienadmisi_id
	 * @return:
	 * -
	 */
	public function actionSetFormPendaftaranRJ(){
		header("content-type:application/json");
		$data = array();
		$data['jenisidentitas'] = array();
		$data['namadepan'] = array();
		$data['jeniskelamin'] = array();
		$data['golongandarah'] = array();
		$data['rhesus'] = array();
		$data['statusperkawinan'] = array();
		$data['warganegara'] = array();
		$data['agama'] = array();
		$data['propinsi'] = array();
		$data['kabupaten'] = array();
		$data['kecamatan'] = array();
		$data['kelurahan'] = array();
		$data['pekerjaan'] = array();
		$data['suku'] = array();
		$data['pendidikan'] = array();

		$data['ruangan'] = array();
		$data['jeniskasuspenyakit'] = array();
		$data['kelaspelayanan'] = array();
		$data['carabayar'] = array();
		$data['penjamin'] = array();

		$data['kelastanggunganasuransi'] = array();
		//default
		$ruangan_id = null;
		$carabayar_id = null;

		$sql = "SELECT lookup_type, lookup_name, lookup_value
				FROM lookup_m
				WHERE LOWER(lookup_type) IN ('jenisidentitas', 'namadepan', 'jeniskelamin', 'golongandarah', 'rhesus', 'statusperkawinan', 'warganegara', 'agama')
				AND lookup_aktif = TRUE
				ORDER BY lookup_type, lookup_urutan";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$val["lookup_type"]][] = $val;
			}
		}
		$sql = "SELECT pekerjaan_id, pekerjaan_nama
				FROM pekerjaan_m
				WHERE pekerjaan_aktif = TRUE
				ORDER BY pekerjaan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['pekerjaan'] = $loadDatas;
		}
		$sql = "SELECT suku_id, suku_nama
				FROM suku_m
				WHERE suku_aktif = TRUE
				ORDER BY suku_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['suku'] = $loadDatas;
		}
		$sql = "SELECT pendidikan_id, pendidikan_nama
				FROM pendidikan_m
				WHERE pendidikan_aktif = TRUE
				ORDER BY pendidikan_urutan";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['pendidikan'] = $loadDatas;
		}
		$data['propinsi'] = $this->getPropinsis();
		$data['kabupaten'] = (isset($_GET['propinsi_id']) ? $this->getKabupatens($_GET['propinsi_id']) : array());
		$data['kecamatan'] = (isset($_GET['kabupaten_id']) ? $this->getKecamatans($_GET['kabupaten_id']) : array());
		$data['kelurahan'] = (isset($_GET['kecamatan_id']) ? $this->getKelurahans($_GET['kecamatan_id']) : array());

		$sql = "SELECT ruangan_id, ruangan_nama
				FROM ruangan_m
				WHERE ruangan_aktif = TRUE
				ORDER BY ruangan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['ruangan'] = $loadDatas;
		}

		$data['jeniskasuspenyakit'] = $this->getJeniskasuspenyakits($ruangan_id);

		$data['kelaspelayanan'] = $this->getKelaspelayanans($ruangan_id);

		$data['kelastanggunganasuransi'] = $this->getKelaspelayanans();

		if(!empty($carabayar_id)){
			$data['penjamin'] = $this->getPenjamins($carabayar_id);
		}

		$sql = "SELECT carabayar_id, carabayar_nama
				FROM carabayar_m
				WHERE carabayar_aktif = TRUE
				ORDER BY carabayar_nourut";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			$data['carabayar'] = $loadDatas;
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * menampilkan data propinsi_m
	 */
	protected function getPropinsis(){
		$sql = "SELECT propinsi_id, propinsi_nama
				FROM propinsi_m
				WHERE propinsi_aktif = TRUE
				ORDER BY propinsi_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}
	/**
	 * menampilkan data kabupaten_m berdasarkan propinsi_id
	 */
	protected function getKabupatens($propinsi_id){
		$sql = "SELECT kabupaten_id, kabupaten_nama
				FROM kabupaten_m
				WHERE kabupaten_aktif = TRUE
					AND propinsi_id = ".$propinsi_id."
				ORDER BY kabupaten_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}
	/**
	 * menampilkan data kecamatan_m berdasarkan kabupaten_id
	 */
	protected function getKecamatans($kabupaten_id){
		$sql = "SELECT kecamatan_id, kecamatan_nama
				FROM kecamatan_m
				WHERE kecamatan_aktif = TRUE
					AND kabupaten_id = ".$kabupaten_id."
				ORDER BY kecamatan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}
	/**
	 * menampilkan data kelurahan_m berdasarkan kecamatan_id
	 */
	protected function getKelurahans($kecamatan_id){
		$sql = "SELECT kelurahan_id, kelurahan_nama, kode_pos
				FROM kelurahan_m
				WHERE kelurahan_aktif = TRUE
					AND kecamatan_id = ".$kabupaten_id."
				ORDER BY kelurahan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}
	/**
	 * menampilkan data kelaspelayanan berdasarkan ruangan_id
	 */
	protected function getKelaspelayanans($ruangan_id = null){
		if(empty($ruangan_id)){
			$sql = "SELECT kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama
					FROM kelaspelayanan_m
					WHERE kelaspelayanan_m.kelaspelayanan_aktif = TRUE
					ORDER BY kelaspelayanan_m.kelaspelayanan_nama";
		}else{
			$sql = "SELECT kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama
					FROM kelaspelayanan_m
					JOIN kelasruangan_m ON kelasruangan_m.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
					WHERE kelaspelayanan_m.kelaspelayanan_aktif = TRUE
						AND kelasruangan_m.ruangan_id = $ruangan_id
					ORDER BY kelaspelayanan_m.kelaspelayanan_nama";
		}
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}
	/**
	 * menampilkan data jeniskasuspenyakit_m berdasarkan ruangan_id
	 */
	protected function getJeniskasuspenyakits($ruangan_id = null){
		if(empty($ruangan_id)){
			$sql = "SELECT jeniskasuspenyakit_id, jeniskasuspenyakit_nama
					FROM jeniskasuspenyakit_m
					WHERE jeniskasuspenyakit_aktif = TRUE
					ORDER BY jeniskasuspenyakit_nama";
		}else{
			$sql = "SELECT jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama
					FROM jeniskasuspenyakit_m
					JOIN kasuspenyakitruangan_m ON kasuspenyakitruangan_m.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
					WHERE jeniskasuspenyakit_m.jeniskasuspenyakit_aktif = TRUE
						AND kasuspenyakitruangan_m.ruangan_id = $ruangan_id
					ORDER BY jeniskasuspenyakit_m.jeniskasuspenyakit_nama";
		}
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}

	/**
	 * menampilkan data pegawai_m (dokter) berdasarkan ruangan_id
	 */
	protected function getDokterruangan($ruangan_id){
		$sql = "SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
				FROM ruanganpegawai_m
				JOIN pegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
				LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
				WHERE pegawai_m.kelompokpegawai_id IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.", ".Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN.")
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
	 * menampilkan data penjaminpasien_m berdasarkan carabayar_id
	 */
	protected function getPenjamins($carabayar_id){
		$sql = "SELECT penjamin_id, penjamin_nama
				FROM penjaminpasien_m
				WHERE penjamin_aktif = TRUE
					AND carabayar_id = ".$carabayar_id."
				ORDER BY penjamin_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count((array)$loadDatas) > 0){
			return $loadDatas;
		}else{
			return array();
		}
	}

	/**
	 * menampilkan data kabupaten
	 * MA-296
	 * @params propinsi_id
	 */
	public function actionGetDataKabupatens(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['propinsi_id'])){
			$data = $this->getKabupatens($_GET['propinsi_id']);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menampilkan data kecamatan
	 * MA-296
	 * @params kabupaten_id
	 */
	public function actionGetDataKecamatans(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['kabupaten_id'])){
			$data = $this->getKelurahans($_GET['kabupaten_id']);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menampilkan data kelurahan
	 * MA-296
	 * @params kecamatan_id
	 */
	public function actionGetDataKelurahans(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['kecamatan_id'])){
			$data = $this->getKelurahans($_GET['kecamatan_id']);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menampilkan data penjamin pasien
	 * MA-296
	 * @params carabayar_id
	 */
	public function actionGetDataPenjamins(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['carabayar_id'])){
			$data = $this->getPenjamins($_GET['carabayar_id']);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menampilkan data kelas pelayanan ruangan
	 * MA-296
	 * @params ruangan_id
	 */
	public function actionGetDataKelaspelayanans(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id'])){
			$data = $this->getKelaspelayanans($_GET['ruangan_id']);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menampilkan data kelas pelayanan ruangan
	 * MA-296
	 * @params ruangan_id
	 */
	public function actionGetDataJeniskasuspenyakits(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id'])){
			$data = $this->getJeniskasuspenyakits($_GET['ruangan_id']);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * menampilkan data penjamin pasien
	 * MA-296
	 * @params pasien_id
	 * @params penjamin_id
	 * @params q
	 */
	public function actionGetDataAsuransiPasiens(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['pasien_id']) && isset($_GET['penjamin_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT *
				FROM asuransipasien_m
				WHERE asuransipasien_m.pasien_id = ".$_GET['pasien_id']."
					AND asuransipasien_m.penjamin_id = ".$_GET['penjamin_id']."
					AND (
						LOWER(asuransipasien_m.nokartuasuransi) like '%".$req."%'
						OR LOWER(asuransipasien_m.nopeserta) like '%".$req."%'
						OR LOWER(asuransipasien_m.namapemilikasuransi) like '%".$req."%'
						OR LOWER(asuransipasien_m.namaperusahaan) like '%".$req."%'
						OR LOWER(asuransipasien_m.nomorpokokperusahaan) like '%".$req."%'
						OR LOWER(asuransipasien_m.nokartukeluarga) like '%".$req."%'
					)
				ORDER BY asuransipasien_m.asuransipasien_id ASC";
			$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
			if(count((array)$loadDatas) > 0){
				$data = $loadDatas;
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi pendaftaran rawat jalan (klinik)
	 * MA-282
	 * @param $_GET['pasien'] array
	 * @param $_GET['pendaftaran'] array
	 * @return json
	 */
	public function actionPendaftaranRJ(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pasien']) && isset($_GET['pendaftaran'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$modPasien = new MOPasienM;
				$modPasien->attributes = $_GET['pasien'];
				$statuspasien = Params::STATUSPASIEN_BARU;
				if(!empty($model->pasien_id)){
					$modPasien = MOPasienM::model()->findByPk($modPasien->pasien_id);
					$modPasien->update_time = date("Y-m-d H:i:s");
					$statuspasien = Params::STATUSPASIEN_LAMA;
				}else{
					$modPasien->pasien_id = null; //agar auto sequence tidak error
				}
				$modPasien->tgl_rekam_medik = date("Y-m-d");
				$modPasien->create_time = date("Y-m-d H:i:s");
				$modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
				$modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
				if($modPasien->save()){
					$modPendaftaran = new MOPendaftaranT;
					$modPendaftaran->attributes = $_GET['pendaftaran'];
					$modPendaftaran->tgl_pendaftaran = (empty($modPendaftaran->tgl_pendaftaran) ? date("Y-m-d H:i:s") : $modPendaftaran->tgl_pendaftaran);
					$modPendaftaran->create_time = date("Y-m-d H:i:s");
					$modPendaftaran->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
					$modPendaftaran->statusmasuk = (!empty($modPendaftaran->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
					$modPendaftaran->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
					$modPendaftaran->statuspasien = $statuspasien;
					$modPendaftaran->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
					$modPendaftaran->kunjungan = CustomFunction::getKunjungan($modPasien, $modPendaftaran->ruangan_id);
					$modPendaftaran->no_pendaftaran = MyGenerator::noPendaftaran($modPendaftaran->instalasi_id);
					$modPendaftaran->no_urutantri = MyGenerator::noAntrian($modPendaftaran->ruangan_id);
					if($modPendaftaran->save()){
						$transaction->commit();
						$data['sukses'] = 1;
						$data['pesan'] = 'Data pasien dan pendaftaran berhasil disimpan!';
					}else{
						$transaction->rollback();
						$data['sukses'] = 0;
						$data['pesan'] = 'Data pendaftaran gagal disimpan!<br>'.CHtml::errorSummary($modPendaftaran);
					}
				}else{
					$transaction->rollback();
					$data['sukses'] = 0;
					$data['pesan'] = 'Data pasien gagal disimpan! <br>'.CHtml::errorSummary($modPasien);
				}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data pasien dan pendaftaran gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
			}

		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * menampilkan umur berdasarkan tanggal lahir
	 * MA-304
	 * @param type $tgl_lahir
	 */
	public function actionGetUmur(){
		header("content-type:application/json");
		if(isset($_GET['tanggal_lahir'])){
			$data['umur'] = CustomFunction::getUmur($_GET['tanggal_lahir']);
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
     * menampilkan jadwal pegawai
     * MA-343
     * @params $_GET['pegawai_id']
     * @params $_GET['bulan'] : yyyy-mm
     */
    public function actionGetJadwalDokter(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['pegawai_id']) && isset($_GET['bulan'])){
            $pegawai_id = $_GET['pegawai_id'];
            $bulan = $_GET['bulan'];
            $sql = "
                (
                    SELECT
                    buatjanjipoli_t.tgljadwal AS tgljadwal,pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama,
                    ruangan_m.ruangan_nama, 'Janji Poliklinik'AS keterangan , pasien_m.nama_pasien , harijadwal as hari
                    FROM buatjanjipoli_t
                    LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = buatjanjipoli_t.pegawai_id
                    LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
                    LEFT JOIN pasien_m ON pasien_m.pasien_id = buatjanjipoli_t.pasien_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = buatjanjipoli_t.ruangan_id
                    WHERE buatjanjipoli_t.pegawai_id = ".$pegawai_id."
                        ".(!empty($_GET['bulan']) ? " AND TO_CHAR(buatjanjipoli_t.tgljadwal,'YYYY-MM') = '".$bulan : "")."'
                )
                ORDER BY tgljadwal ASC
                ";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(count((array)$loadDatas) > 0){
                foreach($loadDatas AS $i => $val){
                    $data[$i] = $val;
                    $data[$i]['nama_pegawai'] = $val['gelardepan']." ".$val['nama_pegawai']." ".$val['gelarbelakang_nama'];
                    $data[$i]['tgljadwal'] = $format->formatDateTimeForUser($val['tgljadwal']);
                }
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }

    /**
     * menampilkan data dashboard
     * MA-350
     */
    public function actionGetDashboard(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        if(isset($_GET['dokter_id'])){
        	$sql_pendaftaran = "SELECT count(pendaftaran_id) as total_pendaftaran, DATE(tgl_pendaftaran) as tgl_pendaftaran FROM pendaftaran_t
	        WHERE DATE(tgl_pendaftaran) = '".date("Y-m-d")."'
	        AND pegawai_id = ".$_GET['dokter_id']."
	        GROUP BY DATE(tgl_pendaftaran)";
	        $result_pendaftaran = Yii::app()->db->createCommand($sql_pendaftaran)->queryRow();

	        $sql_panggil = "SELECT count(panggilantrian) as jum_dipanggil, DATE(tgl_pendaftaran) as tgl_pendaftaran FROM pendaftaran_t
	        WHERE DATE(tgl_pendaftaran) = '".date("Y-m-d")."'
	        AND pegawai_id = ".$_GET['dokter_id']."
	        AND panggilantrian is true
	        GROUP BY DATE(tgl_pendaftaran)";
	        $jum_dipanggil = Yii::app()->db->createCommand($sql_panggil)->queryRow();
			if(!empty($result_pendaftaran)){
				$data['pendaftaran']['total_pendaftaran'] = isset($result_pendaftaran['total_pendaftaran'])?$result_pendaftaran['total_pendaftaran']:0;
				if(count((array)$jum_dipanggil)>0)
					$data['pendaftaran']['jum_dipanggil'] = isset($jum_dipanggil['jum_dipanggil'])?$jum_dipanggil['jum_dipanggil']:0;
				$data['pendaftaran']['current_date'] = $format->formatDateTimeForUser(date('Y-m-d'));
				$data['pendaftaran']['current_day'] = $format->getDayUser(date('w'));
			}

			$sql_masukkeri = "SELECT count(pendaftaran_id) as total_pasien, DATE(tgl_pendaftaran) as tgl_pendaftaran FROM pendaftaran_t
	        WHERE DATE(tgl_pendaftaran) = '".date("Y-m-d")."'
	        AND pegawai_id = ".$_GET['dokter_id']."
	        AND alihstatus is true
	        AND instalasi_id = ".Params::INSTALASI_ID_RI."
	        GROUP BY DATE(tgl_pendaftaran)";
	        $result_masukkeri = Yii::app()->db->createCommand($sql_masukkeri)->queryRow();
			if(!empty($result_masukkeri)){
				$data['masukkeri']['total_pasien'] = isset($result_masukkeri['total_pasien'])?$result_masukkeri['total_pasien']:0;
				$data['masukkeri']['current_month'] = $format->getMonthId(date('m'));
				$data['masukkeri']['current_year'] = date('Y');
			}

			$sql_masukkelab = "SELECT count(pasien_id) as total_pasien FROM pasienmasukpenunjang_t JOIN ruangan_m
			ON pasienmasukpenunjang_t.ruangan_id = ruangan_m.ruangan_id
			WHERE DATE(tglmasukpenunjang) BETWEEN '".date('Y-m')."-01' AND '".date('Y-m-d')."' AND pegawai_id = ".$_GET['dokter_id']." AND ruangan_m.instalasi_id = ".Params::INSTALASI_ID_LAB;
	        $result_masukkelab = Yii::app()->db->createCommand($sql_masukkelab)->queryRow();

			if(!empty($result_masukkelab)){
				$data['masukkelab']['total_pasien'] = $result_masukkelab['total_pasien'];
				$data['masukkelab']['current_month'] = $format->getMonthId(date('m'));
				$data['masukkelab']['current_year'] = date('Y');
			}

			$sql_masukkerad = "SELECT count(pasien_id) as total_pasien FROM pasienmasukpenunjang_t
					JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id = ruangan_m.ruangan_id WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
	        AND pegawai_id = ".$_GET['dokter_id']."
	        AND instalasi_id = ".Params::INSTALASI_ID_RAD;
	        $result_masukkerad = Yii::app()->db->createCommand($sql_masukkerad)->queryRow();
			if(!empty($result_masukkerad)){
				$data['masukkerad']['total_pasien'] = $result_masukkerad['total_pasien'];
				$data['masukkerad']['current_month'] = $format->getMonthId(date('m'));
				$data['masukkerad']['current_year'] = date('Y');
			}

			$sql_masukkerd = "SELECT count(pendaftaran_id) as total_pasien, DATE(tgl_pendaftaran) as tgl_pendaftaran FROM pendaftaran_t
	        WHERE DATE(tgl_pendaftaran) = '".date("Y-m-d")."'
			AND pendaftaran_t.pasienbatalperiksa_id IS NULL
	        AND pegawai_id = ".$_GET['dokter_id']."
	        AND alihstatus is true
	        AND instalasi_id = ".Params::INSTALASI_ID_RD."
	        GROUP BY DATE(tgl_pendaftaran)";
	        $result_masukkerd = Yii::app()->db->createCommand($sql_masukkerd)->queryRow();
			if(!empty($result_masukkerd)){
				$data['masukkerd']['total_pasien'] = isset($result_masukkerd['total_pasien'])?$result_masukkerd['total_pasien']:0;
				$data['masukkerd']['current_month'] = $format->getMonthId(date('m'));
				$data['masukkerd']['current_year'] = date('Y');
			}

			$sql_masukkerj = "SELECT count(pendaftaran_id) as total_pasien, DATE(tgl_pendaftaran) as tgl_pendaftaran FROM pendaftaran_t
	        WHERE DATE(tgl_pendaftaran) = '".date("Y-m-d")."'
	        AND pegawai_id = ".$_GET['dokter_id']."
	        AND alihstatus is true
	        AND instalasi_id = ".Params::INSTALASI_ID_RJ."
	        GROUP BY DATE(tgl_pendaftaran)";
	        $result_masukkerj = Yii::app()->db->createCommand($sql_masukkerj)->queryRow();
			if(!empty($result_masukkerj)){
				$data['masukkerj']['total_pasien'] = isset($result_masukkerj['total_pasien'])?$result_masukkerj['total_pasien']:0;
				$data['masukkerj']['current_month'] = $format->getMonthId(date('m'));
				$data['masukkerj']['current_year'] = date('Y');
			}

			$sql_masukkebedahsentral = "SELECT count(pasien_id) as total_pasien FROM pasienmasukpenunjang_t
				JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
	        WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
	        AND pegawai_id = ".$_GET['dokter_id']."
	        AND ruangan_m.instalasi_id = ".Params::INSTALASI_ID_IBS;
	        $result_masukkebs = Yii::app()->db->createCommand($sql_masukkebedahsentral)->queryRow();
			if(!empty($result_masukkebs)){
				$data['masukkebs']['total_pasien'] = $result_masukkebs['total_pasien'];
				$data['masukkebs']['current_month'] = $format->getMonthId(date('m'));
				$data['masukkebs']['current_year'] = date('Y');
			}

			$sql_jadwal = "SELECT
			instalasi_m.instalasi_nama,
			ruangan_m.ruangan_nama,
			jadwaldokter_m.jadwaldokter_tgl,
			jadwaldokter_m.jadwaldokter_buka
			FROM jadwaldokter_m
			join instalasi_m on jadwaldokter_m.instalasi_id = instalasi_m.instalasi_id
			join ruangan_m on ruangan_m.ruangan_id = ruangan_m.ruangan_id
	        WHERE DATE(jadwaldokter_m.jadwaldokter_tgl) >= '".date("Y-m-d")."'
	        AND jadwaldokter_m.pegawai_id = ".$_GET['dokter_id']."
	        ORDER BY jadwaldokter_m.jadwaldokter_tgl ASC
	        limit 1";
	        $result_jadwal = Yii::app()->db->createCommand($sql_jadwal)->queryRow();
			if(!empty($result_jadwal)){
				$data['jadwal']['instalasi'] = isset($result_jadwal['instalasi_nama'])?$result_jadwal['instalasi_nama']:'-';
				$data['jadwal']['ruangan'] = isset($result_jadwal['ruangan_nama'])?$result_jadwal['ruangan_nama']:'-';
				$data['jadwal']['buka'] = isset($result_jadwal['jadwaldokter_buka'])?$result_jadwal['jadwaldokter_buka']:'-';
				$data['jadwal']['scheduled_date'] = isset($result_jadwal['jadwaldokter_tgl'])?$format->formatDateTimeForUser($result_jadwal['jadwaldokter_tgl']):'-';
			}
       	}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    public function actionGetNotif() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['pegawai_id'])) {
            $pegawai_id = isset($_GET['pegawai_id'])?$_GET['pegawai_id']:'';
			$sql = "SELECT * FROM notifikasi_r 
                                WHERE pegawai_id=".$pegawai_id." AND date(tglnotifikasi) = '".date('Y-m-d')."'
                                ORDER BY tglnotifikasi DESC
                                limit 10"
                                ;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
           
			$sql2 = "SELECT * FROM notifikasi_r 
                                WHERE pegawai_id=".$pegawai_id." AND isread = FALSE AND date(tglnotifikasi) = '".date('Y-m-d')."'
                                ORDER BY tglnotifikasi DESC
                                limit 10"
                                ;
            
            $loadDatas = Yii::app()->db->createCommand($sql2)->queryAll();
            $data['data'] = $loadData;
//            $data['ring'] = '';
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
                $data['ring'] = count((array)$loadDatas);
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackNotifikasi(".$encode.")";
    }
}
