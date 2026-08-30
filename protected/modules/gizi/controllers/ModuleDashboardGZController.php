<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardGZController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Modul Gizi";
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
    //=== start 4 kolom ===
    $dataKolom = array();
    $dataAreaChart = array();
    $dataLineChart = array();
    $dataDonutChart = array();
    $dataPieChart = array();
    $dataBarChart = array();

    $sql = "SELECT COUNT(pesanmenudiet_id) AS jumlah
				FROM pesanmenudiet_t
				WHERE DATE(tglpesanmenu) = '" . date('Y-m-d') . "'
					AND jenispesanmenu ILIKE '%" . Params::JENISPESANMENU_PASIEN . "%'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(pesanmenudiet_id) AS jumlah
				FROM pesanmenudiet_t
				WHERE DATE(tglpesanmenu) = '" . date('Y-m-d') . "'
					AND jenispesanmenu ILIKE '%" . Params::JENISPESANMENU_PEGAWAI . "%'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(kirimmenudiet_id) AS jumlah
				FROM kirimmenudiet_t
				WHERE DATE(tglkirimmenu) = '" . date('Y-m-d') . "'
					AND jenispesanmenu ILIKE '%" . Params::JENISPESANMENU_PASIEN . "%'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(kirimmenudiet_id) AS jumlah
				FROM kirimmenudiet_t
				WHERE DATE(tglkirimmenu) = '" . date('Y-m-d') . "'
					AND jenispesanmenu ILIKE '%" . Params::JENISPESANMENU_PEGAWAI . "%'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang, count(pasienmasukpenunjang_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = '" . PARAMS::INSTALASI_ID_GIZI . "'
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY tglmasukpenunjang ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tglmasukpenunjang) as tglmasukpenunjang , count(pasienmasukpenunjang_id) as jumlah_1
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = '" . PARAMS::INSTALASI_ID_GIZI . "'
						AND jeniskasuspenyakit_nama ILIKE '%Konsultasi Gizi%'
				GROUP BY  DATE(tglmasukpenunjang)
				ORDER BY  tglmasukpenunjang ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();

    $dataLineChart = $result_1;

    $sql = "SELECT instalasiasal_nama, ruanganasal_nama, count(pasienmasukpenunjang_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = '" . PARAMS::INSTALASI_ID_GIZI . "'
				GROUP BY instalasiasal_nama, ruanganasal_nama
				ORDER BY instalasiasal_nama, ruanganasal_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    //		$sql = "SELECT carabayar_nama, count(pasienmasukpenunjang_id) as jumlah
    //				FROM pasienmasukpenunjang_v
    //				WHERE DATE(tglmasukpenunjang) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
    //					AND instalasi_id = '".PARAMS::INSTALASI_ID_GIZI."'
    //				GROUP BY carabayar_nama
    //				ORDER BY carabayar_nama ASC";
    $sql = "
				SELECT 
				penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				AND instalasi_id = '" . PARAMS::INSTALASI_ID_GIZI . "'
				GROUP BY penjamin_id, penjamin_nama
				UNION
				SELECT 
				'Lainnya'::CHARACTER VARYING(50) AS penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id NOT IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				AND instalasi_id = '" . PARAMS::INSTALASI_ID_GIZI . "'
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND LOWER(statusmasuk) = '" . strtolower(Params::STATUSMASUK_RUJUKAN) . "'
					AND instalasi_id = '" . PARAMS::INSTALASI_ID_GIZI . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND LOWER(statusmasuk) = '" . strtolower(Params::STATUSMASUK_NONRUJUKAN) . "'
					AND instalasi_id = '" . PARAMS::INSTALASI_ID_GIZI . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];


    $sql = "SELECT kelaspelayanan_nama,sum(jml_kirim) as jumlah
				FROM laporanjmlporsikelasruangan_v
				GROUP BY kelaspelayanan_nama
				ORDER BY jumlah DESC
				LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 10;
    $criteria_updatepasien->addCondition('instalasi_id = ' . Params::INSTALASI_ID_GIZI);
    $criteria_updatepasien->addCondition("statusperiksa ILIKE '%" . Params::STATUSPERIKSA_SUDAH_PULANG . "%'");
    $criteria_updatepasien->order = 'tglmasukpenunjang DESC';
    $dataTable = GZPasienMasukPenunjangV::model()->findAll($criteria_updatepasien);


    $dataTable = new GZPasienMasukPenunjangV("search");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.longitude as longitude_kab,kabupaten_m.latitude as latitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, COUNT(pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON pasienmasukpenunjang_v.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tglmasukpenunjang) = '" . date('Y') . "'
				GROUP BY kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,latitude_kab,longitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataMap = $result;

    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    $latitude = $modPropinsi->latitude;
    $longitude = $modPropinsi->longitude;
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
      'latitude' => $latitude,
      'longitude' => $longitude,
    ));
  }


  public function actionSetKabupaten() {
    if (Yii::app()->request->isAjaxRequest) {
        $data = array();
        $kabupaten = (isset($_POST['kabupaten']) ? trim($_POST['kabupaten']) : null);

        $sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.longitude as longitude_kab,kabupaten_m.latitude as latitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, COUNT(pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON pasienmasukpenunjang_v.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tglmasukpenunjang) = '" . date('Y') . "'
        AND kabupaten_m.kabupaten_nama = '" .strtolower($kabupaten) . "'
				GROUP BY kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,latitude_kab,longitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				";
      $result = Yii::app()->db->createCommand($sql)->queryAll();
      $model = $result;

        $pas = array();
        if (count($model) > 0) {
            foreach ($model as $i => $map) {
                if ($map['latitude'] != '' && $map['latitude'] != '') {
                    $pas[$i]['latitude'] = $map['latitude'];
                    $pas[$i]['longitude'] = $map['longitude'];
                    $pas[$i]['kecamatan_nama'] = $map['kecamatan_nama'];
                    $pas[$i]['jumlah'] = $map['jumlah'];
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
