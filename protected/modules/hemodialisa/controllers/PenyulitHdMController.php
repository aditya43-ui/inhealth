<?php

/**
 * controller utama untuk mengakses menu penyulit HD
 * @author Refi Fadholi <refifadholi@.com>
 * @package application.modules.onkologi
 * @subpackage controllers
 */
class PenyulitHdMController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Digunakan untuk menampilkan data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Digunakan untuk membuat data.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PenyulitHdM;

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['PenyulitHdM'])) {
            $model->attributes = $_POST['PenyulitHdM'];
            if ($model->save())
                $this->redirect(array('admin', 'id' => $model->penyulit_hd_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Digunakan untuk mengubah data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed


        if (isset($_POST['PenyulitHdM'])) {
            $model->attributes = $_POST['PenyulitHdM'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->penyulit_hd_id));
                // $this->redirect(array('admin', 'id' => $model->penyulit_hd_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Digunakan untuk menghapus data
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            // we only allow deletion via POST request

            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();

            try {
                if ($this->loadModel($id)->delete()) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang sudah digunakan di transaksi lain tidak dapat dihapus.";
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data yang sudah digunakan di transaksi lain tidak dapat dihapus.";
                Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
            }

            echo CJSON::encode($data);
            Yii::app()->end();

            //$this->loadModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PenyulitHdM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new PenyulitHdM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PenyulitHdM']))
            $model->attributes = $_GET['PenyulitHdM'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionPrint() {
        $model = new PenyulitHdM('search');
        if (isset($_GET['PenyulitHdM']))
            $model->attributes = $_GET['PenyulitHdM'];
        $judulLaporan = 'Data Penyulit HD';
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PenyulitHdM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'penyulit-hd-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
