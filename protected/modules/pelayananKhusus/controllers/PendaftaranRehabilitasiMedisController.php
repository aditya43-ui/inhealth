<?php

Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('pendaftaranPenjadwalan.views.pendaftaranRawatJalan');
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');

/**
 * controller dimodifikasi karena ada perubahan layout print 
 * BMB-942
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            <http://.com>
 * @package         application.modules.rehabMedis
 * @subpackage      controllers
 * 
 */
class PendaftaranRehabilitasiMedisController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rehabMedis.views.pendaftaranRehabilitasiMedis.';
    public $pasientersimpan = false;
    public $pendaftarantersimpan = false;
    public $penanggungjawabtersimpan = false;
    public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
    public $karcistersimpan = true; //dilooping / boleh tanpa ini
    public $komponentindakantersimpan = true; //di looping
    public $rujukantersimpan = false;
    public $pasienpenunjangtersimpan = true; //dilooping
    public $hasilpemeriksaantersimpan = true; //dilooping
    public $asuransipasientersimpan = false;

    /**
     * Index transaksi pendaftaran
     */
    public function actionIndex($id = null) {
        $format = new MyFormatter();
        $model = new RMPendaftaranT;
        $model->pendaftaran_id = null; //new record
        $modPasien = new RMPasienM;
        $modAsuransiPasien = new RMAsuransipasienM;
        $modPenanggungJawab = new RMPenanggungJawabM;
        $modPasienMasukPenunjang = new RMPasienmasukpenunjangT;
        $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_FISIOTERAPI;
        $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
        $modPemeriksaanRm = new RMTarifpemeriksaanrmruanganV;
        $modRujukan = new RMRujukanT;
        $modTindakan = new RMTindakanpelayananT;
        $modJenisTindakan = RMJenisTindakanrmM::model()->findAllByAttributes(array('jenistindakanrm_aktif' => true), array('order' => 'jenistindakanrm_nama'));
        $modTindakanRM = RMTindakanrmM::model()->findAllByAttributes(array('tindakanrm_aktif' => true), array('order' => 'tindakanrm_nama'));
        $modHasilPemeriksaan = new HasilpemeriksaanrmT;
        $dataTindakans = array();
        $modKarcis = array();
        $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
        $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
        $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
        $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
        $modPasien->agama = Params::DEFAULT_AGAMA;

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

        //==load data
        if (isset($id)) {
            $model = $this->loadModel($id);
            $modPasien = RMPasienM::model()->findByPk($model->pasien_id);
            $criteria = new CdbCriteria();
            $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
            $criteria->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
            $criteria->limit = 2;
            $criteria1 = $criteria;
            $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_FISIOTERAPI);
            $loadPasienMasukPenunjang = RMPasienmasukpenunjangT::model()->find($criteria1);
            if (isset($loadPasienMasukPenunjang)) {
                $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
                $modPasienMasukPenunjang->is_adakarcis = 1;
            }

            if (!empty($model->penanggungjawab_id)) {
                $modPenanggungJawab = RMPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
            }
            if (!empty($model->rujukan_id)) {
                $modRujukan = RMRujukanT::model()->findByPk($model->rujukan_id);
            }
            $dataKarcis = RMTindakanpelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_FISIOTERAPI, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
            if (isset($dataKarcis->karcis_id)) {
                $modKarcis[0] = RMKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis->karcis_id));
                $modKarcis[0]->harga_tariftindakan = $dataKarcis->tarif_tindakan;
            }

            $dataTindakans = RMTindakanpelayananT::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_FISIOTERAPI, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
        }

        if (isset($_POST['RMPendaftaranT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPasien = $this->simpanPasien($modPasien, $_POST['RMPasienM']);

                if ($_POST['RMPendaftaranT']['is_adapjpasien']) {
                    if (isset($_POST['RMPenanggungJawabM'])) {
                        $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['RMPenanggungJawabM']);
                    }
                } else {
                    $this->penanggungjawabtersimpan = true;
                }

                if ($_POST['RMPendaftaranT']['is_pasienrujukan']) {
                    if (isset($_POST['RMRujukanT'])) {
                        $modRujukan = $this->simpanRujukan($modRujukan, $_POST['RMRujukanT']);
                    }
                } else {
                    $this->rujukantersimpan = true;
                }

                if (isset($_POST['RMAsuransipasienM'])) {
                    if (isset($_POST['RMAsuransipasienM']['asuransipasien_id'])) {
                        if (!empty($_POST['RMAsuransipasienM']['asuransipasien_id'])) {
                            $modAsuransiPasien = RMAsuransipasienM::model()->findByPk($_POST['RMAsuransipasienM']['asuransipasien_id']);
                        }
                    }
                    $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['RMPendaftaranT'], $modPasien, $_POST['RMAsuransipasienM']);
                } else {
                    $this->asuransipasientersimpan = true;
                }

                $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['RMPendaftaranT'], $_POST['RMPasienM'], $_POST['RMPasienmasukpenunjangT'], $modAsuransiPasien);

                $postPenunjang = $_POST['RMPasienmasukpenunjangT'];
                $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, $postPenunjang);

                if (isset($_POST['RMTindakanpelayananT'])) {
                    if (count($_POST['RMTindakanpelayananT']) > 0) {
                        foreach ($_POST['RMTindakanpelayananT'] AS $ii => $tindakan) {
                            $dataTindakans[$ii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjang, $tindakan);
                            $dataTindakans[$ii]->daftartindakan_id = $tindakan['daftartindakan_id'];
                            $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
                            $modHasilPemeriksaan = $this->simpanHasilPemeriksaan($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                            $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
                        }
                    }
                }
                if ($postPenunjang['is_adakarcis']) {
                    if (isset($_POST['RMKarcisV'])) {
                        if (count($_POST['RMKarcisV']) > 0) {
                            foreach ($_POST['RMKarcisV'] AS $ii => $karcis) {
                                if ($karcis['is_pilihkarcis']) {
                                    $modKarcis[$ii] = new RMKarcisV;
                                    $modKarcis[$ii]->attributes = $karcis;
                                    $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjang, $karcis);
                                }
                            }
                        }
                    }
                }

                $this->broadcastNotifDaftarRehab($model, $modPasien);

                if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan) {
                    // SMS GATEWAY
                    $modPegawai = $modPasienMasukPenunjang->pegawai;
                    $modRuangan = $modPasienMasukPenunjang->ruangan;
                    if (isset($model->penanggungjawab)) {
                        $modPenanggungJawab = $model->penanggungjawab;
                    }
                    $sms = new Sms();
                    $smspasien = 1;
                    $smsdokter = 1;
                    $smspenanggungjawab = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        if (isset($model->penanggungjawab)) {
                            $attributes = $modPenanggungJawab->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                        }
                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPasienMasukPenunjang->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modRuangan->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPasienMasukPenunjang->tglmasukpenunjang), $isiPesan);
                        $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                            if (!empty($modPasien->no_mobile_pasien)) {
                                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                            } else {
                                $smspasien = 0;
                            }
                        } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
                            if (!empty($modPegawai->nomobile_pegawai)) {
                                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                            } else {
                                $smsdokter = 0;
                            }
                        } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms) {
                            if (!empty($modPenanggungJawab->no_mobilepj)) {
                                $sms->kirim($modPenanggungJawab->no_mobilepj, $isiPesan);
                            } else {
                                $smspenanggungjawab = 0;
                            }
                        }
                    }
                    // END SMS GATEWAY
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data pendaftaran berhasil disimpan !");
                    $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !");
