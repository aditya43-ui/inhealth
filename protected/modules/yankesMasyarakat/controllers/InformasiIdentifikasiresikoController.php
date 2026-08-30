<?php

/**
 * Digunakan untuk mengakses informasi identifikasi resiko
 * 
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @author   Aida Rahmawati <aidarahmawati@.com>
 * @package    application.modules.yankesMasyarakat
 * @subpackage controller
 * RSST-5696
 */
class InformasiIdentifikasiresikoController extends MyAuthController {

    public $path_view = 'yankesMasyarakat.views.informasiIdentifikasiresiko.';
    public $path_view_identifikasi = 'yankesMasyarakat.views.identifikasiresikoT.';

    /**
     * Default menu transaksi identifikasi resiko
     * @param integer $identifikasiresiko_id
     */
    public function actionIndex() {
        $model = new YKMIdentifikasiresikoT;
        $modPeriode = PerioderiskregisterM::model()->findByAttributes(array('perioderiskregister_aktif' => true), array('order' => 'periode_akhir desc'));
        $model->perioderiskregister_id = $modPeriode->perioderiskregister_id;

        if (isset($_GET['YKMIdentifikasiresikoT'])) {
            $model->attributes = $_GET['YKMIdentifikasiresikoT'];
            $model->unitkerja_id = $_GET['YKMIdentifikasiresikoT']['unitkerja_id'];
            $model->jenisriskmanajemen = $_GET['YKMIdentifikasiresikoT']['jenisriskmanajemen'];
        }
        $this->render($this->path_view . 'index', array('model' => $model));
    }

    /**
     * Load detail 
     * @param type $identifikasiresiko_id
     */
    public function actionDetail($identifikasiresiko_id) {
        $this->layout = '//layouts/iframe';
        if (!empty($identifikasiresiko_id)) {
            $model = YKMIdentifikasiresikoT::model()->findByPk($identifikasiresiko_id);

            if (!empty($model->tingkatrisiko_id)) {
                $namaresiko = TingkatrisikoM::model()->findByPk($model->tingkatrisiko_id);
                $model->tingkatrisiko_nama = $namaresiko->tingkatrisiko_nama;
            }
        }
        $this->render($this->path_view . 'detail/index', array('model' => $model));
    }
    
    /**
     * Halaman Index Petunjuk Penggunaan
     */
    public function actionLihatPetunjuk(){
        $modPetunjuk = PetunjuktransaksiM::model()->findByAttributes(array('petunjuktransaksi_type' => 'Informasi Risk Register'));
        $this->render($this->path_view_identifikasi.'/petunjuk', array('modPetunjuk' => $modPetunjuk));
    }
    
    /**
     * Batal 
     * @param type $identifikasiresiko_id
     */
    public function actionBatal($identifikasiresiko_id) {
        $this->layout = '//layouts/iframe';
        if (!empty($identifikasiresiko_id)) {
            $model = YKMIdentifikasiresikoT::model()->findByPk($identifikasiresiko_id);

            if (!empty($model->tingkatrisiko_id)) {
                $namaresiko = TingkatrisikoM::model()->findByPk($model->tingkatrisiko_id);
                $model->tingkatrisiko_nama = $namaresiko->tingkatrisiko_nama;
            }
        }
        $this->render($this->path_view . '_formBatal', array('model' => $model));
    }

    /**
     * Fungsi ajax untuk submit batal risk register
     * @throws CHttpException
     */
    public function actionAjaxUbahStatus() {
        if (Yii::app()->request->isPostRequest) {
            $keterangan = $_POST['keterangan'];
            $id = $_POST['id'];
            $grading = IdentifikasiresikoT::model()->findByAttributes(array('identifikasiresiko_id' => $id));
            $grading->pegawai_pembatalan_id = Yii::app()->user->getState('pegawai_id');
            $grading->alasanpembatalan = $keterangan;
            $grading->is_batal = true;
            $judul = "Pembatalan Risk Register";
            $isi = "Risk Register di Ruangan " . $grading->ruangan->ruangan_nama . " telah dibatalkan karena " . $grading->alasanpembatalan;
            $ruangan_id = Params::RUANGAN_ID_KMKP;
            $r = RuanganM::model()->findByPk($ruangan_id);
            $notif = new NotifikasiR;
            $notif->instalasi_id = $r->instalasi_id;
            $notif->modul_id = Yii::app()->user->getState('modul_id');
            $notif->tglnotifikasi = date('Y-m-d H:i:s');
            $notif->judulnotifikasi = $judul;
            $notif->isinotifikasi = $isi;
            $notif->create_time = date('Y-m-d H:i:s');
            $notif->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $notif->create_ruangan = $r->ruangan_id;
            $notif->save();
            if ($grading->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-success'>Pembatalan berhasil dilakukan.</div>",
                    ));
                    exit;
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'gagal_form',
                        'div' => "<div class='flash-danger'>Pembatalan gagal dilakukan.</div>",
                    ));
                    exit;
                }
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
}
