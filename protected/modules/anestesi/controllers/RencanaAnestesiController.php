<?php

/**
 * controller Rencana Anestesi
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 * RSST-2239
 */
class RencanaAnestesiController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $path_view = 'anestesi.views.rencanaAnestesi.';
    public $pelaksanasimpan = true;
    public $pasienanestesitersimpan = false;
    public $pasienpenunjangtersimpan = true;

    /**
     * Fungsi untuk menambahkan rencana anestesi 
     * @param type $pendaftaran_id
     * @param type $pasienkirimkeunitlain_id
     */
    public function actionIndex($pendaftaran_id = null, $pasienkirimkeunitlain_id = null, $pasienanastesi_id = null) {
        $modPasienMasukPenunjang = null;

        if (empty($pasienanastesi_id)) {
            $cekRencana = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
        } else {
            $cekRencana = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienanastesi_id' => $pasienanastesi_id));
        }

        if (!empty($cekRencana)) {
            $model = $cekRencana;
            $model->diagnosa_praanestesi = $model->diagnosa_praanestesi;
            $model->diagnosa_praanestesi_nama = !empty($model->diagnosa_praanestesi) ? $model->diagnosa->diagnosa_nama : "";
            if (!empty($pasienkirimkeunitlain_id)) {
                $cekPasienAnas = PasienanastesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
                if (!empty($cekPasienAnas)) {
                    $modPasienAnas = ATPasienanastesiT::model()->findByPk($cekPasienAnas->pasienanastesi_id);
                    $modPasienMasukPenunjang = ATPasienmasukpenunjangT::model()->findByPk($modPasienAnas->pasienmasukpenunjang_id);
                }
            }
            $model->spesialis_nama = !empty($model->spesialis->nama_pegawai) ? $model->spesialis->nama_pegawai : '';
            $model->perawat_nama = !empty($model->perawat->nama_pegawai) ? $model->perawat->nama_pegawai : '';
            $model->ppds_nama = !empty($model->ppds->ppds_nama) ? $model->ppds->ppds_nama : '';
        } else {
            $model = new EvaluasianestesiT();
            $morbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id DESC'));
            $model->diagnosa_praanestesi = isset($morbiditas->diagnosa_id) ? $morbiditas->diagnosa_id : " ";
            $model->diagnosa_praanestesi_nama = !empty($morbiditas->diagnosa_id) ? $morbiditas->diagnosa->diagnosa_nama : "";
            $model->ruangan_id = Params::RUANGAN_ID_BEDAH;
            if (!empty($pasienkirimkeunitlain_id)) {
                $cekPasienKirimUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
                $model->kamarruangan_id = !empty($cekPasienKirimUnitLain) ? $cekPasienKirimUnitLain->ops_kamarruangan_id : '';
            }
        }

        if (!empty($pasienanastesi_id)) {
            $modPasienAnas = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);
            $modPasienMasukPenunjang = ATPasienmasukpenunjangT::model()->findByPk($modPasienAnas->pasienmasukpenunjang_id);

            $model->pasienanastesi_id = $modPasienAnas->pasienanastesi_id;
        }

        $model->tglevaluasianestesi = date('Y-m-d H:i:s');
        $pelaksanaanestesi = new ATPelaksanaanestesiT();

        $modPendaftaran = ATPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        /* Ambil diagnosa */

        $format = new MyFormatter();

        if (isset($_POST['EvaluasianestesiT'])) {
//            echo '<pre>';
//            var_dump($_POST);
//            die();
            $success = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {

                if (empty($pasienanastesi_id)) {
                    $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

                    $modPasienMasukPenunjang = $this->simpanPasienPenunjang($modPendaftaran, $modKirimKeUnitLain);
                }

                $modPasienAnastesi = $this->simpanPasienAnestesi($_POST['EvaluasianestesiT']['pasienanastesi_id'], $modPendaftaran, $_POST['EvaluasianestesiT'], $modPasienMasukPenunjang);

                $model->attributes = $_POST['EvaluasianestesiT'];
                $model->spesialis_id = $_POST['EvaluasianestesiT']['spesialis_id'];
                $model->ppds_id = $_POST['EvaluasianestesiT']['ppds_id'];
                $model->perawat_id = $_POST['EvaluasianestesiT']['perawat_id'];
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                if (!empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                    $model->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
                    $model->pasienkirimkeunitlain_id = $modPasienMasukPenunjang->pasienkirimkeunitlain_id;
                } else {
                    $model->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
                }
                $model->tglevaluasianestesi = $format->formatDateTimeForDb($_POST['EvaluasianestesiT']['tglevaluasianestesi']);
                if (empty($cekRencana)) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }
                $model->pasienanastesi_id = $modPasienAnastesi->pasienanastesi_id;

                if ($model->save()) {

                    if (!empty($model->pasienkirimkeunitlain_id)) {
                        $cri = new CDbCriteria();
                        $cri->join = " JOIN pasienmasukpenunjang_t penunj ON penunj.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id "
                                . " JOIN pasienkirimkeunitlain_t kirimunitanas ON kirimunitanas.pasienkirimkeunitlainparent_id = penunj.pasienkirimkeunitlain_id ";
                        $cri->addCondition(" kirimunitanas.pasienkirimkeunitlain_id = " . $model->pasienkirimkeunitlain_id . " AND t.pasienanastesi_id is NULL ");
                        $rencana = RencanaoperasiT::model()->findAll($cri);

                        if (!empty($rencana)) {
                            foreach ($rencana as $det) {
                                $det->pasienanastesi_id = $model->pasienanastesi_id;
                                $det->save();
                            }
                        }
                    }
                    
                    if (isset($_POST['ATPelaksanaanestesiT'])) {
                    foreach ($_POST['ATPelaksanaanestesiT'] as $i => $postDetail) {
                        if (!empty($postDetail['pelaksanaanestesi_id'])) {
                            //untuk cek data sudah tersedia 
                            $jumlah = ATPelaksanaanestesiT::model()->countByAttributes(array(
                                'pelaksanaanestesi_id' => $postDetail['pelaksanaanestesi_id']
                            ));

                            if ($jumlah != 0) {

                                if (!empty($model->evaluasianestesi_id) && ($_GET['status'] = 'update')) {
                                    $modPelaksana = ATPelaksanaanestesiT::model()->findByPk($postDetail['pelaksanaanestesi_id']);
                                }

                                if ($postDetail['status'] == 1) {//untuk hapus data yang sudah ada
                                    $modPelaksana->delete();
                                } else { //untuk edit data baru
                                    $modPelaksana->attributes = $postDetail;
                                    $modPelaksana->ppds_id = $postDetail['ppds_id'];
                                    $modPelaksana->pegawai_id = $postDetail['pegawai_id'];
                                    $modPelaksana->update_time = date('Y-m-d H:i:s');
                                    $modPelaksana->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                    if($modPelaksana->save()){
                                        $this->pelaksanasimpan = true;
                                    }else{
                                        $this->pelaksanasimpan = false;
                                    }
                                }
                            }
                        } else {
                            $modPelaksana = new ATPelaksanaanestesiT();
                            $modPelaksana->attributes = $postDetail;
                            $modPelaksana->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                            $modPelaksana->pasien_id = $modPendaftaran->pasien_id;
                            $modPelaksana->evaluasianestesi_id = $model->evaluasianestesi_id;
                            $modPelaksana->ppds_id = $postDetail['ppds_id'];
                            $modPelaksana->pegawai_id = $postDetail['pegawai_id'];
                            $modPelaksana->create_time = date('Y-m-d H:i:s');
                            $modPelaksana->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $modPelaksana->create_ruangan = Yii::app()->user->getState('create_ruangan');
                            if($modPelaksana->save()){
                                $this->pelaksanasimpan = true;
                            }else{
                                $this->pelaksanasimpan = false;
                            }
                        }
                    }
                }
                    
                } else {
                    $success = false;
                }

                if ($success == true && $this->pelaksanasimpan && $this->pasienpenunjangtersimpan && $this->pasienanestesitersimpan) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pasienanastesi_id' => $modPasienAnastesi->pasienanastesi_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'format' => $format,
        ));
    }

    /**
     * @author rusdiyanto <rusdiyanto@rusdiyanto@.com>
     * fungsi untuk dropdown kamarruangan
     * @param type $encode
     * @param type $namaModel
     * @param type $attr 
     */
    public function actionSetDropdownKamarKosong($encode = false, $namaModel = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
                $ruangan_id = $_POST[$namaModel]['ruangan_id'];

            $kamarKosong = array();

            if (!empty($ruangan_id)) {
                $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true, 'kamarruangan_aktif'=>true));
                $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
            }

            if ($encode) {
                echo CJSON::encode($kamarKosong);
            } else {
                if (empty($kamarKosong)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
                    foreach ($kamarKosong as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * fungsi untuk load kru anestesi
     * @author rusdiyanto <rusdiyanto@.com>
     */
    public function actionAddLookupKruAnestesi() {
        if (Yii::app()->request->isAjaxRequest) {
            $kruAnestesi = isset($_POST['kruanestesi']) ? $_POST['kruanestesi'] : null;
            $sukses = 0;
            $pesan = '';

            $cri = new CDbCriteria();
            $cri->addCondition(" lookup_type = '" . Params::LOOKUPTYPE_KRU_ANESTESI . "' ");
            $cri->addCondition(" lookup_value ilike '" . strtolower($kruAnestesi) . "' ");
            $look = LookupM::model()->findAll($cri);

            if (!empty($look)) {
                $pesan = "Data Kru Anestesi sudah ada !";
            } else {
                $look = new LookupM;
                $look->lookup_type = Params::LOOKUPTYPE_KRU_ANESTESI;
                $look->lookup_name = $kruAnestesi;
                $look->lookup_value = strtoupper($kruAnestesi);
                $look->lookup_aktif = true;
                $look->lookup_urutan = $look->getNoUrutan(Params::LOOKUPTYPE_KRU_ANESTESI);
                $look->create_time = date('Y-m-d H:i:s');
                $look->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $look->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if ($look->save()) {
                    $sukses = 1;
                    $pesan = "Data Kru Anestesi baru berhasil disimpan !";
                } else {
                    $pesan = "Data gagal disimpan !";
                }
            }

            $drop = LookupM::model()->getDropUrutan(Params::LOOKUPTYPE_KRU_ANESTESI);

            echo CJSON::encode(array(
                'sukses' => $sukses,
                'pesan' => $pesan,
                'drop' => $drop,
                'look' => $kruAnestesi
            ));
            Yii::app()->end();
        }
    }

    /**
     * fungsi untuk add kru anestesi
     * @author rusdiyanto <rusdiyanto@.com>
     */
    public function actionAddKruAnestesi() {

        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $lookup = isset($_POST['lookup']) ? $_POST['lookup'] : null;
            $length = isset($_POST['length']) ? $_POST['length'] : null;
            $sukses = 0;
            
            if($lookup == 'PPDS Anastesiologi'){
                $peg = PpdsM::model()->findByPk($id);
                
                if (!empty($peg)) {
                    $sukses = 1;
                }
                $model = new ATPelaksanaanestesiT();
                $model->ppds_id = $peg->ppds_id;
                $model->pegawai_nama = $peg->ppds_nama;
                $model->kruanestesi = $lookup;
            }else{
                $peg = PegawaiM::model()->findByPk($id);
                
                if (!empty($peg)) {
                    $sukses = 1;
                }
                $model = new ATPelaksanaanestesiT();
                $model->pegawai_id = $peg->pegawai_id;
                $model->pegawai_nama = $peg->namaLengkap;
                $model->kruanestesi = $lookup;
            }

            echo CJSON::encode(array(
                'sukses' => $sukses,
                'look' => ucwords(strtolower($lookup)),
                'lookup' => str_replace(' ', '-', strtolower($lookup)),
                'id' => $id,
                'div' => $this->renderPartial($this->path_view . '_rowKruAnestesi', array('length' => $length, 'model' => $model, 'i' => 0), true)));
            Yii::app()->end();
        }
    }

    /**
     * Fungsi Auto Complete Pencarian Kru Anestesi berdasarkan ruangan anestesi 
     */
    public function actionPegawaiRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition('ruangan_id =' . Params::RUANGAN_ID_ANASTESI);
            $criteria->order = 'nama_pegawai ASC';
            $models = PegawairuanganV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaLengkap; //$model->nomorindukpegawai
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['namaLengkap'] = $model->gelardepan . ' ' . $model->nama_pegawai . ' ' . $model->gelarbelakang_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Fungsi Auto Complete Pencarian Kru Anestesi dari ppds_m
     */
    public function actionPpds() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('ppds_aktif IS TRUE');
            $criteria->addCondition("verifikasi_status = 'Disetujui'");
            $criteria->order = 'ppds_nama ASC';
            $models = PpdsM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nama; //$model->nomorindukpegawai
                $returnVal[$i]['value'] = $model->ppds_id;
                $returnVal[$i]['namaLengkap'] = $model->ppds_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Pencarian autocomple diagnosa
     * @param type $term
     */
    public function actionGetDiagnosaM($term = "") {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria;
            $returnVal = array();
            $criteria->addCondition(
                    ""
                    . "(lower(diagnosa_kode) ilike '%" . $term . "%' or "
                    . "lower(diagnosa_nama) ilike '%" . $term . "%' or "
                    . " lower(diagnosa_namalainnya) ilike '%" . $term . "%'"
                    . ")"
            );
            $criteria->order = 'diagnosa_kode, diagnosa_nama';
            $criteria->addCondition("diagnosa_aktif = true");
            $models = DiagnosaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->diagnosa_kode . ' - ' . $model->diagnosa_nama;
                $returnVal[$i]['value'] = $model->diagnosa_nama;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * proses simpan / ubah data pasien anastesi
     * @param type $post
     * @param type $daftar
     * @param type $renTin
     * @param type $modPasienMasukPenunjang
     * @return \ATPasienanastesiT
     */
    public function simpanPasienAnestesi($post, $daftar, $renTin, $modPasienMasukPenunjang) {
        $format = new MyFormatter();
        if ((!empty($post))) {
            $model = ATPasienanastesiT::model()->findByPk($post);
        } else {
            $model = new ATPasienanastesiT;
        }
        $model->tglanastesi = !empty($model->tglanestesi) ? $model->tglanestesi : date('Y-m-d H:i:s');
        $model->jenisanastesi_id = $renTin['jenisanastesi_id'];

        if (empty($post)) {
            $model->pasien_id = $daftar->pasien_id;
            $model->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
            $model->pendaftaran_id = $daftar->pendaftaran_id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->dokteranastesi_id = $modPasienMasukPenunjang->pegawai_id;
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_time = date('Y-m-d H:i:s');
            $model->noanestesi = MyGenerator::noAnestesi();
            $model->statusanestesi = 'Evaluasi Pra Anastesi';
            $model->ruangan_id = $modPasienMasukPenunjang->ruangan_id;
            $model->pasienkirimkeunitlain_id = $modPasienMasukPenunjang->pasienkirimkeunitlain_id;
        } else {
            $model->statusanestesi = 'Evaluasi Pra Anastesi';
            $model->update_loginpemakai_id = Yii::app()->user->id;
            $model->update_time = date('Y-m-d H:i:s');
            if (empty($model->noanestesi)) {
                $model->noanestesi = MyGenerator::noAnestesi();
            }
        }

        if ($model->save()) {
            $this->pasienanestesitersimpan = true;
        } else {
            $this->pasienanestesitersimpan = false;
        }

        return $model;
    }

    /**
     * Simpan data pasien masuk penunjang dari Pasien Rujukan
     * @param type $attrPendaftaran
     * @param type $pasienKirim
     * @return type
     */
    public function simpanPasienPenunjang($attrPendaftaran, $pasienKirim) {
        $modPasienPenunjang = new ATPasienmasukpenunjangT;
        if (isset($_GET['pasienmasukpenunjang_id'])) {
            $modPasienPenunjang = ATPasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
        }
        $modPasienPenunjang->attributes = $pasienKirim;
        $modPasienPenunjang->attributes = $attrPendaftaran->attributes;
        $modPasienPenunjang->pasienkirimkeunitlain_id = $pasienKirim->pasienkirimkeunitlain_id;
        $modPasienPenunjang->pasien_id = $attrPendaftaran->pasien_id;
        $modPasienPenunjang->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_ANESTESI;
        $modPasienPenunjang->pendaftaran_id = $attrPendaftaran->pendaftaran_id;
        $modPasienPenunjang->pegawai_id = $pasienKirim->pegawai_id;
        $modPasienPenunjang->kelaspelayanan_id = $pasienKirim->kelaspelayanan_id;
        $modPasienPenunjang->ruangan_id = $pasienKirim->ruangan_id;
        $instalasi_id = $modPasienPenunjang->ruangan->instalasi_id;
        $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
        /* $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi); */
        $modPasienPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
        $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($modPasienPenunjang->ruangan_id, $modPasienPenunjang->tglmasukpenunjang);
        $modPasienPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
        $modPasienPenunjang->kunjungan = $attrPendaftaran->kunjungan;
        $modPasienPenunjang->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
        $modPasienPenunjang->ruanganasal_id = $attrPendaftaran->ruangan_id;
        $modPasienPenunjang->create_time = date('Y-m-d H:i:s');
        $modPasienPenunjang->create_loginpemakai_id = Yii::app()->user->id;
        $modPasienPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($modPasienPenunjang->validate()) {
            if ($modPasienPenunjang->save()) {

                $pasienKirim->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
                $pasienKirim->save();

                $this->pasienpenunjangtersimpan = true;
            }
        } else {
            $this->pasienpenunjangtersimpan = false;
        }
        return $modPasienPenunjang;
    }

}
