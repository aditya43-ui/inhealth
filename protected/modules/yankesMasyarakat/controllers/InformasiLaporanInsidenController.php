<?php

/**
 * Digunakan untuk mengakses informasi laporan insiden
 * 
 * @author   Andyka Putra <andykaputra@.com>
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package    application.modules.yankesMasyarakat
 * @subpackage controllers
 * RSST-4346
 */
class InformasiLaporanInsidenController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $simpandetail = false;
    public $defaultAction = 'index';
    public $path_view = 'yankesMasyarakat.views.informasiLaporanInsiden.';
    public $path_grading = 'yankesMasyarakat.views.informasiLaporanInsiden.grading';
    public $path_detail = 'yankesMasyarakat.views.informasiLaporanInsiden.detail';
    public $path_update = 'yankesMasyarakat.views.informasiLaporanInsiden.ubah';

    /**
     * Halaman utama Informasi Laporan Insiden
     */
    public function actionIndex() {
        $this->layout = '//layouts/mainNeonSidebar';

        $model = new InsidenrsT();
        $model->tanggal_awal = date("Y-m-d");
        $model->tanggal_akhir = date("Y-m-d");
        $model->tanggal_awal2 = date("Y-m-d");
        $model->tanggal_akhir2 = date("Y-m-d");
        $model->tipeLapor = "1";
        $model->tipeInsiden = "0";
        if (isset($_GET['InsidenrsT'])) {
            $model->attributes = $_GET['InsidenrsT'];
            $model->no_rekammedik = $_GET['InsidenrsT']['no_rekammedik'];
            $model->instalasi_id = isset($_GET['InsidenrsT']['instalasi_id']) ? $_GET['InsidenrsT']['instalasi_id'] : null;
            $model->ruangan_id = isset($_GET['InsidenrsT']['ruangan_id']) ? $_GET['InsidenrsT']['ruangan_id'] : null;
            $model->gradingrisiko = isset($_GET['InsidenrsT']['gradingrisiko']) ? $_GET['InsidenrsT']['gradingrisiko'] : null;
            $model->status_laporan = isset($_GET['InsidenrsT']['status_laporan']) ? $_GET['InsidenrsT']['status_laporan'] : null;
            $model->tanggal_awal = isset($_GET['InsidenrsT']['tanggal_awal']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_awal']) : null;
            $model->tanggal_akhir = isset($_GET['InsidenrsT']['tanggal_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_akhir']) : null;
            $model->tanggal_awal2 = isset($_GET['InsidenrsT']['tanggal_awal2']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_awal2']) : null;
            $model->tanggal_akhir2 = isset($_GET['InsidenrsT']['tanggal_akhir2']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_akhir2']) : null;
            $model->tipeLapor = isset($_GET['InsidenrsT']['tipeLapor']) ? $_GET['InsidenrsT']['tipeLapor'] : 1;
            $model->tipeInsiden = isset($_GET['InsidenrsT']['tipeInsiden']) ? $_GET['InsidenrsT']['tipeInsiden'] : 0;
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * Update Laporan Insiden
     * @param type $insidenrs_id
     */
    public function actionUpdate($insidenrs_id) {
        $model = InsidenrsT::model()->findByPk($insidenrs_id);
        $cekPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);

        $tempat = '';
        $lokasi = '';
        if (!empty($model->lokasikejadian_id)) {
            $cekRuangan = RuanganM::model()->findByPk($model->lokasikejadian_id);
            $tempat = $cekRuangan->ruangan_nama;

            $modUnitKerja = UnitkerjaruanganM::model()->findByAttributes(array('ruangan_id' => $model->lokasikejadian_id));
            if (!empty($modUnitKerja->unitkerja_id)) {
                $unitKerja = UnitkerjaM::model()->findByPk($modUnitKerja->unitkerja_id);
                $lokasi = $unitKerja->namaunitkerja;
            } else {
                $lokasi = '';
            }
        } else {
            $tempat = '';
            $lokasi = '';
        }

        $model->ruanganpenyebab_nama = RuanganM::model()->findByPk($model->ruanganpenyebab_id)->ruangan_nama;
        $cekunitPenyebab = UnitkerjaM::model()->findByPk($model->unitkerjapenyebab_id);

        if ($model->tindakan_olehdokter == true) {
            $model->tindakan_olehdokter = 1;
        } else {
            $model->tindakan_olehdokter = 0;
        }

        if ($model->tindakan_olehperawat == true) {
            $model->tindakan_olehperawat = 1;
        } else {
            $model->tindakan_olehperawat = 0;
        }

        if ($model->tindakan_olehpetugaslain == true) {
            $model->tindakan_olehpetugaslain = 1;
        } else {
            $model->tindakan_olehpetugaslain = 0;
        }

        if ($model->terjadiunitlain == true) {
            $model->terjadiunitlain_ya = 1;
            $model->terjadiunitlain_tidak = 0;
        } else {
            $model->terjadiunitlain_ya = 0;
            $model->terjadiunitlain_tidak = 1;
        }
        $model->lokasikejadian_nama = $tempat;
        $model->unitkerja = $lokasi;
        $model->unitkerjapenyebab_nama = !empty($model->unitkerjapenyebab_id) ? $cekunitPenyebab->namaunitkerja : '';
        if (!empty($model->mengetahui_id)) {
            $model->mengetahui_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_id))->namaLengkap;
        }
        if (!empty($model->mengetahui_kepalaunitpenyebab_id)) {
            $model->mengetahui_kepalaunitpenyebab_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_kepalaunitpenyebab_id))->namaLengkap;
        }

        $model->mengetahui_kepalainstalasi_kejadian_nama = !empty($model->kepalainstalasikejadian->namaLengkap) ? $model->kepalainstalasikejadian->namaLengkap : null;
        $model->mengetahui_kepalainstalasi_penyebab_nama = !empty($model->kepalainstalasipenyebab->namaLengkap) ? $model->kepalainstalasipenyebab->namaLengkap : null;

        if (isset($_POST['InsidenrsT'])) {
            try {
                $model->attributes = $_POST['InsidenrsT'];

                $peneliti = PenelitiM::model()->findByAttributes(array(
                    'pegawai_id' => Yii::app()->user->getState('pegawai_id')
                ));
                if (!empty($peneliti)) {
                    $model->penelitipelapor_id = $peneliti->peneliti_id;
                } else {
                    $model->penelitipelapor_id = Yii::app()->user->getState('peneliti_id');
                }
                if ($_POST['InsidenrsT']['terjadiunitlain_ya'] == 1) {
                    $model->terjadiunitlain = true;
                }
                if ($_POST['InsidenrsT']['terjadiunitlain_ya'] == 1) {
                    $model->terjadiunitlain = false;
                }
                $model->pegawaipelapor_id = Yii::app()->user->getState('pegawai_id');
                $model->insidenrs_nomor = MyGenerator::nomorInsidenRs();
                $model->insidenrs_tgllapor = MyFormatter::formatDateTimeForDb($model->insidenrs_tgllapor);
                $model->insidenrs_tglinsiden = MyFormatter::formatDateTimeForDb($model->insidenrs_tglinsiden);
                $model->pendaftaran_id = isset($model->pendaftaran_id) ? $model->pendaftaran_id : $_POST['InsidenrsT']['pendaftaran_id'];
                $model->unitkerjatempat_id = isset($model->unitkerjatempat_id) ? $model->unitkerjatempat_id : $_POST['InsidenrsT']['unitkerjatempat_id'];
                $model->unitkerjapenyebab_id = isset($model->unitkerjapenyebab_id) ? $model->unitkerjapenyebab_id : $_POST['InsidenrsT']['unitkerjapenyebab_id'];
                $model->lokasikejadian_id = isset($model->lokasikejadian_id) ? $model->lokasikejadian_id : $_POST['InsidenrsT']['lokasikejadian_id'];
                $model->diagnosa_id = isset($model->diagnosa_id) ? $model->diagnosa_id : $_POST['InsidenrsT']['diagnosa_id'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                if ($model->save()) {

                    if ($_POST['InsidenrsT']['perubahan_ada'] == 1) {
                        if (isset($_POST['InsidenrsdetT'])) {

                            InsidenrsdetT::model()->deleteAllByAttributes(array('insidenrs_id' => $model->insidenrs_id));
                            foreach ($_POST['InsidenrsdetT'] as $i => $post) {
                                if ($post['pilih'] > 0) {
                                    $modDetail = new InsidenrsdetT();
                                    $modDetail->kelompoksubtipeinsiden_id = $post['kelompoksubtipeinsiden_id'];
                                    $modDetail->subtipeinsiden_id = $post['subtipeinsiden_id'];
                                    $modDetail->insidenrs_id = $model->insidenrs_id;
                                    $modDetail->create_time = date('Y-m-d H:i:s');
                                    $modDetail->create_loginpemakai_id = Yii::app()->user->id;
                                    $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                    $this->simpandetail = $modDetail->save() && true;
                                }
                            }
                        }
                    } else {
                        $this->simpandetail = true;
                    }
                }
                if ($model->save() && ($this->simpandetail == true)) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $sukses = 1;
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_update . '/index', array(
            'model' => $model
        ));
    }

    /**
     * Digunakan untuk verifikasi
     */
    public function actionSetVerifikasi() {

        if (Yii::app()->request->isAjaxRequest) {
            $insidenrs_id = isset($_POST['insidenrs_id']) ? $_POST['insidenrs_id'] : null;
            $modInsidenrs = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
            if (!empty($modInsidenrs)) {
                $modInsidenrs->tglverifikasi_unit = date('Y-m-d H:i:s');
                $modInsidenrs->statuslaporan = 'Kirim Laporan';
                $modInsidenrs->update();
                $data['isverifikasi'] = true;
            } else {
                $data['isverifikasi'] = false;
                $data['pesan'] = 'Update Gagal Di Lakukan !';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk set status
     */
    public function actionSetStatus() {

        if (Yii::app()->request->isAjaxRequest) {
            $insidenrs_id = isset($_POST['insidenrs_id']) ? $_POST['insidenrs_id'] : null;
            $modInsidenrs = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
            if (!empty($modInsidenrs)) {
                $modInsidenrs->tgl_kirimpelaporan = date('Y-m-d H:i:s');
                $modInsidenrs->statuslaporan = 'Menunggu Persetujuan';
                $modInsidenrs->update();
                $data['isverifikasi'] = true;
            } else {
                $data['isverifikasi'] = false;
                $data['pesan'] = 'Update Gagal Di Lakukan !';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk melakukan grading
     * @param type $insidenrs_id 
     */
    public function actionGrading($insidenrs_id) {
        $this->layout = '//layouts/iframe';
        $cekgrading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        if (!empty($cekgrading)) {
            $model = $cekgrading;
            if (isset($_POST['GradinginsidenrsT'])) {
                $model->attributes = $_POST['GradinginsidenrsT'];
                $model->skor_risiko = $_POST['GradinginsidenrsT']['skor_risiko'];
                $model->insidenrs_id = $insidenrs_id;
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('grading', 'insidenrs_id' => $insidenrs_id, 'frame' => 3, 'popup' => true, 'sukses' => 1));
                }
            }
        } else {
            $model = new GradinginsidenrsT();
            if (isset($_POST['GradinginsidenrsT'])) {
                $model->attributes = $_POST['GradinginsidenrsT'];
                $model->skor_risiko = $_POST['GradinginsidenrsT']['skor_risiko'];
                $model->insidenrs_id = $insidenrs_id;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('grading', 'insidenrs_id' => $insidenrs_id, 'frame' => 3, 'popup' => true, 'sukses' => 1));
                }
            }
        }
        $this->render($this->path_grading . '/_grading', array(
            'model' => $model,
        ));
    }

    /**
     * Detail Transaksi Insiden RS
     * @param type $insidenrs_id
     */
    public function actionDetail($insidenrs_id) {
//        $this->layout = '//layouts/iframe';
        $model = InsidenrsT::model()->findByPk($insidenrs_id);
        $model->insidenrs_tgllapor = MyFormatter::formatDateTimeForUser($model->insidenrs_tgllapor);
        $model->insidenrs_tglinsiden = MyFormatter::formatDateTimeForUser($model->insidenrs_tglinsiden);
        $cekPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modGrading = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $insidenrs_id));
        if (!empty($modGrading->gradinginsidenrs_id)) {
            $modGrading->tgl_gradingunit = MyFormatter::formatDateTimeForUser($modGrading->tgl_gradingunit);
        }
        $tempat = '';
        $lokasi = '';
        if (!empty($model->lokasikejadian_id)) {
            $cekRuangan = RuanganM::model()->findByPk($model->lokasikejadian_id);
            $tempat = $cekRuangan->ruangan_nama;

            $modUnitKerja = UnitkerjaruanganM::model()->findByAttributes(array('ruangan_id' => $model->lokasikejadian_id));
            if (!empty($modUnitKerja->unitkerja_id)) {
                $unitKerja = UnitkerjaM::model()->findByPk($modUnitKerja->unitkerja_id);
                $lokasi = $unitKerja->namaunitkerja;
            } else {
                $lokasi = '';
            }
        } else {
            $tempat = '';
            $lokasi = '';
        }
        $cekunitPenyebab = UnitkerjaM::model()->findByPk($model->unitkerjapenyebab_id);

        if ($model->tindakan_olehdokter == true) {
            $model->tindakan_olehdokter = 1;
        } else {
            $model->tindakan_olehdokter = 0;
        }

        if ($model->tindakan_olehperawat == true) {
            $model->tindakan_olehperawat = 1;
        } else {
            $model->tindakan_olehperawat = 0;
        }

        if ($model->tindakan_olehpetugaslain == true) {
            $model->tindakan_olehpetugaslain = 1;
        } else {
            $model->tindakan_olehpetugaslain = 0;
        }

        if ($model->terjadiunitlain == true) {
            $model->terjadiunitlain_ya = 1;
            $model->terjadiunitlain_tidak = 0;
        } else {
            $model->terjadiunitlain_ya = 0;
            $model->terjadiunitlain_tidak = 1;
        }

        $model->lokasikejadian_nama = $tempat;
        $model->unitkerja = $lokasi;
        $model->unitkerjapenyebab_nama = !empty($model->unitkerjapenyebab_id) ? $cekunitPenyebab->namaunitkerja : '';
        $model->mengetahui_kepalainstalasi_kejadian_nama = !empty($model->kepalainstalasikejadian->namaLengkap) ? $model->kepalainstalasikejadian->namaLengkap : null;
        $model->mengetahui_kepalainstalasi_penyebab_nama = !empty($model->kepalainstalasipenyebab->namaLengkap) ? $model->kepalainstalasipenyebab->namaLengkap : null;
        if (!empty($model->mengetahui_id)) {
            $model->mengetahui_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_id))->namaLengkap;
        }
        if (!empty($model->mengetahui_kepalaunitpenyebab_id)) {
            $model->mengetahui_kepalaunitpenyebab_nama = PegawaiV::model()->findByAttributes(array('pegawai_id' => $model->mengetahui_kepalaunitpenyebab_id))->namaLengkap;
        }


        $this->render($this->path_detail . '/index', array(
            'model' => $model,
            'modGrading' => $modGrading
        ));
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
            $criteria->order = 't.ruangan_nama ASC';
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
                $criteria->addCondition('t.ruangan_id = ' . $_GET['ruangan_id']);
            }
            $criteria->order = 'unitkerja_m.namaunitkerja ASC';
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

            $criteria = new CDbCriteria();
            $criteria->addCondition("tipeinsiden_id =" . $tipeinsiden);
            $modKelompok = KelompoksubtipeinsidenM::model()->findAll($criteria);

            if (!empty($modKelompok)) {
                $model = new InsidenrsdetT();
                $return = $this->renderPartial($this->path_update . "/_rowTabel", array('model' => $model, 'modKelompok' => $modKelompok), true);
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
     * Mengatur dropdown ruangan berdasarkan instalasi yang dipilih
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if ($model_nama !== '' && $attr == '') {
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            } else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            } else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(RuanganM::model()->findAllByAttributes(array("instalasi_id" => $instalasi_id), "ruangan_aktif = true"), 'ruangan_id', 'ruangan_nama');
            if ($encode) {
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                if (count($models) > 0) {
                    foreach ($models as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk mencetak data
     */
    public function actionPrint() {
        $model = new InsidenrsT();

        if (isset($_GET['InsidenrsT'])) {
            $model->attributes = $_GET['InsidenrsT'];
            $model->no_rekammedik = $_GET['InsidenrsT']['no_rekammedik'];
            $model->instalasi_id = isset($_GET['InsidenrsT']['instalasi_id']) ? $_GET['InsidenrsT']['instalasi_id'] : null;
            $model->ruangan_id = isset($_GET['InsidenrsT']['ruangan_id']) ? $_GET['InsidenrsT']['ruangan_id'] : null;
            $model->gradingrisiko = isset($_GET['InsidenrsT']['gradingrisiko']) ? $_GET['InsidenrsT']['gradingrisiko'] : null;
            $model->status_laporan = isset($_GET['InsidenrsT']['status_laporan']) ? $_GET['InsidenrsT']['status_laporan'] : null;
            $model->tanggal_awal = isset($_GET['InsidenrsT']['tanggal_awal']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_awal']) : null;
            $model->tanggal_akhir = isset($_GET['InsidenrsT']['tanggal_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_akhir']) : null;
            $model->tanggal_awal2 = isset($_GET['InsidenrsT']['tanggal_awal2']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_awal2']) : null;
            $model->tanggal_akhir2 = isset($_GET['InsidenrsT']['tanggal_akhir2']) ? MyFormatter::formatDateTimeForDb($_GET['InsidenrsT']['tanggal_akhir2']) : null;
            $model->tipeLapor = isset($_GET['InsidenrsT']['tipeLapor']) ? $_GET['InsidenrsT']['tipeLapor'] : 1;
            $model->tipeInsiden = isset($_GET['InsidenrsT']['tipeInsiden']) ? $_GET['InsidenrsT']['tipeInsiden'] : 0;
        }


        $judulLaporan = 'Data Laporan Insiden';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = InsidenrsT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteRecord($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            if (InsidenrsdetT::model()->deleteAllByAttributes(array('insidenrs_id' => $id)) && $this->loadModel($id)->delete()) {
                $data['sukses'] = 1;
            } else if (InsidenrsdetT::model()->deleteAllByAttributes(array('insidenrs_id' => $id)) || $this->loadModel($id)->delete()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Halaman untuk pembatalan 
     * @param type $insidenrs_id
     */
    public function actionBatal($insidenrs_id) {
        $this->layout = '//layouts/iframe';
        $model = InsidenrsT::model()->findByPk($insidenrs_id);

        $this->render('_batal', array('model' => $model));
    }

    public function actionSubmitBatal() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = true;
        $data['status'] = 0;
        $data['pesan'] = "Pembatalan Berhasil Dilakukan. ";
        $id = $_POST['id'];
        $model = InsidenrsT::model()->findByPk($id);
        $model->alasanpembatalan = $_POST['alasan'];
        $model->is_batal = true;
        $model->pegawai_pembatalan_id = Yii::app()->user->getState('pegawai_id');

        $lokasiKejadian = RuanganM::model()->findByPk($model->lokasikejadian_id);
        $namaLokasi = $lokasiKejadian->ruangan_nama;
        $judul = "Pembatalan Pelaporan Insiden";
        $isi = "Laporan Insiden " . $model->insidenrs_nama . " di ruangan " . $namaLokasi . " telah dibatalkan karena " . $model->alasanpembatalan;
        $ruangan_id = Params::RUANGAN_ID_KMKP;
        $r = RuanganM::model()->findByPk($ruangan_id);

        $notif = new NotifikasiR;
        $notif->instalasi_id = $r->instalasi_id;
        $notif->modul_id = Yii::app()->user->getState('modul_id');
        $notif->tglnotifikasi = date('Y-m-d H:i:s');
        $notif->judulnotifikasi = $judul;
        $notif->isinotifikasi = $isi;
        $notif->create_time = date('Y-m-d H:i:s');
        $notif->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $notif->create_ruangan = $r->ruangan_id;

        $ok = $ok && $model->save() && $notif->save();
        if ($ok) {
            $data['status'] = 1;
            $data['pesan'] = "Pembatalan Berhasil Dilakukan. ";
        } else {
            $data['status'] = 0;
            $data['pesan'] = "Pembatalan Gagal Dilakukan. ";
        }

        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * Digunakan untuk set Tindakan berdasarkan tingkat risiko yang dipilih
     */
    public function actionSetTindakan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        echo CJSON::encode($this->loadData($_POST['tingkatrisiko_id'], $_POST['peluang'], $_POST['konsekuensi']));
    }

    /**
     * Load data risiko 
     * @param type $risiko
     * @param type $peluang
     * @param type $konsekuensi
     * @return type
     */
    public function loadData($risiko, $peluang, $konsekuensi) {
        $ok = 1;
        $msg = " ";
        $model = TingkatrisikoM::model()->findByPk($risiko);

        $modkonsekuensi = KonsekuensiM::model()->findByPk($konsekuensi);
        $konsekuensi_bobot = !empty($modkonsekuensi->konsekuensi_bobot) ? $modkonsekuensi->konsekuensi_bobot : 0;

        $modpeluang = PeluangM::model()->findByPk($peluang);
        $peluang_bobotdescriptor = !empty($modpeluang->peluang_bobotdescriptor) ? $modpeluang->peluang_bobotdescriptor : 0;

        $skor = $konsekuensi_bobot * $peluang_bobotdescriptor;

        // Jika STR tidak ditamukan maka muncul warning"
        if (empty($model)) {
            $ok = 0;
            $msg = "Tingkat risiko tidak ditemukan";

            return array('ok' => $ok, 'msg' => $msg);
        }

        $data = $model->attributes;
        return array('ok' => $ok, 'msg' => $msg, 'data' => $data, 'skor' => $skor);
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
