<?php

/**
 * Transaksi Berita Acara Pemeriksaan Adm PjPHP
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAPemeriksaanAdmPjPHPController extends MyAuthController {

    /**
     * Halaman Transaksi Berita Acara Pemeriksaan Adm PjPHP
     * 
     * @param type $suratperjanjiankerja_id
     * @param type $bapemeriksaanadmpjphp_id
     */
    public function actionIndex($suratperjanjiankerja_id, $bapemeriksaanadmpjphp_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new BapemeriksaanadmpjphpT;
        $modelDetail = new BakemajuanhasilpekerjaandetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = BapemeriksaanadmpjphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
        
        if (empty($bapemeriksaanadmpjphp_id)) {
            $model = new BapemeriksaanadmpjphpT;
            $model->bapemeriksaanadmpjphp_nomor = "-Otomatis-";
            $model->nomor_beritaacara = "-Otomatis-";
            $model->pemeriksaan_hasil = "Lengkap Tidak Sesuai/Tidak Lengkap";
            $model->bapemeriksaanadmpjphp_tanggal = date('d M Y H:i:s');

            if (!empty($modSPK->pejabatpembuatkomitmen_id)) {
                $modPegawai = PegawaiM::model()->findByPk($modSPK->pejabatpembuatkomitmen_id);
                $model->pegttdkontrak_id = $modSPK->pejabatpembuatkomitmen_id;
                $model->pegttdkontrak_nama = $modPegawai->nama_pegawai;
            }
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan) + 1 : 1;
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'urutan' => $jumlahpemeriksaan));
                if (!empty($cekTermin)) {
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
                $model->terminke = 'I';
                $model->termin_persen = 100;
            }
        } else {
            $model = BapemeriksaanadmpjphpT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpjphp_id' => $bapemeriksaanadmpjphp_id));
            $modPegawai = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
            $model->pegttdkontrak_nama = $modPegawai->nama_pegawai;
            $modPjphp = PegawaiM::model()->findByPk($model->pegpjphp_id);
            $model->pegpjphp_nama = $modPjphp->nama_pegawai;
            $model->bapemeriksaanadmpjphp_tanggal = !empty($model->bapemeriksaanadmpjphp_tanggal) ? date('d M Y H:i:s', strtotime($model->bapemeriksaanadmpjphp_tanggal)) : '';
            $model->tanggal_sk = !empty($model->tanggal_sk) ? date('d M Y', strtotime($model->tanggal_sk)) : '' ;
            $model->pemeriksaan_hasil = $model->pemeriksaan_hasil;
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            if($modSPK->istermin == true){
                if ($model->terminke == 'I') {
                    $model->termin_ke = 1;
                } else if ($model->terminke == 'II') {
                    $model->termin_ke = 2;
                } else if ($model->terminke == 'III') {
                    $model->termin_ke = 3;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
        }
        if (isset($_POST['BapemeriksaanadmpjphpT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['BapemeriksaanadmpjphpT'];
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $model->bapemeriksaanadmpjphp_tanggal = MyFormatter::formatDateTimeForDb($model->bapemeriksaanadmpjphp_tanggal);
                $model->tanggal_sk = MyFormatter::formatDateTimeForDb($model->tanggal_sk);
                
                if($modSPK->istermin == true){
                    $model->terminke = $_POST['BapemeriksaanadmpjphpT']['terminke'];
                    $model->termin_persen = $_POST['BapemeriksaanadmpjphpT']['termin_persen'];
                }else{
                    $model->terminke = 'I';
                    $model->termin_persen = 100;
                }
                if (!empty($model->bapemeriksaanadmpjphp_id)) {
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date('Y-m-d H:i:s');
                } else {
                    $model->bapemeriksaanadmpjphp_nomor = MyGenerator::noBAPemeriksaanAdmPjPHP();
                    $model->nomor_beritaacara = MyGenerator::noBAPemeriksaanPjPHP($model->bapemeriksaanadmpjphp_tanggal);
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                }
                
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');

                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bapemeriksaanadmpjphp_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BapemeriksaanadmpjphpT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpjphp_id' => $bapemeriksaanadmpjphp_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();

                $cekDokumen = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpjphp_id' => $model->bapemeriksaanadmpjphp_id));
                if (isset($_POST['DokumenpemeriksaanadministratifT']) && $ok) {
                    foreach ($_POST['DokumenpemeriksaanadministratifT'] as $key => $value) {
                        if (!empty($cekDokumen)) {
                            foreach ($cekDokumen as $val) {
                                if ($val->dokumenpemeriksaanadministratif_id == $key) {
                                    $modUpdate = DokumenpemeriksaanadministratifT::model()->findByPk($key);
                                    $modUpdate->attributes = $value;
                                    $ok = $ok && $modUpdate->save();
                                }
                            }
                        } else {
                            $modelDetail = new DokumenpemeriksaanadministratifT;
                            $modelDetail->attributes = $value;
                            $modelDetail->bapemeriksaanadmpjphp_id = $model->bapemeriksaanadmpjphp_id;
                            $ok = $ok && $modelDetail->save();
                        }
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanadmpjphp_id' => $model->bapemeriksaanadmpjphp_id, 'sukses' => 1));
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
            'modelDetail' => $modelDetail,
            'modSPK' => $modSPK,
        ));
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
                    $criteria->addCondition("t.pegawai_id = " . $_GET['pegawai_id']);
                }
            }
            $criteria->select = "t.*, pegawai_m.*";
            $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id "
                            . "JOIN jabatan_m ON pegawai_m.jabatan_id = jabatan_m.jabatan_id "
                            . "JOIN unitkerja_m ON pegawai_m.unitkerja_id = unitkerja_m.unitkerja_id ";
            $criteria->compare('LOWER(pegawai_m.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition("t.jabatan_pengadaan = 'Pejabat Pemeriksa Hasil Pekerjaan'");
            $criteria->addCondition('t.pejabatpengadaan_aktif IS TRUE');
            
            $criteria->order = 'pegawai_m.nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PejabatpengadaanM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['no_sk'] = $model->no_sk;
                $returnVal[$i]['tgl_sk'] = date('d ', strtotime($model->tgl_sk)) . MyFormatter::getMonthId(date('m', strtotime($model->tgl_sk))) . date(' Y', strtotime($model->tgl_sk));
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pegawai
     */
    public function actionGetPenandatanganKontrak() {
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
            $models = PegawaiM::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Cetak Transaksi Berita Acara Pemeriksaan Adm PjPHP
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = BapemeriksaanadmpjphpT::model()->findByPk($id);
        $modelDetail = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpjphp_id' => $id));

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'BA Hasil Pemeriksaan Administratif PjPHP'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $cekPenandatangan = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
                $cekPjphp = PegawaiM::model()->findByPk($model->pegpjphp_id);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{pegttdkontrak_nama}}", !empty($cekPenandatangan) ? $cekPenandatangan->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{pegpjphp_nama}}", !empty($cekPjphp) ? $cekPjphp->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{pegpjphp_nip}}", !empty($cekPjphp) ? $cekPjphp->nomorindukpegawai : '', $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->bapemeriksaanadmpjphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapemeriksaanadmpjphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpjphp_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapemeriksaanadmpjphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-', strtotime($model->bapemeriksaanadmpjphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpjphp_tanggal))) . date('-Y', strtotime($model->bapemeriksaanadmpjphp_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{bapemeriksaanadmpjphp_tanggal}}", date('d ', strtotime($model->bapemeriksaanadmpjphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpjphp_tanggal))) . date(' Y', strtotime($model->bapemeriksaanadmpjphp_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{tanggal_sk}}", date('d ', strtotime($model->tanggal_sk)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_sk))) . date(' Y', strtotime($model->tanggal_sk)), $isiPesan);
            }

            $cekSuratPerjanjian = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $attributes = $cekSuratPerjanjian->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglsuratperjanjian']))) . date(' Y', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])), $isiPesan);
                $ceksupplier = !empty($cekSuratPerjanjian->supplier_id) ? $cekSuratPerjanjian->supplier->supplier_nama : '-';
                $isiPesan = str_replace("{{supplier_nama}}", $ceksupplier, $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'modelDetail' => $modelDetail, 'cekSuratPerjanjian' => $cekSuratPerjanjian));
    }
    
    /**
     * Cetak Transaksi Berita Acara Pemeriksaan Adm PjPHP - Termin
     * @param type $id
     */
    public function actionPrintTermin($id) {
        $this->layout = '//layouts/printWindows';
        $model = BapemeriksaanadmpjphpT::model()->findByPk($id);
        $modelDetail = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpjphp_id' => $id));

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'BA Hasil Pemeriksaan Administratif PjPHP - Termin'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $cekPenandatangan = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
                $cekPjphp = PegawaiM::model()->findByPk($model->pegpjphp_id);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{pegttdkontrak_nama}}", !empty($cekPenandatangan) ? $cekPenandatangan->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{pegpjphp_nama}}", !empty($cekPjphp) ? $cekPjphp->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{pegpjphp_nip}}", !empty($cekPjphp) ? $cekPjphp->nomorindukpegawai : '', $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->bapemeriksaanadmpjphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapemeriksaanadmpjphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpjphp_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapemeriksaanadmpjphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-', strtotime($model->bapemeriksaanadmpjphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpjphp_tanggal))) . date('-Y', strtotime($model->bapemeriksaanadmpjphp_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{bapemeriksaanadmpjphp_tanggal}}", date('d ', strtotime($model->bapemeriksaanadmpjphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpjphp_tanggal))) . date(' Y', strtotime($model->bapemeriksaanadmpjphp_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{tanggal_sk}}", date('d ', strtotime($model->tanggal_sk)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_sk))) . date(' Y', strtotime($model->tanggal_sk)), $isiPesan);
                $isiPesan = str_replace("{{terminke}}", $model->terminke, $isiPesan);
            }

            $cekSuratPerjanjian = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
            $attributes = $cekSuratPerjanjian->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])) . MyFormatter::getMonthId(date('m', strtotime($cekSuratPerjanjian['tglsuratperjanjian']))) . date(' Y', strtotime($cekSuratPerjanjian['tglsuratperjanjian'])), $isiPesan);
                $ceksupplier = !empty($cekSuratPerjanjian->supplier_id) ? $cekSuratPerjanjian->supplier->supplier_nama : '-';
                $isiPesan = str_replace("{{supplier_nama}}", $ceksupplier, $isiPesan);
            }
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'modelDetail' => $modelDetail, 'cekSuratPerjanjian' => $cekSuratPerjanjian));
    }

    /**
     * Menampilkan tabel riwayat PjPHP
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $suratperjanjiankerja_id = $_POST['suratperjanjiankerja_id'];
            $modRiwayat = BapemeriksaanadmpjphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id), array('order' => 'bapemeriksaanadmpjphp_id'));
            $i = 1;
            $tr = '';
            foreach ($modRiwayat as $row) {
                $modPegawai = PegawaiM::model()->findByPk($row->pegttdkontrak_id);
                $row->pegttdkontrak_nama = $modPegawai->nama_pegawai;
                $modPjphp = PegawaiM::model()->findByPk($row->pegpjphp_id);
                $row->pegpjphp_nama = $modPjphp->nama_pegawai;
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
                if($modSurat->istermin == true){
                    $termin = $row->terminke . ' (' . $row->termin_persen . '%)';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('printTermin', array('id' => $row->bapemeriksaanadmpjphp_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }else{
                    $termin = 'Non Termin';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $row->bapemeriksaanadmpjphp_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }
                
                $urlDetail = $this->createUrl('Detail', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpjphp_id' => $row->bapemeriksaanadmpjphp_id));
                $urlEdit = $this->createUrl('Index', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpjphp_id' => $row->bapemeriksaanadmpjphp_id));
                $tr .= '<tr>';
                $tr .= '<td>' . $i . ' </td>';
                $tr .= '<td>' . Chtml::link($row->bapemeriksaanadmpjphp_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"iframe1", "onclick"=>"$('#dialogRiwayat').dialog('open');")).'</td>';
                $tr .= '<td>' . $row->nomor_beritaacara . '</td>';
                $tr .= '<td>' . date("d M Y H:i:s", strtotime($row->bapemeriksaanadmpjphp_tanggal)) . '</td>';
                $tr .= '<td>' . $termin .'</td>';
                $tr .= '<td>' . $row->pegttdkontrak_nama . '</td>';
                $tr .= '<td>' . $row->pegpjphp_nama . '</td>';
                $tr .= '<td>' . $row->pemeriksaan_hasil . '</td>';
                $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip', 'onclick' => 'setUbahForm(' . $row->bapemeriksaanadmpjphp_id, $row->suratperjanjiankerja_id . '); return false')) . '</td>';
                $tr .= '<td>' . $cetak . '</td>';

                $tr .= '</tr>';
                $i++;
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Halaman Detail Berita Acara Pemeriksaan Adm PjPHP
     * 
     * @param type $suratperjanjiankerja_id
     * @param type $bapemeriksaanadmpjphp_id
     */
    public function actionDetail($suratperjanjiankerja_id, $bapemeriksaanadmpjphp_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new BapemeriksaanadmpjphpT;
        $modelDetail = new BakemajuanhasilpekerjaandetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = BapemeriksaanadmpjphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
        
        if (empty($bapemeriksaanadmpjphp_id)) {
            $model = new BapemeriksaanadmpjphpT;
            $model->bapemeriksaanadmpjphp_nomor = "-Otomatis-";
            $model->pemeriksaan_hasil = "Lengkap Tidak Sesuai/Tidak Lengkap";
            $model->bapemeriksaanadmpjphp_tanggal = date('d M Y H:i:s');

            if (!empty($modSPK->pejabatpembuatkomitmen_id)) {
                $modPegawai = PegawaiM::model()->findByPk($modSPK->pejabatpembuatkomitmen_id);
                $model->pegttdkontrak_id = $modSPK->pejabatpembuatkomitmen_id;
                $model->pegttdkontrak_nama = $modPegawai->nama_pegawai;
            }
            if($modSPK->istermin == true){
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan) + 1 : 1;
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'urutan' => $jumlahpemeriksaan));
                if (!empty($cekTermin)) {
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
                $model->terminke = 'I';
                $model->termin_persen = 100;
            }
        } else {
            $model = BapemeriksaanadmpjphpT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpjphp_id' => $bapemeriksaanadmpjphp_id));
            $modPegawai = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
            $model->pegttdkontrak_nama = $modPegawai->nama_pegawai;
            $modPjphp = PegawaiM::model()->findByPk($model->pegpjphp_id);
            $model->pegpjphp_nama = $modPjphp->nama_pegawai;
            $model->bapemeriksaanadmpjphp_tanggal = !empty($model->bapemeriksaanadmpjphp_tanggal) ? date('d M Y H:i:s', strtotime($model->bapemeriksaanadmpjphp_tanggal)) : '';
            $model->tanggal_sk = !empty($model->tanggal_sk) ? date('d M Y', strtotime($model->tanggal_sk)) : '' ;
            $model->pemeriksaan_hasil = $model->pemeriksaan_hasil;
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            if($modSPK->istermin == true){
                if ($model->terminke == 'I') {
                    $model->termin_ke = 1;
                } else if ($model->terminke == 'II') {
                    $model->termin_ke = 2;
                } else if ($model->terminke == 'III') {
                    $model->termin_ke = 3;
                }
            }else{
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
        }

        $this->render('detail', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'modSPK' => $modSPK,
        ));
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BapemeriksaanadmpjphpT::model()->findByPk($id);
        $path = Params::pathberitaAcaraDirectory()."/".$filename->dokumen_pendukung;
        if (!empty($filename->dokumen_pendukung)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->dokumen_pendukung, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));   
        }
    }
    
}
