<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardATController extends ModuleDashboardNeonController {

	public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';

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

		$sql = "SELECT count(praanestesi_id) as jumlah FROM praanestesi_t where date(tglpraanestesi) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];

		$sql = "SELECT count(suratpersetujuantm_id) as jumlah FROM suratpersetujuantm_t where date(tglpersetujuan) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];

		$sql = "SELECT count(intraanestesi_id) as jumlah FROM intraanestesi_t where date(tglintraanestesi) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];

		$sql = "SELECT count(pascaanestesi_id) as jumlah FROM pascaanestesi_t where date(tglpascaanestesi) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

		//=== end 4 kolom ===
		//=== chart ===
		$sql = "SELECT DATE(tglanastesi) as tglanastesi, count(pasienanastesi_id) as jumlah FROM pasienanastesi_t
				WHERE DATE(tglanastesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglanastesi)
				ORDER BY tglanastesi ASC";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;

		$sql = "SELECT DATE(tglanastesi) as tgl, count (pasienanastesi_t.pasienmasukpenunjang_id) AS jumlah_1 
				FROM pasienanastesi_t
				JOIN pasienmasukpenunjang_t ON pasienanastesi_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id          
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id                                         WHERE pendaftaran_t.pasienbatalperiksa_id IS NULL and pasienmasukpenunjang_t.kunjungan = 'KUNJUNGAN LAMA'
				AND DATE(tglanastesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglanastesi)
				ORDER BY tgl ASC";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT DATE(tglanastesi) as tgl, count (pasienanastesi_t.pasienmasukpenunjang_id) AS jumlah_2
				FROM pasienanastesi_t
				JOIN pasienmasukpenunjang_t ON pasienanastesi_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id          
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id                                         WHERE pendaftaran_t.pasienbatalperiksa_id IS NULL and pasienmasukpenunjang_t.kunjungan = 'KUNJUNGAN BARU'
				AND DATE(tglanastesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglanastesi)
				ORDER BY tgl ASC";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();

		$dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tgl');

		$sql = "SELECT pendaftaran_t.pendaftaran_id,pasienmasukpenunjang_t.pasienmasukpenunjang_id, pendaftaran_t.penjamin_id,				  penjaminpasien_m.penjamin_nama,count (pasienanastesi_t.pasienanastesi_id) AS jumlah 
				FROM pasienanastesi_t
				JOIN pasienmasukpenunjang_t ON pasienanastesi_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
				JOIN pendaftaran_t ON pasienanastesi_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
				JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
				JOIN ruangan_m ON pasienanastesi_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . Params::INSTALASI_ID_ANESTESI . "
				AND DATE(tglanastesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY pendaftaran_t.pendaftaran_id,pasienmasukpenunjang_t.pasienmasukpenunjang_id, pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataDonutChart = $result;

		$sql = "SELECT count(tindakananestesi_id) as jumlah, anastesi_m.anastesi_nama FROM tindakananestesi_t 
				JOIN anastesi_m ON tindakananestesi_t.anastesi_id = anastesi_m.anastesi_id
				WHERE date(tgl_tindakananestesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY anastesi_m.anastesi_nama
				ORDER BY jumlah desc";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataPieChart = $result;

		$sql = "SELECT count(intraanestesi_id) as jumlah FROM intraanestesi_t 
				WHERE date(tglintraanestesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "' 
				";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];

		$sql = "SELECT count(intraanestesi_id) as jumlah FROM intraanestesi_t 
				WHERE date(tglintraanestesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				and isdarurat = 'TRUE'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];


		$sql = "SELECT count(pasienanastesi_id) as jumlah,typeanastesi_m.typeanastesi_nama FROM pasienanastesi_t
				JOIN typeanastesi_m ON pasienanastesi_t.typeanastesi_id=typeanastesi_m.typeanastesi_id
				WHERE DATE(tglanastesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY typeanastesi_m.typeanastesi_nama
				ORDER BY jumlah DESC
				LIMIT 6";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarChart = $result;
//		echo '<pre>';print_r($dataBarChart);exit;
		//=== end chart ===
		//=== start table ===		
		$dataTable = new ATPraanestesiT();

		//=== end table ===
		//=== start todo list ===
		$modTodolist = new ATTodolistR;
		$dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===
		//=== start map ===
		$sql = "SELECT count (pasienanastesi_t.pasien_id) AS jumlah, pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,pasien_m.nama_pasien,pasien_m.garis_longitude,pasien_m.garis_latitude,kecamatan_m.longitude, kecamatan_m.latitude
				FROM pasienanastesi_t 
				JOIN pendaftaran_t ON  pasienanastesi_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
				JOIN pasien_m ON pasien_m.pasien_id=pendaftaran_t.pasien_id
				LEFT JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE DATE(tglanastesi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,pasien_m.nama_pasien,pasien_m.garis_longitude,pasien_m.garis_latitude,kecamatan_m.longitude, kecamatan_m.latitude
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;

		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = isset($modPropinsi->latitude)? $modPropinsi->latitude : null;
		$longitude = isset($modPropinsi->longitude)? $modPropinsi->longitude : null;
		//=== end map ===

		$this->render('dashboard', array(
			'dataKolom'				 => $dataKolom,
			'dataAreaChart'			 => $dataAreaChart,
			'dataLineChart'			 => $dataLineChart,
			'dataDonutChart'		 => $dataDonutChart,
			'dataPieChart'			 => $dataPieChart,
			'dataBarChart'			 => $dataBarChart,
			'dataTable'				 => $dataTable,
			'modTodolist'			 => $modTodolist,
			'dataProviderTodolist'	 => $dataProviderTodolist,
			'dataMap'				 => $dataMap,
			'modPropinsi'			 => $modPropinsi,
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
				$modTodolist = ATTodolistR::model()->findByPk($todolist_id);
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

			$IdTodolist = isset($isi['ATTodolistR']['todolist_id']) ? $isi['ATTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new ATTodolistR;
				$modTodolist->todolist_nama = isset($isi['ATTodolistR']['todolist_nama']) ? $isi['ATTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ATTodolistR']['todolist_aktif']) ? $isi['ATTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ATTodolistR']['tgltodolist_new']) ? MyFormatter::formatDateTimeForDb($isi['ATTodolistR']['tgltodolist_new']) : date('Y-m-d');
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
				$modTodolist = ATTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['ATTodolistR']['todolist_nama']) ? $isi['ATTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ATTodolistR']['todolist_aktif']) ? $isi['ATTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ATTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['ATTodolistR']['tgltodolist']) : date('Y-m-d');
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

			$IdTodolist = isset($isi['ATTodolistR']['todolist_id']) ? $isi['ATTodolistR']['todolist_id'] : '';

			if (empty($IdTodolist)) { //antrian baru
				$modTodolist = new ATTodolistR;
				$modTodolist->todolist_nama = isset($isi['ATTodolistR']['todolist_nama']) ? $isi['ATTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ATTodolistR']['todolist_aktif']) ? $isi['ATTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ATTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['ATTodolistR']['tgltodolist']) : date('Y-m-d');
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
				$modTodolist = ATTodolistR::model()->findByPk($IdTodolist);
				$modTodolist->todolist_nama = isset($isi['ATTodolistR']['todolist_nama']) ? $isi['ATTodolistR']['todolist_nama'] : '';
				$modTodolist->todolist_aktif = isset($isi['ATTodolistR']['todolist_aktif']) ? $isi['ATTodolistR']['todolist_aktif'] : true;
				$modTodolist->tgltodolist = isset($isi['ATTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['ATTodolistR']['tgltodolist']) : date('Y-m-d');
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
				$modTodolist = ATTodolistR::model()->deleteByPk($todolist_id);
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
				$modTodolist = ATTodolistR::model()->findByPk($todolist_id);
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