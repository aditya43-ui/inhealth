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
class MLaboratoriumController extends Controller {

	public $hasilpemeriksaantersimpan;
	public $savePasienMasukPenunjang = FALSE;
	public $saveTindakanPelayananStat = FALSE;
	
	
	/**
	 * action untuk mendapatkan list daftar pasien lab
	 * 
	 * @param pegawai_id
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
            $q = empty($_GET['q'])?$_GET['noRedMek']:$_GET['q'];
            $staDateLab = $_GET['staDateLab'];
            $endDateLab = $_GET['endDateLab'];
            $pegawai_id = $_GET['pegawai_id'];
            $offset = $_GET['offset'];
            $key = '';
            if(!empty($q)){
                $key = 'AND (lower(nama_pasien) ILIKE lower(\''.$q.'%\') OR lower(no_rekam_medik) ILIKE lower(\''.$q.'%\'))';
            }
            if(empty($staDateLab) && empty($endDateLab)){
                $date = "AND DATE(tglmasukpenunjang) = '".date('Y-m-d')."'";
            }else{
                $date = "AND DATE(tglmasukpenunjang) BETWEEN '".MyFormatter::formatDateTimeForDb($staDateLab)."' AND '".MyFormatter::formatDateTimeForDb($endDateLab)."'";
            }
            if (!empty($_GET['pegawai_id'])) {        			
                $sql = "SELECT * FROM pasienmasukpenunjang_v WHERE pegawai_id = ".$_GET['pegawai_id']." ".$key." AND instalasi_id = ".PARAMS::INSTALASI_ID_LAB." ".$date." ORDER BY tglmasukpenunjang DESC LIMIT 9 OFFSET ".$offset;            
            }else{
                $sql = "SELECT * FROM pasienmasukpenunjang_v WHERE instalasi_id = ".PARAMS::INSTALASI_ID_LAB." ".$date."  ORDER BY tglmasukpenunjang DESC LIMIT 9 OFFSET ".$offset;
            }
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = count($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackDaftarPasien(".$encode.")";
	}
	
	/**
	 * action untuk input pengambilan sampel yang dilakukan oleh dokter
	 * 
	 * @param array dari pengambilan sample
	 * @return sukses 1/0
	 */
	public function actionSubmitPengambilanSample() {
		header("content-type:application/json");
		$data = array();
		$data['sukses'] = 0;
		$data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
		$error = "";
		$format = new MyFormatter();
		if(isset($_GET['pasienmasukpenunjang_id']) && isset($_GET['ambilsample'])){
			$transaction = Yii::app()->db->beginTransaction();
			$sampletersimpan = true; //looping
			$sample = $_GET['ambilsample'];
			try{
				//foreach($_GET['pengambilansample'] AS $i => $sample){
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
					if (isset($_GET['is_kirimsample'])){
						if(empty($_GET['kirimsample']['kirimsamplelab_id'])){
							$modKirim = new MOKirimsamplelabT;
							$modKirim->create_time = date("Y-m-d H:i:s");
							$modKirim->pengambilansample_id = $model->pengambilansample_id;
						}else{
							$modKirim = MOKirimsamplelabT::model()->findByPk($_GET['kirimsample']['kirimsamplelab_id']);
							$modKirim->update_time = date("Y-m-d H:i:s");
						}
						$modKirim->attributes = $_GET['kirimsample'];
						$modKirim->tglkirimsample = $format->formatDateTimeForDb($modKirim->tglkirimsample);
						if($modKirim->save()){
							$sampletersimpan &= true;
						}else{
							$sampletersimpan = false;
							$error .= CHtml::errorSummary($modKirim);
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
	 * action untuk menampilkan data list  pemeriksaan lab
	 * 
	 * @param array tindakan pelayanan lab
	 */
	public function actionGetTindakanPelayananLab() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        $statusPasien = '';
		$tglPendaftaran = '';
		if (isset($_GET['pendaftaran_id'])) {
			$pendaftaran_id = $_GET['pendaftaran_id'];
			$sql = "SELECT * FROM pendaftaran_t WHERE pendaftaran_id=".$pendaftaran_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryRow();			
			if (sizeof($loadData)>0) {	
				$sql = "SELECT * "
						. "FROM tindakanpelayanan_t JOIN daftartindakan_m ON tindakanpelayanan_t.daftartindakan_id=daftartindakan_m.daftartindakan_id "
						. "WHERE tindakanpelayanan_t.pendaftaran_id=".$pendaftaran_id;
				$loadData2 = Yii::app()->db->createCommand($sql)->queryAll();
				if (sizeof($loadData2)>0) {
					$data['data']=$loadData2;
					$data['is_found'] = 1;
					$data['pesan'] = "Data ditemukan!"; 
					$data['no_pendaftaran'] = $loadData['no_pendaftaran'];	
				}
			}
		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	} 
	
	/**
	 * action untuk menampilkan data riwayat ambil dan kirim sample
	 * 
	 * @param array ambil dan kirim sample
	 */
	public function actionGetRiwayatAmbilKirimSample() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        $statusPasien = '';
		$tglPendaftaran = '';
		if (isset($_GET['pasienmasukpenunjang_id'])) {
			$pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
			$sql = "SELECT * FROM pengambilansample_t "
					. "JOIN samplelab_m ON pengambilansample_t.samplelab_id=samplelab_m.samplelab_id "
					. "WHERE pasienmasukpenunjang_id=".$pasienmasukpenunjang_id;
			$loadData = Yii::app()->db->createCommand($sql)->queryAll();	
			$i = 0;
			foreach ($loadData as $datum) {
				$data['data'][$i]['ambilsample']=$datum;				
				$sql = "SELECT * FROM kirimsamplelab_t "
					. "JOIN pengambilansample_t ON kirimsamplelab_t.pengambilansample_id=pengambilansample_t.pengambilansample_id "
					. "JOIN labklinikrujukan_m ON labklinikrujukan_m.labklinikrujukan_id=kirimsamplelab_t.labklinikrujukan_id "
					. "WHERE pengambilansample_t.pengambilansample_id=".$datum['pengambilansample_id'];
				$loadData2 = Yii::app()->db->createCommand($sql)->queryRow();				
				if (sizeof($loadData2)>0) {	
					$data['data'][$i]['kirimsample']=$loadData2;
				}
				$data['is_found'] = 1;
				$data['pesan'] = "Data ditemukan!";
				$i++;
			}
		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	} 
	
	/** 
	 * action untuk mendapatkan sampel lab
	 * 
	 * @return array sampel lab 
	 */
	public function actionGetSampleLab() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$pendaftaran_id = $_GET['pendaftaran_id'];
		$sql = "SELECT * FROM samplelab_m";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
		if (sizeof($loadData)>0) {
			$data['data']=$loadData;
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!"; 

		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	}
	
	/** 
	 * action untuk mendapatkan sample lab
	 * 
	 * @return array sample lab 
	 */
	public function actionHapusItemAmbilLab() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$pengambilansampleID = $_GET['pengambilansample_id'];
		
		$sql = "DELETE FROM kirimsamplelab_t WHERE pengambilansample_id = ".$pengambilansampleID;
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
		if (sizeof($loadData)>0) {
			$data['data']=$loadData;
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!"; 

		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	}

	/** 
	 * action untuk mendapatkan sample lab
	 * 
	 * @return array sample lab 
	 */
	public function actionGetItemHasilLab() {
            header("content-type:application/json");
            $format = new MyFormatter();
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            $pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
            $loadHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            if(count($loadHasilPemeriksaan)>0){
                $sql = "SELECT Hasilpemeriksaanlab_T.pendaftaran_id,* FROM Hasilpemeriksaanlab_T 
                JOIN detailHasilPemeriksaanLab_T t ON t.hasilpemeriksaanlab_id = Hasilpemeriksaanlab_T.hasilpemeriksaanlab_id
                JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
                JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id 
                WHERE t.hasilpemeriksaanlab_id = ".$loadHasilPemeriksaan->hasilpemeriksaanlab_id." 
                ORDER BY pemeriksaanlab_m.pemeriksaanlab_urutan ASC, 
                pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC ";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();			
                if (count($loadData)>0) {
                    $data['data']=$loadData;
                    $data['is_found'] = 1;
                    $data['pesan'] = "Data ditemukan!"; 

                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackHasilLab(".$encode.")";
	}

	public function actionGetHasilLab(){
            header("content-type:application/json");
            $format = new MyFormatter();
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = "Data tidak ditemukan!";
            $data['data'] = array();
            $pasienmasukpenunjang_id = $_GET['pasienmasukpenunjang_id'];
            $loadHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            if (count($loadHasilPemeriksaan)>0) {
                $data['data']=$loadHasilPemeriksaan;
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!"; 

            }
            $encode = CJSON::encode($data);
            echo "jsonCallbackHasilKetLab(".$encode.")";
	}

	public function actionSubmitHasilLab(){
            header("content-type:application/json");
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
            $dataDetails =false;
            if(isset($_REQUEST['HasilPemeriksaanLabT']) && isset($_REQUEST['detailHasilPemeriksaanT'])){
                $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$_REQUEST['HasilPemeriksaanLabT']['pasienmasukpenunjang_id']));
                $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG;
                $modHasilPemeriksaan->catatanlabklinik = (isset($_REQUEST['HasilPemeriksaanLabT']['catatanlabklinik']) ? $_REQUEST['HasilPemeriksaanLabT']['catatanlabklinik'] : null);
                $modHasilPemeriksaan->kesimpulan = (isset($_REQUEST['HasilPemeriksaanLabT']['kesimpulan']) ? $_REQUEST['HasilPemeriksaanLabT']['kesimpulan'] : null);
                $modHasilPemeriksaan->update_time = date('Y-m-d H:i:s');
                $modHasilPemeriksaan->update_loginpemakai_id = $_REQUEST['HasilPemeriksaanLabT']['loginpemakai_id'];
                    if($modHasilPemeriksaan->update()){
                        $this->hasilpemeriksaantersimpan = true;
                    }else{
                        $this->hasilpemeriksaantersimpan = false;
                    }
                    if(isset($_REQUEST['detailHasilPemeriksaanT'])){
                    if(count($_REQUEST['detailHasilPemeriksaanT']) > 0){
                        foreach($_REQUEST['detailHasilPemeriksaanT'] AS $i => $postDetail){
                            $dataDetails = $this->ubahDetailHasilPemeriksaanLab($postDetail,$_REQUEST['HasilPemeriksaanLabT']['loginpemakai_id']);
                        }
                    }
                }
                if($dataDetails && $this->hasilpemeriksaantersimpan){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Sukses diinput!"; 
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
	}

	public function ubahDetailHasilPemeriksaanLab($post,$loginpemakai_id){
		$hasilpemeriksaantersimpan = true;
        $modDetailHasilPemeriksaans = DetailhasilpemeriksaanlabT::model()->findByPk($post['detailhasilpemeriksaanlab_id']);
        $modDetailHasilPemeriksaans->hasilpemeriksaan = $post['hasilpemeriksaan'];
		$modDetailHasilPemeriksaans->hasil_laboratorium = $post['hasil_laboratorium'];
        $modDetailHasilPemeriksaans->update_time = date("Y-m-d H:i:s");
        $modDetailHasilPemeriksaans->update_loginpemakai_id = $loginpemakai_id;
        $modDetailHasilPemeriksaans->create_ruangan = PARAMS::RUANGAN_ID_LAB_ANATOMI;
        if($modDetailHasilPemeriksaans->validate()){
            $modDetailHasilPemeriksaans->update();
        }else{
            $hasilpemeriksaantersimpan = false;
        }
        return $hasilpemeriksaantersimpan;
    }
	
	/** 
	 * action untuk mendapatkan lab klinik rujukan
	 * 
	 * @return array sampel lab 
	 */
	public function actionGetLabKlinikRujukan() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
		$sql = "SELECT * FROM labklinikrujukan_m";
		$loadData = Yii::app()->db->createCommand($sql)->queryAll();			
		if (sizeof($loadData)>0) {
			$data['data']=$loadData;
			$data['is_found'] = 1;
			$data['pesan'] = "Data ditemukan!"; 
		}
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
	}
	
	
	/*
	 * action untuk menampilkan pasien rujukan dari lab
	 * 
	 * @param pegawai_id
	 */	
	public function actionGetPasienLab() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = 'Tidak Ditemukan';
            $data['data'] = array();
            $q = empty($_GET['q'])?$_GET['noRedMek']:$_GET['q'];
            $staDateLab = $_GET['staDateLab'];
            $endDateLab = $_GET['endDateLab'];
            $pegawai_id = $_GET['pegawai_id'];
            $limit = $_GET['lim'];
            $offset = $_GET['offset'];
            $key = '';
            if(!empty($q)){
                $key = '(lower(nama_pasien) ILIKE lower(\''.$q.'%\') OR lower(no_rekam_medik) ILIKE lower(\''.$q.'%\')) AND';
            }
            if(empty($staDateLab) && empty($endDateLab)){
                $date = "AND DATE(tgl_pendaftaran) = '".date('Y-m-d')."'";
            }else{
                $date = "AND DATE(tgl_pendaftaran) BETWEEN '".MyFormatter::formatDateTimeForDb($staDateLab)."' AND '".MyFormatter::formatDateTimeForDb($endDateLab)."'";
            }
            $pegawai = PegawaiM::model()->findByPk($pegawai_id);
            $sql = "SELECT * FROM Infokunjunganrjrdri_V WHERE ".$key." LOWER(nama_pegawai) = '".strtolower($pegawai->nama_pegawai)."' ".$date."  ORDER BY tgl_pendaftaran DESC LIMIT 9 OFFSET ".$offset;
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();			
            if (count($loadData)>0) {
                foreach ($loadData as $i => $value) {
                    $sqlPasien = "SELECT * FROM pasien_m WHERE pasien_id = ".$value['pasien_id'];
                    $loadDataPasien = Yii::app()->db->createCommand($sqlPasien)->queryRow();
                    $data['data'][$i] = $value;
                    $data['data'][$i]['photopasien'] = $loadDataPasien['photopasien'];
                }
                $data['is_found'] = 1;
                $data['pesan'] = 'Data found';
            }

            $encode = CJSON::encode($data);
            echo "jsonCallbackPasienRS(".$encode.")";
            Yii::app()->end();
	}
	
	/*
	 * action untuk menampilkan item rujukan lab
	 * @param pasienkirimkeunitlain_id
	 * @param pendaftaran_id
	 */	
	public function actionGetItemRujukanLab() {
            header("content-type:application/json");
            $data = array();
            $data['is_found'] = 0;
            $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';	
            if (isset($_GET['pasienkirimkeunitlain_id'])&&isset($_GET['pendaftaran_id'])) {
                $pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];
                $pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];		
                $sql = "SELECT pasienkirimkeunitlain_id, jenispemeriksaanlab_m.jenispemeriksaanlab_nama,
                        pemeriksaanlab_m.pemeriksaanlab_nama, pemeriksaanlab_m.pemeriksaanlab_id
                        FROM permintaankepenunjang_t 
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id=permintaankepenunjang_t.pemeriksaanlab_id
                        JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id=jenispemeriksaanlab_m.jenispemeriksaanlab_id
                        WHERE pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id
                        ORDER BY pemeriksaanlab_m.pemeriksaanlab_nama";
                $loadData = Yii::app()->db->createCommand($sql)->queryAll();
                if (!empty($loadData)) {
                    $data['data'] = $loadData;
                    $data['is_found'] = 1;
                    $data['pesan'] = 'Data found';
                }else{
                    echo $pendaftaran_id;
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}
	
	/**
	 * action untuk mendapatkan info item rujukan
	 * 
	 * @param array pasienmasukpenunujang_m
	 * @return array sukses 1/0
	 */
	
	public function actionSubmitPasienKePenunjang() {
            header('content-type: application/json');
            $data = array();
            $data['sukses'] = 0;
            $data['pesan'] = 'Data Gagal Disimpan';		
            if(isset($_GET['pasienmasukpenunjang'])){
                $sampletersimpan = true; //looping
                $modTindakan = new MOTindakanpelayananT;
                $masukpenunjang = $_GET['pasienmasukpenunjang'];
                $tindakanpelayanan = isset($_GET['tindakanpelayanan'])?$_GET['tindakanpelayanan']:'';
                $permintaankepenunjang = isset($_GET['permintaankepenunjang'])?$_GET['permintaankepenunjang']:'';
                //$model = 
                $model = new MOPasienmasukpenunjangT();
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pasienmasukpenunjang']['pendaftaran_id']);
                    $model->attributes = $_GET['pasienmasukpenunjang'];
                    $model->create_time = date("Y-m-d H:i:s");
                    $instalasi_id = $model->ruangan->instalasi_id;
                    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
                    $model->kunjungan = 'KUNJUNGAN BARU';
                    $model->create_loginpemakai_id = 1;
                    $model->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
                    $model->ruanganasal_id = $modPendaftaran->ruangan_id;
                    $model->pasienkirimkeunitlain_id = !empty($modPendaftaran->pasienkirimkeunitlain_id) ? (($model->pasienkirimkeunitlain_id != 'undefided')?$modPendaftaran->pasienkirimkeunitlain_id:null): null;
                    $model->jeniskasuspenyakit_id = !empty($modPendaftaran->jeniskasuspenyakit_id) ? $modPendaftaran->jeniskasuspenyakit_id : null;
                    $model->kelaspelayanan_id = isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null;
                    $model->tglmasukpenunjang = date("Y-m-d H:i:s");
                    $model->no_urutperiksa =  MyGenerator::noAntrianPenunjang($model->ruangan_id);
                    $model->statusperiksa = $modPendaftaran->statusperiksa;
                    $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
                    $model->panggilantrian = $modPendaftaran->panggilantrian;
                    $model->update_time = date("Y-m-d H:i:s");
                    $model->pegawai_id = $_GET['pasienmasukpenunjang']['pegawai_id'];
                    if ($model->validate()) {
                        $model->save();
                        $this->savePasienMasukPenunjang = TRUE;
                    }
                    if($model->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK && $this->savePasienMasukPenunjang){
                        $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPendaftaran, $model);
                    }                
                    if ($this->savePasienMasukPenunjang) {
                        $n = sizeof($tindakanpelayanan);
                        $i = 0;
                        if(!empty($tindakanpelayanan)){
                            while ($i<$n) {							
                                $modelTindakanPelayanan = new MOTindakanpelayananT;
                                $modelTindakanPelayanan->attributes = $tindakanpelayanan[$i];
                                $modelTindakanPelayanan->create_time = date("Y-m-d H:i:s");
                                $modelTindakanPelayanan->shift_id = 1;						
                                $modelTindakanPelayanan->pasien_id = $model->pasien_id;				
                                $modelTindakanPelayanan->kelaspelayanan_id =  $model->kelaspelayanan_id;					
                                $modelTindakanPelayanan->instalasi_id =  $_GET['pasienmasukpenunjang']['instalasi_id'];					
                                $modelTindakanPelayanan->ruangan_id =  $model->ruangan_id;					
                                $modelTindakanPelayanan->carabayar_id =  $_GET['pasienmasukpenunjang']['carabayar_id'];					
                                $modelTindakanPelayanan->pendaftaran_id =  $model->pendaftaran_id;					
                                $modelTindakanPelayanan->tgl_tindakan =  date("Y-m-d H:i:s");
                                $modelTindakanPelayanan->penjamin_id =  $_GET['pasienmasukpenunjang']['penjamin_id'];
                                $modelTindakanPelayanan->tarif_rsakomodasi =  0;
                                $modelTindakanPelayanan->tarif_medis =  0;
                                $modelTindakanPelayanan->tarif_paramedis =  0;
                                $modelTindakanPelayanan->tarif_bhp =  0;
                                $modelTindakanPelayanan->tarif_tindakan =  $modelTindakanPelayanan->tarif_satuan*$modelTindakanPelayanan->qty_tindakan;
                                $modelTindakanPelayanan->satuantindakan =  0;
                                $modelTindakanPelayanan->cyto_tindakan =  0;
                                $modelTindakanPelayanan->tarifcyto_tindakan =  0;
                                $modelTindakanPelayanan->discount_tindakan =  0;
                                $modelTindakanPelayanan->pembebasan_tindakan =  0;
                                $modelTindakanPelayanan->subsidiasuransi_tindakan =  0;
                                $modelTindakanPelayanan->subsidipemerintah_tindakan =  0;
                                $modelTindakanPelayanan->subsisidirumahsakit_tindakan =  0;
                                $modelTindakanPelayanan->iurbiaya_tindakan =  0;
                                $modelTindakanPelayanan->create_loginpemakai_id =  1;
                                $modelTindakanPelayanan->create_ruangan =  $_GET['pasienmasukpenunjang']['ruangan_id'];
                                $modelTindakanPelayanan->pasienmasukpenunjang_id =  $model->pasienmasukpenunjang_id;
                                $modelTindakanPelayanan->jeniskasuspenyakit_id =  $_GET['pasienmasukpenunjang']['jeniskasuspenyakit_id'];
                                if($modelTindakanPelayanan->validate()){
                                    $modelTindakanPelayanan->save();
                                    $this->saveTindakanPelayananStat = TRUE;
                                }									
                                if ($this->saveTindakanPelayananStat) {
                                        if($model->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
                                            if(!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)){
                                                if(empty($tindakan['tindakanpelayanan_id'])){ //jika tindakan baru
                                                    $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modelTindakanPelayanan,$tindakanpelayanan[$i]);
                                                }
                                            }
                                        }else if($model->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
                                            $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modelTindakanPelayanan, $tindakanpelayanan[$i]);
                                        }								
                                        $data['sukses'] = 1;
                                        $data['pesan'] = 'Penambahan data telah berhasil dilakukan!';								
                                }else {
                                    $transaction->rollback();
                                    $data['is_sukses'] = 0;
                                    $data['pesan'] = 'Penambahan data gagal dilakukan!';
                                }
                                $i++;		
                            }
                        }	
                    }else {

                    }
                    $transaction->commit();		
                }catch (Exception $exc) {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data lab gagal disimpan!'.$exc;
                }
            }
            $encode = CJSON::encode($data);
            echo "jsonCallback(".$encode.")";
            Yii::app()->end();
	}


