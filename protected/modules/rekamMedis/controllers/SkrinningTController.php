<?php

class SkrinningTController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.skrinning.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id, $id = null) {
        $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

        if (isset($_GET['typeinstalasi']) && !empty($_GET['typeinstalasi'])) {
            if ($_GET['typeinstalasi'] == 'RD') {
                $modPendaftaran = RKInfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($_GET['typeinstalasi'] == 'RJ') {
                $modPendaftaran = RKInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($_GET['typeinstalasi'] == 'RI') {
                $modPendaftaran = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            }
        }

        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");
        
        $model = new SkriningpasienT();
        if (!empty($id)) {
            $model = SkriningpasienT::model()->findByPk($id);
            
            if (empty($model)) {
                $model = new SkriningpasienT();
            } else {
                $model->petugaspengisi_nama = $model->petugaspengisi->namaLengkap;
            }
        }
        
        $modSkriningDet = new SkriningpasiendetT();
        $modJenisSkrining = JenisskriningM::model()->findAllByAttributes(array('status_jenisskringin' => true), array('order' => 'urutan_skrining ASC'));
        $model->pasien_id = $modPasien->pasien_id;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;

        if (isset($_POST['SkriningpasienT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            // var_dump($model->errors, $model->attributes, $_POST); die;

            try {
                $model->attributes = $_POST['SkriningpasienT'];

                if (!empty($model->skriningpasien_id)) {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                } else {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan = Yii::app()->user->getState("ruangan_id");
                $model->petugas_id = $_POST['SkriningpasienT']['petugaspengisi_id'];
                
                $skriningdet = true;
                $perencanaanEvaluasi = true;
                $skriningid = null;
                
                // var_dump($model->attributes); die;

                if ($model->save()) {
                    $skriningid = $model->skriningpasien_id;
                    $this->tersimpan = true;

                    if (count($_POST['SkriningpasiendetT']) > 0) {
                        SkriningpasiendetT::model()->deleteAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));

                        foreach ($_POST['SkriningpasiendetT'] as $dataEduDet) {
                            if (!empty($dataEduDet['isSkrinning'])) {
                                $modelDet = new SkriningpasiendetT();
                                $modelDet->skriningpasien_id = $model->skriningpasien_id;
                                $modelDet->attributes = $dataEduDet;
                                $modelDet->create_time = date('Y-m-d H:i:s');
                                $modelDet->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                $modelDet->create_ruangan = Yii::app()->user->getState("ruangan_id");
                                if (!$modelDet->save()) {
                                    $skriningdet = false;
                                }
                            }
                        }
                    }

                    if (isset($_POST['PerencanaanevaluasiT']) && count($_POST['PerencanaanevaluasiT']) > 0) {
                        PerencanaanevaluasiT::model()->deleteAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));

                        foreach ($_POST['PerencanaanevaluasiT'] as $dataEduDet) {
                            if (!empty($dataEduDet['ischeckboxSkrining']) && $dataEduDet['ischeckboxSkrining'] != 0) {
                                $modelDet = new PerencanaanevaluasiT();
                                $modelDet->skriningpasien_id = $model->skriningpasien_id;
                                $modelDet->attributes = $dataEduDet;
                                $modelDet->create_time = date('Y-m-d H:i:s');
                                $modelDet->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                                $modelDet->create_ruangan = Yii::app()->user->getState("ruangan_id");
                                if (!$modelDet->save()) {
                                    $perencanaanEvaluasi = false;
                                }
                            }
                        }
                    }
                } else {
                    $this->tersimpan = false;
                }

                // var_dump($this->tersimpan == true, $skriningdet == true, $perencanaanEvaluasi == true); die;

                if ($this->tersimpan == true && $skriningdet == true && $perencanaanEvaluasi == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('index', 'pendaftaran_id' => $_GET['pendaftaran_id'], 'id' => $skriningid, 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'modSkriningDet' => $modSkriningDet,
            'modJenisSkrining' => $modJenisSkrining
        ));
    }
    
    public function actionView($pendaftaran_id, $skriningpasien_id, $typeinstalasi) {
        $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        if (isset($typeinstalasi) && !empty($typeinstalasi)) {
            if ($typeinstalasi == 'RD') {
                $modPendaftaran = RKInfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($typeinstalasi == 'RJ') {
                $modPendaftaran = RKInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($typeinstalasi == 'RI') {
                $modPendaftaran = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            }
        }

        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = SkriningpasienT::model()->findByPk($skriningpasien_id);
        $modSkriningDet = SkriningpasiendetT::model()->findAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));
        $modPerencanaanEvaluasi = PerencanaanevaluasiT::model()->findAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));

        $this->layout = '//layouts/iframe';
        $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modSkriningDet' => $modSkriningDet, 'modPerencanaanEvaluasi' => $modPerencanaanEvaluasi));

    }

    public function actionPrint($pendaftaran_id, $skriningpasien_id, $typeinstalasi) {
        $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        if (isset($typeinstalasi) && !empty($typeinstalasi)) {
            if ($typeinstalasi == 'RD') {
                $modPendaftaran = RKInfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($typeinstalasi == 'RJ') {
                $modPendaftaran = RKInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            } else if ($typeinstalasi == 'RI') {
                $modPendaftaran = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            }
        }

        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = SkriningpasienT::model()->findByPk($skriningpasien_id);
        $modSkriningDet = SkriningpasiendetT::model()->findAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));
        $modPerencanaanEvaluasi = PerencanaanevaluasiT::model()->findAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modSkriningDet' => $modSkriningDet, 'modPerencanaanEvaluasi' => $modPerencanaanEvaluasi, 'caraPrint' => $caraPrint));
        }
    }

    public function actionPrintRiwayat($skriningpasien_id, $caraPrint) {
        $model = SkriningpasienT::model()->findByPk($skriningpasien_id);
        $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pasien_id' => $model->pasien_id));

        $modPasien = RKPasienM::model()->findByPk($model->pasien_id);

        $modSkriningDet = SkriningpasiendetT::model()->findAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));
        $modPerencanaanEvaluasi = PerencanaanevaluasiT::model()->findAllByAttributes(array('skriningpasien_id' => $model->skriningpasien_id));

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modSkriningDet' => $modSkriningDet, 'modPerencanaanEvaluasi' => $modPerencanaanEvaluasi, 'caraPrint' => $caraPrint));
        }
    }

    public function actionRiwayat($pasien_id) {
        $this->layout = '//layouts/iframe';

        $modPasien = PasienM::model()->findByPk($pasien_id);
        $model = new SkriningpasienT();

        $this->render($this->path_view . '_riwayat',
            array('modPasien' => $modPasien,
                'model' => $model
        ));
    }
    
    public function actionDelete() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data skrinning pasien berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            SkriningpasiendetT::model()->deleteAllByAttributes(array('skriningpasien_id' => $id));
            PerencanaanevaluasiT::model()->deleteAllByAttributes(array('skriningpasien_id' => $id));
            SkriningpasienT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data skrinning pasien gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

}
