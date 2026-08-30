<?php

/**
 * Digunakan untuk menampilkan halaman evaluasi pra anestesi 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 * @category controller
 */
class EvaluasiPraAnestesiController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.evaluasiPraAnestesi.';

    /**
     * Menampilkan halaman evaluasi Pra Anestesi
     * @param type $pendaftaran_id
     * @param type $pasienkirimkeunitlain_id
     * @param type $pasienanestesi_id
     */
    public function actionIndex($pendaftaran_id = null, $pasienkirimkeunitlain_id = null, $pasienanastesi_id = null, $frame = null) {
        if (!empty($frame)) {
            $this->layout = '//layouts/iframe';
        }
        $modEvaluasi = new EvaluasianestesiPraT;
        $modKunjungan = new PasienkirimkeunitlainV();

        if (!empty($pasienanastesi_id)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('t.pasienanastesi_id = ' . $pasienanastesi_id);
            $criteria->join = "LEFT JOIN evaluasianestesi_t ON t.pendaftaran_id = evaluasianestesi_t.pendaftaran_id";
            $criteria->select = "t.*, evaluasianestesi_t.*";
            $cekKunjungan = ATInformasipasienanestesiV::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            if (!empty($cekKunjungan)) {
                $modKunjungan = $cekKunjungan;
                $modKunjungan->pendaftaran_id = $pendaftaran_id;
                $modKunjungan->pasienanastesi_id = $cekKunjungan->pasienanastesi_id;
            }

            $modEvaluasi = EvaluasianestesiPraT::model()->findByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
        }

//                if(!empty($pendaftaran_id)) {
//                    $criteria = new CDbCriteria();
//                    $criteria->addCondition('pasienkirimkeunitlain_id = '.$pasienkirimkeunitlain_id);
//                    $criteria->join = 'LEFT JOIN pasien_m p ON t.pasien_id = p.pasien_id '
//                                    . 'LEFT JOIN pekerjaan_m pk ON p.pekerjaan_id = pk.pekerjaan_id';
//                    $criteria->select = 'p.pekerjaan_id, pk.pekerjaan_nama';
//                    $modKunjungan = PasienkirimkeunitlainV::model()->find($criteria);
//                    $modEvaluasi = EvaluasianestesiPraT::model()->findByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));                        
//
//                }

        $this->render($this->path_view . 'index', array(
            'modKunjungan' => $modKunjungan,
            'modEvaluasi' => $modEvaluasi,
        ));
    }

    /**
     * Mengurai data kunjungan berdasarkan:
     * - pasienmasukpenunjang_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();

            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;

            if (!empty($pasienkirimkeunitlain_id)) {
                $criteria->addCondition('pasienkirimkeunitlain_id =' . $pasienkirimkeunitlain_id);
            }
            $criteria->join = "LEFT JOIN pendaftaran_t ON t.pendaftaran_id = pendaftaran_t.pendaftaran_id "
                    . "LEFT JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id ";
            $criteria->select = "t.*, pendaftaran_t.*, pasien_m.*";
            $model = PasienkirimkeunitlainT::model()->find($criteria);
            $modPasien = PasienM::model()->findByPk($model->pasien_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                $returnVal['pekerjaan_nama'] = !empty($modPasien->pekerjaan_id) ? $modPasien->pekerjaan->pekerjaan_nama : "-";
            }

            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["umur"] = $model->umur;
            $returnVal["no_rekam_medik"] = $model->no_rekam_medik;
            $returnVal["nama_pasien"] = $model->nama_pasien;
            $returnVal["jeniskelamin"] = $model->jeniskelamin;
            $returnVal["alamat_pasien"] = $model->alamat_pasien;
            $returnVal["jeniskasuspenyakit_nama"] = $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
            $returnVal["kelaspelayanan_nama"] = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
            $returnVal["nama_pegawai"] = $modPendaftaran->dokter->namaLengkap;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Fungsi untuk mengecek data kunjungan 
     * Jika Evaluasi Anestesi (Tabulasi Rencana Tindakan) 
     * sudah diisi maka bisa melanjutkan ke tabulasi Evaluasi Pra Anestesi / Pra Sedasi
     */
    public function actionCekKunjungan() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['id']) ? $_POST['id'] : ' ';
            $kirim_id = isset($_POST['kirim_id']) ? $_POST['kirim_id'] : ' ';
            $tabulasi = isset($_POST['tabulasi']) ? $_POST['tabulasi'] : null;
            $pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;
            if (isset($id)) {
                if (empty($kirim_id)) {
                    $modEvaluasi = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $id, 'pasienanastesi_id' => $pasienanastesi_id));
                } else {
                    $modEvaluasi = EvaluasianestesiT::model()->findByAttributes(array('pendaftaran_id' => $id, 'pasienkirimkeunitlain_id' => $kirim_id));
                }

                $pasienAnas = PasienanastesiT::model()->findByPk($pasienanastesi_id);

                if (empty($modEvaluasi) && $tabulasi == 'rencana') {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } else if (empty($modEvaluasi) && $tabulasi !== 'rencana') {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Rencana Tindakan Belum Dilakukan';
                } else if (!empty($modEvaluasi) && !empty($pasienAnas)) {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } elseif (!empty($modEvaluasi) && $tabulasi == 'rencana') {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } else if (!empty($modEvaluasi) && $tabulasi !== 'rencana') {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Rencana Tindakan Belum Dilakukan';
                }
                $cekpasienanastesi_id = 0;
                if (!empty($modEvaluasi)) {
                    if (!empty($pasienanastesi_id)) {
                        $cekpasien = PasienanastesiT::model()->findByPk($pasienanastesi_id);
                        $cekpasienanastesi_id = $cekpasien->pasienanastesi_id;
                    } else {
                        $cekpasien = PasienanastesiT::model()->findByPk($modEvaluasi->pasienanastesi_id);
                        $cekpasienanastesi_id = $cekpasien->pasienanastesi_id;
                    }
                } else {
                    $cekpasienanastesi_id = 0;
                }
                $data['pasienanastesi_id'] = $cekpasienanastesi_id;
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

}
