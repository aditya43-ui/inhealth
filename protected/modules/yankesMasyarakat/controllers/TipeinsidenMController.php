<?php
/**
 * Untuk mengakses halaman Master Tipe Insiden
 * @author  Andyka <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class TipeinsidenMController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $path_view = 'yankesMasyarakat.views.tipeinsidenM.';

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render($this->path_view.'view',array(
                        'model'=>$model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate()
    {
        $model = new TipeinsidenM;
        if(isset($_POST['TipeinsidenM']))
        {
            $model->attributes = $_POST['TipeinsidenM'];
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id =Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin','sukses'=>1));
            }
        }

        $this->render($this->path_view.'create',array(
            'model'=>$model,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        if(isset($_POST['TipeinsidenM']))
        {
            $model->attributes = $_POST['TipeinsidenM'];
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id =Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin','sukses'=>1));
            }
        }

        $this->render($this->path_view.'update',array(
            'model'=>$model,
        ));
    }
    
    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteRecord($id)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $data['sukses'] = 0;
             if($this->loadModel($id)->delete()){
                $data['sukses'] = 1;
             }
            echo CJSON::encode($data); 
        }
    }

    /**
     * menonaktifkan status 
     * @param type $id
     */
    public function actionNonActive($id)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
             $model->tipeinsiden_aktif = false;
             if($model->save()){
                    $data['sukses'] = 1;
             }
            echo CJSON::encode($data); 
        }
    }

    /**
     * mengaktifkan status 
     * @param type $id
     */
    public function actionActive($id)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
             $model->tipeinsiden_aktif = true;
             if($model->save()){
                    $data['sukses'] = 1;
             }
            echo CJSON::encode($data); 
        }
    }

    /**
     * Melihat daftar data.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('TipeinsidenM');
        $this->render($this->path_view.'index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin()
    {
        $model = new TipeinsidenM('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TipeinsidenM'])){
            $model->attributes = $_GET['TipeinsidenM'];
        }
        $this->render($this->path_view.'admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = TipeinsidenM::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='tipeinsiden-m-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint()
    {
        $model = new TipeinsidenM;
        $model->attributes = $_REQUEST['TipeinsidenM'];
        $judulLaporan='Data Tipe Insiden';
        $caraPrint = $_REQUEST['caraPrint'];

        if($caraPrint=='PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF); 
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> "", 'colspan'=>10),true));
                    $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

}
