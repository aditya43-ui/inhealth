<?php

/**
 * Controller untuk Informasi Pendonor di modul Bank Darah 
 * improvement pada informasi ketika ubah
 * @author Aida Rahmawati <aidarahmawati@.com>

 * @author  Yusuf Putra Anugrah <yusufputra@.com>

 * @author Andyka Putra <andykaputra@.com>

 * @package applicationa.modules.bankDarah
 * @subpackage controllers
 */
class InformasiPendonorController extends MyAuthController {

    public $path_view = 'bankDarah.views.informasiPendonor.';
    public $path_ubah = 'bankDarah.views.informasiPendonor.ubah.';
    public $pendonortersimpan = false;

    /**
     * Load Informasi Pendonor
     */
    public function actionIndex() {
        $model = new BDPendonorM;
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['BDPendonorM'])) {
            $model->attributes = $_GET['BDPendonorM'];
            $model->no_pendonor = isset($_GET['BDPendonorM']['no_pendonor']) ? $_GET['BDPendonorM']['no_pendonor'] : null;
            $model->nama_lengkap = isset($_GET['BDPendonorM']['nama_lengkap']) ? $_GET['BDPendonorM']['nama_lengkap'] : null;
            $model->jenis_kelamin = isset($_GET['BDPendonorM']['jenis_kelamin']) ? $_GET['BDPendonorM']['jenis_kelamin'] : null;
            $model->gol_darah = isset($_GET['BDPendonorM']['gol_darah']) ? $_GET['BDPendonorM']['gol_darah'] : null;
            $model->rhesus = isset($_GET['BDPendonorM']['rhesus']) ? $_GET['BDPendonorM']['rhesus'] : null;
        }
        $this->render($this->path_view . 'index', array('model' => $model));
    }

    /**
     * Update Data Pendonor 
     * @param type $id
     */
    public function actionUpdate($id) {
        $modPendonor = BDPendonorM::model()->findByPk($id);
        $modPendonor->temp_file = $modPendonor->photopendonor;
        if(!empty($modPendonor->pekerjaan_id)){
            
            $modpekerjaan= PekerjaanpendonorM::model()->findByPk($modPendonor->pekerjaan_id);
            $modPendonor->pekerjaan_nama= isset($modpekerjaan->pekerjaanpendonor_nama)?$modpekerjaan->pekerjaanpendonor_nama:"";
        }
        $modDaftarDonasi = DaftardonasiT::model()->findByAttributes(array('pendonor_id' => $id));
        $format = new MyFormatter();
        $modPendonor->tgllahir = $format->formatDateTimeForUser($modPendonor->tgllahir);
        if (isset($_POST['BDPendonorM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $modPendonor = $this->simpanPendonor($modPendonor, $_POST['BDPendonorM']);

                if ($this->pendonortersimpan) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('update', 'id' => $modPendonor->pendonor_id, 'sukses' => 1, 'frame' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_ubah . 'index', array('modPendonor' => $modPendonor, 'format' => $format, 'modDaftarDonasi' => $modDaftarDonasi));
    }

    /**
     * untuk set tanggal lahir
     */
    public function actionSetTanggalLahir() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['tgllahir'] = MyFormatter::formatDateTimeForUser($_POST['tgl']);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * untuk set tanggal lahir
     */
    public function actionSetTanggalTerakhirDonor() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['tglterakhirdonor'] = MyFormatter::formatDateTimeForUser($_POST['tgl']);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Simpan data pendonor
     * @param type $modPendonor
     * @param type $post
     * @return \PendonorM
     */
    public function simpanPendonor($modPendonor, $post) {
        $format = new MyFormatter();
        $modPendonor->attributes = $post;
        $modPendonor->update_loginpemakai_id = Yii::app()->user->id;
        $modPendonor->update_time = date('Y-m-d H:i:s');
        $modPendonor->tgllahir = !empty($modPendonor->tgllahir) ? $format->formatDateTimeForDb($modPendonor->tgllahir) : ' ';

        if (!empty($modPendonor->photopendonor)) {
            if ($modPendonor->photopendonor != $modPendonor->temp_file){
                $image_text = str_replace('data:image/png;base64,', '', $modPendonor->photopendonor);
                $image_text = str_replace(' ', '+', $image_text);
                $image_text = base64_decode($image_text);
                $modPendonor->photopendonor = date("Ymd") . $modPendonor->no_pendonor . '.png';
                $file = Params::pathPendonorDirectory() . $modPendonor->photopendonor;
                $success = file_put_contents($file, $image_text);
                $source_img = imagecreatefromstring($image_text);

                imagedestroy($source_img);
            }

            if (!empty($modPendonor->temp_file)) {
                if ($modPendonor->temp_file != $modPendonor->photopendonor) {
                    if (file_exists(Params::pathPendonorDirectory() . $modPendonor->temp_file)) {
                        unlink(Params::pathPendonorDirectory() . $modPendonor->temp_file);
                    }
                }
            }
        }
        $modPendonor->validate();

        if ($modPendonor->save()) {
            $this->pendonortersimpan = true;
        } else {
            $this->pendonortersimpan = false;
        }
        return $modPendonor;
    }

    /**
     * untuk menampilkan kabupaten dan kota untuk tempat lahir pasien
     */
    public function actionAutocompleteTempatLahir() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $tempat_lahir = isset($_GET['tempat_lahir']) ? $_GET['tempat_lahir'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(kabupaten_nama)', strtolower($tempat_lahir), true);
            $criteria->addCondition('kabupaten_aktif IS TRUE');
            $criteria->order = 'kabupaten_nama';
            $criteria->limit = 10;
            $models = KabupatenM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = strtoupper($model->kabupaten_nama);
                $returnVal[$i]['value'] = strtoupper($model->kabupaten_nama);
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }
    /**
     * untuk menampilkan nama pekerjaan pendonor
     * @author  Andyka Putra <andykaputra@.com>
     */
    public function actionAutocompletePekerjaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $pekerjaan = isset($_GET['pekerjaan_nama']) ? $_GET['pekerjaan_nama'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(pekerjaanpendonor_nama)', strtolower($pekerjaan), true);
            $criteria->addCondition('pekerjaanpendonor_aktif IS TRUE');
            $criteria->order = 'pekerjaanpendonor_nama';
            $criteria->limit = 10;
            $models = PekerjaanpendonorM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = strtoupper($model->pekerjaanpendonor_nama);
                $returnVal[$i]['value'] = strtoupper($model->pekerjaanpendonor_id);
            }

            echo CJSON::encode($returnVal);
        } else
            throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }

    /**
     * Digunakan untuk melihat riwayat donor
     * @author Andyka Putra <andykaputra@.com>
     * @param type $id
     */
    public function actionRiwayat($id) {
        $this->layout = '//layouts/iframe';
        $modPendonor = PendonorM::model()->findByPk($id);

        $this->render($this->path_view . 'riwayat', array(
            'modPendonor' => $modPendonor,
        ));
    }

}
