<?php
class PetaPenyebaranPasienController extends MyAuthController
{
	public function actionIndex(){
		$model = new SGPetapenyebaranpasienR();
		$format = new MyFormatter();
		
		$model->jns_periode = "hari";
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
	public function actionSetIframePetaPenyebaranPasien(){

        $this->layout= '//layouts/iframeNeon';
        $format = new MyFormatter();
		$tujuanrender = "_map";
		$jns_periode = $_GET['SGPetapenyebaranpasienR']['jns_periode'];
		$tgl_awal = $format->formatDateTimeForDb($_GET['SGPetapenyebaranpasienR']['tgl_awal']);
		$tgl_akhir = $format->formatDateTimeForDb($_GET['SGPetapenyebaranpasienR']['tgl_akhir']);
		$bln_awal = $format->formatMonthForDb($_GET['SGPetapenyebaranpasienR']['bln_awal']);
		$bln_akhir = $format->formatMonthForDb($_GET['SGPetapenyebaranpasienR']['bln_akhir']);
		$thn_awal = $_GET['SGPetapenyebaranpasienR']['thn_awal'];
		$thn_akhir = $_GET['SGPetapenyebaranpasienR']['thn_akhir'];
		$bln_akhir = $bln_akhir."-".date("t",strtotime($bln_akhir));
		$thn_akhir = $thn_akhir."-".date("m-t",strtotime($thn_akhir."-12"));
		switch($jns_periode){
			case 'bulan' : $tgl_awal = $bln_awal."-01"; $tgl_akhir = $bln_akhir; break;
			case 'tahun' : $tgl_awal = $thn_awal."-01-01"; $tgl_akhir = $thn_akhir; break;
			default : null;
		}
		
		if($_GET['SGPetapenyebaranpasienR']['is_typerumah'] == 1){
			// Jika jenis tempat tinggal di checklist
			$sql = "SELECT pegawaiptb_m.tipe_rumah, COUNT(pasien_id) AS jumlah FROM pasien_m
					JOIN pegawaiptb_m ON pegawaiptb_m.employe_id = pasien_m.pegawai_id
					WHERE DATE(tgl_rekam_medik) BETWEEN '$tgl_awal' AND '$tgl_akhir' 
					GROUP BY pegawaiptb_m.tipe_rumah";
			$tujuanrender = "_mapTipeRumah";
		}else{
			$sql = "SELECT pasien_m.kecamatan_id, kecamatan_nama, COUNT(pasien_id) AS jumlah FROM pasien_m
					JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
					WHERE DATE(tgl_rekam_medik) BETWEEN '$tgl_awal' AND '$tgl_akhir' 
					GROUP BY pasien_m.kecamatan_id, kecamatan_nama
					ORDER BY pasien_m.kecamatan_id";
		}
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
		$latitude = null;
		$longitude = null;
		//=== end map ===
		
		
		$this->render($tujuanrender,array(
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
            $kecamatan_id = (isset($_POST['kecamatan_id']) ? $_POST['kecamatan_id'] : null);
			$tgl_awal = $_POST['tgl_awal'];
			$tgl_akhir = $_POST['tgl_akhir'];
            $dataMap = array();
            if(!empty($kecamatan_id)){
				//=== start map ===
				$sql = "SELECT pasien_id, nama_pasien, alamat_pasien, pasien_m.kecamatan_id, garis_latitude, garis_longitude, COUNT(pasien_id) AS jumlah FROM pasien_m
						JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
						WHERE DATE(tgl_rekam_medik) BETWEEN '$tgl_awal' AND '$tgl_akhir'  AND pasien_m.kecamatan_id = $kecamatan_id
						GROUP BY pasien_id, pasien_m.kecamatan_id
						ORDER BY pasien_m.kecamatan_id";
				$result = Yii::app()->db->createCommand($sql)->queryAll();
				$dataMap = $result;
				//=== end map ===
            }else{
            }
			if(count((array)$dataMap) > 0){
				foreach($dataMap as $i=>$map){
					$data[$i]['pasien_id'] = $map['pasien_id'];
					$data[$i]['latitude'] = $map['garis_latitude'];
					$data[$i]['longitude'] = $map['garis_longitude'];
					$data[$i]['nama_pasien'] = $map['nama_pasien'];
					$data[$i]['alamat_pasien'] = $map['alamat_pasien'];
					$data[$i]['kecamatan_id'] = $map['kecamatan_id'];
				}
			}
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
	
	public function actionSetPasienTipeRumah(){
        if(Yii::app()->request->isAjaxRequest){
            $data = array();
            $tipe_rumah = (isset($_POST['tipe_rumah']) ? $_POST['tipe_rumah'] : null);
			$tgl_awal = $_POST['tgl_awal'];
			$tgl_akhir = $_POST['tgl_akhir'];
            $dataMap = array();
            if(!empty($tipe_rumah)){
				//=== start map ===
				$sql = "SELECT pasien_id, nama_pasien, alamat_pasien, garis_latitude, garis_longitude FROM pasien_m
						JOIN pegawaiptb_m ON pegawaiptb_m.employe_id = pasien_m.pegawai_id
						WHERE DATE(tgl_rekam_medik) BETWEEN '$tgl_awal' AND '$tgl_akhir'  AND pegawaiptb_m.tipe_rumah = '$tipe_rumah'
						GROUP BY pasien_id, nama_pasien, alamat_pasien, garis_latitude, garis_longitude";
				
				$result = Yii::app()->db->createCommand($sql)->queryAll();
				$dataMap = $result;
				//=== end map ===
            }else{
            }
			if(count((array)$dataMap) > 0){
				foreach($dataMap as $i=>$map){
					$data[$i]['pasien_id'] = $map['pasien_id'];
					$data[$i]['latitude'] = $map['garis_latitude'];
					$data[$i]['longitude'] = $map['garis_longitude'];
					$data[$i]['nama_pasien'] = $map['nama_pasien'];
					$data[$i]['alamat_pasien'] = $map['alamat_pasien'];
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
		$sql = "SELECT pasien_id, nama_pasien, alamat_pasien, pasien_m.kecamatan_id, garis_latitude, garis_longitude, COUNT(pasien_id) AS jumlah FROM pasien_m
				JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
				WHERE DATE(tgl_rekam_medik) BETWEEN '$tgl_awal' AND '$tgl_akhir'
				GROUP BY pasien_id, pasien_m.kecamatan_id
				ORDER BY pasien_m.kecamatan_id";
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
	
}
