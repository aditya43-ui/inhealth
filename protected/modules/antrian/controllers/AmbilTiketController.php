<?php

class AmbilTiketController extends Controller {

    public $layout = '//layouts/kiosAntrian';
    public $pathView = 'antrian.views.ambilTiket.';
    public $pathView_antrian_pasien = 'antrian.views.ambilTiketPasien.';
    public $pathView_umum_asuransi = 'antrian.views.ambilTiketUmumAsuransi.';
    public $pathView_bpjs = 'antrian.views.ambilTiketBpjs.';
    public $pathView_antrian_ekios = 'antrian.views.ambilAntrianEkios.';
    public $pathView_antrian_ranap = 'antrian.views.ambilTiketRanap.';

    public function actionIndex() {
        $criteria = new CdbCriteria();
        $criteria->addCondition('loket_aktif = true');
        $criteria->order = "loket_nourut";
        $modLokets = ANLoketM::model()->findAll('ispendaftaran = TRUE AND loket_aktif=TRUE ORDER BY loket_nourut');
        $model = new ANAntrianT;



        $this->render($this->pathView . 'index', array('model' => $model, 'modLokets' => $modLokets));
    }

    /**
     * untuk menyimpan tiket (ajax)
     */
    public function actionSimpanTiket() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['antrianpenuh'] = 0;
            $data['pesan'] = "Data gagal disimpan! ";
            if (isset($_POST['data'])) {
                parse_str($_POST['data'], $post);
                // echo '<pre>';
                // var_dump($post);die;
                $model = new ANAntrianT;
                $model->attributes = $post['ANAntrianT'];
                $model->profilrs_id = Params::getDefaultProfilRS();
                $model->ruangan_id = $post['ANAntrianT']['ruangan_id'];
                $model->pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
                
                $cri = new CDbCriteria;
                $cri->join = " JOIN loket_m l ON l.loket_id = t.loket_id ";
                $cri->addCondition("t.ruangan_id=" . $model->ruangan_id . " AND l.modelantrian_id =  " . $model->modelantrian_id);
                $loket = LoketpendaftaranpoliM::model()->find($cri);
                $maksAntrian = 0;
                if (!empty($loket)) {
                    $model->loket_id = $loket->loket_id;
                    $maksAntrian = $loket->loket->loket_maksantrian;
                }

               
                
                if ($model->jenis_kunjungan == ParamsConst::JENIS_KUNJUNGAN_ANTRIAN_RSERVASI) {
                    $model->tglantrian = MyFormatter::formatDateTimeForDb($model->tglakandilayani);
                } else {
                    $model->tglantrian = date('Y-m-d H:i:s');
                }
                
                $model->noantrian = (empty($model->noantrian) ? MyGenerator::noAntrianModelAntrianInteger($model->modelantrian_id, $model->loket_id, $model->tglantrian) : $model->noantrian);
                
                $model->tglakandilayani = $this->hitungTglDilayaniByLoket($model);                
                if ($model->jenis_kunjungan == ParamsConst::JENIS_KUNJUNGAN_ANTRIAN_RSERVASI) {
                    $model->tglantrian = $model->tglakandilayani;
                }

                               
                $ma = ModelantrianM::model()->findByPk($model->modelantrian_id);
                
                $model->status_barcode = ParamsConst::STATUSBARCODE_ANTRIAN_BELUMBARCODE;
                $model->status_panggil = ParamsConst::STATUSPANGGIL_ANTRIAN_TUNGGU;

                $tahun = date('y', strtotime($model->tglantrian));
                $bulan = date('m', strtotime($model->tglantrian));
                $tanggal = date('d', strtotime($model->tglantrian));
                $nobarcode = $tahun . $bulan . $tanggal . $model->loket->loket_singkatan . $model->noantrian;
                $model->barcode = $nobarcode;
                // menentukan tgl dilayani        

                $delaytombol = $this->actionGetDelayTombolAntrian();

                //  var_dump($model->attributes); die;
                if($model->noantrian <= $maksAntrian) {
                    if ($model->validate()) {
                        $model->save();
                        $data['model'] = $model;
                        $data['loket_singkatan'] = $model->modelantrian->modelantrian_singkatan;
                        $data['delaytombol'] = $delaytombol;
                        $data['pesan'] = "Data berhasil disimpan!";
                    } else {
                        $data['pesan'] = "Data gagal disimpan! " . CHtml::errorSummary($model);
                    }
                } else {
                    $data['antrianpenuh'] = 1;
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    public function actionSimpanTiketLangsungRawatInap() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['pesan'] = "Data gagal disimpan! ";
            $model = new ANAntrianT;

            $ruangan_kode = array(
                'F' => 272,
                'S' => 449,
                'L' => Params::RUANGAN_ID_LAB_KLINIK,
                'R' => Params::RUANGAN_ID_RAD,
            );

            $model->profilrs_id = Params::getDefaultProfilRS();
            $model->ruangan_id = 571;
            $model->tglantrian = date('Y-m-d H:i:s');
            $model->modelantrian_id = $_POST['modelantrian_id'];
            $model->noantrian = MyGenerator::noAntrianModelAntrianInteger($model->modelantrian_id);
            $model->tglakandilayani = null;
            $delaytombol = $this->actionGetDelayTombolAntrian();

            $loket = LoketM::model()->findByAttributes(array('modelantrian_id' => $model->modelantrian_id, 'loket_aktif' => true));
            if (!empty($loket)) {
                $model->loket_id = $loket->loket_id;
            }
            $model->tglakandilayani = $this->hitungTglDilayani($model);

            if ($model->validate()) {
                $model->save();
                $data['model'] = $model;
                $data['loket_singkatan'] = $model->modelantrian->modelantrian_singkatan;
                $data['delaytombol'] = $delaytombol;
                $data['pesan'] = "Data berhasil disimpan!";
            } else {
                $data['pesan'] = "Data gagal disimpan! " . CHtml::errorSummary($model);
            }

            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    public function actionSimpanTiketLangsung() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['pesan'] = "Data gagal disimpan! ";
            $model = new ANAntrianT;

            $ruangan_kode = array(
                'F' => 272,
                'S' => 449,
                'L' => Params::RUANGAN_ID_LAB_KLINIK,
                'R' => Params::RUANGAN_ID_RAD,
            );

            $model->profilrs_id = Params::getDefaultProfilRS();
            $model->ruangan_id = !empty($ruangan_kode[$_POST['modelantrian_kode']]) ? $ruangan_kode[$_POST['modelantrian_kode']] : Params::DEFAULT_RUANGAN_KIOSK;
            $model->tglantrian = date('Y-m-d H:i:s');
            $model->modelantrian_id = $_POST['modelantrian_id'];
            $model->noantrian = MyGenerator::noAntrianModelAntrianInteger($model->modelantrian_id);
            $model->tglakandilayani = null;
            $delaytombol = $this->actionGetDelayTombolAntrian();

            $model->tglakandilayani = $this->hitungTglDilayani($model);

            if ($model->validate()) {
                $model->save();
                $data['model'] = $model;
                $data['loket_singkatan'] = $model->modelantrian->modelantrian_singkatan;
                $data['delaytombol'] = $delaytombol;
                $data['pesan'] = "Data berhasil disimpan!";
            } else {
                $data['pesan'] = "Data gagal disimpan! " . CHtml::errorSummary($model);
            }

            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    public function hitungTglDilayani($model) {
        $loket = LoketM::model()->findByAttributes(array(
            'modelantrian_id' => $model->modelantrian_id
        ));

        $bukaloketatrian = !empty($loket->bukaloketantrian) ? $loket->bukaloketantrian : null;
        $tgl_buka = new DateTime(date('Y-m-d') . " " . $bukaloketatrian);
        $tgl_antrian = new DateTime($model->tglantrian);

        if ($model->noantrian == '001') {
            if ($tgl_antrian < $tgl_buka) {
                return $tgl_buka->format('Y-m-d H:i:s');
            }
            return $tgl_antrian->format('Y-m-d H:i:s');
        }

        $cr = new CDbCriteria();
        $cr->order = 'antrian_id desc';
        $cr->compare('modelantrian_id', $model->modelantrian_id);
        $cr->addCondition("tglantrian::date = current_date");

        $antrian = AntrianT::model()->find($cr);
        if (empty($antrian)) {
            $antrian = new AntrianT();
        }

        $tgl_layanan_akhir = new DateTime($antrian->tglakandilayani);
        if (!empty($loket->estimasiantrian)) {
            if ($tgl_layanan_akhir < $tgl_antrian) {
                $tgl_antrian->add(new DateInterval("PT" . $loket->estimasiantrian . "M"));
                return $tgl_antrian->format('Y-m-d H:i:s');
            }

            $tgl_layanan_akhir->add(new DateInterval("PT" . $loket->estimasiantrian . "M"));
        }

        return $tgl_layanan_akhir->format('Y-m-d H:i:s');
    }

    public function hitungTglDilayaniByLoket(&$model) {
        
        $crJadwalPoli = new CDbCriteria();
        $crJadwalPoli->select = [
            "t.jammulaipendaftaran",            
        ];
        $crJadwalPoli->compare('t.hari ', strtoupper($this->hari()));                
        $crJadwalPoli->addCondition('t.ruangan_id = '.$model->ruangan_id." ");        
        $jadwalPoli = JadwalbukapoliM::model()->find($crJadwalPoli);
               
        $jammulaipendaftaran = !empty($jadwalPoli->jammulaipendaftaran)?$jadwalPoli->jammulaipendaftaran: null;
        
        $tgl_buka = new DateTime(date('Y-m-d') . " " . $jammulaipendaftaran);
        
        if ($model->jenis_kunjungan == ParamsConst::JENIS_KUNJUNGAN_ANTRIAN_RSERVASI){
            $tgl_antrian = new DateTime($model->tglantrian.' '.$jammulaipendaftaran);
        }else{
            $tgl_antrian = new DateTime($model->tglantrian);
        }
        
        if ($model->noantrian == 1) {           
            if ($tgl_antrian < $tgl_buka) {
                return $tgl_buka->format('Y-m-d H:i:s');
            }
            $tgl_antrian->add(new DateInterval("PT" . $model->loket->estimasiantrian . "M"));
            return $tgl_antrian->format('Y-m-d H:i:s');
        }

        $cr = new CDbCriteria();
        $cr->order = 'antrian_id desc';
        $cr->compare('loket_id', $model->loket_id);
        $cr->addCondition("tglantrian::date = current_date");

        $antrian = AntrianT::model()->find($cr);
        if (empty($antrian)) {
            $antrian = new AntrianT();
        }
        
        $tgl_layanan_akhir = new DateTime($antrian->tglakandilayani);        
        if ($tgl_layanan_akhir < $tgl_antrian) {
            $tgl_antrian->add(new DateInterval("PT" . $model->loket->estimasiantrian . "M"));
            return $tgl_antrian->format('Y-m-d H:i:s');
        }

        $tgl_layanan_akhir->add(new DateInterval("PT" . $model->loket->estimasiantrian . "M"));
        

        return $tgl_layanan_akhir->format('Y-m-d H:i:s');
    }

    public function actionPrint($antrian_id) {
        $modAntrian = ANAntrianT::model()->findByPk($antrian_id);
        $this->layout = '//layouts/printWindows';
        $this->render($this->pathView . 'printNoAntrianBaru2', array('modAntrian' => $modAntrian));
    }

    public function actionPrintRanap($antrian_id) {
        $modAntrian = ANAntrianT::model()->findByPk($antrian_id);
        $this->layout = '//layouts/printWindows';
        $this->render($this->pathView_antrian_ranap . 'printNoAntrianRanap', array('modAntrian' => $modAntrian));
    }

    public function actionGetRunningText() {
        //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
        $konfig = KonfigsystemK::model()->find();

        $text = $konfig->running_text_kiosk;

        echo json_encode($text);
    }

    public function actionGetDelayTombolAntrian() {
        //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
        $konfig = KonfigsystemK::model()->find();

        $delaytombol = $konfig->delaytombolantrian;

        return $delaytombol;
    }

    public function actionIndexUmumAsuransi() {
        //ALL
        $criteria = new CdbCriteria();
        $criteria->addCondition('modelantrian_aktif = true');

        $modLokets = ModelantrianM::model()->findAll($criteria);

        //PENDAFTARAN
        $criteria1 = new CdbCriteria();
        $criteria1->addCondition('modelantrian_aktif = true');
        $criteria1->addInCondition('modelantrian_kode', array('A', 'B', 'D', 'E', 'F', 'G'));

        $modLokets1 = ModelantrianM::model()->findAll($criteria1);

        //LAB
        $criteria2 = new CdbCriteria();
        $criteria2->addCondition('modelantrian_aktif = true');
        $criteria2->addInCondition('modelantrian_kode', array('L', 'LA', 'LB', 'LI', 'AH'));

        $modLokets2 = ModelantrianM::model()->findAll($criteria2);

        //KASIR
        $criteria3 = new CdbCriteria();
        $criteria3->addCondition('modelantrian_aktif = true');
        $criteria3->addInCondition('modelantrian_kode', array('K', 'KA', 'KI', 'KB', 'KR', 'KD'));

        $modLokets3 = ModelantrianM::model()->findAll($criteria3);


        $model = new ANAntrianT;
        $model->ruangan_id = Params::DEFAULT_RUANGAN_KIOSK;


        $this->pageTitle = Yii::app()->name . " - Ambil Tiket Umum dan Asuransi";
        $this->render($this->pathView_umum_asuransi . 'index', array('model' => $model, 'modLokets' => $modLokets, 'modLokets1' => $modLokets1, 'modLokets2' => $modLokets2, 'modLokets3' => $modLokets3));
    }

    public function actionIndexAntrianEkios() {
        $criteria = new CdbCriteria();
        $criteria->addCondition('modelantrian_aktif = true');
        $modLokets = ModelantrianM::model()->findAll("modelantrian_kode in ('U','L','R', 'A')");
        $model = new ANAntrianT;



        $crJadwalPoli = new CDbCriteria();

        $crJadwalPoli->compare('t.hari ', strtoupper($this->hari()));
        $crJadwalPoli->addCondition('t.jammulai <=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->addCondition('t.jamtutup >=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id';
        $crJadwalPoli->addCondition('r.ruangan_aktif = true');

        $modJadwalPolis = JadwalbukapoliM::model()->findAll($crJadwalPoli);


        $loketKios = ANLoketM::model()->findAll("loket_fungsi = 'Ambil Tiket E-kios' ORDER BY loket_nourut");

//var_dump($modLokets);die();
        $this->pageTitle = Yii::app()->name . " - Tiket Antrian E-kios";
        $this->render($this->pathView_antrian_ekios . 'indexNew', array('model' => $model, 'modJadwalPolis' => $modJadwalPolis, 'modLokets' => $modLokets, 'loketKios' => $loketKios));
    }

     public function actionIndexUmumAsuransiNew2() {
         $criteria = new CdbCriteria();
        $criteria->addCondition('modelantrian_aktif = true');
        // $modLokets = ModelantrianM::model()->findAll("modelantrian_kode in ('U','L','R', '".Params::MODELANTRIAN_BPJS."')");
        $modLokets = ModelantrianM::model()->findAll("modelantrian_id in ( 1, 3, 6, 5) order by modelantrian_id ASC");
        $model = new ANAntrianT;
        $modKasir = ModelantrianM::model()->findByAttributes(array('modelantrian_id' => 4));



        $crJadwalPoli = new CDbCriteria();

        $crJadwalPoli->compare('t.hari ', strtoupper($this->hari()));
        $crJadwalPoli->addCondition('t.jammulai <=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->addCondition('t.jamtutup >=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id';
        $crJadwalPoli->addCondition('r.ruangan_aktif = true');

        $modJadwalPolis = JadwalbukapoliM::model()->findAll($crJadwalPoli);

        $this->pageTitle = Yii::app()->name . " - Ambil Tiket Umum dan Asuransi";
        $this->render($this->pathView_umum_asuransi . 'indexNew', array('model' => $model, 'modJadwalPolis' => $modJadwalPolis, 'modLokets' => $modLokets, 'modKasir' => $modKasir));
    }

    public function actionIndexUmumAsuransiNew() {
        
         if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'pasien-m-grid'){
                    $path = $this->pathView_umum_asuransi.'grid/_listPasien';
                
                    $this->renderPartial($path,[]);
                    exit;
                }
            }
        }
        
        $listmodel = ' ( 1 , 2)';

        $criteria = new CdbCriteria();
        $criteria->addCondition('modelantrian_aktif = true');
        // $modLokets = ModelantrianM::model()->findAll("modelantrian_kode in ('U','L','R', '".Params::MODELANTRIAN_BPJS."')");
        $modLokets = ModelantrianM::model()->findAll("modelantrian_id in " . $listmodel . " order by modelantrian_id ASC");
        $model = new ANAntrianT;
        $modKasir = ModelantrianM::model()->findByAttributes(array('modelantrian_id' => 4));

        $crJadwalPoli = new CDbCriteria();
        $crJadwalPoli->group = $crJadwalPoli->select = "l.loket_id, l.modelantrian_id, t.ruangan_id, r.ruangan_nama";        
        $crJadwalPoli->compare('t.hari ', strtoupper($this->hari()));
        $crJadwalPoli->addCondition('t.jammulai <=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->addCondition('t.jamtutup >=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->join = ' join ruangan_m r on r.ruangan_id = t.ruangan_id 
        JOIN loketpendaftaranpoli_m loketpoli ON loketpoli.ruangan_id = t.ruangan_id 
        JOIN loket_m l ON l.loket_id = loketpoli.loket_id AND l.modelantrian_id IN ' . $listmodel . '
    ';
        $crJadwalPoli->addCondition('r.ruangan_aktif = true');
        $crJadwalPoli->addInCondition("t.ruangan_id", LoketpendaftaranpoliM::listRuanganId());

        $crJadwalPoli->order = "r.ruangan_nama ASC";
        $modJadwalPolis = JadwalbukapoliM::model()->findAll($crJadwalPoli);

        $this->pageTitle = Yii::app()->name . " - Ambil Tiket Umum dan Asuransi";
        $this->render($this->pathView_umum_asuransi . 'indexNew2', array('model' => $model, 'modJadwalPolis' => $modJadwalPolis, 'modLokets' => $modLokets, 'modKasir' => $modKasir));
    }
    public function actionIndexAntrianPasien() {
        
         if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'pasien-m-grid'){
                    $path = $this->pathView_umum_asuransi.'grid/_listPasien';
                
                    $this->renderPartial($path,[]);
                    exit;
                }
            }
        }
        
