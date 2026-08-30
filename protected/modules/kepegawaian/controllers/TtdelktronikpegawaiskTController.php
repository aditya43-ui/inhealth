
<?php

class TtdelktronikpegawaiskTController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
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
    public function actionCreate($id, $ttd_id = null) {
        $peg = PegawaiM::model()->findByPk($id);
        if (empty($peg)) {
            echo "Pegawai tidak ditemukan";
            Yii::app()->end();
        }
        
        $riwayat = new TtdelktronikpegawaiskT;
        $riwayat->unsetAttributes();
        $riwayat->pegawai_id = $id;
        
        
        if (!empty($ttd_id)) {
            $model = TtdelktronikpegawaiskT::model()->findByPk($ttd_id);
            $model->tglberlaku_awal = MyFormatter::formatDateTimeForUser($model->tglberlaku_awal);
            $model->tglberlaku_akhir = MyFormatter::formatDateTimeForUser($model->tglberlaku_akhir);
            
        } else {
            $model = new TtdelktronikpegawaiskT;
            $model->pegawai_id = $id;
        }
        
        

        if (isset($_POST['TtdelktronikpegawaiskT'])) {
            
            $old_file = $model->file_surat;
            
            $model->attributes = $_POST['TtdelktronikpegawaiskT'];
            $model->tglberlaku_awal = MyFormatter::formatDateTimeForDB($model->tglberlaku_awal);
            $model->tglberlaku_akhir = MyFormatter::formatDateTimeForDB($model->tglberlaku_akhir);
            
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->create_petugaspengisi_id = Yii::app()->user->getState('pegawai_id');
            }
            
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            
            //var_dump($model->attributes); die;
            
            
            $upload = CUploadedFile::getInstance($model, 'file_surat');
            
            if (!empty($upload)) {
                
                $file_old = $upload->name;

    //            var_dump($upload, $arr_file, $ext);

                $old_path = $model->path_file_surat;
                
                $file = $file_old;
                $model->file_surat = $file;
                $model->path_file_surat = Params::pathSKTTDElektronik().$file;

    //            var_dump($model->attributes); die;

                $upload->saveAs($model->path_file_surat);
                
                if (!empty($old_path) && file_exists($old_path)) {
                    unlink($old_path);
                }
            } else {
                $model->file_surat = $old_file;
            }
            
//             var_dump($model->attributes); die;
            
            
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('create', 'id' => $id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'riwayat' => $riwayat,
            'pegawai' => $peg,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['TtdelktronikpegawaiskT'])) {
            $model->attributes = $_POST['TtdelktronikpegawaiskT'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('view', 'id' => $model->ttdelktronikpegawaisk_id));
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
        if (Yii::app()->request->isPostRequest) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = 1;
            $msg = "Data SK Berhasil dihapus";
            
            $id = $_POST['id'];
            
            try {
                $model = $this->loadModel($id);
                $model->delete();
                
                if (file_exists($model->path_file_surat)) {
                    unlink($model->path_file_surat);
                }
                
                
                $trans->commit();
            } catch (Exception $ex) {
                $trans->rollback();
                
                
                $ok = 1;
                $msg = "Data SK Gagal Dihapus. ".$ex->getMessage();
            }
            
            echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        } 
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
        $dataProvider = new CActiveDataProvider('TtdelktronikpegawaiskT');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new TtdelktronikpegawaiskT('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TtdelktronikpegawaiskT'])) {
            $model->attributes = $_GET['TtdelktronikpegawaiskT'];
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
        $model = TtdelktronikpegawaiskT::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ttdelktronikpegawaisk-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new TtdelktronikpegawaiskT;
        $model->attributes = $_REQUEST['TtdelktronikpegawaiskT'];
        $judulLaporan = 'Data TtdelktronikpegawaiskT';
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
    
    public function actionViewFile($id) {
        
        $model = TtdelktronikpegawaiskT::model()->findByPk($id);
        
        
        if(!empty($model) && file_exists($model->path_file_surat)){
            $paths = $model->path_file_surat;
            
//            var_dump($paths, mime_content_type ($paths), filesize($paths), $model->file_surat); die;
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($model->file_surat).'"');
            header("Content-Transfer-Encoding: binary"); 
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($paths));
            
            ob_clean();
            flush();
            readfile($paths);
            Yii::app()->end();
        } else {
            echo "File tidak ditemukan";
            Yii::app()->end();
        }
    }

}
