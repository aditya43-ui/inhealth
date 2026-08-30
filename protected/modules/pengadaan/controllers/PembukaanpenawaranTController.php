<?php

/**
 * Controller untuk pembukaan penawaran 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class PembukaanpenawaranTController extends MyAuthController {

    public $layout = '//layouts/iframe';

    /**
     * Halaman index untuk pembukaan penawaran
     * @param type $id
     */
    public function actionIndex($id = null) {
        $model = new ADPembukaanpenawaranT();
        $model->pembukaanpenawaran_nomor = '-- Otomatis --';
        $model->personalia_rapat = "PEJABAT PENGADAAN RSUD Dr. SOETOMO Prov. JATIM";
        $model->pembukaanpenawaran_tanggal = date('d M Y');
        $model->persiapanpengadaan_id = $id;
        $cekInformasi = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        $cekPembukaan = ADPembukaanpenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
        $model->cek_informasi = false; 
        if (!empty($cekPembukaan)) {
            $model = $cekPembukaan;
            $model->supplier_nama = $model->supplier->supplier_nama;
            $model->supplier_alamat = !empty($model->supplier->supplier_alamat) ? $model->supplier->supplier_alamat : "";
            if (!empty($model->pejabatpengadaan_id)) {
                $model->pejabatpengadaan_nama = $model->pejabatpengadaan->namaLengkap;
                $model->pejabatpengadaan_nip = $model->pejabatpengadaan->nomorindukpegawai;      
                $model->pejabatpengadaan_jabatan = $cekInformasi->jabatan_pengadaan;
                $model->sk_tanggal = !empty($model->sk_tanggal) ? MyFormatter::formatDateTimeForUser($model->sk_tanggal) : null;
            }
            $model->cek_informasi = true;
        } else {
            if (!empty($cekInformasi)) {
                $model->cek_informasi = true;
                $model->supplier_nama = $cekInformasi->supplier->supplier_nama;
                $model->supplier_alamat = !empty($cekInformasi->supplier->supplier_alamat) ? $cekInformasi->supplier->supplier_alamat : "";
                if(!empty($cekInformasi->pegpengadaan_id)){
                    $model->pejabatpengadaan_id = $cekInformasi->pegpengadaan_id;
                    $model->pejabatpengadaan_nama = $cekInformasi->pegpengadaan->namaLengkap;
                    $model->pejabatpengadaan_nip = $cekInformasi->pegpengadaan->nomorindukpegawai;
                    $model->pejabatpengadaan_jabatan = $cekInformasi->jabatan_pengadaan;
                    $model->sk_nomor = $cekInformasi->no_sk;
                    $model->sk_tanggal = !empty($cekInformasi->tgl_sk) ? MyFormatter::formatDateTimeForUser($cekInformasi->tgl_sk) : null;
                }
            }
        }

        if (isset($_POST['ADPembukaanpenawaranT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['ADPembukaanpenawaranT'];
                $model->pembukaanpenawaran_tanggal = MyFormatter::formatDateTimeForDb($model->pembukaanpenawaran_tanggal);
                $model->sk_tanggal = !empty($model->sk_tanggal) ? MyFormatter::formatDateTimeForDb($model->sk_tanggal) : null;
                $model->persiapanpengadaan_id = $id;
                $model->supplier_id = $cekInformasi->supplier_id;
                $files = $_FILES['ADPembukaanpenawaranT'];
                if (empty($cekPembukaan)) {
                    $model->pembukaanpenawaran_nomor = MyGenerator::noPembukaanPenawaran();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                    if (!empty($model->dokumen_pendukung)) {
                        $file = $model->dokumen_pendukung;
                        if (!empty($model->dokumen_pendukung)) {
                            $fullDocName = $model->pembukaanpenawaran_nomor . '.' . $model->dokumen_pendukung->getExtensionName();
                            $fullDocSource = Params::pathFilePembukaanPenawaran() . $fullDocName;
                            $model->dokumen_pendukung = $fullDocName;
                        }
                        
                        if (!file_exists(Params::pathFilePembukaanPenawaran())){
                            mkdir(Params::pathFilePembukaanPenawaran(),0775, true);
                        }
                        
                        $file->saveAs($fullDocSource);
                    }else{
                        $cekmodel = ADPembukaanpenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                        $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                    }
                } else {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                    if (!empty($model->dokumen_pendukung)) {
                        $file = $model->dokumen_pendukung;
                        if (!empty($model->dokumen_pendukung)) {
                            $fullDocName = $model->pembukaanpenawaran_nomor . '.' . $model->dokumen_pendukung->getExtensionName();
                            $fullDocSource = Params::pathFilePembukaanPenawaran() . $fullDocName;
                            $model->dokumen_pendukung = $fullDocName;
                        }
                        
                        if (!file_exists(Params::pathFilePembukaanPenawaran())){
                            mkdir(Params::pathFilePembukaanPenawaran(),0775, true);
                        }
                        
                        $file->saveAs($fullDocSource);
                    }else{
                        $cekmodel = ADPembukaanpenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                        $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                    }
                }

                $ok = $ok && $model->save();
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * Unduh file pembukaan penawaran 
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = PembukaanpenawaranT::model()->findByPk($id);
        $path = Params::pathFilePembukaanPenawaran()."/".$filename->dokumen_pendukung;
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
    
    /**
     * Cetak surat pembukaan penawaran
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = ADPembukaanpenawaranT::model()->findByPk($id);
        $a = '';
        if(!empty($model->pembukaanpenawaran_id)){
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
                    $isiPesan = str_replace("{{pembukaanpenawaran_tanggal}}", date('d-m-yy', strtotime($model->pembukaanpenawaran_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{pembukaanpenawaran_tanggal_terbilang}}", ucwords(MyFormatter::formatNumberTerbilang(date('d', strtotime($model->pembukaanpenawaran_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{pembukaanpenawaran_bulan_terbilang}}", ucwords(MyFormatter::getMonthId(date('m', strtotime($model->pembukaanpenawaran_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{pembukaanpenawaran_tahun_terbilang}}", ucwords(MyFormatter::formatNumberTerbilang(date('Y', strtotime($model->pembukaanpenawaran_tanggal)))), $isiPesan);
                    $isiPesan = str_replace("{{sk_tanggal}}", date('d-m-Y', strtotime($model->sk_tanggal)), $isiPesan);
                }
                $modInformasi = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                $attributes = $modInformasi->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                
                $modPersiapan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                $modSumberDana = PengadaansumberdanaT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $modPersiapan->rencanaumumpengadaan_id)); 
                $attributes = $modPersiapan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{sumberdana_nama}}", $modSumberDana->sumberanggaran->sumberanggarannama, $isiPesan);
                    $isiPesan = str_replace("{{kode_rekening}}", $modSumberDana->mappingrekeninganggaran->kodeanggaran, $isiPesan);
                    $isiPesan = str_replace("{{periodeanggaran}}", $modPersiapan->tahunanggaran, $isiPesan);
                    $isiPesan = str_replace("{{total_harga_seluruhnya_terbilang}}", ucwords(MyFormatter::kataTerbilang($modPersiapan->total_hargaseluruhnya))." rupiah", $isiPesan);
                    $isiPesan = str_replace("{{total_harga_seluruhnya}}", "Rp ".MyFormatter::formatNumberForPrint($modPersiapan->total_hargaseluruhnya, 2), $isiPesan);
                }
                
                $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
                $attributes = $modSupplier->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                } 
                
                $penawaran_administrasi = $model->penawaran_administrasi == 1  ? "Lengkap" : "Tidak Lengkap"; 
                $penawaran_teknis = $model->penawaran_teknis == 1  ? "Lengkap" : "Tidak Lengkap"; 
                $penawaran_harga = $model->penawaran_harga == 1  ? "Lengkap" : "Tidak Lengkap"; 
                $kualifikasi_pakta = $model->kualifikasi_pakta == 1  ? "Lengkap" : "Tidak Lengkap"; 
                $kualifikasi_form = $model->kualifikasi_form == 1  ? "Lengkap" : "Tidak Lengkap"; 
               
                $a .= '<table width="100%" border="1">
                    <tr>
                        <td style="text-align: center; vertical-align: middle" rowspan="2"> No. </td>
                        <td style="text-align: center; vertical-align: middle" rowspan="2"> Nama Perusahaan </td>
                        <td style="text-align: center; vertical-align: middle" colspan="3"> Dokumen Penawaran</td>
                        <td style="text-align: center; vertical-align: middle" colspan="2"> Dokumen Kualifikasi </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle"> Penawaran <br>  Administrasi </td>
                        <td style="text-align: center; vertical-align: middle"> Penawaran <br> Teknis </td>
                        <td style="text-align: center; vertical-align: middle"> Penawaran <br>  Harga </td>
                        <td style="text-align: center; vertical-align: middle"> Pakta <br>  Integritas </td>
                        <td style="text-align: center; vertical-align: middle"> Form Isian <br> Kualifikasi </td>
                    </tr>' .
                    '<tr>'.
                        '<td style="text-align: center"> 1. </td>' .
                        '<td style="text-align: left">'.$model->supplier->supplier_nama.'</td>'.
                        '<td style="text-align: center">'.$penawaran_administrasi.'</td>'.
                        '<td style="text-align: center">'.$penawaran_teknis.'</td>'.
                        '<td style="text-align: center">'.$penawaran_harga.'</td>'.
                        '<td style="text-align: center">'.$kualifikasi_pakta.'</td>'.
                        '<td style="text-align: center">'.$kualifikasi_form.'</td>'.
                    '</tr>';    
                    
                $isiPesan = str_replace("{{tabel_hasil}}", $a, $isiPesan);
            }
            $model->dasar=$isiPesan;
        }
        $this->render('Print', array('model' => $model));
    }
}
