<?php
/**
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @issue RSST-8873
 * @category New Feature
 */
class FaktorHubDaftarController extends MyAuthController 
{
    public $layout = '//layouts/iframe';
    
    public function actionAdmin()
    {
        $model = new FaktorhubDaftarM('search');
        $model->unsetAttributes();
        $model->faktorhub_daftar_aktif = 1;
        if (isset($_GET['FaktorhubDaftarM'])) {
            $model->attributes  = $_GET['FaktorhubDaftarM'];
        }
        
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionCreate()
    {
        $model = new FaktorhubDaftarM;
        $model-> faktorhub_daftar_aktif = 1;
        if (isset($_POST['FaktorhubDaftarM'])) {
            $model->attributes = $_POST['FaktorhubDaftarM'];
            if($model->save()){
                Yii::app()->user->setFlash('succes', '<strong>Berhasil!</strong> Data berhasil disimpan!');
                $this->redirect(array('admin', 'sukses' => 1));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
            }
        }
        
        $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        
        if (isset($_POST['FaktorhubDaftarM'])) {
            $model->attributes = $_POST['FaktorhubDaftarM'];
            if($model->update()){
                Yii::app()->user->setFlash('succes', '<strong>Berhasil!</strong> Data berhasil disimpan!');
                $this->redirect(array('admin', 'sukses' => 1));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
            }
        }
        
        $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionremoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = FaktorhubDaftarM::model()->updateByPk($id, array('faktorhub_daftar_aktif' => false));
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                    ));
                    exit;
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                ));
                exit;
            }
        }
    }
    
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id     = $_POST['id'];
            $this->loadModel($id)->delete();
            echo CJSON::encode(array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
            ));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
    
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        
        $this->render('view', ['model' => $model]);
    }
    
    public function actionPrint() {
        $model = new FaktorhubDaftarM;
        $model->attributes = $_REQUEST['FaktorhubDaftarM'];
        $judulLaporan = 'Data Daftar Kondisi Klinis Terkait';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
        protected function loadModel($id)
    {
        $model = FaktorhubDaftarM::model()->findByPk($id);
        
        return $model;
    }
}
