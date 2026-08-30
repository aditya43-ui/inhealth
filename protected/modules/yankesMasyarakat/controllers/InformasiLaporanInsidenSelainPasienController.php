<?php

/**
 * Digunakan untuk mengakses informasi laporan insiden selain pasien
 * 
 * @author Andyka <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class InformasiLaporanInsidenSelainPasienController extends MyAuthController {

    public $simpandetail = false;
    public $defaultAction = 'index';
    public $path_view = 'yankesMasyarakat.views.informasiLaporanInsidenSelainPasien.';
    public $path_detail = 'yankesMasyarakat.views.informasiLaporanInsidenSelainPasien.detail';

    /**
     * Halaman utama Informasi Laporan Insiden
     */
    public function actionIndex() {
        $this->layout = '//layouts/mainNeonSidebar';

        $model = new InsidenrsSelainpasienT();
        $model->tanggal_awal = date("Y-m-d");
        $model->tanggal_akhir = date("Y-m-d");
        $model->tanggal_awal2 = date("Y-m-d");
        $model->tanggal_akhir2 = date("Y-m-d");
        $model->tipeLapor = "1";
        $model->tipeInsiden = "0";
        if (isset($_GET['InsidenrsSelainpasienT'])) {
            $model->attributes = $_GET['InsidenrsSelainpasienT'];
            $model->status_verifikasi = $_GET['InsidenrsSelainpasienT']['status_verifikasi'];
            $model->namakorban = $_GET['InsidenrsSelainpasienT']['namakorban'];
            $model->jeniskejadian = $_GET['InsidenrsSelainpasienT']['jeniskejadian'];
            $model->pelapor_nama = $_GET['InsidenrsSelainpasienT']['pelapor_nama'];
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_akhir']);
            $model->tanggal_awal2 = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_awal2']);
            $model->tanggal_akhir2 = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_akhir2']);
            $model->tipeLapor = $_GET['InsidenrsSelainpasienT']['tipeLapor'];
            $model->tipeInsiden = $_GET['InsidenrsSelainpasienT']['tipeInsiden'];
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * Digunakan untuk verifikasi
     */
    public function actionSetVerifikasi() {

        if (Yii::app()->request->isAjaxRequest) {
            $insidenrs_selainpasien_id = isset($_POST['insidenrs_selainpasien_id']) ? $_POST['insidenrs_selainpasien_id'] : null;
            $modInsidenrs = InsidenrsSelainpasienT::model()->findByPk($insidenrs_selainpasien_id);
            if (!empty($modInsidenrs)) {
                $modInsidenrs->tglverifikasi_pelaporan = date('Y-m-d H:i:s');
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
     * Detail Transaksi Insiden RS Selain Pasien
     * @param type $insidenrs_selainpasien_id
     */
    public function actionDetail($insidenrs_selainpasien_id) {
        $this->layout = '//layouts/iframe';
        $model = InsidenrsSelainpasienT::model()->findByPk($insidenrs_selainpasien_id);
        $model->tgl_pelaporan = MyFormatter::formatDateTimeForUser($model->tgl_pelaporan);
        $model->tgl_kejadian = MyFormatter::formatDateTimeForUser($model->tgl_kejadian);
        $modPegawai = PegawaiM::model()->findByPk($model->pelapor_id);
        $model->pelapor_id = $modPegawai->pegawai_id;
        $model->pelapor_nama = $modPegawai->namaLengkap;
        $model->pegawai_mengetahui1_nama = $model->pegawai_mengetahui1->namaLengkap;
        $model->pegawai_mengetahui2_nama = $model->pegawai_mengetahui2->namaLengkap;
        $model->unitkerja_pelapor_nama = $model->unitkerja->namaunitkerja;
        $model->pegawai_mengetahuikejadian_nama = !empty($model->pegawai_mengetahuikejadian_id) ? $model->pegawai_mengetahuikejadian->namaLengkap : null;

        $this->render($this->path_detail . '/index', array(
            'model' => $model
        ));
    }

    /**
     * Digunakan untuk mencetak data
     */
    public function actionPrint() {

        $model = new InsidenrsSelainpasienT();
        $model->tanggal_awal = date("Y-m-d");
        $model->tanggal_akhir = date("Y-m-d");
        $model->tanggal_awal2 = date("Y-m-d");
        $model->tanggal_akhir2 = date("Y-m-d");
        $model->tipeLapor = "1";
        $model->tipeInsiden = "0";
        if (isset($_GET['InsidenrsSelainpasienT'])) {
            $model->attributes = $_GET['InsidenrsSelainpasienT'];
            $model->status_verifikasi = $_GET['InsidenrsSelainpasienT']['status_verifikasi'];
            $model->namakorban = $_GET['InsidenrsSelainpasienT']['namakorban'];
            $model->jeniskejadian = $_GET['InsidenrsSelainpasienT']['jeniskejadian'];
            $model->pelapor_nama = $_GET['InsidenrsSelainpasienT']['pelapor_nama'];
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_akhir']);
            $model->tanggal_awal2 = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_awal2']);
            $model->tanggal_akhir2 = MyFormatter::formatDateTimeForDb($_GET['InsidenrsSelainpasienT']['tanggal_akhir2']);
        }

        $judulLaporan = 'Data Laporan Insiden Selain Pasien';
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
        $model = InsidenrsSelainpasienT::model()->findByPk($id);
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
            if ($this->loadModel($id)->delete()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

}
