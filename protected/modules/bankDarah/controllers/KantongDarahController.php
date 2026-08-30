<?php

/**
 * Form untuk menginput transaksi kantong darah pendonor
 * Ditempatkan pada tabulasi Obeservasi Donor Darah
 * 
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author     Elham Budianto <elhambudianto@.com>
 * @author     Aida Rahmawati <aidarahmawati@.com>
 * @author     Andyka Putra <andykaputra@.com>
 * @author     M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @package    application.modules.bankDarah
 * @subpackage controllers
 * 
 */
class KantongDarahController extends MyAuthController {
//    public $layout = '//layouts/iframe';

    /**
     * Form Pencatatan Kantong Darah dari Pendonor
     * @param type $kantong
     */
    public function actionIndex($kantong = null) {

        // percepat proses pencarian dialog
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'pegawaimenyetujui-grid') {
                $this->renderPartial('dialog/_dialogDaftarPendonor');
                Yii::app()->end();
            }
        }
        $kantongdarah_id = array();

        $model = new KantongdarahT;
        $model->tglpencatatan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->bulan = date('m');
        $model->jml_input = 1;
        $modSeleksi = new BDSeleksipendonorT();
        $modPendonor = new BDPendonorM();
        $modPendonor->is_pernah_donor = 1;

        if (empty($kantong)) {
            $models = new KantongdarahT;
            $models = array();
        } else {
            $cekKantong = KantongdarahT::model()->findByPk($kantong);
            
            $criteria = new CDbCriteria();
            $criteria->addCondition("create_time = '" . $cekKantong->create_time . "'");
            $criteria->addCondition("create_loginpemakai_id = " . $cekKantong->create_loginpemakai_id . "");
            $criteria->addCondition("create_ruangan = " . $cekKantong->create_ruangan . "");
            $models = KantongdarahT::model()->findAll($criteria);
            $model = $models[0];
        }

        if (isset($_POST['KantongdarahT']) && isset($_POST['komponen'])) {
            // echo '<pre>';var_dump($_POST);die;
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            $kantong_id = array();
            $sample = MyGenerator::noBarcodeKantongDarah($_POST['KantongdarahT']['jeniskantongdarah_id'], Params::PREFIX_KANTONG_DARAH_SAMPLE);
            $sample_kantong = date('my') . substr($sample, 4+ strlen(Params::PREFIX_KANTONG_DARAH_SAMPLE));
            $gen = substr($sample,strlen(Params::PREFIX_KANTONG_DARAH_SAMPLE));
            $jml_input = $_POST['KantongdarahT']['jml_input'];
            $bulan = $_POST['KantongdarahT']['bulan'];
            $tahun = substr($_POST['KantongdarahT']['tahun'],2);
            try {
                for($i = 1; $i < ($jml_input+1); $i++){
                    foreach ($_POST['komponen'] as $komponen_id => $item) {
                        $model = new KantongdarahT;
                        $kom = KomponendarahM::model()->findByPk($komponen_id);
                        if(isset($_POST['BDPendonorM']['pendonor_id']) && $_POST['BDPendonorM']['pendonor_id'] != ''){
                            $model->pendonor_id = $_POST['BDPendonorM']['pendonor_id'];
                        } else {
                            $model->pendonor_id = null;
                        }
                        $model->daftarpendonor_id = null;
                        $model->attributes = $_POST['KantongdarahT'];
                        $model->no_kantongpabrik = $_POST['KantongdarahT']['no_kantongpabrik'];
                        $model->tglpencatatan = MyFormatter::formatDateTimeForDb($model->tglpencatatan);
                        $model->no_kantongdarah = MyGenerator::noKantongDarah($_POST['KantongdarahT']['jeniskantongdarah_id'], $komponen_id, $bulan, $tahun);
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $model->komponendarah_id = $komponen_id;
                        $model->jmlprint_barcode = 0;
                        if($_POST['KantongdarahT']['jeniskantongdarah_id'] == Params::ID_JENIS_KANTONG_DARAH_SINGLE){
                            $model->nomorbarcode_utama = 'WB'. substr($model->no_kantongdarah,2);
                            $model->nomorbarcode_sample = 'WB'. substr($model->no_kantongdarah,2);
                        }else if($_POST['KantongdarahT']['jeniskantongdarah_id'] == Params::ID_JENIS_KANTONG_DARAH_DOUBLE){
                            $model->nomorbarcode_utama = 'PR'. substr($model->no_kantongdarah,2);
                            $model->nomorbarcode_sample = 'PR'. substr($model->no_kantongdarah,2);
                        }else if($_POST['KantongdarahT']['jeniskantongdarah_id'] == Params::ID_JENIS_KANTONG_DARAH_TRIPLE){
                            $model->nomorbarcode_utama = 'PR'. substr($model->no_kantongdarah,2);
                            $model->nomorbarcode_sample = 'PR'. substr($model->no_kantongdarah,2);
                        }else if($_POST['KantongdarahT']['jeniskantongdarah_id'] == Params::ID_JENIS_KANTONG_DARAH_QUADRUPLE){
                            $model->nomorbarcode_utama = 'PC'. substr($model->no_kantongdarah,2);
                            $model->nomorbarcode_sample = 'PC'. substr($model->no_kantongdarah,2);
                        }
                        $exp = explode(' ', (string)$model->tglpencatatan);
                        if(isset($exp[0])) {
                            $nobarcode = date("ymd", strtotime($exp[0]));
                            $model->nomorbarcode_skrinning = $nobarcode . 'S4'; 
                            $model->nomorbarcode_edta = $nobarcode . 'S5';
                        }
                        if ($model->validate()) {
                            $ok = $ok && $model->save();
                        } else {
                            $ok = false;
                        }
                    }
                }

                // echo '<pre>';
                // proses insert seleksi pendonor
                if(isset($_POST['BDPendonorM']['pendonor_id']) && $_POST['BDPendonorM']['pendonor_id'] != ''){
                    $modPendonor = BDPendonorM::model()->findByPk($_POST['BDPendonorM']['pendonor_id']);
                    if(!empty($modPendonor)) {
                        $modSeleksiPendonor = $this->insertSeleksiPendonor($_POST['BDSeleksipendonorT'], $_POST['BDPendonorM'], $model);
                        $this->insertSeleksiQuisioner($modPendonor, $modSeleksiPendonor);
                    }
                }
                // die;

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                    $this->redirect(array('index', 'kantong' => $model->kantongdarah_id, 'bulan'=>$_POST['KantongdarahT']['bulan'], 'tahun' => $_POST['KantongdarahT']['tahun'], 'jml_input'=>$_POST['KantongdarahT']['jml_input']));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                    $this->redirect(array('index'));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }


        $this->render('index', array(
            'model' => $model,
            'models' => $models,
            'kantongdarah_id' => $kantongdarah_id,
            'modSeleksi' => $modSeleksi,
            'modPendonor' => $modPendonor
        ));
    }

    function insertSeleksiPendonor($postSeleksi, $postPendonor, $modKantong) {
        $modDaftarDonasi = DaftardonasiT::model()->findByAttributes(['pendonor_id' => $postPendonor['pendonor_id']], ['order' => 'donasi_ke DESC']);
        $donasi_ke = 1;
        if(!empty($modDaftarDonasi)) {
            $donasi_ke = $modDaftarDonasi->donasi_ke + 1; 
        }

        $modDonasi = new DaftardonasiT();
        $modDonasi->pendonor_id = $postPendonor['pendonor_id'];
        $modDonasi->no_formulir = MyGenerator::noFormulirPendonor();
        $modDonasi->nama_petugas_id = Yii::app()->user->getState('pegawai_id');
        $modDonasi->donasi_ke = $donasi_ke;
        $modDonasi->create_time = date('Y-m-d H:i:s');
        $modDonasi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modDonasi->create_ruangan = Yii::app()->user->getState('create_ruangan');
        $modDonasi->ruangan_rekruitmen_id = Params::RUANGAN_ID_BANK_DARAH;
        $modDonasi->waktu_pendaftaran = date('Y-m-d H:i:s');
        $modDonasi->status = 'SELEKSI';
        $modDonasi->ruangan_id = Params::RUANGAN_ID_BANK_DARAH;
        $modDonasi->rhesus = $_POST['BDPendonorM']['rhesus'];
        $modDonasi->gol_darah = $_POST['BDPendonorM']['gol_darah'];
        $modDonasi->save();

        $modKantong->daftarpendonor_id = $modDonasi->daftardonasi_id;
        $modKantong->update();
        // echo '<pre>';var_dump($modDonasi->getErrors());die;

        $model = new BDSeleksipendonorT;
        $model->attributes = $postSeleksi;
        $model->attributes = $modDonasi;
        $model->attributes = $postPendonor;
        $model->daftardonasi_id = $modDonasi->daftardonasi_id;
        $model->tglseleksikuesioner = date('Y-m-d H:i:s');
        $model->tglseleksidonor = date('Y-m-d H:i:s');
        $model->tglseleksidonor = MyFormatter::formatDateTimeForDb($model->tglseleksidonor);
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->create_time = date('Y-m-d H:i:s');
        $model->jenisdonor = "Sukarela";
        $model->status_pendonor = "DITERIMA";
        $model->tekanandarah = isset($model->td_systolic) ? $model->td_systolic . " / " . $model->td_diastoliic : '';
        $model->td_systolic = isset($model->td_systolic) ? $model->td_systolic : '';
        $model->td_diastoliic = isset($model->td_diastoliic) ? $model->td_diastoliic : '';
        $model->kadar_hb = isset($model->kadar_hb) ? $model->kadar_hb : '';
        
        $model->hb_rendah = 0;
        $model->bb_rendah = 0;
        $model->medis_hb_17 = 0;
        $model->medis_td_rendah = 0;
        $model->medis_tk_tinggi = 0;
        $model->medis_bb_lebih = 0;
        $model->medis_vaksin = 0;
        $model->perilakuberesiko = 0;
        $model->riwberpergian = 0;
        $model->lain_lain = 0;
        $model->dpjpkuesioner_id = $postSeleksi['dpjpkuesioner_id'];
        
        $model->is_gagalseleksi = 0;
        $model->lain_lain = false;
        $model->status_pendonor = 'DITERIMA';
        $model->save();
        // echo '<pre>';var_dump($model->getErrors());die;
        return $model;
        
    }

    function insertSeleksiQuisioner($modPendonor, $modSeleksiPendonor) {
        $modKuesioner = new BDSeleksikuesionerT;

        if($modPendonor->jenis_kelamin =='PEREMPUAN') {
            $modPertanyaan = KuesionerdonorM::model()->findAll("kuesioner_aktif IS TRUE ORDER BY kuesioner_urutan ASC");            
        }else{
            $modPertanyaan = KuesionerdonorM::model()->findAll("kuesionerdonor_id NOT IN ('25', '26', '27')  and  kuesioner_aktif IS TRUE ORDER BY kuesioner_urutan ASC");    
        }

        if(!empty($modPertanyaan)) {
            foreach ($modPertanyaan as $value) {
                $modKuesioner = new BDSeleksikuesionerT;
                $modKuesioner->daftardonasi_id = $modSeleksiPendonor->daftardonasi_id;
                $modKuesioner->kuesionerdonor_id = $value->kuesionerdonor_id;
                $modKuesioner->seleksidonor_id = $modSeleksiPendonor->seleksidonor_id;
                $modKuesioner->ceklist = $value;
                $modKuesioner->save();
                // var_dump($modKuesioner->getErrors());
            }
        }
    }

    /**
     * Menampilkan Field Nomor Komponen Darah berdasarkan Jenis Kantong-nya
     */
    public function actionGetJenisKantongDarah() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['id'];
        $jml_input = $_POST['jml_input'];

        $komponen = KomponendarahM::model()->findAllByAttributes(array(
            'jeniskantongdarah_id' => $id,
            'komponendarah_aktif' => true,
                ), array(
            'order' => 'komponendarah_id',
        ));

        $str = "";
        for($i = 1; $i < ($jml_input+1); $i++){
            foreach ($komponen as $item) {
                $str .= CHtml::textField('komponen[' . $item->komponendarah_id . ']kode', $item->singkatan_komp, array(
                            'class' => 'span1',
                            'readonly' => true,
                ));
                $str .= CHtml::textField('komponen[' . $item->komponendarah_id . ']no', '-- Otomatis --', array(
                            'class' => 'span2',
                            'readonly' => true,
                ));
                $str .= '<br/>';
            }
        }

        echo CJSON::encode(array('html' => $str));
    }

    /**
     * Cetak 
     */
    public function actionPrint() {
        $this->render('print');
    }

    /**
     * Menampilkan item Nama Petugas untuk input Autocomplete Petugas.
     * 
     * @param string $term Nama Petugas yang dicari
     */
    public function actionAutocompleteGetPetugas($term) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $cr = new CDbCriteria;
        $cr->compare('lower(nama_pegawai)', strtolower($term), true);
        $cr->addCondition('pegawai_aktif = true');

        $cr->order = 'nama_pegawai';
        $cr->limit = 15;

        $model = PegawaiM::model()->findAll($cr);
        $res = array();


        foreach ($model as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->nama_pegawai;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    /**
     * Digunakan untuk menampilkan detail kantong
     * @param type $daftarpendonor_id
     * @param type $pendonor_id
     */
    public function actionDetailkantong($daftarpendonor_id, $pendonor_id) {
        $this->layout = '//layouts/iframe';
        $model = BDObservasipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftarpendonor_id));

        $cri = new CDbCriteria;
        $cri->addCondition("pendonor_id = " . $pendonor_id);
        $cri->addCondition("daftarpendonor_id = " . $daftarpendonor_id);
        $cri->group = "t.nomorbarcode_utama";
        $cri->select = "t.nomorbarcode_utama";
        $modKantong = KantongdarahT::model()->findAll($cri);
        $modDaftarDonasi = BDDaftardonasiT::model()->findByPk($daftarpendonor_id);
        $modPendonor = BDPendonorM::model()->findByPk($modDaftarDonasi->pendonor_id);
        $modPendonor->no_formulir = $modDaftarDonasi->no_formulir;
        $modPendonor->tgllahir = !empty($modPendonor->tgllahir) ? MyFormatter::formatDateTimeForUser($modPendonor->tgllahir) : null;
        $modPendonor->umur = CustomFunction::getUmur($modPendonor->tgllahir);
        $modelKantong = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id' => $daftarpendonor_id, 'pendonor_id' => $pendonor_id));
        $modSeleksi = BDSeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $daftarpendonor_id));

        if (empty($modSeleksi)) {
            $modSeleksi = new BDSeleksipendonorT;
        }

        $this->render('detailkantong', array(
            'model' => $model,
            'modKantong' => $modKantong,
            'modelKantong' => $modelKantong,
            'modPendonor' => $modPendonor,
            'modSeleksi' => $modSeleksi,
            'modDaftarDonasi' => $modDaftarDonasi
        ));
    }

    /**
     * Print barcode
     * @param type $kantongdarah_id
     * @param type $bulan
     * @param type $jml_input
     * @param type $jenis
     * @param type $nomorbarcode_utama
     */
    public function actionPrintBarcode($kantongdarah_id=null, $bulan=null, $jml_input=null, $jenis=null, $nomorbarcode_utama=null) {
        $format = new MyFormatter;
        $this->layout = '//layouts/printWindows';
        //Dicari 1 data, lalu komponennya dipisahkan dari no_kantongdarah
        //maka, akan didapatkan nomornya saja agar bisa dicari semua data no_kantongdarah yang memiliki nomor tsb        
        if (empty($jenis)){
            
            $cekkantong = KantongdarahT::model()->findByPk($kantongdarah_id);
    //        $kantong = substr($cekkantong->no_kantongdarah,2);

            $criteria = new CDbCriteria();
            $criteria->addCondition("create_time = '" . $cekkantong->create_time . "'");
            $criteria->addCondition("create_loginpemakai_id = " . $cekkantong->create_loginpemakai_id . "");
            $criteria->addCondition("create_ruangan = " . $cekkantong->create_ruangan . "");
            // $criteria->addCondition('(komponendarah_id = 7) OR (komponendarah_id = 8) OR (komponendarah_id = 10) OR (komponendarah_id = 15)');
            $criteria->order = 'no_kantongdarah desc';
            $modKantongDarah = KantongdarahT::model()->findAll($criteria);
        }else{
                                                 
            $modKantongDarah = KantongdarahT::model()->findAll("nomorbarcode_utama = '".$nomorbarcode_utama."' limit 1 ");                     
        }
        
        // echo '<pre>';var_dump($modKantongDarah);die;
        $judul_print = 'Barcode';
        //lebar, panjang
        $mpdf = new MyPDF60('', array(60, 25));
        $posisi = 'P';
        // $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->setHtmlFooter('<span></span>');
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(utf8_encode(
                        $this->renderPartial('_printBarcodepdf', array(
                            'format' => $format,
                            'judul_print' => $judul_print,
                            'modKantongDarah' => $modKantongDarah,
                            'jenis'=> $jenis,
                            'jml_input'=>$jml_input
                                ), true)));
        $mpdf->Output("Barcode.pdf", 'I');
    }
    
    /**
     * Daftar barcode per tanggal 
     * @param type $bulan
     * @param type $jeniskantong
     * @param type $waktu
     */
    public function actionListBarcodeByTanggal($bulan, $jeniskantong,$waktu){
        $this->layout = '//layouts/iframe';
        
        $load = new BDKantongdarahT();                
        $load->tgl_awal = MyFormatter::formatDateTimeForDb($waktu);
        $load->tgl_akhir = MyFormatter::formatDateTimeForDb($waktu);
        $models = $load->criteriaInformasiBarcode();
        
        $nomorbarcode = array();

        foreach($models as $ii => $dt){                       
            if ($waktu == $dt['tglcetak'] && $bulan == $dt['bulan'].' '.$dt['tahun'] && $jeniskantong == $dt['jeniskantongdarah_id'] ){
                $nomorbarcode[$dt['nomorbarcode_utama']] = $dt['nomorbarcode_utama'];
            }
        }

        $modKantongDarah = $nomorbarcode;
            
        $this->render('infoBarcode/listDetail',array('model'=>$modKantongDarah));
    }
    
    /**
     * Cetak semua barcode 
     * @param type $nomorbarcode_utama
     */
    public function actionPrintAllBarcode($nomorbarcode_utama) {
        
        $judul_print = 'Barcode Komponen';
        
        $nomorbarcode_utama = explode(',',$nomorbarcode_utama);
        
        
        $mod = new BDKantongdarahT();
        $mod->nomorbarcode_utama = $nomorbarcode_utama;
        $mod->disable_tgl = true;
        $modKantongDarah = $mod->criteriaInformasiBarcode();
        
        $mpdf = new MyPDF('', array(80, 28));
        $posisi = 'P';
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(utf8_encode(
                        $this->renderPartial('_printAllBarcodePDF', array(                            
                            'judul_print' => $judul_print,
                            'modKantongDarah' => $modKantongDarah,                            
                                ), true)));
        $mpdf->Output("Barcode.pdf", 'I');            
    }

    /**
     * untuk print barcode komponen
     * @param type $kantongdarah_id
     * @param type $bulan
     * @param int $jml_input
     * @param type $jenis
     * @param type $no_kantongdarah
     * @param type $tipe_transaksi
     */
    public function actionPrintBarcodeKomponen($kantongdarah_id=null, $bulan=null, $jml_input=null, $jenis=null,$no_kantongdarah=null,$tipe_transaksi=null) {
        $format = new MyFormatter;
        
        //Dicari 1 data, lalu komponennya dipisahkan dari no_kantongdarah
        //maka, akan didapatkan nomornya saja agar bisa dicari semua data no_kantongdarah yang memiliki nomor tsb        
        if (empty($jenis)){
            $cekkantong = KantongdarahT::model()->findByPk($kantongdarah_id);
            $kantong = substr($cekkantong->no_kantongdarah,2);

            $criteria = new CDbCriteria();
    //        $criteria->addCondition("no_kantongdarah like '%" . $kantong . "%'");
    //        if (!empty($daftarpendonor_id)) {
    //            $criteria->addCondition('daftarpendonor_id =' . $daftarpendonor_id);
    //        }
            if (empty($tipe_transaksi)){
                $criteria->addCondition("create_time = '" . $cekkantong->create_time . "'");
                $criteria->addCondition("create_loginpemakai_id = " . $cekkantong->create_loginpemakai_id . "");
                $criteria->addCondition("create_ruangan = " . $cekkantong->create_ruangan . "");
                $criteria->addCondition('(komponendarah_id = 7) OR (komponendarah_id = 9) OR (komponendarah_id = 11 OR komponendarah_id = 12) OR (komponendarah_id = 14 OR komponendarah_id = 16)');
            }elseif($tipe_transaksi == 'buat_komponen'){
                $criteria->addCondition("kantongdarah_id = '" .$kantongdarah_id . "'");                
                $jml_input = 1;
            }
            $criteria->order = 'no_kantongdarah desc';
            $modKantongDarah = KantongdarahT::model()->findAll($criteria);            
        }else{
            if (empty($tipe_transaksi)){
                $modKantongDarah = KantongdarahT::model()->findAll("no_kantongdarah = '".$no_kantongdarah."' ");                     
            }else{
                $modKantongDarah = KantongdarahT::model()->findAll("kantongdarah_id = '".$kantongdarah_id."' ");                     
            }
        }
        
        $judul_print = 'Barcode Komponen';
        //lebar, panjang
        $mpdf = new MyPDF60('', array(80, 28));
        $posisi = 'P';
        // $mpdf->mirrorMargins = 2;
        $mpdf->setHTMLFooter('<span></span>');
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(utf8_encode(
                        $this->renderPartial('_printBarcodeKomponenpdf', array(
                            'format' => $format,
                            'judul_print' => $judul_print,
                            'modKantongDarah' => $modKantongDarah,
                            'jenis'=>$jenis,
                            'jml_input'=>$jml_input
                                ), true)));
        $mpdf->Output("Barcode.pdf", 'I');
    }

    /**
     * Fungsi untuk Menampilkan Dialog PPDS
     */
    public function actionAutocompletePpds() {
        if (Yii::app()->request->isAjaxRequest) {

            $returnVal = array();
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
            //$criteria->addCondition('ppds_aktif IS true');
            $criteria->order = 'ppds_nama ASC';
            $criteria->limit = 10;
            $models = PpdsM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nama;
                $returnVal[$i]['ppds_nama'] = $model->ppds_nama;
                $returnVal[$i]['value'] = $model->ppds_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * digunakan untuk masuk ke halaman informasi barcode
     */
    public function actionInformasiBarcode(){
        $model = new BDKantongdarahT();
        
        $tes = '041900001';        
        
        $model->tgl_awal = date('Y-m-01');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['BDKantongdarahT'])){
            $model->attributes = $_GET['BDKantongdarahT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDKantongdarahT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDKantongdarahT']['tgl_akhir']);
            $model->jeniskantongdarah_nama = isset($_GET['BDKantongdarahT']['jeniskantongdarah_nama'])?$_GET['BDKantongdarahT']['jeniskantongdarah_nama']:null;
            $model->nomorbarcode_utama = isset($_GET['BDKantongdarahT']['nomorbarcode_utama'])?$_GET['BDKantongdarahT']['nomorbarcode_utama']:null;
            $model->cekBulan = isset($_GET['BDKantongdarahT']['cekBulan'])?$_GET['BDKantongdarahT']['cekBulan']:null;
            $model->cekTahun = isset($_GET['BDKantongdarahT']['cekTahun'])?$_GET['BDKantongdarahT']['cekTahun']:null;
            $model->tahun = isset($_GET['BDKantongdarahT']['tahun'])? substr($_GET['BDKantongdarahT']['tahun'],2) : null;
            $model->bulan = isset($_GET['BDKantongdarahT']['bulan'])?$_GET['BDKantongdarahT']['bulan']:null;
            //$model->jeniskantongdarah_nama = isset($_GET['BDKantongdarahT']['jeniskantongdarah_nama'])?$_GET['BDKantongdarahT']['jeniskantongdarah_nama']:null;            
        }
        
        $this->render("infoBarcode/index",array('model'=>$model));
    }

}