//                        echo "-".$this->pasientersimpan."<br>";
//                        echo "-".$this->pendaftarantersimpan."<br>";
//                        echo "-".$this->penanggungjawabtersimpan."<br>";
//                        echo "-".$this->rujukantersimpan."<br>";
//                        echo "-".$this->karcistersimpan."<br>";
//                        echo "-".$this->tindakanpelayanantersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
//                        echo "-".$this->pengambilansampletersimpan."<br>";
//                        exit;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
            }
        }



        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modAsuransiPasien' => $modAsuransiPasien,
            'modPenanggungJawab' => $modPenanggungJawab,
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
            'modPemeriksaanRm' => $modPemeriksaanRm,
            'modRujukan' => $modRujukan,
            'modTindakan' => $modTindakan,
            'dataTindakans' => $dataTindakans,
            'modKarcis' => $modKarcis,
            'modJenisTindakan' => $modJenisTindakan,
            'modTindakanRM' => $modTindakanRM,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'modSmsgateway' => $modSmsgateway
        ));
    }

    protected function broadcastNotifDaftarRehab($model, $modPasien) {
        $judul = "Pendaftaran langsung Pasien Rehabilitasi";
        $isi = $model->no_pendaftaran . " - " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien;

        $linkDaftarPasien = Yii::app()->createUrl('/rehabMedis/daftarPasien/index', array(
            'ROPasienMasukPenunjangV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'ROPasienMasukPenunjangV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'ROPasienMasukPenunjangV[no_pendaftaran]' => $model->no_pendaftaran,
            'ROPasienMasukPenunjangV[statusperiksahasil]' => '',
            'ROPasienMasukPenunjangV[tgl_awall]' => date('Y-m-d'),
            'ROPasienMasukPenunjangV[tgl_akhirl]' => date('Y-m-d'),
            'ROPasienMasukPenunjangV[prefix_pendaftaran]' => '',
            'ROPasienMasukPenunjangV[ceklis]' => 0,
        ));


        // var_dump($judul, $isi, $linkDaftarPasien); die;

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Params::INSTALASI_ID_REHAB, 'ruangan_id' => Params::RUANGAN_ID_FISIOTERAPI, 'modul_id' => Params::MODUL_ID_REHABMEDIS, 'link_proses' => $linkDaftarPasien),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $linkDaftarPasien), //, 'link_proses'=>$link_rj
        ));
    }

    /**
     * form verifikasi sebelum submit
     * @param type $id
     */
    public function actionVerifikasi() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = '//layouts/iframe';
            if (isset($_POST['RMPendaftaranT'])) {
                $format = new MyFormatter();
                $model = new RMPendaftaranT;
                $modPasien = new RMPasienM;
                $modPenanggungJawab = null;
                $modRujukan = null;
                $modTindakans = array();
                $modKarcis = array();

                $model->attributes = $_POST['RMPendaftaranT'];
                $modPasien->attributes = $_POST['RMPasienM'];
                if ($_POST['RMPendaftaranT']['is_adapjpasien']) {
                    if (isset($_POST['RMPenanggungJawabM'])) {
                        $modPenanggungJawab = new RMPenanggungJawabM;
                        $modPenanggungJawab->attributes = $_POST['RMPenanggungJawabM'];
                    }
                }

                if ($_POST['RMPendaftaranT']['is_pasienrujukan']) {
                    if (isset($_POST['RMRujukanT'])) {
                        $modRujukan = new RMRujukanT;
                        $modRujukan->attributes = $_POST['RMRujukanT'];
                        $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
                    }
                }

                $modPasienMasukPenunjang = new RMPasienmasukpenunjangT;
                $postPenunjang = $_POST['RMPasienmasukpenunjangT'];
                $modPasienMasukPenunjang->attributes = $postPenunjang;
                $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
                if (isset($_POST['RMTindakanpelayananT'])) {
                    if (count($_POST['RMTindakanpelayananT']) > 0) {
                        foreach ($_POST['RMTindakanpelayananT'] AS $ii => $tindakan) {
                            $modTindakans[$ii] = new RMTindakanpelayananT;
                            $modTindakans[$ii]->attributes = $tindakan;
                        }
                    }
                }
                if ($postPenunjang['is_adakarcis']) {
                    if (isset($_POST['RMKarcisV'])) {
                        if (count($_POST['RMKarcisV']) > 0) {
                            foreach ($_POST['RMKarcisV'] AS $ii => $karcis) {
                                if ($karcis['is_pilihkarcis']) {
                                    $modKarcis[$ii] = new RMKarcisV;
                                    $modKarcis[$ii]->attributes = $karcis;
                                }
                            }
                        }
                    }
                }
            }

            echo CJSON::encode(array(
                'content' => $this->renderPartial($this->path_view . 'verifikasi', array(
                    'model' => $model,
                    'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
                    'modPasien' => $modPasien,
                    'modPenanggungJawab' => $modPenanggungJawab,
                    'modRujukan' => $modRujukan,
                    'modTindakans' => $modTindakans,
                    'modKarcis' => $modKarcis,
                    'format' => $format,
                    ), true)));
            Yii::app()->end();
        }
    }

    /**
     * proses simpan / ubah data pasien
     * @param type $modPasien
     * @param type $post
     * @return type
     */
    public function simpanPasien($modPasien, $post) {
        $format = new MyFormatter();
        if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
            $load = new $modPasien;
            $modPasien = $load->findByPk($post['pasien_id']);
        }
        $modPasien->attributes = $post;
        $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
        $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
        if (isset($post['tempPhoto'])) {
            $modPasien->photopasien = $post['tempPhoto'];
        }
        if (empty($modPasien->pasien_id)) {
            $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
            $modPasien->profilrs_id = Params::getDefaultProfilRS();
            $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
            $modPasien->ispasienluar = TRUE;
            $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modPasien->create_time = date('Y-m-d H:i:s');
            $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjang(Yii::app()->user->getState('mr_rehabmedis'));
        } else {
            $modPasien->update_loginpemakai_id = Yii::app()->user->id;
            $modPasien->update_time = date('Y-m-d H:i:s');
        }
        $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
        $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

        if ($modPasien->save()) {
            $this->pasientersimpan = true;
        }
        return $modPasien;
    }

    /**
     * proses simpan data penanggungjawab pasien
     * @param type $modPenanggungjawab
     * @param type $post
     * @return type
     */
    public function simpanPenanggungjawab($modPenanggungjawab, $post) {
        $format = new MyFormatter;
        $modPenanggungjawab->attributes = $post;
        $modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);

        if ($modPenanggungjawab->save()) {
            $this->penanggungjawabtersimpan = true;
        }
        return $modPenanggungjawab;
    }

    /**
     * proses simpan data rujukan
     * @param type $modRujukan
     * @param type $post
     * @return type
     */
    public function simpanRujukan($modRujukan, $post) {
        $format = new MyFormatter();
        $modRujukan->attributes = $post;
        $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);

        if ($modRujukan->save()) {
            $this->rujukantersimpan = true;
        }
        return $modRujukan;
    }

    /**
     * simpan asuransi pasien
     * @param type $modAsuransiPasien
     * @param type $postPendaftaran
     * @param type $postPasien
     * @param type $postAsuransiPasien
     * @return type
     */
    public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien) {
        $format = new MyFormatter();
        $modAsuransiPasien->attributes = $postAsuransiPasien;
        $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
        $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
        $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
        $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
        $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
        $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);

        if (empty($modAsuransiPasien->masaberlakukartu)) {
            $modAsuransiPasien->masaberlakukartu = null;
        }

        // var_dump($modAsuransiPasien->attributes); die;

        if ($modAsuransiPasien->save()) {
            $this->asuransipasientersimpan = true;
        }
        return $modAsuransiPasien;
    }

    /**
     * proses simpan / ubah data pendaftaran
     * @return type
     */
    public function simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $postPenunjang, $modAsuransiPasien) {
        $format = new MyFormatter();
        $model->attributes = $post;
        $model->pendaftaran_id = null;
        $model->pasien_id = $modPasien->pasien_id;
        $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
        $model->rujukan_id = $modRujukan->rujukan_id;
        $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);

        if (!empty($postPenunjang['pegawai_id'])) {
            $model->pegawai_id = $postPenunjang['pegawai_id'];
        }
        if (!empty($postPenunjang['jeniskasuspenyakit_id'])) {
            $model->jeniskasuspenyakit_id = $postPenunjang['jeniskasuspenyakit_id'];
        }
        if (!empty($postPenunjang['kelaspelayanan_id'])) {
            $model->kelaspelayanan_id = $postPenunjang['kelaspelayanan_id'];
        }
        if (!empty($postPenunjang['ruangan_id'])) {
            $model->ruangan_id = $postPenunjang['ruangan_id'];
        }
        if (empty($model->ruangan_id)) {
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
        $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
        $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
        $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
        $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
        $model->shift_id = Yii::app()->user->getState('shift_id');
        $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
        $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
        $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
        $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_time = date("Y-m-d H:i:s");
        if (Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)) {
            $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
        } else {
            $model->tgl_pendaftaran = date("Y-m-d H:i:s");
        }
        $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
        $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
        $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
        $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
        $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;

        if ($model->save()) {
            $this->pendaftarantersimpan = true;
        }
        return $model;
    }

    /**
     * Fungsi untuk menyimpan data ke model RMPasienmasukpenunjangT
     * @param type $modPendaftaran
     * @param type $modPasien
     * @return RMPasienmasukpenunjangT 
     */
    public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post) {
        $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
        $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
        $modPasienMasukPenunjang->attributes = $post;
        $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPasienMasukPenunjang->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
        $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
        $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
        $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
        $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
        $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
        $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
        $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
        $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

        if ($modPasienMasukPenunjang->validate()) {
            $modPasienMasukPenunjang->save();
            $this->pasienpenunjangtersimpan &= true;
        } else {
            $this->pasienpenunjangtersimpan &= false;
        }

        return $modPasienMasukPenunjang;
    }

    /**
     * proses simpan RMTindakanpelayananT dan RMTindakanKomponenT
     */
    public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post) {
        $modTindakan = new RMTindakanpelayananT;
        $format = new MyFormatter();
        $modTindakan->attributes = $modPendaftaran->attributes;
        $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
        $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modTindakan->attributes = $post;
        $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
        $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
        $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
        if (!empty($modTindakan->karcis_id)) {
            $this->karcistersimpan = true;
            if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
                if (!empty($post['harga_tariftindakan'])) {
                    $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
                }
            }
            $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
        }
        $modTindakan->create_time = date("Y-m-d H:i:s");
        $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
        $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
        if (isset($_POST['tgl_tindakan_semua'])) {
            $modTindakan->tgl_tindakan = $format->formatDateTimeForDb($_POST['tgl_tindakan_semua']);
        }
        $modTindakan->tgl_tindakan = (empty($modTindakan->tgl_tindakan) ? date("Y-m-d H:i:s") : $modTindakan->tgl_tindakan);
        $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
        $modTindakan->cyto_tindakan = 0;
        $modTindakan->tarifcyto_tindakan = 0;
        $modTindakan->discount_tindakan = 0;
        $modTindakan->subsidiasuransi_tindakan = 0;
        $modTindakan->subsidipemerintah_tindakan = 0;
        $modTindakan->subsisidirumahsakit_tindakan = 0;
        $modTindakan->iurbiaya_tindakan = 0;
        $modTindakan->tarif_rsakomodasi = 0;
        $modTindakan->tarif_medis = 0;
        $modTindakan->tarif_paramedis = 0;
        $modTindakan->tarif_bhp = 0;

        if ($modTindakan->validate()) {
            $modTindakan->save();
        } else {
            $this->tindakanpelayanantersimpan &= false;
        }

        return $modTindakan;
    }

    /**
     * menentukan tipepaket_id
     * @param type $modPendaftaran
     * @param type $karcis_id
     * @param type $idTindakan
     * @return type
     */
    public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id) {
        $criteria = new CDbCriteria;
        $criteria->with = array('tipepaket');
        if (!empty($tindakan_id)) {
            $criteria->addCondition('daftartindakan_id =' . $tindakan_id);
        }
        if (!empty($modPendaftaran->carabayar_id)) {
            $criteria->addCondition('tipepaket.carabayar_id =' . $modPendaftaran->carabayar_id);
        }
        if (!empty($modPendaftaran->penjamin_id)) {
            $criteria->addCondition('tipepaket.penjamin_id =' . $modPendaftaran->penjamin_id);
        }
        if (!empty($modPendaftaran->kelaspelayanan_id)) {
            $criteria->addCondition('tipepaket.kelaspelayanan_id =' . $modPendaftaran->kelaspelayanan_id);
        }
        $paket = PaketpelayananM::model()->find($criteria);
        $result = Params::TIPEPAKET_ID_NONPAKET;
        if (isset($paket))
            $result = $paket->tipepaket_id;

        return $result;
    }

    /**
     * set umur dari tanggal lahir (date)
     */
    public function actionSetUmur() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['umur'] = null;
            if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
                $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * set dropdown dokter
     */
    public function actionSetDropdownDokter() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new RMPendaftaranT;
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($_POST['ruangan_id'])) {
                $data = $model->getDokterItems($_POST['ruangan_id']);
                $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['listDokter'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * set dropdown jenis kasus penyakit
     */
    public function actionSetDropdownJeniskasuspenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new RMPendaftaranT;
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($_POST['ruangan_id'])) {
                $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
                $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['listKasuspenyakit'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * set dropdown penjamin pasien dari carabayar_id
     * @param type $encode
     * @param type $namaModel
     */
    public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
            if ($encode) {
                echo CJSON::encode($penjamin);
            } else {
                if (empty($carabayar_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
                    if (count($penjamin) > 1) {
                        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    }
                    $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                    foreach ($penjamin as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * set antrian ruangan
     */
    public function actionSetAntrianRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $data = array();
            $data['maxantrianruangan'] = null;
            $data['no_urutantri'] = '001';
            if (!empty($ruangan_id)) {
                $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
                $criteria = new CDbCriteria;
                $criteria->addCondition('ruangan_id =' . $ruangan_id);
                $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
                if (count($modJadwalBukaPoli) > 0) {
                    foreach ($modJadwalBukaPoli as $key => $antrian) {
                        $data['maxantrianruangan'] = $antrian->maxantiranpoli;
                    }
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * set antrian dokter
     */
    public function actionSetAntrianDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST['ruangan_id'];
            $pegawai_id = $_POST['pegawai_id'];
            $data = array();
            $data['maxantriandokter'] = 0;
            if (!empty($ruangan_id) && !empty($pegawai_id)) {
                $criteria = new CDbCriteria;
                $criteria->addCondition('ruangan_id =' . $ruangan_id);
                $criteria->addCondition('pegawai_id =' . $pegawai_id);
                $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
                if (count($modJadwalDokter) > 0) {
                    foreach ($modJadwalDokter as $key => $antrian) {
                        $data['maxantriandokter'] = $antrian->maximumantrian;
                    }
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * menampilkan karcis
     */
    public function actionSetKarcis() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            $ruangan_id = $_POST['ruangan_id'];
            $pasien_id = $_POST['pasien_id'];
            $penjamin_id = $_POST['penjamin_id'];
            $form = '';
            $is_pasienbaru = 'true';
            if (!empty($pasien_id)) {
                $modPasien = PasienM::model()->findByPk($pasien_id);
                if (isset($modPasien)) {
                    $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF) ? 'false' : 'true';
                }
            }
            $criteria = new CdbCriteria();
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
            $criteria->addCondition("ruangan_id = " . $ruangan_id);
            $criteria->addCondition("penjamin_id = " . $penjamin_id);
            if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
                $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
            }
            $modKarcis = RMKarcisV::model()->findAll($criteria);
            $form = $this->renderPartial($this->path_view . '_formKarcis', array('modKarcis' => $modKarcis), true);
            $data['listKarcis'] = $form;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * set tabel riwayat kunjungan pasien
     */
    public function actionSetRiwayatKunjunganPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $data['table'] = "";
            $modPasien = new RMPasienM;
            $modPasien->pasien_id = $_POST['pasien_id'];
            $data['table'] = $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
                'modPasien' => $modPasien,
                ), true);
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * untuk menampilkan pasien lama dari autocomplete
     * 1. no_rekam_medik
     * 2. no_identitas_pasien
     * 3. nama_pasien
     * 4. nama_bin (alias)
     */
    public function actionAutocompletePasienLama() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->compare('tanggal_lahir', $tanggal_lahir);
            $criteria->compare('ispasienluar', true);
            $criteria->limit = 5;
            $models = PasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
                $returnVal[$i]['value'] = $model->no_rekam_medik;
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * Autocomplete Asuransi
     * @throws CHttpException
     */
    public function actionAutocompleteAsuransi() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
            $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
            $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
            $criteria->addCondition('penjamin_id=' . $penjamin_id);
            $criteria->addCondition('asuransipasien_aktif is true');
            if ($_GET['pasien_id'] == "") {
                $criteria->addCondition('pasien_id is null');
            } else {
                $criteria->addCondition('pasien_id=' . $pasien_id);
            }
            $criteria->limit = 5;
            $models = RMAsuransipasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
                $returnVal[$i]['value'] = $model->nopeserta;
                $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
                $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
            }


            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    public function actionAutocompleteAsuransiKartu() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
            $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
            $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi), true);
            $criteria->addCondition('penjamin_id=' . $penjamin_id);
            if ($_GET['pasien_id'] == "") {
                $criteria->addCondition('pasien_id is null');
            } else {
                $criteria->addCondition('pasien_id=' . $pasien_id);
            }
            $criteria->limit = 5;
            $models = RMAsuransipasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nokartuasuransi . ' - ' . $model->namapemilikasuransi;
                $returnVal[$i]['value'] = $model->nokartuasuransi;
                $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                $returnVal[$i]['nopeserta'] = $model->nopeserta;
                $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
            }


            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * menampilkan data asuransi terakhir pasien
     * @throws CHttpException
     */
    public function actionSetAsuransiPasienLama() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data = array();
            $criteria = new CDbCriteria();
            $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
            $criteria->order = 'asuransipasien_id DESC';
            $model = AsuransipasienM::model()->find($criteria);
            if (!empty($model)) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $data["$attribute"] = $model->$attribute;
                }
                $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
                $data['listPenjamin'] = "";
                $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
                if (count($penjamin) > 1) {
                    $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                }
                $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
                foreach ($penjamin as $value => $name) {
                    $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            } else {
                $data = null;
            }
            echo CJSON::encode($data);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * Mengurai data pasien berdasarkan pasien_id
     * @throws CHttpException
     */
    public function actionGetDataPasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
            if (!empty($pasien_id)) {
                $criteria->addCondition('pasien_id =' . $pasien_id);
            }
            $criteria->compare('no_rekam_medik', $no_rekam_medik);
            $model = PasienM::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));


            if (!empty($pasien_id)) {
                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                    'pasien_id' => $pasien_id,
                    ), array(
                    'condition' => 'pasienbatalperiksa_id is null',
                    'order' => 'pendaftaran_id desc',
                ));
