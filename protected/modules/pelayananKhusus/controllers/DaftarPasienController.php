<?php

/**
 * Informasi daftar pasien rehab medis
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.rehabMedis
 * @subpackage controllers
 * @category controller
 */
class DaftarPasienController extends MyAuthController {

    public $successSave = false;
    public $successSaveJadwal = true;
    public $successSaveHasil = true;
    public $path_view = "rehabMedis.views.daftarPasien.";

    /**
     * Default menu infromasi
     */
    public function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
        $modPasienMasukPenunjang = new RMMasukPenunjangV;
        $format = new MyFormatter();
        $modPasienMasukPenunjang->tgl_awal = date("d M Y");
        $modPasienMasukPenunjang->tgl_akhir = date('d M Y');
        $modPasienMasukPenunjang->ceklis = TRUE;
        if (isset($_REQUEST['RMMasukPenunjangV'])) {
            $modPasienMasukPenunjang->attributes = $_REQUEST['RMMasukPenunjangV'];
            $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_awal']);
            $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMMasukPenunjangV']['tgl_akhir']);
            $modPasienMasukPenunjang->ceklis = $_REQUEST['RMMasukPenunjangV']['ceklis'];
        }
        
        // set url terakhir pada daftar pasien, jadi ketika pada tabulasi yang memiliki tombol kembali bisa klik keurl yang dituju.
        Yii::app()->user->setState('current_url_daftarpasien', Yii::app()->request->requestUri);
        
