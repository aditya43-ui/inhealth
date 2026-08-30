<?php
class PetaPenyebaranPenyakitController extends MyAuthController
{
	public function actionIndex(){
		$model = new SGPetapenyebaranpenyakitR();
		$modDiagnosa = new SGDiagnosaM();
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
		
        $this->render('index',array('model'=>$model,'format'=>$format,'modDiagnosa'=>$modDiagnosa));
	}
	
	// Menampilakan frame map
	// Menggunakan DAO agar proses eksekusi db lebih mulus
	public function actionSetIframePetaPenyebaranPenyakit(){

        $this->layout= '//layouts/iframeNeon';
		$post_tgl = $this->SetTanggal($_GET);
		$ada_tiperumah = false;
		$ada_diagnosa = false;
		$diagnosa_id_terpilih = null;
		$dataPost = $_GET['SGDiagnosaM'];
		$tiperumah_param = null;
		$tiperumah_join = null;
		$tiperumah_where = null;
		
		foreach($dataPost as $i => $foo){
			if($foo['diagnosa_id'] == null){
				unset($dataPost[$i]);
			}
		}
		
		if(!empty($_GET['SGPetapenyebaranpenyakitR']['typerumah'])){
			$ada_tiperumah = true;
			foreach($_GET['SGPetapenyebaranpenyakitR']['typerumah'] as $iii => $detailtyperumah){
				$tiperumah_param .= "'".$detailtyperumah."'";
				if($iii+1 != count((array)$_GET['SGPetapenyebaranpenyakitR']['typerumah'])){
					$tiperumah_param .= ",";
				}
				$iii++;
			}
			$tiperumah_join = "JOIN pasien_m ON pasien_m.pasien_id = pasienmorbiditas_t.pasien_id JOIN pegawaiptb_m ON pegawaiptb_m.employe_id = pasien_m.pegawai_id";
			$tiperumah_where = "AND tipe_rumah IN ($tiperumah_param)";
		}
		
		if(!empty($dataPost)){
			$ada_diagnosa = true;
			$ii = 1;
			foreach($dataPost as $key => $detail){
				if($detail['diagnosa_id']!=null){
					$diagnosa_id_terpilih .= $detail['diagnosa_id'];
					if($ii != count((array)$dataPost)){
						$diagnosa_id_terpilih .= ",";
					}
					$ii++;
				}
			}
			// Jika pencarian pake diagnosa
			$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
					FROM pasienmorbiditas_t
					JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
					$tiperumah_join
					WHERE DATE(tglmorbiditas) BETWEEN '$post_tgl[tgl_awal]' AND '$post_tgl[tgl_akhir]' AND diagnosa_m.diagnosa_id IN ($diagnosa_id_terpilih) $tiperumah_where
					GROUP BY diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
					ORDER BY jumlah DESC
					";
		}else{
			// Jika pencarian tidak pake diagnosa
			$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
					FROM pasienmorbiditas_t
					JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
					$tiperumah_join
					WHERE DATE(tglmorbiditas) BETWEEN '$post_tgl[tgl_awal]' AND '$post_tgl[tgl_akhir]' $tiperumah_where
					GROUP BY diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
					ORDER BY jumlah DESC
					LIMIT 10";
		}
		
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
					'tgl_awal'=>$post_tgl['tgl_awal'],
					'tgl_akhir'=>$post_tgl['tgl_akhir'],
					'ada_diagnosa'=>$ada_diagnosa,
					'ada_tiperumah'=>$ada_tiperumah,
					'tiperumah_param'=>$tiperumah_param
		));
	}
	
	public function actionSetPasien(){
        if(Yii::app()->request->isAjaxRequest){
            $data = array();
            $diagnosa_id = (isset($_POST['diagnosa_id']) ? $_POST['diagnosa_id'] : null);
            $ada_tiperumah = (isset($_POST['ada_tiperumah']) ? $_POST['ada_tiperumah'] : null);
			$tgl_awal = $_POST['tgl_awal'];
			$tgl_akhir = $_POST['tgl_akhir'];
			$tiperumah_join = null;
			
			if($ada_tiperumah == '1'){
				$tiperumah_join = "JOIN pegawaiptb_m ON pegawaiptb_m.employe_id = pasien_m.pegawai_id";
			}
			$dataMap = array();
            if(!empty($diagnosa_id)){
				//=== start map ===
				$sql = "SELECT pasien_m.pasien_id, pasien_m.nama_pasien,alamat_pasien, pasien_m.garis_longitude, pasien_m.garis_latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
						FROM pasienmorbiditas_t
						JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
						JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
						$tiperumah_join
						WHERE DATE(tglmorbiditas) BETWEEN '$tgl_awal' AND '$tgl_akhir' AND diagnosa_m.diagnosa_id = ".$diagnosa_id."
						GROUP BY pasien_m.pasien_id, pasien_m.nama_pasien,alamat_pasien, pasien_m.garis_longitude, pasien_m.garis_latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
						ORDER BY jumlah DESC
						";
				$result = Yii::app()->db->createCommand($sql)->queryAll();
				$dataMap = $result;
				//=== end map ===
            }else{
            }
			if(count((array)$dataMap) > 0){
				foreach($dataMap as $i=>$map){
					$data[$i]['latitude'] = $map['garis_latitude'];
					$data[$i]['longitude'] = $map['garis_longitude'];
					$data[$i]['nama_pasien'] = $map['nama_pasien'];
					$data[$i]['alamat_pasien'] = $map['alamat_pasien'];
					$data[$i]['diagnosa_kode'] = $map['diagnosa_kode'];
					$data[$i]['diagnosa_nama'] = $map['diagnosa_nama'];
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
		$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
				FROM pasienmorbiditas_t
				JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
				WHERE DATE(tglmorbiditas) BETWEEN '$tgl_awal' AND '$tgl_akhir'
				GROUP BY diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
				ORDER BY jumlah DESC
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
	
	public function actionGetDiagnosaPasienForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
			parse_str($_POST['data'], $post);
			$post_tgl = $this->SetTanggal($post);
			$sql = "SELECT diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
					FROM pasienmorbiditas_t
					JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
					WHERE DATE(tglmorbiditas) BETWEEN '$post_tgl[tgl_awal]' AND '$post_tgl[tgl_akhir]'
					GROUP BY diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
					ORDER BY jumlah DESC
					LIMIT 10
					";
			$result = Yii::app()->db->createCommand($sql)->queryAll();
			echo "<pre>";
			print_r($result);
			exit;
        }
        Yii::app()->end();
    }
	
	public function SetTanggal($post){
		$format = new MyFormatter();
		$jns_periode = $post['SGPetapenyebaranpenyakitR']['jns_periode'];
		$tgl_awal = $format->formatDateTimeForDb($post['SGPetapenyebaranpenyakitR']['tgl_awal']);
		$tgl_akhir = $format->formatDateTimeForDb($post['SGPetapenyebaranpenyakitR']['tgl_akhir']);
		$bln_awal = $format->formatMonthForDb($post['SGPetapenyebaranpenyakitR']['bln_awal']);
		$bln_akhir = $format->formatMonthForDb($post['SGPetapenyebaranpenyakitR']['bln_akhir']);
		$thn_awal = $post['SGPetapenyebaranpenyakitR']['thn_awal'];
		$thn_akhir = $post['SGPetapenyebaranpenyakitR']['thn_akhir'];
		$bln_akhir = $bln_akhir."-".date("t",strtotime($bln_akhir));
		$thn_akhir = $thn_akhir."-".date("m-t",strtotime($thn_akhir."-12"));
		switch($jns_periode){
			case 'bulan' : $tgl_awal = $bln_awal."-01"; $tgl_akhir = $bln_akhir; break;
			case 'tahun' : $tgl_awal = $thn_awal."-01-01"; $tgl_akhir = $thn_akhir; break;
			default : null;
		}
		$result['tgl_awal'] = $tgl_awal;
		$result['tgl_akhir'] = $tgl_akhir;
		return $result;
	}
	
	
}
