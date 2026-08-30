<?php

class KantongDarahHdTController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $path_view = 'hemodialisa.views.kantongDarahHdT.';
    public $ok = true;

    public function actionIndex($pendaftaran_id, $kantongdarahid = null, $salin_id = null, $konsulpoli_id=null) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new KantongTransfusiDarahT();
        $model->pegawai_id = $modPendaftaran->pegawai_id;
        $model->nama_pegawai = $modPendaftaran->pegawai->nama_pegawai;
        $modDetail = new KantongTransfusiDarahDetT();
        $modObat = new ObatSebelumTransfusiT();
        $modKantongDarah = PenyerahandarahV::model()->findAll("pendaftaran_id = " . $pendaftaran_id);
        $loadObat = array();

        if (!empty($kantongdarahid)) {
            $model = KantongTransfusiDarahT::model()->findByPk($kantongdarahid);
            $loadObat = ObatSebelumTransfusiT::model()->findAll("observasi_transfusi_darah_id = " . $kantongdarahid);
            $crite = new CDbCriteria();
            $crite->select = "t.petugas_transfusi_id, d.nama_pegawai as petugas_transfusi_nama, t.petugas_verifikasi_id, e.nama_pegawai as petugas_verifikasi_nama, t.no_kantongdarah, t.jeniskomponendarah_id, c.jeniskomponenedarah_nama as namakomponendrh, t.volume_darah as volume";
            $crite->join = "JOIN kantong_transfusi_darah_t b ON b.kantong_transfusi_darah_id = t.kantong_transfusi_darah_id " . "JOIN jeniskomponendarah_m c ON t.jeniskomponendarah_id = c.jeniskomponendarah_id " .
                    "JOIN pegawai_m d ON t.petugas_transfusi_id = d.pegawai_id " .
                    "JOIN pegawai_m e ON t.petugas_verifikasi_id = e.pegawai_id ";
            $crite->addCondition("b.kantong_transfusi_darah_id = " . $kantongdarahid);
            $modKantongDarah = KantongTransfusiDarahDetT::model()->findAll($crite);
            $model->nama_pegawai = $model->pegawai->nama_pegawai;
        }


        if (isset($_POST['KantongTransfusiDarahT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!empty($kantongdarahid)) {
                    if (!empty($salin_id)) {
                        $model = new KantongTransfusiDarahT();
                        $this->saveKantongTransfusiDarah($model, $_POST['KantongTransfusiDarahT'], $modPendaftaran);
                    } else {
                        $model = KantongTransfusiDarahT::model()->findByPk($kantongdarahid);
                        $this->saveKantongTransfusiDarah($model, $_POST['KantongTransfusiDarahT'], $modPendaftaran);
                    }
                } else {
                    $this->saveKantongTransfusiDarah($model, $_POST['KantongTransfusiDarahT'], $modPendaftaran);
                }
                if ($this->ok == true) {
                    if (!empty($kantongdarahid)) {
                        if (!empty($salin_id)) {
                            
                        } else {
                            $ok = true;
                            $cekObat = ObatSebelumTransfusiT::model()->find("observasi_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
                            if (!empty($cekObat)) {
                                $ok = $ok && ObatSebelumTransfusiT::model()->deleteAll("observasi_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
                            }

                            $cekKantong = KantongTransfusiDarahDetT::model()->find("kantong_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
                            if (!empty($cekKantong)) {
                                $ok = $ok && KantongTransfusiDarahDetT::model()->deleteAll("kantong_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
                            }
                        }
                    }

                    if (isset($_POST['ObatSebelumTransfusiT'])) {
                        $this->saveObatSebelum($model, $_POST['ObatSebelumTransfusiT'], $modPendaftaran);
                    }

                    if (isset($_POST['KantongTransfusiDarahDetT'])) {
                        $this->saveKantongTransfusiDarahDet($model, $_POST['KantongTransfusiDarahDetT'], $modPendaftaran);
                    }
                    
                     // Update status periksa 
//                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//                    if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISAGRAHA || $modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISA) {
//                        $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
//                        if (!empty($modKonsul)) {
//                            $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                            $modKonsul->update_time = date("Y-m-d H:i:s");
//                            $modKonsul->update_loginpemakai_id = Yii::app()->user->id;
//                            $this->ok = $this->ok && $modKonsul->save();
//                        } else {
//                            $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                            $modPendaftaran->update_time = date("Y-m-d H:i:s");
//                            $modPendaftaran->update_loginpemakai_id = Yii::app()->user->id;
//                            $this->ok = $this->ok && $modPendaftaran->save();
//                        }
//                    }
                    $this->ubah_status($pendaftaran_id, $konsulpoli_id);

                    if ($this->ok == true) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1, 'konsulpoli_id'=>$konsulpoli_id));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . CHtml::errorSummary($model));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $loadRiwayat = KantongTransfusiDarahT::model()->findAll("pendaftaran_id = " . $pendaftaran_id);

        $this->render('index', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modPendaftaran' => $modPendaftaran,
            'modObat' => $modObat,
            'modPasien' => $modPasien,
            'modKantongDarah' => $modKantongDarah,
            'loadRiwayat' => $loadRiwayat,
            'loadObat' => $loadObat,
        ));
    }

    public function ubah_status($pendaftaran_id, $konsulpoli_id){
        $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pen->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
        $pen->update_time = date('Y-m-d H:i:s');
        $pen->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $pen->save();
        
        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
        
        if (!empty($konsul)){            
            if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())){
                $konsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                $konsul->update_time = date('Y-m-d H:i:s');
                $konsul->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $konsul->save();
            }
        }                
    }
    
    public function saveKantongTransfusiDarah($model, $post, $modPendaftaran) {
        $model->attributes = $post;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->waktu_darah_diterima = MyFormatter::formatDateTimeForDb($post['waktu_darah_diterima']);
        $model->create_time = date('Y-m-d');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
            $this->ok = true;
        } else {
            $this->ok = false;
        }
    }

    public function saveObatSebelum($model, $post, $modPendaftaran) {
        foreach ($post as $data) {
            $modObat = new ObatSebelumTransfusiT();
            $modObat->attributes = $data;
            $modObat->observasi_transfusi_darah_id = $model->kantong_transfusi_darah_id;
            $modObat->pasien_id = $modPendaftaran->pasien_id;
            $modObat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//            $modObat->nama_obat = $data['nama_obat'];

            if ($modObat->save()) {
                $this->ok = true;
            } else {
                $this->ok = false;
            }
        }
    }

    public function updateObatSebelum($model, $post, $modPendaftaran) {
        $ok = true;
        $cekObat = ObatSebelumTransfusiT::model()->find("observasi_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
        if (!empty($cekObat)) {
            $ok = $ok && ObatSebelumTransfusiT::model()->deleteAll("observasi_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
        }
        foreach ($post as $data) {
            $modObat = new ObatSebelumTransfusiT();
            $modObat->attributes = $data;
            $modObat->observasi_transfusi_darah_id = $model->kantong_transfusi_darah_id;
            $modObat->pasien_id = $modPendaftaran->pasien_id;
            $modObat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//            $modObat->nama_obat = $data['nama_obat'];

            if ($modObat->save()) {
                $this->ok = true;
            } else {
                $this->ok = false;
            }
        }
    }

    public function saveKantongTransfusiDarahDet($model, $post, $modPendaftaran) {
        foreach ($post as $data) {
            $modKantongDetail = new KantongTransfusiDarahDetT();
            $modKantongDetail->attributes = $data;
            $modKantongDetail->kantong_transfusi_darah_id = $model->kantong_transfusi_darah_id;
            $modKantongDetail->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modKantongDetail->pasien_id = $modPendaftaran->pasien_id;
            $modKantongDetail->create_time = date('Y-m-d');
            $modKantongDetail->create_loginpemakai_id = Yii::app()->user->id;
            $modKantongDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');

            if ($modKantongDetail->save()) {
                $this->ok = true;
            } else {
                $this->ok = false;
            }
        }
    }

    public function actionAddObat() {
        if (Yii::app()->request->isAjaxRequest) {
            $nama_obat = $_POST['nama_obat'];
            $key = $_POST['key'];
            $form = "";

            $modObat = new ObatSebelumTransfusiT();
            $modObat->nama_obat = $nama_obat;

            $form .= $this->renderPartial('_addObat', array('modObat' => $modObat, 'key' => $key), true);

            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }

    public function actionAddRow() {
        if (Yii::app()->request->isAjaxRequest) {
            $key = $_POST['key'];
            $form = "";

            $modDetail = new KantongTransfusiDarahDetT();

            $form .= $this->renderPartial('_addRow', array('modDetail' => $modDetail, 'key' => $key), true);

            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }

    public function actionHapusRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $hapusObat = ObatSebelumTransfusiT::model()->find("observasi_transfusi_darah_id = " . $id);
                if (!empty($hapusObat)) {
                    $ok = $ok && ObatSebelumTransfusiT::model()->deleteAll("observasi_transfusi_darah_id = " . $id);
                }

                $hapusKantongDetail = KantongTransfusiDarahDetT::model()->find("kantong_transfusi_darah_id = " . $id);
                if (!empty($hapusKantongDetail)) {
                    $ok = $ok && KantongTransfusiDarahDetT::model()->deleteAll("kantong_transfusi_darah_id = " . $id);
                }

                $ok = $ok && KantongTransfusiDarahT::model()->deleteByPk($id);

                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data Berhasil Dihapus!";
                    $trans->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data Gagal Dihapus";
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = "Data Gagal Dihapus";
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionPrintRiwayat() {
        $this->layout = '//layouts/printWindows';
        $id = $_GET['id'];
        $kantongdarahid = $_GET['kantongdarahid'];
        $format = new MyFormatter;
        $modPendaftaran = HDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $cri = new CDbCriteria();
        if ($kantongdarahid != "") {
            $cri->addCondition("kantong_transfusi_darah_id = " . $kantongdarahid);
        }
        $cri->addCondition("pendaftaran_id = " . $id);
        $model = KantongTransfusiDarahT::model()->find($cri);
//        print_r($model);die;
        if ($kantongdarahid != "") {
            $modDetail = KantongTransfusiDarahDetT::model()->findAll("kantong_transfusi_darah_id = " . $kantongdarahid);
        } elseif ($id != "") {
//            $crit = new CDbCriteria();
//            $crit->select = "t.*";
//            $crit->join = "JOIN monitoring_intra_hd_t b ON t.monitoring_intra_hd_id = b.monitoring_intra_hd_id";
//            $crit->addCondition("pendaftaran_id = ".$id);
            $modDetail = KantongTransfusiDarahDetT::model()->findAll("pendaftaran_id = " . $id);
        } else {
            $modDetail = [];
        }
//        $modDetail = HDMonitoringIntraHdDetT::model()->findAll("monitoring_intra_hd_id = ".$monitoringintraid);

        $judul_print = 'Laporan Data Kantong Darah';
        $this->render($this->path_view . 'print', array('format' => $format,
            'judul_print' => $judul_print,
            'modPendaftaran' => $modPendaftaran,
            'model' => $model,
            'modPasien' => $modPasien,
            'modDetail' => $modDetail
        ));
    }

    public function actionDetail($id) {
        $this->layout = '//layouts/iframe';
        $model = KantongTransfusiDarahT::model()->findByPk($id);
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $crite = new CDbCriteria();
        $crite->select = "t.petugas_transfusi_id, d.nama_pegawai as petugas_transfusi_nama, t.petugas_verifikasi_id, e.nama_pegawai as petugas_verifikasi_nama, t.no_kantongdarah, t.jeniskomponendarah_id, c.jeniskomponenedarah_nama as namakomponendrh, t.volume_darah as volume";
        $crite->join = "JOIN kantong_transfusi_darah_t b ON b.kantong_transfusi_darah_id = t.kantong_transfusi_darah_id " . "JOIN jeniskomponendarah_m c ON t.jeniskomponendarah_id = c.jeniskomponendarah_id " .
                "JOIN pegawai_m d ON t.petugas_transfusi_id = d.pegawai_id " .
                "JOIN pegawai_m e ON t.petugas_verifikasi_id = e.pegawai_id ";
        $crite->addCondition("b.kantong_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
        $modKantongDarah = KantongTransfusiDarahDetT::model()->findAll($crite);
        $modDetail = new KantongTransfusiDarahDetT();
        $loadObat = ObatSebelumTransfusiT::model()->findAll("observasi_transfusi_darah_id = " . $model->kantong_transfusi_darah_id);
        $model->pegawai_id = $modPendaftaran->pegawai_id;
        $model->nama_pegawai = $modPendaftaran->pegawai->nama_pegawai;

        $this->render($this->path_view . 'detail', [
            'model' => $model,
            'modKantongDarah' => $modKantongDarah,
            'modDetail' => $modDetail,
            'loadObat' => $loadObat,
        ]);
    }

}