        $listmodel = ' ( 1 , 2)';

        $criteria = new CdbCriteria();
        $criteria->addCondition('modelantrian_aktif = true');
        // $modLokets = ModelantrianM::model()->findAll("modelantrian_kode in ('U','L','R', '".Params::MODELANTRIAN_BPJS."')");
        $modLokets = ModelantrianM::model()->findAll("modelantrian_id in " . $listmodel . " order by modelantrian_id ASC");
        $model = new ANAntrianT;
        $modKasir = ModelantrianM::model()->findByAttributes(array('modelantrian_id' => 4));

        $crJadwalPoli = new CDbCriteria();
        $crJadwalPoli->group = $crJadwalPoli->select = "l.loket_id, l.modelantrian_id, t.ruangan_id, r.ruangan_nama";        
        $crJadwalPoli->compare('t.hari ', strtoupper($this->hari()));
        $crJadwalPoli->addCondition('t.jammulai <=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->addCondition('t.jamtutup >=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->join = ' join ruangan_m r on r.ruangan_id = t.ruangan_id 
        JOIN loketpendaftaranpoli_m loketpoli ON loketpoli.ruangan_id = t.ruangan_id 
        JOIN loket_m l ON l.loket_id = loketpoli.loket_id AND l.modelantrian_id IN ' . $listmodel . '
    ';
        $crJadwalPoli->addCondition('r.ruangan_aktif = true');
        $crJadwalPoli->addInCondition("t.ruangan_id", LoketpendaftaranpoliM::listRuanganId());

        $crJadwalPoli->order = "r.ruangan_nama ASC";
        $modJadwalPolis = JadwalbukapoliM::model()->findAll($crJadwalPoli);

        $this->pageTitle = Yii::app()->name . " - Ambil Tiket Umum dan Asuransi";
        $this->render($this->pathView_antrian_pasien . 'indexNew2', array('model' => $model, 'modJadwalPolis' => $modJadwalPolis, 'modLokets' => $modLokets, 'modKasir' => $modKasir));
    }

