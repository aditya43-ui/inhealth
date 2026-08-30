<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MRawatJalanController
 *
 * @author programer
 */
ini_set('memory_limit', '128M');
class MRawatJalanController extends Controller {
	//put your code here
	/**
	 * set form pendaftaran rawat jalan
	 * MA-281
	 * @params: ruangan_id, pendaftaran_id, pasienadmisi_id
	 * @return:
	 * -
	 */

	 public $pasienpulangtersimpan,$rujukantersimpan,$admisitersimpan,$masukkamartersimpan,$rujukrisukses,$pasientersimpan,$asuransipasientersimpan;

	public function actionSetFormPendaftaran(){
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
		if(count($loadDatas) > 0){
			foreach($loadDatas AS $i => $val){
				$data[$val["lookup_type"]][] = $val;
			}
		}
		$sql = "SELECT pekerjaan_id, pekerjaan_nama
				FROM pekerjaan_m
				WHERE pekerjaan_aktif = TRUE
				ORDER BY pekerjaan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['pekerjaan'] = $loadDatas;
		}
		$sql = "SELECT lookup_id, lookup_name, lookup_value
				FROM lookup_m
				WHERE lookup_aktif = TRUE
				AND lookup_type = 'warganegara'
				ORDER BY lookup_value";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['warganegara'] = $loadDatas;
		}
		$sql = "SELECT pendidikan_id, pendidikan_nama
				FROM pendidikan_m
				WHERE pendidikan_aktif = TRUE
				ORDER BY pendidikan_urutan";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['pendidikan'] = $loadDatas;
		}
		//$data['propinsi'] = $this->getPropinsis();
		//$data['kabupaten'] = (isset($_GET['propinsi_id']) ? $this->getKabupatens($_GET['propinsi_id']) : array());
		//$data['kecamatan'] = (isset($_GET['kabupaten_id']) ? $this->getKecamatans($_GET['kabupaten_id']) : array());
		//$data['kelurahan'] = (isset($_GET['kecamatan_id']) ? $this->getKelurahans($_GET['kecamatan_id']) : array());

		$sql = "SELECT ruangan_id, ruangan_nama
				FROM ruangan_m
				WHERE ruangan_aktif = TRUE
				ORDER BY ruangan_nama";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['ruangan'] = $loadDatas;
		}

		//$data['jeniskasuspenyakit'] = $this->getJeniskasuspenyakits($ruangan_id);

		//$data['kelaspelayanan'] = $this->getKelaspelayanans($ruangan_id);

		//$data['kelastanggunganasuransi'] = $this->getKelaspelayanans();

		if(!empty($carabayar_id)){
			$data['penjamin'] = $this->getPenjamins($carabayar_id);
		}

		$sql = "SELECT carabayar_id, carabayar_nama
				FROM carabayar_m
				WHERE carabayar_aktif = TRUE
				ORDER BY carabayar_nourut";
		$loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
		if(count($loadDatas) > 0){
			$data['carabayar'] = $loadDatas;
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
    * action untuk mendapatkan list kamar
    * @param q
    * @return array of kamar
    */
    public function actionGetRoom() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
			$sql = "SELECT * FROM ruanganrawatjalan_v
                WHERE ruangan_aktif= TRUE AND (LOWER(ruangan_nama) like '%".$q."%'
                OR LOWER(ruangan_namalainnya) like '%".$q."%'
                OR LOWER(ruangan_singkatan) like '%".$q."%')
                ORDER BY ruangan_nama";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
	/**
    * action untuk mendapatkan list kamar
    * @param q
    * @return array of kamar
    */
    public function actionGetRoomRI() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $sql = "SELECT * FROM ruangan_m
                WHERE ruangan_aktif= TRUE AND (LOWER(ruangan_nama) like '%".$q."%'
                OR LOWER(ruangan_namalainnya) like '%".$q."%'
                OR LOWER(ruangan_singkatan) like '%".$q."%')
                AND instalasi_id=".Params::INSTALASI_ID_RI."
                AND ruangan_aktif IS TRUE
                ORDER BY ruangan_nama";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = count($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackRuangan(".$encode.")";
    }

	/**
    * action untuk mendapatkan list ruangan rawat jalan berdasarkan id pegawai
    * @param instalasi_id
    * @return array of kamar
    */
    public function actionGetRoomDokter() {
        header("content-type:application/json");
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['pegawai_id'])) {
            $q = strtolower($_GET['q']);
            $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, instalasi_m.instalasi_id, instalasi_m.instalasi_nama
                            FROM ruangan_m JOIN ruanganpegawai_m ON ruangan_m.ruangan_id=ruanganpegawai_m.ruangan_id
                            JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                            WHERE ruanganpegawai_m.pegawai_id = ".$_GET['pegawai_id']." AND (LOWER(ruangan_m.ruangan_nama) LIKE '%".$q."%' OR LOWER(instalasi_m.instalasi_nama) LIKE '%".$q."%') ORDER BY instalasi_m.instalasi_id";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            if (count($loadData)>0) {
                $data['data'] = $loadData;
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }
    
    /**
     * action untuk mendapatkan list jenis kasus penyakit
     * @param q
     * @return array of jenis kasus penyakit
     */
    public function actionGetKasusPenyakit() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['q']) && isset($_GET['ruangan_id'])) {
            $q = !empty($_GET['q'])?"AND (LOWER(jeniskasuspenyakit_nama) like '%".strtolower($_GET['q'])."%'
                    OR LOWER(jeniskasuspenyakit_namalainnya) like '%".strtolower($_GET['q'])."%')":"";
            $ruangan_id = $_GET['ruangan_id'];
            $sql = "SELECT * FROM jeniskasuspenyakit_m JOIN kasuspenyakitruangan_m
                    ON kasuspenyakitruangan_m.jeniskasuspenyakit_id= jeniskasuspenyakit_m.jeniskasuspenyakit_id
                    WHERE kasuspenyakitruangan_m.ruangan_id = $ruangan_id $q
                    AND jeniskasuspenyakit_aktif= TRUE 
                    ORDER BY jeniskasuspenyakit_nama LIMIT 8 OFFSET 0";				// echo $sql;exit;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackKasusPenyakit(".$encode.")";
    }
    
    /**
     * action untuk mendapatkan list kelas pelayanan
     * @param q
     * @return array of kelas pelayanaan
     */
    public function actionGetKelasPelayanan() {
        header("content-type:application/json");
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemuuukan!";
        $data['data'] = array();
        if (isset($_GET['ruangan_id'])) {
            $sql = "SELECT * FROM kelasruangan_m
                    JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = kelasruangan_m.ruangan_id
                    WHERE kelaspelayanan_m.kelaspelayanan_aktif= TRUE AND ruangan_m.ruangan_id = ".$_GET['ruangan_id']."
                    ORDER BY kelaspelayanan_m.kelaspelayanan_nama";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackKelasPelayanan(".$encode.")";
    }
    
    
    /**
     * action untuk mendapatkan list kelas pelayanan
     * @param q
     * @return array of kelas pelayanaan
     */
    public function actionGetHasilLab(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['pendaftaran_id'])){
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $sql = " SELECT hasilpemeriksaanlab_t.pendaftaran_id, hasilpemeriksaanlab_t.hasilpemeriksaanlab_id,
                    nilairujukan_m.namapemeriksaandet,
                    pemeriksaanlab_m.pemeriksaanlab_id, pemeriksaanlab_m.pemeriksaanlab_nama,
                    jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
                    detailhasilpemeriksaanlab_t.nilairujukan, detailhasilpemeriksaanlab_t.hasilpemeriksaan, detailhasilpemeriksaanlab_t.hasilpemeriksaan_metode FROM hasilpemeriksaanlab_t
                    JOIN detailhasilpemeriksaanlab_t ON detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = hasilpemeriksaanlab_t.hasilpemeriksaanlab_id 
                    JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = detailhasilpemeriksaanlab_t.pemeriksaanlab_id 
                    JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                    JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id 
                    JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id 
                    WHERE hasilpemeriksaanlab_t.pendaftaran_id = ".$pendaftaran_id." ";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if(!empty($loadData)){
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackHasilLab(".$encode.")";
    }
    
    /**
     * action untuk mendapatkan list kelas pelayanan
     * @param q
     * @return array of kelas pelayanaan
     */
    public function actionGetCatatanDokter(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['pendaftaran_id'])){
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $sql = "SELECT pendaftaran_id, monitoring FROM pemeriksaanfisik_t
                    WHERE pendaftaran_id = ".$pendaftaran_id." ";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if(!empty($loadData)){
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackMonitoring(".$encode.")";
    }

	/**
    * action untuk mendapatkan list grup penjamin
    * @param q
	* @param
    * @return array of guarantor group
    */
    public function actionGetCaraBayar() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $sql = "SELECT * from carabayar_m WHERE (LOWER(carabayar_nama) LIKE '%$q%' "
                . "OR LOWER(carabayar_namalainnya) LIKE '%$q%' OR LOWER(carabayar_loket) LIKE '%$q%' "
                . "OR LOWER(carabayar_singkatan) ='$q') AND carabayar_aktif= TRUE "
                . "ORDER BY carabayar_nama LIMIT 8 OFFSET 0";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }

	/**
    * action untuk mendapatkan data anamnesa
    * @param pendaftaran_id
    * @return array of anamnesa
    */
    public function actionGetAnamnesa() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['pendaftaran_id'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
            $sql = "SELECT * FROM anamnesa_t a JOIN pegawai_m p ON a.pegawai_id=p.pegawai_id "
                . "WHERE pendaftaran_id=".$pendaftaran_id;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            foreach ($data['data'] as $i => $val) {
                $data['data'][$i]['tglanamnesis'] = date('d-m-Y H:i',strtotime($val['tglanamnesis']));
            }
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }

    /**
     * action untuk mendapatkan list penjamin
     * @param q
     * @return array of guarantor
     */
    public function actionGetPenjamin() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $carabayar_id = strtolower($_GET['carabayar_id']);
            $sql = "SELECT * from penjaminpasien_m WHERE (LOWER(penjamin_nama) LIKE '%$q%' "
                . "OR LOWER(penjamin_namalainnya) LIKE '%$q%') "
                . "AND penjamin_aktif=TRUE AND carabayar_id=$carabayar_id"
                . "ORDER BY penjamin_nama LIMIT 8 OFFSET 0";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }

	/**
    * action untuk mendapatkan list penjamin
    * @param q
	* @param
    * @return array of guarantor
    */
    public function actionGetDokterRI() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $ruanganID = $_GET['ruangan_id'];
            $sql = "SELECT * from dokter_v WHERE (ruangan_id = $ruanganID AND LOWER(nama_pegawai) LIKE '%$q%' "
            . "AND LOWER(gelardepan) LIKE '%$q%') AND pegawai_aktif=TRUE ORDER BY nama_pegawai";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = count($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackDokterRI(".$encode.")";
    }

	/**
    * action untuk mendapatkan list penjamin
    * @param q
	* @param
    * @return array of guarantor
    */
    public function actionGetDokter() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $ruanganID = $_GET['ruangan_id'];
            $sql = "SELECT * from dokter_v WHERE (ruangan_id = $ruanganID AND LOWER(nama_pegawai) LIKE '%$q%' "
                . "AND LOWER(gelardepan) LIKE '%$q%') AND pegawai_aktif=TRUE";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
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
		if(isset($_GET['Pasien']) && isset($_GET['Pendaftaran'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				if (isset($_GET['Pasien']['pasien_id'])) {
					$oldPasienID = $_GET['Pasien']['pasien_id'];
				}else {
					$oldPasienID = "";
				}


				if ($oldPasienID==''||$oldPasienID==null) {
					$modPasien = new MOPasienM;
					$modPasien->attributes = $_GET['Pasien'];
					$statuspasien = Params::STATUSPASIEN_BARU;
					$modPasien->pasien_id = null; //agar auto sequence tidak error
				}else {
					$modPasien = MOPasienM::model()->findByPk($oldPasienID);
					$modPasien->update_time = date("Y-m-d H:i:s");
					$statuspasien = Params::STATUSPASIEN_LAMA;
				}
				$modPasien->tgl_rekam_medik = date("Y-m-d");
				$modPasien->statusrekammedis = 'AKTIF';
				$modPasien->loginpemakai_id = 1;
				$modPasien->create_loginpemakai_id = 1;
				$modPasien->update_time = date('Y-m-d H:i:s');
				$modPasien->create_time = date("Y-m-d H:i:s");
				$modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
				//print_r($modPasien);
				//exit;
				$modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
				if ($modPasien->save()){
					$modPendaftaran = new MOPendaftaranT;
					$modPendaftaran->attributes = $_GET['Pendaftaran'];
					$modPendaftaran->pasien_id = $modPasien->pasien_id;
					$modPendaftaran->tgl_pendaftaran = (empty($modPendaftaran->tgl_pendaftaran) ? date("Y-m-d H:i:s") : $modPendaftaran->tgl_pendaftaran);
					$modPendaftaran->create_time = date("Y-m-d H:i:s");
					$modPendaftaran->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
					$modPendaftaran->statusmasuk = (!empty($modPendaftaran->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
					$modPendaftaran->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
					$modPendaftaran->statuspasien = $statuspasien;
					$modPendaftaran->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
					$modPendaftaran->kunjungan = CustomFunction::getKunjungan($modPasien, $modPendaftaran->ruangan_id);
					$modPendaftaran->no_pendaftaran = MyGenerator::noPendaftaran(Params::INSTALASI_ID_RJ);
					$modPendaftaran->no_urutantri = MyGenerator::noAntrian($modPendaftaran->ruangan_id);
					$modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
					//$modPendaftaran->loginpemakai_id = 1;
					$modPendaftaran->create_loginpemakai_id = 1;
					//$data['umur'] = CustomFunction::getUmur($_GET['tanggal_lahir']);
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
	 * action untuk mendapatkan tanggal lahir pasien
	 * @param tanggallahir pasien
	 * @return umur pasien
	 */
	public function actionGetUmurPasien() {
        header("content-type:application/json");
            $format = new MyFormatter();
            $data = array();
            if (isset($_GET['tanggal_lahir'])){
                $tanggalLahir = $_GET['tanggal_lahir'];
                $data['umur'] = CustomFunction::hitungUmur($tanggalLahir);
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

    /**
     * action untuk mendapatkan list pasien
     * @param q, status, sort date, sort name
     * @return array list pasien
     *
     */
    public function actionGetDaftarPasien() {
    header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        $statusPasien = '';
        $tglPendaftaran = '';
        if (isset($_GET['q'])&&isset($_GET['status'])&&isset($_GET['start_date'])&&isset($_GET['end_date'])&&isset($_GET['pegawai_id'])&&isset($_GET['ruangan_id'])&&isset($_GET['instalasi_tab'])) {
            $q = strtolower($_GET['q']);
            $statusPeriksa = $_GET['status'];
            $startDate = $_GET['start_date'];
            $endDate = $_GET['end_date'];
            $pegawai_id = isset($_GET['pegawai_id'])?$_GET['pegawai_id']:'';
            $ruangan_id = isset($_GET['ruangan_id'])?$_GET['ruangan_id']:'';
            if ($statusPeriksa==""){
                $statusStr='';
            }else{
                $statusStr = "AND statusperiksa='".$statusPeriksa."'";
            }
            if ($ruangan_id==""){
                $ruangan_id='';
            }else{
                if($_GET['instalasi_tab'] == 'RI'){
                    $ruangan_id = "pasienadmisi_t.ruangan_id='".$ruangan_id."' AND";
                }else{
                    $ruangan_id = "pendaftaran_t.ruangan_id='".$ruangan_id."' AND";
                }
            }
            if(isset($_GET['offset'])){
                if(!empty($_GET['offset'])){
                    $offset = ' OFFSET '.$_GET['offset'];
                }else{
                    $offset = '';
                }
            }else{
                $offset = '';
            }
            if ($startDate!='' && $endDate!='') {
                if($_GET['instalasi_tab'] == 'RI'){
                    $strBetween = " AND pasienadmisi_t.tgladmisi::timestamp::date BETWEEN '".MyFormatter::formatDateTimeForDb($startDate)."' AND '".MyFormatter::formatDateTimeForDb($endDate)."'";
                }else{
                    $strBetween = " AND tgl_pendaftaran::timestamp::date BETWEEN '".MyFormatter::formatDateTimeForDb($startDate)."' AND '".MyFormatter::formatDateTimeForDb($endDate)."'";
                }
            }else {
                if($_GET['instalasi_tab'] == 'RI'){
                     $strBetween = "AND pasienadmisi_t.tgladmisi::timestamp::date='".date('Y-m-d')."'";
                }else{
                    $strBetween = "AND tgl_pendaftaran::timestamp::date='".date('Y-m-d')."'";
                }
            }

            if ($tglPendaftaran=='') {
                $tglPendaftaran = date('Y-m-d');
            }
            if($_GET['instalasi_tab'] == 'RJ'){
                $sql = "SELECT pendaftaran_t.*,pasien_m.nama_pasien,pasien_m.pasien_id,pasien_m.no_rekam_medik,pasien_m.namadepan,pasien_m.no_identitas_pasien,pasien_m.jeniskelamin,pasien_m.alamat_pasien,pasien_m.statusperkawinan,pasien_m.agama,pasien_m.golongandarah,pasien_m.no_telepon_pasien,pasien_m.no_mobile_pasien,pasien_m.photopasien,pasien_m.alamatemail,instalasi_m.instalasi_id,instalasi_m.instalasi_nama,ruangan_m.ruangan_id,ruangan_m.ruangan_nama,jeniskasuspenyakit_m.jeniskasuspenyakit_id,jeniskasuspenyakit_m.jeniskasuspenyakit_nama from pendaftaran_t
                        JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                        JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
                        WHERE $ruangan_id pendaftaran_t.instalasi_id = ".PARAMS::INSTALASI_ID_RJ." AND pasienadmisi_id IS NULL AND pendaftaran_t.pegawai_id=".$pegawai_id." AND (LOWER(nama_pasien) LIKE '%$q%' OR LOWER(no_rekam_medik) LIKE '%$q%') ".$statusStr.$strBetween." AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_SUDAH_PULANG."' AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."'
                        ORDER BY no_urutantri ASC LIMIT 8".$offset;
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            }else if($_GET['instalasi_tab'] == 'RI'){
                $sql = "SELECT pendaftaran_t.*,pasien_m.nama_pasien,pasien_m.pasien_id,pasien_m.no_rekam_medik,pasien_m.namadepan,pasien_m.no_identitas_pasien,pasien_m.jeniskelamin,pasien_m.alamat_pasien,pasien_m.statusperkawinan,pasien_m.agama,pasien_m.golongandarah,pasien_m.no_telepon_pasien,pasien_m.no_mobile_pasien,pasien_m.photopasien,pasien_m.alamatemail,instalasi_m.instalasi_id,instalasi_m.instalasi_nama,ruangan_m.ruangan_id,ruangan_m.ruangan_nama,jeniskasuspenyakit_m.jeniskasuspenyakit_id,jeniskasuspenyakit_m.jeniskasuspenyakit_nama from pendaftaran_t "
                        ."JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id "
                        ."JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id "
                        ."JOIN ruangan_m ON pasienadmisi_t.ruangan_id = ruangan_m.ruangan_id "
                        ."JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id "
                        ."JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id "
                        ."WHERE $ruangan_id pasienadmisi_t.pegawai_id=".$pegawai_id." AND (LOWER(nama_pasien) LIKE '%$q%' OR LOWER(no_rekam_medik) LIKE '%$q%') ".$statusStr.$strBetween." AND pendaftaran_t.statusperiksa = '".PARAMS::STATUSPERIKSA_SEDANG_DIRAWATINAP."' AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_SUDAH_PULANG."' AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' "
                        ."ORDER BY no_urutantri ASC LIMIT 8".$offset;
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            }else if($_GET['instalasi_tab'] == 'RD'){
                $sql = "SELECT pendaftaran_t.*,pasien_m.nama_pasien,pasien_m.pasien_id,pasien_m.no_rekam_medik,pasien_m.namadepan,pasien_m.no_identitas_pasien,pasien_m.jeniskelamin,pasien_m.alamat_pasien,pasien_m.statusperkawinan,pasien_m.agama,pasien_m.golongandarah,pasien_m.no_telepon_pasien,pasien_m.no_mobile_pasien,pasien_m.photopasien,pasien_m.alamatemail,instalasi_m.instalasi_id,instalasi_m.instalasi_nama,ruangan_m.ruangan_id,ruangan_m.ruangan_nama,jeniskasuspenyakit_m.jeniskasuspenyakit_id,jeniskasuspenyakit_m.jeniskasuspenyakit_nama from pendaftaran_t
                        JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                        JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
                        JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
                        WHERE $ruangan_id pendaftaran_t.instalasi_id = ".PARAMS::INSTALASI_ID_RD." AND pasienadmisi_id IS NULL AND pendaftaran_t.pegawai_id=".$pegawai_id." AND (LOWER(nama_pasien) LIKE '%$q%' OR LOWER(no_rekam_medik) LIKE '%$q%') ".$statusStr.$strBetween." AND pendaftaran_t.statusperiksa != ' ".PARAMS::STATUSPERIKSA_SUDAH_PULANG."' AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."'
                        ORDER BY no_urutantri ASC LIMIT 8".$offset;
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            }
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackDaftarPasien".$_GET['instalasi_tab']."(".$encode.")";
    }
    
        /**
	 * action untuk mendapatkan daftar info jasa dokter
	 * @param pegawai_id
	 * @param startDate, tanggal awal filter info jasas dokter
	 * @param endDate, tanggal akhir filter info jasa dokter
	 * @param q, keyword untuk nama pasien, no pendaftaran, no rekam medik
	 * @return array dari info jasa dokter
	 */
	public function actionGetInfoJasaDokter() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data not found!";
            $data['jasdok'] = array();
            $tgl = '';
            $i = 0;
            if (isset($_GET['sta_date']) && isset($_GET['end_date']) && isset($_GET['pegawai_id']) && isset($_GET['ruangan_id']) && isset($_GET['instalasi_tab_jasdok'])) {
                $tgl_awal = $_GET['sta_date'];
                $tgl_akhir = $_GET['end_date'];
                $pegawai_id = $_GET['pegawai_id'];
                $ruangan_id = isset($_GET['ruangan_id'])?$_GET['ruangan_id']:'';
                if ($tgl_awal !='' && $tgl_akhir!='') {
                    $tgl = 'AND DATE(tp.tgl_tindakan) BETWEEN \''.MyFormatter::formatDateTimeForDb($tgl_awal).'\' AND \''.MyFormatter::formatDateTimeForDb($tgl_akhir).'\'';
                }else{
                    $tgl = 'AND DATE(tp.tgl_tindakan) = \''.date('Y-m-d').'\'';
                }
                if(isset($_GET['offset'])){
                    if(!empty($_GET['offset'])){
                        $offset = ' OFFSET '.$_GET['offset'];
                    }else{
                        $offset = '';
                    }
                }else{
                    $offset = '';
                }
                if ($ruangan_id==""){
                    $ruangan_id='';
                }else{
                    if($_GET['instalasi_tab_jasdok'] == 'RI'){
                        $ruangan_id = "pd.ruangan_id='".$ruangan_id."' AND";
                    }else{
                        $ruangan_id = "pn.ruangan_id='".$ruangan_id."' AND";
                    }
                }
                if($_GET['instalasi_tab_jasdok'] == 'RJ'){
                    $sql = " SELECT pn.pendaftaran_id, pn.tgl_pendaftaran, tp.dokterpemeriksa1_id, pn.no_pendaftaran, 
                        pa.no_rekam_medik, pa.pasien_id, pa.nama_pasien, pa.jeniskelamin, pa.alamat_pasien, tp.tgl_tindakan, tp.tindakanpelayanan_id,
                        dt.daftartindakan_nama, sum(tk.tarif_tindakankomp) AS tarif_rj
                        FROM tindakanpelayanan_t tp
                        LEFT JOIN tindakankomponen_t tk on tp.tindakanpelayanan_id = tk.tindakanpelayanan_id
                        LEFT JOIN daftartindakan_m dt on tp.daftartindakan_id = dt.daftartindakan_id
                        LEFT JOIN pendaftaran_t pn on tp.pendaftaran_id = pn.pendaftaran_id
                        LEFT JOIN pasien_m pa on tp.pasien_id = pa.pasien_id
                        LEFT JOIN tindakansudahbayar_t tsb on tp.tindakansudahbayar_id = tsb.tindakansudahbayar_id
                        LEFT JOIN komponentarif_m kt on tk.komponentarif_id = kt.komponentarif_id
                        WHERE tp.dokterpemeriksa1_id = ".$pegawai_id." ".$tgl." AND $ruangan_id pn.instalasi_id = ".PARAMS::INSTALASI_ID_RJ." AND pn.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' AND tk.komponentarif_id in (5, 10, 11, 12, 21, 31, 32, 51, 52, 53, 59, 65, 67, 68, 70, 73, 76, 77, 79, 80, 81, 86)
                        GROUP BY pn.pendaftaran_id, pn.tgl_pendaftaran, tp.dokterpemeriksa1_id, pn.no_pendaftaran, 
                        pa.no_rekam_medik, pa.pasien_id, pa.nama_pasien, pa.jeniskelamin, pa.alamat_pasien, tp.tgl_tindakan, tp.tindakanpelayanan_id,
                        dt.daftartindakan_nama ORDER BY tp.tindakanpelayanan_id DESC".$offset;
                    $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                }else if($_GET['instalasi_tab_jasdok'] == 'RD'){
                    $sql = " SELECT pn.pendaftaran_id, pn.tgl_pendaftaran, tp.dokterpemeriksa1_id, pn.no_pendaftaran, 
                        pa.no_rekam_medik, pa.pasien_id, pa.nama_pasien, pa.jeniskelamin, pa.alamat_pasien, tp.tgl_tindakan, tp.tindakanpelayanan_id,
                        dt.daftartindakan_nama, sum(tk.tarif_tindakankomp) AS tarif_rd
                        FROM tindakanpelayanan_t tp
                        LEFT JOIN tindakankomponen_t tk on tp.tindakanpelayanan_id = tk.tindakanpelayanan_id
                        LEFT JOIN daftartindakan_m dt on tp.daftartindakan_id = dt.daftartindakan_id
                        LEFT JOIN pendaftaran_t pn on tp.pendaftaran_id = pn.pendaftaran_id
                        LEFT JOIN pasien_m pa on tp.pasien_id = pa.pasien_id
                        LEFT JOIN tindakansudahbayar_t tsb on tp.tindakansudahbayar_id = tsb.tindakansudahbayar_id
                        LEFT JOIN komponentarif_m kt on tk.komponentarif_id = kt.komponentarif_id
                        WHERE tp.dokterpemeriksa1_id = ".$pegawai_id." ".$tgl." AND $ruangan_id pn.instalasi_id = ".PARAMS::INSTALASI_ID_RD." AND pn.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' AND tk.komponentarif_id in (5, 10, 11, 12, 21, 31, 32, 51, 52, 53, 59, 65, 67, 68, 70, 73, 76, 77, 79, 80, 81, 86)
                        GROUP BY pn.pendaftaran_id, pn.tgl_pendaftaran, tp.dokterpemeriksa1_id, pn.no_pendaftaran, 
                        pa.no_rekam_medik, pa.pasien_id, pa.nama_pasien, pa.jeniskelamin, pa.alamat_pasien, tp.tgl_tindakan, tp.tindakanpelayanan_id,
                        dt.daftartindakan_nama ORDER BY tp.tindakanpelayanan_id DESC".$offset;
                    $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                }else if($_GET['instalasi_tab_jasdok'] == 'RI'){
                    $sql = " SELECT pn.pendaftaran_id, pn.tgl_pendaftaran, pd.pegawai_id, pn.no_pendaftaran, 
                        pa.no_rekam_medik, pa.pasien_id, pa.nama_pasien, pa.jeniskelamin, pa.alamat_pasien, tp.tgl_tindakan, tp.tindakanpelayanan_id,
                        dt.daftartindakan_nama, sum(tk.tarif_tindakankomp) AS tarif_ri
                        FROM tindakanpelayanan_t tp
                        LEFT JOIN tindakankomponen_t tk on tp.tindakanpelayanan_id = tk.tindakanpelayanan_id
                        LEFT JOIN daftartindakan_m dt on tp.daftartindakan_id = dt.daftartindakan_id
                        LEFT JOIN pendaftaran_t pn on tp.pendaftaran_id = pn.pendaftaran_id
                        LEFT JOIN pasienadmisi_t pd ON pn.pasienadmisi_id = pd.pasienadmisi_id
                        LEFT JOIN pasien_m pa on tp.pasien_id = pa.pasien_id
                        LEFT JOIN tindakansudahbayar_t tsb on tp.tindakansudahbayar_id = tsb.tindakansudahbayar_id
                        LEFT JOIN komponentarif_m kt on tk.komponentarif_id = kt.komponentarif_id
                        WHERE pd.pegawai_id = ".$pegawai_id." ".$tgl." AND $ruangan_id pn.instalasi_id = ".PARAMS::INSTALASI_ID_RI." AND pn.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' AND tk.komponentarif_id in (5, 10, 11, 12, 21, 31, 32, 51, 52, 53, 59, 65, 67, 68, 70, 73, 76, 77, 79, 80, 81, 86)
                        GROUP BY pn.pendaftaran_id, pn.tgl_pendaftaran, pd.pegawai_id, pn.no_pendaftaran, 
                        pa.no_rekam_medik, pa.pasien_id, pa.nama_pasien, pa.jeniskelamin, pa.alamat_pasien, tp.tgl_tindakan, tp.tindakanpelayanan_id,
                        dt.daftartindakan_nama ORDER BY tp.tindakanpelayanan_id DESC".$offset;
                    $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                }
                $totalPeriod1 = 0;
                $totalPeriod2 = 0;
                $totalPeriod3 = 0;
                if(!empty($loadData)) {
                    $data['jasdok'] = $loadData;
                    foreach ($loadData as $datum) {
                        if($_GET['instalasi_tab_jasdok'] == 'RJ'){
                            $totalPeriod1 += ($datum['tarif_rj']==null?0:$datum['tarif_rj']);
                        }else if($_GET['instalasi_tab_jasdok'] == 'RD'){
                            $totalPeriod2 += ($datum['tarif_rd']==null?0:$datum['tarif_rd']);
                        }else if($_GET['instalasi_tab_jasdok'] == 'RI'){
                            $totalPeriod3 += ($datum['tarif_ri']==null?0:$datum['tarif_ri']);
                        }
                    }
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data is found!";
                    $data['total_period_rj'] = $totalPeriod1;
                    $data['total_period_rd'] = $totalPeriod2;
                    $data['total_period_ri'] = $totalPeriod3;
                    $data['startDate'] = !empty($tgl_awal)?MyFormatter::FormatDateTimeForUser($tgl_awal):date('d-m-Y');
                    $data['endDate'] = !empty($tgl_akhir)?MyFormatter::FormatDateTimeForUser($tgl_akhir):date('d-m-Y');
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackJasDok".$_GET['instalasi_tab_jasdok']."(".$encode.")";
            Yii::app()->end();
	}


    public function actionGetRiwayatPasien(){
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if(isset($_GET['pasien_id'])){
            if(!empty($_GET['pasien_id'])){
                $modPendaftaran = MOPendaftaranT::model()->findAllByAttributes(array('pasien_id'=>$_GET['pasien_id']),array('order'=>'tgl_pendaftaran DESC'));
                if(!empty($modPendaftaran)){
                    foreach ($modPendaftaran as $i => $val) {
                        if(!empty($val->pasienadmisi_id)){
                            $modAdmisi = MOPasienadmisiT::model()->findByPk($val->pasienadmisi_id);
                            $modMorbiditas = MOPasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$val->pendaftaran_id));
                            if(!empty($modMorbiditas->pendaftaran_id)){
                                $modDiagnosa = DiagnosaM::model()->findByPk($modMorbiditas->diagnosa_id);
                            }
                            $data['data'][$i+1] = array(
                                'pendaftaran_id'=>$val->pendaftaran_id,
                                'no_pendaftaran'=>$val->no_pendaftaran,
                                'tgl_pendaftaran'=>$format->formatDateTimeForUser($modAdmisi->tgladmisi),
                                'jam_pendaftaran'=>explode(' ',$val->tgl_pendaftaran)[1],
                                'statusperiksa'=>$val->statusperiksa,
                                'tglselesaiperiksa'=>$val->tglselesaiperiksa,
                                'statusmasuk'=>$val->statusmasuk,
                                'jeniskasuspenyakit'=>!empty($val->jeniskasuspenyaki_id)?$val->jeniskasuspenyakit->jeniskasuspenyakit_nama:'',
                                'umur'=>$val->umur,
                                'carabayar'=>$val->carabayar->carabayar_nama,
                                'penjamin'=>!empty($val->penjamin_id)?$val->penjamin->penjamin_nama:'',
                                'diagnosa'=>!empty($modDiagnosa->diagnosa_id)?$modDiagnosa->diagnosa_nama:'-',
                                'ruangan'=>!empty($modAdmisi->ruangan_id)?$modAdmisi->ruangan->ruangan_nama:'',
                                'instalasi'=>'RI',
                                'pegawai'=>!empty($val->pegawai_id)?$val->pegawai->namaLengkap:'-',
                                'instalasi_id'=>PARAMS::INSTALASI_ID_RI,
                                'ruangan_admisi'=>!empty($modAdmisi->ruangan_id)?$modAdmisi->ruangan->ruangan_nama:'-',
                                'tgl_admisi'=>$format->formatDateTimeForUser($modAdmisi->tgladmisi),
                            );
                        }
                        else
                        $modAdmisi = new MOPasienadmisiT;
                        $modDiagnosa = new DiagnosaM;
                        $data['data'][$i] = array(
                            'pendaftaran_id'=>$val->pendaftaran_id,
                            'no_pendaftaran'=>$val->no_pendaftaran,
                            'tgl_pendaftaran'=>$format->formatDateTimeForuser(explode(' ',$val->tgl_pendaftaran)[0]),
                            'jam_pendaftaran'=>explode(' ',$val->tgl_pendaftaran)[1],
                            'statusperiksa'=>$val->statusperiksa,
                            'tglselesaiperiksa'=>$val->tglselesaiperiksa,
                            'statusmasuk'=>$val->statusmasuk,
                            'jeniskasuspenyakit'=>!empty($val->jeniskasuspenyaki_id)?$val->jeniskasuspenyakit->jeniskasuspenyakit_nama:'',
                            'umur'=>$val->umur,
                            'carabayar'=>$val->carabayar->carabayar_nama,
                            'penjamin'=>!empty($val->penjamin_id)?$val->penjamin->penjamin_nama:'',
                            'ruangan'=>!empty($val->ruangan_id)?$val->ruangan->ruangan_nama:'',
                            'diagnosa'=>!empty($modDiagnosa->diagnosa_id)?$modDiagnosa->diagnosa_nama:'-',
                            'instalasi'=>!empty($val->instalasi_id)?$val->instalasi->instalasi_nama:'',
                            'pegawai'=>!empty($val->pegawai_id)?$val->pegawai->namaLengkap:'-',
                            'instalasi_id'=>$val->instalasi_id,
                            'ruangan_admisi'=>!empty($modAdmisi->ruangan_id)?$modAdmisi->ruangan->ruangan_nama:'',
                            'tgl_admisi'=>$format->formatDateTimeForUser($modAdmisi->tgladmisi),
                        );
                    }
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                } 
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback".$_GET['pasien_id']."(".$encode.")";
    }


    /**
     * action untuk mendapatkan list paramedis
     * @param q
     * @param ruangan_id
     * @return array of paramedis
     */
    public function actionGetParamedis() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $ruanganID = $_GET['ruangan_id'];
            $sql = " SELECT pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama
                    FROM pegawai_m
                    JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = pegawai_m.pegawai_id
                    LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
                    WHERE pegawai_m.kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN." AND LOWER(pegawai_m.nama_pegawai) like '%".$q."%' AND ruanganpegawai_m.ruangan_id = ".$ruanganID;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }

	/**
    * action untuk mendapatkan list diagnosa
    * @param q
	* @param dialog_imunisasi, true or false
    * @return array of paramedis
    */
    public function actionGetDiagnosa() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (!empty($_GET['q'])) {
            $criteria = new CDbCriteria();
            $q = strtolower($_GET['q']);
            $criteria->addCondition("LOWER(diagnosa_nama) ilike '%".$q."%' OR LOWER(diagnosa_kode) ilike '%".$q."%' AND diagnosa_aktif = TRUE AND diagnosa_imunisasi = FALSE ");
            $loadData = DiagnosaM::model()->findAll($criteria);
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }

	public function actionGetRuanganDokter() {
            header("content-type:application/json");
            $format = new MyFormatter();
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            if(isset($_GET['instalasi_tab'])&& isset($_GET['pegawai_id'])){
                $pegawai_id = $_GET['pegawai_id'];
                if($_GET['instalasi_tab'] == 'RI'){
                    $instalasi = 'AND instalasi_id = '.PARAMS::INSTALASI_ID_RI;
                }else if($_GET['instalasi_tab'] == 'RD'){
                    $instalasi = 'AND instalasi_id = '.PARAMS::INSTALASI_ID_RD;
                }else if($_GET['instalasi_tab'] == 'RJ'){
                    $instalasi = 'AND instalasi_id = '.PARAMS::INSTALASI_ID_RJ;
                }else{
                    $instalasi = '';
                }
                $sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama  FROM ruangan_m
                        JOIN ruanganpegawai_m ON ruangan_m.ruangan_id=ruanganpegawai_m.ruangan_id
                        WHERE ruanganpegawai_m.pegawai_id = $pegawai_id
                        AND ruangan_aktif = TRUE ".$instalasi;
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackRuanganPeriksa(".$encode.")";
        }

	/**
	 * action untuk memasukkan data hasil pemeriksaan anamnesa
	 * @param array serialize
	 * @return array 1/0 sukses message
	 */
	public function actionSubmitAnamnesa(){
            header("content-type:application/json");
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
            if(isset($_GET['anamnesa'])){
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    if($_GET['anamesa_id']!=''){
                        $model = MOAnamnesaT::model()->findByPk($_GET['anamesa_id']);
                        $model->attributes = $_GET['anamnesa'];
                        $model->update_time = date("Y-m-d H:i:s");					
                    }else{
                        $model = new MOAnamnesaT;
                        $model->attributes = $_GET['anamnesa'];
                        $model->anamesa_id = null; //agar auto sequence tidak error
                    }
                    $model->tglanamnesis = MyFormatter::formatDateTimeForDb($_GET['anamnesa']['tglanamnesis']." ".date("H:i:s"));
                    $model->create_time = date("Y-m-d H:i:s");
                    if($model->save()){
                        MOPendaftaranT::model()->updateByPk($model->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>$model->create_loginpemakai_id));
                        $transaction->commit();
                        $data['sukses'] = 1;
                        $data['pesan'] = 'Data anamnesa berhasil diubah dan simpan!';
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
            echo "jsonCallbackSubmitAnamnesa(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * Action untuk mendapatkan master lookup
	 * @param lookup_type, tipe jenis master
	 * @return array data lookup
	 */
	public function actionGetLookup() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        if (isset($_GET['lookup_type'])) {
                $lookupType = $_GET['lookup_type'];
                $sql = "SELECT * FROM lookup_m WHERE lookup_type='$lookupType'";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }


	/**
	 * action untuk mendapatkan Hasil Tekanan Darah
	 * @param systolic
	 * @param diastolic
	 *
	 * @return nilai Meanarteripressure
	 */
	public function actionGetHasilTekananDarah(){
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
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
                $data['data'] = $loadData;
                if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['data']['meanarteripressure'] = $meanarteripressure;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan Index Massa Tubuh dan Berat Badan Ideal
	 * @param tinggibadan (cm)
	 * @param beratbadan (kg)
	 * @param pasien_id
	 *
	 * @return array dari hasil body mass index dan ideal weight
	 */
	public function actionGetBMI(){
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            if(isset($_GET['tinggibadan_cm']) && isset($_GET['beratbadan_kg']) && isset($_GET['pasien_id'])){
                $tinggibadan_cm = (float)$_GET['tinggibadan_cm'];
                $beratbadan_kg = (float)$_GET['beratbadan_kg'];
                $bmi = ($beratbadan_kg/(($tinggibadan_cm*$tinggibadan_cm)/10000));
                $sql = "SELECT nama_pasien, jeniskelamin
                        FROM pasien_m
                        WHERE pasien_id = ".$_GET['pasien_id'];
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if(strtolower(trim($loadData['jeniskelamin'])) == strtolower(trim(Params::JENIS_KELAMIN_PEREMPUAN))){
                    $bb_ideal = ($tinggibadan_cm - 100) - ((15/100)*($tinggibadan_cm-100));
                }else{
                    $bb_ideal = ($tinggibadan_cm - 100) - ((10/100)*($tinggibadan_cm-100));
                }
                if ($bmi>0) {
                    $sql = "SELECT bodymassindex_id, bmi_sign, bmi_defenisi, bmi_pesan
                            FROM bodymassindex_m
                            WHERE ".$bmi." >= bmi_minimum
                            AND ".$bmi." < (bmi_maksimum + 1)
                            AND bodymassindex_aktif = TRUE";
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                }
                $data['data'] = $loadData;
                if (!empty($loadData)) {
                    $data['bmi'] = $bmi;
                    $data['bb_ideal'] = $bb_ideal;
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackBMI(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk menyimpan data pemeriksaan fisik
	 * @param serialize form
	 * @return 1/0 sukses, pesan
	 */
	public function actionSubmitPemeriksaanFisik(){
            header("content-type:application/json");
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
            if(isset($_GET['pemeriksaanfisik'])){
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    if(!empty($_GET['pemeriksaanfisik_id'])){
                        $model = MOPemeriksaanfisikT::model()->findByPk($_GET['pemeriksaanfisik_id']);					
                        $model->update_time = date("Y-m-d H:i:s");
                    }else{
                        $model = new MOPemeriksaanfisikT;					
                        $model->create_time = date("Y-m-d H:i:s");
                    }                
                    $model->jn_paten = 0;
                    $model->jn_obstruktifpartial = 0;
                    $model->jn_obstruktifnormal = 0;
                    $model->jn_stridor = 0;
                    $model->pgd_simetri = 0;
                    $model->pgd_asimetri = 0;
                    $model->pgp_normal = 0;
                    $model->pgp_kussmaul = 0;
                    $model->pgp_takipnea = 0;
                    $model->pgp_retraktif = 0;
                    $model->pgp_dangkal = 0;
                    $model->sirkulasi_nadicarotis = 0;
                    $model->sirkulasi_nadiradialis = 0;
                    $model->cfr_kecil_2 = 0;
                    $model->cfr_besar_2 = 0;
                    $model->jn_gargling = 0;
                    $model->kulit_normal = 0;
                    $model->kulit_jaundice = 0;
                    $model->kulit_cyanosis = 0;
                    $model->kulit_pucat = 0;
                    $model->kulit_berkeringat = 0;
                    $model->rambut_mengkilat = 0;
                    $model->rambut_kusam = 0;
                    $model->rambut_mudahrontok = 0;
                    $model->rambut_kotor = 0;
                    $model->rambut_bersih = 0;
                    $model->mata_konjungtiva_anemis = 0;
                    $model->mata_sklera_ikterik = 0;
                    $model->mata_penglihatan = 0;
                    $model->hidung_bersih = 0;
                    $model->sumbatanjalannafas = 0;
                    $model->bibir_simetris = 0;
                    $model->gigi_karies = 0;
                    $model->leher_kelenjartiroid_teraba = 0;
                    $model->leher_kelgetahbening_teraba = 0;
                    $model->dada_bentukmamae_simetris = 0;
                    $model->dada_tumor = 0;
                    $model->dada_kolostrum = 0;
                    $model->bentuk_ekstremitas = 0;
                    $model->ekstremitas_kelainan_oedema = 0;
                    $model->ekstremitas_kelainan_varies = 0;
                    $model->ekstremitas_kelainan_parese = 0;
                    $model->ekstremitas_kelainan_atropi = 0;
                    $model->abdo_insp_pelebaranvena = 0;
                    $model->abdo_insp_nigra = 0;
                    $model->abdo_insp_striae = 0;
                    $model->kontraksi_palpasi = 0;  
                    $model->frekuensiteratur = 0;
                    $model->attributes = $_GET['pemeriksaanfisik'];
                    $model->denyutjantung = $_GET['pemeriksaanfisik']['denyutjantung'];
                    $model->td_systolic = $_GET['pemeriksaanfisik']['fisikTekDarMM'];
                    $model->td_diastolic = $_GET['pemeriksaanfisik']['fisikTekDarHG'];
                    $model->tekanandarah = $_GET['pemeriksaanfisik']['fisikTekDarMM'].'/'.$_GET['pemeriksaanfisik']['fisikTekDarHG'];
                    $model->meanarteripressure = (double)$_GET['pemeriksaanfisik']['fisikMeanarteripressure'];
                    $model->bb_ideal = (double)$_GET['pemeriksaanfisik']['fisikBMI'];
                    $model->tglperiksafisik = MyFormatter::formatDateTimeForDb($model->tglperiksafisik." ".date("H:i:s"));
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
    * action untuk mendapatkan data pemeriksaan fisik
    * @param pendaftaran_id
    * @return array of pemeriksaan fisik
    */
    public function actionGetPemeriksaanFisik() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['pendaftaran_id'])) {
            $pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pemeriksaanfisik_t f JOIN pegawai_m p ON f.pegawai_id=p.pegawai_id "
					. "WHERE pendaftaran_id=".$pendaftaran_id;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }

	/**
	 * action untuk pemilihan pemeriksaan lab klinik
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab klinik
	 *
	 */
	public function actionGetPemeriksaanLabKlinik(){
            header("content-type:application/json");
            $data = array();
            $data['data'] = array();
            if(isset($_GET['kelaspelayanan_id'])){
                $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
                $sql = "SELECT daftartindakan_m.daftartindakan_id, jenispemeriksaanlab_m.jenispemeriksaanlab_id,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_kode, jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
                        pemeriksaanlab_m.pemeriksaanlab_id, pemeriksaanlab_m.pemeriksaanlab_kode,
                        pemeriksaanlab_m.pemeriksaanlab_nama, tariftindakan_m.harga_tariftindakan,
                        tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind,
                        tariftindakan_m.persencyto_tind, jenispemeriksaanlab_m.jenispemeriksaanlab_id
                        FROM pemeriksaanlab_m
                        JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
                        JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
                        JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
                        JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
                        JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
                        WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL." AND jenispemeriksaanlab_m.jenispemeriksaanlab_aktif = true
                        AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
                        AND pemeriksaanlab_m.pemeriksaanlab_aktif = true
                        AND(
                            LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_kode) like '%$req%'
                            OR LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_nama) like '%$req%'
                            OR LOWER(pemeriksaanlab_m.pemeriksaanlab_kode) like '%$req%'
                            OR LOWER(pemeriksaanlab_m.pemeriksaanlab_nama) like '%$req%'
                        )
                        GROUP BY daftartindakan_m.daftartindakan_id,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_id,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_kode,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
                        pemeriksaanlab_m.pemeriksaanlab_id,
                        pemeriksaanlab_m.pemeriksaanlab_kode,
                        pemeriksaanlab_m.pemeriksaanlab_nama,
                        tariftindakan_m.harga_tariftindakan,
                        tariftindakan_m.persendiskon_tind,
                        tariftindakan_m.hargadiskon_tind,
                        tariftindakan_m.persencyto_tind, jenispemeriksaanlab_m.jenispemeriksaanlab_id
                        ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC LIMIT 10";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackTindakanPemeriksaan(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk pemilihan pemeriksaan lab klinik
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab klinik
	 *
	 */
	public function actionGetPemeriksaanLabAnatomi(){
            header("content-type:application/json");
            $data = array();
            if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
                $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
                $sql = "SELECT daftartindakan_m.daftartindakan_id,jenispemeriksaanlab_m.jenispemeriksaanlab_id,jenispemeriksaanlab_m.jenispemeriksaanlab_kode,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_nama,pemeriksaanlab_m.pemeriksaanlab_id,pemeriksaanlab_m.pemeriksaanlab_kode,
                        pemeriksaanlab_m.pemeriksaanlab_nama,tariftindakan_m.harga_tariftindakan,tariftindakan_m.persendiskon_tind,
                        tariftindakan_m.hargadiskon_tind,tariftindakan_m.persencyto_tind
                        FROM pemeriksaanlab_m
                        JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id
                        JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
                        JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
                        JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
                        JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
                        WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL." AND jenispemeriksaanlab_m.jenispemeriksaanlab_aktif = true
                        AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']." AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN." 
                        AND pemeriksaanlab_m.pemeriksaanlab_aktif = true
                        AND jenispemeriksaanlab_m.jenispemeriksaanlab_id=2
                        AND(
                            LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_kode) like '%$req%'
                            OR LOWER(jenispemeriksaanlab_m.jenispemeriksaanlab_nama) like '%$req%'
                            OR LOWER(pemeriksaanlab_m.pemeriksaanlab_kode) like '%$req%'
                            OR LOWER(pemeriksaanlab_m.pemeriksaanlab_nama) like '%$req%'
                        )
                        GROUP BY daftartindakan_m.daftartindakan_id,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_id,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_kode,
                        jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
                        pemeriksaanlab_m.pemeriksaanlab_id,
                        pemeriksaanlab_m.pemeriksaanlab_kode,
                        pemeriksaanlab_m.pemeriksaanlab_nama,
                        tariftindakan_m.harga_tariftindakan,
                        tariftindakan_m.persendiskon_tind,
                        tariftindakan_m.hargadiskon_tind,
                        tariftindakan_m.persencyto_tind
                        ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC LIMIT 10";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * transaksi rujuk ke laboratorium
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionSubmitRujukKeLab(){
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
                    $model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']." ".date("H:i:s"));
                    $model->create_time = date("Y-m-d H:i:s");
                    $model->update_time = $model->create_time;
                    $model->update_loginpemakai_id = $model->create_loginpemakai_id;
                    $model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
                    $model->create_ruangan = $model->ruangan_id;
                    if($model->save()) {
                        if(count($_GET['permintaankepenunjang']) > 0){
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
	 * action untuk mendapatkan item rujukan yang telah diinput sebelumnya
	 * @param pendaftaran_id
	 * @return item rujukan dan informasi data yang dikirim ke penunjang
	 */
	public function actionGetRujukanKeRadiologi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasienkirimkeunitlain_t pkul JOIN kelaspelayanan_m kp ON pkul.kelaspelayanan_id=kp.kelaspelayanan_id WHERE pkul.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tgl_kirimpasien'] = $datum['tgl_kirimpasien'];
					$data['data'][$i]['pasienkirimkeunitlain_id'] = $datum['pasienkirimkeunitlain_id'];
					$pasienKirimKeUnitlainID = $datum['pasienkirimkeunitlain_id'];
					$sql = "SELECT pkp.permintaankepenunjang_id, pkp.daftartindakan_id, "
							. "pkp.pemeriksaanrad_id, pl.pemeriksaanrad_nama, pkp.qtypermintaan, jpl.jenispemeriksaanrad_nama "
							. "FROM permintaankepenunjang_t pkp JOIN pemeriksaanrad_m pl ON pkp.pemeriksaanrad_id=pl.pemeriksaanrad_id "
							. "JOIN jenispemeriksaanrad_m jpl ON pl.jenispemeriksaanrad_id=jpl.jenispemeriksaanrad_id "
							. "WHERE pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!";
					}
					$i++;
				}

			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk menghapus data item lab
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteItemLab() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;

		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			//$sql = "DELETE FROM pasienkirimkeunitlain_t WHERE pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;


			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk pemilihan pemeriksaan radiologi
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab
	 *
	 */
	public function actionGetPemeriksaanRadiologi(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");

			$sql = "SELECT daftartindakan_m.daftartindakan_id,
						jenispemeriksaanrad_m.jenispemeriksaanrad_id,
						jenispemeriksaanrad_m.jenispemeriksaanrad_kode,
						jenispemeriksaanrad_m.jenispemeriksaanrad_nama,
						pemeriksaanrad_m.pemeriksaanrad_id,
						pemeriksaanrad_m.pemeriksaanrad_kode,
						pemeriksaanrad_m.pemeriksaanrad_nama,
						tariftindakan_m.harga_tariftindakan,
						tariftindakan_m.persendiskon_tind,
						tariftindakan_m.hargadiskon_tind
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
						AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
						AND(
							LOWER(jenispemeriksaanrad_m.jenispemeriksaanrad_kode) like '%".$req."%'
							OR LOWER(jenispemeriksaanrad_m.jenispemeriksaanrad_nama) like '%".$req."%'
							OR LOWER(pemeriksaanrad_m.pemeriksaanrad_kode) like '%".$req."%'
							OR LOWER(pemeriksaanrad_m.pemeriksaanrad_nama) like '%".$req."%'
						)
                        GROUP BY daftartindakan_m.daftartindakan_id,
                        jenispemeriksaanrad_m.jenispemeriksaanrad_id,
                        jenispemeriksaanrad_m.jenispemeriksaanrad_kode,
                        jenispemeriksaanrad_m.jenispemeriksaanrad_nama,
                        pemeriksaanrad_m.pemeriksaanrad_id,
                        pemeriksaanrad_m.pemeriksaanrad_kode,
                        pemeriksaanrad_m.pemeriksaanrad_nama,
                        tariftindakan_m.harga_tariftindakan,
                        tariftindakan_m.persendiskon_tind,
                        tariftindakan_m.hargadiskon_tind
					ORDER BY daftartindakan_m.daftartindakan_id ASC, pemeriksaanrad_m.pemeriksaanrad_urutan ASC LIMIT 10";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallbackRadiologi(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi simpan rujuk ke radiologi
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionSubmitRujukKeRadiologi(){
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
				$model->create_ruangan = $model->ruangan_id;
              
				if($model->save()) {
					if(count($_GET['permintaankepenunjang']) > 0){
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
	 * action untuk menghapus data item radiologi
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteItemRadiologi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;

		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			//$sql = "DELETE FROM pasienkirimkeunitlain_t WHERE pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;


			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	/**
	 * action untuk mendapatkan item rujukan yang telah diinput sebelumnya
	 * @param pendaftaran_id
	 * @return item rujukan dan informasi data yang dikirim ke penunjang
	 */
	public function actionGetRujukanKeRehabMedis() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasienkirimkeunitlain_t pkul JOIN kelaspelayanan_m kp ON pkul.kelaspelayanan_id=kp.kelaspelayanan_id WHERE pkul.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tgl_kirimpasien'] = $datum['tgl_kirimpasien'];
					$data['data'][$i]['pasienkirimkeunitlain_id'] = $datum['pasienkirimkeunitlain_id'];
					$pasienKirimKeUnitlainID = $datum['pasienkirimkeunitlain_id'];
					$sql = "SELECT pkp.permintaankepenunjang_id, pkp.daftartindakan_id, "
							. "jtr.jenistindakanrm_id, trm.tindakanrm_nama, pkp.qtypermintaan, jtr.jenistindakanrm_nama "
							. "FROM permintaankepenunjang_t pkp LEFT JOIN tindakanrm_m trm ON pkp.tindakanrm_id=trm.tindakanrm_id "
							. "LEFT JOIN jenistindakanrm_m jtr ON trm.jenistindakanrm_id=jtr.jenistindakanrm_id "
							. "WHERE pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						//echo sizeof($loadData2)
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!";
					}
					$i++;
				}
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk pemilihan pemeriksaan radiologi
	 * @params ruangan_id, penjamin_id, kelaspelayanan_id, q
	 * @return array pf pemeriksaan lab
	 *
	 */
	public function actionGetTindakanRehabMedis(){
		header("content-type:application/json");
		$data = array();
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id,
						jenistindakanrm_m.jenistindakanrm_id,
						jenistindakanrm_m.jenistindakanrm_kode,
						jenistindakanrm_m.jenistindakanrm_nama,
						tindakanrm_m.tindakanrm_id,
						tindakanrm_m.tindakanrm_kode,
						tindakanrm_m.tindakanrm_nama,
						tariftindakan_m.harga_tariftindakan,
						tariftindakan_m.persendiskon_tind,
						tariftindakan_m.hargadiskon_tind
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
						AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
						AND(
							LOWER(jenistindakanrm_m.jenistindakanrm_kode) like '%".$req."%'
							OR LOWER(jenistindakanrm_m.jenistindakanrm_nama) like '%".$req."%'
							OR LOWER(tindakanrm_m.tindakanrm_kode) like '%".$req."%'
							OR LOWER(tindakanrm_m.tindakanrm_nama) like '%".$req."%'
						)
					ORDER BY jenistindakanrm_m.jenistindakanrm_urutan ASC, tindakanrm_m.tindakanrm_urutan ASC LIMIT 10";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;
            $n = sizeof($loadData);

            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	/**
	 * transaksi simpan rujuk ke rehab medis
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionSubmitRujukKeRehabMedis(){
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
				$model->create_ruangan = $model->ruangan_id;

				if($model->save()) {
					if(count($_GET['permintaankepenunjang']) > 0){
						foreach($_GET['permintaankepenunjang'] AS $i => $detail){
							$modPermintaan = new MOPermintaankepenunjangT();
							$modPermintaan->attributes = $detail;
							$modPermintaan->pasienkirimkeunitlain_id = $model->pasienkirimkeunitlain_id;
                            $modPermintaan->tglpermintaankepenunjang = $model->tgl_kirimpasien;
							$modPermintaan->tindakanrm_id = $detail['tindakanrm_id'];
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
	 * action untuk menghapus data item rehab medis
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteItemRehabMedis() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;

		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			//$sql = "DELETE FROM pasienkirimkeunitlain_t WHERE pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;


			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
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
	public function actionGetTindakanKonsulGizi(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
			$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
			$sql = "SELECT daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama,
						tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
					FROM daftartindakan_m
					JOIN tindakanruangan_m ON daftartindakan_m.daftartindakan_id = tindakanruangan_m.daftartindakan_id
					JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
					JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
					WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
					AND tindakanruangan_m.ruangan_id = ".Params::RUANGAN_ID_GIZI."
					AND daftartindakan_m.daftartindakan_aktif = TRUE
					AND daftartindakan_m.daftartindakan_konsul is TRUE
					AND tariftindakan_m.kelaspelayanan_id = ".$_GET['kelaspelayanan_id']."
					AND tariftindakan_m.jenistarif_id = ".Params::JENISTARIF_ID_PELAYANAN."
					AND(
						LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
						OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
					)
					ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC LIMIT 8
					";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * transaksi simpan konsultasi gizi
	 * @param $_GET['pasienkirimkeunitlain'] array
	 * @param $_GET['permintaankepenunjang'] array(array()) //detail pemeriksaan
	 * @return json
	 */
	public function actionSubmitKonsultasiGizi(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['pasienkirimkeunitlain']) && isset($_GET['permintaankepenunjang'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
                $modPendaftaran = MOPendaftaranT::model()->findByPk($_GET['pasienkirimkeunitlain']['pendaftaran_id']);
				$model = new MOPasienkirimkeunitlainT;
				$model->attributes = $_GET['pasienkirimkeunitlain'];
				$model->tgl_kirimpasien = $format->formatDateTimeForDb($_GET['pasienkirimkeunitlain']['tgl_kirimpasien']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->update_time = $model->create_time;
				$model->update_loginpemakai_id = $model->create_loginpemakai_id;
                $model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
                $model->ruangan_id = Params::RUANGAN_ID_GIZI;
				$model->create_ruangan = Params::RUANGAN_ID_GIZI;
                
				if ($model->save()) {
					if(count($_GET['permintaankepenunjang']) > 0){
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
                        PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,
                            array(
                                'pembayaranpelayanan_id'=>null
                            )
                        );
					}
                    $MasukPenunjang = $this->savePasienPenunjang($modPendaftaran,$model,$modPermintaan);
					if($MasukPenunjang){
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

    protected function savePasienPenunjang($modPendaftaran,$modKirimKeUnitLain,$modPermintaan){
        $stat = false; 
        $modPasienPenunjang = new PasienmasukpenunjangT;
        $modPasienPenunjang->pasien_id = $modPendaftaran->pasien_id;
        $modPasienPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
        $modPasienPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPasienPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
        $modPasienPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modPasienPenunjang->ruangan_id = Params::RUANGAN_ID_GIZI;   //$modPendaftaran->ruangan_id;
        $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang('RJ');
        $modPasienPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');    //$modPendaftaran->tgl_pendaftaran;
        $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
        $modPasienPenunjang->kunjungan = $modPendaftaran->kunjungan;
        $modPasienPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
        $modPasienPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
        $modPasienPenunjang->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
        $modPasienPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $modPasienPenunjang->create_loginpemakai_id = $modKirimKeUnitLain->create_loginpemakai_id;
        if(empty($modPendaftaran->pasienadmisi_id)){
            $modPasienPenunjang->pasienadmisi_id = null;
        }else{
            $modPasienPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        }
        if ($modPasienPenunjang->validate()){
            $modPasienPenunjang->Save();
            $stat = true;
            if(count($modPermintaan) > 0){
                $this->saveTindakanPelayanan($modPendaftaran, $modPasienPenunjang,$modPermintaan);
            }
            $this->updatePasienKirimKeUnitLain($modPasienPenunjang);
        } 
        
        return $stat;
    }

    protected function saveTindakanPelayanan($modPendaftaran,$modPasienPenunjang,$modPermintaan)
    {
        $valid=true;
        $format = new MyFormatter;
        $modTindakans = array();
        foreach($modPermintaan as $i=>$item)
        {
            if(!empty($item)){
                if(isset($item['cbTindakan']) == 1){
                    $modTindakans[$i] = new TindakanpelayananT;
                    $modTindakans[$i]->attributes=$item;
                    $modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
                    $modTindakans[$i]->pasien_id = $modPendaftaran->pasien_id;
                    $modTindakans[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                    $modTindakans[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                    $modTindakans[$i]->instalasi_id = Params::INSTALASI_ID_GIZI;
                    $modTindakans[$i]->ruangan_id = Params::RUANGAN_ID_GIZI;
                    $modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
                    $modTindakans[$i]->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
                    $modTindakans[$i]->daftartindakan_id = $item['idDaftarTindakan'];
                    $modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
                    $modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                    if (isset($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien'])){
                        $tgl_tindakan = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
                    } else {
                        $tgl_tindakan = date('Y-m-d H:i:s');
                    }
                    $modTindakans[$i]->tgl_tindakan = $tgl_tindakan;
                    $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan();
                    $modTindakans[$i]->qty_tindakan = 1;
                    $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
                    $modTindakans[$i]->satuantindakan = "HARI";
                    $modTindakans[$i]->cyto_tindakan = $item['cyto'];
                    $modTindakans[$i]->tarifcyto_tindakan = ($item['cyto']) ? (($item['cyto'] / 100) * $modTindakans[$i]->tarif_tindakan) : 0;
                    $modTindakans[$i]->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
                    $modTindakans[$i]->discount_tindakan = 0;
                    $modTindakans[$i]->subsidiasuransi_tindakan = 0;
                    $modTindakans[$i]->subsidipemerintah_tindakan = 0;
                    $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
                    $modTindakans[$i]->iurbiaya_tindakan = 0;
                    if($modTindakans[$i]->validate()){
                        $modTindakans[$i]->save();
                    }
                    if (isset($item['inputpemeriksaanrad'])){
                        $idPemeriksaanRad[$i] = $item['inputpemeriksaanrad'];
                    }
                }
            }
        }        
        
        return $modTindakans;
    }

    protected function updatePasienKirimKeUnitLain($modPasienPenunjang) {
        PasienkirimkeunitlainT::model()->updateByPk($modPasienPenunjang->pasienkirimkeunitlain_id, 
                array('pasienmasukpenunjang_id'=>$modPasienPenunjang->pasienmasukpenunjang_id));
    }


	/**
	 * action untuk mendapatkan item konsultasi gizi yang telah diinput sebelumnya
	 * @param pendaftaran_id
	 * @return item konsultasi gizi
	 */
	public function actionGetKonsultasiGizi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			//$ruangan_id = $_GET['ruangan_id'];
			$sql = "SELECT * FROM pasienkirimkeunitlain_t pkul JOIN kelaspelayanan_m kp ON pkul.kelaspelayanan_id=kp.kelaspelayanan_id WHERE pkul.ruangan_id=".Params::RUANGAN_ID_GIZI." AND pkul.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tgl_kirimpasien'] = $datum['tgl_kirimpasien'];
					$data['data'][$i]['pasienkirimkeunitlain_id'] = $datum['pasienkirimkeunitlain_id'];
					$pasienKirimKeUnitlainID = $datum['pasienkirimkeunitlain_id'];
					$sql = "SELECT pkp.permintaankepenunjang_id, pkp.daftartindakan_id, "
							. "dt.daftartindakan_nama, pkp.qtypermintaan "
							. "FROM permintaankepenunjang_t pkp JOIN daftartindakan_m dt ON pkp.daftartindakan_id=dt.daftartindakan_id "
							. "WHERE pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID
							. "AND pkp.pasienkirimkeunitlain_id=".$pasienKirimKeUnitlainID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!";
					}
					$i++;
				}
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk menghapus data item konsultasi gizi
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteItemKonsultasiGizi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;

		if (isset($_GET['pasienkirimkeunitlain_id'])) {
			if (Yii::app()->db->createCommand()->delete('permintaankepenunjang_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
				if (Yii::app()->db->createCommand()->delete('pasienkirimkeunitlain_t', 'pasienkirimkeunitlain_id=:id', array(':id'=>$_GET['pasienkirimkeunitlain_id']))) {
					$data['sukses'] = 1;
					$data['pesan'] = 'Data berhasil dihapus!';
				}
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	/**
	 * transaksi submit konsul poli
	 * @param $_GET['konsulpoli'] array
	 * @return json
	 */
	public function actionSubmitKonsultasiPoliklinik(){
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
                    $model->tglkonsulpoli = $format->formatDateTimeForDb($_GET['konsulpoli']['tglkonsulpoli']." ".date("H:i:s"));
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

	public function actionGetRuanganRawatJalan() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $sql = "SELECT ruangan_id,instalasi_id,ruangan_nama
                    FROM ruangan_m
                    WHERE ruangan_aktif = TRUE AND instalasi_id IN (".Params::INSTALASI_ID_RJ.",".Params::INSTALASI_ID_RD.")
                    ORDER BY instalasi_id ";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if(!empty($loadData)){
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	public function actionGetTarifKonsulPoli() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		if (isset($_GET['kelaspelayanan_id'])) {
			$kelasPelayananID = $_GET['kelaspelayanan_id'];
			$jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjaminID)->jenistarif_id;
			$sql = "SELECT *
				FROM tariftindakan_m
				WHERE kelaspelayanan_id =$kelasPelayananID"
					."AND komponentarif_id=".Params::KOMPONENTARIF_ID_TOTAL."
					AND	daftartindakan_id =".Params::DAFTARTINDAKAN_ID_KONSUL."
				ORDER BY ruangan_nourut";
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			$data['data'] = $loadData;
			if(sizeof($loadData)>0){
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";
			}
		}
        $data['sukses'] = 0;

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	public function actionGetPolyCounseling() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            if (isset($_GET['pendaftaran_id'])) {
                $pendaftaran_id = $_GET['pendaftaran_id'];
                $sql = "SELECT *, (SELECT ruangan_nama FROM ruangan_m r WHERE r.ruangan_id=kp.ruangan_id) AS ruangan_tujuan, "
                    . "(SELECT ruangan_nama FROM ruangan_m r WHERE r.ruangan_id=kp.asalpoliklinikkonsul_id) AS ruangan_asal FROM konsulpoli_t kp "
                    . "WHERE kp.pendaftaran_id=".$pendaftaran_id;
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                if (count($loadData)>0) {
                    $data['data']=$loadData;
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	public function actionAjaxSetTarif()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
		$ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
		$kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
		$ruangan = RuanganM::model()->findByPk($ruangan_id);
		$ruangan_nama = $ruangan->ruangan_nama;
		$jenistarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$penjamin_id)->jenistarif_id;

		$criteria = new CDbCriteria();
		$criteria->addCondition('komponentarif_id ='.Params::KOMPONENTARIF_ID_TOTAL);
		$criteria->addCondition('daftartindakan_id = '.Params::DAFTARTINDAKAN_ID_KONSUL);
		if(!empty($kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);
		}
		if(!empty($jenistarif)){
			$criteria->addCondition("jenistarif_id = ".$jenistarif);
		}
		$model = TariftindakanM::model()->findAll($criteria);

		$data['result'] = $this->renderPartial($this->path_view.'_listTarifKonsul', array('model'=>$model,'ruangan_nama'=>$ruangan_nama), true);

		echo json_encode($data);
		Yii::app()->end();
		}
	}

	/**
	 * action untuk menghapus data item konsultasi poliklinik
	 * @param konsulpoli_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteKonsultasiPoliklinik() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['sukses'] = 0;

		if (isset($_GET['konsulpoli_id'])) {
			if (Yii::app()->db->createCommand()->delete('konsulpoli_t', 'konsulpoli_id=:id', array(':id'=>$_GET['konsulpoli_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan list diagnosa yang telah dilakukan kepada pasien
	 * @param pendaftaran_id
	 * @return array history diagnosa pasien
	 */
	public function actionRiwayatDiagnosa() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pendaftaran_id'])) {
                $pendaftaranID = $_GET['pendaftaran_id'];
                $sql = "SELECT * FROM pasienmorbiditas_t pmd JOIN diagnosa_m d ON pmd.diagnosa_id=d.diagnosa_id
                    WHERE pmd.pendaftaran_id= ".$pendaftaranID." ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if(!empty($loadData)){
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackDiagnosaPasien(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan list Anamnesa yang telah dilakukan kepada pasien
	 * @param pasien_id, pegawai_id
	 * @return array history anamnesa pasien
	 */
	public function actionRiwayatAnamnesa() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pasien_id']) && isset($_GET['pegawai_id'])) {
                $pasien_id = $_GET['pasien_id'];
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT * FROM anamnesa_t
                    WHERE anamnesa_t.pasien_id= ".$pasien_id." AND anamnesa_t.pegawai_id= ".$pegawai_id." ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if(!empty($loadData)){
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackAnamnesaPasien(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan Rincian Anamnesa yang telah dilakukan kepada pasien
	 * @param pendaftaran_id, pasien_id
	 * @return array history rincian anamnesa pasien
	 */
	public function actionRincianAnamnesa() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pendaftaran_id']) && isset($_GET['pasien_id'])) {
                $pendaftaran_id = $_GET['pendaftaran_id'];
                $pasien_id = $_GET['pasien_id'];
                $sql = "SELECT * FROM anamnesa_t 
                    JOIN pegawai_m ON anamnesa_t.pegawai_id = pegawai_m.pegawai_id
                    LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
                    WHERE anamnesa_t.pendaftaran_id= ".$pendaftaran_id." AND anamnesa_t.pasien_id= ".$pasien_id." ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if(!empty($loadData)){
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackRincianAnamnesa(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan list Fisik yang telah dilakukan kepada pasien
	 * @param pasien_id, pegawai_id
	 * @return array history fisik pasien
	 */
	public function actionRiwayatFisik() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pasien_id']) && isset($_GET['pegawai_id'])) {
                $pasien_id = $_GET['pasien_id'];
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT * FROM pemeriksaanfisik_t
                    WHERE pemeriksaanfisik_t.pasien_id= ".$pasien_id." AND pemeriksaanfisik_t.pegawai_id= ".$pegawai_id." ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if(!empty($loadData)){
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackFisikPasien(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan Rincian Fisik yang telah dilakukan kepada pasien
	 * @param pendaftaran_id, pasien_id
	 * @return array history rincian Fisik pasien
	 */
	public function actionRincianFisik() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pendaftaran_id']) && isset($_GET['pasien_id'])) {
                $pendaftaran_id = $_GET['pendaftaran_id'];
                $pasien_id = $_GET['pasien_id'];
                $sql = "SELECT * FROM pemeriksaanfisik_t
                    JOIN pegawai_m ON pemeriksaanfisik_t.pegawai_id = pegawai_m.pegawai_id
                    LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
                    WHERE pemeriksaanfisik_t.pendaftaran_id= ".$pendaftaran_id." AND pemeriksaanfisik_t.pasien_id= ".$pasien_id." ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if(!empty($loadData)){
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackRincianFisik(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan item rujukan yang telah diinput sebelumnya
	 * @param pasien_id, pegawai_id
	 * @return item rujukan dan informasi data yang dikirim ke penunjang
	 */
	public function actionGetRujukanLab() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            if (isset($_GET['pasien_id']) && isset($_GET['pegawai_id'])) {
                $pasien_id = $_GET['pasien_id'];
                $pegawai_id = $_GET['pegawai_id'];
                $sql = " SELECT pasienkirimkeunitlain_t.pasienkirimkeunitlain_id, daftartindakan_m.daftartindakan_nama, pasienkirimkeunitlain_t.tgl_kirimpasien, pasienkirimkeunitlain_t.pegawai_id, pasienkirimkeunitlain_t.pasien_id FROM pasienkirimkeunitlain_t
                        JOIN permintaankepenunjang_t ON permintaankepenunjang_t.pasienkirimkeunitlain_id = pasienkirimkeunitlain_t.pasienkirimkeunitlain_id
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = permintaankepenunjang_t.pemeriksaanlab_id
                        JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
                        WHERE pasienkirimkeunitlain_t.pasien_id= ".$pasien_id." AND pasienkirimkeunitlain_t.pegawai_id= ".$pegawai_id." ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if(!empty($loadData)){
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackLabPasien(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan Rincian Lab yang telah dilakukan kepada pasien
	 * @param pendaftaran_id, pasien_id
	 * @return array history rincian Lab pasien
	 */
	public function actionRincianLab() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            if (isset($_GET['pendaftaran_id']) && isset($_GET['pasien_id'])) {
                $pendaftaran_id = $_GET['pendaftaran_id'];
                $pasien_id = $_GET['pasien_id'];
                $sql = " SELECT pasienkirimkeunitlain_t.pasienkirimkeunitlain_id, daftartindakan_m.daftartindakan_nama, pasienkirimkeunitlain_t.tgl_kirimpasien, pasienkirimkeunitlain_t.pendaftaran_id, pasienkirimkeunitlain_t.pasien_id FROM pasienkirimkeunitlain_t
                        JOIN permintaankepenunjang_t ON permintaankepenunjang_t.pasienkirimkeunitlain_id = pasienkirimkeunitlain_t.pasienkirimkeunitlain_id
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = permintaankepenunjang_t.pemeriksaanlab_id
                        JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = pemeriksaanlab_m.daftartindakan_id
                        WHERE pasienkirimkeunitlain_t.pendaftaran_id= ".$pendaftaran_id." AND pasienkirimkeunitlain_t.pasien_id= ".$pasien_id." ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                if(!empty($loadData)){
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackRincianLab(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan kelompok diagnosa
	 *
	 * @return group diagnosa
	 */
	public function actionGetGroupDiagnosa() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            $sql = " SELECT *
                    FROM kelompokdiagnosa_m
                    WHERE kelompokdiagnosa_aktif = TRUE ";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk untuk menyimpan data mordibitas dari diagnosis yang dilakukan pada pasien rawat jalan
	 *
	 * @param data mordibitas
	 */
	public function actionSubmitMordibitas() {
            header("content-type:application/json");
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
            if(isset($_GET['pasienmordibitas'])){
                $transaction = Yii::app()->db->beginTransaction();
                $format = new MyFormatter;
                $errorDetail = "";
                try{
                    $model = new MOPasienmorbiditasT;
                    $model->attributes = $_GET['pasienmordibitas'];
                    $model->tglmorbiditas = (!empty($model->tglmorbiditas) ? $format->formatDateTimeForDb($model->tglmorbiditas) : date("Y-m-d H:i:s"));
                    $model->create_time = date("Y-m-d H:i:s");
                    $model->kasusdiagnosa = $this->getKasusDiagnosa($model->pasien_id);
                    if($model->save()){
                        $transaction->commit();
                        $data['sukses'] = 1;
                        $data['pesan'] = 'Data diagnosis berhasil disimpan!';
                    }else{
                        $errorDetail .= CHtml::errorSummary($model);
                        $transaction->rollback();
                        $data['sukses'] = 0;
                        $data['pesan'] = 'Data diagnosis gagal disimpan!<br>'.$errorDetail;
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
	 * action untuk menghapus data item pasien mordibitas
	 * @param konsulpoli_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeletePasienMordibitas() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data gagal hapus!";
        $data['sukses'] = 0;

		if (isset($_GET['pasienmorbiditas_id'])) {
			if (Yii::app()->db->createCommand()->delete('pasienmorbiditas_t', 'pasienmorbiditas_id=:id', array(':id'=>$_GET['pasienmorbiditas_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan data item tipe paket
	 * @param carabayar_id
	 * @param kelaspelayanan_id
	 * @param penjamin_id
	 *
	 * @return tipe paket tindakan
	 */
	public function actionGetTipePaket() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['is_found'] = 0;
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
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                if(sizeof($loadData) > 0){
                    $data['data'] = $loadData;
                    $data['pesan'] = "Data ditemukan!";
                    $data['is_found'] = 1;
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan data item tipe paket
	 * @param carabayar_id
	 * @param kelaspelayanan_id
	 * @param penjamin_id
	 *
	 * @return tipe paket tindakan
	 */
	public function actionGetTipePaketHonor() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['is_found'] = 0;
            $sql = "SELECT tipepaket_id, tipepaket_nama, tipepaket_singkatan, tarifpaket, paketsubsidiasuransi, paketsubsidirs, paketiurbiaya
                FROM
                tipepaket_m
                WHERE tipepaket_aktif = TRUE
                AND tipepaket_id = ".Params::TIPEPAKET_ID_NONPAKET."
                ";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            if(sizeof($loadData) > 0){
                $data['data'] = $loadData;
                $data['pesan'] = "Data ditemukan!";
                $data['is_found'] = 1;
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackPaketHonor(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan data nama tindakan
	 * @param ruangan_id
	 * @param penjamin_id
	 * @param kelaspelayanan_id
	 * @param tipepaket_id
	 *
	 * @return array item tindakan
	 */
	public function actionGetItemTindakanHonor(){
            header("content-type:application/json");
            $data = array();
            $data['pesan'] = "Data tidak ditemukan!";
            $data['is_found'] = 0;
            $data['data'] = array();
            $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
            $sql = "SELECT daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama,
                    tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
                    FROM daftartindakan_m
                    JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id
                    WHERE tariftindakan_m.komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
                    AND daftartindakan_m.daftartindakan_aktif = TRUE
                    AND tariftindakan_m.kelaspelayanan_id = ".Params::KELASPELAYANAN_ID_TANPA_KELAS."
                    AND (daftartindakan_m.daftartindakan_nama ilike '%Honor%' OR daftartindakan_m.daftartindakan_nama ilike '%HR%')
                    AND(
                        LOWER(daftartindakan_m.daftartindakan_kode) like '%".$req."%'
                        OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$req."%'
                    )
                    ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC LIMIT 8
                ";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($loadData)){
                $data['data'] = $loadData;
                $data['pesan'] = "Data ditemukan!";
                $data['is_found'] = 1;
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackGetItemTindakanHonor(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan data nama tindakan
	 * @param ruangan_id
	 * @param penjamin_id
	 * @param kelaspelayanan_id
	 * @param tipepaket_id
	 *
	 * @return array item tindakan
	 */
	public function actionGetItemTindakan(){
            header("content-type:application/json");
            $data = array();
            $data['pesan'] = "Data tidak ditemukan!";
            $data['is_found'] = 0;
            $data['data'] = array();
            if(isset($_GET['ruangan_id']) && isset($_GET['penjamin_id']) && isset($_GET['kelaspelayanan_id'])){
                $req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
                    $sql = "SELECT kelompoktindakan_m.kelompoktindakan_nama, daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_kode, daftartindakan_m.daftartindakan_nama,
                        tariftindakan_m.harga_tariftindakan, tariftindakan_m.persendiskon_tind, tariftindakan_m.hargadiskon_tind
                        FROM daftartindakan_m JOIN kelompoktindakan_m ON daftartindakan_m.kelompoktindakan_id=kelompoktindakan_m.kelompoktindakan_id
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
                        ORDER BY daftartindakan_m.daftartindakan_kode ASC, daftartindakan_m.daftartindakan_nama ASC LIMIT 8
                        ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                if(!empty($loadData)){
                    $data['data'] = $loadData;
                    $data['pesan'] = "Data ditemukan!";
                    $data['is_found'] = 1;
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan satuan tindakan
	 * @return array satuan tindakan
	 */
	public function actionGetSatuanTindakan() {
		header("content-type:application/json");
		$data = array();
		$data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		$data['data'] = '';
		$sql = "SELECT * FROM lookup_m WHERE lookup_type='satuantindakan'";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['data'] = $loadData;
			$data['pesan'] = "Data ditemukan!";
			$data['is_found'] = 1;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan satuan tindakan
	 * @return array satuan tindakan
	 */
	public function actionGetSatuanTindakanHonor() {
		header("content-type:application/json");
		$data = array();
		$data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		$data['data'] = '';
		$sql = "SELECT * FROM lookup_m WHERE lookup_type='satuantindakan' AND lookup_name='KALI'";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['data'] = $loadData;
			$data['pesan'] = "Data ditemukan!";
			$data['is_found'] = 1;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallbackSatuanTindakan(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk menyimpan data tindakan pelayanan
	 *
	 * @param serialize tindakan pelayanan
	 * @return sukses 1/0 dan pesan setelah submit
	 */
	public function actionSubmitTindakanPelayanan(){
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
                    if(isset($_GET['tindakanpelayanan'])){
                        $model = new MOTindakanpelayananT;
                        $model->attributes = $_GET['tindakanpelayanan'];
                        $model->tgl_tindakan = (!empty($model->tgl_tindakan) ? $format->formatDateTimeForDb($model->tgl_tindakan) : date("Y-m-d H:i:s"));
                        $model->create_time = date("Y-m-d H:i:s");
                        $model->shift_id = $this->getShift("shift_id");
                        $model->tarif_satuan = $model->getTarifSatuan(); //RND-7250
                        $model->tarif_tindakan = $model->tarif_satuan * $model->qty_tindakan;
                        $model->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                        $model->satuantindakan = "KALI";
                        if(!$model->cyto_tindakan){ //false
                            $model->tarifcyto_tindakan = 0;
                        }else{
                            $model->tarifcyto_tindakan = $model->tarif_tindakan + ($model->tarif_tindakan * 10 / 100);
                        }
                        $model->pembebasan_tindakan = 0;
                        $model->dokterpemeriksa1_id = $_GET['tindakanpelayanan']['pegawai_id'];
                        $model->qty_tindakan = $_GET['tindakanpelayanan']['qty_tindakan'];
                        $model->cyto_tindakan = $_GET['tindakanpelayanan']['cyto_tindakan'];
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
	 * action untuk menyimpan data tindakan pelayanan
	 *
	 * @param serialize tindakan pelayanan
	 * @return sukses 1/0 dan pesan setelah submit
	 */
	public function actionSubmitHonorDokter(){
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
                    if(isset($_GET['tindakanpelayanan'])){
                        $model = new MOTindakanpelayananT;
                        $model->attributes = $_GET['tindakanpelayanan'];
                        $model->tgl_tindakan = (!empty($model->tgl_tindakan) ? $format->formatDateTimeForDb($model->tgl_tindakan) : date("Y-m-d H:i:s"));
                        $model->create_time = date("Y-m-d H:i:s");
                        $model->shift_id = $this->getShift("shift_id");
                        $model->tarif_satuan = $model->getTarifSatuan(); //RND-7250
                        $model->tarif_tindakan = $model->tarif_satuan * $model->qty_tindakan;
                        $model->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                        $model->satuantindakan = "KALI";
                        $model->pembebasan_tindakan = 0;
                        $model->dokterpemeriksa1_id = $_GET['tindakanpelayanan']['pegawai_id'];
                        $model->qty_tindakan = 1;
                        $model->cyto_tindakan = 0;
                        $model->tarifcyto_tindakan = 0;
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
	 * action untuk mendapatkan riwayat tindakan pelayanan
	 * @param pendaftaran_id
	 * @return array dari tindakan
	 */
	public function actionGetTindakanPelayananDaftarTindakan() {
            header("content-type:application/json");
            $data = array();
            $data['pesan'] = "Data tidak ditemukan!";
            $data['is_found'] = 0;
            $data['data'] = array();
            if (isset($_GET['pendaftaran_id'])){
                $sql = "SELECT tindakanpelayanan_t.tgl_tindakan, tindakanpelayanan_t.tindakanpelayanan_id, tindakanpelayanan_t.qty_tindakan, daftartindakan_m.daftartindakan_nama FROM tindakanpelayanan_t
                        JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id=tindakanpelayanan_t.daftartindakan_id
                        WHERE tindakanpelayanan_t.pendaftaran_id=".$_GET['pendaftaran_id']." AND tindakanpelayanan_t.pasienmasukpenunjang_id IS NULL AND (daftartindakan_m.daftartindakan_nama ilike '%Honor%' OR daftartindakan_m.daftartindakan_nama ilike '%HR%') ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                if(!empty($loadData)){
                    foreach ($loadData as $key => $val) {
                        $data['data'][$key] = array(
                            'tgl_tindakan'=>MyFormatter::formatDateTimeForuser(explode(' ',$val['tgl_tindakan'])[0]),
                            'jam_tindakan'=>explode(' ',$val['tgl_tindakan'])[1],
                            'tindakanpelayanan_id'=>$val['tindakanpelayanan_id'],
                            'daftartindakan_nama'=>$val['daftartindakan_nama'],
                            'qty_tindakan'=>$val['qty_tindakan']);
                        }				
                $data['pesan'] = "Data ditemukan!";
                $data['is_found'] = 1;
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackDaftarTindakan(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan riwayat tindakan pelayanan
	 * @param pendaftaran_id
	 * @return array dari tindakan
	 */
	public function actionGetTindakanPelayanan() {
            header("content-type:application/json");
            $data = array();
            $data['pesan'] = "Data tidak ditemukan!";
            $data['is_found'] = 0;
            $data['data'] = array();
            if (isset($_GET['pendaftaran_id'])){
                $sql = "SELECT tindakanpelayanan_t.tgl_tindakan, tindakanpelayanan_t.tindakanpelayanan_id, tindakanpelayanan_t.qty_tindakan, "
                        . "daftartindakan_m.daftartindakan_nama FROM tindakanpelayanan_t "
                        . "JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id=tindakanpelayanan_t.daftartindakan_id "
                        . "WHERE tindakanpelayanan_t.pendaftaran_id=".$_GET['pendaftaran_id']." AND tindakanpelayanan_t.pasienmasukpenunjang_id IS NULL ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                if(!empty($loadData)){
                    foreach ($loadData as $key => $val) {
                        $data['data'][$key] = array(
                            'tgl_tindakan'=>MyFormatter::formatDateTimeForuser(explode(' ',$val['tgl_tindakan'])[0]),
                            'jam_tindakan'=>explode(' ',$val['tgl_tindakan'])[1],
                            'tindakanpelayanan_id'=>$val['tindakanpelayanan_id'],
                            'daftartindakan_nama'=>$val['daftartindakan_nama'],
                            'qty_tindakan'=>$val['qty_tindakan']);
                        }				
                $data['pesan'] = "Data ditemukan!";
                $data['is_found'] = 1;
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk menghapus data item tindakan
	 * @param tindakanpelayanan_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteTindakan() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data gagal hapus!";
        $data['sukses'] = 0;

		if (isset($_GET['tindakanpelayanan_id'])) {
			if (Yii::app()->db->createCommand()->delete('tindakanpelayanan_t', 'tindakanpelayanan_id=:id', array(':id'=>$_GET['tindakanpelayanan_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk menyimpan rujukan ke luar
	 * @param serialize data rujukan
	 * @return 1/0, pesan sukses
	 */
	public function actionSubmitRujukanKeLuar(){
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
                $model->tgldirujuk = MyFormatter::formatDateTimeForDb($model->tgldirujuk);
                $model->tglberlakusurat = MyFormatter::formatDateTimeForDb($model->tglberlakusurat);
                $model->sampaidengan = MyFormatter::formatDateTimeForDb($model->sampaidengan);
				$model->nosuratrujukan = MyGenerator::noSuratRujukanKeluar();
				
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
	 * action untuk mendapatkan item rujukan ke luar
	 *
	 * @return array data rujukan keluar
	 */
	public function actionGetItemRujukanKeluar() {
		header("content-type:application/json");
		$data = array();
		$data['pesan'] = "Data tidak ditemukan!";
		$data['is_found'] = 0;
		$data['data'] = '';
		$sql = "SELECT *
				FROM rujukankeluar_m
				WHERE rujukankeluar_aktif = TRUE
				ORDER BY rumahsakitrujukan ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['data'] = $loadData;
			$data['pesan'] = "Data ditemukan!";
			$data['is_found'] = 1;
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan riwayat rujukan keluar
	 * @param pendaftaran_id
	 * @return array riwayat rujukan keluar
	 */
	public function actionGetRiwayatRujukanKeluar() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pasiendirujukkeluar_t prk JOIN rujukankeluar_m rk ON prk.rujukankeluar_id=rk.rujukankeluar_id "
					. " WHERE prk.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$data['data']=$loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk menghapus data item referensi keluar
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteItemRefKeluar() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak berhasil dihapus!";
        $data['sukses'] = 0;

		if (isset($_GET['pasiendirujukkeluar_id'])) {
			if (Yii::app()->db->createCommand()->delete('pasiendirujukkeluar_t', 'pasiendirujukkeluar_id=:id', array(':id'=>$_GET['pasiendirujukkeluar_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan riwayat reseptur
	 * @param pendaftaran_id
	 * @return array riwayat reseptur
	 */
	public function actionGetRiwReseptur() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM reseptur_t r WHERE r.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$i=0;
				foreach ($loadData as $datum) {
					$data['data'][$i]['tglreseptur'] = MyFormatter::formatDateTimeForuser(explode(' ',$datum['tglreseptur'])[0]);
					$data['data'][$i]['noresep'] = $datum['noresep'];
					$data['data'][$i]['reseptur_id'] = $datum['reseptur_id'];
					$resepID = $datum['reseptur_id'];
					$sql = "SELECT * "
							. "FROM resepturdetail_t rd JOIN obatalkes_m oa ON rd.obatalkes_id=oa.obatalkes_id "
							. "JOIN racikan_m r ON rd.racikan_id=r.racikan_id "
							. "JOIN satuankecil_m sk ON sk.satuankecil_id = rd.satuankecil_id "
							. "JOIN sumberdana_m sd ON rd.sumberdana_id = sd.sumberdana_id "
							. "WHERE rd.reseptur_id=".$resepID;
					$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
					if (sizeof($loadData2)>0) {
						$data['data'][$i]['detail']=$loadData2;
						$data['is_found'] = 1;
						$data['pesan'] = "Data ditemukan!";
					}
					$i++;
				}
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	public function actionGetRiwayatReseptur() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM reseptur_t r JOIN resepturdetail_t rd On r.reseptur_id=rd.reseptur_id "
					. "WHERE r.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$data['data']=$loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
        
        /**
    * action untuk mendapatkan data anamnesa
    * @param pegawai_id, ruangan_id
    * @return array of anamnesa
    */
    public function actionGetAnamnesis() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = array();
        $statusPasien = '';
        $tglPendaftaran = '';
        if (isset($_GET['q'])&&isset($_GET['status'])&&isset($_GET['start_date'])&&isset($_GET['end_date'])&&isset($_GET['pegawai_id'])&&isset($_GET['ruangan_id'])&&isset($_GET['instalasi_tab'])) {
            $q = strtolower($_GET['q']);
            $statusPeriksa = $_GET['status'];
            $startDate = $_GET['start_date'];
            $endDate = $_GET['end_date'];
            $pegawai_id = isset($_GET['pegawai_id'])?$_GET['pegawai_id']:'';
            $ruangan_id = isset($_GET['ruangan_id'])?$_GET['ruangan_id']:'';
            if ($statusPeriksa==""){
                $statusStr='';
            }else{
                $statusStr = "AND statusperiksa='".$statusPeriksa."'";
            }
            if ($ruangan_id==""){
                $ruangan_id='';
            }else{
                if($_GET['instalasi_tab'] == 'RI'){
                    $ruangan_id = "pasienadmisi_t.ruangan_id='".$ruangan_id."' AND";
                }else{
                    $ruangan_id = "pendaftaran_t.ruangan_id='".$ruangan_id."' AND";
                }
            }
            if(isset($_GET['offset'])){
                if(!empty($_GET['offset'])){
                    $offset = ' OFFSET '.$_GET['offset'];
                }else{
                    $offset = '';
                }
            }else{
                $offset = '';
            }
            if ($startDate!='' && $endDate!='') {
                if($_GET['instalasi_tab'] == 'RI'){
                    $strBetween = " AND pasienadmisi_t.tgladmisi::timestamp::date BETWEEN '".MyFormatter::formatDateTimeForDb($startDate)."' AND '".MyFormatter::formatDateTimeForDb($endDate)."'";
                }else{
                    $strBetween = " AND tgl_pendaftaran::timestamp::date BETWEEN '".MyFormatter::formatDateTimeForDb($startDate)."' AND '".MyFormatter::formatDateTimeForDb($endDate)."'";
                }
            }else {
                if($_GET['instalasi_tab'] == 'RI'){
                     $strBetween = "AND pasienadmisi_t.tgladmisi::timestamp::date='".date('Y-m-d')."'";
                }else{
                    $strBetween = "AND tgl_pendaftaran::timestamp::date='".date('Y-m-d')."'";
                }
            }
            if ($tglPendaftaran=='') {
                $tglPendaftaran = date('Y-m-d');
            }
            if($_GET['instalasi_tab'] == 'RJ'){
                $sql = "SELECT anamnesa_t.*,
                        pasien_m.nama_pasien,pasien_m.pasien_id,pasien_m.no_rekam_medik,pasien_m.namadepan,
                        pendaftaran_t.no_pendaftaran, pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.statusperiksa,
                        instalasi_m.instalasi_id,instalasi_m.instalasi_nama,ruangan_m.ruangan_id,ruangan_m.ruangan_nama 
                        FROM anamnesa_t
                        JOIN pasien_m ON anamnesa_t.pasien_id = pasien_m.pasien_id
                        JOIN pendaftaran_t ON anamnesa_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                        LEFT JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        LEFT JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                        WHERE $ruangan_id instalasi_m.instalasi_id = ".PARAMS::INSTALASI_ID_RJ." AND anamnesa_t.pasienadmisi_id IS NULL AND anamnesa_t.pegawai_id=".$pegawai_id." AND (LOWER(nama_pasien) LIKE '%$q%' OR LOWER(no_pendaftaran) LIKE '%$q%') ".$statusStr.$strBetween." AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_SUDAH_PULANG." AND pasienbatalperiksa_id IS NULL' 
                        ORDER BY tgl_pendaftaran DESC LIMIT 8".$offset;
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            }else if($_GET['instalasi_tab'] == 'RI'){
                $sql = "SELECT anamnesa_t.*, "
                        ."pasien_m.nama_pasien,pasien_m.pasien_id,pasien_m.no_rekam_medik,pasien_m.namadepan, "
                        ."pendaftaran_t.no_pendaftaran, pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.statusperiksa, "
                        ."instalasi_m.instalasi_id,instalasi_m.instalasi_nama,ruangan_m.ruangan_id,ruangan_m.ruangan_nama "
                        ."FROM anamnesa_t "
                        ."JOIN pasienadmisi_t ON anamnesa_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id "
                        ."LEFT JOIN ruangan_m ON pasienadmisi_t.ruangan_id = pasienadmisi_t.ruangan_id "
                        ."LEFT JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id "
                        ."JOIN pasien_m ON anamnesa_t.pasien_id = pasien_m.pasien_id "
                        ."JOIN pendaftaran_t ON anamnesa_t.pendaftaran_id = pendaftaran_t.pendaftaran_id "
                        ."WHERE $ruangan_id anamnesa_t.pegawai_id=".$pegawai_id." AND (LOWER(nama_pasien) LIKE '%$q%' OR LOWER(no_pendaftaran) LIKE '%$q%') ".$statusStr.$strBetween." AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_SUDAH_PULANG." AND pasienbatalperiksa_id IS NULL' "
                        ."ORDER BY tgl_pendaftaran DESC LIMIT 8".$offset;
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            }else if($_GET['instalasi_tab'] == 'RD'){
                $sql = "SELECT anamnesa_t.*,
                        pasien_m.nama_pasien,pasien_m.pasien_id,pasien_m.no_rekam_medik,pasien_m.namadepan,
                        pendaftaran_t.no_pendaftaran, pendaftaran_t.pendaftaran_id,pendaftaran_t.tgl_pendaftaran, pendaftaran_t.statusperiksa,
                        instalasi_m.instalasi_id,instalasi_m.instalasi_nama,ruangan_m.ruangan_id,ruangan_m.ruangan_nama 
                        FROM anamnesa_t
                        JOIN pasien_m ON anamnesa_t.pasien_id = pasien_m.pasien_id
                        JOIN pendaftaran_t ON anamnesa_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                        LEFT JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                        LEFT JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                        WHERE $ruangan_id instalasi_m.instalasi_id = ".PARAMS::INSTALASI_ID_RD." AND anamnesa_t.pasienadmisi_id IS NULL AND anamnesa_t.pegawai_id=".$pegawai_id." AND (LOWER(nama_pasien) LIKE '%$q%' OR LOWER(no_pendaftaran) LIKE '%$q%') ".$statusStr.$strBetween." AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_SUDAH_PULANG." AND pasienbatalperiksa_id IS NULL'
                        ORDER BY tgl_pendaftaran DESC LIMIT 8".$offset;
                        
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            }
            $data['data'] = $loadData;
            if (!empty($loadData)) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackAnamnesis".$_GET['instalasi_tab']."(".$encode.")";
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
	 * action untuk menghapus data item konsultasi gizi
	 * @param pasienkirimkeunitlain_id
	 * @return status 1/0 deleted or not
	 */
	public function actionDeleteReseptur() {
		header("content-type:application/json");
                $data = array();
		$data['is_found'] = 0;
                $data['pesan'] = "Data tidak ditemukan!";
                $data['sukses'] = 0;

		if (isset($_GET['reseptur_id'])) {
                    if (Yii::app()->db->createCommand()->delete('resepturdetail_t', 'reseptur_id=:id', array(':id'=>$_GET['reseptur_id']))) {
                        if (Yii::app()->db->createCommand()->delete('reseptur_t', 'reseptur_id=:id', array(':id'=>$_GET['reseptur_id']))) {
                            $data['sukses'] = 1;
                            $data['pesan'] = 'Data berhasil dihapus!';
                        }
                    }
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan ruangan farmasi
	 *
	 * @return array ruangan id farmasi
	 */
	public function actionGetSigna() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		$sql = "SELECT lookup_name, lookup_value
			FROM lookup_m
			WHERE lookup_aktif = TRUE
				AND LOWER(lookup_type) = 'signa_oa'
			ORDER BY lookup_urutan ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!";
			$data['data'] = $loadData;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * action untuk mendapatkan ruangan farmasi
	 *
	 * @return array ruangan id farmasi
	 */
	public function actionGetEtiket() {
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		$sql = "SELECT lookup_name, lookup_value
			FROM lookup_m
			WHERE lookup_aktif = TRUE
				AND LOWER(lookup_type) = 'etiket'
			ORDER BY lookup_urutan ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!";
			$data['data'] = $loadData;
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan ruangan farmasi
	 *
	 * @return array ruangan id farmasi
	 */
	public function actionGetRuanganFarmasi() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";

		$sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama
			FROM ruangan_m
			WHERE ruangan_m.instalasi_id = ".Params::INSTALASI_ID_FARMASI."
				AND ruangan_m.ruangan_aktif = TRUE
				AND ruangan_m.ruangan_id <> ".Params::RUANGAN_ID_GUDANG_FARMASI."
				ORDER BY ruangan_m.ruangan_nourut ASC, ruangan_m.ruangan_nama ASC";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if(sizeof($loadData) > 0){
			$data['data'] = $loadData;
			$data['pesan'] = "Data ditemukan!";
			$data['is_found'] = 1;
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan etiket
	 * @return: array of obat etiket
	 */
	public function actionGetObatAlkes(){
		header("content-type:application/json");
		$data = array();
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
		$req = (isset($_GET['q']) ? str_replace('"','',str_replace("'","",strtolower(trim($_GET['q'])))) : "");
        $ruangan=isset($_GET['ruangan_id'])?$_GET['ruangan_id']:null;
		$sql = "SELECT obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_barcode, obatalkes_m.obatalkes_kode, obatalkes_m.obatalkes_nama, obatalkes_m.obatalkes_namalain, obatalkes_m.obatalkes_golongan, obatalkes_m.obatalkes_kategori, obatalkes_m.obatalkes_kadarobat, obatalkes_m.harganetto, obatalkes_m.hargajual,obatalkes_m.kekuatan,
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
				LIMIT 8";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
        if(isset($_GET['pendaftaran_id']) && empty($ruangan)){
            $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
            if($modPendaftaran)
                $ruangan = $modPendaftaran->ruangan_id;
        }
        else
            $modPendaftaran = null;
		if(sizeof($loadData) > 0){
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!";
			// $data['data'] = $loadData;
             foreach ($loadData as $i => $obat) {
                $data['data'][$i] = $obat;
                $data['data'][$i]['stok'] = StokobatalkesT::getJumlahStok($obat['obatalkes_id'],$ruangan);
            }
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action submit reseptur
	 * MA-265
	 * @param serialize dari array reseptur
	 * @param serialize dari array detail reseptur
	 * @return json
	 */
	public function actionSubmitReseptur(){
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
                    $model->tglreseptur = (!empty($_GET['reseptur']['tglreseptur']) ? $format->formatDateTimeForDb($_GET['reseptur']['tglreseptur']." ".date("H:i:s")) : date("Y-m-d H:i:s"));
                    $model->create_time = date("Y-m-d H:i:s");
                    $model->noresep = MyGenerator::noResepReseptur();
                    if($model->save()){
                        if(count($_GET['resepturdetail']) > 0){
                            foreach($_GET['resepturdetail'] AS $i => $detail){
                                $modDetail = new MOResepturdetailT();
                                $modDetail->attributes = $detail;
                                $modDetail->reseptur_id = $model->reseptur_id;
                                $modDetail->hargajual_reseptur = $modDetail->qty_reseptur * $modDetail->hargasatuan_reseptur;
                                $modDetail->r = "R/";
                                $modDetail->rke = 1;
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

	public function actionSubmitPenggunaanBahan() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$errorDetail = "";
		if(isset($_GET['bahan'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$model = new MOObatalkespasienT;
				$model->attributes = $_GET['bahan'];
				$model->tglpelayanan = date("Y-m-d H:i:s");
				$model->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
				$model->pasienmasukpenunjang_id = null;
				$model->shift_id = $this->getShift("shift_id");
				$model->tglpelayanan = date ('Y-m-d H:i:s');
				$model->create_time = date ('Y-m-d H:i:s');
				if($model->save()){
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

	public function actionGetRiwayatPemakaianBahan() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$data['header'] = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM obatalkespasien_t op JOIN obatalkes_m oa ON op.obatalkes_id=oa.obatalkes_id "
					. "WHERE op.pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();
			if (sizeof($loadData)>0) {
				$data['data']=$loadData;
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action dashboard untuk mendapatkan total registrasi
	 * total registrasi dihitung berdasarkan hari kemarin dan hari sekarang serta
	 * ditampilkan apakah mengalami penurunan atau kenaikan jumlah register
	 *
	 * @param pegawai_id
	 * @return array data total register dan kenaikannya
	 */
	public function actionGetTotalReg() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pegawai_id'])) {
                //------------------- total register/pasien per hari -----------------------------
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t
                        WHERE pegawai_id=".$_GET['pegawai_id'].
                        " AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                        $data['totalreg']['totCurrDate']=$loadData['totcurrdate'];
                        $sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t
                                WHERE pegawai_id=".$_GET['pegawai_id'].
                                " AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday')";
                        $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                        if (!empty($loadData2)) {
                            $data['totalreg']['totYestDate']=$loadData2['totyestdate'];
                            if ($data['totalreg']['totYestDate']!=0) {
                                $data['totalreg']['increase']= (($data['totalreg']['totCurrDate'] - $data['totalreg']['totYestDate']) / $data['totalreg']['totYestDate'])*100;
                            }else {
                                if($data['totalreg']['totCurrDate']==0) {
                                    $data['totalreg']['increase']= 0;
                                }else{
                                    $data['totalreg']['increase']= 100;
                                }
                            }
                            $data['is_found'] = 1;
                            $data['pesan'] = "Data ditemukan!";
                        }
                }
                //------------------- end of total register/pasien per hari -----------------------------

                //------------------- total register RJ/pasien per hari -----------------------------
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t
                        WHERE pegawai_id=".$_GET['pegawai_id'].
                        " AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND instalasi_id='".Params::INSTALASI_ID_RJ."' ";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                        $data['regrj']['totCurrDate']=$loadData['totcurrdate'];
                        $sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t
                                        WHERE pegawai_id=".$_GET['pegawai_id'].
                                        " AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday') AND instalasi_id= '".Params::INSTALASI_ID_RJ."' ";
                        $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                        if (!empty($loadData2)) {
                                $data['regrj']['totYestDate']=$loadData2['totyestdate'];
                                if ($data['regrj']['totYestDate']!=0) {
                                        $data['regrj']['increase']= (($data['regrj']['totCurrDate'] - $data['regrj']['totYestDate']) / $data['regrj']['totYestDate'])*100;
                                }else {
                                        if ($data['regrj']['totCurrDate']==0) {
                                                $data['regrj']['increase']= 0;
                                        }else {
                                                $data['regrj']['increase']= 100;
                                        }

                                }
                                $data['is_found'] = 1;
                                $data['pesan'] = "Data ditemukan!";
                        }
                }
                //------------------- end of total register RJ/pasien per hari -----------------------------

                //------------------- total register RD/pasien per hari -----------------------------
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t
                        WHERE pegawai_id=".$_GET['pegawai_id'].
                        " AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND instalasi_id='".Params::INSTALASI_ID_RD."' AND ruangan_id= '".Params::RUANGAN_ID_PERAWATAN_DARURAT."' ";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if(!empty($loadData)){
                    $data['regrd']['totCurrDate']=$loadData['totcurrdate'];
                    $sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t
                            WHERE pegawai_id=".$_GET['pegawai_id'].
                            " AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday') AND instalasi_id= '".Params::INSTALASI_ID_RD."' AND ruangan_id= '".Params::RUANGAN_ID_PERAWATAN_DARURAT."' ";
                    $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                    if(!empty($loadData2)){
                        $data['regrd']['totYestDate']=$loadData2['totyestdate'];
                        if ($data['regrd']['totYestDate']!=0) {
                            $data['regrd']['increase']= (($data['regrd']['totCurrDate'] - $data['regrd']['totYestDate']) / $data['regrd']['totYestDate'])*100;
                        }else {
                            if ($data['regrd']['totCurrDate']==0) {
                                $data['regrd']['increase']= 0;
                            }else {
                                $data['regrd']['increase']= 100;
                            }
                        }
                        $data['is_found'] = 1;
                        $data['pesan'] = "Data ditemukan!";
                    }
                }
                //------------------- end of total register RD/pasien per hari -----------------------------

                //------------------- total register RI/pasien per hari -----------------------------
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t
                        WHERE pegawai_id=".$_GET['pegawai_id'].
                        " AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND instalasi_id='".Params::INSTALASI_ID_RI."' ";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                    $data['regri']['totCurrDate']=$loadData['totcurrdate'];
                    $sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t
                            WHERE pegawai_id=".$_GET['pegawai_id'].
                            " AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday') AND instalasi_id= '".Params::INSTALASI_ID_RI."' ";
                    $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData2)) {
                        $data['regri']['totYestDate']=$loadData2['totyestdate'];
                        if ($data['regri']['totYestDate']!=0) {
                            $data['regri']['increase']= (($data['regri']['totCurrDate'] - $data['regri']['totYestDate']) / $data['regri']['totYestDate'])*100;
                        }else {
                            if ($data['regri']['totCurrDate']==0) {
                                $data['regri']['increase']= 0;
                            }else {
                                $data['regri']['increase']= 100;
                            }
                        }
                        $data['is_found'] = 1;
                        $data['pesan'] = "Data ditemukan!";
                    }
                }
                //------------------- end of total register RI/pasien per hari -----------------------------

                //------------------- dashboard get register per tahun      -----------------------------
                $currDay = date('d');
                $currMonth = date('m');
                $currYear = date('Y');
                $arrMonth = array();
                if ($currMonth<=6) {
                    for ($i=1;$i<=6;$i++) {
                        $arrMonth[$i] = $i;
                    }
                }else {
                    for ($i=7;$i<=12;$i++) {
                        $arrMonth[$i] = $i;
                    }
                }
                $currYearMonth = $currYear."-".$currMonth."-";
                $i = 0;
                foreach ($arrMonth as $datum) {
                    $currDate = $currYearMonth.$datum;
                    $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t "
                        . "WHERE pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                        . "AND EXTRACT(MONTH FROM tgl_pendaftaran)=".$datum;
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    if(!empty($loadData)) {
                        $data['regtahun'][$i]['bulan']=$datum;
                        $data['regtahun'][$i]['count']=$loadData['totcurrdate'];
                    }
                    $i++;
                }
                //------------------- end of dashboard get register per tahun  -----------------------------

                //-------------------- dashboard jenis kelamin per tahun
                $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                    . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                    . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_LAKI_LAKI."'";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                    $data['jeniskelamin']['tahun']['laki']=$loadData['totcurrltahun'];
                    $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                        . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                        . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_PEREMPUAN."'";
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData)) {
                        $data['jeniskelamin']['tahun']['perempuan']=$loadData['totcurrltahun'];
                    }
                }
                // ------------------ end of dashboard jenis kelamin per tahun

                //------------------- dashboard get register per bulan      -----------------------------
                $currDay = date('d');
                //$currMonth = date('m');
                //$currYear = date('Y');
                $arrDay = array();
                if ($currDay<=6) {
                    for ($i=1;$i<=6;$i++) {
                        $arrDay[$i] = $i;
                    }
                }else {
                    for ($i=($currDay-5);$i<=$currDay;$i++) {
                        $arrDay[$i] = $i;
                    }
                }
                $i = 0;
                foreach ($arrDay as $datum) {
                    $sql = "SELECT COUNT(*) as totcurrdate FROM pendaftaran_t "
                        . "WHERE pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                        . "AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(DAY FROM tgl_pendaftaran)=".$datum;
                    $sqlJasdokBulan = "SELECT SUM(tarif_tindakankomp) AS tottarifkomponen 
                        FROM tindakankomponen_t
                        JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = tindakankomponen_t.tindakanpelayanan_id
                        JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = tindakanpelayanan_t.pendaftaran_id
                        JOIN komponentarif_m ON komponentarif_m.komponentarif_id = tindakankomponen_t.komponentarif_id "
                        . "WHERE komponentarif_nama ilike '%dokter%' AND dokterpemeriksa1_id=$pegawai_id "
                        . "AND EXTRACT(YEAR FROM tgl_tindakan)=EXTRACT(YEAR FROM NOW()) "
                        . "AND EXTRACT(MONTH FROM tgl_tindakan)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(DAY FROM tgl_tindakan) = ".$datum;

                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    $loadDataJasDokBulan = Yii::app()->db->createCommand($sqlJasdokBulan)->queryRow();
                    if (!empty($loadData)) {
                        $data['regbulan'][$i]['tgl']='Tgl. '.$datum;
                        $data['regbulan'][$i]['count']=$loadData['totcurrdate'];
                    }
                    if (!empty($loadDataJasDokBulan)) {
                        $data['jasdokbulan'][$i]['tgl']='Tgl. '.$datum;
                        $data['jasdokbulan'][$i]['sum']=($loadDataJasDokBulan['tottarifkomponen']==null?0:$loadDataJasDokBulan['tottarifkomponen']);
                    }
                    $i++;
                }
                //------------------- get register per bulan  -----------------------------

                //-------------------- dashboard jenis kelamin per bulan
                $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                    . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW())"
                    . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_LAKI_LAKI."'";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                    $data['jeniskelamin']['bulan']['laki']=$loadData['totcurrltahun'];
                    $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                        . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW())"
                        . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_PEREMPUAN."'";
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData)) {
                        $data['jeniskelamin']['bulan']['perempuan']=$loadData['totcurrltahun'];
                    }
                }
                // ------------------ end of dashboard jenis kelamin per tahun

                //------------------- beginning total jasa dokter hari ini-------------------------------
                $totalJasDokHari = 0;
                $data['jasdok']['hari'] = $totalJasDokHari;
                $sql = "SELECT SUM(tarif_tindakankomp) AS totcurrjasdokharidate 
                FROM tindakankomponen_t
                JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = tindakankomponen_t.tindakanpelayanan_id
                JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = tindakanpelayanan_t.pendaftaran_id
                JOIN komponentarif_m ON komponentarif_m.komponentarif_id = tindakankomponen_t.komponentarif_id
                WHERE komponentarif_nama ilike '%dokter%' AND dokterpemeriksa1_id = $pegawai_id AND tgl_tindakan::date = now()::date";
                if ($loadData = Yii::app()->db->createCommand($sql)->queryRow()) {
                    $sql = "SELECT SUM(tarif_kompsatuan) as totyestjasdokharidate FROM pasienpelayanandokterrs_v "
                        . "WHERE pegawai_id=$pegawai_id AND tgl_pendaftaran::date = (SELECT DATE 'yesterday')";
                    if ($loadData['totcurrjasdokharidate']==null) {
                        $currJasDok = 0;
                    }else {
                        $currJasDok = $loadData['totcurrjasdokharidate'];
                    }
                    $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                    $yestJasDok = ($loadData2['totyestjasdokharidate']==null?0:$loadData2['totyestjasdokharidate']);
                    $data['jasdok']['kemarin']=$yestJasDok;
                    if ($yestJasDok!=0) {
                        $data['jasdok']['increase'] = (($currJasDok - $yestJasDok) / $yestJasDok)*100;
                    }else  {
                        if ($currJasDok==0) {
                            $data['jasdok']['increase']= 0;
                        }else {
                            $data['jasdok']['increase']= 100;
                        }
                    }
                    $data['jasdok']['hari']= $currJasDok;
                }
                //------------------ end of total jasa dokter hari ini ----------------------------------
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action dashboard untuk mendapatkan total registrasi baru
	 * total registrasi dihitung berdasarkan hari kemarin dan hari sekarang serta
	 * ditampilkan apakah mengalami penurunan atau kenaikan jumlah register
	 *
	 * @param pegawai_id
	 * @return array data total register dan kenaikannya
	 */
	public function actionGetTotalRegistrasi() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pegawai_id'])) {
                //------------------- total register RJ/pasien per hari -----------------------------
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t
                        WHERE pegawai_id=".$_GET['pegawai_id'].
                        " AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND instalasi_id='".Params::INSTALASI_ID_RJ."' AND statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' ";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                    $data['regrj']['totCurrDate']=$loadData['totcurrdate'];
                    $sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t
                            WHERE pegawai_id=".$_GET['pegawai_id'].
                            " AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday') AND instalasi_id= '".Params::INSTALASI_ID_RJ."' AND statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' ";
                    $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData2)) {
                        $data['regrj']['totYestDate']=$loadData2['totyestdate'];
                        if ($data['regrj']['totYestDate']!=0) {
                            $data['regrj']['increase']= (($data['regrj']['totCurrDate'] - $data['regrj']['totYestDate']) / $data['regrj']['totYestDate'])*100;
                        }else {
                            if ($data['regrj']['totCurrDate']==0) {
                                $data['regrj']['increase']= 0;
                            }else {
                                $data['regrj']['increase']= 100;
                            }

                        }
                        $data['is_found'] = 1;
                        $data['pesan'] = "Data ditemukan!";
                    }
                }
                //------------------- end of total register RJ/pasien per hari -----------------------------

                //------------------- total register RD/pasien per hari -----------------------------
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t
                        WHERE pegawai_id=".$_GET['pegawai_id'].
                        " AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND instalasi_id='".Params::INSTALASI_ID_RD."' AND ruangan_id= '".Params::RUANGAN_ID_PERAWATAN_DARURAT."' AND statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' ";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if(!empty($loadData)){
                    $data['regrd']['totCurrDate']=$loadData['totcurrdate'];
                    $sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t
                            WHERE pegawai_id=".$_GET['pegawai_id'].
                            " AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday') AND instalasi_id= '".Params::INSTALASI_ID_RD."' AND ruangan_id= '".Params::RUANGAN_ID_PERAWATAN_DARURAT."' AND statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' ";
                    $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                    if(!empty($loadData2)){
                        $data['regrd']['totYestDate']=$loadData2['totyestdate'];
                        if ($data['regrd']['totYestDate']!=0) {
                            $data['regrd']['increase']= (($data['regrd']['totCurrDate'] - $data['regrd']['totYestDate']) / $data['regrd']['totYestDate'])*100;
                        }else {
                            if ($data['regrd']['totCurrDate']==0) {
                                $data['regrd']['increase']= 0;
                            }else {
                                $data['regrd']['increase']= 100;
                            }
                        }
                        $data['is_found'] = 1;
                        $data['pesan'] = "Data ditemukan!";
                    }
                }
                //------------------- end of total register RD/pasien per hari -----------------------------

                //------------------- total register RI/pasien per hari -----------------------------
                $pegawai_id = $_GET['pegawai_id'];
                $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t
                        WHERE pegawai_id=".$_GET['pegawai_id'].
                        " AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND instalasi_id='".Params::INSTALASI_ID_RI."' AND statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' ";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                    $data['regri']['totCurrDate']=$loadData['totcurrdate'];
                    $sql = "SELECT COUNT(*) as totYestDate FROM pendaftaran_t
                            WHERE pegawai_id=".$_GET['pegawai_id'].
                            " AND tgl_pendaftaran::timestamp::date = (SELECT DATE 'yesterday') AND instalasi_id= '".Params::INSTALASI_ID_RI."' AND statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."' ";
                    $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData2)) {
                        $data['regri']['totYestDate']=$loadData2['totyestdate'];
                        if ($data['regri']['totYestDate']!=0) {
                            $data['regri']['increase']= (($data['regri']['totCurrDate'] - $data['regri']['totYestDate']) / $data['regri']['totYestDate'])*100;
                        }else {
                            if ($data['regri']['totCurrDate']==0) {
                                $data['regri']['increase']= 0;
                            }else {
                                $data['regri']['increase']= 100;
                            }
                        }
                        $data['is_found'] = 1;
                        $data['pesan'] = "Data ditemukan!";
                    }
                }
                //------------------- end of total register RI/pasien per hari -----------------------------

                //------------------- dashboard get register per tahun      -----------------------------
                $currDay = date('d');
                $currMonth = date('m');
                $currYear = date('Y');
                $arrMonth = array();
                if ($currMonth<=6) {
                    for ($i=1;$i<=6;$i++) {
                        $arrMonth[$i] = $i;
                    }
                }else {
                    for ($i=7;$i<=12;$i++) {
                        $arrMonth[$i] = $i;
                    }
                }
                $currYearMonth = $currYear."-".$currMonth."-";
                $i = 0;
                foreach ($arrMonth as $datum) {
                    $currDate = $currYearMonth.$datum;
                    $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t "
                        . "WHERE pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                        . "AND EXTRACT(MONTH FROM tgl_pendaftaran)=".$datum;
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    if(!empty($loadData)) {
                        $data['regtahun'][$i]['bulan']=$datum;
                        $data['regtahun'][$i]['count']=$loadData['totcurrdate'];
                    }
                    $i++;
                }
                //------------------- end of dashboard get register per tahun  -----------------------------

                //-------------------- dashboard jenis kelamin per tahun
                $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                    . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                    . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_LAKI_LAKI."'";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                    $data['jeniskelamin']['tahun']['laki']=$loadData['totcurrltahun'];
                    $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                        . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                        . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_PEREMPUAN."'";
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData)) {
                        $data['jeniskelamin']['tahun']['perempuan']=$loadData['totcurrltahun'];
                    }
                }
                // ------------------ end of dashboard jenis kelamin per tahun

                //------------------- dashboard get register per bulan      -----------------------------
                $currDay = date('d');
                //$currMonth = date('m');
                //$currYear = date('Y');
                $arrDay = array();
                if ($currDay<=6) {
                    for ($i=1;$i<=6;$i++) {
                        $arrDay[$i] = $i;
                    }
                }else {
                    for ($i=($currDay-5);$i<=$currDay;$i++) {
                        $arrDay[$i] = $i;
                    }
                }
                $i = 0;
                foreach ($arrDay as $datum) {
                    $sql = "SELECT COUNT(*) as totcurrdate FROM pendaftaran_t "
                        . "WHERE pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                        . "AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(DAY FROM tgl_pendaftaran)=".$datum;
                    $sqlJasdokBulan = "SELECT SUM(tk.tarif_tindakankomp) AS tottarifkomponen 
                        FROM tindakanpelayanan_t tp
                        LEFT JOIN tindakankomponen_t tk on tp.tindakanpelayanan_id = tk.tindakanpelayanan_id
                        LEFT JOIN daftartindakan_m dt on tp.daftartindakan_id = dt.daftartindakan_id
                        LEFT JOIN pendaftaran_t pn on tp.pendaftaran_id = pn.pendaftaran_id
                        LEFT JOIN tindakansudahbayar_t tsb on tp.tindakansudahbayar_id = tsb.tindakansudahbayar_id
                        LEFT JOIN komponentarif_m kt on tk.komponentarif_id = kt.komponentarif_id "
                        . "WHERE tp.dokterpemeriksa1_id=$pegawai_id AND tk.komponentarif_id in (5, 10, 11, 12, 21, 31, 32, 51, 52, 53, 59, 65, 67, 68, 70, 73, 76, 77, 79, 80, 81, 86) "
                        . "AND EXTRACT(YEAR FROM tp.tgl_tindakan)=EXTRACT(YEAR FROM NOW()) "
                        . "AND EXTRACT(MONTH FROM tp.tgl_tindakan)=EXTRACT(MONTH FROM NOW()) AND EXTRACT(DAY FROM tp.tgl_tindakan) = ".$datum;

                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    $loadDataJasDokBulan = Yii::app()->db->createCommand($sqlJasdokBulan)->queryRow();
                    if (!empty($loadData)) {
                        $data['regbulan'][$i]['tgl']='Tgl. '.$datum;
                        $data['regbulan'][$i]['count']=$loadData['totcurrdate'];
                    }
                    if (!empty($loadDataJasDokBulan)) {
                        $data['jasdokbulan'][$i]['tgl']='Tgl. '.$datum;
                        $data['jasdokbulan'][$i]['sum']=($loadDataJasDokBulan['tottarifkomponen']==null?0:$loadDataJasDokBulan['tottarifkomponen']);
                    }
                    $i++;
                }
                //------------------- get register per bulan  -----------------------------

                //-------------------- dashboard jenis kelamin per bulan
                $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                    . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW())"
                    . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_LAKI_LAKI."'";
                $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                if (!empty($loadData)) {
                    $data['jeniskelamin']['bulan']['laki']=$loadData['totcurrltahun'];
                    $sql = "SELECT COUNT(*) as totCurrLTahun FROM pendaftaran_t JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id "
                        . "WHERE pendaftaran_t.pegawai_id=$pegawai_id AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM tgl_pendaftaran)=EXTRACT(MONTH FROM NOW())"
                        . "AND pasien_m.jeniskelamin='".Params::JENIS_KELAMIN_PEREMPUAN."'";
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData)) {
                        $data['jeniskelamin']['bulan']['perempuan']=$loadData['totcurrltahun'];
                    }
                }
                // ------------------ end of dashboard jenis kelamin per tahun

                //------------------- beginning total jasa dokter hari ini-------------------------------
                $totalJasDokHari = 0;
                $data['jasdok']['hari'] = $totalJasDokHari;
                $sql = "SELECT SUM(tk.tarif_tindakankomp) AS totcurrjasdokharidate 
                        FROM tindakanpelayanan_t tp
                        LEFT JOIN tindakankomponen_t tk on tp.tindakanpelayanan_id = tk.tindakanpelayanan_id
                        LEFT JOIN daftartindakan_m dt on tp.daftartindakan_id = dt.daftartindakan_id
                        LEFT JOIN pendaftaran_t pn on tp.pendaftaran_id = pn.pendaftaran_id
                        LEFT JOIN tindakansudahbayar_t tsb on tp.tindakansudahbayar_id = tsb.tindakansudahbayar_id
                        LEFT JOIN komponentarif_m kt on tk.komponentarif_id = kt.komponentarif_id
                        WHERE tp.dokterpemeriksa1_id = $pegawai_id AND tp.tgl_tindakan::date = now()::date AND 
                        tk.komponentarif_id in (5, 10, 11, 12, 21, 31, 32, 51, 52, 53, 59, 65, 67, 68, 70, 73, 76, 77, 79, 80, 81, 86) ";
                if ($loadData = Yii::app()->db->createCommand($sql)->queryRow()) {
                    $sql = "SELECT SUM(tk.tarif_tindakankomp) AS totyestjasdokharidate
                            FROM tindakanpelayanan_t tp
                            LEFT JOIN tindakankomponen_t tk on tp.tindakanpelayanan_id = tk.tindakanpelayanan_id
                            LEFT JOIN daftartindakan_m dt on tp.daftartindakan_id = dt.daftartindakan_id
                            LEFT JOIN pendaftaran_t pn on tp.pendaftaran_id = pn.pendaftaran_id
                            LEFT JOIN tindakansudahbayar_t tsb on tp.tindakansudahbayar_id = tsb.tindakansudahbayar_id
                            LEFT JOIN komponentarif_m kt on tk.komponentarif_id = kt.komponentarif_id
                            WHERE tp.dokterpemeriksa1_id = $pegawai_id AND tp.tgl_tindakan::date = (SELECT DATE 'yesterday') AND 
                            tk.komponentarif_id in (5, 10, 11, 12, 21, 31, 32, 51, 52, 53, 59, 65, 67, 68, 70, 73, 76, 77, 79, 80, 81, 86) ";
                    if ($loadData['totcurrjasdokharidate']==null) {
                        $currJasDok = 0;
                    }else {
                        $currJasDok = $loadData['totcurrjasdokharidate'];
                    }
                    $loadData2 = Yii::app()->db->createCommand($sql)->queryRow();
                    $yestJasDok = ($loadData2['totyestjasdokharidate']==null?0:$loadData2['totyestjasdokharidate']);
                    $data['jasdok']['kemarin']=$yestJasDok;
                    if ($yestJasDok!=0) {
                        $data['jasdok']['increase'] = (($currJasDok - $yestJasDok) / $yestJasDok)*100;
                    }else  {
                        if ($currJasDok==0) {
                            $data['jasdok']['increase']= 0;
                        }else {
                            $data['jasdok']['increase']= 100;
                        }
                    }
                    $data['jasdok']['hari']= $currJasDok;
                }
                //------------------ end of total jasa dokter hari ini ----------------------------------
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackRegistrasi(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan list Fisik yang telah dilakukan kepada pasien
	 * @param pasien_id, pegawai_id
	 * @return array history fisik pasien
	 */
	public function actionJumlahPasienRuanganRJ() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['ruangandokterrj'] = array();
            if (isset($_GET['pegawai_id'])) {
                //------------------- total register RJ/pasien per hari berdasarkan ruangan -----------------------------
                $sql = " SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, count(pasien_id) as jumlah_pasien FROM pendaftaran_t
                        JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                        WHERE pegawai_id=".$_GET['pegawai_id']." AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND pendaftaran_t.instalasi_id='".Params::INSTALASI_ID_RJ."' AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."'
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['ruangandokterrj']=$loadData;
                if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
                //------------------- end of total register RJ/pasien per hari berdasarkan ruangan -----------------------------
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackJumlahPasienRuanganRJ(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan list Fisik yang telah dilakukan kepada pasien
	 * @param pasien_id, pegawai_id
	 * @return array history fisik pasien
	 */
	public function actionJumlahPasienRuanganRD() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['ruangandokterrd'] = array();
            if (isset($_GET['pegawai_id'])) {                
                //------------------- total register RD/pasien per hari berdasarkan ruangan -----------------------------
                $sql = " SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, count(pasien_id) as jumlah_pasien FROM pendaftaran_t
                        JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                        WHERE pegawai_id=".$_GET['pegawai_id']." AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND pendaftaran_t.instalasi_id='".Params::INSTALASI_ID_RD."' AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."'
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['ruangandokterrd']=$loadData;
                if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
                //------------------- end of total register RD/pasien per hari berdasarkan ruangan -----------------------------
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackJumlahPasienRuanganRD(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan list Fisik yang telah dilakukan kepada pasien
	 * @param pasien_id, pegawai_id
	 * @return array history fisik pasien
	 */
	public function actionJumlahPasienRuanganRI() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['ruangandokterri'] = array();
            if (isset($_GET['pegawai_id'])) {                
                //------------------- total register RI/pasien per hari berdasarkan ruangan -----------------------------
                $sql = " SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, count(pasien_id) as jumlah_pasien FROM pendaftaran_t
                        JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                        WHERE pegawai_id=".$_GET['pegawai_id']." AND tgl_pendaftaran::timestamp::date = NOW()::timestamp::date AND pendaftaran_t.instalasi_id='".Params::INSTALASI_ID_RI."' AND pendaftaran_t.statusperiksa != '".PARAMS::STATUSPERIKSA_BATAL_PERIKSA."'
                        GROUP BY ruangan_m.ruangan_id, ruangan_m.ruangan_nama ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['ruangandokterri']=$loadData;
                if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
                //------------------- end of total register RI/pasien per hari berdasarkan ruangan -----------------------------
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackJumlahPasienRuanganRI(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan Status Str
	 * @param pasien_id, pegawai_id
	 * @return array history Status Str
	 */
	public function actionStatusStr() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $tanggal = date('Y-m-d', strtotime('+6 months'));
            if (isset($_GET['pegawai_id'])) {
                $pegawai_id = $_GET['pegawai_id'];
                $sql = " SELECT * FROM pegawai_m
                        WHERE pegawai_id=".$_GET['pegawai_id']." ";
                $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
                if(!empty($loadDatas)){
                    foreach($loadDatas AS $i => $val){
                        if($val['tanggal_str'] < $tanggal){
                            $data['is_found'] = 2;
                            $data['pesan'] = "Masa berlaku STR akan segera habis";
                            $data['pesanerror'] ="Masa berlaku STR akan segera habis";
                        }else{
                            $data['pesan'] = "Silakan Daftar!";
                            $data['is_found'] = 1;
                        }
                    }
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackStatusStr(".$encode.")";
            Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan Status SIP
	 * @param pasien_id, pegawai_id
	 * @return array history Status SIP
	 */
	public function actionStatusSip() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $tanggal = date('Y-m-d', strtotime('+6 months'));
            if (isset($_GET['pegawai_id'])) {
                $pegawai_id = $_GET['pegawai_id'];
                $sql = " SELECT * FROM pegawai_m
                        WHERE pegawai_id=".$_GET['pegawai_id']." ";
                $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
                if(!empty($loadDatas)){
                    foreach($loadDatas AS $i => $val){
                        if($val['tanggal_sip'] < $tanggal){
                            $data['is_found'] = 2;
                            $data['pesan'] = "Masa berlaku SIP akan segera habis";
                            $data['pesanerror'] ="Masa berlaku SIP akan segera habis";
                        }else{
                            $data['pesan'] = "Silakan Daftar!";
                            $data['is_found'] = 1;
                        }
                    }
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackStatusSip(".$encode.")";
            Yii::app()->end();
	}


	/**
	 * action dashboard untuk mendapatkan jumlah register  per tahun
	 *
	 * @param pegawai_id
	 * @return array data register per tahun
	 */
	public function actionGetRegistrasiTahun() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            if (isset($_GET['pegawai_id'])) {
                $pegawai_id = $_GET['pegawai_id'];
                $currDay = date('d');
                $currMonth = date('m');
                $currYear = date('Y');
                $arrMonth = array();
                if ($currMonth<=6) {
                    for ($i=1;$i<=6;$i++) {
                        $arrMonth[$i] = $i;
                    }
                }else {
                    for ($i=7;$i<=12;$i++) {
                        $arrMonth[$i] = $i;
                    }
                }
                $currYearMonth = $currYear."-".$currMonth."-";
                $i = 0;
                foreach ($arrMonth as $datum) {
                    $currDate = $currYearMonth.$datum;
                    $sql = "SELECT COUNT(*) as totCurrDate FROM pendaftaran_t "
                        . "WHERE pegawai_id=19 AND EXTRACT(YEAR FROM tgl_pendaftaran)=EXTRACT(YEAR FROM NOW()) "
                        . "AND EXTRACT(MONTH FROM tgl_pendaftaran)=".$datum;
                    $loadData = Yii::app()->db->createCommand($sql)->queryRow();
                    if (!empty($loadData)) {
                        $data['data'][$i]['bulan']=$datum;
                        $data['data'][$i]['count']=$loadData['totcurrdate'];
                    }
                    $i++;
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	public function actionBatalPemeriksaan() {
		header("content-type:application/json");
		$data['is_sukses'] = 0;

		if (isset($_GET['pendaftaran_id'])&&isset($_GET['pasien_id'])&&isset($_GET['ruangan_id'])) {
			$pendaftaranID = $_GET['pendaftaran_id'];
			$pasienID = $_GET['pasien_id'];
			$ruanganID = $_GET['ruangan_id'];

			$model = new MOPasienbatalperiksaR();
			$model->pendaftaran_id = $pendaftaranID;
			$model->pasien_id = $pasienID;
			$model->tglbatal = date('Y-m-d');
			$model->create_time = date('Y-m-d');
			$model->create_loginpemakai_id =  Params::LOGINPEMAKAI_ID_ADMIN;
			$model->keterangan_batal = "Batal Rawat Jalan";
			$model->create_ruangan = $ruanganID;

			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($model->save()) {
						//print_r($model);exit;
					$attributes = array(
						'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
						'update_time' => date('Y-m-d H:i:s'),
						'update_loginpemakai_id' => Params::LOGINPEMAKAI_ID_ADMIN,
						'statusperiksa'=>Params::STATUSPERIKSA_BATAL_PERIKSA
					);
					$pendaftaran = MOPendaftaranT::model()->updateByPk($pendaftaranID, $attributes);
					$transaction->commit();
					$data['is_sukses'] = 1;
					$data['pesan'] = "Data berhasil dibatalkan!";
				}else{
					$pesan = "Pemeriksaan gagal dibatalkan! ".CHtml::errorSummary($model);
					 $data['pesan'] = $pesan;
					$transaction->rollback();
				}
			} catch (Exception $ex) {
				$status = false;
				$pesan = "exist";
				$transaction->rollback();
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
	/**
	 * action untuk tindak lanjut ke rawat inap
	 *
	 * @param pendaftaran_id
	 * @param pasien_id
	 * @param ruangan_id
	 * @param loginpemakai_id
	 *
	 * @return 1/0 pesan sukses
	 */
	public function actionTindakLanjutRI()
	{
		header("content-type:application/json");
        
		$retVal =array();
		$format = new MyFormatter();

        // Inputan
		$ruanganasal_id = isset($_GET['ruangan_id'])?$_GET['ruangan_id']:null; //ruanganasal_id
        $pendaftaran_id = isset($_GET['pendaftaran_id'])?$_GET['pendaftaran_id']:null;
        $loginpemakai_id = isset($_GET['loginpemakai_id'])?$_GET['loginpemakai_id']:null;
        $carabayar_id = isset($_GET['pasienadmisi']['carabayar_id'])?$_GET['pasienadmisi']['carabayar_id']:null;
        $penjamin_id = isset($_GET['pasienadmisi']['penjamin_id'])?$_GET['pasienadmisi']['penjamin_id']:null;
        $pasien_id = isset($_GET['pasienadmisi']['pasien_id'])?$_GET['pasienadmisi']['pasien_id']:null;
        $ruangan_id = isset($_GET['pasienadmisi']['ruangan_id'])?$_GET['pasienadmisi']['ruangan_id']:null;
        $kelaspelayanan_id = isset($_GET['ruangan_id'])?$_GET['pasienadmisi']['kelaspelayanan_id']:null;
        $dokter_id = isset($_GETT['pasienadmisi']['dokter_id'])?$_GET['pasienadmisi']['dokter_id']:null;
		$jeniskasuspenyakit_id = isset($_GET['pasienadmisi']['jeniskasuspenyakit_id'])?$_GET['pasienadmisi']['jeniskasuspenyakit_id']:null;
        $tglpasienpulang = date('Y-m-d H:i:s');

		$modPendaftaran = MOPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$instalasi_id = $modPendaftaran->instalasi_id;
        $pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        if(empty($pasienadmisi_id)){
    		$modPasien = MOPasienM::model()->findByPk($modPendaftaran->pasien_id);
    		$modRujukan=new MORujukanT;
            $modRujukanBpjs = new RujukanT;
            $modPasienAdmisi = new PasienadmisiT;
            $modAsuransiPasien = new AsuransipasienM;
            $modAsuransiPasienBpjs = new AsuransipasienM;
            $modSep = new SepT;
    		$status =0;

    		if ($instalasi_id == Params::INSTALASI_ID_RD){
    			$modPasienPulang = new PasienpulangT;
    			$modPasienPulang->tglpasienpulang = date('d M Y H:i:s');
    			$modPasienPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    			$modPasienPulang->pasien_id = $modPasien->pasien_id;

    			$date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
    			$date2 = date('Y-m-d H:i:s');
    			$diff = abs(strtotime($date2) - strtotime($date1));
    			$hours   = floor(($diff)/3600);

    			$modPasienPulang->lamarawat = $hours;
    		}else{
    			$modPasienPulang = array();
    		}

    		if (isset($_GET['pendaftaran_id'])){
    			$transaction = Yii::app()->db->beginTransaction();
    			try {
    				if ($instalasi_id == Params::INSTALASI_ID_RD) { // Proses khusus dari rawat darurat
                        $modPasienPulang = new PasienPulangT;
                        $modPasienPulang->pasienadmisi_id = ($instalasi_id == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;
                        $modPasienPulang->carapulang_id = 2; //Dirujuk
                        $modPasienPulang->kondisikeluar_id = 6; //Belum sembuh
                        $modPasienPulang->ruanganakhir_id = $ruangan_id;
                        $modPasienPulang->satuanlamarawat = ($instalasi_id == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
                        $modPasienPulang->ruanganakhir_id =  $ruangan_id;
                        $modPasienPulang->create_time = date('Y-m-d H:i:s');
                        $modPasienPulang->create_ruangan = $ruanganasal_id;
                        $modPasienPulang->create_loginpemakai_id = $loginpemakai_id;                    

                        if ($modPasienPulang->save()) {
                            $this->pasienpulangtersimpan = true;
                        }
                        $this->rujukrisukses = true;
                    } else {
                        $this->pasienpulangtersimpan = true;
                        $modRujuk = $this->pulangRujukRI($modPendaftaran,$ruangan_id,$ruanganasal_id,$loginpemakai_id);
                    }
    				
    				if ($this->rujukrisukses == true){
    					if($pasien_id){
    						$modPasien = $this->simpanPasien($modPasien,$modPendaftaran,$loginpemakai_id);
    					}else{
    						$this->pasientersimpan = true;
    					}
                        
    					// if(!empty($modPendaftaran->is_bpjs)){
    					// 	if(isset($_POST['RJRujukanbpjsT'])){
    					// 		$modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['RJRujukanbpjsT']);
    					// 	} else {
    					// 		$this->rujukantersimpan = true;
    					// 	}
    					// }else{
    					// 	$this->rujukantersimpan = true;
    					// }
                        $this->rujukantersimpan = true;
                       
    					// if(isset($_POST['RJAsuransipasienM'])){
    					// 	if(isset($_POST['RJAsuransipasienM']['asuransipasien_id'])){
    					// 		if(!empty($_POST['RJAsuransipasienM']['asuransipasien_id'])){
    					// 			$modAsuransiPasien = RJAsuransipasienM::model()->findByPk($_POST['RJAsuransipasienM']['asuransipasien_id']);
    					// 		}
    					// 	}
    					// 	$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['RJPendaftaranT'], $modPasien, $_POST['RJAsuransipasienM']);
    					// }else{
    					// 	$this->asuransipasientersimpan = true;
    					// }
                        if(!empty($modPendaftaran->asuransipasien_id)){
                            $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                        }
                        $this->asuransipasientersimpan = true;
                        $pegawai_id = $_GET['pasienadmisi']['dokter_id'];
    					$modPasienAdmisi = $this->simpanPasienAdmisi($modPendaftaran,$modPasien,$modPasienAdmisi, $modPasienPulang, $ruanganasal_id, $loginpemakai_id, $ruangan_id, $carabayar_id, $kelaspelayanan_id, $penjamin_id, $pegawai_id);

    					$this->simpanMasukKamar($modPendaftaran, $modPasien, $modPasienAdmisi, $loginpemakai_id, $ruanganasal_id);

                        // echo "<pre>";print_r("hasil".$this->rujukrisukses."<br>".$this->pasientersimpan.'<br>'.$this->pasienpulangtersimpan."<br>".$this->rujukantersimpan."<br>".$this->admisitersimpan."<br>".$this->masukkamartersimpan);exit;
                        
    					if($this->pasienpulangtersimpan &&
    						 $this->pasientersimpan && $this->rujukantersimpan && $this->admisitersimpan && $this->masukkamartersimpan){
    						$transaction->commit();
    						$retVal['is_sukses'] = true;
    					}else{
    						$transaction->rollback();
    						$retVal['is_sukses'] = false;
    					}
    				} else {
    					$transaction->rollback();
    					$retVal['is_sukses'] = false;
    				}

    			} catch (Exception $ex) {
    				$transaction->rollback();
    				 Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($ex));
    			}
    		}
        }else{
            $retVal['is_sukses'] = false;
        }
		$encode = CJSON::encode($retVal);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

    public function pulangRujukRI($modPendaftaran,$ruangan_id,$ruanganasal_id,$loginpemakai_id) {
        $modPasienPulang = new PasienpulangT;
        $modPasienPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPasienPulang->pasien_id = $modPendaftaran->pasien_id;
        $modPasienPulang->tglpasienpulang = date('Y-m-d H:i:s');
        $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
        $modPasienPulang->kondisikeluar_id = Params::KONDISIKELUAR_ID_RAWATINAP;
        $modPasienPulang->ruanganakhir_id = $ruangan_id;
        $modPasienPulang->lamarawat = 0;
        $modPasienPulang->satuanlamarawat = 'lamarawat';
        $modPasienPulang->create_time = date('Y-m-d H:i:s');
        $modPasienPulang->create_ruangan = $ruanganasal_id;
        $modPasienPulang->create_loginpemakai_id = $loginpemakai_id; 
        if ($modPasienPulang->save()) {
            PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pasienpulang_id' => $modPasienPulang->pasienpulang_id, 'statusperiksa' => Params::STATUSPERIKSA_SEDANG_DIRAWATINAP, 'alihstatus' => TRUE));
            $this->rujukrisukses = true;
        }

        return $modPasienPulang;
    }

    /**
     * simpan PPPasienAdmisiT
     * @param modPasienAdmisi $modPasienAdmisi
     * @param type $model
     * @param type $modPasien
     * @return \modPasienAdmisi
     */
    protected function simpanPasienAdmisi($model, $modPasien, $modPasienAdmisi,$modPasienPulang, $ruanganasal_id, $loginpemakai_id,$ruangan_id,$carabayar_id,$kelaspelayanan_id,$penjamin_id,$pegawai_id) {
        $format = new MyFormatter();
        $modPasienAdmisi = new $modPasienAdmisi;
        if ($model->instalasi_id == Params::INSTALASI_ID_RJ) {
            $caramasuk_id = Params::CARAMASUK_ID_RJ;
        } else if ($model->instalasi_id == Params::INSTALASI_ID_RD) {
            $caramasuk_id = Params::CARAMASUK_ID_RD;
        } else {
            $caramasuk_id = Params::CARAMASUK_ID_LANGSUNG_RI;
        }
        $modPasienAdmisi->carabayar_id = $carabayar_id;
        $modPasienAdmisi->kelaspelayanan_id = $kelaspelayanan_id;
        $modPasienAdmisi->penjamin_id = $penjamin_id;
        $modPasienAdmisi->ruangan_id = $ruangan_id;
        $modPasienAdmisi->caramasuk_id = $caramasuk_id;
        $modPasienAdmisi->pendaftaran_id = $model->pendaftaran_id;
        $modPasienAdmisi->tglpendaftaran = $model->tgl_pendaftaran;
        $modPasienAdmisi->pegawai_id = $pegawai_id;
        $modPasienAdmisi->tgladmisi = date('Y-m-d H:i:s');
        $modPasienAdmisi->pasien_id = $model->pasien_id;
        $modPasienAdmisi->shift_id = 2; //sementara pakai shift siang
        $modPasienAdmisi->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienAdmisi->ruangan_id);
        $modPasienAdmisi->create_ruangan = $ruanganasal_id;
        $modPasienAdmisi->tglpulang = null;
        $modPasienAdmisi->rencanapulang = null;
        $modPasienAdmisi->create_time = date("Y-m-d H:i:s");
        $modPasienAdmisi->create_loginpemakai_id = $loginpemakai_id;
        
        if ($modPasienAdmisi->save()) {
            if (PendaftaranT::model()->updateByPk($modPasienAdmisi->pendaftaran_id, array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id, 'alihstatus'=>true,'statusperiksa' => Params::STATUSPERIKSA_SEDANG_DIRAWATINAP))) {
                $this->admisitersimpan = true;
            } else {
                $this->admisitersimpan = false;
            }
        } else {
            $this->admisitersimpan = false;
        }
        return $modPasienAdmisi;
    }

    protected function simpanPasien($modPasien, $modPendaftaran, $loginpemakai_id) {
        $format = new MyFormatter();

        if (!empty($modPasien->pasien_id)) {
            $load = new $modPasien;
            $modPasien = $load->findByPk($modPasien->pasien_id);
        }
        // $modPasien->attributes = $modPendaftaran;
        $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
        $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
        if (empty($modPasien->pasien_id)) {
            $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
            $modPasien->profilrs_id = Params::getDefaultProfilRS();
            $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
            $modPasien->ispasienluar = FALSE;
            $modPasien->create_ruangan = $modPendaftaran->ruangan_id;
            $modPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modPasien->create_time = date('Y-m-d H:i:s');
            $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
        } else {
            $modPasien->update_loginpemakai_id = $loginpemakai_id;
            $modPasien->update_time = date('Y-m-d H:i:s');
        }

        $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
        $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

        if ($modPasien->save()) {
            $this->pasientersimpan = true;
        }

        return $modPasien;
    }

    protected function simpanMasukKamar($model, $modPasien, $modPasienAdmisi, $loginpemakai_id, $ruanganasal_id) {
                
        $modMasukKamar = new MasukkamarT;
        $modMasukKamar->carabayar_id = $model->carabayar_id;
        $modMasukKamar->kamarruangan_id = (!empty($modPasienAdmisi->kamarruangan_id)) ? $modPasienAdmisi->kamarruangan_id : null;
        $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
        $modMasukKamar->ruangan_id = $modPasienAdmisi->ruangan_id;
        $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
        $modMasukKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
        $modMasukKamar->penjamin_id = $model->penjamin_id;
        $modMasukKamar->shift_id = 2; //sementara shift siang
        $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
        $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
        $modMasukKamar->jammasukkamar = date('H:i:s');
        $modMasukKamar->tglkeluarkamar = null;
        $modMasukKamar->jamkeluarkamar = null;
        $modMasukKamar->lamadirawat_kamar = null;
        $modMasukKamar->create_time = date("Y-m-d H:i:s");
        $modMasukKamar->create_loginpemakai_id = $loginpemakai_id;
        $modMasukKamar->create_ruangan = $ruanganasal_id;
        
        if ($modMasukKamar->save()) {
            if (!empty($modMasukKamar->kamarruangan_id)) {
                KamarruanganM::model()->updateByPk($modMasukKamar->kamarruangan_id, array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN));
            }
            $this->masukkamartersimpan = true;
        } else {
            $this->masukkamartersimpan = false;
        }
    }

	/**
	 * action untuk rencana kontrol
	 *
	 * @param pendaftaran_id
	 * @param tglrencanakontrol
	 *
	 * @return 1/0 pesan sukses
	 */
	public function actionRencanaKontrol(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		if(isset($_GET['pendaftaran_id']) && isset($_GET['tglrencanakontrol'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$format = new MyFormatter;
				$updatePendaftaran = MOPendaftaranT::model()->updateByPk($_GET['pendaftaran_id'],array('tglrenkontrol'=>$format->formatDateTimeForDb($_GET['tglrencanakontrol']),'update_time'=>date("Y-m-d H:i:s")));
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
	 * action untuk mendapatkan pasien lama
	 *
	 * @param medical record dari pasien, eg 635968
	 * @return array dari data pasien
	 */
	public function actionGetPasienByRekamMedik() {
            header("content-type:application/json");
            $format = new MyFormatter();
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data not found!";
            $data['data'] = array();
            if (isset($_GET['no_rekam_medik'])) {
                $medRec = strtolower($_GET['no_rekam_medik']);
                $sql = "SELECT * from pasien_m WHERE no_rekam_medik = '".$medRec."' OR nama_pasien ilike '%".$medRec."%' limit 5 ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                $n = count($loadData);
                if ($n>0) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}
        /**
	 * action untuk mendapatkan pasien lama
	 *
	 * @param medical record dari pasien, eg 635968
	 * @return array dari data pasien
	 */
	public function actionGetPasienByRekamM() {
	header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
        $tglPendaftaran = '';
        if (isset($_GET['pegawai_id'])) {
            $pegawai_id = isset($_GET['pegawai_id'])?$_GET['pegawai_id']:'';
            if ($tglPendaftaran=='') {
                $tglPendaftaran = date('Y-m-d');
            }
            $sql = "SELECT pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.pasien_id, pendaftaran_t.instalasi_id, pendaftaran_t.ruangan_id, pendaftaran_t.pegawai_id,
                    pasien_m.nama_pasien, pasien_m.namadepan, pasien_m.no_rekam_medik, pasien_m.no_mobile_pasien, pasien_m.jeniskelamin,
                    instalasi_m.instalasi_nama,ruangan_m.ruangan_nama
                    FROM pendaftaran_t 
                    JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                    JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = pendaftaran_t.ruangan_id
                    WHERE pendaftaran_t.pegawai_id =".$pegawai_id."
                    ORDER BY tgl_pendaftaran DESC LIMIT 8";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
	}
        
        /**
	 * action untuk mendapatkan antrian pasien
	 *
	 * @param medical record dari pasien, eg 635968
	 * @return array dari data pendaftaran
	 */
	public function actionGetRiwayatAntrian() {
            header("content-type:application/json");
            $format = new MyFormatter();
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data not found!";
            $data['data'] = array();
            $tglPendaftaran = '';
            if (isset($_GET['pegawai_id'])&&isset($_GET['start_date'])&&isset($_GET['end_date'])) {
                $pegawai_id = isset($_GET['pegawai_id'])?$_GET['pegawai_id']:'';
                $startDate = $_GET['start_date'];
                $endDate = $_GET['end_date'];
                if ($startDate!='' && $endDate!='') {
                    $strBetween = " AND tgl_pendaftaran::timestamp::date BETWEEN '".MyFormatter::formatDateTimeForDb($startDate)."' AND '".MyFormatter::formatDateTimeForDb($endDate)."'";
                }else {
                    $strBetween = "AND tgl_pendaftaran::timestamp::date='".date('Y-m-d')."'";
                }
                if ($tglPendaftaran=='') {
                    $tglPendaftaran = date('Y-m-d');
                }
                $sql = "SELECT pendaftaran_t.pendaftaran_id, pendaftaran_t.pegawai_id, pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.pasien_id, pasien_m.nama_pasien,
                        antrian_t.antrian_id, antrian_t.noantrian,
                        ruangan_m.ruangan_id, ruangan_m.ruangan_nama, 
                        instalasi_m.instalasi_id,instalasi_m.instalasi_nama,
                        carabayar_m.carabayar_id, carabayar_m.carabayar_nama, carabayar_m.metode_pembayaran
                        FROM pendaftaran_t
                        JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                        JOIN antrian_t ON pendaftaran_t.antrian_id = antrian_t.antrian_id
                        JOIN instalasi_m ON pendaftaran_t.instalasi_id = instalasi_m.instalasi_id
                        JOIN ruangan_m ON ruangan_m.ruangan_id = antrian_t.ruangan_id
                        JOIN carabayar_m ON carabayar_m.carabayar_id = antrian_t.carabayar_id
                        WHERE pendaftaran_t.pegawai_id=".$pegawai_id."
                        ORDER BY pendaftaran_t.tgl_pendaftaran DESC LIMIT 8";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                $data['data'] = $loadData;
                $n = count($loadData);
                if ($n>0) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!";
                }
            }
            $encode = CJSON::encode($data);
            if(isset($_GET['antrian'])){
                echo "jsonCallbackAntrianAn(".$encode.")";
            }else{
                echo "jsonCallbackAntrian(".$encode.")";
            }
            Yii::app()->end();
	}
	/**
	 * action panggil pasien
	 *
	 * @param instalasi_id
	 * @param pendaftaran_id
	 *
	 * @return 1/0 sukses
	 */
	public function actionPanggilPasien(){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';

		if(isset($_GET['pendaftaran_id'])){
//			$sql = "UPDATE pendaftaran_t SET panggilantrian=TRUE, update_time='".date("Y-m-d H:i:s")."', "
//					. "update_loginpemakai_id=".Params::LOGINPEMAKAI_ID_ADMIN." WHERE pendaftaran_id=".$_GET['pendaftaran_id'];
//			if (Yii::app()->db->createCommand($sql)->queryRow()) {
//				$data['sukses'] = 1;
//				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
//			}else {
//				$data['sukses'] = 0;
//				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!';
//			}
            
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modPendaftaran =  MOPendaftaranT::model()->findByPk($_GET['pendaftaran_id']); 
                        
				$modPendaftaran->panggilantrian = TRUE;
				$modPendaftaran->update_time = date("Y-m-d H:i:s");
				// $modPendaftaran->update_loginpemakai_id = Params::LOGINPEMAKAI_ID_ADMIN;
				if ($modPendaftaran->save()) {
                    $transaction->commit();
                     $data['daata'] = $modPendaftaran;     
					$data['sukses'] = 1;
					$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
				}else {
					$data['sukses'] = 0;
					$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!';
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	public function actionPanggilPasienPoliklinik($pendaftaran_id){
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$transaction = Yii::app()->db->beginTransaction();
		try{

			if (MOPendaftaranT::model()->updateByPk($pendaftaran_id,array('panggilantrian'=>TRUE,'update_time'=>date("Y-m-d H:i:s"),'update_loginpemakai_id'=>Params::LOGINPEMAKAI_ID_ADMIN))) {
				$transaction->commit();
				$data['sukses'] = 1;
				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
			}



//			if ($updatePendaftaran->save()){
//				$transaction->commit();
//
//			}
//			$updatePendaftaran->panggilantrian = TRUE;
//			$updatePendaftaran->update_time = date("Y-m-d H:i:s");
//			if($updatePendaftaran->save()){
//				$transaction->commit();
//				$data['sukses'] = 1;
//				$data['pesan'] = 'Pemanggilan pasien berhasil dilakukan!';
//				$data_telnet = $updatePendaftaran->ruangan->ruangan_nama.", ".$updatePendaftaran->ruangan->ruangan_singkatan."-".$updatePendaftaran->no_urutantri;
//				self::postTelnet($data_telnet);
//			}else{
//				$transaction->rollback();
//				$data['sukses'] = 0;
//				$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!<br>'.CHtml::errorSummary($updatePendaftaran);
//			}
		}catch (Exception $exc) {
			$transaction->rollback();
			$data['sukses'] = 0;
			$data['pesan'] = 'Pemanggilan pasien gagal dilakukan!'.MyExceptionMessage::getMessage($exc,true);
		}
		return $data;
	}

	/**
	 * kirim data ke telnet (untuk dimasukkan ke led matrix)
	 * MIC-91
	 */
	public static function postTelnet($data){
		if(Yii::app()->user->getState('is_telnetaktif')){
			$address = Yii::app()->user->getState('telnet_host');
			$port = Yii::app()->user->getState('telnet_port');
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) OR FALSE;
			socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 3, 'usec' => 0));
			if($socket){
				if(socket_connect($socket, $address, $port)){
					socket_write($socket, $data);
					socket_close();
				}
			}
		}
	}

	/**
	 * action untuk menghapus pemakaian bahan
	 *
	 * @param obatalkespasien_id
	 */
	public function actionDeletePemakaianBahan() {
		header("content-type:application/json");
		$data['is_found'] = 0;
        $data['pesan'] = "Data gagal dihapus!";
		if (isset($_GET['obatalkespasien_id'])) {
			if (Yii::app()->db->createCommand()->delete('obatalkespasien_t', 'obatalkespasien_id=:id', array(':id'=>$_GET['obatalkespasien_id']))) {
				$data['sukses'] = 1;
				$data['pesan'] = 'Data berhasil dihapus!';
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan jenis pemeriksaan
	 *
	 * @return jenis periksa pasien
	 */
	public function actionGetStatusPeriksaPasien() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data not found!";
            $data['data'] = array();

            $sql = "SELECT * FROM lookup_m WHERE lookup_type='statusperiksa'";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            if (!empty($loadData)) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data is found!";
                    $data['data'] = $loadData;
            }

            $encode = CJSON::encode($data);
            echo "jsonCallbackStatusPeriksa(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan kategori catatan dokter
	 *
	 * @return kategori catatan dokter
	 */
	public function actionGetKatCatDokter() {
		header("content-type:application/json");
		$data['is_found'] = 0;
                $data['pesan'] = "Data not found!";
                $data['data'] = array();
		$kategoriNama = $_GET['q'];
		$sql = "SELECT * FROM mkategoricatatan_m WHERE mkategoricatatan_nama LIKE '%$kategoriNama%'";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($loadData)>0) {
			$data['is_found'] = 1;
			$data['pesan'] = "Data is found!";
			$data['data'] = $loadData;
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}


	public function actionSubmitCatatan() {
            header("content-type:application/json");
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
            $errorDetail = "";
            if(isset($_GET['catatandokter'])){
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    $format = new MyFormatter;
                    $model = new McatatandokterT();
                    $model->attributes = $_GET['catatandokter'];
                    $model->create_time = date("Y-m-d H:i:s");
                    $model->tglrencana = MyFormatter::formatDateTimeForDb($model->tglrencana." ".date("H:i:s"));
                    if($model->save()){
                        if(empty($errorDetail)){
                            $transaction->commit();
                            $data['sukses'] = 1;
                            $data['pesan'] = 'Data catatan berhasil disimpan!';
                        }else{
                            $transaction->rollback();
                            $data['sukses'] = 0;
                            $data['pesan'] = 'Data catatan gagal disimpan!<br>'.$errorDetail;
                        }
                    }else{
                        $transaction->rollback();
                        $data['sukses'] = 0;
                        $data['pesan'] = 'Data catatan disimpan!<br>'.CHtml::errorSummary($model)."<br><pre>".$errorDetail."</pre>";
                    }
                }catch (Exception $exc) {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data catatan gagal disimpan!'.MyExceptionMessage::getMessage($exc,true);
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}
        
	public function actionEditCatatan() {
            header("content-type:application/json");
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
            if (isset($_GET['catatandokter'])) {
                if ($model = MCatatandokterT::model()->findByPk($_GET['catatandokter']['mcatatandokter_id'])) {
                    $model->attributes  = $_GET['catatandokter'];
                    $model->update_time = date("Y-m-d H:i:s");
                    $model->tglrencana =MyFormatter::FormatDateTimeForDb($model->tglrencana);
                    if ($model->save()) {
                        $data['sukses'] = 1;
                        $data['pesan'] = 'Data catatan berhasil disimpan!';
                    }
                }

            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
	}

	/**
	 * action untuk mendapatkan catatan umum
	 *
	 * @return array dari catatan dokter
	 */
	public function actionGetCatatan() {
		header("content-type:application/json");
		$data['is_found'] = 0;
                $data['pesan'] = "Data not found!";
                $data['data'] = array();
		$sql = "SELECT * FROM mcatatandokter_t JOIN mkategoricatatan_m "
                    ."ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
                    ."WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_UMUM
                    ." AND mcatatandokter_t.status_catatan!='READ' "
                    ."ORDER BY mcatatandokter_t.mcatatandokter_id DESC LIMIT 8";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($loadData)>0) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data is found!";
                    $data['data'] = $loadData;
                foreach ($data['data'] as $i => $val) {
                    $data['data'][$i]['create_time'] = MyFormatter::formatDateTimeForuser($val['create_time']);
                    $data['data'][$i]['tglrencana'] = MyFormatter::formatDateTimeForuser($val['tglrencana']);
                    $data['data'][$i]['update_time'] = MyFormatter::formatDateTimeForuser($val['update_time']);
                }
                $sql2 = "SELECT *, tglrencana::time as time_rencana, tglrencana::date as date_rencana FROM mcatatandokter_t JOIN mkategoricatatan_m "
                        ."ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
                        ."WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_AGENDA
                        ."ORDER BY mcatatandokter_t.mcatatandokter_id DESC";
                    if ($loadData2 = Yii::app()->db->createCommand($sql2)->queryRow()) {
                        $data['agenda']['agenda_title'] = $loadData2['judulcatatan'];
                        $data['agenda']['agenda_time'] = $loadData2['time_rencana'];
                        $data['agenda']['agenda_date'] = MyFormatter::formatDateTimeForuser($loadData2['date_rencana']);
                    }else {
                        $data['agenda']['agenda_title'] = 'No agenda found!';
                        $data['agenda']['agenda_time'] = '-';
                        $data['agenda']['agenda_date'] = '-';
                    }
		}

		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
		Yii::app()->end();
	}
        /**
	 * action untuk mendapatkan catatan umum
	 *
	 * @return array dari catatan dokter
	 */
        public function actionGetCatatDokter() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data not found!";
            $data['data'] = array();
            $sql = "SELECT * FROM mcatatandokter_t LIMIT 8";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            if (count($loadData)>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data is found!";
                $data['data'] = $loadData;
                foreach ($data['data'] as $i => $val) {
                    $data['data'][$i]['create_time'] = MyFormatter::formatDateTimeForuser($val['create_time']);
                    $data['data'][$i]['tglrencana'] = MyFormatter::formatDateTimeForuser($val['tglrencana']);
                    $data['data'][$i]['update_time'] = MyFormatter::formatDateTimeForuser($val['update_time']);
                }
                $sql2 = "SELECT *, tglrencana::time as time_rencana, tglrencana::date as date_rencana FROM mcatatandokter_t JOIN mkategoricatatan_m "
                        ."ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
                        ."WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_AGENDA
                        ."ORDER BY mcatatandokter_t.mcatatandokter_id DESC";
                if ($loadData2 = Yii::app()->db->createCommand($sql2)->queryRow()) {
                    $data['agenda']['agenda_title'] = $loadData2['judulcatatan'];
                    $data['agenda']['agenda_time'] = $loadData2['time_rencana'];
                    $data['agenda']['agenda_date'] = MyFormatter::formatDateTimeForuser($loadData2['date_rencana']);
                }else {
                    $data['agenda']['agenda_title'] = 'No agenda found!';
                    $data['agenda']['agenda_time'] = '-';
                    $data['agenda']['agenda_date'] = '-';
                }
            }

            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

	/**
	 * action untuk mendapatkan agenda dokter
	 *
	 * @return array dari catatan dokter
	 */
	public function actionGetAgenda() {
            header("content-type:application/json");
            $data['is_found'] = 0;
            $data['pesan'] = "Data not found!";
            $data['data'] = array();
            $sql = "SELECT * FROM mcatatandokter_t JOIN mkategoricatatan_m "
                . "ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
                . "WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_AGENDA
                . " AND mcatatandokter_t.status_catatan!='READ' "
                . "ORDER BY mcatatandokter_t.mcatatandokter_id DESC LIMIT 8";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            if (count($loadData)>0) {
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data is found!";
                    $data['data'] = $loadData;
                foreach ($data['data'] as $i => $val) {
                    $data['data'][$i]['create_time'] = MyFormatter::formatDateTimeForuser($val['create_time']);
                    $data['data'][$i]['tglrencana'] = MyFormatter::formatDateTimeForuser($val['tglrencana']);
                    $data['data'][$i]['update_time'] = MyFormatter::formatDateTimeForuser($val['update_time']);
                }
                $sql2 = "SELECT * FROM mcatatandokter_t JOIN mkategoricatatan_m "
                        . "ON mcatatandokter_t.mkategoricatatan_id=mkategoricatatan_m.mkategoricatatan_id "
                        . "WHERE mcatatandokter_t.mkategoricatatan_id=".Params::KATEGORICATATAN_ID_AGENDA
                        . " AND mcatatandokter_t.status_catatan!='READ' "
                        . " ORDER BY mcatatandokter_t.mcatatandokter_id DESC";
                if ($loadData2 = Yii::app()->db->createCommand($sql2)->queryRow()) {
                    $data['agenda']['agenda_title'] = $loadData2['judulcatatan'];
                    $data['agenda']['agenda_time'] = explode(' ',$loadData2['tglrencana'])[1];
                    $data['agenda']['agenda_date'] = MyFormatter::formatDateTimeForuser(explode(' ',$loadData2['tglrencana'])[0]);
                }else {
                    $data['agenda']['agenda_title'] = 'No agenda found!';
                    $data['agenda']['agenda_time'] = '-';
                    $data['agenda']['agenda_date'] = '-';
                }
            }

            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}
	/**
	 * action untuk membuat catatan sudah dibaca
	 *
	 * @param catatan_id, mcatatandokter_id
	 */
	public function actionMarkAsDoneNote() {
            header("content-type:application/json");
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
            if (isset($_GET['catatan_id'])) {
                $sql = "UPDATE mcatatandokter_t SET status_catatan = 'READ' WHERE mcatatandokter_id=".$_GET['catatan_id'];
                if (Yii::app()->db->createCommand()->update('mcatatandokter_t',
                    array('status_catatan'=>'READ'), 'mcatatandokter_id=:id', array(':id'=>$_GET['catatan_id']))) {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data have been sucessfully changed!';
                }else {
                    $data['pesan'] = 'Data have not been sucessfully changed!';
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}

    /**
    * Action untuk cek apakah pasien sudah di admisi
    *
    * @param pasien_id
    *
    */
    public function actionCekPasienAdmisi()
    {
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Data admisi tidak ditemukan';
        $data['data'] = array();
        if(isset($_GET['pendaftaran_id'])){
            $sql = "SELECT pendaftaran_t.pendaftaran_id,pendaftaran_t.pasienadmisi_id,statusperiksa,tgl_pendaftaran,tgladmisi,ruanganadmisi_m.ruangan_nama AS ruanganadmisi_nama,ruanganpendaftaran_m.ruangan_nama AS ruanganpendaftaran_nama, pasienadmisi_t.dokterpenerima_id, pegawai_m.pegawai_id, pegawai_m.gelardepan, pegawai_m.nama_pegawai, gelarbelakang_m.gelarbelakang_nama FROM
                pendaftaran_t 
                LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id 
                LEFT JOIN ruangan_m ruanganadmisi_m ON pasienadmisi_t.ruangan_id = ruanganadmisi_m.ruangan_id
                LEFT JOIN pegawai_m ON pasienadmisi_t.dokterpenerima_id = pegawai_m.pegawai_id
                LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
                JOIN ruangan_m ruanganpendaftaran_m ON ruanganpendaftaran_m.ruangan_id = pendaftaran_t.ruangan_id 
                WHERE pendaftaran_t.pendaftaran_id = ".$_GET['pendaftaran_id'];
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if($loadData){
                $data['sukses'] = 1;
                $data['pesan'] = 'sukses';
                $data['data'] = $loadData;
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackCekAdmisi(".$encode.");";
        Yii::app()->end();
    }

    public function actionCekRencanaKontrol()
    {
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Data rencana Kontrol tidak ditemukan';
        $data['data'] = array();
        if(isset($_GET['pendaftaran_id'])){
            $sql = "SELECT pendaftaran_id, tglrenkontrol FROM pendaftaran_t WHERE pendaftaran_id = ".$_GET['pendaftaran_id'];
            $loadData = Yii::app()->db->createCommand($sql)->queryRow();
            if($loadData){
                $data['sukses'] = 1;
                $data['pesan'] = 'sukses';
                $data['data']['pendaftaran_id'] = $loadData['pendaftaran_id'];
                $data['data']['tglrenkontrol'] = !empty($loadData['tglrenkontrol'])?MyFormatter::FormatDateTimeForUser($loadData['tglrenkontrol']):'Tidak ada rencana';                
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackCekRencanaKontrol(".$encode.");";
        Yii::app()->end();
    }


}
