<?php
/**
 * Informasi Laporan Insiden Kebakaran
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controller
 */
class InformasiLaporanInsidenKebakaranController extends MyAuthController{
    public $path_view = 'yankesMasyarakat.views.informasiLaporanInsidenKebakaran.';
    
    /**
     * Halaman index 
     */
    public function actionIndex(){
        $model = new YKMInsidenkebakaranT();
        $model->tanggal_awal = date("Y-m-d");
        $model->tanggal_akhir = date("Y-m-d");
        $model->tanggal_awal2 = date("Y-m-d");
        $model->tanggal_akhir2 = date("Y-m-d");
        $model->tipeLapor = "1";
        $model->tipeInsiden = "0";
        if (isset($_GET['YKMInsidenkebakaranT'])) {
            $model->attributes = $_GET['YKMInsidenkebakaranT'];
            $model->status_verifikasi = $_GET['YKMInsidenkebakaranT']['status_verifikasi'];
            $model->pelapor_nama = $_GET['YKMInsidenkebakaranT']['pelapor_nama'];
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenkebakaranT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenkebakaranT']['tanggal_akhir']);
            $model->tanggal_awal2 = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenkebakaranT']['tanggal_awal2']);
            $model->tanggal_akhir2 = MyFormatter::formatDateTimeForDb($_GET['YKMInsidenkebakaranT']['tanggal_akhir2']);
            $model->tipeLapor = $_GET['YKMInsidenkebakaranT']['tipeLapor'];
            $model->tipeInsiden = $_GET['YKMInsidenkebakaranT']['tipeInsiden'];
        }
        $this->render($this->path_view.'index', array('model' => $model));
    }
    
    /**
     * Detail 
     * @param type $insidenkebakaran_id
     */
    public function actionDetail($insidenkebakaran_id){
        $this->layout = '//layouts/iframe';
        $model = YKMInsidenkebakaranT::model()->findByPk($insidenkebakaran_id);
        $model->pelapor_nama = $model->pegawai_pelapor->namaLengkap;
        $model->mengetahuipegawai_nama = $model->pegawai_mengetahui->namaLengkap;
        $model->unitkerja_kejadian_nama = !empty($model->unitkeja_kejadian_id) ? $model->unitkerja->namaunitkerja : "";
        $model->tgl_pelaporan = MyFormatter::formatDateTimeForUser($model->tgl_pelaporan);
        $model->tgl_kejadian = MyFormatter::formatDateTimeForUser($model->tgl_kejadian);
        $this->render($this->path_view.'detail', array('model' => $model));
    }
    
    /**
     * Digunakan untuk verifikasi
     */
    public function actionSetVerifikasi() {

        if (Yii::app()->request->isAjaxRequest) {
            $insidenkebakaran_id = isset($_POST['insidenkebakaran_id']) ? $_POST['insidenkebakaran_id'] : null;
            $modKebakaran = InsidenkebakaranT::model()->findByPk($insidenkebakaran_id);
            if (!empty($modKebakaran)) {
                $modKebakaran->tglverifikasi_pelaporan = date('Y-m-d H:i:s');
                $modKebakaran->update();
                $data['isverifikasi'] = true;
            } else {
                $data['isverifikasi'] = false;
                $data['pesan'] = 'Update Gagal Di Lakukan!';
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = InsidenkebakaranT::model()->findByPk($id);
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
            $modRevisi = RevisiInsidenkebakaranR::model()->findAllByAttributes(array('insidenkebakaran_id' => $id));
            if (!empty($modRevisi)) {
                $ok = RevisiInsidenkebakaranR::model()->deleteAllByAttributes(array('insidenkebakaran_id' => $id));
                if ($ok) {
                    if ($this->loadModel($id)->delete()) {
                        $data['sukses'] = 1;
                    }
                }
            } else {
                if ($this->loadModel($id)->delete()) {
                    $data['sukses'] = 1;
                }
            }
            echo CJSON::encode($data);
        }
    }
}