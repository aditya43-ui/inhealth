<?php

/**
 * Digunakan sebagai informasi nota dinas PPTK
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class InformasiNotadinaspptkController extends MyAuthController {

    /**
     * Digunakan untuk menampilkan data rencana umum
     */
    public function actionIndex() {
        $model = new InformasinotadinaspptkV('searchInformasi');
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        $modPPTK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpptk_id' => Yii::app()->user->getState('pegawai_id')));
        $modPPK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegppk_id' => Yii::app()->user->getState('pegawai_id')));
        $modPJK = InformasinotadinaspptkV::model()->findAllByAttributes(array('pegpjk_id' => Yii::app()->user->getState('pegawai_id')));
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        if (!empty($modPJK)) {
            $model->pegpjk = $modPegawai->nama_pegawai;
        } else if ($modPPK) {
            $model->pegppk = $modPegawai->nama_pegawai;
        } else if ($modPPTK) {
            $model->pegpptk = $modPegawai->nama_pegawai;
        } 
            
        if (isset($_GET['InformasinotadinaspptkV'])) {
            $model->attributes = $_GET['InformasinotadinaspptkV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InformasinotadinaspptkV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InformasinotadinaspptkV']['tgl_akhir']);
            $model->notadinaspptk_nomor = $_GET['InformasinotadinaspptkV']['notadinaspptk_nomor'];
            $model->nama_pekerjaan = $_GET['InformasinotadinaspptkV']['nama_pekerjaan'];
            $model->pegpptk = !empty($_GET['InformasinotadinaspptkV']['pegpptk']) ? $_GET['InformasinotadinaspptkV']['pegpptk'] : null;
            $model->pegppk = !empty($_GET['InformasinotadinaspptkV']['pegppk']) ? $_GET['InformasinotadinaspptkV']['pegppk'] : null;
            $model->pegpjk = !empty($_GET['InformasinotadinaspptkV']['pegpjk']) ? $_GET['InformasinotadinaspptkV']['pegpjk'] : null;
            $model->nomor_notadinas = !empty($_GET['InformasinotadinaspptkV']['nomor_notadinas']) ? $_GET['InformasinotadinaspptkV']['nomor_notadinas'] : null;
        }
        $this->render('index', array(
            'model' => $model,
                )
        );
    }

    /**
     * Digunakan untuk menampilkan halaman detail
     * @param type $notadinaspptk_id
     * @param type $persiapanpengadaan_id
     */
    public function actionDetail($notadinaspptk_id) {
        $format = new MyFormatter();
        $model = NotadinaspptkT::model()->findByPk($notadinaspptk_id);
        $modDetail = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $notadinaspptk_id));
        $model->pegpptk_nama = $model->pegpptk->namaLengkap;
        $model->pegppk_nama = $model->pegppk->namaLengkap;
        $model->pegpjk_nama = $model->pegpjk->namaLengkap;
        $model->pegpjk_unitkerja = $model->pegpjk->unitkerja->namaunitkerja;
        $model->ispph22 = $model->ispph22;
        
        if (!empty($model->suratperjanjiankerja_id)) {
            $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $model->suratperjanjiankerja_id, 'kategori_pengadaan' => 'Penyedia'));
        } else {
            $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $model->rencanaumumpengadaan_id, 'kategori_pengadaan' => 'Swakelola'));
        }
        
        $model->persiapanpengadaan_nomor = $modInfo->nomor_dokumen;
        $model->tahunanggaran = $modInfo->tahun;
        $model->programkerja_nama = $modInfo->programkerja_nama;
        $model->kegiatanprogram_nama = !empty($modInfo->subprogramkerja_kode) ? $modInfo->subprogramkerja_kode . " - " . $modInfo->subprogramkerja_nama : '';
        $model->subkegiatanprogram_nama = $modInfo->subkegiatanprogram_nama;
        //Kode Rekening
        $model->koderekening = '';
        $cekRekening = MappingrekeninganggaranM::model()->findByPk($model->mappingrekeninganggaran_id);
        $model->koderekening .= !empty($cekRekening) ? $cekRekening->kodeanggaran . " - " . $cekRekening->nama_rekeninganggaran5  : ' ';

        $model->notadinaspptk_tanggal = date('d M Y', strtotime($model->notadinaspptk_tanggal));
        $model->kontrak_tanggal = date('d M Y', strtotime($model->kontrak_tanggal));
        $model->jumlah_harga = number_format($model->jumlah_harga, 2, ',', '.');
        $model->jumlah_pajak = number_format($model->jumlah_pajak, 2, ',', '.');
        $model->jumlah_diterima = number_format($model->jumlah_diterima, 2, ',', '.');
        $model->sisa_pagu = number_format($model->sisa_pagu, 2, ',', '.');
        $this->render('detail', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'format' => $format
        ));
    }

    /**
     * Fungsi Cetak
     */
    public function actionPrint() {
        $model = new InformasinotadinaspptkV;
        if (isset($_GET['InformasinotadinaspptkV'])) {
            $model->attributes = $_GET['InformasinotadinaspptkV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InformasinotadinaspptkV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InformasinotadinaspptkV']['tgl_akhir']);
            $model->notadinaspptk_nomor = $_GET['InformasinotadinaspptkV']['notadinaspptk_nomor'];
            $model->nama_pekerjaan = $_GET['InformasinotadinaspptkV']['nama_pekerjaan'];
            $model->pegpptk = !empty($_GET['InformasinotadinaspptkV']['pegpptk']) ? $_GET['InformasinotadinaspptkV']['pegpptk'] : null;
            $model->pegppk = !empty($_GET['InformasinotadinaspptkV']['pegppk']) ? $_GET['InformasinotadinaspptkV']['pegppk'] : null;
            $model->pegpjk = !empty($_GET['InformasinotadinaspptkV']['pegpjk']) ? $_GET['InformasinotadinaspptkV']['pegpjk'] : null;
            $model->nomor_notadinas = !empty($_GET['InformasinotadinaspptkV']['nomor_notadinas']) ? $_GET['InformasinotadinaspptkV']['nomor_notadinas'] : null;
        }
        $judulLaporan = 'Data Nota Dinas PPTK';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    /**
     * Cetak Nota Dinas
     * @param type $id
     */
    public function actionPrintNotadinas($id) {
        $this->layout = '//layouts/printWindows';
        $model = NotadinaspptkT::model()->findByPk($id);
        $modelDetail = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $id));

        $isiPesan = "-";
        $criteria = new CDbCriteria;
        $criteria->addCondition("konfigtemplatesurat_aktif=true");
        if (!empty($model->suratperjanjiankerja_id)) {
            $criteria->addCondition("konfigtemplatesurat_nama = 'Nota Dinas PPTK - Kontrak'");
        } else {
            $criteria->addCondition("konfigtemplatesurat_nama = 'Nota Dinas PPTK - RUP'");
        }
        $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);

        foreach ($modTemplate as $i => $templateTugas) {
            $isiPesan = $templateTugas->konfigtemplatesurat_isi;
            $isiPesan = "${isiPesan}";
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                $isiPesan = str_replace("{{notadinaspptk_tanggal}}", date('d ', strtotime($model->notadinaspptk_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->notadinaspptk_tanggal))) . date(' Y', strtotime($model->notadinaspptk_tanggal)), $isiPesan);
                $isiPesan = str_replace("{{jumlah_diterima}}", MyFormatter::formatUang($model->jumlah_diterima, "Rp.", 2), $isiPesan);
                $isiPesan = str_replace("{{jumlah_diterima_terbilang}}", ucwords(MyFormatter::kataTerbilang($model->jumlah_diterima)) ." Rupiah", $isiPesan);
            }

            if (!empty($model->suratperjanjiankerja_id)) {
                $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $model->suratperjanjiankerja_id, 'kategori_pengadaan' => 'Penyedia'));
            } else {
                $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $model->rencanaumumpengadaan_id, 'kategori_pengadaan' => 'Swakelola'));
            }
            $modMapping = MappingrekeninganggaranM::model()->findByPk($model->mappingrekeninganggaran_id);
            $attributes = $modInfo->getAttributes();
            foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
