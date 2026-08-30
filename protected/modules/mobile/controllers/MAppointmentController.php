<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Kelas Controller untuk mendapatkan proses buat janji
 */
ini_set('memory_limit', '-1');
class MAppointmentController extends Controller {
	//put your code here
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
    * action untuk mendapatkan list doctor
    * @param q
	* @param ruangan_id, ruangan yang dipilih sebelumnya
    * @return array of doctor
    */
    public function actionGetDoctor() {
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
    * action untuk mendapatkan list grup penjamin
    * @param q
	* @param 
    * @return array of guarantor group
    */
    public function actionGetGuarantorGroup() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$sql = "SELECT * from carabayar_m WHERE (LOWER(carabayar_nama) LIKE '%$q%' "
					. "OR LOWER(carabayar_namalainnya) LIKE '%$q%' OR LOWER(carabayar_loket) LIKE '%$q%' "
					. "OR LOWER(carabayar_singkatan) ='$q') AND carabayar_aktif= TRUE";
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
    * action untuk mendapatkan list penjamin
    * @param q
	* @param 
    * @return array of guarantor
    */
    public function actionGetGuarantor() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$carabayar_id = strtolower($_GET['carabayar_id']);
			$sql = "SELECT * from penjaminpasien_m WHERE (LOWER(penjamin_nama) LIKE '%$q%' "
					. "OR LOWER(penjamin_namalainnya) LIKE '%$q%') "
					. "AND penjamin_aktif=TRUE AND carabayar_id=$carabayar_id";
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
    * action untuk mendapatkan list kelaspelayanan
    * @param q
	* @param 
    * @return array of kelaspelayanan
    */
    public function actionGetServiceClass() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])) {            
            $q = strtolower($_GET['q']);
			$ruangan_id = strtolower($_GET['ruangan_id']);
			$sql = "SELECT * from kelaspelayanan_m km JOIN kelasruangan_m kr ON km.kelaspelayanan_id=kr.kelaspelayanan_id WHERE (LOWER(km.kelaspelayanan_nama) LIKE '%$q%' "
					. "OR LOWER(km.kelaspelayanan_namalainnya) LIKE '%$q%') "
					. "AND km.kelaspelayanan_aktif=TRUE	AND kr.ruangan_id=$ruangan_id";
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
	 * Simpan data buat janji
	 * 
	 */
	public function actionMakeAppointment(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
		$data['code'] = 'NO CODE';
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if (isset($_GET['BuatJanji'])&&isset($_GET['Pasien'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOBuatjanjipoliT;
				if ($_GET['isPasienLama']==0)
				{// Jika Bukan Pasien Lama
					$modPasien = $this->savePasien($_GET['Pasien']);
					$model->pasien_id=$modPasien->pasien_id;
					//$id = $model->pasien_id;
					//$model->pendaftaran_id = (isset($modPasien->pendaftaranTs->pendaftaran_id) ? $modPasien->pendaftaranTs->pendaftaran_id : null);
				}else {
					$modPasien = PPPasienM::model()->findByPk($_GET['pasien']['pasien_id']);
					$model->pasien_id = $modPasien->pasien_id;
					if (isset($modPasien)){
						$modPasien->attributes = $_GET['Pasien'];
						$modPasien->update_time = date("Y-m-d H:i:s");
						$modPasien->update_loginpemakai_id = 1;
						$modPasien->update();
					}
				}	
                //$model->pasien_id = $_GET['pasien_id'];
                $model->attributes = $_GET['BuatJanji'];
                $model->keteranganbuatjanji = "via m-Appointment";
                $model->create_time = date("Y-m-d H:i:s");
				$model->tglbuatjanji = date("Y-m-d H:i:s");
                $model->create_loginpemakai_id = 1;
				//CVarDumper::dump($model, 10, true);
				$model->no_buatjanji = MyGenerator::noJanjiPoli("JP");
				$model->no_antrianjanji = MyGenerator::noAntrianJanjiPoli($model->ruangan_id);
				$data['code'] = $model->no_buatjanji;

				
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Janji poliklinik berhasil!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Janji poliklinik gagal!<br>'.CHtml::errorSummary($model);
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Janji poliklinik gagal!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
	
	/**
	 * method untuk menyimpan data pasien
	 * @param type $attrPasien
	 * @return model pasien_m
	 */
	public function savePasien($attrPasien) {
		$modPasien = new PPPasienM;
		$modPasien->attributes = $attrPasien;
		$modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
		$modPasien->no_rekam_medik = MyGenerator::noRekamMedikBookingKamar();
		$modPasien->ispasienluar = true;
		$modPasien->tgl_rekam_medik = date('Y-m-d', time());
		$modPasien->profilrs_id = Params::getDefaultProfilRS();
		$modPasien->statusrekammedis = 'AKTIF';
		$modPasien->create_ruangan = 6; //Rekam Medis / disesuaikan dengan kebutuhan RS
		$modPasien->loginpemakai_id = 1;
		$modPasien->create_time = date('Y-m-d H:i:s');
		$modPasien->update_time = date('Y-m-d H:i:s');
		$modPasien->create_loginpemakai_id = 1;
		$modPasien->update_loginpemakai_id = 1;
		if ($modPasien->validate()) {
			$modPasien->save();	
		}else {
			CVarDumper::dump($modPasien, 10, true);
		}
		return $modPasien;
	}
}
