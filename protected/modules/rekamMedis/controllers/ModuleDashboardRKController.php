<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");
class ModuleDashboardRKController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Rekam Medis";
    $this->render('index');
  }

  /**
   * menampilkan halaman dashboard (iframe)
   * beberapa menggunakan DAO (createCommand) agar lebih cepat
   */
  public function actionSetIFrameDashboard()
  {

    $this->layout = '//layouts/iframeNeon';
    $format = new MyFormatter();

    // KOLOM BARIS PERTAMA
    $dataKolom = array();
    // Query Kunjungan Pasien Rawat Jalan
    $sql = "SELECT COUNT(pasien_id) AS jumlah
						FROM infokunjunganrj_v
						WHERE DATE(tgl_pendaftaran) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];
    // Query Kunjungan Pasien Rawat Darurat Hari Ini
    $sql = "SELECT COUNT(pasien_id) AS jumlah
						FROM infokunjunganrd_v
						WHERE DATE(tgl_pendaftaran) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];
    // Query Kunjungan Pasien Rawat Inap Hari Ini
    $sql = "SELECT COUNT(pasien_id) AS jumlah
						FROM infokunjunganri_v
						WHERE DATE(tgl_pendaftaran) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];
    // Query Berkas Dokumen Baru Hari Ini
    $sql = "SELECT COUNT(dokrekammedis_id) AS jumlah
						FROM dokrekammedis_m
						WHERE DATE(create_time) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    // AREA CHART
    $sql = "SELECT DATE(tglrekammedis) as tglrekammedis, count(dokrekammedis_id) as jumlah
						FROM dokrekammedis_m
						WHERE DATE(tglrekammedis) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY DATE(tglrekammedis)
						ORDER BY tglrekammedis ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataAreaChart = $result;

    // LINE CHART
    // LINE I
    $sql = "SELECT  DATE(tglpeminjamanrm) as tglpeminjamanrm, count(peminjamanrm_id) as jumlah_1
						FROM peminjamanrm_t
						WHERE DATE(tglpeminjamanrm) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY DATE(tglpeminjamanrm)
						ORDER BY tglpeminjamanrm ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    // LINE 2
    $sql = "SELECT  DATE(tglpengirimanrm) as tglpeminjamanrm, count(pengirimanrm_id) as jumlah_2
						FROM pengirimanrm_t
						WHERE DATE(tglpengirimanrm) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY tglpeminjamanrm
						ORDER BY tglpeminjamanrm ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tglpeminjamanrm');

    // DONUT CHART
    $sql = "SELECT  ruangan_nama, DATE(tglpengirimanrm) as tglpengirimanrm, count(pengirimanrm_id) as jumlah
						FROM pengirimanrm_t JOIN ruangan_m ON pengirimanrm_t.ruangan_id = ruangan_m.ruangan_id
						WHERE DATE(tglpengirimanrm) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY ruangan_nama,tglpengirimanrm
						ORDER BY ruangan_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    // PIE CHART
    //		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
    //						FROM laporankunjunganrs_v
    //						WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
    //						GROUP BY carabayar_nama
    //						ORDER BY carabayar_nama ASC";
    $sql = "
				SELECT 
				penjamin_nama, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				GROUP BY penjamin_id, penjamin_nama
				UNION
				SELECT 
				'Lainnya'::CHARACTER VARYING(50) AS penjamin_nama, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id NOT IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    // KOLOM BARIS KETIGA
    // Query Jumlah Kunjungan Baru
    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
						FROM laporankunjunganrs_v 
						WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND LOWER(kunjungan) = '" . strtolower(Params::STATUSKUNJUNGAN_BARU) . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];
    // Query Jumlah Kunjungan Lama
    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
						FROM laporankunjunganrs_v
						WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND LOWER(kunjungan) = '" . strtolower(Params::STATUSKUNJUNGAN_LAMA) . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];

    // BAR CHART
    $sql = "SELECT  diagnosa_nama, count(pasienmorbiditas_id) as jumlah
						FROM laporan10besarpenyakit_v
						WHERE DATE(tglmorbiditas) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY diagnosa_nama
						ORDER BY jumlah DESC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;

    // TABEL
    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 10;
    $criteria_updatepasien->order = 'tglrekammedis DESC';
    $dataTable = RKDokrekammedisM::model()->findAll($criteria_updatepasien);
    $dataTable = new RKDokrekammedisM();

    // MAP 
    $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama as kabupaten_nama,kabupaten_m.longitude as logitude_kab, kabupaten_m.latitude as latitude_kab,  kecamatan_m.longitude, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				JOIN kecamatan_m ON laporankunjunganrs_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON laporankunjunganrs_v.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama, logitude_kab, latitude_kab,kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataMap = $result;

    // TO DO LIST
    $modTodolist = new PPTodolistR();
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();

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
    ));
  }

  public function actionSetKabupaten() {
    if (Yii::app()->request->isAjaxRequest) {
        $data = array();
        $kabupaten = (isset($_POST['kabupaten']) ? trim($_POST['kabupaten']) : null);

        $criteria = new CDbCriteria();
        $criteria->select = "kecamatan_m.kecamatan_nama,kabupaten_m.kabupaten_nama as kabupaten_nama,kabupaten_m.longitude as logitude_kab, kabupaten_m.latitude as latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude,  count(pendaftaran_id) as jumlah";
        $criteria->join = 'JOIN kecamatan_m ON laporankunjunganrs_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON laporankunjunganrs_v.kabupaten_id = kabupaten_m.kabupaten_id';
        $criteria->group = "kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude,kabupaten_m.kabupaten_nama,logitude_kab, latitude_kab";
        $criteria->compare('LOWER(kabupaten_m.kabupaten_nama)', strtolower($kabupaten), true);

        $model = LaporankunjunganrsV::model()->findAll($criteria);

        $pas = array();
        if (count($model) > 0) {
            foreach ($model as $i => $map) {
                if ($map['latitude'] != '' && $map['latitude'] != '') {
                    $pas[$i]['latitude'] = $map->latitude;
                    $pas[$i]['longitude'] = $map->longitude;
                    $pas[$i]['kecamatan_nama'] = $map->kecamatan_nama;
                    $pas[$i]['jumlah'] = $map->jmlstatuscovid;
                }
            }

            $data['pasien'] = count($pas);
            $data['loadpasien'] = $pas;
        } else {
            $data['pasien'] = 0;
            $data['loadpasien'] = array();
        }

        echo CJSON::encode($data);
        Yii::app()->end();
    } else
        throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
}

}