        $this->render('index', array(
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang
        ));
    }

    /**
     * Buat jadwal
     * @param type $id
     */
    public function actionBuatJadwal($id) {
        $this->pageTitle = Yii::app()->name . " - Buat Jadwal";
        $modHasilPemeriksaan = $this->loadAllByPasienMasukPenunjang($id);
        $modPasienPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $id)); //data pasien penunjang
        $modTindakanPelayanan = new RMTindakanpelayananT;
        $modTindakanKomponen = new RMTindakanKomponenT;
        $modJadwalKunjungan = new JadwalkunjunganrmT;
        $modNewHasil = new HasilpemeriksaanrmT;
        $listJadwalKunjungan = JadwalkunjunganrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $id));

        if (isset($_POST['JadwalKunjungan'])) {
            $transaction = Yii::app()->db->beginTransaction();
//			try
//			{
            $modJadwalKunjungan = $this->saveJadwalKunjungan($_POST['JadwalKunjungan'], $modPasienPenunjang);

            if ($this->successSave && $this->successSaveJadwal && $this->successSaveHasil) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
//			}
//			catch(Exception $exc){
//				$transaction->rollback();
//				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
//			}
        }

        $this->render('buatJadwal', array(
            'modPasienPenunjang' => $modPasienPenunjang,
            'modTindakanPelayanan' => $modTindakanPelayanan,
            'modTindakanKomponen' => $modTindakanKomponen,
            'modJadwalKunjungan' => $modJadwalKunjungan,
            'modNewHasil' => $modNewHasil,
            'listJadwalKunjungan' => $listJadwalKunjungan,
            'id' => $id
        ));
    }

    /**
     * Print Jadwal
     */
    public function actionPrintJadwal() {
        $id = $_REQUEST['id'];
        $judulLaporan = 'Jadwal Kunjungan Rehab Medis';
        $modHasilPemeriksaan = $this->loadAllByPasienMasukPenunjang($id);
        $modPasienPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $id)); //data pasien penunjang
        $modTindakanPelayanan = new RMTindakanpelayananT;
        $modTindakanKomponen = new RMTindakanKomponenT;
        $modJadwalKunjungan = new JadwalkunjunganrmT;
        $modNewHasil = new HasilpemeriksaanrmT;
        $listJadwalKunjungan = JadwalkunjunganrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $id));

        $this->layout = '//layouts/printWindows';
        $this->render('printJadwal', array(
            'modPasienPenunjang' => $modPasienPenunjang,
            'modTindakanPelayanan' => $modTindakanPelayanan,
            'modTindakanKomponen' => $modTindakanKomponen,
            'modJadwalKunjungan' => $modJadwalKunjungan,
            'modNewHasil' => $modNewHasil,
            'listJadwalKunjungan' => $listJadwalKunjungan,
            'id' => $id,
            'judulLaporan' => $judulLaporan,
        ));
    }

    /**
     * Fungsi untuk menyimpan ke tabel jadwalkunjungan_t
     * @param type $attrJadwal
     * @param type $modPasienPenunjang 
     */
    protected function saveJadwalKunjungan($attrJadwal, $modPasienPenunjang) {
        $format = new MyFormatter();
        $arrSave = array();
        $validJadwal = true;
        $arrTindakan = array(); // array untuk menampung tindakan yg nantinnya digunakan pada proses saveHasilpemeriksaan
        $arrIdHasilPemeriksaan = array(); // array untuk menampung hasilpemeriksaan_id yg nantinnya digunakan pada proses saveHasilpemeriksaan
        for ($f = 0; $f < $_POST['lamaterapi']; $f++) {
            $modJadwalKunjungan = new JadwalkunjunganrmT;
            $modJadwalKunjungan->pegawai_id = (!empty($attrJadwal['pegawai_id'][$f])) ? $attrJadwal['pegawai_id'][$f] : null;
            $modJadwalKunjungan->pasien_id = $modPasienPenunjang->pasien_id;
            $modJadwalKunjungan->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
            $modJadwalKunjungan->pendaftaran_id = $modPasienPenunjang->pendaftaran_id;
            $modJadwalKunjungan->nojadwal = MyGenerator::noUrutJadwalRencanaRM();
            $modJadwalKunjungan->nourutjadwal = $f + 1;
            $modJadwalKunjungan->tgljadwalrm = $attrJadwal['tgljadwalrm'][$f];
            $modJadwalKunjungan->harijadwalrm = $this->getNamaHari($attrJadwal['tgljadwalrm'][$f]);
            $modJadwalKunjungan->lamaterapikunjungan = $_POST['lamaterapi'];
            $modJadwalKunjungan->paramedis1_id = (!empty($attrJadwal['paramedis1_id'][$f])) ? $attrJadwal['paramedis1_id'][$f] : null;
            $modJadwalKunjungan->paramedis2_id = (!empty($attrJadwal['paramedis2_id'][$f])) ? $attrJadwal['paramedis2_id'][$f] : null;

            $modJadwalKunjungan->create_loginpemakai_id = Yii::app()->user->id;
            $modJadwalKunjungan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modJadwalKunjungan->create_time = date('Y-m-d H:i:s');

            $modJadwalKunjungan->validate();
            $arrIdHasilPemeriksaan[$f] = array(
                'hasilpemeriksaanrm_id' => isset($attrJadwal['hasilpemeriksaanrm_id'][$f]) ? $attrJadwal['hasilpemeriksaanrm_id'][$f] : null
            );

            if ($modJadwalKunjungan->validate()) {
                $validJadwal = true;
                $arrSave[$f] = $modJadwalKunjungan; // menyimpan objek JadwalkunjunganrmT ke dalam sebuah array dan siap untuk disave *kaya masak ya :p
            } else {
                $validJadwal = false;
            }
        } //ENDING FOR
        if ($validJadwal) { //kondisi apabila semua Jadwal tindakan valid dan siap untuk di save
            $arrIdHasil = array(); //membuang nilai array yg empty . . 

            foreach ($arrIdHasilPemeriksaan as $z => $idHasil) {
                if ($idHasil['hasilpemeriksaanrm_id'] == '') {
                    unset($idHasil[$z]);
                } else {
                    $arrIdHasil[$z] = array(
                        'hasilpemeriksaanrm_id' => $idHasil['hasilpemeriksaanrm_id']
                    );
                }
            }

            foreach ($arrSave as $x => $simpan) {
                $simpan->save();
                $this->successSave = true;
                if ($x < 1) { // kondisi dimana proses save pada baris pertama, yang asumsinya bahwa jadwal pertama sudah pasti mempunyai hasilpemeriksaanrm_t maka akan diupdate
                    if (isset($idHasil['hasilpemeriksaanrm_id'])) {
                        $this->updateHasilPemeriksaan($simpan, $arrIdHasil);
                    }
                } else {
                    if (isset($attrJadwal['tindakanrm_id'][$f])) {
                        $this->saveHasilPemeriksaan($modPasienPenunjang, $attrJadwal, $simpan, $x);
                    }
                }
            } //ENDING FOREACH
        } else {
            $this->successSave = false;
        }
        return $modJadwalKunjungan;
    }

    /**
     * Simpan hasil pemeriksaan
     * @param type $attrPenunjang
     * @param type $attrTindakan
     * @param type $modJadwal
     * @param type $index
     * @return \HasilpemeriksaanrmT
     */
    protected function saveHasilPemeriksaan($attrPenunjang, $attrTindakan, $modJadwal, $index) {
        $arrSave = array();
        $validTindakan = true;
        $arrTindakan = array(); // array untuk menampung tindakan yg nantinnya digunakan pada proses saveTindakanPelayanan
        for ($i = 0; $i < count($attrTindakan['tindakanrm_id'][$index]); $i++) {

            $modHasil = new HasilpemeriksaanrmT;
            $modHasil->jadwalkunjunganrm_id = $modJadwal->jadwalkunjunganrm_id;
            $modHasil->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
            $modHasil->pendaftaran_id = $attrPenunjang->pendaftaran_id;
            $modHasil->pasien_id = $attrPenunjang->pasien_id;
            $modHasil->ruangan_id = $attrPenunjang->ruangan_id;
            $modHasil->pegawai_id = $attrPenunjang->pegawai_id;
            $modHasil->tglpemeriksaanrm = date('Y-m-d H:i:s');
            $modHasil->kunjunganke = $modJadwal->nourutjadwal; //di default untuk kunjungan pertama

            $modHasil->tindakanrm_id = $attrTindakan['tindakanrm_id'][$index][$i];
            $modHasil->jenistindakanrm_id = RMTindakanrmM::model()->findByPk($modHasil->tindakanrm_id)->jenistindakanrm_id;

            $modHasil->create_time = date('Y-m-d H:i:s');
            $modHasil->create_loginpemakai_id = Yii::app()->user->id;
            $modHasil->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modHasil->nohasilrm = MyGenerator::noHasilPemeriksaanRM();

            if ($modHasil->validate()) {
                $arrSave[$i] = $modHasil; // menyimpan objek BSRencanaOperasiT ke dalam sebuah array dan siap untuk disave
            } else {
                $validTindakan = false;
            }
        } //ENDING FOR 

        if ($validTindakan) { //kondisi apabila semua rencana operasi valid dan siap untuk di save
            foreach ($arrSave as $f => $simpan) {
                $simpan->save();
//                        $this->saveTindakanPelayanT($attrPendaftaran,$attrPenunjang,$simpan,$attrTindakanPelayanan,$f);
            }
            $this->successSave = true;
        } else {
            $this->successSave = false;
        }
        return $modHasil;
    }

    /**
     * Fungsi untuk mengupdate hasilpemeriksaanrm_t pada saat kunjungan pertama yg asumsinya dia sudah punya hasil pemeriksaan
     * @param type $attrHasil 
     */
    protected function updateHasilPemeriksaan($modJadwal, $attrHasil) {
        $arrSave = array();
        $validHasil = true;
        $modHasil = array();
        for ($i = 0; $i < count($attrHasil); $i++) {
            $modHasil = $this->loadHasilPemeriksaan($attrHasil[$i]['hasilpemeriksaanrm_id']);
            $modHasil->jadwalkunjunganrm_id = $modJadwal->jadwalkunjunganrm_id;
            $modHasil->pegawai_id = (!empty($modJadwal->pegawai_id)) ? $modJadwal->pegawai_id : null;
            $modHasil->paramedis1_id = (!empty($modJadwal->paramedis1_id)) ? $modJadwal->paramedis1_id : null;
            $modHasil->paramedis2_id = (!empty($modJadwal->paramedis2_id)) ? $modJadwal->paramedis2_id : null;
            if ($modHasil->validate()) {
                $arrSave[$i] = $modHasil; // menyimpan objek 
            } else {
                $validHasil = false;
            }
        } //ENDING FOR

        if ($validHasil) { //kondisi apabila semua hasil valid dan siap untuk di save
            foreach ($arrSave as $f => $simpan) {
                $simpan->save();
                $this->successSave = true;
            }
        } else {
            $this->successSave = false;
        }
        return $modHasil;
    }

    /**
     * Hasil pemeriksaan
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @param type $pasienmasukpenunjang_id
     * @param type $caraPrint
     */
    public function actionHasilPemeriksaan($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '') {
        $modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

//            $modJadwalKunjungan = JadwalkunjunganrmT::model()->findAll('pendaftaran_id = '.$pendaftaran_id.' and 
//                                                                        pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id.' and
//                                                                        pasien_id = '.$pasien_id.' and
//                                                                        tglkunjunganrm is not null
//                                                                        order by nourutjadwal');
        $modHasilPemeriksaanrm = HasilpemeriksaanrmT::model()->findAll('pendaftaran_id = ' . $pendaftaran_id . ' and 
																	pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id . ' and
																	pasien_id = ' . $pasien_id);
                                                                    
        
        // 


//            if(isset($_POST['hasilpemeriksaanrm']))
//            {
//               $transaction = Yii::app()->db->beginTransaction();
//                try
//                { 
//                    
//                    for ($i = 0; $i < count($_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm_id']); $i++) {
//                        $modHasil = $this->loadHasilPemeriksaan($_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm_id'][$i]);
//                        $modHasil->hasilpemeriksaanrm = $_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm'][$i];
//                        $modHasil->keteranganhasilrm = $_POST['hasilpemeriksaanrm']['keteranganhasilrm'][$i];
//                        $modHasil->peralatandigunakan = $_POST['hasilpemeriksaanrm']['peralatandigunakan'][$i];
//                        if($_POST['hasilpemeriksaanrm']['hasilpemeriksaanrm'][$i] == '' && 
//                           $_POST['hasilpemeriksaanrm']['keteranganhasilrm'][$i]  == '' && 
//                           $_POST['hasilpemeriksaanrm']['peralatandigunakan'][$i]  == '')
//                        {
//                            $update = TRUE;
//                        }
//                        else
//                        {
//                            $update = JadwalkunjunganrmT::model()->updateByPk($modHasil->jadwalkunjunganrm_id, array('statusterapi'=>1));
//                        }
//                        if($modHasil->save() && $update)
//                        {
//                             $this->successSaveHasil = TRUE;
//                        }
//                        else{
//                            $this->successSaveHasil = FALSE;
//                        }
//                    }
//                    if ($this->successSaveHasil){
//                        $transaction->commit();
//                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
//                    }
//                    else{
//                        $transaction->rollback();
//                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
//                    }
//                }
//                catch(Exception $exc){
//                    $transaction->rollback();
//                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
//                }
//            }

        if (isset($_POST['HasilpemeriksaanrmT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $id_pendaftaran = $_POST['RMMasukPenunjangV']['pendaftaran_id'];
                $id_pasien = $_POST['RMMasukPenunjangV']['pasien_id'];
                $id_pasienmasukpenunjang = $_POST['RMMasukPenunjangV']['pasienmasukpenunjang_id'];
                for ($i = 0; $i < count($_POST['HasilpemeriksaanrmT']['hasilpemeriksaanrm_id']); $i++) {
                    $modHasil = $this->loadHasilPemeriksaan($_POST['HasilpemeriksaanrmT']['hasilpemeriksaanrm_id'][$i]);
                    $modHasil->hasilpemeriksaanrm = $_POST['HasilpemeriksaanrmT'][$i]['hasilpemeriksaanrm'];
                    $modHasil->keteranganhasilrm = $_POST['HasilpemeriksaanrmT'][$i]['keteranganhasilrm'];
                    $modHasil->evaluasi = $_POST['HasilpemeriksaanrmT'][$i]['evaluasi'];
                    if (isset($_POST['HasilpemeriksaanrmT'][$i]['peralatandigunakan'])) {
                        $modHasil->peralatandigunakan = CJSON::encode($_POST['HasilpemeriksaanrmT'][$i]['peralatandigunakan']);
                    }
                    if ($modHasil->save()) {
                        $this->successSaveHasil = TRUE;
                    } else {
                        $this->successSaveHasil = FALSE;
                    }
                }

                $penunjang = PasienmasukpenunjangT::model()->findByPk($id_pasienmasukpenunjang);
                $penunjang->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
                $this->successSaveHasil = $this->successSaveHasil && $penunjang->save();
                
                if ($this->successSaveHasil) {

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('hasilPemeriksaan',
                        'pendaftaran_id' => $id_pendaftaran,
                        'pasien_id' => $id_pasien,
                        'pasienmasukpenunjang_id' => $id_pasienmasukpenunjang,
                        'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('hasilPemeriksaanNew', array(/* 'modJadwalKunjungan'=>$modJadwalKunjungan, */
            'modPasienPenunjang' => $modPasienMasukPenunjang,
            'modHasilPemeriksaanrm' => $modHasilPemeriksaanrm,
            'caraPrint' => $caraPrint,
        ));
    }

    /**
     * Print hasil periksa
     * @param type $pendaftaran_id
     * @param type $pasien_id
     * @param type $pasienmasukpenunjang_id
     * @param type $caraPrint
     */
    public function actionHasilPeriksaPrint($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = '') {
        $this->layout = '//layouts/printWindows';
        $judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
        $modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $detailHasil = HasilpemeriksaanrmT::model()->findAll('pendaftaran_id = ' . $pendaftaran_id);
        $this->render('hasilPrint', array(
            'judulLaporan' => $judulLaporan,
            'masukpenunjang' => $modPasienMasukPenunjang,
            'detailHasil' => $detailHasil,
        ));
    }

    /**
     * Fungsi untuk mengembalikan object $model dengan method findAllByAttributes yang nanti digunakan untuk mendeskripsikan operasi_id
     * @param type $id
     * @return type 
     */
    protected function loadAllByPasienMasukPenunjang($id) {
        $model = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Fungsi untuk mengembalikan object $model dengan method findByAttributes yang nanti digunakan untuk mendeskripsikan hasilpemeriksanrm_t
     * @param type $id
     * @return type 
     */
    protected function loadHasilPemeriksaan($id) {
        $model = HasilpemeriksaanrmT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Load jadwal kunjungan
     */
    public function actionLoadFormJadwalKunjunganAwal() {
        if (Yii::app()->request->isAjaxRequest) {
            $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
            $lamaTerapi = isset($_POST['lamaTerapi']) ? $_POST['lamaTerapi'] : null;
            $tindakan = array();
            $idHasil = array();
            $modHasilPemeriksaan = array();

//            $sql = "select * from hasilpemeriksaanrm_t where pasienmasukpenunjang_id = $pasienmasukpenunjang_id";
//            //echo count($sql);
//            $modHasil = Yii::app()->db->createCommand($sql)->queryAll();
            $modHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
            foreach ($modHasil as $i => $hasilPeriksa) {
                $tindakan[$i] = $hasilPeriksa['tindakanrm_id'];
                $idHasil[$i] = $hasilPeriksa['hasilpemeriksaanrm_id'];
//                echo $hasilPeriksa['hasilpemeriksaanrm_id'].'<br/>';
//                echo $hasilPeriksa['tindakanrm_id'].'<br/>';
            }
            if (count($modHasil) > 0) {
//            exit;
                echo CJSON::encode(array(
                    'status' => 'create_form',
                    'pesan' => '',
                    'form' => $this->renderPartial('_formLoadJadwalKunjunganAwal', array('modHasilPemeriksaan' => $modHasilPemeriksaan,
                        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
                        'lamaTerapi' => $lamaTerapi,
                        'tindakan' => $tindakan,
                        'idHasil' => $idHasil
                            ), true)));
                exit;
            } else {
                echo CJSON::encode(array(
                    'status' => 'create_form',
                    'pesan' => 'Tindakan Rehabilitasi Medis belum dipilih!',
                    'form' => '',
                ));
                exit;
            }
        }
    }

    /**
     * action ketika tombol panggil di klik
     */
    public function actionPanggil() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";

            $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
            $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
            $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
            $criteria = new CDbCriteria;
            $criteria->compare('modul_id', $modul_id);
            $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
            $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
            if (isset($_POST['tujuansms'])) {
                $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
            }
            $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
            $data['smspasien'] = 1;
            $data['nama_pasien'] = '';

            if (isset($pasienMasukPenunjang)) {
                if ($pasienMasukPenunjang->panggilantrian == true) {
                    if ($keterangan == "batal") {
                        $pasienMasukPenunjang->panggilantrian = false;
                        if ($pasienMasukPenunjang->update()) {
                            // SMS GATEWAY
                            $modPasien = $pasienMasukPenunjang->pasien;
                            $sms = new Sms();
                            $smspasien = 1;
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $modPasien->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }
                                $attributes = $pasienMasukPenunjang->getAttributes();
                                foreach ($attributes as $attributes => $value) {
                                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                }

                                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                                    if (!empty($modPasien->no_mobile_pasien)) {
                                        $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                                    } else {
                                        $smspasien = 0;
                                    }
                                }
                            }
                            // END SMS GATEWAY
                            $data['smspasien'] = $smspasien;
                            $data['nama_pasien'] = $modPasien->nama_pasien;
                            $data['pesan'] = "Pemanggilan no. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dibatalkan !";
                        }
                    } else {
                        $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " sudah dipanggil sebelumnya !";
                    }
                } else {
                    $pasienMasukPenunjang->panggilantrian = true;
                    if ($pasienMasukPenunjang->update()) {
                        $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
                        // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
//              AKAN DIGANTI MENGGUNAKAN NODE JS
                        // self::postTelnet($data_telnet);
                    }
                }
            }

            $attributes = $pasienMasukPenunjang->attributeNames();
            foreach ($attributes as $i => $attribute) {
                $data["$attribute"] = $pasienMasukPenunjang->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Get antrian terakhir
     * @throws CHttpException
     */
    public function actionGetAntrianTerakhir() {
        if (Yii::app()->request->isAjaxRequest) {

            $data['pesan'] = "";
            $criteria = new CDbCriteria;
            $criteria->addCondition('panggilantrian != TRUE');
            $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \'' . date('d M Y') . '\' AND \'' . date('d M Y') . '\'');
            $criteria->order = 'no_urutperiksa ASC';

            $model = RMMasukPenunjangV::model()->find($criteria);
            if (!empty($model)) {
                $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
                $data['ruangan_singkatan'] = $model->ruangan_singkatan;
                $data['no_urutperiksa'] = $model->no_urutperiksa;
                $data['ruangan_id'] = $model->ruangan_id;
            } else {
                $data['pesan'] = "Tidak ada antrian!";
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Batal Penunjang
     * @param type $task
     */
    public function actionBatalPenunjang($task = 'BatalPenunjang') {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $status = '';
            $update_tindakan = false;
            $delete_tindakan = false;
            $delete_penunjang = false;

            $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

            $username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
            $password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
            $ruangan_id = Yii::app()->user->getState('ruangan_id');

            $status_tindakan = false;
            $status_obat = false;
            $status_batal = true;
            $user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
                'loginpemakai_aktif' => TRUE));
            if ($user === null) {
                $data['error'] = "Login Pemakai salah!";
                $data['cssError'] = 'username';
                $data['status'] = 'Gagal Login';
                $pesan = 'Gagal Login';
            } else {
                // cek password
//                if ($user->katakunci_pemakai !== $user->encrypt($password)) {
                if(!$user->cekPassword3($password)){
                    $data['error'] = 'password salah!';
                    $data['cssError'] = 'password';
                    $data['status'] = 'Gagal Login';
                    $pesan = 'Gagal Login';
                } else {
                    $data['error'] = '';
//                    $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id, 'action' => $task)); //dari MyAuthController
//                    if ($cek) {
                        $data['status'] = 'success';
                        $data['userid'] = $user->loginpemakai_id;
                        $data['username'] = $user->nama_pemakai;

                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            $criteria = new CDbCriteria();
                            $criteria->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                            $criteria->addCondition('tindakansudahbayar_id is not null');
                            $modTindakanPelayanan = TindakanpelayananT::model()->find($criteria);
                            
                            $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
                            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                            if ($modPendaftaran->ruangan_id == $modPasienMasukPenunjang->ruangan_id) {
                                $criteriaTindakan = new CDbCriteria();
                                $criteriaTindakan->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                                $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');
                                
                                $modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);

                                $criteriaObat = new CDbCriteria();
                                $criteriaObat->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                                $criteriaObat->addCondition('oasudahbayar_id is not null');
                                $modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);

                                if (!empty($modTindakanPelayanan)) {
                                    $status_tindakan = true;
                                }

                                if (!empty($modObatalkesPasien)) {
                                    $status_obat = true;
                                }
                                
                                if ($status_tindakan == true || $status_obat == true) {
                                    $status_batal = false;
                                    $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
                                } else {
                                    $status_batal = true;
                                }

                                if ($status_batal == true) {
                                    /*
                                     * cek data pendaftaran pasien masuk penunjang
                                     */
                                    $criteria = new CDbCriteria();
                                    if (!empty($pasienmasukpenunjang_id)) {
                                        $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
                                    }

                                    $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

                                    $pesan = '';
                                    $status = false;
                                    $model = new PasienbatalperiksaR();
                                    $model->pendaftaran_id = $pendaftaran_id;
                                    $model->pasien_id = $modPendaftaran->pasien_id;
                                    $model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
                                    $model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Pemeriksaan Rehab Medis";
                                    $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                                    $model->create_time = date('Y-m-d H:i:s');
                                    $model->create_loginpemakai_id = Yii::app()->user->id;

                                    if ($model->save()) {
                                        $status = true;
                                        $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                                    } else {
                                        $status = false;
                                        $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
                                    }

                                    $attributes = array(
                                        'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                                        'update_time' => date('Y-m-d H:i:s'),
                                        'update_loginpemakai_id' => Yii::app()->user->id
                                    );
                                    $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

                                    if (!empty($pasienMasukPenunjang)) {
                                        if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
                                            $attributes = array(
                                                'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
                                            );
                                            $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
                                            if ($Perminataan_penunjang) {
                                                $status = true;
                                            } else {
                                                $status = false;
                                            }
                                        }

                                        $attributes = array(
                                            'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
                                            'update_time' => date('Y-m-d H:i:s'),
                                            'update_loginpemakai_id' => Yii::app()->user->id
                                        );
                                        $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
                                        if (!$penunjang) {
                                            $status = false;
                                        }
                                        /*
                                         * cek data tindakan_pelayanan
                                         */
                                        $attributes = array(
                                            'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
                                            'tindakansudahbayar_id' => null
                                        );

                                        $criteria2 = new CDbCriteria();
                                        $criteria2->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
                                        $criteria2->addCondition('tindakansudahbayar_id is null');
                                        $tindakan = TindakanpelayananT::model()->findAll($criteria2);

                                        if (count($tindakan) > 0) {
                                            foreach ($tindakan as $val => $key) {
                                                $attributes = array(
                                                    'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                                                );
                                                $hapus_komponen = TindakankomponenT::model()->deleteAllByAttributes($attributes);
                                            }

                                            $attributes = array(
                                                'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
                                            );

                                            $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
                                            if (!$hapus_tindakan) {
                                                $status = false;
                                                $pesan = "exist";
                                            }
                                        } else {
                                            $status = true;
                                        }

                                        $criteriaObat2 = new CDbCriteria();
                                        $criteriaObat2->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                                        $criteriaObat2->addCondition('oasudahbayar_id is null');
                                        $modObatalkesPasien2 = ObatalkespasienT::model()->findAll($criteriaObat2);

                                        if (count($modObatalkesPasien2) > 0) {
                                            foreach ($modObatalkesPasien2 as $val => $obat) {
                                                $attributes = array(
                                                    'obatalkespasien_id' => $obat->obatalkespasien_id
                                                );
                                                $hapusobatalkes = ObatalkeskomponenT::model()->deleteAllByAttributes($attributes);
                                            }

                                            $hapus_obat = ObatalkespasienT::model()->deleteAllByAttributes($attributes);
                                            if (!$hapus_obat) {
                                                $status = false;
                                                $pesan = "exist";
                                            }
                                        } else {
                                            $status = true;
                                        }

                                        $penunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienMasukPenunjang->pasienmasukpenunjang_id);
                                        if (!$penunjang) {
                                            $status = false;
                                        } else {
                                            
                                        }
                                    }
                                }
                            } else {
                                if (!empty($modTindakanPelayanan)) {
                                    $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
                                    $status = false;
                                } else {
                                    $update_tindakanpelayanan = TindakanpelayananT::model()->updateAll(array('detailhasilpemeriksaanlab_id' => null,
                                        'hasilpemeriksaanrm_id' => null,
                                        'hasilpemeriksaanrad_id' => null,
                                        'hasilpemeriksaanpa_id' => null), 'pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);

                                    if ($update_tindakanpelayanan) {
                                        $update_tindakan = true;
                                        $status = true;
                                    } else {
                                        $update_tindakan = false;
                                        $status = false;
                                    }

                                    $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                                    if ($delete_tindakanpelayanan) {
                                        $delete_tindakan = true;
                                        $status = true;
                                    } else {
                                        $delete_tindakan = false;
                                        $status = false;
                                    }
                                    
                                    if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
                                        $update_pasienpenunjang = PasienkirimkeunitlainT::model()->updateByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id, array(
                                            'pasienmasukpenunjang_id'=>null,
                                        ));
                                    }

                                    $delete_pasienmasukpenunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienmasukpenunjang_id);
                                    if ($delete_pasienmasukpenunjang) {
                                        $delete_penunjang = true;
                                        $status = true;
                                    } else {
                                        $delete_penunjang = false;
                                        $status = false;
                                    }
                                }
                            }

                            if ($status == true) {
                                $pesan = 'Pasien Penunjang berhasil di batalkan';
                                $transaction->commit();
                            } else {
                                $transaction->rollback();
                            }
                        } catch (Exception $ex) {
                            $status = false;
                            $pesan = "exist";
                            var_dump($ex->getMessage()); die;
                            $transaction->rollback();
                        }
//                    } else {
//                        $data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
//                    }
                }
            }

            $data = array(
                'pesan' => $pesan,
                'status' => $status,
            );
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Lihat hasil
     * @param type $id
     * @param type $caraPrint
     */
    Public function actionLihatHasil($id, $caraPrint = '') {
        $this->layout = '//layouts/iframe';
        $judulLaporan = 'HASIL PEMERIKSAAN REHAB MEDIS';
        $modPasienMasukPenunjang = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$id));
        $detailHasil = HasilpemeriksaanrmT::model()->findAll('pasienmasukpenunjang_id = ' . $id);
        $this->render($this->path_view.'lihatHasil', array('masukpenunjang' => $modPasienMasukPenunjang,
            'judulLaporan' => $judulLaporan,
            'detailHasil' => $detailHasil,
            'caraPrint' => $caraPrint,
        ));
    }

    /**
     * Rincian tagihan penunjang
     * @param type $pendaftaran_id
     * @param type $instalasi_id
     * @param type $pasienmasukpenunjang_id
     * @param type $pasienadmisi_id
     */
    public function actionRincianTagihanPenunjang($pendaftaran_id, $instalasi_id, $pasienmasukpenunjang_id, $pasienadmisi_id = null) {
        $format = new MyFormatter();
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        // untuk load data pasien
        $criteria = new CDbCriteria();
        if (!empty($pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        }
        if (!empty($pasienmasukpenunjang_id)) {
            $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
        }
        if (!empty($pasienadmisi_id)) {
            $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
        }
        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $instalasi_id);
        }
        $modInfo = RMPasienMasukPenunjangV::model()->find($criteria);

        // untuk load data tindakan
        $criteriaTindakan = new CDbCriteria();
        if (!empty($pendaftaran_id)) {
            $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        }
        if (!empty($pasienmasukpenunjang_id)) {
            $criteriaTindakan->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
        }
        if (!empty($pasienadmisi_id)) {
            $criteriaTindakan->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
        }
        if (!empty($instalasi_id)) {
            $criteriaTindakan->addCondition("instalasi_id = " . $instalasi_id);
        }
        $criteriaTindakan->addCondition('pasienmasukpenunjang_id is not null');
        $criteriaTindakan->group = 'pendaftaran_id, pasien_id, instalasi_id, ruangan_id, kelaspelayanan_id, pasienmasukpenunjang_id, tgl_tindakan, instalasi_nama, ruangan_nama, kelaspelayanan_nama';
        $criteriaTindakan->select = $criteriaTindakan->group . ', sum(tarif_tindakan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan';
        $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

        $this->render('printRincianTagihanPenunjang', array(
            'format' => $format,
            'modInfo' => $modInfo,
            'modRincianTindakan' => $modRincianTindakan,
        ));
    }

    /*
     * Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */
    public function actionUbahStatusPeriksaPasien() {
        $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;
        $model = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
        if (isset($_POST['status'])) {
            $update = true;
            if ($status == "ANTRIAN") {
                PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            } else {
                if ($status == "SEDANG PERIKSA") {
                    $update = true;
                    $p = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
                    if ($p->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
                        PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
                    }
                }
            }
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'ok',
                    ));
                    exit;
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'not',
                    ));
                    exit;
                }
            }
        }
    }

    public function actionTerimaDokumen() {
        if (Yii::app()->request->isAjaxRequest) {
            $pendaftaran = $_POST['pendaftaran_id'];
            $pengirimanrm_id = $_POST['pengirimanrm_id'];
          
            $model = PendaftaranT::model()->findByPk($pendaftaran);
            if(!empty($pengirimanrm_id)) {            
                $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);      
                $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
                $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
                $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
                
                if($modPenerimaanRm->save()){
                        $model->statusdokrm = Params::STATUSDOKRMTERIMA_SUDAH;
                        $model->save();
                        
                        $judul = 'Penerimaan Berkas Rekam Medis';
                        
                        $isi = $modPenerimaanRm->pasien->no_rekam_medik.' - '.$modPenerimaanRm->pasien->nama_pasien;
    
                        
                        CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id'=> $modPenerimaanRm->ruanganpengirim->instalasi->instalasi_id, 'ruangan_id'=> $modPenerimaanRm->ruanganpengirim->ruangan_id, 'modul_id'=> !empty($modPenerimaanRm->ruanganpengirim->modul_id)?$modPenerimaanRm->ruanganpengirim->modul_id:null),
                        ));   
                        
                        $update = true;
                }else{
                        $update = false;
                }
            }
            
            if($update == true)
            {
                    $status = 'proses_form';
                    $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
            }else{
                    $status = 'proses_form';
                    $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
            }
    
            echo CJSON::encode(array(
                    'status'=>$status, 
                    'div'=>$div,
                    ));
            exit;   
        }
    }

    public function actionStatusDokumenKirim($pengirimanrm_id,$pendaftaran_id){
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		$status = false;
		if(!empty($pengirimanrm_id)){
			$modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
		}else{
			$modPengirimanRm = new PengirimanrmT();
		}			

                $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;                
				$modUbahStatus = new PengirimanrmT;
                $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');                
                $modUbahStatus->petugaspengirim = Yii::app()->user->name;
                $modUbahStatus->petugaspengirim_id = $pegawai_id;
                
		if(isset($_POST['PengirimanrmT']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try 
			{
				$modUbahStatus->attributes = $_POST['PengirimanrmT'];
                                //var_dump($_POST);die;
				$modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
				$modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
				$modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
				$modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
				$modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
				$modUbahStatus->kelengkapandokumen = TRUE;
				$modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];                                
				$modUbahStatus->create_time = date('Y-m-d H:i:s');
				$modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
				$modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
                                $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];
				
				if($modUbahStatus->save())
				{
					$modPendaftaran->statusdokrm = Params::STATUSDOKRMKIRIM_SUDAH;
					$modPendaftaran->pengirimanrm_id = $modUbahStatus->pengirimanrm_id;
					$modPendaftaran->save();
					
					$judul = 'Pengiriman Berkas Rekam Medis';
                    
					$isi = $modUbahStatus->pendaftaran->no_pendaftaran.' - '.$modUbahStatus->pasien->no_rekam_medik.' - '.$modUbahStatus->pasien->nama_pasien;
					
					CustomFunction::broadcastNotif($judul, $isi, array(
						array('instalasi_id'=> $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id'=> $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id'=> !empty($modUbahStatus->ruangantujuan->modul_id)?$modUbahStatus->ruangantujuan->modul_id:null),
					));
					

					$transaction->commit();
					$status = true;
					Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
				}else{
					$status = false;
					Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
				}
			}catch(Exception $exc) {
				$transaction->rollback();
				$status = false;
				Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan'.MyExceptionMessage::getMessage($exc));
			}                  
		}
		
		$this->render('_formStatusDokumen', array(
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modPengirimanRm'=>$modPengirimanRm,
			'modUbahStatus'=>$modUbahStatus,
			'status'=>$status
		));            
	}

    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                if (count($models) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count($models) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    public function actionGetStatusPenerimaan()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$pengirimanrm_id = $_POST['pengirimanrm_id'];
			$ruanganpenerimaan_id = $_POST['ruanganpenerimaan_id'];
			$statusdok = $_POST['status'];
			$penerimaan = false;
			$div = '';
			$ruangan = '';
			$model = PendaftaranT::model()->findByPk($pendaftaran_id);
			if(!empty($pengirimanrm_id)){
				$modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
				if($modPenerimaanRm->ruanganpenerimaan_id == $ruanganpenerimaan_id){
					$penerimaan = true;
				}
			}

			if($penerimaan == true)
			{
				$div = "<div class='flash-success'>Dokumen Sudah Diterima Oleh Ruangan  <b>".$ruangan."</b></div>";
			}else{
				$div = "<div class='flash-error'>Dokumen Belum Diterima Oleh Ruangan  <b>".$ruangan."</b></div>";
			}

			echo CJSON::encode(array(
				'div'=>$div,
				));
			exit;
		}
   }

   public function actionHapusDokumenPengiriman()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$pendaftaran_id = $_POST['pendaftaran_id'];
			$pengirimanrm_id = $_POST['pengirimanrm_id'];
			$statusdok = $_POST['status'];
			$delete = false;
			$status = '';
			$div = '';
			$model = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $pengiriman = PengirimanrmT::model()->findAllByAttributes(array(
                            'ruanganpengirim_id'=>Yii::app()->user->getState('ruangan_id'),
                            'pendaftaran_id'=>$pendaftaran_id,
                        ), array (
                            'order' => 'nourut_keluar desc',
                            'limit' => 2,
                        ));

                        //var_dump($pengiriman[0]->pengirimanrm_id); die;

			if(!empty($pengirimanrm_id)) {
				$model->pengirimanrm_id = $pengirimanrm_id;
				$modPenerimaanRm = PengirimanrmT::model()->findByPk($pengiriman[0]->pengirimanrm_id); //($pengirimanrm_id);
                                // var_dump($modPenerimaanRm->attributes);
                                // var_dump($model->attributes); die;
				if($model->save()) {
					$modPenerimaanRm->delete();
					$delete = true;
				}else{
					$delete = false;
				}
			}

			if($delete == true)
			{
				$status = 'proses_form';
				$div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil dihapus </div>";
			}else{
				$status = 'proses_form';
				$div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal dihapus </div>";
			}

			echo CJSON::encode(array(
				'status'=>$status,
				'div'=>$div,
				));
			exit;
		}
   }

}
