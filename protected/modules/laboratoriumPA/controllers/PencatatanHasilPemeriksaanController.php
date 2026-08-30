<?php
Yii::import('laboratoriumPA.controllers.PemeriksaanPasienLaboratoriumController');

/**
 * Controller untuk pencatatan hasil pemeriksaan
 * @author Elham Budianto <elhambudianto@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.laboratoriumPA
 * @subpackage controllers
 * @category controller
 * ada kondisi :
 * 1. untuk pemeriksaan klinik (LBHasilPemeriksaanLabT & LBDetailHasilPemeriksaanLabT)
 * 2. untuk pemeriksaan anatomi (LBHasilPemeriksaanPAT)
 */
class PencatatanHasilPemeriksaanController extends PemeriksaanPasienLaboratoriumController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = "laboratoriumPA.views.pemeriksaanPasienLaboratorium.";
    public $path_view_pendaftaran = "laboratoriumPA.views.pendaftaranLaboratorium.";
    public $hasilpemeriksaanpa = true;

    /**
     * Tambah / Ubah Pemeriksaan Laboratorium.
     * @param type $pasienmasukpenunjang_id
     */
    public function actionIndex($pasienmasukpenunjang_id = null) {
        $format = new MyFormatter();
        $modKunjungan = new LBPasienMasukPenunjangV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modPemeriksaanLab = new LBTarifpemeriksaanlabruanganV;
        $modHasilPemeriksaan = new LBHasilPemeriksaanPAT;
        $modTindakan = new LBTindakanPelayananT;
        $modPasienMorbiditas = new LBPasienmorbiditasT();
        $dataHasilPemeriksaanPAs = array();
        $dataDetails = array();
        $modAnamnesa = new LBAnamnesaT;
        $modPemeriksaan = new LBPemeriksaanfisikT;
        $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : $pasienmasukpenunjang_id);
        if (!empty($pasienmasukpenunjang_id)) {
            $loadModKunjungan = $this->loadModPasienMasukPenunjang($pasienmasukpenunjang_id);
            if (isset($loadModKunjungan)) {
                $modKunjungan = $loadModKunjungan;
                $modKunjungan->dokterperujuk = $modKunjungan->getDokterPerujuk();
                //if($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
                
                $loadHasilPemeriksaan = LBHasilPemeriksaanPAT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $loadModKunjungan->pasienmasukpenunjang_id));
                if (!empty($loadHasilPemeriksaan)){
                if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
                    Yii::app()->user->setFlash('warning', "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !");
                } else {
                    $modHasilPemeriksaan = $loadHasilPemeriksaan;
                }
            }
                //}else if($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
                //}
            }
        }

        if (isset($_POST['pasienmasukpenunjang_id']) && (isset($_POST['LBHasilPemeriksaanLabT']) || isset($_POST['LBHasilPemeriksaanPAT']))) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                    if (isset($_POST['LBHasilPemeriksaanLabT'])) {
                        $modHasilPemeriksaan->attributes = $_POST['LBHasilPemeriksaanLabT'];
                        $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG;
                        $modHasilPemeriksaan->tglhasilpemeriksaanlab = $format->formatDateTimeForDb($_POST['LBHasilPemeriksaanLabT']['tglhasilpemeriksaanlab']);
                        $modHasilPemeriksaan->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['LBHasilPemeriksaanLabT']['tglpengambilanhasil']);
                        $modHasilPemeriksaan->catatanlabklinik = (isset($_POST['LBHasilPemeriksaanLabT']['catatanlabklinik']) ? $_POST['LBHasilPemeriksaanLabT']['catatanlabklinik'] : null);
                        $modHasilPemeriksaan->kesimpulan = (isset($_POST['LBHasilPemeriksaanLabT']['kesimpulan']) ? $_POST['LBHasilPemeriksaanLabT']['kesimpulan'] : null);
                        $modHasilPemeriksaan->update_time = date('Y-m-d H:i:s');
                        $modHasilPemeriksaan->update_loginpemakai_id = Yii::app()->user->id;
                        if ($modHasilPemeriksaan->update()) {
                            $this->hasilpemeriksaantersimpan = true;
                        } else {
                            $this->hasilpemeriksaantersimpan = false;
                        }
                    }
                }
                if (isset($_POST['LBDetailHasilPemeriksaanLabT'])) {
                    if (count($_POST['LBDetailHasilPemeriksaanLabT']) > 0) {
                        foreach ($_POST['LBDetailHasilPemeriksaanLabT'] AS $i => $postDetail) {
                            $dataDetails[$i] = $this->ubahDetailHasilPemeriksaanLab($postDetail);
                        }
                    }
                }
                if (isset($_POST['LBHasilPemeriksaanPAT'])) {
                    if (count($_POST['LBHasilPemeriksaanPAT']) > 0) {
                        foreach ($_POST['LBHasilPemeriksaanPAT'] AS $i => $postDetail) {
                            $dataDetails[$i] = $this->ubahHasilPemeriksaanPA($postDetail);
                        }
                    }
                }
                if ($this->hasilpemeriksaantersimpan) {
                    $pasien = PasienmasukpenunjangV::model()->find(" pasienmasukpenunjang_id = '" . $pasienmasukpenunjang_id . "' ");
                    $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    $modul = RuanganM::model()->findByPk($pasien->ruanganasal_id);
                    if ($pasien->ruanganasal_id != Params::RUANGAN_ID_LAB_KLINIK) {
                        $judul = 'Hasil Pemeriksaan Laboratorium';
                        $isi = $peg->namaLengkap . ' sudah mencatatkan / mengubah data hasil pemeriksaan untuk pasien ' . $pasien->nama_pasien . ' (No RM' . $pasien->no_rekam_medik . ') pada tanggal ' . MyFormatter::formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab);
                        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                                    array('instalasi_id' => $pasien->instalasiasal_id, 'ruangan_id' => $pasien->ruanganasal_id, 'modul_id' => $modul->modul_id),
                        ));
                    }

                    if (!empty($_POST['pasienmasukpenunjang_id'])) {
                        $up = PasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
                        $up->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA;
                        $up->save();
                    }

                    Yii::app()->user->setFlash('success', "Data pemeriksaan pasien laboratorium berhasil disimpan !");
                    $transaction->commit();
                    $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modKunjungan->pasienmasukpenunjang_id, 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render('index', array(
            'format' => $format,
            'modKunjungan' => $modKunjungan,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'modTindakan' => $modTindakan,
            'dataDetails' => $dataDetails,
            'modAnamnesa' => $modAnamnesa,
            'modPemeriksaan' => $modPemeriksaan,
            'modPasienMorbiditas' => $modPasienMorbiditas,
        ));
    }

    /**
     * Cetak hasil laboratorium 
     * @param type $pasienmasukpenunjang_id
     * @param type $frame
     * @param type $caraPrint
     */
    public function actionPrint($pasienmasukpenunjang_id, $frame = null, $caraPrint = null) {
        if ($frame == 1) {
            $this->layout = '//layouts/iframe';
        } else {
            $this->layout = '//layouts/printWindows';
        }

        $format = new MyFormatter();
        $judulLaporan = "Hasil Pemeriksaan Laboratorium";
        //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
        $modKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);

        $data = array();

        foreach ($modDetailHasilPemeriksaans as $dt) {
            $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
            $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
            $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
            $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;
            //	if (isset($data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"])){
            //	$total = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] + 1;
            //	}else{
            //	$total = 1;
            //	}


            $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
            $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;
            /* $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] = $total;			
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["nilairujukan"]["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama.' '.(($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-')?$dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan:''); */
            //change
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
            //$data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"]['total'] = $kelompokdet;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
            $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
        }

