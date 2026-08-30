
<?php

class DetailResepHDController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//	public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $layout = '//layouts/iframe';

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
//            $model = $this->loadModel($id);
        $cri = new CDbCriteria();
        $cri->select = "t.*, b.*, c.*, d.satuankecil_nama";
        $cri->join = "JOIN obatalkes_m b ON t.obatalkes_id = b.obatalkes_id " .
                "JOIN resephd_m c ON t.resephd_id = c.resephd_id " .
                "JOIN satuankecil_m d ON b.satuankecil_id = d.satuankecil_id";
        $cri->addCondition('t.resephd_det_id = ' . $id);
        $model = ResephdDetM::model()->find($cri);
//            var_dump($model);die;
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        $model = new ResephdDetM;

        if (isset($_POST['ResephdDetM'])) {
//                    print_r($_POST['ResephdDetM']);die;
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['ResephdDetM'] as $key => $post) {
                    $model = new ResephdDetM;
                    if(!empty($post['resephd_det_id'])){
                        $model = ResephdDetM::model()->findByPk($post['resephd_det_id']);
                    }
                    $model->attributes = $post;
                    $model->obatalkes_id = $post['obatalkes_id'];
                    $model->resephd_id = $post['resephd_id'];

                    $ok = $ok && $model->save();
                }
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !! " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }

//			if($model->save()){
//				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//				$this->redirect(array('view','id'=>$model->resephd_det_id));
//				$this->redirect(array('admin'));
//			}
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

        if (isset($_POST['ResephdDetM'])) {
//                    print_r($_POST['ResephdDetM']);die;
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
//                $cek = ResephdDetM::model()->find('resephd_id = ' . $model->resephd_id);
//                if (!empty($cek)) {
//                    $ok = $ok && ResephdDetM::model()->deleteAll('resephd_id = ' . $model->resephd_id);
//                }
                foreach ($_POST['ResephdDetM'] as $key => $post) {
                    $model = new ResephdDetM;
                    $model->attributes = $post;
                    $model->obatalkes_id = $post['obatalkes_id'];
                    $model->resephd_id = $post['resephd_id'];

                    $ok = $ok && $model->save();
                }
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !! " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }

//			if($model->save()){
//				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//				$this->redirect(array('view','id'=>$model->resephd_det_id));
//				$this->redirect(array('admin'));
//			}
        }
//		if(isset($_POST['ResephdDetM']))
//		{
//			$model->attributes = $_POST['ResephdDetM'];
//			if($model->save()){
//				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
//				$this->redirect(array('view','id'=>$model->resephd_det_id));
//			}
//		}

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Memanggil dan menonaktifkan status 
     */
    public function actionActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
            $model->resephd_aktif = true;
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Memanggil dan mengaktifkan status 
     */
    public function actionNonActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set active this
            // example: 
            $model->resephd_aktif = false;
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ResephdDetM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new ResephdDetM();
//        $model->unsetAttributes();  // clear any default values
        if (isset($_REQUEST['ResephdDetM'])) {
            $model->attributes = $_REQUEST['ResephdDetM'];
            if(isset($_REQUEST['ResephdDetM']['resephd_nama'])){
                $model->resephd_nama = $_REQUEST['ResephdDetM']['resephd_nama'];
            }
            if(isset($_REQUEST['ResephdDetM']['obatalkes_kode'])){
                $model->obatalkes_kode = $_REQUEST['ResephdDetM']['obatalkes_kode'];
            }
            if(isset($_REQUEST['ResephdDetM']['obatalkes_nama'])){
                $model->obatalkes_nama = $_REQUEST['ResephdDetM']['obatalkes_nama'];
            }
            if(isset($_REQUEST['ResephdDetM']['satuankecil_id'])){
                $model->satuankecil_id = $_REQUEST['ResephdDetM']['satuankecil_id'];
            }
//            $model->obatalkes_kode = $_REQUEST['ResephdDetM']['obatalkes_kode'];
//            $model->obatalkes_nama = $_REQUEST['ResephdDetM']['obatalkes_nama'];
//            $model->satuankecil_id = $_REQUEST['ResephdDetM']['satuankecil_id'];
            
//            echo $model->resephd_nama;die;
        }
        
        $dataProvider = $model->searchDetail();
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = ResephdDetM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'resephd-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new ResephdDetM;
        if (isset($_REQUEST['ResephdDetM'])) {
//            var_dump($_REQUEST['ResephdDetM']);die;
            $model->attributes = $_REQUEST['ResephdDetM'];
            if(isset($_REQUEST['ResephdDetM']['resephd_nama'])){
                $model->resephd_nama = $_REQUEST['ResephdDetM']['resephd_nama'];
            }
            if(isset($_REQUEST['ResephdDetM']['obatalkes_kode'])){
                $model->obatalkes_kode = $_REQUEST['ResephdDetM']['obatalkes_kode'];
            }
            if(isset($_REQUEST['ResephdDetM']['obatalkes_nama'])){
                $model->obatalkes_nama = $_REQUEST['ResephdDetM']['obatalkes_nama'];
            }
            if(isset($_REQUEST['ResephdDetM']['satuankecil_id'])){
                $model->satuankecil_id = $_REQUEST['ResephdDetM']['satuankecil_id'];
            }
//            echo $model->obatalkes_kode;die;
        }