    public function actionIndexRawatInap() {
        
        if (Yii::app()->request->isAjaxRequest){
           if (isset($_GET['ajax'])){
               $ajax = $_GET['ajax'];
               if ($ajax == 'pasien-m-grid'){
                   $path = $this->pathView_umum_asuransi.'grid/_listPasien';
               
                   $this->renderPartial($path,[]);
                   exit;
               }
           }
       }
       
       $listmodel = ' ( 12 )';

       $criteria = new CdbCriteria();
       $criteria->addCondition('modelantrian_aktif = true');
       // $modLokets = ModelantrianM::model()->findAll("modelantrian_kode in ('U','L','R', '".Params::MODELANTRIAN_BPJS."')");
       $modLokets = ModelantrianM::model()->findAll("modelantrian_id in " . $listmodel . " order by modelantrian_id ASC");
       $model = new ANAntrianT;

       $this->pageTitle = Yii::app()->name . " - Ambil Tiket Rawat Inap";
       $this->render($this->pathView_antrian_ranap . 'index', array('model' => $model, 'modLokets' => $modLokets));
   }

    public function actionIndexCheckinOnly() {
        $criteria = new CdbCriteria();
        $criteria->addCondition('modelantrian_aktif = true');
        // $modLokets = ModelantrianM::model()->findAll("modelantrian_kode in ('U','L','R', '".Params::MODELANTRIAN_BPJS."')");
        $modLokets = ModelantrianM::model()->findAll("modelantrian_id in ( 1, 3, 6, 5) order by modelantrian_id ASC");
        $model = new ANAntrianT;
        $modKasir = ModelantrianM::model()->findByAttributes(array('modelantrian_id' => 4));


        $crJadwalPoli = new CDbCriteria();

        $crJadwalPoli->compare('t.hari ', strtoupper($this->hari()));
        $crJadwalPoli->addCondition('t.jammulai <=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->addCondition('t.jamtutup >=' . "'" . date('H:i:s') . "'");
        $crJadwalPoli->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id';
        $crJadwalPoli->addCondition('r.ruangan_aktif = true');

        $modJadwalPolis = JadwalbukapoliM::model()->findAll($crJadwalPoli);

        $this->pageTitle = Yii::app()->name . " - Ambil Tiket Umum dan Asuransi";
        $this->render($this->pathView_umum_asuransi . 'indexCheckin', array('model' => $model, 'modJadwalPolis' => $modJadwalPolis, 'modLokets' => $modLokets, 'modKasir' => $modKasir));
    }

    public function actionIndexBpjs() {
        $criteria = new CdbCriteria();
        $criteria->addCondition('modelantrian_aktif = true');
        //$criteria->order = "modelantrian_aktif";

        $modLokets = ModelantrianM::model()->findAll("modelantrian_kode = '" . Params::MODELANTRIAN_BPJS . "'");
        $model = new ANAntrianT;

        $this->pageTitle = Yii::app()->name . " - Ambil Tiket BPJS";
        $this->render($this->pathView_bpjs . 'index', array('model' => $model, 'modLokets' => $modLokets));
    }

    protected function hari() {
        $hari = date('l');
        /* $new = date('l, F d, Y', strtotime($Today)); */
        if ($hari == "Sunday") {
            return "MINGGU";
        } elseif ($hari == "Monday") {
            return "SENIN";
        } elseif ($hari == "Tuesday") {
            return "SELASA";
        } elseif ($hari == "Wednesday") {
            return "RABU";
        } elseif ($hari == "Thursday") {
            return "KAMIS";
        } elseif ($hari == "Friday") {
            return "JUMAT";
        } elseif ($hari == "Saturday") {
            return "SABTU";
        }
    }

    public function actionGetDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();

            $res = array();
            $ruangan_id = $_POST['ruangan_id'];
            $kode = $_POST['kode'] ?? null;
            $criteria = new CDbCriteria;
            // $criteria->select = 'pegawai_id,ruangan_id,DATE_ADD(jadwaldokter_mulai, INTERVAL '"2 HOUR"') AS datemulai,DATE_ADD(jadwaldokter_tutup, INTERVAL 2 HOUR) AS dateakhir';
            $criteria->addCondition('ruangan_id =' . $ruangan_id);
            $tgl_awal = date('Y-m-d');
            $waktu = date('H:i:s');
            // $tgl_akhir = date('Y-m-d') . " 23:59:59";
            // $criteria->addCondition('jadwaldokter_mulai BETWEEN DATE_ADD(NOW(), INTERVAL -2 MONTH)');
            $criteria->addCondition("jadwaldokter_tgl ='" . $tgl_awal . "'");
            $criteria->addCondition("'" . $waktu . "' between jadwaldokter_mulai and jadwaldokter_tutup");

            // $criteria->addCondition('jadwaldokter_mulai <='."'".date('H:i:s')."'");
            // $criteria->addCondition('jadwaldokter_tutup <='."'".date('H:i:s', strtotime('+2 HOUR'))."'");
            // $criteria->addCondition('jadwaldokter_tgl::date ='."'".date('Y-m-d')."'");
            // select * from  jadwaldokter_m  WHERE jadwaldokter_mulai >= '14:00:00' - INTERVAL '1' HOUR
            // print_r($criteria);
            // exit();
            $models = JadwaldokterM::model()->findAll($criteria);

            // var_dump($models);die;




            echo CJSON::encode($this->renderPartial($this->pathView_umum_asuransi . '_dokter', array('modDokters' => $models, 'kode' => $kode), true));


            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDaftarBooking() {

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "No Booking pasien berhasil didaftarkan.";
        $no_booking = strtoupper(trim($_POST['no_booking']));

        $janji = BuatjanjipoliT::model()->findByAttributes(array(
            'no_buatjanji' => $no_booking,
        ));

        if (empty($janji) || empty($janji->pasien_id)) {
            echo CJSON::encode(array(
                'ok' => 0, 'msg' => "Data booking tidak ditemukan.",
            ));
            Yii::app()->end();
        }

        if (!empty($janji->pendaftaran_id)) {
            echo CJSON::encode(array(
                'ok' => 0, 'msg' => "Data booking sudah didaftarkan sebelumnya.",
            ));
            Yii::app()->end();
        }

        $tgl_booking = date('Y-m-d', strtotime($janji->tgljadwal));

        if ($tgl_booking != date('Y-m-d')) {
            echo CJSON::encode(array(
                'ok' => 0, 'msg' => "Hanya bisa didaftarkan pada " . MyFormatter::formatDateTimeForUser($tgl_booking) . ".",
            ));
            Yii::app()->end();
        }

        $modPasien = PasienM::model()->findByPk($janji->pasien_id);

        $penjamin = null;
        if (!empty($janji->penjamin_id)) {
            $penjamin = PenjaminpasienM::model()->findByPk($janji->penjamin_id);
            if (!empty($penjamin)) {
                if ($penjamin->carabayar_id != Params::CARABAYAR_ID_MEMBAYAR) {
                    echo CJSON::encode(array(
                        'ok' => 0, 'msg' => "Data booking tidak ditemukan.",
                    ));
                    Yii::app()->end();
                }
            } else {
                $penjamin = PenjaminpasienM::model()->findByPk(Params::PENJAMIN_ID_UMUM);
                if (empty($penjamin)) {
                    echo CJSON::encode(array(
                        'ok' => 0, 'msg' => "Data booking tidak ditemukan.",
                    ));
                    Yii::app()->end();
                }
            }
        } else {
            $penjamin = PenjaminpasienM::model()->findByPk(Params::PENJAMIN_ID_UMUM);
            if (empty($penjamin)) {
                echo CJSON::encode(array(
                    'ok' => 0, 'msg' => "Data booking tidak ditemukan.",
                ));
                Yii::app()->end();
            }
        }

        // simpan pendaftaran
        $trans = Yii::app()->db->beginTransaction();
        $tok = true;

        try {
            $model = new PendaftaranT;

            $model->attributes = $janji->attributes;
            if (!empty($penjamin)) {
                $model->penjamin_id = $penjamin->penjamin_id;
                $model->carabayar_id = $penjamin->carabayar_id;
            }
            $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
            $jenis = KasuspenyakitruanganM::model()->findByAttributes(array(
                'ruangan_id' => $model->ruangan_id,
            ));

            if (!empty($jenis)) {
                $model->jeniskasuspenyakit_id = $jenis->jeniskasuspenyakit_id;
            }

            $model->tgl_pendaftaran = date('Y-m-d H:i:s');
            $model->instalasi_id = $model->ruangan->instalasi_id;
            $model->statuspasien = Params::STATUSPASIEN_LAMA;
            $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
            $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
            $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
            $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
            $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id, $model->tgl_pendaftaran);
            $model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
            $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
            $model->keterangan_pendaftaran = "Daftar Booking Poli : " . $no_booking;

            $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
            $estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;

            $tgl_awal = date('Y-m-d');
            $tgl_akhir = date('Y-m-d');
            $criteria = new CDbCriteria();
            $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
            $criteria->addCondition("tgl_pendaftaran::date = '" . $tgl_awal . "'");
            $criteria->order = 'tgl_pendaftaran DESC';
            $dataPendaftaran = PendaftaranT::model()->find($criteria);
            // var_dump($estimasipelayanan, $dataPendaftaran->attributes); die;


            $tgldaftar = new DateTime($model->tgl_pendaftaran);
            if (!empty($dataPendaftaran) && !empty($dataPendaftaran->tglakandilayani)) {
                $tglakandilayani = new DateTime($dataPendaftaran->tglakandilayani);

                if ($tgldaftar < $tglakandilayani) {
                    $tglakandilayani->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                    $model->tglakandilayani = $tglakandilayani->format('Y-m-d H:i:s');
                } else {
                    $tgldaftar->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                    $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
                }
            } else {
                $tgldaftar->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
            }

            $model->tglakandilayani = $model->tgl_pendaftaran;
            $model->no_urutantri = $janji->no_antrianjanji;
            $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
            $model->create_time = $model->update_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = $model->update_loginpemakai_id = 1;
            $model->create_ruangan = 2;

            if ($model->validate()) {
                $tok = $tok && $model->save();
                $janji->pendaftaran_id = $model->pendaftaran_id;
                $janji->save();
            } else {
                $tok = false;
            }

            // var_dump($tok, $model->errors, $model->attributes, $janji->attributes, $_POST); die;

            if ($tok) {
                $trans->commit();
                echo CJSON::encode(array(
                    'ok' => $ok, 'msg' => $msg, 'id' => $model->pendaftaran_id,
                ));
                Yii::app()->end();
            } else {
                $trans->rollback();
                echo CJSON::encode(array(
                    'ok' => 0, 'msg' => "No Booking pasien gagal didaftarkan.",
                ));
                Yii::app()->end();
            }
        } catch (Exteption $e) {
            $trans->rollback();
            echo CJSON::encode(array(
                'ok' => 0, 'msg' => $e->getMessage(),
            ));
            Yii::app()->end();
        }





        echo CJSON::encode(array(
            'ok' => $ok, 'msg' => $msg,
        ));
    }

    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintKarcis($pendaftaran_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);

