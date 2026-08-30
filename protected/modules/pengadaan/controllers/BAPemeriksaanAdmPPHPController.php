<?php

/**
 * Transaksi Berita Acara Pemeriksaan Adm PPHP
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAPemeriksaanAdmPPHPController extends MyAuthController {

    /**
     * Default Transaksi Berita Acara Pemeriksaan Adm PPHP
     * 
     * @param type $suratperjanjiankerja_id
     * @param type $bapemeriksaanadmpphp_id
     */
    public function actionIndex($suratperjanjiankerja_id, $bapemeriksaanadmpphp_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new BapemeriksaanadmpphpT;
        $modelDetail = new BakemajuanhasilpekerjaandetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modPegPPHP = new PegpphpT;
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = BapemeriksaanadmpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
        
        if (empty($bapemeriksaanadmpphp_id)) {
            $model = new BapemeriksaanadmpphpT;
            $model->bapemeriksaanadmpphp_nomor = "-Otomatis-";
            $model->nomor_beritaacara = "-Otomatis-";
            $model->bapemeriksaanadmpphp_tanggal = date('d M Y H:i:s');
            $model->pemeriksaan_hasil = "Lengkap Tidak Sesuai/Tidak Lengkap";

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
            $model = BapemeriksaanadmpphpT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $bapemeriksaanadmpphp_id));
            $modPegawai = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
            $model->pegttdkontrak_nama = $modPegawai->nama_pegawai;
            $model->bapemeriksaanadmpphp_tanggal = !empty($model->bapemeriksaanadmpphp_tanggal) ? date('d M Y H:i:s', strtotime($model->bapemeriksaanadmpphp_tanggal)) : '';
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
        
        if (isset($_POST['BapemeriksaanadmpphpT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['BapemeriksaanadmpphpT'];
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $model->bapemeriksaanadmpphp_tanggal = MyFormatter::formatDateTimeForDb($model->bapemeriksaanadmpphp_tanggal);
                $model->tanggal_sk = MyFormatter::formatDateTimeForDb($model->tanggal_sk);
                if($modSPK->istermin == true){
                    $model->terminke = $_POST['BapemeriksaanadmpphpT']['terminke'];
                    $model->termin_persen = $_POST['BapemeriksaanadmpphpT']['termin_persen'];
                }else{
                    $model->terminke = 'I';
                    $model->termin_persen = 100;
                }
                if (!empty($model->bapemeriksaanadmpphp_id)) {
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date('Y-m-d H:i:s');
                } else {
                    $model->bapemeriksaanadmpphp_nomor = MyGenerator::noBAPemeriksaanAdmPPHP();
                    $model->nomor_beritaacara = MyGenerator::noBAPemeriksaanPPHP($model->bapemeriksaanadmpphp_tanggal);
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                }
                
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');

                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bapemeriksaanadmpphp_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BapemeriksaanadmpphpT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $bapemeriksaanadmpphp_id));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();

                $cekDokumen = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpphp_id' => $model->bapemeriksaanadmpphp_id));
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
                            $modelDetail->bapemeriksaanadmpphp_id = $model->bapemeriksaanadmpphp_id;
                            $ok = $ok && $modelDetail->save();
                        }
                    }
                }
                if (isset($_POST['PegpphpT'])) {
                    foreach ($_POST['PegpphpT'] as $i => $postDetail) {
                        if (!empty($postDetail['pegpphp_id'])) {
                            //untuk cek data sudah tersedia 
                            $jumlah = PegpphpT::model()->countByAttributes(array(
                                'pegpphp_id' => $postDetail['pegpphp_id']
                            ));

                            if ($jumlah != 0) {

                                if (!empty($model->bapemeriksaanadmpphp_id) && ($_GET['status'] = 'update')) {
                                    $modelPphp = PegpphpT::model()->findByPk($postDetail['pegpphp_id']);
                                }

                                if ($postDetail['status'] == 1) {//untuk hapus data yang sudah ada
                                    $modelPphp->delete();
                                } else { //untuk edit data baru
                                    $modelPphp->pegawai_id = $postDetail['pegawai_id'];
                                    $modelPphp->jabatan_pphp = $postDetail['jabatan_pphp'];
                                    $modelPphp->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                                    $modelPphp->bapemeriksaanadmpphp_id = $model->bapemeriksaanadmpphp_id;
                                    $ok = $ok && $modelPphp->save() && true;
                                }
                            }
                        } else {
                            $modelPphp = new PegpphpT;
                            $modelPphp->pegawai_id = $postDetail['pegawai_id'];
                            $modelPphp->jabatan_pphp = $postDetail['jabatan_pphp'];
                            $modelPphp->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                            $modelPphp->bapemeriksaanadmpphp_id = $model->bapemeriksaanadmpphp_id;
                            $ok = $ok && $modelPphp->save();
                        }
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $model->bapemeriksaanadmpphp_id, 'sukses' => 1));
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
            'modPegPPHP' => $modPegPPHP
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
            $criteria->addCondition("t.jabatan_pengadaan = 'Panitia Pemeriksa Hasil Pekerjaan'");
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
                $returnVal[$i]['nomorindukpegawai'] = $model->nomorindukpegawai;
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
            $models = PegawaiV::model()->findAll($criteria);

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
     * Cetak Transaksi Berita Acara Pemeriksaan Adm PPHP
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = BapemeriksaanadmpphpT::model()->findByPk($id);
        $modelDetail = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpphp_id' => $id));


        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'BA Hasil Pemeriksaan Administratif PPHP'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $cekPenandatangan = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{pegttdkontrak_nama}}", !empty($cekPenandatangan) ? $cekPenandatangan->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->bapemeriksaanadmpphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapemeriksaanadmpphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpphp_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapemeriksaanadmpphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-', strtotime($model->bapemeriksaanadmpphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpphp_tanggal))) . date('-Y', strtotime($model->bapemeriksaanadmpphp_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{bapemeriksaanadmpphp_tanggal}}", date('d ', strtotime($model->bapemeriksaanadmpphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpphp_tanggal))) . date(' Y', strtotime($model->bapemeriksaanadmpphp_tanggal)), $isiPesan);
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

            $cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id,'bapemeriksaanadmpphp_id' => $model->bapemeriksaanadmpphp_id));
            $a = '<table border="0" style="width:100%">';
            $no = 1;
            foreach ($cekPegpphp as $panitia) {
                $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                $a .= '<tr>
                            <td style="text-align: left">' . $no++ . '. </td>
                            <td style="text-align: left">Nama </td>
                            <td style="text-align: left"> : ' . $cekPegawai->namaLengkap . '</td>
                            <td style="text-align: left">Jabatan</td>
                            <td style="text-align: left"> : ' . $panitia->jabatan_pphp . '</td>
                        </tr>';
            }
            $a .= '</table>';
            $isiPesan = str_replace("{{panitia_pemeriksa}}", $a, $isiPesan);
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'modelDetail' => $modelDetail, 'cekSuratPerjanjian' => $cekSuratPerjanjian));
    }

    /**
     * Cetak Transaksi Berita Acara Pemeriksaan Adm PPHP - Termin
     * @param type $id
     */
    public function actionPrintTermin($id) {
        $this->layout = '//layouts/printWindows';
        $model = BapemeriksaanadmpphpT::model()->findByPk($id);
        $modelDetail = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpphp_id' => $id));


        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'BA Hasil Pemeriksaan Administratif PPHP - Termin'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $cekPenandatangan = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{pegttdkontrak_nama}}", !empty($cekPenandatangan) ? $cekPenandatangan->namaLengkap : '', $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->bapemeriksaanadmpphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapemeriksaanadmpphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpphp_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapemeriksaanadmpphp_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-', strtotime($model->bapemeriksaanadmpphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpphp_tanggal))) . date('-Y', strtotime($model->bapemeriksaanadmpphp_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{bapemeriksaanadmpphp_tanggal}}", date('d ', strtotime($model->bapemeriksaanadmpphp_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->bapemeriksaanadmpphp_tanggal))) . date(' Y', strtotime($model->bapemeriksaanadmpphp_tanggal)), $isiPesan);
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

            $cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id,'bapemeriksaanadmpphp_id' => $model->bapemeriksaanadmpphp_id));
            $a = '<table border="0" style="width:100%">';
            $no = 1;
            foreach ($cekPegpphp as $panitia) {
                $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                $a .= '<tr>
                            <td style="text-align: left">' . $no++ . '. </td>
                            <td style="text-align: left">Nama </td>
                            <td style="text-align: left"> : ' . $cekPegawai->namaLengkap . '</td>
                            <td style="text-align: left">Jabatan</td>
                            <td style="text-align: left"> : ' . $panitia->jabatan_pphp . '</td>
                        </tr>';
            }
            $a .= '</table>';
            $isiPesan = str_replace("{{panitia_pemeriksa}}", $a, $isiPesan);
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'modelDetail' => $modelDetail, 'cekSuratPerjanjian' => $cekSuratPerjanjian));
    }
    
    /**
     * Menampilkan tabel riwayat PPHP
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $suratperjanjiankerja_id = $_POST['suratperjanjiankerja_id'];
            $modRiwayat = BapemeriksaanadmpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id), array('order' => 'bapemeriksaanadmpphp_id'));
            $i = 1;
            $tr = '';
            foreach ($modRiwayat as $row) {
                $modPegawai = PegawaiM::model()->findByPk($row->pegttdkontrak_id);
                $row->pegttdkontrak_nama = $modPegawai->nama_pegawai;
                
                $pphp = '';
                $cekTimteknis = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $row->bapemeriksaanadmpphp_id));
                if (count($cekTimteknis)>0){
                    $pphp .= '<ul>';
                    foreach($cekTimteknis as $val){
                        if (!empty($val->pegpphp_id)){
                            $pphp .= '<li>'.$val->pegawai->namaLengkap.'</li>';
                        }
                    }
                    $pphp .= '</ul>';
                }else{
                    $pphp .= "-";
                }
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
                if($modSurat->istermin == true){
                    $termin = $row->terminke . ' (' . $row->termin_persen . '%)';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('printTermin', array('id' => $row->bapemeriksaanadmpphp_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }else{
                    $termin = 'Non Termin';
                    $cetak = CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $row->bapemeriksaanadmpphp_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                }
                
                $urlDetail = $this->createUrl('Detail', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $row->bapemeriksaanadmpphp_id));
                $urlEdit = $this->createUrl('Index', array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $row->bapemeriksaanadmpphp_id));
                $tr .= '<tr>';
                $tr .= '<td>' . $i . ' </td>';
                $tr .= '<td>' . Chtml::link($row->bapemeriksaanadmpphp_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip',"target"=>"iframe1", "onclick"=>"$('#dialogRiwayat').dialog('open');")).'</td>';
                $tr .= '<td>' . $row->nomor_beritaacara . '</td>';
                $tr .= '<td>' . date("d M Y H:i:s", strtotime($row->bapemeriksaanadmpphp_tanggal)) . '</td>';
                $tr .= '<td>' . $termin .'</td>';
                $tr .= '<td>' . $row->pegttdkontrak_nama . '</td>';
                $tr .= '<td>' . $pphp . '</td>';
                $tr .= '<td>' . $row->pemeriksaan_hasil . '</td>';
                $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip', 'onclick' => 'setUbahForm(' . $row->bapemeriksaanadmpphp_id, $row->suratperjanjiankerja_id . '); return false')) . '</td>';
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
     * Halaman Detail Berita Acara Pemeriksaan Adm PPHP
     * 
     * @param type $suratperjanjiankerja_id
     * @param type $bapemeriksaanadmpphp_id
     */
    public function actionDetail($suratperjanjiankerja_id, $bapemeriksaanadmpphp_id = null) {
        $this->layout = '//layouts/iframe';
        $model = new BapemeriksaanadmpphpT;
        $modelDetail = new BakemajuanhasilpekerjaandetT;
        $modSPK = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $modPegPPHP = new PegpphpT;
        if($modSPK->istermin == true){
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $cekpemeriksaanpekerjaan = BapemeriksaanadmpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
        
        if (empty($bapemeriksaanadmpphp_id)) {
            $model = new BapemeriksaanadmpphpT;
            $model->bapemeriksaanadmpphp_nomor = "-Otomatis-";
            $model->bapemeriksaanadmpphp_tanggal = date('d M Y H:i:s');
            $model->pemeriksaan_hasil = "Lengkap Tidak Sesuai/Tidak Lengkap";

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
            $model = BapemeriksaanadmpphpT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id' => $bapemeriksaanadmpphp_id));
            $modPegawai = PegawaiM::model()->findByPk($model->pegttdkontrak_id);
            $model->pegttdkontrak_nama = $modPegawai->nama_pegawai;
            $model->bapemeriksaanadmpphp_tanggal = !empty($model->bapemeriksaanadmpphp_tanggal) ? date('d M Y H:i:s', strtotime($model->bapemeriksaanadmpphp_tanggal)) : '';
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
            'modPegPPHP' => $modPegPPHP
        ));
    }

    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BapemeriksaanadmpphpT::model()->findByPk($id);
        $path = Params::pathberitaAcaraDirectory().$filename->dokumen_pendukung;
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
