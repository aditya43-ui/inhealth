<?php

/**
 * Controller untuk menampilkan Informasi Laporan RS di modul Pelayanan Kesehatan Masyarakat
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class InformasiLaporanInsidenRSController extends MyAuthController {

    public $path_view = 'yankesMasyarakat.views.informasiLaporanInsidenRS.';

    /**
     * Load Index Informasi Laporan RS 
     */
    public function actionIndex() {
        $model = new YKMInsidenRST;
        $model->tglawallapor = date('d M Y');
        $model->tglakhirlapor = date('d M Y');
        $model->tglawalinsiden = date('d M Y');
        $model->tglakhirinsiden = date('d M Y');
        $model->tipeLapor = true;
        $model->tipeInsiden = false;
        if (isset($_GET['YKMInsidenRST'])) {
            $model->attributes = $_GET['YKMInsidenRST'];
            $model->tglawallapor = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tglawallapor']);
            ;
            $model->tglakhirlapor = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tglakhirlapor']);
            $model->tglawalinsiden = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tglawalinsiden']);
            $model->tglakhirinsiden = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenRST']['tglakhirinsiden']);
            $model->no_rekam_medik = $_GET['YKMInsidenRST']['no_rekam_medik'];
            $model->insidenrs_jenis = $_GET['YKMInsidenRST']['insidenrs_jenis'];
            $model->tingkatrisiko_id = $_GET['YKMInsidenRST']['tingkatrisiko_id'];
            $model->regradingrisiko = $_GET['YKMInsidenRST']['regradingrisiko'];
            $model->statuslaporan = $_GET['YKMInsidenRST']['statuslaporan'];
            $model->tipeLapor = $_GET['YKMInsidenRST']['tipeLapor'];
            $model->tipeInsiden = $_GET['YKMInsidenRST']['tipeInsiden'];
        }
        $this->render($this->path_view . 'index', array('model' => $model));
    }

    /**
     * Load detail 
     * @param type $insidenrs_id
     */
    public function actionDetail($insidenrs_id) {
        $model = YKMInsidenRST::model()->findByPk($insidenrs_id);
        $modDiagnosa = DiagnosaM::model()->findByPk($model->diagnosa_id);
        $model->diagnosa_nama = $modDiagnosa->diagnosa_nama;
        $model->insidenrs_tgllapor = MyFormatter::formatDateTimeForUser($model->insidenrs_tgllapor);
        $model->insidenrs_tglinsiden = MyFormatter::formatDateTimeForUser($model->insidenrs_tglinsiden);
        $modPendaftaran = new PendaftaranT;
        $modPasien = new PasienM;
        if (!empty($model->pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        }
        $grading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        if (empty($grading->regradingrisiko)) {
            $grading->regradingrisiko = $grading->gradingrisiko;
            $grading->tgl_gradingunit = MyFormatter::formatDateTimeForUser($grading->tgl_gradingunit);
        }
        if (!empty($model->mengetahui_id)) {
            $model->mengetahui_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_id))->namaLengkap;
        }
        if (!empty($model->mengetahui_kepalaunitpenyebab_id)) {
            $model->mengetahui_kepalaunitpenyebab_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_kepalaunitpenyebab_id))->namaLengkap;
        }

        if (empty($model->pendaftaran_id)) {
            $modPasien->no_rekam_medik = $model->norekammedik;
            $modPasien->nama_pasien = $model->nama_pasien;
            $modPasien->jeniskelamin = $model->jenis_kelamin;
            $modPendaftaran->umur = $model->umur;
            $modPendaftaran->ruangan_id = $model->ruangan_id;
            $modPendaftaran->ruangan_nama = $model->ruangan_nama;
            $modPendaftaran->instalasi_id = $model->instalasi_id;
            $modPendaftaran->penjamin_nama = $model->penanggungjawab_biaya;
            $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tanggal_masukrs);
        }

        $model->mengetahui_kepalainstalasi_kejadian_nama = !empty($model->kepalainstalasikejadian->namaLengkap) ? $model->kepalainstalasikejadian->namaLengkap : null;
        $model->mengetahui_kepalainstalasi_penyebab_nama = !empty($model->kepalainstalasipenyebab->namaLengkap) ? $model->kepalainstalasipenyebab->namaLengkap : null;

        $this->render($this->path_view . 'indexDetailGrading', array('model' => $model, 'grading' => $grading, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
    }

    /**
     * Load detail untuk di kolom grading
     * @param type $insidenrs_id
     */
    public function actionDetailGrading($insidenrs_id) {
        $this->layout = '//layouts/iframe';
        $model = YKMInsidenRST::model()->findByPk($insidenrs_id);
        $grading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $modPendaftaran = new PendaftaranT;
        $modPasien = new PasienM;
        if (!empty($model->pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        }
        if (empty($grading->regradingrisiko)) {
            $grading->regradingrisiko = $grading->gradingrisiko;
        }

        if (empty($model->pendaftaran_id)) {
            $modPasien->no_rekam_medik = $model->norekammedik;
            $modPasien->nama_pasien = $model->nama_pasien;
            $modPasien->jeniskelamin = $model->jenis_kelamin;
            $modPendaftaran->umur = $model->umur;
            $modPendaftaran->ruangan_id = $model->ruangan_id;
            $modPendaftaran->ruangan_nama = $model->ruangan_nama;
            $modPendaftaran->instalasi_id = $model->instalasi_id;
            $modPendaftaran->penjamin_nama = $model->penanggungjawab_biaya;
            $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tanggal_masukrs);
        }

        $this->render($this->path_view . 'indexDetailGrading', array('model' => $model, 'grading' => $grading, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
    }

    /**
     * Digunakan untuk melakukan regrading
     * @param type $insidenrs_id 
     */
    public function actionRegrading($insidenrs_id) {
        $this->layout = '//layouts/iframe';
        $model = InsidenrsT::model()->findByPk($insidenrs_id);
        $model->insidenrs_tgllapor = MyFormatter::formatDateTimeForUser($model->insidenrs_tgllapor);
        $model->insidenrs_tglinsiden = MyFormatter::formatDateTimeForUser($model->insidenrs_tglinsiden);
        $modPendaftaran = new PendaftaranT;
        $modPasien = new PasienM;
        if (!empty($model->pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        }
        if (!empty($model->mengetahui_id)) {
            $model->mengetahui_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_id))->namaLengkap;
        }
        if (!empty($model->mengetahui_kepalaunitpenyebab_id)) {
            $model->mengetahui_kepalaunitpenyebab_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_kepalaunitpenyebab_id))->namaLengkap;
        }
        
        if (!empty($model->mengetahui_kepalainstalasi_kejadian_id)) {
            $model->mengetahui_kepalainstalasi_kejadian_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_kepalainstalasi_kejadian_id))->namaLengkap;
        }
        
        if (!empty($model->mengetahui_kepalainstalasi_penyebab_id)) {
            $model->mengetahui_kepalainstalasi_penyebab_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_kepalainstalasi_penyebab_id))->namaLengkap;
        }

        if ($model->terjadiunitlain_tidak = 1) {
            $model->terjadiunitlain_tidak = 1;
        } else {
            $model->terjadiunitlain_ya = 1;
        }
        $model->ruanganpenyebab_nama = RuanganM::model()->findByPk($model->ruanganpenyebab_id)->ruangan_nama; 
        $cekDetail = InsidenrsdetT::model()->findByAttributes(array('insidenrs_id'=>$model->insidenrs_id));
        if(!empty($cekDetail)){
            $cektipeinsiden = SubtipeinsidenM::model()->findByAttributes(array('subtipeinsiden_id'=>$cekDetail->subtipeinsiden_id));
            $model->tipeinsiden = $cektipeinsiden->tipeinsiden->tipeinsiden_id;
        }
        if (!empty($model->lokasikejadian_id)) {
            $ruangan = RuanganM::model()->findByPk($model->lokasikejadian_id);
            $model->lokasikejadian_nama = $ruangan->ruangan_nama;
        }
        if (!empty($model->unitkerjatempat_id)) {
            $unit = UnitkerjaM::model()->findByPk($model->unitkerjatempat_id);
            $model->unitkerja = $unit->namaunitkerja;
        }
        if (!empty($model->unitkerjapenyebab_id)) {
            $unit = UnitkerjaM::model()->findByPk($model->unitkerjapenyebab_id);
            $model->unitkerjapenyebab_nama = $unit->namaunitkerja;
        }

        if (!empty($model->diagnosa_id)) {
            $modDiagnosa = DiagnosaM::model()->findByPk($model->diagnosa_id);
            $model->diagnosa_nama = $modDiagnosa->diagnosa_nama;
        }

        $grading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $cekgrading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $grading = $cekgrading;
        if (empty($cekgrading->regradingrisiko)) {
            $cekgrading->regradingrisiko = $cekgrading->gradingrisiko;
        }

        if (empty($model->pendaftaran_id)) {
            $modPasien->no_rekam_medik = $model->norekammedik;
            $modPasien->nama_pasien = $model->nama_pasien;
            $modPasien->jeniskelamin = $model->jenis_kelamin;
            $modPendaftaran->umur = $model->umur;
            $modPendaftaran->ruangan_id = $model->ruangan_id;
            $modPendaftaran->ruangan_nama = $model->ruangan_nama;
            $modPendaftaran->instalasi_id = $model->instalasi_id;
            $modPendaftaran->penjamin_nama = $model->penanggungjawab_biaya;
            $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tanggal_masukrs);
        }


        if (isset($_POST['InsidenrsT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['InsidenrsT'];
                
                $model->insidenrs_tgllapor = MyFormatter::formatDateTimeForDb($model->insidenrs_tgllapor);
                $model->insidenrs_tglinsiden = MyFormatter::formatDateTimeForDb($model->insidenrs_tglinsiden);
                $model->pendaftaran_id = isset($model->pendaftaran_id) ? $model->pendaftaran_id : null;
                $modPegawaiTempat = PegawaiM::model()->findByPk($model->mengetahui_id);
                $model->unitkerjatempat_id = $modPegawaiTempat->unitkerja_id;
                $modPegawaiPenyebab = PegawaiM::model()->findByPk($model->mengetahui_kepalaunitpenyebab_id);
                $model->unitkerjapenyebab_id = $modPegawaiPenyebab->unitkerja_id;
                $model->lokasikejadian_id = isset($model->lokasikejadian_id) ? $model->lokasikejadian_id : $_POST['InsidenrsT']['lokasikejadian_id'];

                if ($_POST['InsidenrsT']['terjadiunitlain_ya'] == 1) {
                    $model->terjadiunitlain = true;
                }
                if ($_POST['InsidenrsT']['terjadiunitlain_ya'] == 1) {
                    $model->terjadiunitlain = false;
                }

                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $ok = $ok && $model->save();

                if (isset($_POST['InsidenrsdetT'])) {
                    InsidenrsdetT::model()->deleteAllByAttributes(array('insidenrs_id' => $insidenrs_id));
                    foreach ($_POST['InsidenrsdetT'] as $i => $post) {
                        if ($post['pilih'] > 0) {
                            $modDetail = new InsidenrsdetT();
                            $modDetail->kelompoksubtipeinsiden_id = $post['kelompoksubtipeinsiden_id'];
                            $modDetail->subtipeinsiden_id = $post['subtipeinsiden_id'];
                            $modDetail->insidenrs_id = $model->insidenrs_id;
                            $modDetail->create_time = date('Y-m-d H:i:s');
                            $modDetail->create_loginpemakai_id = Yii::app()->user->id;
                            $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            $ok = $modDetail->save() && $ok;
                        }
                    }
                }

                if (isset($_POST['GradinginsidenrsT'])) {
                    $grading->attributes = $_POST['GradinginsidenrsT'];
                    $grading->insidenrs_id = $insidenrs_id;
                    $grading->grader2 = Yii::app()->user->getState('pegawai_id');
                    $grading->update_time = date('Y-m-d H:i:s');
                    $grading->update_loginpemakai_id = Yii::app()->user->id;
                    $ok = $ok && $grading->save();
                }
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('regrading', 'insidenrs_id' => $insidenrs_id, 'frame' => 3, 'popup' => true, 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true));
                $trans->rollback();
            }
        }
        $this->render($this->path_view . 'indexGrading', array(
            'model' => $model,
            'grading' => $cekgrading,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien
        ));
    }

    /**
     * Load Halaman Status Laporan
     * @param type $insidenrs_id
     */
    public function actionSubmitLaporan($insidenrs_id) {
        $this->layout = '//layouts/iframe';
        $model = YKMInsidenRST::model()->findByPk($insidenrs_id);
        $model->tgl_laporan = date('d M Y');

        $this->render($this->path_view . 'statusLaporan', array(
            'model' => $model,
        ));
    }

    /**
     * Fungsi ajax untuk submit status laporan grading
     * @throws CHttpException
     */
    public function actionAjaxUbahStatus() {
        if (Yii::app()->request->isPostRequest) {
            $tanggal = MyFormatter::formatDateTimeForDb($_POST['tanggal']);
            $status = $_POST['status'];
            $keterangan = $_POST['keterangan'];
            $kategori = !empty($_POST['kategori']) ? $_POST['kategori'] : null;
            $id = $_POST['id'];
            $ok = true;
            $grading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $id));
            $grading->tgl_persetujuan = $tanggal;
            $grading->statuslaporan = $status;
            $grading->alasan_persetujuan = $keterangan;
            $grading->kategoripenolakan = $kategori;
            if ($grading->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-success'>Perubahan Status Laporan berhasil disimpan.</div>",
                    ));
                    exit;
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'gagal_form',
                        'div' => "<div class='flash-danger'>Perubahan Status Laporan gagal disimpan.</div>",
                    ));
                    exit;
                }
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Ajax generate tindakan dari tingkat risiko
     */
    public function actionGenerateTindakan() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $ok = 1;
            $msg = " ";
            $risiko = $_POST['risiko'];
            $peluang = $_POST['peluang'];
            $konsekuensi = $_POST['konsekuensi'];
            $model = TingkatrisikoM::model()->findByPk($risiko);

            if (empty($model)) {
                $data['ok'] = 0;
                $data['msg'] = "Tingkat risiko tidak ditemukan";
            }

            $data['ok'] = 1;
            $data['msg'] = 1;
            $data['tingkatrisiko_tindakan'] = $model->tingkatrisiko_tindakan;
            $data['tingkatrisiko_warna'] = $model->tingkatrisiko_warna;

            $modPeluang = PeluangM::model()->findByPk($peluang);
            $modKonsekuensi = KonsekuensiM::model()->findByPk($konsekuensi);

            $data['skor'] = $modKonsekuensi->konsekuensi_bobot * $modPeluang->peluang_bobotdescriptor;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Autocomplete Ruangan
     */
    public function actionAutocompleteRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->select = "t.*";
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition("t.ruangan_aktif is true");
            $criteria->order='t.ruangan_nama ASC';
            $criteria->limit = 10;
            $models = RuanganM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ruangan_nama;
                $returnVal[$i]['value'] = $model->ruangan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete Unit Kerja
     * Filter berdasarkan ruangan 
     */
    public function actionAutocompleteUnitKerjaRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->select = "t.*, unitkerja_m.*";
            $criteria->join = "join unitkerja_m on t.unitkerja_id = unitkerja_m.unitkerja_id "
                            . "join ruangan_m on t.ruangan_id = ruangan_m.ruangan_id ";
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)', strtolower($_GET['term']), true);
            $criteria->addCondition("unitkerja_m.unitkerja_aktif is true");
            if (empty($_GET['ruangan_id'])) {
                $criteria->addCondition('t.ruangan_id is null');
            } else {
                $criteria->addCondition('t.ruangan_id = '.$_GET['ruangan_id']);
            }
            $criteria->order='unitkerja_m.namaunitkerja ASC';
            $criteria->limit = 10;
            $models = UnitkerjaruanganM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaunitkerja;
                $returnVal[$i]['value'] = $model->unitkerja_id;
                
                $modUnit = UnitkerjaM::model()->findByPk($model->unitkerja_id); 
                $returnVal[$i]['kepalaunitpeg_id'] = !empty($modUnit->kepalaunitpeg_id) ? $modUnit->kepalaunitpeg_id : null;
                $returnVal[$i]['kepalaunitpeg_nama'] = !empty($modUnit->kepalaunitpeg_id) ? $modUnit->kepalaunitkerja->namaLengkap : null;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Load data autocomplete Unit Kerja 
     */
    public function actionAutocompleteDiagnosa() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            $criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);

            $criteria->order = 'diagnosa_nama';
            $criteria->limit = 5;
            $models = DiagnosaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['diagnosa_id'] = $model->diagnosa_id;
                $returnVal[$i]['value'] = $model->diagnosa_id;
                $returnVal[$i]['label'] = $model->diagnosa_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Mendapatkan data kelompoktipe insiden dari inputan user
     */
    public function actionGetTabel() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            $tipeinsiden = $_POST['tipeinsiden'];
            $insiden_id = $_POST['insiden_id'];
            $jenis = $_POST['jenis'];

            $criteria = new CDbCriteria();
            $criteria->addCondition("tipeinsiden_id =" . $tipeinsiden);
            $modKelompok = KelompoksubtipeinsidenM::model()->findAll($criteria);

            if (!empty($modKelompok)) {
                if ($jenis == 'load') {
                    $models = InsidenrsdetT::model()->findAllByAttributes(array('insidenrs_id' => $insiden_id));
                    foreach ($models as $i => $model) {
                        $return = $this->renderPartial($this->path_view . "_rowTabel", array('model' => $model, 'modKelompok' => $modKelompok), true);
                    }
                } else {
                    $model = new InsidenrsdetT();
                    $return = $this->renderPartial($this->path_view . "_rowTabel", array('model' => $model, 'modKelompok' => $modKelompok), true);
                }

                $message = 'sukses';
            } else {
                $return = '';
                $message = 'gagal';
            }
            $data['return'] = $return;
            $data['pesan'] = $message;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Detail grading ditolak 
     * @param type $insidenrs_id
     */
    function actionDetailDitolak($insidenrs_id) {
        $this->layout = '//layouts/iframe';
        $model = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        $model->tgl_persetujuan = MyFormatter::formatDateTimeForUser($model->tgl_persetujuan);
        $this->render('detailDitolak', array('model' => $model));
    }

    /**
     * Autocomplete pegawai
     */
    public function actionGetPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition(" pegawai_aktif = TRUE ");
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawaiV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
                if (!empty($model->jabatan_id)) {
                    $returnVal[$i]['jabatan_nama'] = JabatanM::model()->findByPk($model->jabatan_id)->jabatan_nama;
                } else {
                    $returnVal[$i]['jabatan_nama'] = '';
                }
                $returnVal[$i]['nosk'] = $model->getNoKeputusan();
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
