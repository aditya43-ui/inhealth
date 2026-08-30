<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardHDController extends ModuleDashboardNeonController {

	public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';

	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
	public function actionSetIFrameDashboard() {
                $dataTable = new HDCustomModel();
                $dataTable->tgl_awal = date('Y-m-d');
                
                if (isset($_GET['HDCustomModel'])){
                    $dataTable->attributes = $_GET['HDCustomModel'];
                    $dataTable->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['HDCustomModel']['tgl_awal']);
                }
                
                if (Yii::app()->request->isAjaxRequest){
                    if (isset($_GET['ajax'])){
                        $ajax = $_GET['ajax'];
                        if ($ajax == 'table-grid')
                            $path = 'grid/_water_treatment';
                        
                        $this->renderPartial($path,['dataTable'=>$dataTable]);
                    }
                    Yii::app()->end();
                }
            
                    
                    
                    
		$this->layout = '//layouts/iframeNeon';
		$format = new MyFormatter();
		//=== start 4 kolom ===
		$dataKolom = array();
		$dataAreaChart = array();
		$dataLineChart = array();
		$dataDonutChart = array();
		$dataPieChart = array();
		$dataBarChart = array();

		$sql = "SELECT count (pendaftaran_id) AS jumlah 
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')." 
				AND pasienbatalperiksa_id IS NULL 
				AND date(tgl_pendaftaran)= '" . date('Y-m-d') . "'
				AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];
//		
		$sql = "SELECT count (pasienadmisi_id) AS jumlah FROM pasienadmisi_t 
				WHERE caramasuk_id = ".PARAMS::CARAMASUK_ID_HD."
				AND date(tgladmisi)= '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];
