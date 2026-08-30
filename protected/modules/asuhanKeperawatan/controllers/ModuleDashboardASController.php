<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardASController extends ModuleDashboardNeonController {

	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
	public function actionSetIFrameDashboard() {

		$this->layout = '//layouts/iframeNeon';
		$format = new MyFormatter();
		//=== start 4 kolom ===
		$dataKolom = array();
		$dataAreaChart = array();
		$dataLineChart = array();
		$dataDonutChart = array();
		$dataPieChart = array();
		$dataBarChart = array();
		
		$sql = "SELECT count(pengkajianaskep_id) as jumlah 
				FROM pengkajianaskep_t 
				WHERE date(pengkajianaskep_tgl) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];

		$sql = "SELECT count(rencanaaskep_id) as jumlah 
				FROM rencanaaskep_t 
				WHERE date(rencanaaskep_tgl) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];

		$sql = "SELECT count(implementasiaskep_id) as jumlah 
				FROM implementasiaskep_t 
				WHERE date(implementasiaskep_tgl) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];

		$sql = "SELECT count(evaluasiaskep_id) as jumlah 
				FROM evaluasiaskep_t 
				WHERE date(evaluasiaskep_tgl) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

		//=== end 4 kolom ===
		//=== chart ===
		$sql = "SELECT count(rencanaaskep_id) as jumlah, DATE(rencanaaskep_tgl) as tgl
				FROM rencanaaskep_t 
				WHERE DATE(rencanaaskep_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(rencanaaskep_tgl)
				ORDER BY tgl ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT count(implementasiaskep_id) as jumlah_1 , DATE(implementasiaskep_tgl) as tgl
				FROM implementasiaskep_t 
				WHERE date (implementasiaskep_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(implementasiaskep_tgl)
				ORDER BY tgl ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(rencanaaskep_id) as jumlah_2 , DATE(rencanaaskep_tgl) as tgl
				FROM rencanaaskep_t 
				WHERE date(rencanaaskep_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(rencanaaskep_tgl)
				ORDER BY tgl ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tgl');

		//=== chart ===
		$sql = "SELECT count(evaluasiaskep_id) as jumlah
				FROM evaluasiaskep_t 
				WHERE date(evaluasiaskep_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataDonutChart = $result;
		
//		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
//				FROM laporankunjunganrs_v
//				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
//					AND (
//						instalasi_id = ".Params::INSTALASI_ID_RJ."
//						OR instalasi_id = ".Params::INSTALASI_ID_RD."
//						OR instalasi_id = ".Params::INSTALASI_ID_RI."
//					)
//				GROUP BY carabayar_nama
//				ORDER BY carabayar_nama ASC";
		// LNG-1
		$sql = "
				SELECT count(implementasiaskepdet_t.diagnosakep_id) as jumlah,diagnosakep_m.diagnosakep_nama 
				FROM implementasiaskepdet_t 
				JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id=implementasiaskepdet_t.diagnosakep_id
				GROUP BY diagnosakep_m.diagnosakep_nama
				ORDER BY jumlah desc
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataPieChart = $result;

		$sql = "SELECT count(pengkajianaskep_id) as jumlah 
				FROM pengkajianaskep_t 
				WHERE date(pengkajianaskep_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];

		$sql = "SELECT count(rencanaaskep_id) as jumlah 
				FROM rencanaaskep_t 
				WHERE date(rencanaaskep_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];

		$sql = "SELECT count(rencanaaskepdet_t.diagnosakep_id) as jumlah,diagnosakep_m.diagnosakep_nama 
				FROM rencanaaskepdet_t 
				JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id=rencanaaskepdet_t.diagnosakep_id
				GROUP BY diagnosakep_m.diagnosakep_nama
				ORDER BY jumlah desc";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarChart = $result;

		//=== end chart ===
		//=== start table ===
		$dataTable = new ASRencanaaskepT("searchDashboardAS");

		//=== end table ===
		//=== start todo list ===
		$modTodolist = new ASTodolistR();
		$dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===
		//=== start map ===
		$sql = "SELECT count (pendaftaran_t.pegawai_id) AS jumlah, pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,pasien_m.nama_pasien,pasien_m.garis_longitude,pasien_m.garis_latitude,kecamatan_m.longitude, kecamatan_m.latitude
				FROM pengkajianaskep_t
				JOIN pendaftaran_t ON  pendaftaran_t.pendaftaran_id=pengkajianaskep_t.pendaftaran_id                                                                                                                                                               
				JOIN pasien_m ON pasien_m.pasien_id=pendaftaran_t.pasien_id
				LEFT JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
                WHERE date(pendaftaran_t.tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,pasien_m.nama_pasien,pasien_m.garis_longitude,pasien_m.garis_latitude,kecamatan_m.longitude, kecamatan_m.latitude
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		//=== end map ===

		$this->render('dashboard', array(
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
			'modPropinsi' => $modPropinsi,
		));
	}

	/**
	 * menampilkan form antrian dari request ajax
	 * @param type $record
	 * @param type $noantrian
	 * @throws CHttpException
	 */
	public function actionSetFormTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			$data = array();
			$data['pesan'] = "";
			$todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
			if (!empty($todolist_id)) { //antrian baru
				$modTodolist = ASTodolistR::model()->findByPk($todolist_id);
			} else {
				$data['pesan'] = 'tidak ditemukan';
			}
			$data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * menyimpan data todolist by ajax
	 * @throws CHttpException
	 */
	public function actionSimpanTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			parse_str($_POST['isi'], $isi);

			$data = array();
			$data['pesan'] = "";



			// echo "<pre>"; print_r($isi['PPTodolistR']['todolist_id']);exit();

			$IdTodolist = isset($isi['ASTodolistR']['todolist_id']) ? $isi['ASTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new ASTodolistR;
				$modTodolist->todolist_nama = isset($isi['ASTodolistR']['todolist_nama']) ? $isi['ASTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ASTodolistR']['todolist_aktif']) ? $isi['ASTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ASTodolistR']['tgltodolist_new']) ? MyFormatter::formatDateTimeForDb($isi['ASTodolistR']['tgltodolist_new']) : date('Y-m-d');
				$modTodolist->create_time = date('Y-m-d');
				$modTodolist->create_loginpemakai_id = Yii::app()->user->id;
				$modTodolist->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
				$modTodolist->create_modul_id = Yii::app()->session['modul_id'];
				$simpan = $modTodolist->save();
				if ($simpan) {
					$data['pesan'] = 'Todolist Berhasil Disimpan!';
				} else {
					$data['pesan'] = 'Todolist Gagal Disimpan!';
				}
			} else {
				$modTodolist = ASTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['ASTodolistR']['todolist_nama']) ? $isi['ASTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ASTodolistR']['todolist_aktif']) ? $isi['ASTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ASTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['ASTodolistR']['tgltodolist']) : date('Y-m-d');
				$modTodolist->update_time = date('Y-m-d');
				$modTodolist->update_loginpemakai_id = Yii::app()->user->id;

				$update = $modTodolist->update();
				if ($update) {
					$data['pesan'] = 'Todolist Berhasil Diubah!';
				} else {
					$data['pesan'] = 'Todolist Gagal Diubah!';
				}
			}
			$data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * update by ajax
	 * @throws CHttpException
	 */
	public function actionUpdateTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			parse_str($_POST['isi'], $isi);

			$data = array();
			$data['pesan'] = "";

			$IdTodolist = isset($isi['ASTodolistR']['todolist_id']) ? $isi['ASTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new ASTodolistR;
				$modTodolist->todolist_nama = isset($isi['ASTodolistR']['todolist_nama']) ? $isi['ASTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ASTodolistR']['todolist_aktif']) ? $isi['ASTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ASTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['ASTodolistR']['tgltodolist']) : date('Y-m-d');
				$modTodolist->create_time = date('Y-m-d');
				$modTodolist->create_loginpemakai_id = Yii::app()->user->id;
				$modTodolist->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
				$modTodolist->create_modul_id = Yii::app()->session['modul_id'];
				$simpan = $modTodolist->save();
				if ($simpan) {
					$data['pesan'] = 'Todolist Berhasil Disimpan!';
				} else {
					$data['pesan'] = 'Todolist Gagal Disimpan!';
				}
			} else {
				$modTodolist = ASTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['ASTodolistR']['todolist_nama']) ? $isi['ASTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ASTodolistR']['todolist_aktif']) ? $isi['ASTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ASTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['ASTodolistR']['tgltodolist']) : date('Y-m-d');
				$modTodolist->update_time = date('Y-m-d');
				$modTodolist->update_loginpemakai_id = Yii::app()->user->id;

				$update = $modTodolist->update();
				if ($update) {
					$data['pesan'] = 'Todolist Berhasil Diubah!';
				} else {
					$data['pesan'] = 'Todolist Gagal Diubah!';
				}
			}
			$data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * hapus todo list ajax dari tombol di widget
	 * @throws CHttpException
	 */
	public function actionHapusTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			$data = array();
			$data['pesan'] = "";
			$todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
			if (!empty($todolist_id)) { //antrian baru
				$modTodolist = ASTodolistR::model()->deleteByPk($todolist_id);
				$data['pesan'] = 'Data Berhasil Dihapus';
			} else {
				$data['pesan'] = 'Data Gagal Dihapus';
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * ubah todolist ajax dari widget
	 * @throws CHttpException
	 */
	public function actionUbahStatusTodolist() {
		if (Yii::app()->request->isAjaxRequest) {
			$data = array();
			$data['pesan'] = "";
			$todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
			if (!empty($todolist_id)) { //antrian baru
				$modTodolist = ASTodolistR::model()->findByPk($todolist_id);
				$modTodolist->todolist_aktif = false;
				$update = $modTodolist->update();
				if ($update) {
					$data['pesan'] = 'Status Todolist Berhasil Diubah!';
				} else {
					$data['pesan'] = 'Status Todolist Gagal Diubah!';
				}
			} else {
				$data['pesan'] = 'Status Todolist Gagal Diubah!';
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

}

?>