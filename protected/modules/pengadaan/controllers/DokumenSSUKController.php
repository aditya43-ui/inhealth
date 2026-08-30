
<?php
/**
 * Controller untuk master dokumen SSUK
 * @author M Iqbal Laksana <iqballaksana@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class DokumenSSUKController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */    
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
        $model = new ADLookupM;
        $model->lookup_type = 'dokumenssuk';
        
        if (isset($_POST['ADLookupM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['ADLookupM'];                       
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $model->lookup_value = CUploadedFile::getInstance($model, 'lookup_value');
                $dokumen_pendukung = $model->lookup_value;

                if (!empty($dokumen_pendukung)){
                    $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumen_pendukung));
                    $fullImgSource = Params::pathDokumenSSUKDirectory() . $fullImgName;                    
                    $model->lookup_value = $fullImgName;
                }
                
                $ok &= $model->save();

                 if($ok){     
                                           
                    if (!empty($dokumen_pendukung)){						
                        
                        if (!file_exists(Params::pathDokumenSSUKDirectory())){
                            mkdir(Params::pathDokumenSSUKDirectory(), 0755, true);
                        }
                        
                        $dokumen_pendukung->saveAs($fullImgSource);
                    }
                    
                                         
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('admin','id'=>$model->lookup_id,'sukses'=>1));       
                }else{                             
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
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
        $model->temp_file = $model->lookup_value;


        if (isset($_POST['ADLookupM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['ADLookupM'];                   
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->temp_file = isset($_POST['ADLookupM']['temp_file'])?$_POST['ADLookupM']['temp_file']:null;

                $model->lookup_value = CUploadedFile::getInstance($model, 'lookup_value');
                $dokumen_pendukung = $model->lookup_value;

                if (!empty($dokumen_pendukung)){
                    $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumen_pendukung));
                    $fullImgSource = Params::pathDokumenSSUKDirectory() . $fullImgName;                    
                    $model->lookup_value = $fullImgName;
                }else{
                    $model->lookup_value = $model->temp_file;
                }
                
                $ok &= $model->save();

                 if($ok){     
                                           
                    if (!empty($dokumen_pendukung)){		
                        
                        if (!file_exists(Params::pathDokumenSSUKDirectory())){
                            mkdir(Params::pathDokumenSSUKDirectory(), 0755, true);
                        }
                        
                        $dokumen_pendukung->saveAs($fullImgSource);
                        
                        if (!empty($model->temp_file)){
                            if ($model->temp_file != $model->lookup_value){
                                if (file_exists(Params::pathDokumenSSUKDirectory().$model->temp_file)){
                                    unlink(Params::pathDokumenSSUKDirectory().$model->temp_file);
                                }
                            }
                        }
                    }
                                         
                    $trans->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                    $this->redirect(array('admin','id'=>$model->lookup_id,'sukses'=>1));       
                }else{                             
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {                
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }   
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Menghapus Data
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $mod = $this->loadModel($id);
            
            if (file_exists(Params::pathDokumenSSUKDirectory().$mod->lookup_value)){
                unlink(Params::pathDokumenSSUKDirectory().$mod->lookup_value);
            }
            
            $mod->delete();
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Mengubah status menjadi nonaktif
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = LookupM::model()->updateByPk($id, array('lookup_aktif' => false));
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

    /**
     * Mengubah status menjadi aktif
     */
    public function actionAktifkan() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = LookupM::model()->updateByPk($id, array('lookup_aktif' => true));
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
   

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new ADLookupM('search');
        $model->lookup_type = 'dokumenssuk';
        
        if (isset($_GET['ADLookupM'])) {
            $model->attributes = $_GET['ADLookupM'];
            $model->lookup_type = 'dokumenssuk';
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
        $model = ADLookupM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jenispengadaan-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new ADLookupM();
        $model->lookup_type = 'dokumenssuk';
        if (isset($_REQUEST['ADLookupM'])){
            $model->attributes = $_REQUEST['ADLookupM'];
            $model->lookup_type = 'dokumenssuk';
        }
        $judulLaporan = 'Data Dokumen SSUK';
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
    
    /**
     * Proses unduh file dok 
     * @param integer $id
     */
    public function actionUnduhDok($id) {

        $filename = LookupM::model()->findByPk($id);

        $path = Params::pathDokumenSSUKDirectory() . $filename->lookup_value;

        if (!empty($filename->lookup_value)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->lookup_value, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/file_tidak_ditemukan.txt'));
        }
    }

}
