<?php
/**
 * Untuk mengakses halaman Master Tingkat Risiko
 * @author  Andyka <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 */
class TingkatrisikoMController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $path_view = 'yankesMasyarakat.views.tingkatrisikoM.';

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
        $model = new TingkatrisikoM;
        if(isset($_POST['TingkatrisikoM']))
        {
            $model->attributes = $_POST['TingkatrisikoM'];
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
        if(isset($_POST['TingkatrisikoM']))
        {
            $model->attributes = $_POST['TingkatrisikoM'];
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
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
             $model->tingkatrisiko_aktif = false;
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
             $model->tingkatrisiko_aktif = true;
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
        $dataProvider = new CActiveDataProvider('TingkatrisikoM');
        $this->render($this->path_view.'index',array(
                'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin()
    {
        $model = new TingkatrisikoM('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TingkatrisikoM'])){
            $model->attributes = $_GET['TingkatrisikoM'];
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
        $model = TingkatrisikoM::model()->findByPk($id);
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
        $model = new TingkatrisikoM;
        $model->attributes = $_REQUEST['TingkatrisikoM'];
        $judulLaporan='Data Tingkat Risiko';
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

    /**
     * Fungsi untuk menyimpan satuan bahan makanan.
     */
    public function actionSimpanWarna(){
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->condition  = "lookup_type = 'tingkatwarna_risiko' and lookup_aktif=true";
            $criteria->order = "lookup_urutan DESC";
            $criteria->limit = 1;
            $modelUrutan = LookupM::model()->find($criteria);
            
            $urut = !empty($modelUrutan)?$modelUrutan->lookup_urutan:1;
            
            $model = new LookupM();
            $model->lookup_type = 'tingkatwarna_risiko';
            $model->lookup_name = $_POST['name'];
            $model->lookup_value = $_POST['value'];
            $model->lookup_urutan = $urut + 1;
            $model->create_time = date("Y-m-d H:i:s");
            $model->create_loginpemakai_id = 1;
            $model->create_ruangan = 1;
            $model->save();

            if($model->save()){
               $data['sukses'] = 1; 
               $data['pesan'] = "Data berhasil ditambahkan";
            }else{
               $data['sukses'] = 0; 
               $data['pesan'] = "Data gagal ditambahkan";
            }

            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Fungsi untuk membuat form satuan bahan makanan.
     */
    public function actionTambahWarna(){
        $this->layout = '//layouts/iframe';
        $model = new LookupM();

        $this->render('_tambahWarna',
            array(
                'model'=>$model,
            )
        );
    }
}
