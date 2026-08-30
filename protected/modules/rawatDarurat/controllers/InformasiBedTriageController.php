<?php

class InformasiBedTriageController extends MyAuthController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.informasiBedTriage.';
    public $path_tips = 'sistemAdministrator.views.tips.';

    /**
     * halaman informasi
     */
    public function actionIndex()
    {
        $format = new MyFormatter;
        $model = new RDInformasibedtriageV();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_GET['RDInformasibedtriageV'])) {
            $model->attributes = $_GET['RDInformasibedtriageV'];
            $model->tgl_awal = isset($_GET['RDInformasibedtriageV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['RDInformasibedtriageV']['tgl_awal']) : null;
            $model->tgl_akhir = isset($_GET['RDInformasibedtriageV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['RDInformasibedtriageV']['tgl_akhir']) : null;
        }

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['ajax'])) {
                $ajax = $_GET['ajax'];
                if ($ajax == 'informasi-stok-grid')
                    $path = $this->path_view . '_tabel';

                $this->renderPartial($path, ['model' => $model]);
            }
            exit;
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * menampilkan dan menyimpan set petugas
     * @param type $id
     * @param type $proses
     */
    public function actionSetPendaftaran($id, $proses = null)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $model = NotriagePasienT::model()->findByPk($id);
            $modPas = !empty($model->pendaftaran) ? $model->pendaftaran->pasien : new PasienM;
            $ok = '';
            $pesan = '';

            if ($proses == 'simpan') {
                parse_str($_POST['formdata'], $arr);
                $ok = true;

                $trans = Yii::app()->db->beginTransaction();
                try {
                    $model->attributes = $arr['NotriagePasienT'];
                    
                    $model->pasien_id = $arr['NotriagePasienT']['pasien_id'];
                    $ok &= $model->update();
                    // print_r($model->notriage_pasien_id);
                    // exit;
                    $wpss = AsesmentriagewpssT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $anamnesa = AnamnesaT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $pemeriksaanfisik = PemeriksaanfisikT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    if (!empty($wpss)) {
                        $wpss->pendaftaran_id = $model->pendaftaran_id;
                        $wpss->pasien_id = $model->pasien_id;
                        $ok &= $wpss->update();
                    }

                    if (!empty($anamnesa)) {
                        $anamnesa->pendaftaran_id = $model->pendaftaran_id;
                        $anamnesa->pasien_id = $model->pasien_id;
                        $anamnesa->update_time = date('Y-m-d H:i:s');
                        $anamnesa->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $anamnesa->update();
                    }

                    if (!empty($pemeriksaanfisik)) {
                        $pemeriksaanfisik->pendaftaran_id = $model->pendaftaran_id;
                        $pemeriksaanfisik->pasien_id = $model->pasien_id;
                        $pemeriksaanfisik->update_time = date('Y-m-d H:i:s');
                        $pemeriksaanfisik->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $pemeriksaanfisik->update();
                    }

                    if ($ok) {
                        $trans->commit();
                        $pesan .= "set pendaftaran sukses simpan";
                    } else {
                        $trans->rollback();
                        $pesan .= "set pendaftaran gagal simpan";
                    }
                } catch (Exception $ex) {
                    $trans->rollback();
                    $pesan .= 'set pendaftaran gagal simpan <br/>' . $ex->getMessage();
                }
            }

            $html = $this->renderPartial($this->path_view . 'set-pendaftaran/index', [
                'model' => $model,
                'modPas' => $modPas,
                'sukses' => ($ok) ? 'ya' : (($ok === false) ? 'tidak' : ''),
                'pesan' => $pesan
            ], true);

            echo json_encode($html);
        }
        Yii::app()->end();
    }




    public function actionSetPendaftaran2($id, $proses = null)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $model = NotriagePasienT::model()->findByPk($id);
            $modPas = !empty($model->pendaftaran) ? $model->pendaftaran->pasien : new PasienM;
            $ok = '';
            $pesan = '';

            if ($proses == 'simpan') {
                parse_str($_POST['formdata'], $arr);
                $ok = true;

                $trans = Yii::app()->db->beginTransaction();
                try {
                    $model->attributes = $arr['NotriagePasienT'];
                    
                    $model->pasien_id = $arr['NotriagePasienT']['pasien_id'];
                    $ok &= $model->update();
                    // print_r($model->notriage_pasien_id);
                    // exit;
                    $wpss = AsesmentriagewpssT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $anamnesa = AnamnesaT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    $pemeriksaanfisik = PemeriksaanfisikT::model()->findByAttributes([
                        'notriage_pasien_id' => $model->notriage_pasien_id
                    ]);

                    if (!empty($wpss)) {
                        $wpss->pendaftaran_id = $model->pendaftaran_id;
                        $wpss->pasien_id = $model->pasien_id;
                        $ok &= $wpss->update();
                    }

                    if (!empty($anamnesa)) {
                        $anamnesa->pendaftaran_id = $model->pendaftaran_id;
                        $anamnesa->pasien_id = $model->pasien_id;
                        $anamnesa->update_time = date('Y-m-d H:i:s');
                        $anamnesa->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $anamnesa->update();
                    }

                    if (!empty($pemeriksaanfisik)) {
                        $pemeriksaanfisik->pendaftaran_id = $model->pendaftaran_id;
                        $pemeriksaanfisik->pasien_id = $model->pasien_id;
                        $pemeriksaanfisik->update_time = date('Y-m-d H:i:s');
                        $pemeriksaanfisik->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                        $ok &= $pemeriksaanfisik->update();
                    }

                    if ($ok) {
                        $trans->commit();
                        $pesan .= "set pendaftaran sukses simpan";
                    } else {
                        $trans->rollback();
                        $pesan .= "set pendaftaran gagal simpan";
                    }
                } catch (Exception $ex) {
                    $trans->rollback();
                    $pesan .= 'set pendaftaran gagal simpan <br/>' . $ex->getMessage();
                }
            }

            $html = $this->renderPartial($this->path_view . 'set-pendaftaran/index2', [
                'model' => $model,
                'modPas' => $modPas,
                'sukses' => ($ok) ? 'ya' : (($ok === false) ? 'tidak' : ''),
                'pesan' => $pesan
            ], true);

            echo json_encode($html);
        }
        Yii::app()->end();
    }

    public function actionLoadPendaftaran()
    {
        if (Yii::app()->request->isAjaxRequest) {

            $id = $_GET['id'];

            $modDaftar = RDPendaftaranT::model()->findByPk($id);
            $return = [];
            $return['no_rekam_medik'] = '';
            $return['nama_pasien'] = '';
            $return['pasien_id'] = '';
            if (!empty($modDaftar)) {
                $return['no_rekam_medik'] = $modDaftar->pasien->no_rekam_medik;
                $return['nama_pasien'] = $modDaftar->pasien->nama_pasien;
                $return['alamat_pasien'] = $modDaftar->pasien->alamat_pasien;
                $return['pasien_id'] = $modDaftar->pasien_id;
                $return['pendaftaran_id'] = $modDaftar->pendaftaran_id;
            }

            echo json_encode($return);
            Yii::app()->end();
        }
    }

    public function actionTambahTriage() {
        $this->layout = '//layouts/iframe';
        $model = new RDNotriagePasienT;
        $model->no_bed_triage = '- Otomatis -';

        if (isset($_POST['RDNotriagePasienT'])) {

            if ($_POST['RDNotriagePasienT'] != "") {
                // echo '<pre>';var_dump($_POST);die;
                $transaction = Yii::app()->db->beginTransaction();
                $ok = true;
                try {
                    $model->attributes = $_POST['RDNotriagePasienT'];
                    $bedTriage = BedTriageM::model()->findByPk($_POST['RDNotriagePasienT']['bed_triage_id']);
                    $model->no_bed_triage = $bedTriage->no_bed;
                    $model->no_triage_pasien = MyGenerator::noTriagePasien();
                    // $model->no_triage_pasien = ($model->bed_triage_id < 10) ? 'A0' . $model->bed_triage_id : 'A' . $model->bed_triage_id;
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    
                    // echo'<pre>';var_dump( $_POST, $model);die;
                    $ok && $model->save();

                    if ($ok) {
                        $bedTriage->is_use = false;
                        $bedTriage->keterangan_use = $_POST['RDNotriagePasienT']['keterangan'];
                        if($bedTriage->save()) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                            $this->redirect(['tambahTriage', 'sukses' => 1]);
                            // echo CJSON::encode(array(
                            //     'status' => 'proses_form',
                            //     'div' => "<div class='flash-success'>Berhasil menambahkan pasien IGD.</div>",
                            // ));
                        }
                    } else {
                        $transaction->rollback();

                        // echo CJSON::encode(array(
                        //     'status' => 'proses_form',
                        //     'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                        // ));
                    }
                } catch (Exception $exc) {
                    echo '<pre>';var_dump($exc);die;
                    $transaction->rollback();
                }
            }
        }
        
        $this->render('_formTambahPasienIGD', array('model' => $model));

        // if (Yii::app()->request->isAjaxRequest) {
        //     echo CJSON::encode(array(
        //         'status' => 'create_form',
        //         'div' => $this->renderPartial('_formTambahPasienIGD', array('model' => $model), true)
        //     ));
        //     exit;
        // }
    }

    function actionCekBed() {
        $bed_triage_id = $_POST['bed_triage_id'];
        $modBed = BedTriageM::model()->findByPk($bed_triage_id);
        $data['ketersediaan'] = 2;

        if(!empty($modBed)) {
            $modPasienTriage = RDNotriagePasienT::model()->findByAttributes(['no_bed_triage' => $modBed->no_bed], 'create_time::date = current_date');
            if(!empty($modPasienTriage)) {
                $data['ketersediaan'] = 0;
                $data['infobed'] = 'Bed ' . $modBed->no_bed . ' Masih Digunakan oleh pasien dengan no triage ' . $modPasienTriage->no_triage_pasien;
            } else {
                $data['ketersediaan'] = 1;
            }
        }

        echo json_encode($data);

    }

    public function actionTambahTriagePasien() {
        $model = new RDNotriagePasienT;
        $model->no_bed_triage = '- Otomatis -';

        if (isset($_POST['RDNotriagePasienT'])) {
            if (!empty($_POST['RDNotriagePasienT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                $ok = true;
                try {

                    $model->attributes = $_POST['RDNotriagePasienT'];
                    $model->pendaftaran_id = $_POST['RDNotriagePasienT']['pendaftaran_id'];
                    $model->pasien_id = $_POST['RDNotriagePasienT']['pasien_id'];
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $bedTriage = BedTriageM::model()->findByPk($_POST['RDNotriagePasienT']['bed_triage_id']);
                    $model->no_bed_triage = $bedTriage->no_bed;
                    $model->no_triage_pasien = MyGenerator::noTriagePasien();
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                    $ok && $model->save();

                    if ($ok) {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil menambahkan pasien IGD.</div>",
                        ));
                    } else {
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                        ));
                    }
                    exit;
                } catch (Exception $exc) {
                    $transaction->rollback();
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-error'>Data gagal disimpan.</div>" . $exc->getMessage(),
                    ));
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'create_form',
                'div' => $this->renderPartial('_formTambahTriagePasienIGD', array('model' => $model, 'sukses' => 'tidak', 'jenisform' => 'tambah'), true)
            ));
            exit;
        }
    }

    public function actionLoadTriage() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $jenis = $_POST['jenis'];

            if ($jenis == 'ubah') {
                $model = RDNotriagePasienT::model()->findByPk($id);

                $returnVal['no_bed_triage'] = $model->no_bed_triage;
                $returnVal['notriage_pasien_id'] = $model->notriage_pasien_id;
                $returnVal['keterangan'] = $model->keterangan;
                $returnVal['bed_triage_id'] = $model->bed_triage_id;
            } else {
                $model = BedTriageM::model()->findByPk($id);
                $returnVal['no_bed_triage'] = $model->no_bed;
                $returnVal['notriage_pasien_id'] = '';
                $returnVal['keterangan'] = '';
                $returnVal['bed_triage_id'] = $model->bed_triage_id;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    public function actionUpdateTriagePasien($pendaftaran_id, $notriage_pasien_id = null) {

        $this->layout = '//layouts/iframe';
        $sukses = 'tidak';
        $modPendaftaran = RDPendaftaranT::model()->findByPk($pendaftaran_id);
        $model = new RDNotriagePasienT;
        if (!empty($notriage_pasien_id)) {
            $model = RDNotriagePasienT::model()->findByAttributes(array('notriage_pasien_id' => $notriage_pasien_id));
        } else {
            $cekNo = RDNotriagePasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if (!empty($cekNo)) {
                $model = $cekNo;
            }
        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        if (isset($_POST['RDNotriagePasienT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $clone = clone $model;
                if (!empty($_POST['RDNotriagePasienT']['notriage_pasien_id'])) {
                    $cek = RDNotriagePasienT::model()->findByPk($_POST['RDNotriagePasienT']['notriage_pasien_id']);
                    if (!empty($cek)) {
                        $model = $cek;
                    }
                }
                $model->attributes = $_POST['RDNotriagePasienT'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $ok && $model->update();

                // echo '<pre>'; var_dump($model->attributes, $clone->attributes); die();


                if (!empty($clone->notriage_pasien_id)) {
                    if ($clone->notriage_pasien_id != $model->notriage_pasien_id) {
                        $clone->pendaftaran_id = null;
                        $clone->pasien_id = null;
                        $clone->update();

                        $wpss = AsesmentriagewpssT::model()->findByAttributes([
                            'notriage_pasien_id' => $clone->notriage_pasien_id
                        ]);

                        if (!empty($wpss)) {
                            $wpss->pendaftaran_id = null;
                            $wpss->pasien_id = null;
                            $wpss->update();
                        }
                    } else {
                        $wpss = AsesmentriagewpssT::model()->findByAttributes([
                            'notriage_pasien_id' => $clone->notriage_pasien_id
                        ]);

                        if (!empty($wpss)) {
                            $wpss->pendaftaran_id = $model->pendaftaran_id;
                            $wpss->pasien_id = $model->pasien_id;
                            $wpss->update();
                        }
                    }
                }

                if ($ok) {
                    $trans->commit();
                    $sukses = 'iya';
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ! ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . $ex->getMessage());
            }
        }

        $this->render('_formTambahTriagePasienIGD', array('model' => $model, 'sukses' => $sukses));
    }
}
