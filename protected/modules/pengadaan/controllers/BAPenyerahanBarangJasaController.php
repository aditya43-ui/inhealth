<?php

/**
 * Controller untuk tab Penyerahan Barang / Jasa pada Berita Acara
 * @author Aida Rahmaawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAPenyerahanBarangJasaController extends MyAuthController {

    /**
     * Load halaman index dan submit penyerahan barang / jasa
     * @param type $bapenyerahanbarangjasa_id
     */
    public function actionIndex($bapenyerahanbarangjasa_id = null) {
        $this->layout = '//layouts/iframe';
        $cekPenyerahan = BapenyerahanbarangjasaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $modSurat = SuratperjanjiankerjaT::model()->findByPk($_GET['suratperjanjiankerja_id']);
        $modDetail = new BapenyerahanbarangjasadetT;
        if ($modSurat->istermin == true) {
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
            $cekpemeriksaanpekerjaan = BapenyerahanbarangjasaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }
        if (empty($bapenyerahanbarangjasa_id)) {
            $model = new BapenyerahanbarangjasaT;
            $modSurat = SuratperjanjiankerjaT::model()->findByPk($_GET['suratperjanjiankerja_id']);
            $model->pegpihakkesatu_id = $modSurat->pejabatpembuatkomitmen_id;
            $model->pegpihakkesatu_nama = $modSurat->pejabatpembuatkomitmen->namaLengkap;
            $model->pegpihakkesatu_nip = $modSurat->pejabatpembuatkomitmen->nomorindukpegawai;
            $model->pegpihakkesatu_alamat = $modSurat->pejabatpembuatkomitmen->alamat_pegawai;
            $model->bapenyerahanbarangjasa_nomor = '-- Otomatis --';
//            $model->nomor_beritaacara = '-- Otomatis --'; // Generator nomor BA di-nonaktifkan di RSST-10126
            $model->jabatan_pihakkesatu = 'Pejabat Pembuat Komitmen RSUD Dr. Soetomo';
            $model->bapenyerahanbarangjasa_tanggal = date('d M Y H:i:s');
            $model->pernyataan = '  <table>
                                        <tbody>
                                                <tr>
                                                    <td rowspan="5" style="vertical-align:top; width:3%">1.</td>
                                                    <td colspan="3" style="vertical-align:top; width:97%">PIHAK KESATU telah menyerahkan barang sesuai dengan :</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:top; width:20%">Kontrak Nomor</td>
                                                    <td style="vertical-align:top; width:2%">:</td>
                                                    <td style="vertical-align:top; width:75%">{{nomor_dokumen}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:top; width:20%">Tanggal</td>
                                                    <td style="vertical-align:top; width:2%">:</td>
                                                    <td style="vertical-align:top; width:75%">{{tglsuratperjanjian}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:top; width:20%">Pekerjaan</td>
                                                    <td style="vertical-align:top; width:2%">:</td>
                                                    <td style="vertical-align:top; width:75%">{{nama_pekerjaan}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:top; width:20%">Penyedia</td>
                                                    <td style="vertical-align:top; width:2%">:</td>
                                                    <td style="vertical-align:top; width:75%">{{supplier_nama}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:top; width:3%">2.</td>
                                                    <td colspan="3" style="vertical-align:top; width:97%">PIHAK KEDUA telah menerima dengan baik penyerahan barang/jasa tersebut sebagaimana daftar terlampir</td>
                                                </tr>
                                        </tbody>
                                    </table>';
            if ($modSurat->istermin == true) {
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                $model->termin_ke = !empty($cekpemeriksaanpekerjaan) ? count($cekpemeriksaanpekerjaan) + 1 : 1;
                $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'urutan' => $jumlahpemeriksaan));
                if (!empty($cekTermin)) {
                    $model->terminke = $cekTermin->terminke;
                    $model->termin_persen = $cekTermin->jumlah_persen;
                }
            } else {
                $model->total_termin = 1;
                $model->termin_ke = 1;
                $model->terminke = 1;
                $model->termin_persen = 100;
            }
        } else {
            $model = BapenyerahanbarangjasaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'bapenyerahanbarangjasa_id' => $bapenyerahanbarangjasa_id));
            $model->bapenyerahanbarangjasa_tanggal = MyFormatter::formatDateTimeForUser($model->bapenyerahanbarangjasa_tanggal);
            $model->pegpihakkesatu_nama = $model->pegpihakkesatu->namaLengkap;
            $model->pegpihakkesatu_nip = $model->pegpihakkesatu->nomorindukpegawai;
            $model->pegpihakkesatu_alamat = $model->pegpihakkesatu->alamat_pegawai;
            $model->pegpihakkedua_nama = $model->pegpihakkedua->namaLengkap;
            $model->pegpihakkedua_nip = $model->pegpihakkedua->nomorindukpegawai;
            $model->pegpihakkedua_alamat = $model->pegpihakkedua->alamat_pegawai;
            if ($modSurat->istermin == true) {
                $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
                if ($model->terminke == 'I') {
                    $model->termin_ke = 1;
                } else if ($model->terminke == 'II') {
                    $model->termin_ke = 2;
                } else if ($model->terminke == 'III') {
                    $model->termin_ke = 3;
                }
            } else {
                $model->total_termin = 1;
                $model->termin_ke = 1;
            }
        }

        $modRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $model->suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
        if (isset($_POST['BapenyerahanbarangjasaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['BapenyerahanbarangjasaT'];
                $model->total_dibulatkan = $_POST['BapenyerahanbarangjasaT']['total_dibulatkan'];
                if ($modSurat->istermin == true) {
                    $model->terminke = $_POST['BapenyerahanbarangjasaT']['terminke'];
                    $model->termin_persen = $_POST['BapenyerahanbarangjasaT']['termin_persen'];
                    $model->total_pembayaran = $_POST['BapenyerahanbarangjasaT']['total_pembayaran'];
                } else {
                    $model->terminke = 'I';
                    $model->termin_persen = 100;
                    $model->total_pembayaran = $_POST['BapenyerahanbarangjasaT']['total_dibulatkan'];
                }
                if (empty($bapenyerahanbarangjasa_id)) {
                    $model->bapenyerahanbarangjasa_nomor = MyGenerator::noBAPenyerahanBarangJasa();
                    $model->bapenyerahanbarangjasa_tanggal = MyFormatter::formatDateTimeForDb($model->bapenyerahanbarangjasa_tanggal);
                    $modKPA = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSurat->kuasapenggunaanggaran_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'KPA'));
                    $modPPK = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modSurat->pejabatpembuatkomitmen_id, 'pejabatpengadaan_aktif' => true, 'jabatan_pengadaan' => 'PPK'));
                    if (!empty($modPPK)) {
                        $modPPK->kode_dokumen = !empty($modPPK->kode_dokumen) ? $modPPK->kode_dokumen : null;
                    } else {
                        $modPPK->kode_dokumen = null;
                    }

                    if (!empty($modKPA)) {
                        $modKPA->kode_dokumen = !empty($modKPA->kode_dokumen) ? $modKPA->kode_dokumen : null;
                    } else {
                        $modKPA->kode_dokumen = null;
                    } 

                    $tanggal = MyFormatter::formatDateTimeForDb(date("d m Y"));
                    $tanggalbeli = MyFormatter::formatDateTimeForDb(date("d m Y", strtotime($model->bapenyerahanbarangjasa_tanggal)));
                    if ($tanggalbeli < $tanggal) {
                        $model->isantidatir = true;
                    }
                    // Generator nomor BA di-nonaktifkan di RSST-10126
//                    $nomorsurat = MyGenerator::nomorBAPenyerahanBarangJasa($model->bapenyerahanbarangjasa_tanggal, $modKPA->kode_dokumen, $modPPK->kode_dokumen); 
//                    $model->nomor_beritaacara = $nomorsurat['nosurat'];
//                    $model->nomor_urut = $nomorsurat['nourut']; 
                    $model->nomor_urut = '000';
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                } else {
                    $model->bapenyerahanbarangjasa_tanggal = MyFormatter::formatDateTimeForDb($model->bapenyerahanbarangjasa_tanggal);
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date('Y-m-d H:i:s');
                }

                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');

                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bapenyerahanbarangjasa_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathberitaAcaraDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathberitaAcaraDirectory())){
                        mkdir(Params::pathberitaAcaraDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BapenyerahanbarangjasaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();

                if ($ok) {
                    BapenyerahanbarangjasadetT::model()->deleteAllByAttributes(array('bapenyerahanbarangjasa_id' => $model->bapenyerahanbarangjasa_id));
                }

                if (isset($_POST['BapenyerahanbarangjasadetT']) && $ok) {
                    foreach ($_POST['BapenyerahanbarangjasadetT'] as $key => $value) {
                        $modelDetail = new BapenyerahanbarangjasadetT;
                        $modelDetail->attributes = $value;
                        $modelDetail->bapenyerahanbarangjasa_id = $model->bapenyerahanbarangjasa_id;
                        $ok = $ok && $modelDetail->save();
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model, 'modRincian' => $modRincian, 'modDetail' => $modDetail, 'modSurat' => $modSurat));
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
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
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

    /**
     * Cetak transaksi penyerahan barang / jasa 
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = BapenyerahanbarangjasaT::model()->findByPk($id);
        $modSurat = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
        if (!empty($model->bapenyerahanbarangjasa_id)) {
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            if ($modSurat->istermin == true) {
                $criteria->addCondition("konfigtemplatesurat_nama LIKE 'BA Penyerahan Barang / Jasa - Termin'");
            } else {
                $criteria->addCondition("konfigtemplatesurat_nama LIKE 'BA Penyerahan Barang / Jasa'");
            }
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{ba_hari}}", MyFormatter::getDayName($model->bapenyerahanbarangjasa_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->bapenyerahanbarangjasa_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('n', strtotime($model->bapenyerahanbarangjasa_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->bapenyerahanbarangjasa_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{ba_tgl_bulan_tahun}}", date('d-m-Y', strtotime($model->bapenyerahanbarangjasa_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{jabatan_pegpihakkesatu}}", $model->jabatan_pihakkesatu, $isiPesan);
                    $isiPesan = str_replace("{{jabatan_pegpihakkedua}}", $model->jabatan_pihakkedua, $isiPesan);
                }
                $modPegawaiPertama = PegawaiM::model()->findByPk($model->pegpihakkesatu_id);
                $attributes = $modPegawaiPertama->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkesatu_nama}}", $modPegawaiPertama->namaLengkap, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkesatu_nip}}", $modPegawaiPertama->nomorindukpegawai, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkesatu_alamat}}", $modPegawaiPertama->alamat_pegawai, $isiPesan);
                }

                $modPegawaiKedua = PegawaiM::model()->findByPk($model->pegpihakkedua_id);
                $attributes = $modPegawaiKedua->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkedua_nama}}", $modPegawaiKedua->namaLengkap, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkedua_nip}}", $modPegawaiKedua->nomorindukpegawai, $isiPesan);
                    $isiPesan = str_replace("{{pegpihakkedua_alamat}}", $modPegawaiKedua->alamat_pegawai, $isiPesan);
                }

                $modSurat = SuratperjanjiankerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                $attributes = $modSurat->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_spk}}", $modSurat->nomor_dokumen, $isiPesan);
                    $isiPesan = str_replace("{{tglsuratperjanjian}}", date('d ', strtotime($modSurat->tglsuratperjanjian)) . MyFormatter::getMonthId(date('m', strtotime($modSurat->tglsuratperjanjian))) . date(' Y', strtotime($modSurat->tglsuratperjanjian)), $isiPesan);
                    $cekPersiapanPengadaan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $modSurat->persiapanpengadaan_id));
                    $namapekerjaan = !empty($cekPersiapanPengadaan) ? $cekPersiapanPengadaan->nama_pekerjaan : '';
                    $isiPesan = str_replace("{{nama_pekerjaan}}", $namapekerjaan, $isiPesan);
                    $penyedia = !empty($modSurat->supplier_id) ? $modSurat->supplier->supplier_nama : '';
                    $isiPesan = str_replace("{{supplier_nama}}", $penyedia, $isiPesan);
                }
            }
            $model->dasar = $isiPesan;
        }
        $this->render('print', array('model' => $model, 'modSurat' => $modSurat));
    }

    /**
     * Menampilkan tabel riwayat Penyerahan Barang dan Jasa
     */
    public function actionGetRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $_GET['suratperjanjiankerja_id'] = $_POST['suratperjanjiankerja_id'];
            $modRiwayat = BapenyerahanbarangjasaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']), array('order' => 'bapenyerahanbarangjasa_id'));
            $i = 1;
            $tr = '';
            foreach ($modRiwayat as $row) {
                $modPegawai = PegawaiM::model()->findByPk($row->pegpihakkesatu_id);
                $row->pegpihakkesatu_nama = $modPegawai->nama_pegawai;
                $modPjphp = PegawaiM::model()->findByPk($row->pegpihakkedua_id);
                $row->pegpihakkedua_nama = $modPjphp->nama_pegawai;
                $modSurat = SuratperjanjiankerjaT::model()->findByPk($_GET['suratperjanjiankerja_id']);
                if ($modSurat->istermin == true) {
                    $termin = $row->terminke . ' (' . $row->termin_persen . '%)';
                } else {
                    $termin = 'Non Termin';
                }
                $urlDetail = $this->createUrl('Detail', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'bapenyerahanbarangjasa_id' => $row->bapenyerahanbarangjasa_id));
                $urlEdit = $this->createUrl('Index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'bapenyerahanbarangjasa_id' => $row->bapenyerahanbarangjasa_id));
                $tr .= '<tr>';
                $tr .= '<td>' . $i . ' </td>';
                $tr .= '<td>' . CHtml::link($row->bapenyerahanbarangjasa_nomor, $urlDetail, array('title' => 'Detail', 'rel' => 'tooltip', "target" => "iframe1", "onclick" => "$('#dialogRiwayat').dialog('open');")) . '</td>';
                $tr .= '<td>' . $row->nomor_beritaacara . '</td>';
                $tr .= '<td>' . date("d M Y H:i:s", strtotime($row->bapenyerahanbarangjasa_tanggal)) . '</td>';
                $tr .= '<td>' . $termin . '</td>';
                $tr .= '<td>' . $row->pegpihakkesatu_nama . ' (' . $row->jabatan_pihakkesatu . ')</td>';
                $tr .= '<td>' . $row->pegpihakkedua_nama . ' (' . $row->jabatan_pihakkedua . ')</td>';
                $tr .= '<td>' . CHtml::link('<i class="entypo-pencil"></i>', $urlEdit, array('title' => 'Ubah Data', 'rel' => 'tooltip', 'onclick' => 'setUbahForm(' . $row->bapenyerahanbarangjasa_id, $row->suratperjanjiankerja_id . '); return false')) . '</td>';
                $tr .= '<td>' . CHtml::link('<i class="entypo-print"></i>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $row->bapenyerahanbarangjasa_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')")) . '</td>';

                $tr .= '</tr>';
                $i++;
            }

            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Halaman Detail
     * @param type $bapenyerahanbarangjasa_id
     */
    public function actionDetail($bapenyerahanbarangjasa_id = null) {
        $this->layout = '//layouts/iframe';
        $cekPenyerahan = BapenyerahanbarangjasaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $modSurat = SuratperjanjiankerjaT::model()->findByPk($_GET['suratperjanjiankerja_id']);
        $modDetail = new BapenyerahanbarangjasadetT;
        if ($modSurat->istermin == true) {
            $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
            $cekpemeriksaanpekerjaan = BapenyerahanbarangjasaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
            $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;
        }

        $model = BapenyerahanbarangjasaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'bapenyerahanbarangjasa_id' => $bapenyerahanbarangjasa_id));
        $model->bapenyerahanbarangjasa_tanggal = MyFormatter::formatDateTimeForUser($model->bapenyerahanbarangjasa_tanggal);
        $model->pegpihakkesatu_nama = $model->pegpihakkesatu->namaLengkap;
        $model->pegpihakkesatu_nip = $model->pegpihakkesatu->nomorindukpegawai;
        $model->pegpihakkesatu_alamat = $model->pegpihakkesatu->alamat_pegawai;
        $model->pegpihakkedua_nama = $model->pegpihakkedua->namaLengkap;
        $model->pegpihakkedua_nip = $model->pegpihakkedua->nomorindukpegawai;
        $model->pegpihakkedua_alamat = $model->pegpihakkedua->alamat_pegawai;
        if ($modSurat->istermin == true) {
            $model->total_termin = !empty($cekTermin) ? count($cekTermin) : 0;
            if ($model->terminke == 'I') {
                $model->termin_ke = 1;
            } else if ($model->terminke == 'II') {
                $model->termin_ke = 2;
            } else if ($model->terminke == 'III') {
                $model->termin_ke = 3;
            }
        } else {
            $model->total_termin = 1;
            $model->termin_ke = 1;
        }

        $modRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $model->suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];

        $this->render('detail', array('model' => $model, 'modRincian' => $modRincian, 'modDetail' => $modDetail, 'modSurat' => $modSurat));
    }

    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BapenyerahanbarangjasaT::model()->findByPk($id);
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
