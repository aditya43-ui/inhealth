<?php

class CatatanImplementasiController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rekamMedis.views.catatanImplementasi.';
    public $tersimpan = false;

    public function actionIndex($pasien_id = null, $pendaftaran_id = null, $typeinstalasi = null, $catatanimplementasi_id = null) {
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
            // $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

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
        
        if (!empty($catatanimplementasi_id)) {
            $model = CatatanimplementasiT::model()->findByPk($catatanimplementasi_id);
            $model->fasilitas = explode(";", $model->fasilitas);
            $model->petugaspengisi_nama = empty($model->petugaspengisi) ? null : $model->petugaspengisi->namaLengkap;
        } else {
            $model = new CatatanimplementasiT();
            $model->ruangan_id = $modPendaftaran->ruangan_id;
            $model->pasien_id = $modPendaftaran->pasien_id;
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

        if (isset($_POST['CatatanimplementasiT'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes = $_POST['CatatanimplementasiT'];
                $model->tgl_evaluasi = MyFormatter::formatDateTimeForDb($_POST['CatatanimplementasiT']['tgl_evaluasi']);

                if ($model->kelompok_resiko == 'LAINNYA') {
                    $model->kelompok_resiko = $_POST['CatatanimplementasiT']['kelompok_resikolainnya'];
                }
                if (!empty($model->catatanimplementasi_id)) {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                } else {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan = Yii::app()->user->getState("ruangan_id");

                if (is_array($model->fasilitas)) {
                    $model->fasilitas = implode(";", $model->fasilitas);
                }

                // var_dump($model->attributes, $model->validate(), $model->errors); die;

                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
                    $this->redirect(array('index', 'pasien_id'=>$pasien_id, 'pendaftaran_id' => $pendaftaran_id, 'typeinstalasi' => $typeinstalasi, 'catatanimplementasi_id' => $model->catatanimplementasi_id, 'sukses' => 1));
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

    public function actionPrint($pendaftaran_id, $catatanimplementasi_id, $typeinstalasi) {
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
        $model = CatatanimplementasiT::model()->findByPk($catatanimplementasi_id);

        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'caraPrint' => $caraPrint));
        }
    }

    public function actionPrintRiwayat($catatanimplementasi_id) {
        $model = CatatanimplementasiT::model()->findByPk($catatanimplementasi_id);
        $modPendaftaran = RKPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pasien_id' => $model->pasien_id), array(
            'order' => 'pendaftaran_id desc',
        ));
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

        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (!empty($caraPrint) && $caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'caraPrint' => $caraPrint));
        } else {
            $this->layout = '//layouts/iframe';
            $this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran));
        }
    }

    public function actionRiwayat($pasien_id) {
        $this->layout = '//layouts/iframe';

        $modPasien = PasienM::model()->findByPk($pasien_id);
        $model = new CatatanimplementasiT();

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
        $msg = "Data catatan implementasi berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            CatatanimplementasiT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data catatan implementasi gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

}
