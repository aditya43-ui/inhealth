<?php
/**
 * Kelas Controller untuk mendapatkan proses booking kamar
 */
ini_set('memory_limit', '128M');
class MBookingRoomController extends Controller
{

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
			$notQ = $_GET['notqsta'];
			$startVal = $_GET['st'];
			$limit = $_GET['lm'];
			$strNotQ = '';
			if(isset($_GET['notq'])){
				foreach($_GET['notq'] AS $i => $data){
					$strNotQ = $strNotQ.' AND kamarruangan_m.kamarruangan_id <> '.$data['kamarruangan_id'];
				}
			}			
			$sql = "SELECT ruangan_m.ruangan_id, ruangan_m.ruangan_nama, 
                kamarruangan_m.kamarruangan_id, kamarruangan_m.kamarruangan_nokamar, kamarruangan_m.kamarruangan_nobed, kamarruangan_m.kamarruangan_jmlbed, kamarruangan_m.kamarruangan_image, kamarruangan_m.keterangan_kamar, 
                kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, daftartindakan_m.daftartindakan_namalainnya, tariftindakan_m.harga_tariftindakan AS tarif
                FROM tariftindakan_m
                JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
                JOIN tindakanruangan_m ON tindakanruangan_m.daftartindakan_id = tariftindakan_m.daftartindakan_id
                JOIN ruangan_m ON ruangan_m.ruangan_id = tindakanruangan_m.ruangan_id
                JOIN kamarruangan_m ON kamarruangan_m.ruangan_id = ruangan_m.ruangan_id AND kamarruangan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
                JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id
                JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
                WHERE daftartindakan_m.daftartindakan_aktif = TRUE 
                AND daftartindakan_m.daftartindakan_akomodasi = TRUE 
                AND ruangan_m.ruangan_aktif = TRUE 
                AND kamarruangan_m.kamarruangan_aktif = TRUE
                AND jenistarifpenjamin_m.penjamin_id = 1 ".
				$strNotQ." AND
                (LOWER(ruangan_m.ruangan_nama) like '%".$q."%'
                OR LOWER(kamarruangan_m.kamarruangan_nokamar) like '%".$q."%'
                OR LOWER(kamarruangan_m.kamarruangan_nobed) like '%".$q."%'
                OR LOWER(kamarruangan_m.keterangan_kamar) like '%".$q."%'
                OR LOWER(daftartindakan_m.daftartindakan_nama) like '%".$q."%')
                ORDER BY kamarruangan_m.keterangan_kamar DESC
                LIMIT $limit OFFSET $startVal";
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
        //echo $sql; 
    }

	
	/**
	 * Simpan data booking kamar
	 * 
	 */
	public function actionBookingRoom()
	{
		$data['sukses'] = 0;
		$data['pesan'] = "Error 404 : Request tidak valid. Cek parameter";
		$data['data'] = '';
		$model=new MOBookingkamarT;
		$model->tglbookingkamar = date('Y-m-d H:i:s');//date('d M Y H:i:s');
		$modPasien = new MOPasienM;
		$modPasien->tanggal_lahir = date('d/m/Y');
		$modPasien->agama = Params::DEFAULT_AGAMA;
		$modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
		$modPasien->isPasienLama = false;
		$model->bookingkamar_no = "- Otomatis -";
		if (isset($_GET['BookingKamar'])) {	
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->bookingkamar_no = MyGenerator::noBookingKamar();
				$model->attributes= $_GET['BookingKamar'];
				$model->tgltransaksibooking=date('Y-m-d H:i:s');
				$model->statuskonfirmasi = Params::STATUSKONFIRMASI_BOOKING_BELUM;
				$model->statusbooking = Params::STATUSBOOKING_NON_ANTRI;
				$model->create_time = date('Y-m-d H:i:s');
				$model->bookingkamar_no = MyGenerator::noBookingKamar();

				if ($_GET['isPasienLama']==0)
				{// Jika Bukan Pasien Lama
					$modPasien = $this->savePasien($_GET['Pasien']);
					$model->pasien_id=$modPasien->pasien_id;
					$id = $model->pasien_id;
					//echo "pasien id = " .$id;
					$model->pendaftaran_id = (isset($modPasien->pendaftaranTs->pendaftaran_id) ? $modPasien->pendaftaranTs->pendaftaran_id : null);
				}else {
					$modPasien = MOPasienM::model()->findByPk($_GET['pasien']['pasien_id']);
					$model->pasien_id = $modPasien->pasien_id;
					if (isset($modPasien)){
						$modPasien->attributes = $_GET['Pasien'];
						$modPasien->update_time = date("Y-m-d H:i:s");
						$modPasien->update_loginpemakai_id = 1;
						$modPasien->update();
					}
				}	

				if($model->save())
				{			
					KamarruanganM::model()->updateByPk($model->kamarruangan_id,array('keterangan_kamar'=>Params::KETERANGANKAMAR_DIPESAN));                         
					$transaction->commit();
					$data['sukses'] = 1;
					$data['pesan'] = 'Data pasien berhasil disimpan!';
				}else{
					$data['sukses'] = 0;
					$data['pesan'] = 'Data pasien gagal disimpan!-'.$id;
				}       
			} catch (Exception $ex) {
				$transaction->rollback();
				$data['sukses'] = 0;
				$data['pesan'] = 'Data booking kamar gagal disimpan!'.MyExceptionMessage::getMessage($ex,true);
			}
		}
		$encode = CJSON::encode($data);
		echo "jsonCallback(".$encode.")";
	}
	
	/**
	 * method untuk menyimpan data pasien
	 * @param type $attrPasien
	 * @return model pasien_m
	 */
	public function savePasien($attrPasien) {
		$modPasien = new MOPasienM;
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
	
	public function actionGetPasienByMedRecDateBorn() {
		header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
        if (isset($_GET['medrec'])&&isset($_GET['dateborn'])) {            
            $medRec = strtolower($_GET['medrec']);
			$dateBorn = strtolower($_GET['dateborn']);
						
			$sql = "SELECT * from pasien_m where no_rekam_medik = '$medRec' AND tanggal_lahir = '$dateBorn'";
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
        //echo $sql; 
	}
}
