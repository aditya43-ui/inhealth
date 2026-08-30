<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardLabPAController extends ModuleDashboardNeonController
{
    public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
	public function actionIndex()
	{
        $this->render('index');
	}
	
	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
    public function actionSetIFrameDashboard(){

        $this->layout= '//layouts/iframeNeon';
        $format = new MyFormatter();
		//=== start 4 kolom ===
		$dataKolom = array();
		$dataAreaChart = array();
		$dataLineChart = array();
		$dataDonutChart = array();
		$dataPieChart = array();
		$dataBarChart = array();
		
        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pasienmasukpenunjang_v
                WHERE DATE(tglmasukpenunjang) = '".date('Y-m-d')."' and instalasiasal_id IN (".implode(',',Params::grupInstalasiRJID()).") and ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[1] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pasienmasukpenunjang_v
                WHERE DATE(tglmasukpenunjang) = '".date('Y-m-d')."' and instalasiasal_id IN (".implode(',',Params::grupInstalasiRIID()).") and ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[2] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pasienmasukpenunjang_v
                WHERE DATE(tglmasukpenunjang) = '".date('Y-m-d')."' and instalasiasal_id = ".Params::INSTALASI_ID_RD."  and ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'  ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[3] = $result['jumlah'];

        $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pasienmasukpenunjang_v
                WHERE DATE(tglmasukpenunjang) = '".date('Y-m-d')."' and instalasiasal_id = ".Yii::app()->user->getState('instalasi_id')."   and ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[4] = $result['jumlah'];
		
		//=== end 4 kolom ===
		
		//=== chart ===
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA."
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_1
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND kunjungan = '".Params::STATUSKUNJUNGAN_BARU."'
                    AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA."
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_2
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND kunjungan = '".Params::STATUSKUNJUNGAN_LAMA."'
                    AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA."
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
        $dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'tgl_pendaftaran');
		$dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tgl_pendaftaran');
		
		$sql = "SELECT penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
                AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA."
				GROUP BY penjamin_nama
				ORDER BY penjamin_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataDonutChart = $result;
		
//		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
//				FROM pasienmasukpenunjang_v
//				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
//                AND instalasi_id = ".Params::INSTALASI_ID_LAB."
//				GROUP BY carabayar_nama
//				ORDER BY carabayar_nama ASC";
		$sql = "
				SELECT 
				penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND penjamin_id IN (".Params::PENJAMIN_ID_PISA.",".Params::PENJAMIN_ID_PROKESPEN.") 
				AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA."
				GROUP BY penjamin_id, penjamin_nama
				UNION
				SELECT 
				'Lainnya'::CHARACTER VARYING(50) AS penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND penjamin_id NOT IN (".Params::PENJAMIN_ID_PISA.",".Params::PENJAMIN_ID_PROKESPEN.") 
				AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA."
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

		$sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA." AND instalasiasal_id <> ".Params::INSTALASI_ID_LAB_PA;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[5] = $result['jumlah'];
		
		$sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA." AND instalasiasal_id = ".Params::INSTALASI_ID_LAB_PA;
		$result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataKolom[6] = $result['jumlah'];
		
		
		
		$sql = "SELECT jeniskasuspenyakit_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
					AND instalasi_id = ".Params::INSTALASI_ID_LAB_PA."
				GROUP BY jeniskasuspenyakit_nama
				ORDER BY jeniskasuspenyakit_nama ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LBPendaftaranMp::model()->findAll($criteria_updatepasien);
		
		
		$dataTable = new LBPasienMasukPenunjangV("searchPemeriksaan");
		
		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE date_part('year',tgl_pendaftaran) = '".date('Y')."'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		//=== end map ===
		
		$this->render('dashboard',array(
                    'dataKolom'=>$dataKolom,
                    'dataAreaChart'=>$dataAreaChart,
                    'dataLineChart'=>$dataLineChart,
                    'dataDonutChart'=>$dataDonutChart,
                    'dataPieChart'=>$dataPieChart,
                    'dataBarChart'=>$dataBarChart,
					'dataTable'=>$dataTable,
					'modTodolist'=>$modTodolist,
					'dataProviderTodolist'=>$dataProviderTodolist,
					'dataMap'=>$dataMap,
		));

    }
}
?>