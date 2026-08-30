<?php

/**
 * Digunakan untuk mengakses informasi laporan insiden tumpahan b3
 * 
 * @author   Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package    application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class InformasiLaporanInsidenTumpahanB3TController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $simpandetail = false;
    public $defaultAction = 'index';
    public $path_view = 'yankesMasyarakat.views.informasiLaporanInsidenTumpahanb3T.';
    public $path_detail = 'yankesMasyarakat.views.informasiLaporanInsidenTumpahanb3T.detail';
    public $path_update = 'yankesMasyarakat.views.informasiLaporanInsidenTumpahanb3T.ubah';

    /**
     * Halaman utama Informasi Laporan Insiden tumpahan b3
     */
    public function actionIndex() {
        $this->layout = '//layouts/mainNeonSidebar';

        $model = new Insidentumpahanb3T();
        $model->tanggal_awal = date("Y-m-d");
        $model->tanggal_akhir = date("Y-m-d");
        $model->tanggal_awal2 = date("Y-m-d");
        $model->tanggal_akhir2 = date("Y-m-d");
        $model->tipeLapor = "1";
        $model->tipeInsiden = "0";
        if (isset($_GET['Insidentumpahanb3T'])) {
            $model->attributes = $_GET['Insidentumpahanb3T'];
            $model->pelapor_nama = $_GET['Insidentumpahanb3T']['pelapor_nama'];
            $model->status_verifikasi = $_GET['Insidentumpahanb3T']['status_verifikasi'];
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['Insidentumpahanb3T']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['Insidentumpahanb3T']['tanggal_akhir']);
            $model->tanggal_awal2 = MyFormatter::formatDateTimeForDb($_GET['Insidentumpahanb3T']['tanggal_awal2']);
            $model->tanggal_akhir2 = MyFormatter::formatDateTimeForDb($_GET['Insidentumpahanb3T']['tanggal_akhir2']);
            $model->tipeLapor = $_GET['Insidentumpahanb3T']['tipeLapor'];
            $model->tipeInsiden = $_GET['Insidentumpahanb3T']['tipeInsiden'];
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
            $insidentumpahanb3_id = isset($_POST['insidentumpahanb3_id']) ? $_POST['insidentumpahanb3_id'] : null;
            $modInsidenTumpahanb3 = Insidentumpahanb3T::model()->findByPk($insidentumpahanb3_id);
            if (!empty($modInsidenTumpahanb3)) {
                $modInsidenTumpahanb3->tglverifikasi_pelaporan = date('Y-m-d H:i:s');
                $modInsidenTumpahanb3->update();
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
     * Detail Informasi Insiden tumpahan b3
     * @param type $insidentumpahanb3_id
     */
    public function actionDetail($insidentumpahanb3_id) {
        $this->layout = '//layouts/iframe';
        $model = Insidentumpahanb3T::model()->findByPk($insidentumpahanb3_id);
        $model->tgl_pelaporan = MyFormatter::formatDateTimeForUser($model->tgl_pelaporan);
        $model->tgl_kejadian = MyFormatter::formatDateTimeForUser($model->tgl_kejadian);
        $modPegawai = PegawaiM::model()->findByPk($model->pelapor_id);
        $model->pelapor_id = $modPegawai->pegawai_id;
        $model->pelapor_nama = $modPegawai->namaLengkap;
        $model->mengetahuipegawai_nama = $model->pegawai_mengetahui->namaLengkap;
        $modDialogUnitKerja = UnitkerjaM::model()->findByPk($model->unitkerja_kejadian_id);
        $model->unitkerja_kejadian_id = $model->unitkerja_kejadian_id;
        $model->unitkerja_kejadian_nama = $modDialogUnitKerja->namaunitkerja;
//        $model->pegawai_mengetahuikejadian_nama = !empty($model->pegawai_mengetahuikejadian_id) ? $model->pegawai_mengetahuikejadian->namaLengkap : null;

        $this->render($this->path_detail . '/index', array(
            'model' => $model
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Insidentumpahanb3T::model()->findByPk($id);     
        
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteRecord() {
        if (Yii::app()->request->isAjaxRequest) {                                 
            $trans = Yii::app()->db->beginTransaction();            
            $pesan = '';
            try{
                $id = $_POST['id'];                                                
                $cek = $this->loadModel($id);
                if ($cek->delete()){
                    $data['sukses'] = 1;
                    $trans->commit();
                }else{
                    $data['sukses'] = 0;
                    $trans->rollback();
                }                
            }catch (Exception $e) {
                $trans->rollback();
                $data['sukses'] = 0;                
                $pesan = $e->getMessage();
            }            
            $data['pesan'] = $pesan;
            echo CJSON::encode($data);
            exit;
        }
    }

}