        if (!empty($lp))
            $modPegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
        else
            $modPegawai = new PegawaiM;

        $karcis_id = null;
        $modTindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
        $judul_print = 'Kunjungan ' . $modPendaftaran->ruangan->instalasi->instalasi_nama;

        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(140, 180));
        // $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/STRUCK.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
                $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printKarcis', array(
                    'format' => $format,
                    'modPendaftaran' => $modPendaftaran,
                    'judul_print' => $judul_print,
                    'modPasien' => $modPasien,
                    'modTindakan' => $modTindakan,
                    'modPegawai' => $modPegawai,
                        ), true)
        );
        $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

    public function actionDaftarPasien() {
        $format = new MyFormatter;

        $jenisAntrian = ModelantrianM::model()->findAll(" modelantrian_id IN ( 1, 3, 6, 5) AND modelantrian_aktif = TRUE ORDER BY modelantrian_nama ASC ");

        $hari = strtolower($format->getDayUser(date('w')));

        $cri = new CDbCriteria();
        $cri->group = $cri->select = " r.ruangan_id, r.ruangan_nama ";
        $cri->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id AND r.ruangan_aktif = TRUE ";
        $cri->addCondition(" LOWER(hari) ilike '%" . $hari . "%' ");
        $cri->order = " ruangan_nama ASC ";
        $polilinik = JadwalbukapoliM::model()->findAll($cri);

        $jenisKunjungan = LookupM::getItemsUrutan('jeniskunjunganantrian');

        $model = new AntrianT;

        $this->render('daftarPasien/index', [
            'jenisAntrian' => $jenisAntrian,
            'polilinik' => $polilinik,
            'jenisKunjungan' => $jenisKunjungan,
            'model' => $model
        ]);
    }

    public function actionCekNoRm() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $post = $_GET['ANAntrianT'];

        $norm = PasienM::model()->findByAttributes([
            'no_rekam_medik' => $post['no_rekam_medik']
        ]);

        $data['ada'] = true;
        if (empty($norm)) {
            $data['ada'] = false;
        }

        echo json_encode($data);
    }

}
