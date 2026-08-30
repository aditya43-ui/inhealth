
<?php

class CatatanEdukasiController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'create';
    public $path_view = "rawatJalan.views.catatanEdukasi.";
    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $this->layout = '//layouts/iframe';

        $model = CatatanedukasiT::model()->findByPk($id);

        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);

        $penjelasan = CatatanedikasipenjT::model()->findAllByAttributes(array(
            'catatanedukasi_id' => $id,
            ), array(
            'order' => 'urutan asc'
        ));
        $keterangan = CatatanedukasiketEvaluasiT::model()->findAllByAttributes(array(
            'catatanedukasi_id' => $id,
            ), array(
            'order' => 'urutan asc',
        ));

        $this->render($this->path_view . 'view', array(
            'model' => $model,
            'pendaftaran' => $pendaftaran,
            'penjelasan' => $penjelasan,
            'keterangan' => $keterangan
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate($pendaftaran_id) {
        $this->layout = '//layouts/iframe';

        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $model = new CatatanedukasiT;
        $model->pendaftaran_id = $pendaftaran->pendaftaran_id;
        $model->pasien_id = $pendaftaran->pasien_id;
        $model->pasienadmisi_id = $pendaftaran->pasienadmisi_id;
        $model->tgl_edukasi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->nomorcatatanedukasi = "-- Otomatis --";

        $riwayat = CatatanedukasiT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
            ), array(
            'order' => 'tgl_edukasi asc'
        ));



        if (isset($_POST['CatatanedukasiT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $model->attributes = $_POST['CatatanedukasiT'];
                $model->nomorcatatanedukasi = MyGenerator::noCatatanEdukasi();
                $model->tgl_edukasi = MyFormatter::formatDateTimeForDB($model->tgl_edukasi);

                $model->create_time = date('Y-m-d H:i:s');
                $model->update_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $arrPenjelasankie = array();
                if (isset($_POST['Penjelasankie']) && count($_POST['Penjelasankie']) > 0) {
                    foreach ($_POST['Penjelasankie'] as $dataPenjelasankie) {
                        if (isset($dataPenjelasankie['isCheck']) && $dataPenjelasankie['isCheck'] == 1) {
                            $arrPenjelasankie[] = $dataPenjelasankie['nama'];
                        }
                    }
                }
                if(count($arrPenjelasankie) > 0){
                   $model->penjelasan_kie = json_encode($arrPenjelasankie);
                }

                $arrEvaluasiketerangan = array();
                if (isset($_POST['Evaluasiketerangan']) && count($_POST['Evaluasiketerangan']) > 0) {
                    foreach ($_POST['Evaluasiketerangan'] as $dataEvaluasiketerangan) {
                        if (isset($dataEvaluasiketerangan['isCheck']) && $dataEvaluasiketerangan['isCheck'] == 1) {
                            $arrEvaluasiketerangan[] = $dataEvaluasiketerangan['nama'];
                        }
                    }
                }
                if(count($arrEvaluasiketerangan) > 0){
                   $model->keterangan_dan_evaluasi = json_encode($arrEvaluasiketerangan);
                }

                if ($model->validate()) {
                    $ok = $ok && $model->save();
                } else {
                    $ok = false;
                }

                if (isset($_POST['CatatanedikasipenjT'])) {
                    foreach ($_POST['CatatanedikasipenjT'] as $id => $item) {
                        $det = new CatatanedikasipenjT;
                        $det->attributes = $item;
                        $det->catatanedukasi_id = $model->catatanedukasi_id;
                        $det->edukasipenjelasan_id = $id;

                        $mod = EdukasipenjelasanM::model()->findByPk($id);
                        $det->nama_edukasi = $mod->nama_penjelasan;
                        $det->urutan = $mod->urutan;
                        $det->isceklis = $det->isceklis == 1;

                        $det->create_time = date('Y-m-d H:i:s');
                        $det->update_time = date('Y-m-d H:i:s');
                        $det->create_loginpemakai_id = Yii::app()->user->id;
                        $det->update_loginpemakai_id = Yii::app()->user->id;
                        $det->create_ruangan = Yii::app()->user->getState('ruangan_id');


                        $ok = $ok && $det->save();

                        // var_dump($det->attributes, $item);
                    }
                }


                if (isset($_POST['CatatanedukasiketEvaluasiT'])) {
                    foreach ($_POST['CatatanedukasiketEvaluasiT'] as $id => $item) {
                        $det = new CatatanedukasiketEvaluasiT;
                        $det->attributes = $item;
                        $det->catatanedukasi_id = $model->catatanedukasi_id;
                        $det->edukasi_keteranganevaluasi_id = $id;

                        $mod = EdukasiKeteranganevaluasiM::model()->findByPk($id);
                        $det->keterangan_evaluasi = $mod->keterangan_evaluasi;
                        $det->urutan = $mod->urutan;
                        $det->isceklis = $det->isceklis == 1;

                        $det->create_time = date('Y-m-d H:i:s');
                        $det->update_time = date('Y-m-d H:i:s');
                        $det->create_loginpemakai_id = Yii::app()->user->id;
                        $det->update_loginpemakai_id = Yii::app()->user->id;
                        $det->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $ok = $ok && $det->save();


                        // var_dump($item, $det->attributes);
                    }
                }

                // var_dump($ok, $_POST);
                // die;

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('create', 'pendaftaran_id' => $model->pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));

                // var_dump($ex->getMessage()); die;
            }
        }

        $this->render($this->path_view . 'create', array(
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

                CatatanedikasipenjT::model()->deleteAllByAttributes(array(
                    'catatanedukasi_id'=>$id,
                ));
                CatatanedukasiketEvaluasiT::model()->deleteAllByAttributes(array(
                    'catatanedukasi_id'=>$id,
                ));
                $this->loadModel($id)->delete();

                $trans->commit();

            } catch (Exception $ex) {
                $trans->rollback();
                $ok = 0;
                $msg = "Data catatan gagal dihapus.".$ex->getMessage();
            }

            // we only allow deletion via POST request

        }

        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CatatanedukasiT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'catatanedukasi-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint($pendaftaran_id, $tipe, $caraPrint = 'PRINT') {
        if (!in_array($tipe, array('a', 'b'))) {
            $tipe = 'a';
        }

        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $model = CatatanedukasiT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $pendaftaran_id,
            ), array(
            'order' => 'tgl_edukasi asc'
        ));
        $judulLaporan = 'Catatan Edukasi dan Terintegrasi ' . strtoupper($tipe);

        $view = '_printA';

        if ($tipe == 'b') {
            $view = '_printB';
        }

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

    public function actionLoadCeklisEdukator() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        $kode = $_POST['kode'];

        $penjelasan = EdukasipenjelasanM::model()->findAllByAttributes(array(
            'kodeedukator' => $kode,
            'is_aktif' => true
            ), array(
            'order' => 'urutan'
        ));
        $keterangan = EdukasiKeteranganevaluasiM::model()->findAllByAttributes(array(
            'kodeedukator' => $kode,
            'is_aktif' => true
            ), array(
            'order' => 'urutan'
        ));


        $html = $this->renderPartial($this->path_view . "_tabCeklis", array(
            'penjelasan' => $penjelasan, 'keterangan' => $keterangan, 'kode' => $kode,
            ), true);

        echo CJSON::encode(array(
            'html' => $html,
        ));
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
