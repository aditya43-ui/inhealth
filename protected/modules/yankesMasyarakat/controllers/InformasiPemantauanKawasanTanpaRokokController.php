<?php
/**
 * Informasi Pemantauan Kawasan Tanpa Rokok
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controller
 */
class InformasiPemantauanKawasanTanpaRokokController extends MyAuthController {

    /**
     * Halaman Index
     */
    public function actionIndex() {
        $model = new YKMPemantauankawasantanparokokT();
        $model->tanggal_awal = date("Y-m-d");
        $model->tanggal_akhir = date("Y-m-d");
        $model->tanggal_awal2 = date("Y-m-d");
        $model->tanggal_akhir2 = date("Y-m-d");
        $model->tipeLapor = "1";
        $model->tipeInsiden = "0";
        if (isset($_GET['YKMPemantauankawasantanparokokT'])) {
            $model->attributes = $_GET['YKMPemantauankawasantanparokokT'];
            $model->status_verifikasi = $_GET['YKMPemantauankawasantanparokokT']['status_verifikasi'];
            $model->pelapor_nama = $_GET['YKMPemantauankawasantanparokokT']['pelapor_nama'];
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['YKMPemantauankawasantanparokokT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['YKMPemantauankawasantanparokokT']['tanggal_akhir']);
            $model->tanggal_awal2 = MyFormatter::formatDateTimeForDb($_GET['YKMPemantauankawasantanparokokT']['tanggal_awal2']);
            $model->tanggal_akhir2 = MyFormatter::formatDateTimeForDb($_GET['YKMPemantauankawasantanparokokT']['tanggal_akhir2']);
            $model->tipeLapor = $_GET['YKMPemantauankawasantanparokokT']['tipeLapor'];
            $model->tipeInsiden = $_GET['YKMPemantauankawasantanparokokT']['tipeInsiden'];
        }

        $this->render('index', array('model' => $model));
    }

    /**
     * Digunakan untuk verifikasi
     */
    public function actionSetVerifikasi() {

        if (Yii::app()->request->isAjaxRequest) {
            $pemantauankawasantanparokok_id = isset($_POST['pemantauankawasantanparokok_id']) ? $_POST['pemantauankawasantanparokok_id'] : null;
            $modPemantauan = PemantauankawasantanparokokT::model()->findByPk($pemantauankawasantanparokok_id);
            if (!empty($modPemantauan)) {
                $modPemantauan->tg_verifikasi = date('Y-m-d H:i:s');
                $modPemantauan->update();
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
        $model = PemantauankawasantanparokokT::model()->findByPk($id);
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
