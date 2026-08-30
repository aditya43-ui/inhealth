<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardSAController extends ModuleDashboardNeonController
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

    $sql = "SELECT COUNT(loginpemakai_id) AS jumlah
				FROM loginpemakai_k
				WHERE DATE(waktuterakhiraktifitas) = '" . date('Y-m-d') . "'
					AND statuslogin is TRUE";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(chat_id) AS jumlah
				FROM chat
				WHERE DATE(chat_sent) = '" . date('Y-m-d') . "'
					AND chat_recd = 0";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(nofitikasi_id) AS jumlah
				FROM notifikasi_r
				WHERE DATE(tglnotifikasi) = '" . date('Y-m-d') . "'
					AND isread is FALSE";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(reportbugs_id) AS jumlah
				FROM reportbugs_r
				WHERE DATE(create_datetime) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(create_datetime) as create_datetime, count(reportbugs_id) as jumlah
				FROM reportbugs_r
				WHERE DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(create_datetime)
				ORDER BY create_datetime ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;

    $sql = "SELECT DATE(create_datetime) as create_datetime , count(reportbugs_id) as jumlah_1
				FROM reportbugs_r
				WHERE DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND kodebugs ILIKE '%404%'
				GROUP BY  DATE(create_datetime)
				ORDER BY  create_datetime ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_datetime) as create_datetime , count(reportbugs_id) as jumlah_2
				FROM reportbugs_r
				WHERE DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND kodebugs ILIKE '%403%'
				GROUP BY  DATE(create_datetime)
				ORDER BY  create_datetime ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_datetime) as create_datetime , count(reportbugs_id) as jumlah_3
				FROM reportbugs_r
				WHERE DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND kodebugs ILIKE '%500%'
				GROUP BY  DATE(create_datetime)
				ORDER BY  create_datetime ASC";
    $result_3 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_datetime) as create_datetime , count(reportbugs_id) as jumlah_4
				FROM reportbugs_r
				WHERE DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND kodebugs ILIKE '%LOG error%'
				GROUP BY  DATE(create_datetime)
				ORDER BY  create_datetime ASC";
    $result_4 = Yii::app()->db->createCommand($sql)->queryAll();

    $dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'create_datetime');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'create_datetime');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'create_datetime');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4, 'create_datetime');

    $sql = "SELECT create_login_nama, count(create_login_nama) as jumlah
				FROM reportbugs_r
				WHERE DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY create_login_nama
				ORDER BY jumlah
				LIMIT 5";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT crudaktifitas, count(loginpemakai_id) as jumlah
				FROM loginpemakai_k
				WHERE DATE(waktuterakhiraktifitas) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY crudaktifitas
				ORDER BY jumlah DESC
				LIMIT 5";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(reportbugs_id) AS jumlah
				FROM reportbugs_r
				WHERE (DATE_PART('month', create_datetime)) != '" . date('m') . "'
					AND DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(reportbugs_id) AS jumlah
				FROM reportbugs_r
				WHERE DATE(create_datetime) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];


    $sql = "SELECT DATE(create_time) as create_time,count(pendaftaran_id) as jumlah_1
				FROM pendaftaran_t
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'
				GROUP BY  DATE(create_time)
				ORDER BY  create_time ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_time) as create_time,count(pasien_id) as jumlah_2
				FROM pasien_m
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'
				GROUP BY  DATE(create_time)
				ORDER BY  create_time ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_time) as create_time,count(tindakanpelayanan_id) as jumlah_3
				FROM tindakanpelayanan_t
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'
				GROUP BY  DATE(create_time)
				ORDER BY  create_time ASC";
    $result_3 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_time) as create_time,count(obatalkespasien_id) as jumlah_4
				FROM obatalkespasien_t
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'
				GROUP BY  DATE(create_time)
				ORDER BY  create_time ASC";
    $result_4 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_time) as create_time,count(pasienbatalperiksa_id) as jumlah_5
				FROM pasienbatalperiksa_r
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'
				GROUP BY  DATE(create_time)
				ORDER BY  create_time ASC";
    $result_5 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(create_time) as create_time,count(pembayaranpelayanan_id) as jumlah_6
				FROM pembayaranpelayanan_t
				WHERE DATE(create_time) = '" . date('Y-m-d') . "'
				GROUP BY  DATE(create_time)
				ORDER BY  create_time ASC";
    $result_6 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'create_time');
    $dataBarChart = CustomFunction::joinTwo2DArrays($dataBarChart, $result_3, 'create_time');
    $dataBarChart = CustomFunction::joinTwo2DArrays($dataBarChart, $result_4, 'create_time');
    $dataBarChart = CustomFunction::joinTwo2DArrays($dataBarChart, $result_5, 'create_time');
    $dataBarChart = CustomFunction::joinTwo2DArrays($dataBarChart, $result_6, 'create_time');
    //=== end chart ===

    //=== start table ===
    $criteria_updatepemakai = new CDbCriteria();
    $criteria_updatepemakai->limit = 5;
    $criteria_updatepemakai->addCondition("loginpemakai_aktif is true");
    $criteria_updatepemakai->order = 'lastlogin DESC';
    $dataTable = SALoginpemakaiK::model()->findAll($criteria_updatepemakai);

    $dataTable = new SALoginpemakaiK("search");
    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT nama_pemakai, longitude, latitude, COUNT(loginpemakai_id) AS jumlah
				FROM loginpemakai_k
				WHERE loginpemakai_aktif is TRUE
				AND pasien_id is NOT NULL
				GROUP BY nama_pemakai, longitude, latitude
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
}
