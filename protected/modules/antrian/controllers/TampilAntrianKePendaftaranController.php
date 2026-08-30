<?php

class TampilAntrianKePendaftaranController extends Controller {

    public $layout = '//layouts/antrian';
    public $defaultAction = 'index';
    public $is_bpjs = false;

    public function actionIndex($loket_id = null) {
        $this->pageTitle = Yii::app()->name . " - Tampil Antrian Ke Pendaftaran";
        $layout = '//layouts/antrian_baru';
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();

        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE");
        if (!empty($loket_id)) {
            $criteria->addCondition("loket_id = " . $loket_id);
        }
        $criteria->order = "loket_singkatan, loket_nourut ASC";
        $modLokets = ANLoketM::model()->findAll($criteria);

        $modModels = ModelantrianM::model()->findAll("modelantrian_aktif = true order by modelantrian_id asc");
        $modProfile = ProfilrumahsakitM::model()->findByPk(1);

        $render = 'index';
        $list = [];
        if (!empty($loket_id)) {
            $render = 'indexLoketNew';
            
            if (empty($modLokets)){
                echo "Loket tidak ditemukan! cek apakah loket tersebut aktif dan sudah di set untuk pendaftaran";
                exit;
            }
            
            $list = AntrianT::listNoAntrianByLoketBelumPanggilNew($modLokets[0]);
        }

        $this->render($render, array(
            'format' => $format,
            'model' => $model,
            'modLokets' => $modLokets,
            'modModels' => $modModels,
            'konfig' => $konfig,
            'modProfile' => $modProfile,
            'list' => $list
        ));
    }

    public function actionIndexKasir() {
        $this->pageTitle = Yii::app()->name . " - Tampil Antrian Ke Pendaftaran";
        $layout = '//layouts/antrian_baru';
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE and loket_singkatan not in ('L', 'R')");
        $criteria->order = "modelantrian_id, loket_nourut ASC";
        $modLokets = ANLoketM::model()->findAll($criteria);
        // $modModels = ModelantrianM::model()->findAll("modelantrian_singkatan in ('U', 'A', 'B') and modelantrian_aktif = true order by modelantrian_id asc");
        $modModels = ModelantrianM::model()->findAll("modelantrian_singkatan in ('U', 'A') and modelantrian_aktif = true order by modelantrian_id asc");
        $modProfile = ProfilrumahsakitM::model()->findByPk(1);

        // kasir
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND iskasir = TRUE");
        $criteria->order = "loket_nourut ASC";
        $modLoketsKasir = ANLoketM::model()->findAll($criteria);
        $modModelsKasir = ModelantrianM::model()->findAll("modelantrian_singkatan in ('K') and modelantrian_aktif = true order by modelantrian_id asc");
        // var_dump(count($modModelsKasir), count($modLoketsKasir)); die;
        $this->render('index_kasir', array(
            'format' => $format,
            'model' => $model,
            'modLokets' => $modLokets,
            'modModels' => $modModels,
            'modLoketsKasir' => $modLoketsKasir,
            'modModelsKasir' => $modModelsKasir,
            'konfig' => $konfig,
            'modProfile' => $modProfile,
        ));
    }

    public function actionIndexFarmasi() {
        $this->pageTitle = Yii::app()->name . " - Tampilan Antrian Pendaftaran & Farmasi";
        $layout = '//layouts/antrian_baru';
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE and loket_singkatan not in ('L', 'R')");
        $criteria->order = "modelantrian_id, loket_nourut ASC";
        $modLokets = ANLoketM::model()->findAll($criteria);
        $modModels = ModelantrianM::model()->findAll("modelantrian_singkatan in ('U', 'A', 'B') and modelantrian_aktif = true order by modelantrian_id asc");
        $modProfile = ProfilrumahsakitM::model()->findByPk(1);

        $this->render('indexPendaftaranFarmasi', array(
            'format' => $format,
            'model' => $model,
            'modLokets' => $modLokets,
            'modModels' => $modModels,
            'konfig' => $konfig,
            'modProfile' => $modProfile,
        ));
    }

    public function actionIndexFarmasiBPJS() {
        $this->pageTitle = Yii::app()->name . " - Tampil Antrian Pendaftaran Dan Farmasi Bpjs";
        $this->is_bpjs = true;
        $layout = '//layouts/antrian_baru';
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE and loket_singkatan not in ('L', 'R')");
        $criteria->order = "modelantrian_id, loket_nourut ASC";
        $modLokets = ANLoketM::model()->findAll($criteria);
        $modModels = ModelantrianM::model()->findAll("modelantrian_singkatan in ('U', 'A', 'B') and modelantrian_aktif = true order by modelantrian_id asc");
        $modProfile = ProfilrumahsakitM::model()->findByPk(1);

        $this->render('indexPendaftaranFarmasi', array(
            'format' => $format,
            'model' => $model,
            'modLokets' => $modLokets,
            'modModels' => $modModels,
            'konfig' => $konfig,
            'modProfile' => $modProfile,
        ));
    }

