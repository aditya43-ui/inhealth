
<?php

class PencatatanSisaMakananController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'create';
    public $path_view = "gizi.views.pencatatanSisaMakanan.";

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->layout = '//layouts/iframe';
        $model = $this->loadModel($id);
        $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
            'pasienadmisi_id' => $model->pasienadmisi_id
        ));
        $this->render($this->path_view . 'view', array(
            'model' => $model, 'kunjungan' => $kunjungan,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate($pasienadmisi_id = null, $id = null) {
        if (!empty($pasienadmisi_id)) {
            $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
                'pasienadmisi_id' => $pasienadmisi_id
            ));
        } else {
            $kunjungan = new InfokunjunganriV();
        }

        if (!empty($id)) {
            $model = SisamakananpasienT::model()->findByPk($id);
        } else {
            $model = new SisamakananpasienT;
            $model->tgl_audit = date('Y-m-d');
            $model->jam_audit = date('H:i:s');

            if (!$kunjungan->isNewRecord) {
                $tgl_awal = new DateTime($kunjungan->tgladmisi);
                $tgl_akhir = new DateTime(date('Y-m-d H:i:s'));

                $interval = $tgl_awal->diff($tgl_akhir);
                $model->hariperawatke = $interval->days;
                $model->ruangan_id = $kunjungan->ruangan_id;
            }
        }



        $model->tgl_audit = MyFormatter::formatDateTimeForUser($model->tgl_audit);



        if (isset($_POST['SisamakananpasienT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            try {
                $model->attributes = $_POST['SisamakananpasienT'];

                $random = rand(0000000, 9999999);
                $model->sisamakanan_image = CUploadedFile::getInstance($model, 'sisamakanan_image');
		// var_dump(CUploadedFile::getInstance($model, 'gambarpromo'));die;
			
			$gambar = $model->sisamakanan_image;
			
				$model->sisamakanan_image = $random . $model->sisamakanan_image;
				// var_dump($model->gambarpromo);die;
				Yii::import("ext.EPhpThumb.EPhpThumb");

				$thumb = new EPhpThumb();
				$thumb->init(); //this is needed

				$fullImgName = $model->sisamakanan_image;
				// var_dump($fullImgName);die;
				$fullImgSource = Params::pathSisaMakananDirectory() . $fullImgName;
				$fullThumbSource = Params::pathSisaMakananTumbsDirectory() . 'kecil_' . $fullImgName;
                // $model->save();
                // $gambar->save($fullImgSource);
                // $thumb->create($fullImgSource)
                // ->resize(200, 200)
                // ->save($fullThumbSource);
           

				$model->sisamakanan_image = $fullImgName;
                $model->tgl_audit = MyFormatter::formatDateTimeForDB($model->tgl_audit);
                $model->jml_jenismenu = (integer) MyFormatter::formatRupiahForDB($model->jml_jenismenu);
                $model->jml_4dan5 = (integer) MyFormatter::formatRupiahForDB($model->jml_4dan5);
                $model->auditscore_persen = MyFormatter::formatRupiahForDB($model->auditscore_persen);

                if ($model->isNewRecord) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;

                if ($model->validate()) {
                    $ok = $ok && $model->save();
                       
                    
                } else {
                    $ok = false;
                }
            
                SisamakananpasiendetT::model()->deleteAllByAttributes(array(
                    'sisamakananpasien_id' => $model->sisamakananpasien_id,
                ));

                if (isset($_POST['SisamakananpasiendetT'])) {
                    foreach ($_POST['SisamakananpasiendetT'] as $jenismakanan_id => $item) {
                        $det = new SisamakananpasiendetT;
                        $det->attributes = $model->attributes;
                        $det->attributes = $item;
                        $det->jenismakanan_id = $jenismakanan_id;

                        $ok = $ok && $det->save();

//                        var_dump($det->attributes);
                    }
                }

//                var_dump($ok, $model->errors, $model->attributes, $_POST); die;

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Asesmen Gizi berhasil disimpan");
                    // $gambar->saveAs($fullImgSource);
                    //         $thumb->create($fullImgSource)
                    //                 ->resize(200, 200)
                    //                 ->save($fullThumbSource);

                    $this->redirect(array('create', 'pasienadmisi_id' => $model->pasienadmisi_id, 'sukses' => 1));
                } else {
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . '<pre>' .
                            print_r($model->getErrors(), 1) . '</pre>');

                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . $ex->getMessage());
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model, 'kunjungan' => $kunjungan,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['SisamakananpasienT'])) {
            $model->attributes = $_POST['SisamakananpasienT'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('view', 'id' => $model->sisamakananpasien_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "Catatan Sisa Makanan berhasil di-hapus";
        $trans = Yii::app()->db->beginTransaction();
        $id = $_POST['id'];

        try {
            SisamakananpasiendetT::model()->deleteAllByAttributes(array(
                'sisamakananpasien_id' => $id
            ));
            SisamakananpasienT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Catatan Sisa Makanan gagal di-hapus. " . $ex->getMessage();
        }

        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
    }

    /**
     * Memanggil dan menonaktifkan status 
     */
    public function actionNonActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
            // $model->modelaktif = false;
            // if($model->save()){
            //	$data['sukses'] = 1;
            // }
            echo CJSON::encode($data);
        }
    }

    /**
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SisamakananpasienT');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new SisamakananpasienT('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SisamakananpasienT'])) {
            $model->attributes = $_GET['SisamakananpasienT'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SisamakananpasienT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sisamakananpasien-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        

        // $model = $this->loadModel($id);
        // $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
        //     'pasienadmisi_id' => $model->pasienadmisi_id
        // ));
        $model = new SisamakananpasienT;
        $model->attributes = isset($_REQUEST['SisamakananpasienT']) ? $_REQUEST['SisamakananpasienT'] : null;;
        $judulLaporan = 'Data Sisa Makanan Pasien';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            // $this->render($this->path_view.'Print', array('model' => $model, 'kunjungan' => $kunjungan, 'caraPrint' => $caraPrint));
            $this->render($this->path_view.'PrintNew', array('model' => $model, 'caraPrint' => $caraPrint, 'judulLaporan'=>$judulLaporan));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            // $this->render($this->path_view.'Print', array('model' => $model, 'kunjungan' => $kunjungan));
            $this->render($this->path_view.'PrintNew', array('model' => $model, 'caraPrint' => $caraPrint, 'judulLaporan'=>$judulLaporan));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            // $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'PrintNew', array('model' => $model, 'caraPrint' => $caraPrint, 'judulLaporan'=>$judulLaporan), true));
            $mpdf->Output();
        }
    }

    public function actionAutocompleteAuditor($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $model = new GZPegawairuanganV;
        $model->unsetAttributes();
        $model->nama_pegawai = $term;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        $prov = $model->searchDialog();
        $prov->pagination = false;

        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['namaLengkap'] = $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionAutocompleteJenisDiet($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $model = new JenisdietM('search');
        $model->unsetAttributes();
        $model->jenisdiet_nama = $term;
        $model->jenisdiet_aktif = true;

        $prov = $model->search();
        $prov->pagination = false;

        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->jenisdiet_nama;
            $sub['value'] = $item->jenisdiet_id;

            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

}