//                $isiPesan = str_replace("{{kodeanggaran}}", $modMapping->kodeanggaran, $isiPesan);
            }
            
            $modInformasi = InformasinotadinaspptkV::model()->findByAttributes(['notadinaspptk_id' => $model->notadinaspptk_id]);
            if ($modInformasi->sumberbiaya == "Subsidi") {
                $isiPesan = str_replace("{{kodeanggaran}}", $modInformasi->rekening_kecil, $isiPesan);
            } else if ($modInformasi->sumberbiaya == "Fungsional") {       
                if (!empty($modInformasi->rekening_besar)) {
                    $isiPesan = str_replace("{{kodeanggaran}}", $modInformasi->rekening_besar." - ".$modInformasi->rekening_kecil, $isiPesan);
                } else {
                    $isiPesan = str_replace("{{kodeanggaran}}", $modInformasi->rekening_kecil, $isiPesan);
                }
            }
                
                
        }
        $model->isi_surat = $isiPesan;

        $this->render('printNotadinas', array('model' => $model, 'modelDetail' => $modelDetail));
    }

    /**
     * Cetak Uraian
     * @param type $id
     */
    public function actionPrintUraian($id) {
        $this->layout = '//layouts/printWindows';
        $model = NotadinaspptkT::model()->findByPk($id);
        $modelDetail = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $id));

        $this->render('printUraian', array('model' => $model, 'modelDetail' => $modelDetail));
    }

    /**
     * Print Kuitansi
     * @param integer $id
     */
    public function actionPrintKuitansi($id) {
        $format = new MyFormatter();
        $model = NotadinaspptkT::model()->findByPk($id);

        $judul_print = '';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        // panjang : 20 -> 2cm , lebar: 118 ->11,8 cm
        $mpdf = new MyPDF('', array(100, 250));
        ob_clean();
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML(
                $this->renderPartial('printKuitansi', array(
                    'format' => $format,
                    'model' => $model,
                        ), true)
        );
        $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

}