    public function actionIndexPenunjangLabRad() {
        $this->pageTitle = Yii::app()->name . " - Tampil Antrian Pemeriksaan Laboratorium & Radiologi";
        $layout = '//layouts/antrian_baru';
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND is_penunjang = TRUE and loket_singkatan in ('L', 'R')");
        $criteria->order = "loket_nourut ASC";
        $modLokets = ANLoketM::model()->findAll($criteria);
        $modProfile = ProfilrumahsakitM::model()->findByPk(1);
        $this->render('indexLabRad', array(
            'format' => $format,
            'model' => $model,
            'modLokets' => $modLokets,
            'konfig' => $konfig,
            'modProfile' => $modProfile
        ));
    }

    /**
     * get nilai antrian
     * @throws CHttpException
     */
    public function actionGetAntrians() {
        //if(Yii::app()->request->isAjaxRequest)
        //{
        $format = new MyFormatter();
        $data = array();

        $modLokets = ANLoketM::model()->findAll('ispendaftaran = TRUE AND loket_aktif = TRUE');
        if (count((array) $modLokets) > 0) {
            foreach ($modLokets as $i => $loket) {
                $modAntrian = $this->loadModelAntrian($loket->loket_id);
                $modJumlah = $this->loadDataStatistik($loket->loket_id);
                if ($modAntrian) {
                    if (isset($_POST['antrian_id']) && $_POST['antrian_id'] != '') {
                        $modAntrian = $this->loadModelAntrianById($loket->loket_id, $_POST['antrian_id']);
                        $modJumlah = $this->loadDataStatistik($loket->loket_id);
                        $modModel = ModelantrianM::model()->findByPk($loket->modelantrian_id);
                    }
                    if (!empty($modAntrian)) {
                        $data["an_" . $i] = $modAntrian->attributes;
                        $data["an_" . $i] += $loket->attributes;
                        $data["an_" . $i] += $modModel->attributes;
                        $data["an_" . $i] += $modJumlah;
                    }
                }
            }
        }

        echo CJSON::encode($data);
        Yii::app()->end();
        //}
        //else
        //throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateStatistik() {
        $format = new MyFormatter();
        $data = array();

        if (isset($_POST['loket_id'])) {
            $modJumlah = $this->loadDataStatistik($_POST['loket_id']);
        }
        echo CJSON::encode(array('stat' => $modJumlah));
        Yii::app()->end();
    }

