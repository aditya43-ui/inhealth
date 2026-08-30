<?php

/**
 * Pemeriksaan staining Lab Mikrobiologi
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class PemeriksaanStainingController extends MyAuthController {

    /**
     * Default menu transaksi
     * @param integer $spesimen_id
     * @param integer $staining_id
     */
    public function actionIndex($spesimen_id, $staining_id = null, $staining_gambar_id = null) {
        $model = new MKStainingT;
        $models = new MKStainingT;
        $modGambar = new MKStainingGambarT;
        $modDetail = new MKStainingdetT;
        $arrGambar = array();
        $modStainingGambar = new MKStainingGambarT();
        $modSpesiman = MKSpesimenT::model()->findByPk($spesimen_id);
        $dataStaining = MKStainingT::model()->findAllByAttributes(array('spesimen_id' => $spesimen_id), array('order' => 'tanggal_staining'));
        $temp = '';
        if (!empty($staining_id)) {
            $model = MKStainingT::model()->findByPk($staining_id);
            $model->analis_nama = !empty($model->analis_id) ? $model->analis->nama_pegawai : '';
            $model->analis_nip = !empty($model->analis_id) ? $model->analis->nomorindukpegawai : '';

            $loadGambar = MKStainingGambarT::model()->findAllByAttributes(array('staining_id' => $staining_id));
            if (count($loadGambar) > 0) {
                foreach ($loadGambar as $key => $value) {
                    $arrGambar[$key] = $value;
                }
            }
        }

        if (isset($_GET['verifikasippds'])) {
            $sukses = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modStainingGambar = StainingGambarT::model()->findByPk($staining_gambar_id);
                if ($modStainingGambar->ppds_id == Yii::app()->user->getState('ppds_id') && empty($modStainingGambar->tgl_verifikasi_ppds)) {
                    $modStainingGambar->tgl_verifikasi_ppds = date('Y-m-d H:i:s');
                }

                if ($modStainingGambar->save()) {
                    $modGambar = count(StainingGambarT::model()->findAllByAttributes(array('staining_id' => $staining_id)));
                    $cri = new CDbCriteria();
                    $cri->addCondition('t.tgl_verifikasi_ppds is not null and staining_id = '.$staining_id);
                    $modPPDS = count(StainingGambarT::model()->findAll($cri));
                    if ($modGambar == $modPPDS) {
                        StainingT::model()->updateByPk($staining_id, array('status_verifikasi' => 'Terverifikasi PPDS'));
                    } else {
                        StainingT::model()->updateByPk($staining_id, array('status_verifikasi' => 'Belum Terverifikasi'));
                    }
                    $sukses &= true;
                } else {
                    $sukses &= false;
                }

                if ($sukses) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Verifikasi berhasil disimpan.');
                    $this->redirect(array('index', 'spesimen_id' => $spesimen_id, 'staining_id' => $model->staining_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Verifikasi gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        if (isset($_GET['verifikasi'])) { //verifikasi staining
            $sukses = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modStainingGambar = StainingGambarT::model()->findByPk($staining_gambar_id);
                if ($modStainingGambar->dpjtm_id == Yii::app()->user->getState('pegawai_id') && empty($modStainingGambar->tgl_verifikasi_dpjtm)) {
                    $modStainingGambar->tgl_verifikasi_dpjtm = date('Y-m-d H:i:s');
                }

                if ($modStainingGambar->save()) {
                    $sukses &= true;
                    $modGambar = count(StainingGambarT::model()->findAllByAttributes(array('staining_id' => $staining_id)));
                    $cri = new CDbCriteria();
                    $cri->addCondition('t.tgl_verifikasi_dpjtm is not null and staining_id = '.$staining_id);
                    $modDpjtm = count(StainingGambarT::model()->findAll($cri));
                    if ($modGambar == $modDpjtm) {
                        StainingT::model()->updateByPk($staining_id, array('status_verifikasi' => 'Terverifikasi DPJTM'));
                    } else {
                        StainingT::model()->updateByPk($staining_id, array('status_verifikasi' => 'Terverifikasi PPDS'));
                    }
                } else {
                    $sukses &= false;
                }

                if ($sukses) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Verifikasi berhasil disimpan.');
                    $this->redirect(array('index', 'spesimen_id' => $spesimen_id, 'staining_id' => $model->staining_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Verifikasi gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        
        if (isset($_POST['MKStainingT'])) {
            $ok = true;
            $valid = true;
            $valid2 = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (empty($staining_id)) {
                    $model = new MKStainingT;
                    $model->attributes = $_POST['MKStainingT'];
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->status_verifikasi = "Belum Terverifikasi"; 
                } else {
                    $model = MKStainingT::model()->findByPk($staining_id);
                    $model->attributes = $_POST['MKStainingT'];
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }

                $model->spesimen_id = $spesimen_id;
                $model->tanggal_staining = MyFormatter::formatDateTimeForDb($_POST['MKStainingT']['tanggal_staining']);
//                $model->analis_id = $_POST['MKStainingT']['analis_id'];
                $ok = $model->save();
                
                if ($ok) {
                    if (isset($_POST['MKStainingGambarT']['detail'])) {
                        foreach ($_POST['MKStainingGambarT']['detail'] as $i => $gambar) {
                            if (!empty($gambar['staining_gambar_id']) && $gambar['status_gambar'] == 1) {
                                $hapus_detail = MKStainingdetT::model()->deleteAllByAttributes(array('staining_gambar_id' => $gambar['staining_gambar_id']));
                                $valid = $hapus_detail && MKStainingGambarT::model()->deleteByPk($gambar['staining_gambar_id']);
                            } else {
                                if (!empty($gambar['staining_gambar_id'])) {
                                    $modStainingGambar = MKStainingGambarT::model()->findByPk($gambar['staining_gambar_id']);
                                    $modStainingGambar->attributes = $gambar;
                                    $modStainingGambar->staining_id = $model->staining_id;
                                    $modStainingGambar->ppds_id = !empty($gambar['ppds_id']) ? $gambar['ppds_id'] : null;
                                    $modStainingGambar->dpjtm_id = !empty($gambar['dpjtm_id']) ? $gambar['dpjtm_id'] : null;
                                    $temp = $gambar['temp_file'];

                                    $modStainingGambar->gambar = CUploadedFile::getInstance($modStainingGambar, '[detail][' . $i . ']gambar');
                                    if (!empty($modStainingGambar->gambar)) {
                                        $dokumen_pendukung = $modStainingGambar->gambar;
                                        $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                        $fullImgSource = Params::pathPemeriskaanGambarStaining() . $fullImgName;
                                        $modStainingGambar->gambar = $fullImgName;
                                    } else {
                                        $modStainingGambar->gambar = $temp;
                                    }
                                } else {
                                    $modStainingGambar = new MKStainingGambarT();
                                    $modStainingGambar->attributes = $gambar;
                                    $modStainingGambar->staining_id = $model->staining_id;
                                    $modStainingGambar->ppds_id = !empty($gambar['ppds_id']) ? $gambar['ppds_id'] : null;
                                    $modStainingGambar->dpjtm_id = !empty($gambar['dpjtm_id']) ? $gambar['dpjtm_id'] : null;
                                    $modStainingGambar->gambar = CUploadedFile::getInstance($modStainingGambar, '[detail][' . $i . ']gambar');
                                    if (!empty(CUploadedFile::getInstance($modStainingGambar, '[detail][' . $i . ']gambar'))) {
                                        $dokumen_pendukung = $modStainingGambar->gambar;

                                        $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
                                        $fullImgSource = Params::pathPemeriskaanGambarStaining() . $fullImgName;

                                        $modStainingGambar->gambar = $fullImgName;
                                    }
                                }
                                $valid = $valid && $modStainingGambar->save();
                            }

                            if ($valid) {
                                if (!empty($dokumen_pendukung)) {
                                    if (!empty($temp)) {
                                        if ($modStainingGambar->gambar != $temp) {
                                            if (!empty($modStainingGambar->gambar)) {
                                                if (file_exists(Params::pathPemeriskaanGambarStaining() . $temp)) {
                                                    unlink(Params::pathPemeriskaanGambarStaining() . $temp);
                                                }
                                            }
                                        }
                                    }

                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                                
                                if (empty($gambar['status_gambar'])) {
                                    foreach ($_POST['MKStainingdetT']['detail'][$i] as $j) {
                                        if (empty($j['status'])) {
                                            if (!empty($j['stainingdet_id'])) {
                                                $modStainingDetail = MKStainingdetT::model()->findByPk($j['stainingdet_id']);
                                                $modStainingDetail->attributes = $j;
                                                $modStainingDetail->staining_gambar_id = $modStainingGambar->staining_gambar_id;
                                            } else {
                                                $modStainingDetail = new MKStainingdetT();
                                                $modStainingDetail->attributes = $j;
                                                $modStainingDetail->staining_gambar_id = $modStainingGambar->staining_gambar_id;
                                            }
                                            $valid2 = $ok && $modStainingDetail->save();
                                        } else {
                                            $valid2 = MKStainingdetT::model()->deleteByPk($j['stainingdet_id']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ok && $valid && $valid2) {
                    $transaction->commit();
                    SpesimenT::model()->updateByPk($spesimen_id, array('status_pemeriksaan' => 'STAINING'));
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'spesimen_id' => $spesimen_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('index', array(
            'model' => $model,
            'models' => $models,
            'modGambar' => $modGambar,
            'modDetail' => $modDetail,
            'modSpesiman' => $modSpesiman,
            'arrGambar' => $arrGambar,
            'dataStaining' => $dataStaining,
            'modStainingGambar' => $modStainingGambar
        ));
    }

    /**
     * Autocomplete pegawai ruangan
     */
    public function actionAutoCompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            if (isset($_GET['kelompokpegawai_id'])) {
                if (!empty($_GET['kelompokpegawai_id'])) {
                    $criteria->addCondition('kelompokpegawai_id = ' . $_GET['kelompokpegawai_id']);
                }
            }
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pegawai ruangan
     */
    public function actionAutoCompleteAnalis() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            $criteria->addCondition('kelompokpegawai_id != '.Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP);
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Hapus staining 
     */
    public function actionBatalStaining() {
        if (Yii::app()->request->isAjaxRequest) {

            $staining_id = $_POST['staining_id'];

            $model = MKStainingT::model()->findByPk($staining_id);
            $modGambar = MKStainingGambarT::model()->findAllByAttributes(array('staining_id' => $staining_id));
            $spesimen_id = $model->spesimen_id;

            if (!empty($model->tgl_verifikasi)) {

                $returnVal['status'] = 'not';
                $returnVal['keterangan'] = 'Data staining gagal dihapus, karena sudah diverifkasi';
            } else {

                try {
                    $sukses = true;
                    $transaction = Yii::app()->db->beginTransaction();
                    foreach ($modGambar as $key => $value) {
                        MKStainingdetT::model()->deleteAllByAttributes(array('staining_gambar_id' => $value->staining_gambar_id));
                        if ($value->delete()) {
                            if (!empty($value->gambar) && file_exists(Params::pathPemeriskaanGambarStaining() . $value->gambar)) {
                                unlink(Params::pathPemeriskaanGambarStaining() . $value->gambar);
                            }
                        } else {
                            $sukses &= false;
                        }
                    }

                    if ($sukses) {
                        if ($model->delete()) {
                            $sukses &= true;
                        } else {
                            $sukses &= false;
                        }
                    }

                    if ($sukses) {
                        $transaction->commit();
                        $returnVal['status'] = 'ok';
                        $returnVal['keterangan'] = '';
                    } else {
                        $transaction->rollback();
                        $returnVal['status'] = 'not';
                        $returnVal['keterangan'] = 'Data staining gagal dihapus !';
                    }
                } catch (Exception $ex) {
                    $transaction->rollback();
                    $returnVal['status'] = 'not';
                    $returnVal['keterangan'] = 'Terjadi kesalah, data staining gagal dihapus !';
                }
            }

            echo CJSON::encode($returnVal);
        }
    }

    /**
     * Load data staining
     */
    public function actionLoadStaining() {
        if (Yii::app()->request->isAjaxRequest) {
            $spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $staining = isset($_POST['staining']) ? $_POST['staining'] : null;
            $modSpesimen = SpesimenT::model()->findByAttributes(array('spesimen_id' => $spesimen));
            $modDaftar = DaftartindakanM::model()->findByPk($modSpesimen->tindakanpelayanan->daftartindakan_id);
            $html = '';
            if ($jenis == 'load') {
                $modStaining = MKStainingT::model()->findByPk($staining);
                $modStainingGambars = MKStainingGambarT::model()->findAllByAttributes(array('staining_id' => $modStaining->staining_id), array('order' =>  'staining_gambar_id asc'));
                if (!empty($modStainingGambars)) {
                    foreach ($modStainingGambars as $modStainingGambar) {
                        $modStainingGambar->dpjtm_nama = !empty($modStainingGambar->dpjtm_id) ? $modStainingGambar->dpjtm->namaLengkap : '';
                        $modStainingGambar->dpjtm_nip = !empty($modStainingGambar->dpjtm_id) ? $modStainingGambar->dpjtm->nomorindukpegawai : '';
                        $modStainingGambar->ppds_nama = !empty($modStainingGambar->ppds_id) ? $modStainingGambar->ppds->ppds_nama : '';
                        $modStainingGambar->ppds_nim = !empty($modStainingGambar->ppds_id) ? $modStainingGambar->ppds->ppds_nim : '';
                        $modStainingGambar->analis_nama = !empty($modStainingGambar->analis_id) ? $modStainingGambar->analis->namaLengkap : '';
                        $modStainingGambar->analis_nip = !empty($modStainingGambar->analis_id) ? $modStainingGambar->analis->nomorindukpegawai : '';
                        $modStainingGambar->daftartindakan_id = $modDaftar->daftartindakan_id;
                        $modStainingGambar->pemeriksaanlab_nama = $modDaftar->daftartindakan_nama;
                        $modStainingGambar->tanggal_staining = !empty($modStainingGambar->tanggal_staining) ? $modStainingGambar->tanggal_staining : date('Y-m-d H:i:s');
                        $modStainingGambar->temp_file = $modStainingGambar->gambar;
                        if ($modStainingGambar->daftartindakan_id == 3822 || $modStainingGambar->daftartindakan_id == 8918 || $modStainingGambar->daftartindakan_id == 8919 || $modStainingGambar->daftartindakan_id == 8920) {
                            $html .= $this->renderPartial('_1_formLoadStainingSubmit', array('modStainingGambar' => $modStainingGambar, 'modStaining' => $modStaining, 'i' => 1), true);
                        }
                    }
                }
            } else {
                $modStaining = new MKStainingT;
                $modStainingGambar = new MKStainingGambarT();
                $modStainingGambar->daftartindakan_id = $modDaftar->daftartindakan_id;
                $modStainingGambar->pemeriksaanlab_nama = $modDaftar->daftartindakan_nama;
                if ($modStainingGambar->daftartindakan_id == 3822 || $modStainingGambar->daftartindakan_id == 8918 || $modStainingGambar->daftartindakan_id == 8919 || $modStainingGambar->daftartindakan_id == 8920) {

                    $html .= "<br>" . $this->renderPartial('_1_formLoadStaining', array('modStainingGambar' => $modStainingGambar, 'modStaining' => $modStaining, 'i' => 1), true);
                }
            }

            $data['sukses'] = 1;
            $data['html'] = $html;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    /**
     * Membuka halaman detail
     * @param type $staining_id
     */
    public function actionDetail($staining_id) {
        $this->layout = '//layouts/iframe';
        $modStaining = MKStainingT::model()->findByPk($staining_id);
        $this->render('detail', array('modStaining' => $modStaining));
    }

    /**
     * Auto complete PPDS 
     */
    public function actionGetPpds() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (isset($_GET['ppds_id'])) {
                if (!empty($_GET['ppds_id'])) {
                    $criteria->addCondition("t.ppds_id = " . $_GET['ppds_id']);
                }
            }
            $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'ppds_nama ASC';
            $criteria->addCondition("t.ppds_aktif IS TRUE");
            $criteria->addCondition("t.verifikasi_status = 'Disetujui'");
            $criteria->limit = 10;
            $models = PpdsM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nim . " - " . $model->ppds_nama;
                $returnVal[$i]['ppds_nama'] = $model->ppds_nama;
                $returnVal[$i]['ppds_nim'] = $model->ppds_nim;
                $returnVal[$i]['value'] = $model->ppds_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete DPJTM
     */
    public function actionGetDpjtm() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("t.pegawai_id = " . $_GET['pegawai_id']);
                }
            }
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai ASC';
            $criteria->addCondition("t.pegawai_aktif IS TRUE");
            $criteria->limit = 10;
            $models = PegawaiM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['nomorindukpegawai'] = $model->nomorindukpegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Analis
     */
    public function actionGetAnalis() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("t.pegawai_id = " . $_GET['pegawai_id']);
                }
            }
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai ASC';
            $criteria->addCondition("t.pegawai_aktif IS TRUE");
            $criteria->addCondition('kelompokpegawai_id != '.Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP);
            $criteria->limit = 10;
            $models = PegawaiM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['nomorindukpegawai'] = $model->nomorindukpegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
