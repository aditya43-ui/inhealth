<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardAGController extends ModuleDashboardNeonController {

	public function actionIndex() {
		$this->layout = '//layouts/mainNeonSidebar';
		$this->pageTitle = Yii::app()->name . " - Dashboard Anggaran";
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

		$sql = "SELECT COUNT(alokasianggaran_id) AS jumlah
				FROM alokasianggaran_t
				WHERE DATE(tglalokasianggaran) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];

		$sql = "SELECT COUNT(rencanggaranpeng_id) AS jumlah
				FROM rencanggaranpeng_t
				WHERE DATE(rencanggaranpeng_tgl) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];

		$sql = "SELECT COUNT(renanggpenerimaan_id) AS jumlah
				FROM renanggpenerimaan_t
				WHERE DATE(tglrenanggaranpen) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];

		$sql = "SELECT COUNT(realisasianggpenerimaan_id) AS jumlah
				FROM realisasianggpenerimaan_t
				WHERE DATE(tglrealisasianggpen) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

		//=== end 4 kolom ===
		//=== chart ===
		$sql = "SELECT DATE(rencanggaranpeng_tgl) as tgl, count(rencanggaranpeng_id) as jumlah_1
				FROM rencanggaranpeng_t
				WHERE DATE(rencanggaranpeng_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(rencanggaranpeng_tgl)
				ORDER BY tgl ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglrenanggaranpen) as tgl, count(renanggpenerimaan_id) as jumlah_2
				FROM renanggpenerimaan_t
				WHERE DATE(tglrenanggaranpen) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglrenanggaranpen)
				ORDER BY tgl ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tgl');
		//=== chart ===
		$sql = "SELECT DATE(rencanggaranpeng_tgl) as tgl, count(rencanggaranpeng_id) as jumlah_1
				FROM rencanggaranpeng_t
				WHERE DATE(rencanggaranpeng_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(rencanggaranpeng_tgl)
				ORDER BY tgl ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglrenanggaranpen) as tgl, count(renanggpenerimaan_id) as jumlah_2
				FROM renanggpenerimaan_t
				WHERE DATE(tglrenanggaranpen) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglrenanggaranpen)
				ORDER BY tgl ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		
		$dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tgl');

		//=== chart ===
		$sql = "SELECT count(realisasianggpenerimaan_id) as jumlah_1
				FROM realisasianggpenerimaan_t
				WHERE DATE(tglrealisasianggpen) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(realisasianggpeng_id) as jumlah_2
				FROM realisasianggpeng_t
				WHERE DATE(tglrealisasianggaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($result_1 as $AGPen) {
			$tempAGPen['label'] = "Realisasi Anggaran Penerimaan";
			$tempAGPen['jumlah'] = $AGPen['jumlah_1'];
			array_push($dataDonutChart, $tempAGPen);
		}
		foreach ($result_2 as $AGPeng) {
			$tempAGPeng['label'] = "Realisasi Anggaran Pengeluaran";
			$tempAGPeng['jumlah'] = $AGPeng['jumlah_2'];
			array_push($dataDonutChart, $tempAGPeng);
		}

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
				SELECT unitkerja_m.namaunitkerja as namaunitkerja, count(realisasianggpeng_t.realisasianggpeng_id) as jumlah
				FROM realisasianggpeng_t
				JOIN unitkerja_m ON realisasianggpeng_t.unitkerja_id = unitkerja_m.unitkerja_id
				WHERE DATE(realisasianggpeng_t.tglrealisasianggaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'		
				GROUP BY namaunitkerja
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataPieChart = $result;

		$sql = "SELECT COUNT(realisasianggpenerimaan_id) AS jumlah
				FROM realisasianggpenerimaan_t
				WHERE DATE(tglrealisasianggpen) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];

		$sql = "SELECT COUNT(realisasianggpeng_id) AS jumlah
				FROM realisasianggpeng_t
				WHERE DATE(tglrealisasianggaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];

		$sql = "SELECT count(renanggpenerimaan_id) as jumlah_1
				FROM renanggpenerimaan_t
				WHERE DATE(tglrenanggaranpen) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(realisasianggpenerimaan_id) as jumlah_2
				FROM realisasianggpenerimaan_t
				WHERE DATE(tglrealisasianggpen) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(rencanggaranpeng_id) as jumlah_3
				FROM rencanggaranpeng_t
				WHERE DATE(rencanggaranpeng_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				";
		$result_3 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count(realisasianggpeng_id) as jumlah_4
				FROM realisasianggpeng_t
				WHERE DATE(tglrealisasianggaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result_4 = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($result_1 as $AGRPen) {
			$tempAGRPen['label'] = "Rencana Anggaran Penerimaan";
			$tempAGRPen['jumlah'] = $AGRPen['jumlah_1'];
			array_push($dataBarChart, $tempAGRPen);
		}
		foreach ($result_2 as $AGPen) {
			$tempAGPen['label'] = "Realisasi Anggaran Penerimaan";
			$tempAGPen['jumlah'] = $AGPen['jumlah_2'];
			array_push($dataBarChart, $tempAGPen);
		}
		foreach ($result_3 as $AGRPeng) {
			$tempAGRPeng['label'] = "Rencana Anggaran Pengeluaran";
			$tempAGRPeng['jumlah'] = $AGRPeng['jumlah_3'];
			array_push($dataBarChart, $tempAGRPeng);
		}
		foreach ($result_4 as $AGPeng) {
			$tempAGPeng['label'] = "Realisasi Anggaran Pengeluaran";
			$tempAGPeng['jumlah'] = $AGPeng['jumlah_4'];
			array_push($dataBarChart, $tempAGPeng);
		}

		//=== end chart ===
		//=== start table ===
		$criteria_updatepasien = new CDbCriteria();
		$criteria_updatepasien->limit = 5;
		$criteria_updatepasien->order = 'tglalokasianggaran DESC';
		$dataTable = AGAlokasianggaranT::model()->findAll($criteria_updatepasien);


		$dataTable = new AGAlokasianggaranT("searchDashboard");

		//=== end table ===
		//=== start todo list ===
		$modTodolist = new AGTodolistR();
		$dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===
		//=== start map ===
		$sql = "SELECT pegawai_id, nama_pegawai, latitude, longitude, garis_latitude, garis_longitude, count(instalasi_id) as jumlah
				FROM pegawairuangan_v
				WHERE instalasi_id = '".Yii::app()->user->getState('instalasi_id')."'
				GROUP BY pegawai_id, nama_pegawai, latitude, longitude, garis_latitude, garis_longitude
				ORDER BY jumlah DESC
				LIMIT 10
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
				$modTodolist = AGTodolistR::model()->findByPk($todolist_id);
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

			$IdTodolist = isset($isi['AGTodolistR']['todolist_id']) ? $isi['AGTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new AGTodolistR;
				$modTodolist->todolist_nama = isset($isi['AGTodolistR']['todolist_nama']) ? $isi['AGTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['AGTodolistR']['todolist_aktif']) ? $isi['AGTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['AGTodolistR']['tgltodolist_new']) ? MyFormatter::formatDateTimeForDb($isi['AGTodolistR']['tgltodolist_new']) : date('Y-m-d');
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
				$modTodolist = AGTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['AGTodolistR']['todolist_nama']) ? $isi['AGTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['AGTodolistR']['todolist_aktif']) ? $isi['AGTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['AGTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['AGTodolistR']['tgltodolist']) : date('Y-m-d');
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

			$IdTodolist = isset($isi['AGTodolistR']['todolist_id']) ? $isi['AGTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new AGTodolistR;
				$modTodolist->todolist_nama = isset($isi['AGTodolistR']['todolist_nama']) ? $isi['AGTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['AGTodolistR']['todolist_aktif']) ? $isi['AGTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['AGTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['AGTodolistR']['tgltodolist']) : date('Y-m-d');
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
				$modTodolist = AGTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['AGTodolistR']['todolist_nama']) ? $isi['AGTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['AGTodolistR']['todolist_aktif']) ? $isi['AGTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['AGTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['AGTodolistR']['tgltodolist']) : date('Y-m-d');
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
				$modTodolist = AGTodolistR::model()->deleteByPk($todolist_id);
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
				$modTodolist = AGTodolistR::model()->findByPk($todolist_id);
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