//                    if (empty($pendafaran)) {
//                        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
//                            'pasien_id'=>$pasien_id,
//                        ), array(
//                            'condition'=>'pasienbatalperiksa_id is null',
//                            'order'=>'pendaftaran_id desc',
//                        ));
//                    }
            } else if (!empty($no_rekam_medik)) {
                $p = PasienM::model()->findByAttributes(array('no_rekam_medik' => trim($no_rekam_medik)));
                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                    'pasien_id' => $p->pasien_id,
                    ), array(
                    'condition' => 'pasienbatalperiksa_id is null',
                    'order' => 'pendaftaran_id desc',
                ));
//                    if (empty($pendafaran)) {
//                        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
//                            'pasien_id'=>$p->pasien_id,
//                        ), array(
//                            'condition'=>'pasienbatalperiksa_id is null',
//                            'order'=>'pendaftaran_id desc',
//                        ));
//                    }
            } else {
                $pendaftaran = null;
            }

            $returnVal['lebih'] = false;
            $returnVal['adaDaftar'] = false;

            $pp = null;
            if (!empty($pendaftaran)) {
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;

                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                $pp = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

                if (!empty($admisi)) {
                    $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                } else {
                    switch ($pendaftaran->instalasi_id) {
                        case Params::INSTALASI_ID_RJ:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_RD:
                            $this->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        case Params::INSTALASI_ID_RI:
                            $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                        default:
                            $this->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal);
                            break;
                    }
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    
    function periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, &$returnVal) {   //var_dump($pendaftaran->attributes);
        if (!empty($pendaftaran->pasienpulang_id)) {
            // echo "Kick"; die;
            $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
            if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                if (!empty($pendaftaran->pasienadmisi_id)) {
                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                } else {
                    $returnVal['tindakLanjut'] = true;
                }
            }
        } else {
            $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                ), array(
                'condition' => 'tindakansudahbayar_id is null  and qty_tindakan <> 0',
            ));
            $oa = ObatalkespasienT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                ), array(
                'condition' => 'oasudahbayar_id is null and qty_oa <> 0',
            ));

            $isAda = false;
            if (!empty($oa) || !empty($tindakan)) {
                if (empty($pendaftaran->pembayaranpelayanan_id))
                    $isAda = true;
            }

            // var_dump($isAda); die;
            if ($isAda && !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_PULANG))) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
            }
        }
    }

    function periksaValidasiPasienRD($pendaftaran, $admisi, $pp, &$returnVal) {
        if (!empty($pendaftaran->pasienpulang_id)) {
            $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
            if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                if (!empty($pendaftaran->pasienadmisi_id)) {
                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                } else {
                    $returnVal['tindakLanjut'] = true;
                }
            }
        } else {
            $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                ), array(
                'condition' => 'tindakansudahbayar_id is null and qty_tindakan <> 0',
            ));
            $oa = ObatalkespasienT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                ), array(
                'condition' => 'oasudahbayar_id is null and qty_oa <> 0',
            ));

            $isAda = false;
            if (!empty($oa) || !empty($tindakan)) {
                if (empty($pendaftaran->pembayaranpelayanan_id))
                    $isAda = true;
            }

            if ($isAda || !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_PULANG))) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
            }
        }
    }

    function periksaValidasiPasienRI($pendaftaran, $admisi, $pp, &$returnVal) {
        if (empty($pendaftaran->pasienpulang_id)) {
            $returnVal['adaDaftar'] = true;
            $returnVal['listDaftar'] = $pendaftaran->attributes;
            $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
            $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
            $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
            $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
            if (!empty($admisi)) {

                if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $pendaftaran->statusperiksa == Params::STATUSPERIKSA_BATAL_PERIKSA) {
                    $returnVal['adaDaftar'] = false;
                } else {
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                }
            } else {
                if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $pendaftaran->statusperiksa == Params::STATUSPERIKSA_BATAL_PERIKSA) {
                    $returnVal['adaDaftar'] = false;
                }
                //var_dump($admisi);
            }
        } else {
            //var_dump($pendaftaran->statusperiksa);
            if ($pendaftaran->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG && $pendaftaran->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA) {
                //var_dump($pendaftaran->statusperiksa);
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                if (!empty($admisi)) {
                    $returnVal['adaInap'] = true;
                    $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                } else {
                    $returnVal['adaDaftar'] = false;
                }
            } else {
                $returnVal['adaDaftar'] = false;
            }
        }
        //var_dump($pendaftaran->pasienpulang_id);die;
    }

    function periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, &$returnVal) {
        //if (date('Y-m-d', time()) == date('Y-m-d', strtotime($pendaftaran->tgl_pendaftaran))) {
        if (!in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SUDAH_PULANG))) {
            $returnVal['adaDaftar'] = true;
            $returnVal['listDaftar'] = $pendaftaran->attributes;
            $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
            $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
            $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
        }
    }
    
    
    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new RMPasienM;
            if ($model_nama !== '' && $attr == '') {
                $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $propinsi_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $propinsi_id = $_POST["$model_nama"]["$attr"];
            }
            $kabupaten = null;
            if ($propinsi_id) {
                $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
                $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
            }
            if ($encode) {
                echo CJSON::encode($kabupaten);
            } else {
                if (empty($kabupaten)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kabupaten as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Mengatur dropdown kecamatan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new RMPasienM;
            if ($model_nama !== '' && $attr == '') {
                $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kabupaten_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kabupaten_id = $_POST["$model_nama"]["$attr"];
            }
            $kecamatan = null;
            if ($kabupaten_id) {
                $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
                $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kecamatan);
            } else {
                if (empty($kecamatan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kecamatan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Mengatur dropdown kelurahan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new RMPasienM;
            if ($model_nama !== '' && $attr == '') {
                $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kecamatan_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kecamatan_id = $_POST["$model_nama"]["$attr"];
            }
            $kelurahan = null;
            if ($kecamatan_id) {
                $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kelurahan);
            } else {
                if (empty($kelurahan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kelurahan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
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
            $modPasien = new RMPasienM;
            $propinsi_id = $_POST['propinsi_id'];
            $kabupaten_id = $_POST['kabupaten_id'];
            $kecamatan_id = $_POST['kecamatan_id'];
            $kelurahan_id = $_POST['kelurahan_id'];

            $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
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
     * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
     */
    public function actionSetTanggalLahir() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * untuk drop down rujukan
     */
    public function actionGetRujukanDari($encode = false, $namaModel = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

            if ($encode) {
                echo CJSON::encode($rujukandari);
            } else {
                if (empty($asalrujukan_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
                    $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
                    foreach ($rujukandari as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RMPendaftaranT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lkpendaftaran-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * set checklist pemeriksaan rehab medis
     */
    public function actionSetChecklistPemeriksaanRehab() {
        if (Yii::app()->request->isAjaxRequest) {
            $content = "";
            parse_str($_POST['data'], $post);
            $postPemeriksaan = $post['RMTarifpemeriksaanrmruanganV'];
            if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
                $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
                if (!empty($modJenisTarif)) {
                    $jenistarif_id = $modJenisTarif->jenistarif_id;
                }
                $criteria = new CdbCriteria();
                $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
                $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
                $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
                if (!empty($jenistarif_id)) {
                    $criteria->addCondition('jenistarif_id = ' . $jenistarif_id);
                }
                $criteria->compare('LOWER(tindakanrm_nama)', strtolower($postPemeriksaan['tindakanrm_nama']), true);
                $criteria->compare('LOWER(jenistindakanrm_nama)', strtolower($postPemeriksaan['jenistindakanrm_nama']), true);
                $criteria->order = "jenistindakanrm_nama, tindakanrm_nama";
                $modPemeriksaanRehabMediss = RMTarifpemeriksaanrmruanganV::model()->findAll($criteria);
                $content = $this->renderPartial('rehabMedis.views.pendaftaranRehabilitasiMedis._checklistPemeriksaanRehabMedis', array('modPemeriksaanRehabMediss' => $modPemeriksaanRehabMediss), true);
            }
            echo CJSON::encode(array(
                'content' => $content));
            Yii::app()->end();
        }
    }

    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintStatusRehabMedis($pendaftaran_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran = $this->loadModel($pendaftaran_id);
        $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modTindakans = array();
        $criteria1 = new CdbCriteria();
        $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
        $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
        $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_FISIOTERAPI);
        $loadPasienMasukPenunjang = RMPasienmasukpenunjangT::model()->find($criteria1);
        if (isset($loadPasienMasukPenunjang)) {
            $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
            $modTindakans = RMTindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id), "karcis_id is not null");
            $criteria_tot = new CdbCriteria();
            $criteria_tot->addCondition("karcis_id IS NULL");
            $criteria_tot->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
            $daftartindakan = RMTindakanpelayananT::model()->findAll($criteria_tot);
        }

        $judul_print = 'Kunjungan Rehab Medis';
        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF('', array(140, 950));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(
            $this->renderPartial('rehabMedis.views.pendaftaranRehabilitasiMedis.printStatusRehabMedis', array(
                'format' => $format,
                'modPendaftaran' => $modPendaftaran,
                'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
                'judul_print' => $judul_print,
                'modPasien' => $modPasien,
                'modTindakans' => $modTindakans,
                'daftartindakan' => $daftartindakan,
                ), true)
        );
        $mpdf->SetJS('this.print();');
        $mpdf->Output();
//      
    }

    /**
     * simpan RMHasilpemeriksaanrmT
     */
    public function simpanHasilPemeriksaan($modPasienMasukPenunjang, $modTindakan, $post) {
        $modHasilPemeriksaan = new HasilpemeriksaanrmT;
        $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
        $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modHasilPemeriksaan->jenistindakanrm_id = $post['jenistindakanrm_id'];
        $modHasilPemeriksaan->tindakanrm_id = $post['tindakanrm_id'];
        $modHasilPemeriksaan->tglpemeriksaanrm = $modPasienMasukPenunjang->tglmasukpenunjang;
        $modHasilPemeriksaan->kunjunganke = 1; //di default untuk kunjungan pertama
        $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
        $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
        $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
        $modHasilPemeriksaan->nohasilrm = MyGenerator::noHasilPemeriksaanRM();

        if ($modHasilPemeriksaan->validate()) {
            $modHasilPemeriksaan->save();
            $modTindakan->hasilpemeriksaanrm_id = $modHasilPemeriksaan->hasilpemeriksaanrm_id;
            $modTindakan->save();
        } else {
            $this->hasilpemeriksaantersimpan = false;
        }
    }

    /**
     * print kartu pasien
     * @param type $pasien_id		 
     */
    public function actionPrintKartuPasien($pasien_id) {
        $con = new PendaftaranRawatJalanController("PendaftaranRawatJalanController", Yii::app()->getModule('rehabMedis'));
        return $con->actionPrintKartuPasien($pasien_id);
    }

    /**
     * - digunakan untuk mencetak sticker
     * @param integer $pendaftaran_id
     */
    public function actionPrintLabel($pendaftaran_id) {
        $con = new PendaftaranRawatJalanController("PendaftaranRawatJalanController", Yii::app()->getModule('rehabMedis'));
        return $con->actionPrintLabel($pendaftaran_id);
    }

    public function actionPrintKlaim2($pendaftaran_id) {
      $this->layout = '//layouts/printWindows';

      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      // var_dump($modPendaftaran->carabayar_id)
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
      $modPenanggungjawab=PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
      $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
      $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
      // echo "<pre>";
      // var_dump($modPegawai);die;

      $judulLaporan = '';
      // var_dump($_REQUEST);die;

      // $caraPrint = $_REQUEST['caraPrint'];
      // if ($caraPrint == 'PRINT') {
      //     $this->layout = '//layouts/printWindows';
      // }
      $this->render($this->path_view . 'printKlaim2', array(
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'modAsuransi'   => $modAsuransi,
          'modPenanggungjawab' => $modPenanggungjawab,
          'format'=>$format,
          'modPegawai' => $modPegawai,
          'modPenjamin'=> $modPenjamin,

          //'model' => $model,
          'judulLaporan' => $judulLaporan,
          //'caraPrint' => $caraPrint
      ));
  }

}
