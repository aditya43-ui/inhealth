
<?php

class PersetujuanumumisiMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        $model = new PersetujuanumumisiM;
        $pers = PersetujuanumumM::model()->find();

        if (isset($_POST['PersetujuanumumisiM'])) {
            
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try {
                
                $model->attributes = $_POST['PersetujuanumumisiM'];
                $model->create_time = $model->update_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');

                if (!empty($pers)) {
                    $model->persetujuanumum_id = $pers->persetujuanumum_id;
                }

                if ($model->persetujuan_isiadagambar == 0) {
                    $model->persetujuan_gambar = null;
                }

                if (!empty($model->persetujuan_gambar)) {
                    $model->persetujuan_gambar = $this->tabPerseTujuanGambar($model);
                }
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                } else {
                    $ok = false;
                }
                
                
                if (isset($_POST['PersetujuanumuminputanM'])) {
                    foreach ($_POST['PersetujuanumuminputanM'] as $idx => $val) {
                        $inputan = new PersetujuanumuminputanM;
                        $inputan->attributes = $model->attributes;
                        $inputan->attributes = $val;
                        
                        if ($inputan->validate()) {
                            $ok = $ok && $inputan->save();
                        } else {
                            $ok = false;
                        }
                        
                        $urutan_idx = 0;
                        if (isset($_POST['PersetujuanumuminputandetM'][$idx]['detail'])) {
                            foreach ($_POST['PersetujuanumuminputandetM'][$idx]['detail'] as $val2) {
                                $det = new PersetujuanumuminputandetM;
                                $det->attributes = $inputan->attributes;
                                $det->attributes = $val2;
                                $det->urutan = $urutan_idx++;
                                
                                if ($det->validate()) {
                                    $ok = $ok && $det->save();
                                } else {
                                    $ok = false;
                                }
                                
//                                var_dump($det->attributes);
                            } 
                        }
                        
//                        var_dump($inputan->attributes);
                    }
                }
                
//                var_dump($ok, $model->attributes, $_POST); die;
                
                if ($ok) {
//                    die;
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $trans->collback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan. '.$ex->getMessage());
            }
            
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['PersetujuanumumisiM'])) {
            
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            
            try {
                
                $model->attributes = $_POST['PersetujuanumumisiM'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;

                if ($model->persetujuan_isiadagambar == 0) {
                    $model->persetujuan_gambar = null;
                }

                if (!empty($model->persetujuan_gambar)) {
                    $model->persetujuan_gambar = $this->tabPerseTujuanGambar($model);
                }
                
                if ($model->validate()) {
                    $ok = $ok && $model->save();
                } else {
                    $ok = false;
                }
                
                
                // hapus data
                $modhapus = PersetujuanumuminputanM::model()->findAllByAttributes(array(
                    'persetujuanumumisi_id'=>$model->persetujuanumumisi_id,
                ));
                
                foreach ($modhapus as $item) {
                    PersetujuanumuminputandetM::model()->deleteAllByAttributes(array(
                        'persetujuanumuminputan_id'=>$item->persetujuanumuminputan_id,
                    ));
                    $item->delete();
                }
                
                
                if (isset($_POST['PersetujuanumuminputanM'])) {
                    foreach ($_POST['PersetujuanumuminputanM'] as $idx => $val) {
                        $inputan = new PersetujuanumuminputanM;
                        $inputan->attributes = $model->attributes;
                        $inputan->attributes = $val;
                        
                        if ($inputan->validate()) {
                            $ok = $ok && $inputan->save();
                        } else {
                            $ok = false;
                        }
                        
                        $urutan_idx = 0;
                        if (isset($_POST['PersetujuanumuminputandetM'][$idx]['detail'])) {
                            foreach ($_POST['PersetujuanumuminputandetM'][$idx]['detail'] as $val2) {
                                $det = new PersetujuanumuminputandetM;
                                $det->attributes = $inputan->attributes;
                                $det->attributes = $val2;
                                $det->urutan = $urutan_idx++;
                                
                                if ($det->validate()) {
                                    $ok = $ok && $det->save();
                                } else {
                                    $ok = false;
                                }
                                
//                                var_dump($det->attributes);
                            } 
                        }
                        
//                        var_dump($inputan->attributes);
                    }
                }
                
                
                if ($ok) {
//                    die;
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $trans->collback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan. '.$ex->getMessage());
            }
            
            
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    protected function tabPerseTujuanGambar($model) {

        $res = array();
        if (empty($model->persetujuan_gambar) || !is_array($model->persetujuan_gambar)) {
            return null;
        }

        $idx = 1;
        foreach ($model->persetujuan_gambar as $item) {

            $nama_gambar = explode(".", $item['nama_gambar']);
            if (count($nama_gambar) > 1) {
                array_pop($nama_gambar);
            }

            $sub['nama_gambar'] = $nama_gambar[0];
            $sub['urutan'] = $idx;

            //upload gambar
            list($type, $data) = explode(";", $item['val64_gambar']);
            list($t1, $data) = explode(",", $data);
            list($type, $ext) = explode("/", $type);

            $bin = base64_decode($data);
            $nama_file = "img_" . date('YmdHis') . $idx . "." . $ext;

            file_put_contents(Params::pathPersetujuanUmumIsiGambar() . $nama_file, $bin);

            $sub['path_gambar'] = $nama_file;

            // var_dump(Params::pathPersetujuanUmumIsiGambar().$nama_file, $nama_file, $type, $ext, $data, $bin); die;





            $res[] = $sub;

            $idx++;
        }

//            var_dump($res); die;

        return CJSON::encode($res);

//            var_dump($res, $model->attributes);
//            
//            die;
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            
            $trans = Yii::app()->db->beginTransaction();
            
            try {
                // hapus data
                $modhapus = PersetujuanumuminputanM::model()->findAllByAttributes(array(
                    'persetujuanumumisi_id'=>$id,
                ));

                foreach ($modhapus as $item) {
                    PersetujuanumuminputandetM::model()->deleteAllByAttributes(array(
                        'persetujuanumuminputan_id'=>$item->persetujuanumuminputan_id,
                    ));
                    $item->delete();
                }

                $this->loadModel($id)->delete();

                $trans->commit();
                
            } catch (Exception $ex) {
                $trans->rollback();
                throw new CHttpException(400, 'Data gagal dihapus.');
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
        $dataProvider = new CActiveDataProvider('PersetujuanumumisiM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new PersetujuanumumisiM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PersetujuanumumisiM'])) {
            $model->attributes = $_GET['PersetujuanumumisiM'];
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
        $model = PersetujuanumumisiM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'persetujuanumumisi-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new PersetujuanumumisiM;
        $model->attributes = $_REQUEST['PersetujuanumumisiM'];
        $judulLaporan = 'Data PersetujuanumumisiM';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
    public function actionLoadFormTipeInput() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $tipe = $_POST['tipe'];
        $input_idx = $_POST['input_idx'];
        $inputan = new PersetujuanumuminputanM;
        
        $ok = 1;
        
        $html = match($tipe) {
            "checkbox" => $this->renderPartial('form/input/_checkbox', array('inputan'=>$inputan, 'idx'=>$input_idx), true),
            "radiobutton" => $this->renderPartial('form/input/_radio', array('inputan'=>$inputan, 'idx'=>$input_idx), true),
            "dropdown" => $this->renderPartial('form/input/_dropdown', array('inputan'=>$inputan, 'idx'=>$input_idx), true),
            "textfield" => $this->renderPartial('form/input/_textfield', array('inputan'=>$inputan, 'idx'=>$input_idx), true),
            "textarea" => $this->renderPartial('form/input/_textarea', array('inputan'=>$inputan, 'idx'=>$input_idx), true),
        };
        
        echo CJSON::encode(array('html'=>$html, 'ok'=>$ok));
        
        
    }
    
    public function actionAjaxGenerateDetailDropdown() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $nilai = $_POST['nilai'] ?? 0;
        $index = $_POST['input_idx'];
        
        $ok = 1;
        $html = "";
        
        for ($i = 0; $i < $nilai; $i++) {
            $html .= $this->renderPartial('form/input/_dropdown_detail', array(
                'inputan'=>new PersetujuanumuminputanM, 'idx'=>$index, 'idx2' => $i,
            ), true);
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'html'=>$html));
    }
    
    public function actionAjaxGenerateDetailCheckBox() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $nilai = $_POST['nilai'] ?? 0;
        $index = $_POST['input_idx'];
        
        $ok = 1;
        $html = "";
        
        for ($i = 0; $i < $nilai; $i++) {
            $html .= $this->renderPartial('form/input/_checkbox_detail', array(
                'inputan'=>new PersetujuanumuminputanM, 'idx'=>$index, 'idx2' => $i,
            ), true);
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'html'=>$html));
    }
    
    public function actionAjaxGenerateDetailRadio() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $nilai = $_POST['nilai'] ?? 0;
        $index = $_POST['input_idx'];
        
        $ok = 1;
        $html = "";
        
        for ($i = 0; $i < $nilai; $i++) {
            $html .= $this->renderPartial('form/input/_radio_detail', array(
                'inputan'=>new PersetujuanumuminputanM, 'idx'=>$index, 'idx2' => $i,
            ), true);
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'html'=>$html));
    }
    
    public function actionAjaxGenerateDetailTextfield() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $nilai = $_POST['nilai'] ?? 0;
        $index = $_POST['input_idx'];
        
        $ok = 1;
        $html = "";
        
        for ($i = 0; $i < $nilai; $i++) {
            $html .= $this->renderPartial('form/input/_textfield_detail', array(
                'inputan'=>new PersetujuanumuminputanM, 'idx'=>$index, 'idx2' => $i,
            ), true);
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'html'=>$html));
    }
    
    public function actionAjaxGenerateDetailTextarea() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $nilai = $_POST['nilai'] ?? 0;
        $index = $_POST['input_idx'];
        
        $ok = 1;
        $html = "";
        
        for ($i = 0; $i < $nilai; $i++) {
            $html .= $this->renderPartial('form/input/_textarea_detail', array(
                'inputan'=>new PersetujuanumuminputanM, 'idx'=>$index, 'idx2' => $i,
            ), true);
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'html'=>$html));
    }
    
    public function actionTambahSubForm() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $index = $_POST['idx'];
        
        echo $this->renderPartial('form/input/_form', array('idx'=>$index), true);
    }

}
