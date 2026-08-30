<?php

/**
 * Transaksi Berita Acara Penjelasan Pengadaan Langsung
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BAPengadaanLangsungController extends MyAuthController {

    /**
     * Default menu Transaksi Penjelasan Pengadaan Langsung - Berita Acara
     * @param integer $id
     */
    public function actionIndex($id) {
        $this->layout = '//layouts/iframe';
        $modPersiapanPengadaan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
        $cekmodel = BapengadaanlangsungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));

        if (empty($cekmodel)) {
            $model = new BapengadaanlangsungT;
            $model->bapengadaanlangsung_nomor = "-Otomatis-";
            $model->bapengadaanlangsung_tanggal = date('d M Y H:i:s');
            $model->waktu_pertemuan = date('d M Y H:i:s');
            $model->kehadiran_pejabat = 0;
            $model->kehadiran_penyedia = 0;

            $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            $model->supplier_id = !empty($cekPenawaran) ? $cekPenawaran->supplier_id : null;
            $model->supplier_nama = !empty($cekPenawaran) ? $cekPenawaran->supplier->supplier_nama : '';
            $model->alamat_supplier = !empty($cekPenawaran) ? $cekPenawaran->supplier->supplier_alamat : '';
            $model->nama_direktur = !empty($cekPenawaran) ? $cekPenawaran->supplier->direktursupplier : '';

            $cekInformasiUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekInformasiUmum->pegpengadaan_id)) {
                $model->pegpengadaan_id = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan_id : null;
                $model->pejabat_pengadaan = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan->namaLengkap : '';
                $model->pejabat_pengadaan_nip = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan->nomorindukpegawai : '';
                $model->jabatan_pengadaan = !empty($cekInformasiUmum) ? $cekInformasiUmum->jabatan_pengadaan : '';
                $model->nomor_sk = !empty($cekInformasiUmum) ? $cekInformasiUmum->no_sk : '';
                $model->tanggal_sk = !empty($cekInformasiUmum) ? date('d M Y', strtotime($cekInformasiUmum->tgl_sk)) : '';
            }
            
            $cekEvaluasi = EvaluasipenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            $model->harga_penawaran = !empty($cekEvaluasi->harga_penawaran) ? number_format($cekEvaluasi->harga_penawaran, 2, ",", ".") : number_format(0, 2, ",", ".");
            $model->harga_terkoreksi = !empty($cekEvaluasi->harga_terkoreksi) ? number_format($cekEvaluasi->harga_terkoreksi, 2, ",", ".") : number_format(0, 2, ",", ".");
            
            $cekNegosiasi = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            $model->total_negosiasi = !empty($cekNegosiasi->pembulatan_negosiasi) ? number_format($cekNegosiasi->pembulatan_negosiasi, 2, ",", ".") : number_format(0, 2, ",", ".");
            
        } else {
            $model = BapengadaanlangsungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            $model->bapengadaanlangsung_tanggal = date('d M Y H:i:s', strtotime($model->bapengadaanlangsung_tanggal));
            $model->waktu_pertemuan = date('d M Y H:i:s', strtotime($model->waktu_pertemuan));
            $model->supplier_nama = $model->supplier->supplier_nama;
            $model->alamat_supplier = $model->supplier->supplier_alamat;
            $model->nama_direktur = $model->direktur_supplier;
            
            if (!empty($model->pegpengadaan_id)) {
                $model->pejabat_pengadaan = $model->pegpengadaan->namaLengkap;
                $model->pejabat_pengadaan_nip = $model->pegpengadaan->nomorindukpegawai;
                $model->tanggal_sk = date('d M Y', strtotime($model->tanggal_sk));
            }
            
            $cekEvaluasi = EvaluasipenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            $harga_penawaran = !empty($cekEvaluasi->harga_penawaran) ? number_format($cekEvaluasi->harga_penawaran, 2, ",", ".") : number_format(0, 2, ",", ".");
            $harga_terkoreksi = !empty($cekEvaluasi->harga_terkoreksi) ? number_format($cekEvaluasi->harga_terkoreksi, 2, ",", ".") : number_format(0, 2, ",", ".");
            
            $cekNegosiasi = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));
            $total_negosiasi = !empty($cekNegosiasi->pembulatan_negosiasi) ? number_format($cekNegosiasi->pembulatan_negosiasi, 2, ",", ".") : number_format(0, 2, ",", ".");
            
            $model->harga_penawaran = !empty($model->harga_penawaran) ? number_format($model->harga_penawaran, 2, ",", ".") : $harga_penawaran;
            $model->harga_terkoreksi = !empty($model->harga_terkoreksi) ? number_format($model->harga_terkoreksi, 2, ",", ".") : $harga_terkoreksi;
            $model->total_negosiasi = !empty($model->total_negosiasi) ? number_format($model->total_negosiasi, 2, ",", ".") : $total_negosiasi;
        }

        if (isset($_POST['BapengadaanlangsungT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['BapengadaanlangsungT'];
                $model->persiapanpengadaan_id = $id;
                $model->bapengadaanlangsung_tanggal = MyFormatter::formatDateTimeForDb($_POST['BapengadaanlangsungT']['bapengadaanlangsung_tanggal']);
                $model->direktur_supplier = $_POST['BapengadaanlangsungT']['nama_direktur'];
                $model->tanggal_sk = !empty($_POST['BapengadaanlangsungT']['tanggal_sk']) ? MyFormatter::formatDateTimeForDb($_POST['BapengadaanlangsungT']['tanggal_sk']) : null;
                $model->waktu_pertemuan = MyFormatter::formatDateTimeForDb($_POST['BapengadaanlangsungT']['waktu_pertemuan']);
                $model->nama_pekerjaan = $modPersiapanPengadaan->nama_pekerjaan;
                $model->harga_penawaran = $_POST['BapengadaanlangsungT']['harga_penawaran'];
                $model->harga_terkoreksi = $_POST['BapengadaanlangsungT']['harga_terkoreksi'];
                $model->total_negosiasi = $_POST['BapengadaanlangsungT']['total_negosiasi'];

                if (empty($model->bapengadaanlangsung_id)) {
                    $model->bapengadaanlangsung_nomor = MyGenerator::NoBAPengadaanLangsung();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if(!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->bapengadaanlangsung_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathBaPengadaanDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathBaPengadaanDirectory())){
                        mkdir(Params::pathBaPengadaanDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = BapengadaanlangsungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }

                $ok = $ok && $model->save();

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $model->persiapanpengadaan_id, 'bapengadaanlangsung_id' => $model->bapengadaanlangsung_id, 'sukses' => 1));
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
            'modPersiapanPengadaan' => $modPersiapanPengadaan,
        ));
    }

    /**
     * Cetak Transaksi Berita Acara Pengadaan Langsung
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = BapengadaanlangsungT::model()->findByPk($id);

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_id=".$model->konfigtemplatesurat_id);
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{ba_hari}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->waktu_pertemuan)))), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->waktu_pertemuan)))), $isiPesan);
                $isiPesan = str_replace("{{ba_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->waktu_pertemuan))), $isiPesan);
                $isiPesan = str_replace("{{ba_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->waktu_pertemuan)))), $isiPesan);
                $isiPesan = str_replace("{{waktu_pertemuan}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->waktu_pertemuan)))) . ', ' . date('d ', strtotime($model->waktu_pertemuan)) . MyFormatter::getMonthId(date('m', strtotime($model->waktu_pertemuan))) . date(' Y', strtotime($model->waktu_pertemuan)), $isiPesan);
                $isiPesan = str_replace("{{ba_tanggal_bulan_tahun}}", date('d-m-Y', strtotime($model->waktu_pertemuan)), $isiPesan);
                $isiPesan = str_replace("{{tanggal_sk}}", date('d ', strtotime($model->tanggal_sk)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_sk))) . date(' Y', strtotime($model->tanggal_sk)), $isiPesan);
                $isiPesan = str_replace("{{kehadiran_pejabat_terbilang}}", strtolower(ucwords(MyFormatter::kataTerbilang($model->kehadiran_pejabat))), $isiPesan);
                $isiPesan = str_replace("{{kehadiran_penyedia_terbilang}}", strtolower(ucwords(MyFormatter::kataTerbilang($model->kehadiran_penyedia))), $isiPesan);
                $isiPesan = str_replace("{{jam_pertemuan}}", date('H:i', strtotime($model->waktu_pertemuan)), $isiPesan);
                $isiPesan = str_replace("{{nama_pekerjaan_uppercase}}", strtoupper($model->nama_pekerjaan), $isiPesan);
                $isiPesan = str_replace("{{harga_penawaran_terbilang}}", "(". ucwords(MyFormatter::kataTerbilang($model->harga_penawaran))." Rupiah )", $isiPesan);
                $isiPesan = str_replace("{{harga_penawaran}}", number_format($model->harga_penawaran, 2, ",", "."), $isiPesan);
                $isiPesan = str_replace("{{harga_terkoreksi_terbilang}}", "(". ucwords(MyFormatter::kataTerbilang($model->harga_terkoreksi))." Rupiah )", $isiPesan);
                $isiPesan = str_replace("{{harga_terkoreksi}}", number_format($model->harga_terkoreksi, 2, ",", "."), $isiPesan);
                $isiPesan = str_replace("{{total_negosiasi_terbilang}}", "(". ucwords(MyFormatter::kataTerbilang($model->total_negosiasi))." Rupiah )", $isiPesan);
                $isiPesan = str_replace("{{total_negosiasi}}", number_format($model->total_negosiasi, 2, ",", "."), $isiPesan);
            }

            $modSupplier = SupplierM::model()->findByAttributes(array('supplier_id' => $model->supplier_id));
            $attributes = $modSupplier->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            
            $cekPembukaan = PembukaanpenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id,'isbatal' => false, 'isaddendum' => true));
            $administrasi = !empty($cekPembukaan->penawaran_administrasi) ? 'Ada' : 'Tidak Ada';
            $teknis = !empty($cekPembukaan->penawaran_teknis) ? 'Ada' : 'Tidak Ada';
            $harga = !empty($cekPembukaan->penawaran_harga) ? 'Ada' : 'Tidak Ada';
            if($administrasi == 'Ada' && $teknis == 'Ada' && $harga == 'Ada'){
                $keterangan = 'Lengkap';
            }else{
                $keterangan = 'Tidak Lengkap';
            }
            $a = '<table border="1" style="width:98%; float:right">
                    <thead>
                        <tr>
                            <td style="text-align: center" colspan="3">Penawaran</td>
                            <td style="text-align: center" rowspan="2">Keterangan</td>
                        </tr>
                        <tr>
                            <td style="text-align: center">Administrasi</td>
                            <td style="text-align: center">Teknis</td>
                            <td style="text-align: center">Harga</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center">' . $administrasi . '</td>
                            <td style="text-align: center">' . $teknis . '</td>
                            <td style="text-align: center">' . $harga . '</td>
                            <td style="text-align: center">' . $keterangan . '</td>
                        </tr>
                    </tbody>
                  </table>';
            $isiPesan = str_replace("{{tabel_pembukaanpenawaran}}", $a, $isiPesan);
            
            $cekEvaluasiPenawaran = EvaluasipenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id,'isbatal' => false, 'isaddendum' => true));
            $b = '<table border="1" style="width:98%; float:right">
                    <thead>
                        <tr>
                            <td style="text-align: center">No.</td>
                            <td style="text-align: center">Unsur Yang Dievaluasi</td>
                            <td style="text-align: center">Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>';
            if(!empty($cekEvaluasiPenawaran)){
                $cekAdministrasi = EvaluasipenawarandetT::model()->findAllByAttributes(array('evaluasipenawaran_id'=>$cekEvaluasiPenawaran->evaluasipenawaran_id, 'evaluasipenawarandet_jenis' => 'Evaluasi Administrasi'));
                $no = 1;
                foreach ($cekAdministrasi as $value) {
                    $memenuhi = !empty($value->ismemenuhi) ? 'Memenuhi Syarat' : 'Tidak Memenuhi Syarat';
                    $b .= '<tr>
                                <td style="text-align: center">' . $no++ . '. </td>
                                <td style="text-align: left">' . $value->evaluasipenawaran_nama . '</td>
                                <td style="text-align: center">' . $memenuhi . '</td>
                            </tr>';
                }
            } else {
                $no = 1;
                $cekpersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
                if (!empty($cekpersiapan)) {
                    $cekjenis = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $cekpersiapan->rencanaumumpengadaan_id));
                    $modIndikator = IndikatorevaluasipenawaranM::model()->findAllByAttributes(array('evaluasipenawaran_jenis' => 'Evaluasi Administrasi', 'jenispengadaan_id' => $cekjenis->jenispengadaan_id));

                    foreach ($modIndikator as $value) {
                        $b .= '<tr>
                                <td style="text-align: center">' . $no++ . '. </td>
                                <td style="text-align: left">' . $value->evaluasipenawaran_nama . '</td>
                                <td style="text-align: center"></td>
                            </tr>';
                    }
                }
            }
            $b .= ' </tbody>
                  </table>';
            $isiPesan = str_replace("{{tabel_penawaran}}", $b, $isiPesan);
                        
            $c = '<table border="1" style="width:98%; float:right">
                    <thead>
                        <tr>
                            <td style="text-align: center">No.</td>
                            <td style="text-align: center">Unsur Yang Dievaluasi</td>
                            <td style="text-align: center">Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>';
            if(!empty($cekEvaluasiPenawaran)){
                $cekTeknis = EvaluasipenawarandetT::model()->findAllByAttributes(array('evaluasipenawaran_id'=>$cekEvaluasiPenawaran->evaluasipenawaran_id, 'evaluasipenawarandet_jenis' => 'Evaluasi Teknis'));
                $no = 1;
                foreach ($cekTeknis as $value) {
                    $memenuhi = !empty($value->ismemenuhi) ? 'Memenuhi Syarat' : 'Tidak Memenuhi Syarat';
                    $c .= '<tr>
                                <td style="text-align: center">' . $no++ . '. </td>
                                <td style="text-align: left">' . $value->evaluasipenawaran_nama . '</td>
                                <td style="text-align: center">' . $memenuhi . '</td>
                            </tr>';
                }
            } else {
                $no = 1;
                $cekpersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
                if (!empty($cekpersiapan)) {
                    $cekjenis = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $cekpersiapan->rencanaumumpengadaan_id));
                    $modIndikator = IndikatorevaluasipenawaranM::model()->findAllByAttributes(array('evaluasipenawaran_jenis' => 'Evaluasi Teknis', 'jenispengadaan_id' => $cekjenis->jenispengadaan_id));

                    foreach ($modIndikator as $value) {
                        $c .= '<tr>
                                <td style="text-align: center">' . $no++ . '. </td>
                                <td style="text-align: left">' . $value->evaluasipenawaran_nama . '</td>
                                <td style="text-align: center"></td>
                            </tr>';
                    }
                }
            }
            
            $c .= ' </tbody>
                  </table>';
            $isiPesan = str_replace("{{tabel_teknis}}", $c, $isiPesan);
                          
            $d = '<table border="1" style="width:98%; float:right">
                    <thead>
                        <tr>
                            <td style="text-align: center">No.</td>
                            <td style="text-align: center">Unsur Yang Dievaluasi</td>
                            <td style="text-align: center">Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>';
            if(!empty($cekEvaluasiPenawaran)){
                $cekHarga = EvaluasipenawarandetT::model()->findAllByAttributes(array('evaluasipenawaran_id'=>$cekEvaluasiPenawaran->evaluasipenawaran_id, 'evaluasipenawarandet_jenis' => 'Evaluasi Harga'));
                $no = 1;
                foreach ($cekHarga as $value) {
                    $memenuhi = !empty($value->ismemenuhi) ? 'Memenuhi Syarat' : 'Tidak Memenuhi Syarat';
                    $d .= '<tr>
                                <td style="text-align: center">' . $no++ . '. </td>
                                <td style="text-align: left">' . $value->evaluasipenawaran_nama . '</td>
                                <td style="text-align: center">' . $memenuhi . '</td>
                            </tr>';
                }
            } else {
                $no = 1;
                $cekpersiapan = PersiapanpengadaanT::model()->findByPk($model->persiapanpengadaan_id);
                if (!empty($cekpersiapan)) {
                    $cekjenis = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $cekpersiapan->rencanaumumpengadaan_id));
                    $modIndikator = IndikatorevaluasipenawaranM::model()->findAllByAttributes(array('evaluasipenawaran_jenis' => 'Evaluasi Harga', 'jenispengadaan_id' => $cekjenis->jenispengadaan_id));

                    foreach ($modIndikator as $value) {
                        $d .= '<tr>
                                <td style="text-align: center">' . $no++ . '. </td>
                                <td style="text-align: left">' . $value->evaluasipenawaran_nama . '</td>
                                <td style="text-align: center"></td>
                            </tr>';
                    }
                }
            }
            
            $d .= ' </tbody>
                  </table>';
            $isiPesan = str_replace("{{tabel_kewajaranharga}}", $d, $isiPesan);
              
        }
        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model));
    }

    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = BapengadaanlangsungT::model()->findByPk($id);
        $path = Params::pathBaPengadaanDirectory()."/".$filename->dokumen_pendukung;
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
