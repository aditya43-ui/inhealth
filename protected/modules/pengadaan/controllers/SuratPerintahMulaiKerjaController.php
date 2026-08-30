<?php

/**
 * Controller untuk halaman SuratPerintah Mulai Kerja Penyedia 
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * 
 */
class SuratPerintahMulaiKerjaController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'pengadaan.views.suratPerintahMulaiKerja.';
    public $penyediaTersimpan = true;

    /**
     * untuk menampilkan halaman transaksi
     * @param type integer $id menampung persiapanpengadaan_id
     */
    public function actionIndex($id = null) {
        $this->layout = '//layouts/iframe';
        $cekPerintah = ADPerintahmulaikerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        if (!empty($cekPerintah)) {
            $cekPengumuman = ADPerintahmulaikerjaT::model()->findByAttributes(array('perintahmulaikerja_id' => $cekPerintah->perintahmulaikerja_id));
            if (!empty($cekPengumuman)) {
                $model = ADPerintahmulaikerjaT::model()->findByAttributes(array('perintahmulaikerja_id' => $cekPerintah->perintahmulaikerja_id));
                $modsurat = SuratperjanjiankerjaT::model()->findByPK($model->suratperjanjiankerja_id);
                $model->perintahmulaikerja_nomor = $model->perintahmulaikerja_nomor;
                $model->perintahmulaikerja_tanggal = MyFormatter::formatDateTimeForUser($model->perintahmulaikerja_tanggal);
                $tanggal_akhir = strtotime($modsurat->tglakhir_pekerjaan);
                $tanggal_awal = strtotime($modsurat->tglawal_pekerjaan);
                $diff = $tanggal_akhir - $tanggal_awal;
                $selisihwaktu = floor($diff / (60 * 60 * 24));
                $modsurat->tglawal_pekerjaan = ucwords(strtolower(MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modsurat->tglawal_pekerjaan)))));
                $modsurat->tglakhir_pekerjaan = ucwords(strtolower(MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modsurat->tglakhir_pekerjaan)))));
                $modsurat->tglsuratperjanjian = ucwords(strtolower(MyFormatter::formatDateTimeForUser($modsurat->tglsuratperjanjian)));
                $model->supplier_id = $model->supplier_id;
                $model->supplier_nama = !empty($model->supplier->supplier_nama) ? $model->supplier->supplier_nama : "-";
                $model->supplier_alamat = !empty($model->supplier->supplier_alamat) ? $model->supplier->supplier_alamat : "-";
                $modsurat->waktuselesai = $selisihwaktu;
            } else {
                $model = new ADPerintahmulaikerjaT();
                $model->persiapanpengadaan_id = $id;
                $model->perintahmulaikerja_tanggal = date('d M Y H:i:s');
                $model->perintahmulaikerja_nomor = '-- Otomatis --';

                if (!empty($id) && empty($model->perintahmulaikerja_id)) {
                    $criteria = new CDbCriteria;
                    $criteria->select = "t.*,to_char(t.tglawal_pekerjaan, 'DD MON YYYY') as tglawal_pekerjaan,to_char(t.tglakhir_pekerjaan, 'DD MON YYYY') as tglakhir_pekerjaan,to_char(t.tglsuratperjanjian, 'DD MON YYYY') as tglsuratperjanjian,sp.* as waktuselesai,to_char((t.tglakhir_pekerjaan - t.tglawal_pekerjaan),'DD') as waktuselesai";
                    $criteria->join = "left join supplier_m sp on t.supplier_id=sp.supplier_id";
                    $criteria->addCondition('t.isbatal is false');
                    $criteria->addCondition('t.isaddendum is true');
                    $criteria->addCondition("t.persiapanpengadaan_id=" . $id);
                    //$criteria->compare('t.persiapanpengadaan_id',$model->persiapanpengadaan_id);
                    $modtmp = SuratperjanjiankerjaT::model()->find($criteria);

                    if (!empty($modtmp)) {
                        $modsurat->namapekerjaan = !empty($modtmp->namapekerjaan) ? $modtmp->namapekerjaan : "";
                        $modsurat->noindukpegawai = !empty($modtmp->noindukpegawai) ? $modtmp->noindukpegawai : "";
                        $modsurat->alamat = !empty($modtmp->alamat) ? $modtmp->alamat : "";
                        $modsurat->waktuselesai = !empty($modtmp->waktuselesai) ? $modtmp->waktuselesai : "";
                        $model->supplier_id = !empty($modtmp->supplier_nama) ? $modtmp->supplier_nama : "";
                        $model->supplier_nama = !empty($modtmp->supplier_nama) ? $modtmp->supplier_nama : "";
                        $model->supplier_alamat = !empty($modtmp->supplier_alamat) ? $modtmp->supplier_alamat : "";
                        $model->nama_direktur = !empty($modtmp->direktursupplier) ? $modtmp->direktursupplier : "";
                        $modsurat->tglawal_pekerjaan = ucwords(strtolower(MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modtmp->tglawal_pekerjaan)))));
                        $modsurat->tglakhir_pekerjaan = ucwords(strtolower(MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modtmp->tglakhir_pekerjaan)))));
                        $modsurat->tglsuratperjanjian = (MyFormatter::formatDateTimeForUser($modtmp->tglsuratperjanjian));
                        $modsurat->noindukpegawai = !empty($modtmp->noindukpegawai) ? $modtmp->noindukpegawai : "";
                        $model->pegppk_id = !empty($modtmp->pegppk_id) ? $modtmp->pejabatpembuatkomitmen_id : "";
                    }
                }
            }
        } else {
            $model = new ADPerintahmulaikerjaT();
            $modsurat = new SuratperjanjiankerjaT();
            $model->persiapanpengadaan_id = $id;
            $model->perintahmulaikerja_tanggal = date('d M Y H:i:s');
            $model->perintahmulaikerja_nomor = '-- Otomatis --';

            if (!empty($id) && empty($model->perintahmulaikerja_id)) {
                $criteria = new CDbCriteria;
                $criteria->select = "t.*,to_char(t.tglawal_pekerjaan, 'DD MON YYYY') as tglawal_pekerjaan,to_char(t.tglakhir_pekerjaan, 'DD MON YYYY') as tglakhir_pekerjaan,to_char(t.tglsuratperjanjian, 'DD MON YYYY') as tglsuratperjanjian,sp.* as waktuselesai,to_char((t.tglakhir_pekerjaan - t.tglawal_pekerjaan),'DD') as waktuselesai";
                $criteria->join = "left join supplier_m sp on t.supplier_id=sp.supplier_id";
                $criteria->addCondition('t.isbatal is false');
                $criteria->addCondition('t.isaddendum is true');
                $criteria->addCondition("t.persiapanpengadaan_id=" . $id);
                $modtmp = SuratperjanjiankerjaT::model()->find($criteria);

                if (!empty($modtmp)) {
                    $modsurat->nosuratperjanjiankerja = !empty($modtmp->nosuratperjanjiankerja) ? $modtmp->nosuratperjanjiankerja : "";
                    $modsurat->noindukpegawai = !empty($modtmp->noindukpegawai) ? $modtmp->noindukpegawai : "";
                    $modsurat->alamat = !empty($modtmp->alamat) ? $modtmp->alamat : "";
                    $modsurat->waktuselesai = !empty($modtmp->waktuselesai) ? $modtmp->waktuselesai : "";
                    $model->supplier_id = !empty($modtmp->supplier_id) ? $modtmp->supplier_id : "";
                    $model->supplier_nama = !empty($modtmp->supplier_nama) ? $modtmp->supplier_nama : "";
                    $model->supplier_alamat = !empty($modtmp->supplier_alamat) ? $modtmp->supplier_alamat : "";
                    $model->nama_direktur = !empty($modtmp->direktursupplier) ? $modtmp->direktursupplier : "";
                    $modsurat->namapembuatkomitmen = !empty($modtmp->namapembuatkomitmen) ? $modtmp->namapembuatkomitmen : "";
                    $modsurat->tglawal_pekerjaan = ucwords(strtolower(MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modtmp->tglawal_pekerjaan)))));
                    $modsurat->tglakhir_pekerjaan = ucwords(strtolower(MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($modtmp->tglakhir_pekerjaan)))));
                    $modsurat->tglsuratperjanjian = ucwords(strtolower(MyFormatter::formatDateTimeForUser($modtmp->tglsuratperjanjian)));
                    $modsurat->noindukpegawai = !empty($modtmp->noindukpegawai) ? $modtmp->noindukpegawai : "";
                    $model->suratperjanjiankerja_id = !empty($modtmp->suratperjanjiankerja_id) ? $modtmp->suratperjanjiankerja_id : "";
                    $model->pegppk_id = !empty($modtmp->pejabatpembuatkomitmen_id) ? $modtmp->pejabatpembuatkomitmen_id : "";
                }
            }
        }

        if (isset($_POST['ADPerintahmulaikerjaT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $model->attributes = $_POST['ADPerintahmulaikerjaT'];
                $model->perintahmulaikerja_tanggal = MyFormatter::formatDateTimeForDb($model->perintahmulaikerja_tanggal);
                if (empty($cekPengumuman)) {
                    $model->perintahmulaikerja_nomor = MyGenerator::noPerintahmulaikerja();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }

                $ok = $ok && $model->save();

                if (empty($cekPengumuman)) {
                    $modSPK = SuratperjanjiankerjaT::model()->findByPK($model->suratperjanjiankerja_id);
                    if (!empty($modSPK)) {
                        $modSPK->suratperjanjiankerja_status = 'SPMK Diterbitkan';
                        $modSPK->update();
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $model->persiapanpengadaan_id, 'sukses' => 1));
                } else {

                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (CException $ex) {

                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model, 'modsurat' => $modsurat));
    }

    /**
     * Cetak Surat Perjanjian Kerja
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = ADPerintahmulaikerjaT::model()->findByAttributes(array('perintahmulaikerja_id' => $id));
        $modPengadaan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        $modsurat = SuratperjanjiankerjaT::model()->findByPK($model->suratperjanjiankerja_id);
        $model->perintahmulaikerja_nomor = $model->perintahmulaikerja_nomor;

        $tanggal_akhir = strtotime($modsurat->tglakhir_pekerjaan);
        $tanggal_awal = strtotime($modsurat->tglawal_pekerjaan);
        $diff = $tanggal_akhir - $tanggal_awal;
        $selisihwaktu = floor($diff / (60 * 60 * 24));

        $tglsuratperjanjian = $modsurat->tglsuratperjanjian;
        $modsurat->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($modsurat->tglsuratperjanjian);

        $model->supplier_id = $model->supplier_id;
        $model->supplier_nama = !empty($model->supplier->supplier_nama) ? $model->supplier->supplier_nama : "-";
        $model->supplier_alamat = !empty($model->supplier->supplier_alamat) ? $model->supplier->supplier_alamat : "-";
        $modsurat->waktuselesai = $selisihwaktu;
        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_id=" . $model->konfigtemplatesurat_id);
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{tglsuratperjanjiankerja}}", date('d ', strtotime($tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($tglsuratperjanjian))) . date(' Y', strtotime($tglsuratperjanjian)), $isiPesan);
                $isiPesan = str_replace("{{supplier_nama}}", $model->supplier_nama, $isiPesan);
                $isiPesan = str_replace("{{supplier_alamat}}", $model->supplier_alamat, $isiPesan);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{nomor_dokumen_spk}}", $modsurat->nomor_dokumen, $isiPesan);
            }
            $attributes = $modsurat->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{tglawal_pekerjaan}}", date('d ', strtotime($modsurat->tglawal_pekerjaan)) . MyFormatter::getMonthId(date('m', strtotime($modsurat->tglawal_pekerjaan))) . date(' Y', strtotime($modsurat->tglawal_pekerjaan)), $isiPesan);
                $isiPesan = str_replace("{{tglakhir_pekerjaan}}", date('d ', strtotime($modsurat->tglakhir_pekerjaan)) . MyFormatter::getMonthId(date('m', strtotime($modsurat->tglakhir_pekerjaan))) . date(' Y', strtotime($modsurat->tglakhir_pekerjaan)), $isiPesan);
                $isiPesan = str_replace("{{jangka_waktu}}", $modsurat->waktuselesai, $isiPesan);
                $isiPesan = str_replace("{{hari_terbilang}}", trim(ucwords(MyFormatter::kataTerbilang($modsurat->waktuselesai))), $isiPesan);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'modsurat' => $modsurat, 'modPengadaan' => $modPengadaan));
    }

    /**
     * digunakan untuk mendapatkan surat perjanjian pekerjaan 
     * @param type string $term menampung nama pekerjaan yang dicari
     */
    public function actionAutoCompleteGetSpk($term) {
        if (Yii::app()->request->isAjaxRequest) {
            $cr = new CDbCriteria;

            $cr->compare('lower(namapekerjaan)', strtolower($term), true);
            $cr->order = 'namapekerjaan';
            $rencana = SuratperjanjiankerjaT::model()->findAll($cr);

            $res = array();
            foreach ($rencana as $item) {
                array_push($res, array(
                    'dat' => $item->attributes,
                    'label' => $item->namapekerjaan,
                    'value' => $item->suratperjanjiankerja_id
                ));
            }

            echo CJSON::encode($res);
        }
        Yii::app()->end();
    }

    /**
     * digunakan untuk load data surat perjanjian pekerjaan dan supplier
     */
    public function actionLoadPerintah() {
        if (Yii::app()->request->isAjaxRequest) {

            $suratperjanjiankerja_id = $_POST['id'];
            $criteria = new CDbCriteria;
            $criteria->select = "t.*,to_char(t.tglawal_pekerjaan, 'DD MON YYYY') as tglawal_pekerjaan,to_char(t.tglakhir_pekerjaan, 'DD MON YYYY') as tglakhir_pekerjaan,to_char(t.tglsuratperjanjian, 'DD MON YYYY') as tglsuratperjanjian,sp.* as waktuselesai,to_char((t.tglakhir_pekerjaan - t.tglawal_pekerjaan),'DD') as waktuselesai";
            $criteria->join = "left join supplier_m sp on t.supplier_id=sp.supplier_id";
            $criteria->addCondition('suratperjanjiankerja_id=' . $suratperjanjiankerja_id);

            $perintah = SuratperjanjiankerjaT::model()->find($criteria);

            $res['perintah'] = $perintah->attributes;

            $res['tglsuratperjanjian'] = MyFormatter::formatDateTimeForUser($perintah->tglsuratperjanjian);
            $res['supplier_nama'] = $perintah->supplier_nama;
            $res['supplier_alamat'] = $perintah->supplier_alamat;
            $res['direktursupplier'] = $perintah->direktursupplier;
            $tanggal_akhir = strtotime($perintah->tglakhir_pekerjaan);
            $tanggal_awal = strtotime($perintah->tglawal_pekerjaan);
            $diff = $tanggal_akhir - $tanggal_awal;
            $selisihwaktu = floor($diff / (60 * 60 * 24));
            $res['waktuselesai'] = $selisihwaktu;

            echo CJSON::encode($res);
        }
        Yii::app()->end();
    }

}