//        $model->attributes = $_REQUEST['ResephdDetM'];
        $judulLaporan = 'Data Detail Paket HD';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        }
//		else if($_REQUEST['caraPrint']=='PDF') {
//			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
//			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
//			ob_end_clean();
//			$mpdf = new MyPDF('',$ukuranKertasPDF); 
//			$mpdf->debug = true;
//			$mpdf->mirrorMargins = 2;  
//			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
//			$mpdf->WriteHTML($stylesheet,1);  
//			$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> "", 'colspan'=>10),true));
//                        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
//			$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
//			$mpdf->Output();
//		}
        else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    public function actionSetDetailresephd() {
        if (Yii::app()->request->isAjaxRequest) {
            $form = "";
            $resephd_id = $_POST['resephd_id'];
            $obatalkes_id = $_POST['obatalkes_id'];
            $key = $_POST['key'];
            $obatalkes = ObatalkesM::model()->findByPk($obatalkes_id);
            $satuan = SatuankecilM::model()->findByPk($obatalkes->satuankecil_id);
            $modResep = new ResephdDetM();
            $modResep->obatalkes_id = $obatalkes_id;
            $modResep->resephd_id = $resephd_id;
            $modResep->obatalkes_kode = $obatalkes->obatalkes_kode;
            $modResep->obatalkes_nama = $obatalkes->obatalkes_nama;
            $modResep->satuankecil_nama = $satuan->satuankecil_nama;
            $modResep->harga_satuan = $obatalkes->hargajual;

            $form .= $this->renderPartial('_addRow', array('modResep' => $modResep, 'key' => $key
                    ), true);

            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }

    public function actionSetObatAlkes() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
            
            $models = ObatalkesM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->obatalkes_nama;
                $returnVal[$i]['value'] = $model->obatalkes_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionSetDetailPaket() {
        if (Yii::app()->request->isAjaxRequest) {
            $form = "";
            $id = $_POST['paket_id'];
            $key=1;
            
            $paket = ResephdDetM::model()->findAll('resephd_id = '.$id);
//            echo count($paket);die;
            if(!empty($paket)){
                foreach ($paket as $no=>$row){
                    $obatalkes = ObatalkesM::model()->findByPk($row->obatalkes_id);
                    $satuan = SatuankecilM::model()->findByPk($obatalkes->satuankecil_id);
                    $modResep = ResephdDetM::model()->findByPk($row->resephd_det_id);
                    $modResep->resephd_det_id = $modResep->resephd_det_id;
                    $modResep->obatalkes_id = $row->obatalkes_id;
                    $modResep->resephd_id = $row->resephd_id;
                    $modResep->obatalkes_kode = $obatalkes->obatalkes_kode;
                    $modResep->obatalkes_nama = $obatalkes->obatalkes_nama;
                    $modResep->satuankecil_nama = $satuan->satuankecil_nama;
                    $modResep->harga_satuan = $obatalkes->hargajual;

                    $form .= $this->renderPartial('_addRow', array('modResep' => $modResep, 'key' => $key
                            ), true);
                    
                }
                
            }
            

            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }

}
