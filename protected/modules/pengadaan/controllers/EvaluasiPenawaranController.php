<?php

/**
 * Transaksi Evaluasi Penawaran
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class EvaluasiPenawaranController extends MyAuthController {

    /**
     * Halaman Transaksi Evaluasi Penawaran
     * @param type $id
     * @param type $evaluasipenawaran_id
     */
    public function actionIndex($id, $evaluasipenawaran_id = null) {
        $this->layout = '//layouts/iframe';
        $modelDetail = new EvaluasipenawarandetT;
        $modPersiapanPengadaan = PersiapanpengadaanT::model()->findByPk($id);
        $cekmodel = EvaluasipenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        
        if (empty($cekmodel)) {
            $model = new EvaluasipenawaranT;
            $model->evaluasipenawaran_nomor = "-Otomatis-";
            $model->evaluasipenawaran_tanggal = date('d M Y H:i:s');
            $model->personalia_rapat = 'PEJABAT PENGADAAN RSUD Dr. SOETOMO Prov. JATIM';
            $model->keterangan = "Tidak Memenuhi Syarat";

            $cekInfoUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $model->supplier_id = !empty($cekInfoUmum) ? $cekInfoUmum->supplier_id : null;
            $model->supplier_nama = !empty($cekInfoUmum) ? $cekInfoUmum->supplier->supplier_nama : '';
            $model->alamat_supplier = !empty($cekInfoUmum) ? $cekInfoUmum->supplier->supplier_alamat : '';

            $cekInformasiUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));

            if (!empty($cekInformasiUmum->pegpengadaan_id)) {
                $model->pejabatpengadaan_id = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan_id : null;
                $model->pejabat_pengadaan = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan->namaLengkap : '';
                $model->pejabat_pengadaan_nip = !empty($cekInformasiUmum) ? $cekInformasiUmum->pegpengadaan->nomorindukpegawai : '';
                $model->jabatan_pengadaan = !empty($cekInformasiUmum) ? $cekInformasiUmum->jabatan_pengadaan : '';
                $model->sk_nomor = !empty($cekInformasiUmum) ? $cekInformasiUmum->no_sk : '';
                $model->sk_tanggal = !empty($cekInformasiUmum) ? date('d M Y', strtotime($cekInformasiUmum->tgl_sk)) : '';
            }

            $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $model->harga_penawaran = !empty($cekPenawaran->penawaranpenyedia_harga) ? number_format($cekPenawaran->penawaranpenyedia_harga, 2, ",", ".") : number_format(0, 2, ",", ".");
            $model->harga_terkoreksi = number_format(0, 2, ",", ".");
        } else {
            $model = EvaluasipenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $model->evaluasipenawaran_tanggal = date('d M Y H:i:s', strtotime($model->evaluasipenawaran_tanggal));
            $model->supplier_nama = $model->supplier->supplier_nama;
            $model->alamat_supplier = $model->supplier->supplier_alamat;
            $model->harga_penawaran = number_format($model->harga_penawaran, 2, ",", ".");
            $model->harga_terkoreksi = number_format($model->harga_terkoreksi, 2, ",", ".");

            if (!empty($model->pejabatpengadaan_id)) {
                $model->pejabat_pengadaan = $model->pejabatpengadaan->namaLengkap;
                $model->pejabat_pengadaan_nip = $model->pejabatpengadaan->nomorindukpegawai;
                $cekInformasiUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
                $model->jabatan_pengadaan = !empty($cekInformasiUmum) ? $cekInformasiUmum->jabatan_pengadaan : '';
                $model->sk_tanggal = date('d M Y', strtotime($model->sk_tanggal));
            }
        }

        if (isset($_POST['EvaluasipenawaranT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['EvaluasipenawaranT'];
                $model->persiapanpengadaan_id = $id;
                $model->evaluasipenawaran_tanggal = MyFormatter::formatDateTimeForDb($_POST['EvaluasipenawaranT']['evaluasipenawaran_tanggal']);
                $model->sk_tanggal = !empty($_POST['EvaluasipenawaranT']['sk_tanggal']) ? MyFormatter::formatDateTimeForDb($_POST['EvaluasipenawaranT']['sk_tanggal']) : null;
                $model->konfigtemplatesurat_id = $_POST['EvaluasipenawaranT']['konfigtemplatesurat_id'];

                if (empty($model->evaluasipenawaran_id)) {
                    $model->evaluasipenawaran_nomor = MyGenerator::NoEvaluasiPenawaran();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }

                if ($_POST['EvaluasipenawaranT']['evaluasi_administrasi'] == "Memenuhi Syarat") {
                    $model->evaluasi_administrasi = true;
                } else {
                    $model->evaluasi_administrasi = false;
                }

                if ($_POST['EvaluasipenawaranT']['evaluasi_teknis'] == "Memenuhi Syarat") {
                    $model->evaluasi_teknis = true;
                } else {
                    $model->evaluasi_teknis = false;
                }

                if ($_POST['EvaluasipenawaranT']['evaluasi_harga'] == "Memenuhi Syarat") {
                    $model->evaluasi_harga = true;
                } else {
                    $model->evaluasi_harga = false;
                }

                if ($_POST['EvaluasipenawaranT']['evaluasi_kualifikasi'] == "Memenuhi Syarat") {
                    $model->evaluasi_kualifikasi = true;
                } else {
                    $model->evaluasi_kualifikasi = false;
                }

                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');

                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if (!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->evaluasipenawaran_nomor . '.' . $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathevaluasiPenawaranDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathevaluasiPenawaranDirectory())){
                        mkdir(Params::pathevaluasiPenawaranDirectory(), 0755, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = EvaluasipenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                
                $ok = $ok && $model->save();

                $cekDokumen = EvaluasipenawarandetT::model()->findAllByAttributes(array('evaluasipenawaran_id' => $model->evaluasipenawaran_id));
                if (isset($_POST['EvaluasipenawarandetT']) && $ok) {
                    foreach ($_POST['EvaluasipenawarandetT'] as $key => $value) {
                        if (!empty($value['evaluasipenawarandet_id'])) {
                            $modUpdate = EvaluasipenawarandetT::model()->findByPk($value['evaluasipenawarandet_id']);
                            $modUpdate->attributes = $value;
                            $modUpdate->ismemenuhi = !empty($value['ismemenuhi']) ? 1 : 0;
                            $modUpdate->evaluasipenawaran_id = $model->evaluasipenawaran_id;
                            $ok = $ok && $modUpdate->save();
                        } else {
                            $modelDetail = new EvaluasipenawarandetT;
                            $modelDetail->attributes = $value;
                            $modelDetail->ismemenuhi = !empty($value['ismemenuhi']) ? 1 : 0;
                            $modelDetail->evaluasipenawaran_id = $model->evaluasipenawaran_id;
                            $ok = $ok && $modelDetail->save();
                        }
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $id, 'evaluasipenawaran_id' => $model->evaluasipenawaran_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modelDetail));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('index', array(
            'model' => $model,
            'modelDetail' => $modelDetail,
            'modPersiapanPengadaan' => $modPersiapanPengadaan,
        ));
    }

    /**
     * Cetak Transaksi Evaluasi Penawaran
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $model = EvaluasipenawaranT::model()->findByPk($id);
        $modelDetail = EvaluasipenawarandetT::model()->findAllByAttributes(array('evaluasipenawaran_id' => $id));

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        $criteria->addCondition("konfigtemplatesurat_nama = 'Evaluasi Penawaran'");
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{evaluasipenawaran_hari_terbilang}}", ucwords(MyFormatter::getDayName(date('D', strtotime($model->evaluasipenawaran_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{evaluasipenawaran_tanggal_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('d', strtotime($model->evaluasipenawaran_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{evaluasipenawaran_bulan_terbilang}}", MyFormatter::getMonthId(date('m', strtotime($model->evaluasipenawaran_tanggal))), $isiPesan);
                $isiPesan = str_replace("{{evaluasipenawaran_tahun_terbilang}}", ucwords(MyFormatter::kataTerbilang(date('Y', strtotime($model->evaluasipenawaran_tanggal)))), $isiPesan);
                $isiPesan = str_replace("{{evaluasipenawaran_tanggal}}", date('d-', strtotime($model->evaluasipenawaran_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->evaluasipenawaran_tanggal))) . date('-Y', strtotime($model->evaluasipenawaran_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{sk_tanggal}}", date('d ', strtotime($model->sk_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->sk_tanggal))) . date(' Y', strtotime($model->sk_tanggal)), $isiPesan);
            }

            $modInfo = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
            $attributes = $modInfo->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{sumberdana_nama}}", $modInfo->daftarsumberdana, $isiPesan);
                $isiPesan = str_replace("{{periodeanggaran}}", $modInfo->tahunanggaran, $isiPesan);
                $ceksumberdana = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modInfo->rencanaumumpengadaan_id));
                $cekmapping = MappingrekeninganggaranM::model()->findByPk($ceksumberdana->mappingrekeninganggaran_id);
                $isiPesan = str_replace("{{kode_rekening}}", (!empty($cekmapping->kodeanggaran) ? $cekmapping->kodeanggaran : ''), $isiPesan);
            }

            $modPersiapan = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
            $attributes = $modPersiapan->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{total_harga_seluruhnya}}", "Rp " . number_format($modPersiapan->total_hargaseluruhnya, 2, ",", "."), $isiPesan);
                $isiPesan = str_replace("{{total_harga_seluruhnya_terbilang}}", ucwords(MyFormatter::kataTerbilang($modPersiapan->total_hargaseluruhnya)) . ' Rupiah', $isiPesan);
            }

            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }

            if ($model->evaluasi_administrasi == true) {
                $evaluasi_administrasi = "Memenuhi Syarat";
            } else {
                $evaluasi_administrasi = "Tidak Memenuhi Syarat";
            }

            if ($model->evaluasi_teknis == true) {
                $evaluasi_teknis = "Memenuhi Syarat";
            } else {
                $evaluasi_teknis = "Tidak Memenuhi Syarat";
            }

            if ($model->evaluasi_harga == true) {
                $evaluasi_harga = "Memenuhi Syarat";
            } else {
                $evaluasi_harga = "Tidak Memenuhi Syarat";
            }

            if ($model->evaluasi_kualifikasi == true) {
                $evaluasi_kualifikasi = "Memenuhi Syarat";
            } else {
                $evaluasi_kualifikasi = "Tidak Memenuhi Syarat";
            }
            
            $i = 1;
            $a = '<table border="1" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align: center"> No. </th>
                            <th style="text-align: center"> Nama Perusahaan </th>
                            <th style="text-align: center"> Evaluasi Administrasi </th>
                            <th style="text-align: center"> Evaluasi Teknis </th>
                            <th style="text-align: center"> Evaluasi Harga </th>
                            <th style="text-align: center"> Evaluasi Kualifikasi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="color:black; border:1px solid black;text-align: left">' . $i++ . ' </td>
                            <td style="color:black; border:1px solid black;text-align: left">' . $model->supplier->supplier_nama . ' </td>
                            <td style="color:black; border:1px solid black;text-align: left">' . $evaluasi_administrasi . ' </td>
                            <td style="color:black; border:1px solid black;text-align: left">' . $evaluasi_teknis . ' </td>
                            <td style="color:black; border:1px solid black;text-align: left">' . $evaluasi_harga . ' </td>
                            <td style="color:black; border:1px solid black;text-align: left">' . $evaluasi_kualifikasi . ' </td>

                       </tr>
                    </tbody> 
                  </table>';

            $isiPesan = str_replace("{{tabel_hasil}}", $a, $isiPesan);
        }

        $model->isi_surat = $isiPesan;

        $this->render('print', array('model' => $model, 'modelDetail' => $modelDetail));
    }

    
    /**
     * Cetak Lampiran Transaksi Evaluasi Penawaran
     * @param type $id
     */
    public function actionPrintLampiran($id){
        $this->layout = '//layouts/printWindows';
        $model = EvaluasipenawaranT::model()->findByPk($id);
        
        $this->render('printLampiran', array('model'=>$model));
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = EvaluasipenawaranT::model()->findByPk($id);
        $path = Params::pathevaluasiPenawaranDirectory() . "/" . $filename->dokumen_pendukung;
        if (!empty($filename->dokumen_pendukung)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->dokumen_pendukung, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
        }
    }

}
