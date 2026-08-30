<?php

class CatatanElektrokardiogramController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'create';
    public $path_view = "rawatJalan.views.catatanElektrokardiogram.";
    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate($pendaftaran_id) {
        $this->layout = '//layouts/iframe';

        if(empty($pendaftaran_id)) {
            echo 'Tidak ada kunjungan pada pasien tersebut';
            die;
        }

        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $model = new CatatanelektrokardiogramT;
        $model->pendaftaran_id = $pendaftaran->pendaftaran_id;
        $model->pasien_id = $pendaftaran->pasien_id;
        $model->pasienadmisi_id = $pendaftaran->pasienadmisi_id;
        $model->tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

        $riwayat = CatatanelektrokardiogramT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
            ), array(
            'order' => 'tanggal'
        ));

        if (isset($_POST['CatatanelektrokardiogramT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $model->attributes = $_POST['CatatanelektrokardiogramT'];
                $model->tanggal = MyFormatter::formatDateTimeForDb($_POST['CatatanelektrokardiogramT']['tanggal']);
                $model->create_time = date('Y-m-d H:i:s');
                $model->update_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if(isset($_FILES['CatatanelektrokardiogramT'])) {

                    $instance = CUploadedFile::getInstance($model, 'gambar_path');

                if (!file_exists(Params::pathEkgDirectory())) {
                    mkdir(Params::pathEkgDirectory(), 0777, true);
                }

                $fullImgName = time() . '_image.' . $instance->getExtensionName();
                $fullImgSource = Params::pathEkgDirectory() . $fullImgName;
                $image_info = getimagesize($_FILES['CatatanelektrokardiogramT']['tmp_name']['gambar_path']);
                $model->gambar_path = $fullImgSource;

                }

                // var_dump($model->gambar_path); die();

                if ($model->validate()) {
                    $ok = $ok && $model->save();
                                    // var_dump($fullImgSource, $_POST); die();
                    $instance->saveAs($fullImgSource);
                } else {
                    $ok = false;
                }

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('create', 'pendaftaran_id' => $model->pendaftaran_id, 'catatanelektrokardiogram_id' => $model->catatanelektrokardiogram_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));

            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model, 'pendaftaran' => $pendaftaran, 'riwayat' => $riwayat
        ));
    }

    public function actionLihatGambar($catatanelektrokardiogram_id) {

        $model = CatatanelektrokardiogramT::model()->findByAttributes(array(
            'catatanelektrokardiogram_id' => $catatanelektrokardiogram_id,
            ), array(
            'order' => 'tanggal'
        ));

        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . '_gambar', array('model' => $model));

    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionDetail($pendaftaran_id, $id) {
        $this->layout = '//layouts/iframe';

        $pendaftaran = PendaftaranT::model()->findByPk($id);

        $model = CatatanelektrokardiogramT::model()->findByPk($id);
        $model->tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

        $riwayat = CatatanelektrokardiogramT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
            ), array(
            'order' => 'tanggal'
        ));

        $this->render($this->path_view . 'view', array(
            'model' => $model, 'pendaftaran' => $pendaftaran, 'riwayat' => $riwayat
        ));
    }


    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {

        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data catatan berhasil dihapus";

        if (Yii::app()->request->isPostRequest) {

            try {
                $id = $_POST['id'];
                $this->loadModel($id)->delete();
                $trans->commit();

            } catch (Exception $ex) {
                $trans->rollback();
                $ok = 0;
                $msg = "Data catatan gagal dihapus.".$ex->getMessage();
            }

        }

        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

     /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCopy($id) {
        $this->layout = '//layouts/iframe';

        $model = CatatanelektrokardiogramT::model()->findByPk($id);
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $model->tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

        $riwayat = CatatanelektrokardiogramT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $model->pendaftaran_id,
            ), array(
            'order' => 'tanggal'
        ));

        if (isset($_POST['CatatanelektrokardiogramT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $model = new CatatanelektrokardiogramT;
                $model->attributes = $_POST['CatatanelektrokardiogramT'];
                $model->tanggal = MyFormatter::formatDateTimeForDb($_POST['CatatanelektrokardiogramT']['tanggal']);
                $model->create_time = date('Y-m-d H:i:s');
                $model->update_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if(isset($_FILES['CatatanelektrokardiogramT'])) {

                    $instance = CUploadedFile::getInstance($model, 'gambar_path');

                if (!file_exists(Params::pathEkgDirectory())) {
                    mkdir(Params::pathEkgDirectory(), 0777, true);
                }

                $fullImgName = time() . '_image.' . $instance->getExtensionName();
                $fullImgSource = Params::pathEkgDirectory() . $fullImgName;
                $image_info = getimagesize($_FILES['CatatanelektrokardiogramT']['tmp_name']['gambar_path']);
                $model->gambar_path = $fullImgSource;

                }

                if ($model->validate()) {
                    $ok = $ok && $model->save();
                                    // var_dump($fullImgSource, $_POST); die();
                    $instance->saveAs($fullImgSource);
                } else {
                    $ok = false;
                }

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('create', 'pendaftaran_id' => $model->pendaftaran_id, 'catatanelektrokardiogram_id' => $model->catatanelektrokardiogram_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));

            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model, 'pendaftaran' => $pendaftaran, 'riwayat' => $riwayat
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CatatanelektrokardiogramT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Mencetak data
     */
    public function actionPrint($id, $caraPrint = 'PRINT') {

        $model = CatatanelektrokardiogramT::model()->findByPk($id);
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $model->tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

        $judulLaporan = 'Catatan Elektrokardiogram';

        $view = '_print';

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . $view, array('model' => $model, 'judulLaporan' => $judulLaporan, 'pendaftaran' => $pendaftaran, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . $view, array('model' => $model, 'judulLaporan' => $judulLaporan, 'pendaftaran' => $pendaftaran, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . $view, array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    public function actionAutocompleteEdukator($term) {
        $cr = new CDbCriteria;
        $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $cr->compare('lower(nama_pegawai)', strtolower($term), true);
        $cr->addCondition('pegawai_aktif = true');

        $model = PegawairuanganV::model()->findAll($cr);
        $res = array();

        foreach ($model as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

}