    protected function loadDataStatistik($loket_id) {
        $default = '000';
        $data['jmlpasien'] = 0;
        $data['jmlmenunggu'] = 0;
        $data['jmlterdaftar'] = 0;
        $data['jmlterlewatkan'] = 0;

        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteria->addCondition("loket_id = " . $loket_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $models = ANAntrianT::model()->findAll($criteria);

        if (count((array) $models) > 0) {
            foreach ($models as $i => $model) {
                $data['jmlpasien'] += 1;
                if (!empty($model->pendaftaran_id)) {
                    $data['jmlterdaftar'] += 1;
                }
            }
        }

        //start RSPMC-625
        $criteriaMenunggu = new CDbCriteria();
        $criteriaMenunggu->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteriaMenunggu->addCondition("loket_id = " . $loket_id);
        $criteriaMenunggu->addCondition("panggil_flaq = FALSE");
        $criteriaMenunggu->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $modelsMenunggu = ANAntrianT::model()->findAll($criteriaMenunggu);
        $jmlmenunggu = 0;
        if (count((array) $modelsMenunggu) > 0) {
            foreach ($modelsMenunggu as $i => $model) {
                $jmlmenunggu += 1;
            }
        }
        //end RSPMC-625
        //		$jmlmenunggu = $data['jmlpasien'] - $data['jmlterdaftar'];
        $data['jmlmenunggu'] = $jmlmenunggu;
        $data['jmlterlewatkan'] = $data['jmlpasien'] - ($jmlmenunggu + $data['jmlterdaftar']);

        $data['jmlterlewatkan'] = (isset($data['jmlterlewatkan']) ? (str_pad($data['jmlterlewatkan'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlpasien'] = (isset($data['jmlpasien']) ? (str_pad($data['jmlpasien'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlterdaftar'] = (isset($data['jmlterdaftar']) ? (str_pad($data['jmlterdaftar'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlmenunggu'] = (isset($jmlmenunggu) ? (str_pad($jmlmenunggu, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $data;
    }

    public function actionUpdateStatistikModel() {
        $format = new MyFormatter();
        $data = array();

        if (isset($_POST['loket_id'])) {
            $modJumlah = $this->loadDataStatistikModel($_POST['loket_id']);
        }
        echo CJSON::encode(array('stat' => $modJumlah));
        Yii::app()->end();
    }

    protected function loadDataStatistikModel($modelantrian_id) {
        $default = '000';
        $data['jmlpasien'] = 0;
        $data['jmlmenunggu'] = 0;
        $data['jmlterdaftar'] = 0;
        $data['jmlterlewatkan'] = 0;

        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
        $criteria->order = "modelantrian_id DESC, noantrian DESC"; //panggil terakhir
        $models = ANAntrianT::model()->findAll($criteria);

        if (count((array) $models) > 0) {
            foreach ($models as $i => $model) {
                $data['jmlpasien'] += 1;
                if (!empty($model->pendaftaran_id)) {
                    $data['jmlterdaftar'] += 1;
                }
            }
        }

        //start RSPMC-625
        $criteriaMenunggu = new CDbCriteria();
        $criteriaMenunggu->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteriaMenunggu->addCondition("modelantrian_id = " . $modelantrian_id);
        $criteriaMenunggu->addCondition("panggil_flaq = FALSE");
        $criteriaMenunggu->order = "modelantrian_id DESC, noantrian DESC"; //panggil terakhir
        $modelsMenunggu = ANAntrianT::model()->findAll($criteriaMenunggu);
        $jmlmenunggu = 0;
        if (count((array) $modelsMenunggu) > 0) {
            foreach ($modelsMenunggu as $i => $model) {
                $jmlmenunggu += 1;
            }
        }
        //end RSPMC-625
        //		$jmlmenunggu = $data['jmlpasien'] - $data['jmlterdaftar'];
        $data['jmlmenunggu'] = $jmlmenunggu;
        $data['jmlterlewatkan'] = $data['jmlpasien'] - ($jmlmenunggu + $data['jmlterdaftar']);

        $data['jmlterlewatkan'] = (isset($data['jmlterlewatkan']) ? (str_pad($data['jmlterlewatkan'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlpasien'] = (isset($data['jmlpasien']) ? (str_pad($data['jmlpasien'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlterdaftar'] = (isset($data['jmlterdaftar']) ? (str_pad($data['jmlterdaftar'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlmenunggu'] = (isset($jmlmenunggu) ? (str_pad($jmlmenunggu, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $data;
    }

    /**
     * cari antrian berdasarkan loket_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrian($loket_id) {
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteria->addCondition("pendaftaran_id IS NULL");
        $criteria->addCondition("panggil_flaq = TRUE");
        $criteria->addCondition("loket_id = " . $loket_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $model = ANAntrianT::model()->find($criteria);
        return $model;
    }

    /**
     * cari antrian berdasarkan loket_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrianById($loket_id, $antrian_id) {
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteria->addCondition("pendaftaran_id IS NULL");
        if (!empty($loket_id)){
            $criteria->compare("loket_id", $loket_id);
        }
        $criteria->compare("antrian_id", $antrian_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $model = ANAntrianT::model()->find($criteria);
        return $model;
    }

    /**
     * suara panggilan MULTI no antrian (array) dan loket (array)
     * akses dengan ajax
     */
    public function actionSuaraPanggilan() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = "//layouts/iframe";
            $noantrians = $_POST["noantrians"];
            $loket_ids = $_POST["loket_ids"];
            $untuk = isset($_POST['untuk'])?$_POST['untuk']:null;
            $ruangan_id = isset($_POST['ruangan_id'])?$_POST['ruangan_id']:null;
            $modLokets = array();
            $modModel = array();
            $modRuangan = [];
            if (count((array) $loket_ids) > 0) {
                foreach ($loket_ids as $i => $loket_id) {
                    $modLokets[$i] = ANLoketM::model()->findByPk($loket_id);
                    $modModel[$i] = ModelantrianM::model()->findByPk($modLokets[$i]->modelantrian_id);
                    $modRuangan[$i] = RuanganM::model()->findByPk($ruangan_id[$i]);
                }
            }
            $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan', array('untuk'=>$untuk,'noantrians' => $noantrians, 'modLokets' => $modLokets, 'modModel' => $modModel, 'modRuangan'=>$modRuangan), true);
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * suara panggilan SATU no antrian dal loket
     * akses dengan iframe
     */
    public function actionSuaraPanggilanSingle($noantrian, $loket_id) {
        $this->layout = '//layouts/antrian';
        $modLoket = LoketM::model()->findByPk($loket_id);
        $noantrian_split = str_split($noantrian);
        $this->render("suaraPanggilan", array("noantrian" => $noantrian, "modLoket" => $modLoket, "noantrian_split" => $noantrian_split));
    }

    protected function loadDataStatistikLoket($loket_id) {
        $default = '000';
        $data['jmlpasien'] = 0;
        $data['jmlmenunggu'] = 0;
        $data['jmlterdaftar'] = 0;
        $data['jmlterlewatkan'] = 0;

        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteria->addCondition("loket_id = " . $loket_id);
        $criteria->order = "modelantrian_id DESC, noantrian DESC"; //panggil terakhir
        $models = ANAntrianT::model()->findAll($criteria);

        if (count((array) $models) > 0) {
            foreach ($models as $i => $model) {
                $data['jmlpasien'] += 1;
                if (!empty($model->pendaftaran_id)) {
                    $data['jmlterdaftar'] += 1;
                }
            }
        }

        $criteriaMenunggu = new CDbCriteria();
        $criteriaMenunggu->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteriaMenunggu->addCondition("loket_id = " . $loket_id);
        $criteriaMenunggu->addCondition("panggil_flaq = FALSE");
        $criteriaMenunggu->order = "modelantrian_id DESC, noantrian DESC"; //panggil terakhir
        $modelsMenunggu = ANAntrianT::model()->findAll($criteriaMenunggu);
        $jmlmenunggu = 0;
        if (count((array) $modelsMenunggu) > 0) {
            foreach ($modelsMenunggu as $i => $model) {
                $jmlmenunggu += 1;
            }
        }
        
        $criTelat = new CDbCriteria();
        $criTelat->compare("DATE(tglantrian)", date("Y-m-d"));
        $criTelat->addCondition("loket_id = " . $loket_id);
        $criTelat->addCondition("LOWER(status_barcode) ilike '".ParamsConst::STATUSBARCODE_ANTRIAN_TERLAMBAT."' ");
        $criTelat->order = "modelantrian_id DESC, noantrian DESC"; //panggil terakhir
        $modelsTelat = ANAntrianT::model()->findAll($criTelat);
        $jmltelat = 0;
        if (count((array) $modelsTelat) > 0) {
            foreach ($modelsTelat as $i => $model) {
                $jmltelat += 1;
            }
        }

        $data['jmlmenunggu'] = $jmlmenunggu;
        $data['jmlterlewatkan'] = $jmltelat;

        $data['jmlterlewatkan'] = (isset($data['jmlterlewatkan']) ? (str_pad($data['jmlterlewatkan'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlpasien'] = (isset($data['jmlpasien']) ? (str_pad($data['jmlpasien'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlterdaftar'] = (isset($data['jmlterdaftar']) ? (str_pad($data['jmlterdaftar'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlmenunggu'] = (isset($jmlmenunggu) ? (str_pad($jmlmenunggu, strlen($default), 0, STR_PAD_LEFT)) : $default);
        
        return $data;
    }
    
     public function actionUpdateStatistikLoket() {
        $format = new MyFormatter();
        $data = array();

        if (isset($_POST['loket_id'])) {
            $modJumlah = $this->loadDataStatistikLoket($_POST['loket_id']);
        }
        echo CJSON::encode(array('stat' => $modJumlah));
        Yii::app()->end();
    }
    
    /**
     * get nilai antrian
     * @throws CHttpException
     */
    public function actionGetAntriansLoket() {

        $format = new MyFormatter();
        $data = array();

        $modAntrian = $this->loadModelAntrianById(null, $_POST['antrian_id']);
        
        $modLokets = $modAntrian->loket;
        $modJumlah = $this->loadDataStatistikLoket($modLokets->loket_id);
       
        $i = 0;
        if (!empty($modAntrian)) {
            $data["an_" . $i] = $modAntrian->attributes;
            $data["an_" . $i] += $modLokets->attributes;
            $data["an_" . $i] += $modAntrian->ruangan->attributes;
            $data["an_" . $i] += $modAntrian->modelantrian->attributes;
            $data["an_" . $i] += $modJumlah;
            $data["an_" . $i]['html'] = $this->renderPartial('baris/_antrianLoketNew',[
                'loket' => $modLokets,
                'list' => AntrianT::listNoAntrianByLoketBelumPanggilNew($modLokets),
                'i'=>0
            ],true);
        }
        
        echo CJSON::encode($data);
        Yii::app()->end();
        //}
        //else
        //throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
}
