<?php
Yii::import("pendaftaranPenjadwalan.models.PPPasienM");
/**
 * untuk transaksi pendaftaran donor darah
 * @author rusdiyanto <rusdiyanto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class PendaftaranDonorDarahController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.pendaftaranDonorDarah.';
    public $pendonortersimpan = false;
    public $pendaftardonasisimpan = false;

    /**
     * fungsi untuk menampilkan halaman awal dan proses insert
     * @param type $daftardonasi_id
     */
    public function actionIndex($daftardonasi_id = null) {

        $modDaftarDonasi = new BDDaftardonasiT();
        $format = new MyFormatter();
        $modDaftarDonasi->waktu_pendaftaran = $format->formatDateTimeForUser(date('Y-m-d H:i:s'));
        // if(Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_MOBILE_UNIT_INTERNAL){
            // $modDaftarDonasi->ruangan_rekruitmen_id = Yii::app()->user->getState('ruangan_id');
        // }else{
        //     $modDaftarDonasi->ruangan_rekruitmen_id = null;
        // }
        $modDaftarDonasi->no_formulir = '-- Otomatis --';
        $modLoginPegawai = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
        $modPegawai = PegawaiM::model()->findByPk($modLoginPegawai->pegawai_id);
        $modDaftarDonasi->nama_petugas_id = $modPegawai->pegawai_id;
        $modPendonor = new BDPendonorM();
        $modPendonor->is_pernah_donor = 1;

        if (!empty($daftardonasi_id)) {
            $modDaftarDonasi = BDDaftardonasiT::model()->findByPk($daftardonasi_id);
            $cekPegawai = PegawaiM::model()->findByPk(!empty($modDaftarDonasi->dpjp_id) ? $modDaftarDonasi->dpjp_id : null);
            if(!empty($cekPegawai)){
                $modDaftarDonasi->dpjp_nama = $cekPegawai->nama_pegawai;
            }
            $modPendonor = BDPendonorM::model()->findByPk($modDaftarDonasi->pendonor_id);
        }


        if (isset($_POST['BDDaftardonasiT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $modPendonor = $this->simpanPendonor($modPendonor, $_POST['BDPendonorM']);

                $modDaftarDonasi = $this->simpanDaftarDonasi($modPendonor, $modDaftarDonasi, $_POST['BDDaftardonasiT'], $_POST['BDPendonorM']);
                if ($this->pendonortersimpan && $this->pendaftardonasisimpan) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'sukses' => 1, 'daftardonasi_id' => $modDaftarDonasi->daftardonasi_id));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    echo '<pre>';var_dump($modDaftarDonasi->getErrors(), $modPendonor->getErrors());die;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'modDaftarDonasi' => $modDaftarDonasi,
            'modPendonor' => $modPendonor,
            'format' => $format
        ));
    }

    /**
     * digunakan untuk simpan pendonor
     * @param array $modPendonor
     * @param array $post
     * @return \BDPendonorM
     */
    public function simpanPendonor($modPendonor, $post) {
        $format = new MyFormatter();
        $snrm = "";

        if (isset($post['pendonor_id']) && (!empty($post['pendonor_id']))) {
            $load = new $modPendonor;
            $modPendonor = $load->findByPk($post['pendonor_id']);
            $snrm = $modPendonor->nama_lengkap;
        } else {
            $modPendonor = new BDPendonorM;
        }


        $modPendonor->attributes = $post;

        if (empty($modPendonor->pendonor_id)) {
            $modPendonor->no_pendonor = MyGenerator::noPendonor();
            $modPendonor->profilrs_id = 1;
            $modPendonor->donasi_ke = !empty($modPendonor->donasi_ke) ? $modPendonor->donasi_ke : 0;
            $modPendonor->tgllahir = !empty($modPendonor->tgllahir) ? $format->formatDateTimeForDb($modPendonor->tgllahir) : ' ';
            $modPendonor->tgl_donor_terakhir = !empty($modPendonor->tgl_donor_terakhir) ? $format->formatDateTimeForDb($modPendonor->tgl_donor_terakhir) : null;
            $modPendonor->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPendonor->create_loginpemakai_id = Yii::app()->user->id;
            $modPendonor->create_time = date('Y-m-d H:i:s');
            $modPendonor->donor_itd_ke = isset($modPendonor->donor_itd_ke) ? $modPendonor->donor_itd_ke : 0;
            $modPendonor->pegawai_id = !empty($_POST['BDPendonorM']['pegawai_id']) ? $_POST['BDPendonorM']['pegawai_id'] : '';
            $modPendonor->propinsi_id = !empty($_POST['BDPendonorM']['propinsi_id']) ? $_POST['BDPendonorM']['propinsi_id'] : '';
            $modPendonor->kabupaten_id = !empty($_POST['BDPendonorM']['kabupaten_id']) ? $_POST['BDPendonorM']['kabupaten_id'] : '';
            $modPendonor->kecamatan_id = !empty($_POST['BDPendonorM']['kecamatan_id']) ? $_POST['BDPendonorM']['kecamatan_id'] : '';
            $modPendonor->kelurahan_id = !empty($_POST['BDPendonorM']['kelurahan_id']) ? $_POST['BDPendonorM']['kelurahan_id'] : '';
        } else {
            $modPendonor->donasi_ke = !empty($modPendonor->donasi_ke) ? $modPendonor->donasi_ke : 0;
            $modPendonor->donor_itd_ke = isset($modPendonor->donor_itd_ke) ? $modPendonor->donor_itd_ke : 0;
            $modPendonor->update_loginpemakai_id = Yii::app()->user->id;
            $modPendonor->update_time = date('Y-m-d H:i:s');
            $modPendonor->tgllahir = !empty($modPendonor->tgllahir) ? $format->formatDateTimeForDb($modPendonor->tgllahir) : ' ';
            $modPendonor->tgl_donor_terakhir = !empty($_POST['BDPendonorM']['tgl_donor_terakhir']) ? $format->formatDateTimeForDb($_POST['BDPendonorM']['tgl_donor_terakhir']) : null;

            $modPendonor->pegawai_id = !empty($_POST['BDPendonorM']['pegawai_id']) ? $_POST['BDPendonorM']['pegawai_id'] : '';
            $modPendonor->propinsi_id = !empty($_POST['BDPendonorM']['propinsi_id']) ? $_POST['BDPendonorM']['propinsi_id'] : '';
            $modPendonor->kabupaten_id = !empty($_POST['BDPendonorM']['kabupaten_id']) ? $_POST['BDPendonorM']['kabupaten_id'] : '';
            $modPendonor->kecamatan_id = !empty($_POST['BDPendonorM']['kecamatan_id']) ? $_POST['BDPendonorM']['kecamatan_id'] : '';
            $modPendonor->kelurahan_id = !empty($_POST['BDPendonorM']['kelurahan_id']) ? $_POST['BDPendonorM']['kelurahan_id'] : '';
        }

        if (!empty($modPendonor->photopendonor)) {
            $image_text = str_replace('data:image/png;base64,', '', $modPendonor->photopendonor);
            $image_text = str_replace(' ', '+', $image_text);
            $image_text = base64_decode($image_text);
            $modPendonor->photopendonor = date("Ymd") . $modPendonor->no_pendonor . '.png';
            $file = Params::pathPendonorDirectory() . $modPendonor->photopendonor;
            $success = file_put_contents($file, $image_text);
            $source_img = imagecreatefromstring($image_text);

            imagedestroy($source_img);

            if (!empty($modPendonor->temp_file)) {
                if ($modPendonor->temp_file != $modPendonor->photopendonor) {
                    if (file_exists(Params::pathPendonorDirectory() . $modPendonor->temp_file)) {
                        unlink(Params::pathPendonorDirectory() . $modPendonor->temp_file);
                    }
                }
            }
        }
        $modPendonor->validate();

        if ($modPendonor->save()) {
            $this->pendonortersimpan = true;
        } else {
            $this->pendonortersimpan = false;
        }


        return $modPendonor;
    }

    /**
     * digunakan untuk insert daftar donasi
     * @param array $modPendonor
     * @param BDDaftardonasiT $modDaftarDonasi
     * @param array $post
     * @param array $postPendonor
     * @return \BDDaftardonasiT
     */
    public function simpanDaftarDonasi($modPendonor, $modDaftarDonasi, $post, $postPendonor) {
        $format = new MyFormatter();
        $modDaftarDonasi = new BDDaftardonasiT();
        $modDaftarDonasi->attributes = $post;
        $modDaftarDonasi->pendonor_id = empty($postPendonor['pendonor_id']) ? $modPendonor->pendonor_id : $postPendonor['pendonor_id'];
        $modDaftarDonasi->donasi_ke = 0;
        $modDaftarDonasi->gol_darah = $postPendonor['gol_darah'];
        $modDaftarDonasi->rhesus = $postPendonor['rhesus'];
        $modDaftarDonasi->tinggibadan_cm = $postPendonor['tinggibadan_cm'];
        $modDaftarDonasi->beratbadan_kg = $postPendonor['beratbadan_kg'];
        $modDaftarDonasi->dpjp_id = $post['dpjp_id'];
        $modDaftarDonasi->waktu_pendaftaran = !empty($modDaftarDonasi->waktu_pendaftaran) ? $format->formatDateTimeForDb($modDaftarDonasi->waktu_pendaftaran) : ' ';
        $modDaftarDonasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modDaftarDonasi->create_loginpemakai_id = Yii::app()->user->id;
        $modDaftarDonasi->create_time = date('Y-m-d H:i:s');
        $modDaftarDonasi->no_formulir = MyGenerator::noFormulirPendonor();
        $modDaftarDonasi->status = Params::STATUS_PENDONOR_ANTRIAN;
        $modDaftarDonasi->ruangan_id = Yii::app()->user->getState('ruangan_id');
        // echo '<pre>';var_dump($modDaftarDonasi);die;
        if ($modDaftarDonasi->save()) {
            $this->pendaftardonasisimpan = true;
        } else {
            $this->pendaftardonasisimpan = false;
        }
        return $modDaftarDonasi;
    }

    /**
     * untuk set tanggal lahir
     */
    public function actionSetTanggalLahir() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['tgllahir'] = MyFormatter::formatDateTimeForUser($_POST['tgl']);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * untuk set tanggal lahir
     */
    public function actionSetTanggalTerakhirDonor() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['tglterakhirdonor'] = MyFormatter::formatDateTimeForUser($_POST['tgl']);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * untuk menampilkan kabupaten dan kota untuk tempat lahir pasien
     */
    public function actionAutocompleteTempatLahir() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $tempat_lahir = isset($_GET['tempat_lahir']) ? $_GET['tempat_lahir'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(kabupaten_nama)', strtolower($tempat_lahir), true);
            $criteria->addCondition('kabupaten_aktif IS TRUE');
            $criteria->order = 'kabupaten_nama';
            $criteria->limit = 10;
            $models = KabupatenM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = strtoupper($model->kabupaten_nama);
                $returnVal[$i]['value'] = strtoupper($model->kabupaten_nama);
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * untuk menampilkan nama lengkap
     * @author  Andyka Putra <andykaputra@.com>
     */
    public function actionAutocompleteNamaLengkap() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_lengkap = isset($_GET['nama_lengkap']) ? $_GET['nama_lengkap'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_lengkap)', strtolower($nama_lengkap), true);
            $criteria->order = 'nama_lengkap';
            $criteria->limit = 10;
            $models = PendonorM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendonor.' '.strtoupper($model->nama_lengkap);
                $returnVal[$i]['value'] = strtoupper($model->nama_lengkap);
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }
    
    /**
     * untuk menampilkan no identitas dan mengisi data lainnya
     * @author  Andyka Putra <andykaputra@.com>
     */
    public function actionAutocompleteNomorIdentitas() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $no_identitas = isset($_GET['no_identitas']) ? $_GET['no_identitas'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_identitas)', strtolower($no_identitas), true);
            $criteria->order = 'no_identitas';
            $criteria->limit = 10;
            $models = PendonorM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_identitas.' '.strtoupper($model->nama_lengkap);
                $returnVal[$i]['value'] = strtoupper($model->no_identitas);
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * untuk menampilkan nama pekerjaan pendonor
     * @author  Andyka Putra <andykaputra@.com>
     */
    public function actionAutocompletePekerjaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $pekerjaan = isset($_GET['pekerjaan_nama']) ? $_GET['pekerjaan_nama'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(pekerjaanpendonor_nama)', strtolower($pekerjaan), true);
            $criteria->addCondition('pekerjaanpendonor_aktif IS TRUE');
            $criteria->order = 'pekerjaanpendonor_nama';
            $criteria->limit = 10;
            $models = PekerjaanpendonorM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = strtoupper($model->pekerjaanpendonor_nama);
                $returnVal[$i]['value'] = strtoupper($model->pekerjaanpendonor_id);
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mencetak kartu donor darah
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $modPendonor = PendonorM::model()->findByPk($id);

        $this->render($this->path_view . 'Print', array(
            'modPendonor' => $modPendonor,
        ));
    }
    
    /**
     * periksa apakah pasien sudah pernah jadi pendonor
     */
    public function actionCekData(){
        if (Yii::app()->request->isAjaxRequest) {
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;
            $pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:null;
            $pendonor_id = isset($_POST['pendonor_id'])?$_POST['pendonor_id']:null;
            $pasien_id = isset($_POST['pasien_id'])?$_POST['pasien_id']:null;
            $id = isset($_POST['id'])?$_POST['id']:null;
            $cekPendonor = array();
            if ($tipe == 'pegawai'){
                $cekDonor = PendonorM::model()->findByPk($pendonor_id);
                $pendonor = PendonorM::model()->findByPk($id);
                
                $cekPekerjaanpendonor = PekerjaanpendonorM::model()->findByPk($pendonor->pekerjaan_id);
                if(!empty($cekPekerjaanpendonor)){
                    $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                }
                
                $data = $pendonor->attributes;
                $pegawai = PegawaiM::model()->findByPk($pendonor->pegawai_id);
                                
                if (!empty($pegawai)){
                    $data['pegawai'] = $pegawai->attributes;  
                    if(!empty($cekPekerjaanpendonor)){
                        $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                    }
                }else{
                    $data['pegawai'] = '';
                    if(!empty($cekPekerjaanpendonor)){
                        $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                    }
                }
                
                /*
                 * Cek jika ada data seleksi
                 * Jika tidak ada data seleksi atau data seleksi terakhir ditolak maka pendaftaran bisa dilanjutkan
                 */
                $cri = new CDbCriteria();
                $cri->select = "MAX(seleksidonor_id), pendonor_id, status_pendonor";
                $cri->addCondition('pendonor_id ='.$pendonor->pendonor_id);
                $cri->group = "seleksidonor_id, pendonor_id, status_pendonor";
                $cri->order = "seleksidonor_id DESC";
                $cri->limit = 1;
                $modSeleksi = SeleksipendonorT::model()->find($cri);               
                
                if (empty($modSeleksi) || $modSeleksi->status_pendonor == Params::STATUS_SELEKSI_DITOLAK) {
                    $data['status_seleksi'] = Params::STATUS_SELEKSI_DITOLAK;
                } else {
                    $data['status_seleksi'] = $modSeleksi->status_pendonor;
                    
                    /**
                     * Memeriksa data observasi
                     * Jika data observasi <= 56 hari maka pendaftaran akan ditolak (muncul warning)
                     * Jika data observasi > 56 hari maka pendaftaran dapat dilakukan
                     */
                    $criteria = new CDbCriteria();
                    $criteria->select = "pendonor_id, observasipendonor_id, date(waktu_observasi), (current_date - waktu_observasi::date) as selisih_hari ";
                    $criteria->addCondition('pendonor_id = '.$pendonor->pendonor_id);
                    $criteria->order = 'observasipendonor_id DESC';
                    $criteria->group = 'observasipendonor_id, waktu_observasi, pendonor_id';
                    $modObservasi = ObservasipendonorT::model()->find($criteria);
                    
                    /**
                     * Jika hasil_skrining = reaktif maka muncul warning
                     * Jika belum pernah skrining tetapi sudah > 56 hari tetap bisa donor 
                     */
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = "t.skriningimltd_id, t.hasil_skrining, t.pengujian_ke ";
                    $criteria2->join = "left join kantongdarah_t on kantongdarah_t.kantongdarah_id = t.kantongdarah_id
                                        left join pendonor_m on pendonor_m.pendonor_id = kantongdarah_t.pendonor_id";
                    $criteria2->group = "t.skriningimltd_id, t.hasil_skrining, t.pengujian_ke";
                    $criteria2->addCondition("pendonor_m.pendonor_id = ".$id);
                    $criteria2->order = "t.skriningimltd_id DESC, t.pengujian_ke DESC";
                    $modSkrining  = SkriningimltdT::model()->find($criteria2);
                    
                    if (empty($modObservasi)) {
                        $data['selisih_hari'] = 57;
                    } else if (!empty($modObservasi) && empty($modSkrining)) {
                        $data['selisih_hari'] = $modObservasi->selisih_hari;
                    } else if (empty($modObservasi) && !empty($modSkrining)) {
                        $data['selisih_hari'] = 57;
                        $data['hasil_skrining'] = $modSkrining['hasil_skrining'];
                    } else if (!empty($modObservasi) && !empty($modSkrining)) {
                        $data['selisih_hari'] = $modObservasi->selisih_hari;
                        $data['hasil_skrining'] = $modSkrining['hasil_skrining'];
                    }
                }
                
            } elseif ($tipe == 'pasien'){
                $cekDonor = PasienM::model()->findByPk($pasien_id);
                
                $pasien = PasienM::model()->findByPk($id);
                $cekPekerjaanpendonor = PekerjaanpendonorM::model()->findByPk($pasien->pekerjaan_id);
                if(!empty($cekPekerjaanpendonor)){
                    $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                }
                
                $data = $pasien->attributes;
                                
                if (!empty($pasien)){
                    $data['pasien'] = $pasien->attributes;  
                    if(!empty($cekPekerjaanpendonor)){
                        $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                    }
                }else{
                    $data['pasien'] = '';
                    if(!empty($cekPekerjaanpendonor)){
                        $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                    }
                }
                
                /*
                 * Cek jika ada data seleksi
                 * Jika tidak ada data seleksi atau data seleksi terakhir ditolak maka pendaftaran bisa dilanjutkan
                 */
                $cri = new CDbCriteria();
                $cri->select = "MAX(seleksidonor_id), pendonor_id, status_pendonor";
                $cri->addCondition('pendonor_id ='.$modSeleksi->pendonor_id);
                $cri->group = "seleksidonor_id, pendonor_id, status_pendonor";
                $cri->order = "seleksidonor_id DESC";
                $cri->limit = 1;
                $modSeleksi = SeleksipendonorT::model()->find($cri);               
                
                if (empty($modSeleksi) || $modSeleksi->status_pendonor == Params::STATUS_SELEKSI_DITOLAK) {
                    $data['status_seleksi'] = Params::STATUS_SELEKSI_DITOLAK;
                } else {
                    $data['status_seleksi'] = $modSeleksi->status_pendonor;
                    
                    /**
                     * Memeriksa data observasi
                     * Jika data observasi <= 56 hari maka pendaftaran akan ditolak (muncul warning)
                     * Jika data observasi > 56 hari maka pendaftaran dapat dilakukan
                     */
                    $criteria = new CDbCriteria();
                    $criteria->select = "pendonor_id, observasipendonor_id, date(waktu_observasi), (current_date - waktu_observasi::date) as selisih_hari ";
                    $criteria->addCondition('pendonor_id = '.$pendonor->pendonor_id);
                    $criteria->order = 'observasipendonor_id DESC';
                    $criteria->group = 'observasipendonor_id, waktu_observasi, pendonor_id';
                    $modObservasi = ObservasipendonorT::model()->find($criteria);
                    
                    /**
                     * Jika hasil_skrining = reaktif maka muncul warning
                     * Jika belum pernah skrining tetapi sudah > 56 hari tetap bisa donor 
                     */
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = "t.skriningimltd_id, t.hasil_skrining, t.pengujian_ke ";
                    $criteria2->join = "left join kantongdarah_t on kantongdarah_t.kantongdarah_id = t.kantongdarah_id
                                        left join pendonor_m on pendonor_m.pendonor_id = kantongdarah_t.pendonor_id";
                    $criteria2->group = "t.skriningimltd_id, t.hasil_skrining, t.pengujian_ke";
                    $criteria2->addCondition("pendonor_m.pendonor_id = ".$id);
                    $criteria2->order = "t.skriningimltd_id DESC, t.pengujian_ke DESC";
                    $modSkrining  = SkriningimltdT::model()->find($criteria2);
                    
                    if (empty($modObservasi)) {
                        $data['selisih_hari'] = 57;
                    } else if (!empty($modObservasi) && empty($modSkrining)) {
                        $data['selisih_hari'] = $modObservasi->selisih_hari;
                    } else if (empty($modObservasi) && !empty($modSkrining)) {
                        $data['selisih_hari'] = 57;
                        $data['hasil_skrining'] = $modSkrining['hasil_skrining'];
                    } else if (!empty($modObservasi) && !empty($modSkrining)) {
                        $data['selisih_hari'] = $modObservasi->selisih_hari;
                        $data['hasil_skrining'] = $modSkrining['hasil_skrining'];
                    }
                }
                
            }else{
                if (!empty($pegawai_id)){
                    $cekDonor = PendonorM::model()->findByAttributes(array('pegawai_id' => $pegawai_id));
                }
                
                $pegawai = PegawaiM::model()->findByPk($id);
                
                $data = $pegawai->attributes;                
                $data['pekerjaan_nama'] = !empty($pegawai->pekerjaan)?$pegawai->pekerjaan->pekerjaan_nama:null;
                
                /*
                 * Cek jika ada data seleksi
                 * Jika tidak ada data seleksi atau data seleksi terakhir ditolak maka pendaftaran bisa dilanjutkan
                 */
                $cri = new CDbCriteria();
                $cri->select = "MAX(seleksidonor_id), pendonor_id, status_pendonor";
                $cri->addCondition('pendonor_id ='.$id);
                $cri->group = "seleksidonor_id, pendonor_id, status_pendonor";
                $cri->order = "seleksidonor_id DESC";
                $cri->limit = 1;
                $modSeleksi = SeleksipendonorT::model()->find($cri);               
                
                if (empty($modSeleksi) || $modSeleksi->status_pendonor == Params::STATUS_SELEKSI_DITOLAK) {
                    $data['status_seleksi'] = Params::STATUS_SELEKSI_DITOLAK;
                } else {
                    $data['status_seleksi'] = $modSeleksi->status_pendonor;
                    
                    /**
                     * Memeriksa data observasi
                     * Jika data observasi <= 56 hari maka pendaftaran akan ditolak (muncul warning)
                     * Jika data observasi > 56 hari maka pendaftaran dapat dilakukan
                     */
                    $criteria = new CDbCriteria();
                    $criteria->select = "pendonor_id, observasipendonor_id, date(waktu_observasi), (current_date - waktu_observasi::date) as selisih_hari ";
                    $criteria->addCondition('pendonor_id = '.$pendonor->pendonor_id);
                    $criteria->order = 'observasipendonor_id DESC';
                    $criteria->group = 'observasipendonor_id, waktu_observasi, pendonor_id';
                    $modObservasi = ObservasipendonorT::model()->find($criteria);
                    
                    /**
                     * Jika hasil_skrining = reaktif maka muncul warning
                     * Jika belum pernah skrining tetapi sudah > 56 hari tetap bisa donor 
                     */
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = "t.skriningimltd_id, t.hasil_skrining, t.pengujian_ke ";
                    $criteria2->join = "left join kantongdarah_t on kantongdarah_t.kantongdarah_id = t.kantongdarah_id
                                        left join pendonor_m on pendonor_m.pendonor_id = kantongdarah_t.pendonor_id";
                    $criteria2->group = "t.skriningimltd_id, t.hasil_skrining, t.pengujian_ke";
                    $criteria2->addCondition("pendonor_m.pendonor_id = ".$id);
                    $criteria2->order = "t.skriningimltd_id DESC, t.pengujian_ke DESC";
                    $modSkrining  = SkriningimltdT::model()->find($criteria2);
                    
                    if (empty($modObservasi)) {
                        $data['selisih_hari'] = 57;
                    } else if (!empty($modObservasi) && empty($modSkrining)) {
                        $data['selisih_hari'] = $modObservasi->selisih_hari;
                    } else if (empty($modObservasi) && !empty($modSkrining)) {
                        $data['selisih_hari'] = 57;
                        $data['hasil_skrining'] = $modSkrining['hasil_skrining'];
                    } else if (!empty($modObservasi) && !empty($modSkrining)) {
                        $data['selisih_hari'] = $modObservasi->selisih_hari;
                        $data['hasil_skrining'] = $modSkrining['hasil_skrining'];
                    }
                }
                

                if (!empty($pendonor)){
                    $data['pendonor'] = $pendonor->attributes;
                    $cekPekerjaanpendonor = PekerjaanpendonorM::model()->findByPk($pendonor->pekerjaan_id);
                
                    if(!empty($cekPekerjaanpendonor)){
                        $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                    }
                    $data['propinsi_id'] = !empty($pendonor->propinsi_id)?$pendonor->propinsi_id:$data['propinsi_id'];
                    $data['kabupaten_id'] = !empty($pendonor->kabupaten_id)?$pendonor->kabupaten_id:$data['kabupaten_id'];
                    $data['kecamatan_id'] = !empty($pendonor->kecamatan_id)?$pendonor->kecamatan_id:$data['kecamatan_id'];
                    $data['kelurahan_id'] = !empty($pendonor->kelurahan_id)?$pendonor->kelurahan_id:$data['kelurahan_id'];
                }else{
                    $data['pendonor'] = '';
                    if(!empty($cekPekerjaanpendonor)){
                        $data['pekerjaan_nama'] = !empty($cekPekerjaanpendonor) ?$cekPekerjaanpendonor->pekerjaanpendonor_nama:null;
                    }
                }
            }
                                
            
            if (!empty($cekDonor)){
                $data['reset'] = 'ya';
            }else{
                $data['reset'] = 'tidak';
            }
            
            $data['tipe'] = $tipe;
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
     /**
     * set dropdown daerah pasien berdasarkan
     * propinsi_id
     * kabupaten_id
     * kecamatan_id
     * kelurahan_id
     * pasien_id
     */
    public function actionSetDropdownDaerahPasien() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $modPasien = new PPPasienM;
            $propinsi_id = isset($_POST['propinsi_id'])?$_POST['propinsi_id']:null;
            $kabupaten_id = isset($_POST['kabupaten_id'])?$_POST['kabupaten_id']:null;
            $kecamatan_id = isset($_POST['kecamatan_id'])?$_POST['kecamatan_id']:null;
            $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

            $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE ORDER BY propinsi_nama ASC');
            $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
            $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($propinsis as $value => $name) {
                if ($value == $propinsi_id)
                    $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
//                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));

            $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
            $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($kabupatens as $value => $name) {
                if ($value == $kabupaten_id)
                    $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
//                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));

            $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
            $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($kecamatans as $value => $name) {
                if ($value == $kecamatan_id)
                    $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);

            $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
            $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
            foreach ($kelurahans as $value => $name) {
                if ($value == $kelurahan_id)
                    $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
                else
                    $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $dataList['listPropinsi'] = $propinsiOption;
            $dataList['listKabupaten'] = $kabupatenOption;
            $dataList['listKecamatan'] = $kecamatanOption;
            $dataList['listKelurahan'] = $kelurahanOption;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * Autocomplete DPJP
     * @author  Andyka <andykaputra@.com>
     */
    public function actionAutocompleteDpjp() {
        if (Yii::app()->request->isAjaxRequest) {

            $returnVal = array();
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (!isset($_GET['ruangan_id'])) {
                $_GET['ruangan_id'] = null;
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition('kelompokpegawai_id = 1');
            $criteria->addCondition('ruangan_id =' . $_GET['ruangan_id']);
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawairuanganV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}