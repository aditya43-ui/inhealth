<?php

class EvaluasiAwalController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.evaluasiAwal.';
    public $tersimpan = false;

    public function actionIndex($pendaftaran_id = null, $pasien_id = null, $typeinstalasi = null, $evaluasi_id = null) {
        
        $modPendaftaran = null;
        
        if (!empty($pendaftaran_id)) {
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
        } else if (!empty($pasien_id)) {
            $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array(
                'pasien_id'=>$pasien_id,
            ), array(
                'order'=>'pendaftaran_id desc',
            ));
            if (isset($typeinstalasi) && !empty($typeinstalasi)) {
                if ($typeinstalasi == 'RD') {
                    $modPendaftaran = RKInfokunjunganrdV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                } else if ($typeinstalasi == 'RJ') {
                    $modPendaftaran = RKInfokunjunganrjV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                } else if ($typeinstalasi == 'RI') {
                    $modPendaftaran = InfokunjunganriV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                }
            }
        }

        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan_id = Yii::app()->user->getState("ruangan_id");
        
        if (!empty($evaluasi_id)) {
            $model = EvaluasiawalT::model()->findByPk($evaluasi_id);
            $model->petugaspengisi_nama = empty($model->petugaspengisi) ? null : $model->petugaspengisi->namaLengkap;
        } else {
            $model = new EvaluasiawalT();
            $model->pasien_id = $modPendaftaran->pasien_id;
            $model->ruangan_id = $modPendaftaran->ruangan_id;
            $model->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
            
        }
        

        $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $model->ruangan_id));
        $diagnosaUtama = "";
        $diagnosaTambahan = "";
        $diagnosa_id = null;

        if (count($pasienMorbid) > 0) {
            $indexKel2 = 0;
            $indexKel3 = 0;

            foreach ($pasienMorbid as $datamorbid) {
                $diagnosa_id = $datamorbid->diagnosa_id;
                if ($datamorbid->kelompokdiagnosa_id == 2) {
                    if ($indexKel2 > 0) {
                        $diagnosaUtama .= ", ";
                    }
                    $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }

                if ($datamorbid->kelompokdiagnosa_id == 3) {
                    if ($indexKel3 > 0) {
                        $diagnosaTambahan .= ", ";
                    }
                    $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $model->diagnosa_id = $diagnosa_id;
        $model->diagnosa_nama = "Diagnosa Utama: " . $diagnosaUtama . " \n\n Diagnosa Tambahan: " . $diagnosaTambahan;

        $model->tgl_evaluasi = date('d M Y');

        if (isset($_POST['EvaluasiawalT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['EvaluasiawalT'];
                $model->tgl_evaluasi = MyFormatter::formatDateTimeForDb($_POST['EvaluasiawalT']['tgl_evaluasi']);

                if (!empty($model->kelompok_resiko)) {
                    $model->kelompok_resiko = $_POST['EvaluasiawalT']['kelompok_resiko'];
                }
                if ($model->kelompok_resikolainnya == 'LAINNYA') {
                    $model->kelompok_resikolainnya = $_POST['EvaluasiawalT']['kelompok_resikolainnya'];
                }
                if (!empty($model->evaluasiawal_id)) {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                } else {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan = Yii::app()->user->getState("ruangan_id");
                
                // var_dump($model->attributes, $_POST); die;

                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('index', 'pasien_id'=>$pasien_id, 'pendaftaran_id' => $pendaftaran_id, 'typeinstalasi' => $typeinstalasi, 'evaluasi_id' => $model->evaluasiawal_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
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
            'model' => $model
        ));
    }

    public function actionPrint($evaluasi_id, $typeinstalasi, $pendaftaran_id = null, $pasien_id = null) {
        if (!empty($pendaftaran_id) && $pendaftaran_id != 0) {
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
        } else if (!empty($pasien_id)) {
            $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array(
                'pasien_id'=>$pasien_id,
            ), array(
                'order'=>'pendaftaran_id desc',
            ));
            if (isset($typeinstalasi) && !empty($typeinstalasi)) {
                if ($typeinstalasi == 'RD') {
                    $modPendaftaran = RKInfokunjunganrdV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                } else if ($typeinstalasi == 'RJ') {
                    $modPendaftaran = RKInfokunjunganrjV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                } else if ($typeinstalasi == 'RI') {
                    $modPendaftaran = InfokunjunganriV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                }
            }
        }

        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = EvaluasiawalT::model()->findByPk($evaluasi_id);

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'caraPrint' => $caraPrint));
        }
    }
    
    public function actionView($evaluasi_id, $typeinstalasi, $pendaftaran_id = null, $pasien_id = null) {
        if (!empty($pendaftaran_id) && $pendaftaran_id != 0) {
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
        } else if (!empty($pasien_id)) {
            $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array(
                'pasien_id'=>$pasien_id,
            ), array(
                'order'=>'pendaftaran_id desc',
            ));
            if (isset($typeinstalasi) && !empty($typeinstalasi)) {
                if ($typeinstalasi == 'RD') {
                    $modPendaftaran = RKInfokunjunganrdV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                } else if ($typeinstalasi == 'RJ') {
                    $modPendaftaran = RKInfokunjunganrjV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                } else if ($typeinstalasi == 'RI') {
                    $modPendaftaran = InfokunjunganriV::model()->findByAttributes(array('pasien_id' => $pasien_id));
                }
            }
        }

        $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = EvaluasiawalT::model()->findByPk($evaluasi_id);

        $this->layout = '//layouts/iframe';
        $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran));

    }

    public function actionPrintRiwayat($evaluasi_id) {
        $model = EvaluasiawalT::model()->findByPk($evaluasi_id);
        $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pasien_id' => $model->pasien_id));
        $modPasien = RKPasienM::model()->findByPk($model->pasien_id);


        $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $model->ruangan_id));
        $diagnosaUtama = "";
        $diagnosaTambahan = "";
        $diagnosa_id = null;

        if (count($pasienMorbid) > 0) {
            $indexKel2 = 0;
            $indexKel3 = 0;

            foreach ($pasienMorbid as $datamorbid) {
                $diagnosa_id = $datamorbid->diagnosa_id;
                if ($datamorbid->kelompokdiagnosa_id == 2) {
                    if ($indexKel2 > 0) {
                        $diagnosaUtama .= ", ";
                    }
                    $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel2++;
                }

                if ($datamorbid->kelompokdiagnosa_id == 3) {
                    if ($indexKel3 > 0) {
                        $diagnosaTambahan .= ", ";
                    }
                    $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                    $indexKel3++;
                }
            }
        }
        $model->diagnosa_id = $diagnosa_id;
        $model->diagnosa_nama = "Diagnosa Utama: " . $diagnosaUtama . " <br/><br/> Diagnosa Tambahan: " . $diagnosaTambahan;


        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'caraPrint' => $caraPrint));
        }
    }

    public function actionRiwayat($pasien_id, $typeinstalasi = null) {
        $this->layout = '//layouts/iframe';

        $modPasien = PasienM::model()->findByPk($pasien_id);
        $model = new EvaluasiawalT();

        $this->render($this->path_view . '_riwayat',
            array('modPasien' => $modPasien,
                'model' => $model,
                'typeinstalasi' => $typeinstalasi,
        ));
    }
    
    
    public function actionDelete() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data evaluasi awal pasien berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            EvaluasiawalT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data evaluasi awal pasien gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

}
