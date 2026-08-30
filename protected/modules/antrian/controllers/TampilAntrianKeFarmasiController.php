<?php
class TampilAntrianKeFarmasiController extends Controller
{
  public $layout = '//layouts/antrian';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Tampil Antrian Ke Farmasi";
    $format = new MyFormatter();
    $model = new ANAntrianfarmasiT();
    $konfig = KonfigsystemK::model()->find();
    $criteria = new CdbCriteria;
    $criteria->addCondition("racikan_aktif = true");
    $criteria->order = "racikan_id ASC";
    $modLokets = ANRacikanM::model()->findAll($criteria);
    $modAntrians = $this->loadAllAntrianPerHari();
    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modLokets' => $modLokets,
      'konfig' => $konfig,
      'modAntrians' => $modAntrians
    ));
  }

  /**
   * get nilai antrian (or dan nr)
   * @throws CHttpException
   */
  public function actionGetAntrians()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();

      $res = array();

      $modelantrian_id = array();

      if (isset($_POST['is_pendaftaran']) && $_POST['is_pendaftaran'] == true) {
        if (isset($_POST['is_bpjs']) && $_POST['is_bpjs'] == 1) {
          $modelantrian_id = array(2);
        } else {
          $modelantrian_id = array(1, 3);
        }
      }


      if (isset($_POST['antrianfarmasi_id']) && !empty($_POST['antrianfarmasi_id'])) {
        $antrianfarmasi_id = $_POST['antrianfarmasi_id'];
        $antrian = AntrianfarmasiT::model()->findByPk($antrianfarmasi_id);
        $reseptur = ResepturT::model()->findByPk($antrian->reseptur_id);
        $modLoket = ModelantrianM::model()->findByPk($antrian->modelantrian_id);

        if ((isset($_POST['is_pendaftaran']) && $_POST['is_pendaftaran'] == true) &&
          !in_array($antrian->modelantrian_id, $modelantrian_id)
        ) {
          $res['pendaftaran'] = null;
          $res['ruangan'] = null;
          $res['pasien'] = null;
          $res['antrian'] = null;
          $res['loket'] = null;
          $res['penjualan'] = null;
        } else {

          $penjualan = PenjualanresepT::model()->findByAttributes(array(
            'antrianfarmasi_id' => $antrianfarmasi_id
          ));

          $pendaftaran_id = empty($penjualan) ? $reseptur->pendaftaran_id : $penjualan->pendaftaran_id;
          $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
          $antrian = AntrianfarmasiT::model()->findByPk($antrianfarmasi_id);
          $racikan = RacikanM::model()->findByPk($antrian->racikan_id);
          // $loket = LoketM::model()->findByPk($antrian->loket_id);

          $pasienDat = $pendaftaran->pasien;
          $pasien = $pasienDat->namadepan . $pasienDat->nama_pasien;
          if (!empty($pendaftaran->pasienadmisi_id)) {
            $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
            $ruangan = $admisi->ruangan->ruangan_nama;
          } else {
            $ruangan = $pendaftaran->ruangan->ruangan_nama;
          }

          $res['pendaftaran'] = $pendaftaran->attributes;
          $res['ruangan'] = empty($penjualan) ? $reseptur->ruangan->attributes : $penjualan->ruangan->attributes;
          $res['pasien'] = $pasien;
          $res['antrian'] = $antrian->attributes;
          $res['loket'] = $racikan->attributes;
          $res['loket2'] = $modLoket->attributes;
          $res['penjualan'] = empty($penjualan) ? $reseptur->attributes : $penjualan->attributes;
        }
      }

      $data['nonracikan'] = $this->renderPartial('_daftarAntrian', array('data' => $this->loadDaftarAntrians(Params::RACIKAN_ID_NONRACIKAN, $modelantrian_id)), true);
      $data['racikan'] = $this->renderPartial('_daftarAntrian', array('data' => $this->loadDaftarAntrians(Params::RACIKAN_ID_RACIKAN, $modelantrian_id)), true);


      $res['tabel'] = $data;


      echo CJSON::encode($res);


      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * get nilai antrian (or dan nr)
   * @throws CHttpException
   */
  public function actionGetAntrians2()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();

      $res = array();

      $modelantrian_id = isset($_POST['modelantrian_id']) ? $_POST['modelantrian_id'] : 0;

      if ($modelantrian_id != 2) { // ID Model Antrian BPJS
        $modelantrian_id = array(1, 3); // ID Model Antrian Umum dan Asuransi
      } else {
        $modelantrian_id = array($modelantrian_id);
      }


      if (isset($_POST['antrianfarmasi_id']) && !empty($_POST['antrianfarmasi_id'])) {
        $antrianfarmasi_id = $_POST['antrianfarmasi_id'];
        $antrian = AntrianfarmasiT::model()->findByPk($antrianfarmasi_id);
        $modLoket = ModelantrianM::model()->findByPk($antrian->modelantrian_id);

        if (!in_array($antrian->modelantrian_id, $modelantrian_id)) {
          $res['pendaftaran'] = null;
          $res['ruangan'] = null;
          $res['pasien'] = null;
          $res['antrian'] = null;
          $res['loket'] = null;
          $res['penjualan'] = null;
        } else {

          $penjualan = PenjualanresepT::model()->findByAttributes(array(
            'antrianfarmasi_id' => $antrianfarmasi_id
          ));

          $pendaftaran_id = $penjualan->pendaftaran_id;
          $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
          $antrian = AntrianfarmasiT::model()->findByPk($antrianfarmasi_id);
          $racikan = RacikanM::model()->findByPk($antrian->racikan_id);
          // $loket = LoketM::model()->findByPk($antrian->loket_id);

          $pasienDat = $pendaftaran->pasien;
          $pasien = $pasienDat->namadepan . $pasienDat->nama_pasien;
          if (!empty($pendaftaran->pasienadmisi_id)) {
            $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
            $ruangan = $admisi->ruangan->ruangan_nama;
          } else {
            $ruangan = $pendaftaran->ruangan->ruangan_nama;
          }

          $res['pendaftaran'] = $pendaftaran->attributes;
          $res['ruangan'] = $penjualan->ruangan->attributes;
          $res['pasien'] = $pasien;
          $res['antrian'] = $antrian->attributes;
          $res['loket'] = $racikan->attributes;
          $res['loket2'] = $modLoket->attributes;
          $res['penjualan'] = $penjualan->attributes;
        }
      }

      $data['nonracikan'] = $this->renderPartial('_daftarAntrian', array('data' => $this->loadDaftarAntrians(Params::RACIKAN_ID_NONRACIKAN, $modelantrian_id)), true);
      $data['racikan'] = $this->renderPartial('_daftarAntrian', array('data' => $this->loadDaftarAntrians(Params::RACIKAN_ID_RACIKAN, $modelantrian_id)), true);


      $res['tabel'] = $data;


      echo CJSON::encode($res);


      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * cari antrian berdasarkan statuspasien
   * @return \ANAntrianfarmasiT
   */
  protected function loadModelAntrian($racikan_id)
  {
    $criteria = new CDbCriteria();
    $criteria->compare("DATE(tglambilantrian)", date("Y-m-d"));
    $criteria->addCondition("racikan_id = " . $racikan_id);
    $criteria->addCondition("panggilantrian = TRUE");
    $criteria->order = "noantrian DESC"; //panggil terakhir
    $model =  ANAntrianfarmasiT::model()->find($criteria);
    if (!isset($model)) {
      $model = new ANAntrianfarmasiT;
    }
    return $model;
  }

  protected function loadModelAntrianById($racikan_id, $antrianfarmasi_id)
  {
    $criteria = new CDbCriteria();
    $criteria->compare("DATE(tglambilantrian)", date("Y-m-d"));
    $criteria->addCondition("racikan_id = " . $racikan_id);
    $criteria->addCondition("antrianfarmasi_id = " . $antrianfarmasi_id);
    $criteria->addCondition("panggilantrian = TRUE");
    $criteria->order = "noantrian DESC"; //panggil terakhir
    $model =  ANAntrianfarmasiT::model()->find($criteria);
    if (!isset($model)) {
      $model = new ANAntrianfarmasiT;
    }
    return $model;
  }

  /**
   * load daftar racikan
   * @param type $racikan_id
   * @return $data array()
   */

  protected function loadAllAntrianPerHari(){
    $data = array();
    $criteria = new CdbCriteria();
    $criteria->compare('DATE(tglambilantrian)', date("Y-m-d"));
   
    // $criteria->addCondition("noantrian IS NOT NULL");
    $criteria->addCondition("jumlah_panggil > 1");
    $criteria->order = "tglambilantrian DESC";
    $criteria->limit = 5;

    $model =  ANAntrianfarmasiT::model()->findAll($criteria);
    return $model;
  }
  protected function loadDaftarAntrians($racikan_id, $modelantrian_id = null)
  {
    $data = array();
    $criteria = new CdbCriteria();
    $criteria->compare('DATE(tglpelayanan)', date("Y-m-d"));
    $criteria->addCondition("racikanantrian_id = " . $racikan_id);
    $criteria->addCondition("noantrian IS NOT NULL");
    $criteria->addCondition("panggilantrian = FALSE");
    $criteria->compare('modelantrian_id', $modelantrian_id);
    $criteria->order = "tglresep ASC";
    $criteria->group = "tglresep, noresep, namadepan, nama_pasien, noantrian, racikanantrian_singkatan, no_rekam_medik";
    $criteria->select = $criteria->group . ", count(obatalkes_id) AS jumlahoa";
    $criteria->limit = 5;


    $modInfoPenjualanResep = ANInformasipenjualanaresepV::model()->findAll($criteria);
    if (count((array)$modInfoPenjualanResep) > 0) {
      foreach ($modInfoPenjualanResep as $i => $penjualan) {
        $data[$i]["racikanantrian_singkatan"] = $penjualan->racikanantrian_singkatan;
        $data[$i]["noantrian"] = $penjualan->noantrian;
        $data[$i]["noresep"] = $penjualan->noresep;
        $data[$i]["namadepan"] = $penjualan->namadepan;
        $data[$i]["nama_pasien"] = $penjualan->nama_pasien;
        $data[$i]["no_rekam_medik"] = $penjualan->no_rekam_medik;
        $data[$i]["jumlahoa"] = $penjualan->jumlahoa;
      }
    }
    return $data;
  }
  /**
   * suara panggilan MULTI no antrian (array) dan loket (array)
   * akses dengan ajax
   */
  public function actionSuaraPanggilan()
  {
    /*
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->layout = "//layouts/iframe";
            $noantrians = $_POST["noantrians"];
            $loket_ids = $_POST["loket_ids"];
            $modLokets = array();
            if(count((array)$loket_ids) >  0){
                foreach($loket_ids AS $i => $loket_id){
                    $modLokets[$i] = ANLoketM::model()->findByPk($loket_id);
                }
            }
            $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan',array('noantrians'=>$noantrians, 'modLokets'=>$modLokets),true);
            echo CJSON::encode($data);
        }
         * 
         */
    $this->layout = "//layouts/antrian";
    $kodeantrian = $_POST["kodeantrians"];
    $noantrian = $_POST["noantrians"];
    $modelantrian = $_POST["modelantrians"];
    $loket = isset($_POST["loket"]) ? $_POST['loket'] : null;
    // $ruangan_id = $_GET["ruangan_id"];
    // $modRuangan = RuanganM::model()->findByPk($ruangan_id);
    $res = array();
    $res['suarapanggilan'] = $this->renderPartial('suaraPanggilan', array(
      'kodeantrian' => $kodeantrian,
      'noantrian' => $noantrian,
      'loket' => $loket,
      'modelantrian' => $modelantrian
      // 'modRuangan'=>$modRuangan
    ), true);

    echo CJSON::encode($res);

    Yii::app()->end();
  }

  /**
   * suara panggilan SINGLE no antrian (array)
   * akses dengan iframe
   */
  /*
    public function actionSuaraPanggilanSingle(){
        $this->layout = "//layouts/antrian";
        $kodeantrian = $_GET["kodeantrian"];
        $noantrian = $_GET["noantrian"];
        $ruangan_id = $_GET["ruangan_id"];
        $modRuangan = RuanganM::model()->findByPk($ruangan_id);
        $this->render('suaraPanggilanSingle',array('kodeantrian'=>$kodeantrian,'noantrian'=>$noantrian, 'modRuangan'=>$modRuangan));
    }
     * 
     */
}