//		
		$sql = "SELECT count (pendaftaran_id) AS jumlah 
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')." 
				AND pasienbatalperiksa_id IS NULL 
				AND date(tgl_pendaftaran)= '" . date('Y-m-d') . "'
				AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
				AND statuspasien = '" . Params::STATUSPASIEN_BARU . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];
		
        $sql = "SELECT count(pendaftaran_t.pendaftaran_id) AS jumlah
				FROM pendaftaran_t
                JOIN rujukan_t ON pendaftaran_t.rujukan_id=rujukan_t.rujukan_id
                WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')." 
				AND pasienbatalperiksa_id IS NULL 
				AND date(tgl_pendaftaran)= '" . date('Y-m-d') . "'
				AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
                AND istraveling IS TRUE";
        
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT count (pendaftaran_id) AS jumlah, DATE(tgl_pendaftaran) AS tgl_pendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL 
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		
		//=== chart ===
		$sql = "SELECT count (pendaftaran_id) AS jumlah_1, DATE(tgl_pendaftaran) AS tgl_pendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL and statuspasien = '".PARAMS::STATUSPASIEN_BARU."'
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT count (pendaftaran_id) AS jumlah_2, DATE(tgl_pendaftaran) AS tgl_pendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL and statuspasien = '".PARAMS::STATUSKUNJUNGAN_LAMA."'
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT count (pendaftaran_id) AS jumlah_3, DATE(tgl_pendaftaran) AS tgl_pendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL and kunjungan = '".PARAMS::STATUSKUNJUNGAN_LAMA."'
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran";
		$result_3 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT count (pendaftaran_id) AS jumlah_4, DATE(tgl_pendaftaran) AS tgl_pendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL and kunjungan = '".PARAMS::STATUSKUNJUNGAN_BARU."'
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran";
		$result_4 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT count (pendaftaran_id) AS jumlah_5, DATE(tgl_pendaftaran) AS tgl_pendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL  AND statusmasuk = '".PARAMS::STATUSMASUK_RUJUKAN."'
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran";
		$result_5 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT count (pendaftaran_id) AS jumlah_6, DATE(tgl_pendaftaran) AS tgl_pendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL  AND statusmasuk = '".PARAMS::STATUSMASUK_NONRUJUKAN."'
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran";
		$result_6 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'tgl_pendaftaran');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tgl_pendaftaran');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'tgl_pendaftaran');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4, 'tgl_pendaftaran');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_5, 'tgl_pendaftaran');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_6, 'tgl_pendaftaran');
		
		$sql = "SELECT count (pendaftaran_id) AS jumlah, keadaanmasuk FROM pendaftaran_t WHERE 
				instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL AND keadaanmasuk IS NOT NULL
				AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY keadaanmasuk";
		
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataDonutChart = $result;
		
		$sql = "SELECT pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,count (pendaftaran_id) AS jumlah 
				FROM pendaftaran_t 
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				WHERE instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND pasienbatalperiksa_id IS NULL AND DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				GROUP BY pendaftaran_t.penjamin_id, penjaminpasien_m.penjamin_nama";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataPieChart = $result;
		
		$sql = "SELECT COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
				FROM pendaftaran_t
				WHERE DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d 23:59:59")."'
				AND pendaftaran_t.pasienbatalperiksa_id is null
				AND pendaftaran_t.no_pendaftaran ILIKE '".Yii::app()->user->getState('instalasi_singkatan')."%'
				AND pendaftaran_t.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
				AND tgl_pendaftaran::time >= '07:00:00' and tgl_pendaftaran::time <= '12:00:00'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];
		
        $sql = "SELECT COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
				FROM pendaftaran_t
				WHERE DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d 23:59:59")."'
				AND pendaftaran_t.pasienbatalperiksa_id is null
				AND pendaftaran_t.no_pendaftaran ILIKE '".Yii::app()->user->getState('instalasi_singkatan')."%'
				AND pendaftaran_t.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
				AND tgl_pendaftaran::time >= '12:00:00' and tgl_pendaftaran::time <= '17:00:00'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];

		$sql = "SELECT diagnosa_m.diagnosa_nama, count(pasienmorbiditas_id) as jumlah 
				FROM pasienmorbiditas_t
				JOIN diagnosa_m ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
				JOIN ruangan_m ON pasienmorbiditas_t.ruangan_id = ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
				WHERE ruangan_m.instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				GROUP BY diagnosa_m.diagnosa_nama
				ORDER BY jumlah desc LIMIT 10";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarChart = $result;
		//=== end chart ===
		
		//=== start table ===
		
		
		
		//=== end table ===
		//=== start todo list ===
		$modTodolist = new PPTodolistR;
		$dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===
		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
				FROM pasienmorbiditas_t
				JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
				JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
				JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN ruangan_m ON pasienmorbiditas_t.ruangan_id = ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
				WHERE ruangan_m.instalasi_id = ".Yii::app()->user->getState('instalasi_id')."
				AND DATE(tglmorbiditas) BETWEEN '" . date('Y-m') . "-01' AND '" . date('Y-m-d') . "'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
				ORDER BY jumlah DESC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
		//=== end map ===

		$this->render('dashboard', 
                array(
			'dataKolom' => $dataKolom,
			'dataAreaChart' => $dataAreaChart,
			'dataLineChart' => $dataLineChart,
			'dataDonutChart' => $dataDonutChart,
			'dataPieChart' => $dataPieChart,
			'dataBarChart' => $dataBarChart,
			'dataTable' => $dataTable,
			'modTodolist' => $modTodolist,
			'dataProviderTodolist' => $dataProviderTodolist,
			'dataMap' => $dataMap,
			'latitude' => $latitude,
			'longitude' => $longitude,
		));
	}

	/**
     * menampilkan data kecamatan berdasarkan diagnosa_id dari ajax
     * @throws CHttpException
     */
    public function actionSetKecamatan(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $data = array();
            $diagnosa_id = (isset($_POST['diagnosa_id']) ? $_POST['diagnosa_id'] : null);
            if(!empty($diagnosa_id)){
				//=== start map ===
				$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
						FROM pasienmorbiditas_t
						JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
						JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
						JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
						WHERE tglmorbiditas BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'  AND diagnosa_m.diagnosa_id = '".$diagnosa_id."'
						GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
						ORDER BY jumlah DESC
						LIMIT 10
						";
				$result = Yii::app()->db->createCommand($sql)->queryAll();
				$dataMap = $result;
				//=== end map ===
            }else{
            }			
			if(count($dataMap) > 0){
				foreach($dataMap as $i=>$map){
					$data[$i]['latitude'] = $map['latitude'];
					$data[$i]['longitude'] = $map['longitude'];
					$data[$i]['kecamatan_nama'] = $map['kecamatan_nama'];
				}
			}
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

}

?>