	/**
	 * simpan LBHasilPemeriksaanLabT
	 */
	public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang) {
		$modHasilPemeriksaan = new HasilpemeriksaanlabT;
		$modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
		$modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->pasien->tanggal_lahir);
		$modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->pasien->jeniskelamin;
		$modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
		$modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
		$modHasilPemeriksaan->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;

		if ($modHasilPemeriksaan->validate()) {
			$modHasilPemeriksaan->save();
		} 
		
		return $modHasilPemeriksaan;
	}
	

	/**
	 * simpan LBDetailHasilPemeriksaanLabT
	 */
	public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post) {
		// echo "<pre>";
		// print_r($modHasilPemeriksaan->attributes);
		// exit;
		$modDetailHasilPemeriksaans = array();
		$date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
		$date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
		$umurhari = $date2->diff($date1)->format("%a");
		$criteria = new CDbCriteria();
		$criteria->addCondition('pemeriksaanlab_id = ' . $post['pemeriksaanlab_id']);
		$criteria->addCondition("'" . $umurhari . "' BETWEEN hariminlab AND harimakslab");
		$criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
		$criteria->order = 'pemeriksaanlabdet_nourut ASC';
		$modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);
		if (count($modPemeriksaanLadDet) > 0) {
			foreach ($modPemeriksaanLadDet AS $i => $pemeriksaanDet) {
				$modDetailHasilPemeriksaans[$i] = new DetailhasilpemeriksaanlabT;
				$modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
				$modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
				$modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
				$modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
				$modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
				$modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
				$modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
				$modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
				$modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = $modHasilPemeriksaan->create_loginpemakai_id;
				$modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;

				if ($modDetailHasilPemeriksaans[$i]->validate()) {
					$modDetailHasilPemeriksaans[$i]->save();
				} 
			}
		}
		return $modDetailHasilPemeriksaans;
	}

	/**
	 * simpan LBHasilPemeriksaanPAT
	 */
	public function simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $post) {
		$modHasilPemeriksaanPA = new HasilPemeriksaanPAT;
		$modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
		$modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
		$modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
		$modHasilPemeriksaanPA->nosediaanpa = MyGenerator::noSediaanPA();
		$modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
		$modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
		$modHasilPemeriksaanPA->create_loginpemakai_id = Yii::app()->user->id;
		$modHasilPemeriksaanPA->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

		if ($modHasilPemeriksaanPA->validate()) {
			$modHasilPemeriksaanPA->save();
			$modTindakan->hasilpemeriksaanpa_id = $modHasilPemeriksaanPA->hasilpemeriksaanpa_id;
			$modTindakan->update();
		} 
		return $modHasilPemeriksaanPA;
	}

}
