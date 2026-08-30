<?php

/**
 * Controller untuk Informasi Dokumen Pengadaan
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class InformasiDokumenPengadaanController extends MyAuthController {
    
    public $path_view = 'pengadaan.views.informasiDokumenPengadaan.';
    /**
     * Halaman Index untuk informasi dokumen pengadaan
     */
    public function actionIndex() {
        $model = new InformasidokumenpengadaanV();
        $period = PeriodeanggaranK::model()->find(" tahunanggaran = '".date('Y')."' ");
        $model->periodeanggaran_id = !empty($period)?$period->periodeanggaran_id:null;
        
        if (isset($_GET['InformasidokumenpengadaanV'])) {
            $model->attributes = $_GET['InformasidokumenpengadaanV'];
            if (!empty($_GET['InformasidokumenpengadaanV']['namaunitkerja'])) {
                $model->namaunitkerja = $_GET['InformasidokumenpengadaanV']['namaunitkerja'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['periodeanggaran_id'])) {
                $model->periodeanggaran_id = $_GET['InformasidokumenpengadaanV']['periodeanggaran_id'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['nama_pekerjaan'])) {
                $model->nama_pekerjaan = $_GET['InformasidokumenpengadaanV']['nama_pekerjaan'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['supplier_nama'])) {
                $model->supplier_nama = $_GET['InformasidokumenpengadaanV']['supplier_nama'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['rencanaumumpengadaan_nomor'])) {
                $model->rencanaumumpengadaan_nomor = $_GET['InformasidokumenpengadaanV']['rencanaumumpengadaan_nomor'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['persiapanpengadaan_nomor'])) {
                $model->persiapanpengadaan_nomor = $_GET['InformasidokumenpengadaanV']['persiapanpengadaan_nomor'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['nomor_dokumen'])) {
                $model->nomor_dokumen = $_GET['InformasidokumenpengadaanV']['nomor_dokumen'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['nosuratperjanjiankerja'])) {
                $model->nosuratperjanjiankerja = $_GET['InformasidokumenpengadaanV']['nosuratperjanjiankerja'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['pegawaippk_id'])) {
                $model->nama_pegawai = $_GET['InformasidokumenpengadaanV']['nama_pegawai'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['pegawaikpa_id'])) {
                $model->nama_kpa = $_GET['InformasidokumenpengadaanV']['nama_kpa'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['kode_kegiatan'])) {
                $model->kode_kegiatan = $_GET['InformasidokumenpengadaanV']['kode_kegiatan'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['koderup_final']))
            {
                if (empty($model->findAllByAttributes(array('koderup_final'=>$_GET['InformasidokumenpengadaanV']['koderup_final']))))
                {
                    $tampung = $model->findByAttributes(array('koderup_awal'=>$_GET['InformasidokumenpengadaanV']['koderup_final']));
                    $model->koderup_awal = $tampung->koderup_awal;
                    $model->koderup_final = $tampung->koderup_final;
                }
                else
                {
                    $model->koderup_final = $_GET['InformasidokumenpengadaanV']['koderup_final'];
                }
            }
        }
        $this->render($this->path_view.'index', array('model' => $model));
    }

    /**
     * Digunakan untuk mencetak data
     */
    public function actionPrint() {

        $model = new InformasidokumenpengadaanV();
        if (isset($_GET['InformasidokumenpengadaanV'])) {
            $model->attributes = $_GET['InformasidokumenpengadaanV'];
            if (!empty($_GET['InformasidokumenpengadaanV']['namaunitkerja'])) {
                $model->namaunitkerja = $_GET['InformasidokumenpengadaanV']['namaunitkerja'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['nama_pekerjaan'])) {
                $model->nama_pekerjaan = $_GET['InformasidokumenpengadaanV']['nama_pekerjaan'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['supplier_nama'])) {
                $model->supplier_nama = $_GET['InformasidokumenpengadaanV']['supplier_nama'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['rencanaumumpengadaan_nomor'])) {
                $model->rencanaumumpengadaan_nomor = $_GET['InformasidokumenpengadaanV']['rencanaumumpengadaan_nomor'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['persiapanpengadaan_nomor'])) {
                $model->persiapanpengadaan_nomor = $_GET['InformasidokumenpengadaanV']['persiapanpengadaan_nomor'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['nomor_dokumen'])) {
                $model->nomor_dokumen = $_GET['InformasidokumenpengadaanV']['nomor_dokumen'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['nosuratperjanjiankerja'])) {
                $model->nosuratperjanjiankerja = $_GET['InformasidokumenpengadaanV']['nosuratperjanjiankerja'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['pegawaippk_id'])) {
                $model->nama_pegawai = $_GET['InformasidokumenpengadaanV']['nama_pegawai'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['pegawaikpa_id'])) {
                $model->nama_kpa = $_GET['InformasidokumenpengadaanV']['nama_kpa'];
            }
            if (!empty($_GET['InformasidokumenpengadaanV']['kode_kegiatan'])) {
                $model->kode_kegiatan = $_GET['InformasidokumenpengadaanV']['kode_kegiatan'];
            }
        }

        $judulLaporan = 'Data Dokumen Pengadaan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = 'L';         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }
    
    /**
     * Digunakan untuk menampilkan halaman detail
     * @author Andyka Putra <andykaputra@.com>
     * @param type $id
     * @param type $iframe
     */
    public function actionKelengkapanKonrak($id) {
        $this->layout = '//layouts/iframe';
        
        $model = ADRencanaumumpengadaanT::model()->findByPk($id);
        $modDokumenPengadaan = InformasidokumenpengadaanV::model()->findByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modKelengkapan = KelengkapandokumenkontrakV::model()->findByAttributes(array('rencanaumumpengadaan_id' => $id), array('order' => 'pembukaanpenawaran_tanggal ASC, evaluasipenawaran_tanggal ASC, banegosiasi_tanggal ASC, bapengadaanlangsung_tanggal ASC, penetapanpemenang_tanggal ASC, pengumumanpemenang_tanggal ASC, penunjukanpenyedia_tanggal ASC, kontrak_kontrak ASC, syaratkhususkontrak_tanggal ASC, perintahmulaikerja_tanggal ASC, perintahpengiriman_tanggal ASC'));
        $modKelengkapanSurat = KelengkapandokumenkontrakV::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id), array('order' => 'pembukaanpenawaran_tanggal ASC, evaluasipenawaran_tanggal ASC, banegosiasi_tanggal ASC, bapengadaanlangsung_tanggal ASC, penetapanpemenang_tanggal ASC, pengumumanpemenang_tanggal ASC, penunjukanpenyedia_tanggal ASC, kontrak_kontrak ASC, syaratkhususkontrak_tanggal ASC, perintahmulaikerja_tanggal ASC, perintahpengiriman_tanggal ASC'));
        $this->render('_formKelengkapanKontrak', array(
            'model' => $model,
            'modDokumenPengadaan' => $modDokumenPengadaan,
            'modKelengkapan' => $modKelengkapan,
            'modKelengkapanSurat' => $modKelengkapanSurat,
        ));
    }
}
