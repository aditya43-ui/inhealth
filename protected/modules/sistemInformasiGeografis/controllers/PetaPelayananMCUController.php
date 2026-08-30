<?php
class PetaPelayananMCUController extends MyAuthController
{
	public function actionIndex(){
		$model = new SGPetapenyebaranmcuR();
		$format = new MyFormatter();
		
		$model->jns_periode = "tahun";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
        $model->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_awal))));
        $model->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_akhir))));
		
        $this->render('index',array('model'=>$model,'format'=>$format));
	}
	
	// Menampilakan frame map
	// Menggunakan DAO agar proses eksekusi db lebih mulus
	public function actionSetIframePetaPelayananMCU(){

        $this->layout= '//layouts/iframeNeon';
        $format = new MyFormatter();		
		$jns_periode = $_GET['SGPetapenyebaranmcuR']['jns_periode'];
		$thn_awal = $_GET['SGPetapenyebaranmcuR']['thn_awal'];
		$thn_akhir = $_GET['SGPetapenyebaranmcuR']['thn_awal'];
		$thn_akhir = $thn_akhir."-".date("m-t",strtotime($thn_akhir."-12"));
		$tgl_awal = $thn_awal."-01-01"; 
		$tgl_akhir = $thn_akhir;
		
		$jenispasienbadaks = $_GET['SGPetapenyebaranmcuR']['jenispasienbadak'];
		$paramjenispasien = null;
		
		if(!empty($jenispasienbadaks)){
			if(count((array)$jenispasienbadaks)==2){
					$paramjenispasien = null;
			}else{
				if($jenispasienbadaks[0]=='PEKERJA'){
					$paramjenispasien = "AND asuransipasien_m.hubkeluarga ilike '%Pekerja%' AND asuransipasien_m.carabayar_id = ".Params::CARABAYAR_ID_BADAK."";
				}else if($jenispasienbadaks[0]=='UMUM'){
					$paramjenispasien = "AND (asuransipasien_m.hubkeluarga not like '%Pekerja%' OR asuransipasien_m.hubkeluarga is null)";
				}
			}
		}else{
				$paramjenispasien = null;
		}
		
		$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
					FROM pasienmorbiditas_t
					JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
					LEFT JOIN asuransipasien_m ON asuransipasien_m.pasien_id = pasienmorbiditas_t.pasien_id
					WHERE ruangan_id = ".Params::RUANGAN_ID_KLINIK_MCU." AND kelompokdiagnosa_id=".Params::KELOMPOKDIAGNOSA_UTAMA." AND DATE(tglmorbiditas) BETWEEN '$tgl_awal' AND '$tgl_akhir' ".$paramjenispasien."
					GROUP BY diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
					ORDER BY jumlah DESC";
		
		//=== start map ===
		
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
		$latitude = null;
		$longitude = null;
		//=== end map ===
		
		$this->render('_map',array(
					'dataMap'=>$dataMap,
					'latitude'=>$latitude,
					'longitude'=>$longitude,
					'tgl_awal'=>$tgl_awal,
					'tgl_akhir'=>$tgl_akhir
		));
	}
	
	public function actionSetPasien(){
        if(Yii::app()->request->isAjaxRequest){
            $data = array();
            $diagnosa_id = (isset($_POST['diagnosa_id']) ? $_POST['diagnosa_id'] : null);
			$tgl_awal = $_POST['tgl_awal'];
			$tgl_akhir = $_POST['tgl_akhir'];
            $dataMap = array();
            if(!empty($diagnosa_id)){
			//=== start map ===
			$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama, pasien_m.pasien_id, pasien_m.nama_pasien, pasien_m.garis_latitude, pasien_m.garis_longitude, pasien_m.alamat_pasien
					FROM pasienmorbiditas_t
					JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
					LEFT JOIN asuransipasien_m ON asuransipasien_m.pasien_id = pasienmorbiditas_t.pasien_id
					LEFT JOIN pasien_m ON pasien_m.pasien_id = pasienmorbiditas_t.pasien_id
					WHERE ruangan_id = ".Params::RUANGAN_ID_KLINIK_MCU." AND kelompokdiagnosa_id=".Params::KELOMPOKDIAGNOSA_UTAMA." AND DATE(tglmorbiditas) BETWEEN '$tgl_awal' AND '$tgl_akhir'
					AND diagnosa_m.diagnosa_id = $diagnosa_id
					GROUP BY diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama, pasien_m.pasien_id, pasien_m.nama_pasien, pasien_m.garis_latitude, pasien_m.garis_longitude, pasien_m.alamat_pasien";
			$result = Yii::app()->db->createCommand($sql)->queryAll();
			$dataMap = $result;
			//=== end map ===
            }else{
            }
			if(count((array)$dataMap) > 0){
				foreach($dataMap as $i=>$map){
					$data[$i]['latitude'] = $map['garis_latitude'];
					$data[$i]['longitude'] = $map['garis_longitude'];
					$data[$i]['pasien_id'] = $map['pasien_id'];
					$data[$i]['nama_pasien'] = $map['nama_pasien'];
					$data[$i]['alamat_pasien'] = $map['alamat_pasien'];
					$data[$i]['diagnosa_id'] = $map['diagnosa_id'];
				}
			}
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
	
	public function actionPrint() {
		$this->layout = '//layouts/printWindows';
		$format = new MyFormatter();
		
		$tgl_awal = $_GET['tgl_awal'];
		$tgl_akhir = $_GET['tgl_akhir'];
		//=== start map ===
		$sql = "SELECT pendaftaran_t.penjamin_id, penjaminpasien_m.penjamin_nama
				FROM permintaanmcu_t 
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = permintaanmcu_t.pendaftaran_id
				JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				WHERE DATE(tgl_pendaftaran) BETWEEN '$tgl_awal' AND '$tgl_akhir'
				GROUP BY pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama
				ORDER BY penjaminpasien_m.penjamin_nama ASC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
		$latitude = null;
		$longitude = null;
		//=== end map ===
		$this->render('_printMap',array(
					'dataMap'=>$dataMap,
					'latitude'=>$latitude,
					'longitude'=>$longitude,
					'tgl_awal'=>$tgl_awal,
					'tgl_akhir'=>$tgl_akhir
		));
    }
	
	public function getJumlah($tgl_awal,$tgl_akhir,$penjamin_id) {
		$sql = "SELECT pendaftaran_t.pasien_id,pasien_m.nama_pasien
				FROM permintaanmcu_t 
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = permintaanmcu_t.pendaftaran_id
				JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				WHERE DATE(tgl_pendaftaran) BETWEEN '$tgl_awal' AND '$tgl_akhir' AND pendaftaran_t.penjamin_id = $penjamin_id
				GROUP BY pendaftaran_t.pasien_id,pasien_m.nama_pasien";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		return count((array)$result);
	}
	
		}