//        $this->render('printHasilPemeriksaan',array(
//            'format'=>$format,
//            'modKunjungan'=>$modKunjungan,
//            'modHasilPemeriksaan'=>$modHasilPemeriksaan,
//            'modDetailHasilPemeriksaans'=>$modDetailHasilPemeriksaans,
//            'judulLaporan'=>$judulLaporan,
//            'caraPrint'=>$caraPrint,
//        ));
        $this->render('printHasilPemeriksaan', array(
            'format' => $format,
            'modKunjungan' => $modKunjungan,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint,
            'data' => $data
        ));
    }

    /**
     * cetak hasil pemeriksaan Patologi Anatomi
     * @param type $pasienmasukpenunjang_id
     * @param type $frame
     * @param type $caraPrint
     */
    public function actionPrintPA($pasienmasukpenunjang_id, $frame = null, $caraPrint = null) {
        if ($frame == 1) {
            $this->layout = '//layouts/iframe';
        } else {
            $this->layout = '//layouts/printWindows';
        }
        $format = new MyFormatter();
        $judulLaporan = "Hasil Pemeriksaan Patologi Anatomi";
        $modKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modHasilPemeriksaanPAs = $this->loadHasilPemeriksaanPAs($modKunjungan);
        $modHasilPemeriksaan = new LBHasilPemeriksaanLabT;
        $this->render('printHasilPemeriksaanPA', array(
            'format' => $format,
            'modKunjungan' => $modKunjungan,
            'modHasilPemeriksaanPAs' => $modHasilPemeriksaanPAs,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
        ));
    }

    /**
     * load LBDetailHasilPemeriksaanLabT
     * @param type $modHasilPemeriksaan
     */
    public function loadDetailHasilPemeriksaans($modHasilPemeriksaan) {
        $criteria = new CDbCriteria();
        $criteria->join = "
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
						JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id  
                        JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
        $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
        $criteria->order = "jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
        //$criteria->order = "pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
        $modDetailHasilPemeriksaans = LBDetailHasilPemeriksaanLabT::model()->findAll($criteria);
        return $modDetailHasilPemeriksaans;
    }

    /**
     *  load LBHasilPemeriksaanPAT
     * @param type $modPasienMasukPenunjang
     * @return type
     */
    public function loadHasilPemeriksaanPAs($modPasienMasukPenunjang) {
        $criteria = new CDbCriteria();
        $criteria->join = "JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id";
        $criteria->addCondition('t.pasienmasukpenunjang_id = ' . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
        $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC";
        $modHasilPemeriksaanPAs = LBHasilPemeriksaanPAT::model()->findAll($criteria);
        return $modHasilPemeriksaanPAs;
    }

    /**
     * simpan LBDetailHasilPemeriksaanLabT
     * @param type $post
     * @return type
     */
    public function ubahDetailHasilPemeriksaanLab($post) {
        $modDetailHasilPemeriksaans = LBDetailHasilPemeriksaanLabT::model()->findByPk($post['detailhasilpemeriksaanlab_id']);
        $modDetailHasilPemeriksaans->hasilpemeriksaan = $post['hasilpemeriksaan'];
        $modDetailHasilPemeriksaans->update_time = date("Y-m-d H:i:s");
        $modDetailHasilPemeriksaans->update_loginpemakai_id = Yii::app()->user->id;
        $modDetailHasilPemeriksaans->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modDetailHasilPemeriksaans->validate()) {
            $modDetailHasilPemeriksaans->update();
        } else {
            $this->hasilpemeriksaantersimpan &= false;
        }
        return $modDetailHasilPemeriksaans;
    }

    /**
     * simpan LBHasilPemeriksaanPAT
     * @param type $post
     * @return type
     */
    public function ubahHasilPemeriksaanPA($post) {
        $modHasilPemeriksaanPA = LBHasilPemeriksaanPAT::model()->findByPk($post['hasilpemeriksaanpa_id']);
        $modHasilPemeriksaanPA->tglperiksapa = MyFormatter::formatDateTimeForDb($post['tglperiksapa']);
        $modHasilPemeriksaanPA->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG;
        $modHasilPemeriksaanPA->makroskopis = $post['makroskopis'];
        $modHasilPemeriksaanPA->mikroskopis = $post['mikroskopis'];
        $modHasilPemeriksaanPA->kesimpulanpa = $post['kesimpulanpa'];
        $modHasilPemeriksaanPA->saranpa = $post['saranpa'];
        $modHasilPemeriksaanPA->catatanpa = $post['catatanpa'];
        if ($post['statushasilpemeriksaan'] == 1) { // jika checkbox dicentang maka Kritis
            $modHasilPemeriksaanPA->statushasilpemeriksaan = Params::STATUS_PEMERIKSAAN_PA_KRITIS;
        } else { // jika checkbox d-uncheck maka Normal 
            $modHasilPemeriksaanPA->statushasilpemeriksaan = Params::STATUS_PEMERIKSAAN_PA_NORMAL;
        }
        $modHasilPemeriksaanPA->update_time = date("Y-m-d H:i:s");
        $modHasilPemeriksaanPA->update_loginpemakai_id = Yii::app()->user->id;
        $modHasilPemeriksaanPA->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modHasilPemeriksaanPA->validate()) {
            $modHasilPemeriksaanPA->update();
        } else {
            $this->hasilpemeriksaantersimpan &= false;
        }
        return $modHasilPemeriksaanPA;
    }

    /**
     * set form hasil pemeriksaan
     */
    public function actionSetFormHasilPemeriksaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $rows = "";
            //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
            $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']));
            $hasilPemeriksaan = array();
            $attributes = $modHasilPemeriksaan->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $hasilPemeriksaan["$attribute"] = $modHasilPemeriksaan->$attribute;
            }
            $hasilPemeriksaan['tglhasilpemeriksaanlab'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglhasilpemeriksaanlab));
            $hasilPemeriksaan['tglpengambilanhasil'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglpengambilanhasil));

            $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
            $rows = $this->renderPartial("_rowsHasilPemeriksaan", array('modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans), true);
            echo CJSON::encode(array(
                'hasilPemeriksaan' => $hasilPemeriksaan,
                'rows' => $rows));
        }
        Yii::app()->end();
    }

    /**
     * set form hasil pemeriksaan patologi anatomi
     */
    public function actionSetFormHasilPemeriksaanPA() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
            $dataHasilPemeriksaanPAs = $this->loadHasilPemeriksaanPAs($modPasienMasukPenunjang);
            $rows = $this->renderPartial("_rowsHasilPemeriksaanPA", array('format' => $format, 'dataHasilPemeriksaanPAs' => $dataHasilPemeriksaanPAs), true);
            echo CJSON::encode(array(
                'rows' => $rows));
        }
        Yii::app()->end();
    }

    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetRiwayatAnamnesa() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
            $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
            $anamnesa = LBAnamnesaT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
            if (!empty($anamnesa)) {
                $modAnamnesa = $anamnesa;
            } else {
                $modAnamnesa = new LBAnamnesaT();
                $modAnamnesa->pendaftaran_id = $pendaftaran_id;
            }
            $modAnamnesa->pendaftaran_id = $modAnamnesa->pendaftaran_id;
            $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatAnamnesa", array('i' => 0, 'modAnamnesa' => $modAnamnesa), true);
            echo CJSON::encode(array(
                'rows' => $rows));
        }
        Yii::app()->end();
    }

    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetRiwayatPemeriksaanFisik() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
            $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
            $periksafisik = LBPemeriksaanfisikT::model()->find('pendaftaran_id = ' . $pendaftaran_id);
            if (!empty($periksafisik)) {
                $modPemeriksaan = $periksafisik;
            } else {
                $modPemeriksaan = new LBPemeriksaanfisikT;
                $modPemeriksaan->pendaftaran_id = $pendaftaran_id;
            }
            $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatPemeriksaanFisik", array('i' => 0, 'modPemeriksaan' => $modPemeriksaan), true);
            echo CJSON::encode(array(
                'rows' => $rows));
        }
        Yii::app()->end();
    }

    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetRiwayatDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
            $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            $pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
            $modPasienMorbiditas = new LBPasienmorbiditasT();
            $rows .= $this->renderPartial("laboratorium.views.pencatatanHasilPemeriksaan._riwayatDiagnosa", array('i' => 0, 'modPasienMorbiditas' => $modPasienMorbiditas, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang), true);
            echo CJSON::encode(array(
                'rows' => $rows));
        }
        Yii::app()->end();
    }

    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetTindakanPelayanan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $drop = '<option value="">-- Pilih --</option>';

            $modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
            if (count($modTindakans) > 0) {
                foreach ($modTindakans AS $i => $modTindakan) {
                    $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id;
                    $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
                    $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
                    $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);
                    $rows .= $this->renderPartial($this->path_view_pendaftaran . "_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
                }
            }
            echo CJSON::encode(array(
                'rows' => $rows,
                'drop' => $drop,
            ));
        }
        Yii::app()->end();
    }

}
