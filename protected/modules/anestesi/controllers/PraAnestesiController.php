<?php

class PraAnestesiController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.praAnestesi.';

    /**
     * Lists all models.
     */
    public function actionIndex($pendaftaran_id = null, $pasienanastesi_id = null, $frame = null) {
        if (!empty($frame)) {
            $this->layout = '//layouts/iframe';
        }
        if (!empty($pendaftaran_id)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
            if (!empty($pasienanastesi_id)) {
                $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            }
            $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);
        } else {
            $modKunjungan = new ATInformasipasienanestesiV();
        }

        $this->render($this->path_view . 'index', array(
            'modKunjungan' => $modKunjungan,
        ));
    }

    public function actionCekKunjungan($pasienanastesi_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            if (isset($pasienanastesi_id)) {
                $data = ATPraanestesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * untuk menampilkan data kunjungan dari autocomplete
     * - no_anestesi
     * - no_rekam_medik
     * - nama_pasien
     */
    public function actionAutocompleteKunjungan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $noanestesi = isset($_GET['noanestesi']) ? $_GET['noanestesi'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(noanestesi)', strtolower($noanestesi), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->addCondition("DATE(tglanastesi) = '" . date("Y-m-d") . "'");
            $criteria->limit = 5;

            $models = ATInformasipasienanestesiV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->noanestesi . "-" . $model->no_masukpenunjang . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
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

            $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;

            if (!empty($pasienmasukpenunjang_id)) {
                $criteria->addCondition('pasienmasukpenunjang_id =' . $pasienmasukpenunjang_id);
            }
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
            }
            if (!empty($pasienanastesi_id)) {
                $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            }

            $model = ATInformasipasienanestesiV::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["tglanastesi"] = $format->formatDateTimeForUser($model->tglanastesi);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * digunakan untuk mengecek data skala nyeri dan observasi sebelum submit
     */
    public function actionGetData() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : ' ';
            if (isset($id)) {
                $modObservasipendonor = RencanaanestesiT::model()->findByAttributes(array('pasienanastesi_id' => $id));
                if (isset($modObservasipendonor)) {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'data ada';
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Anda belum melakukan transaksi Rencana Tindakan dan Evaluasi Pra-Anestesi / Pra-sedas';
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

}
