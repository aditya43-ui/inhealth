<?php
/**
 * Untuk mengakses halaman Master Pejabat Pengadaan
 * menambahkan kolom tanggal sk dan no sk
 * @author  Andyka <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 */
class PejabatpengadaanMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $path_view = 'pengadaan.views.pejabatpengadaanM.';

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render($this->path_view . 'view', array(
            'model' => $model,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        $model = new PejabatpengadaanM;
        $modDet = new PejabatpengadaandetM;
        $modUnit = new PejabatpengadaanunitM();
        if (isset($_POST['PejabatpengadaanM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['PejabatpengadaanM'];
                $model->tgl_sk = MyFormatter::formatDateTimeForDb($_POST['PejabatpengadaanM']['tgl_sk']);

                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $model->file_sk = CUploadedFile::getInstance($model, 'file_sk');
                $dokumen_pendukung = $model->file_sk;

                if (!empty($dokumen_pendukung)){
                    $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumen_pendukung));
                    $fullImgSource = Params::pathFileSkDirectory() . $fullImgName;                    
                    $model->file_sk = $fullImgName;
                }

                if (!empty($dokumen_pendukung)){						

                    if (!file_exists(Params::pathFileSkDirectory())){
                        mkdir(Params::pathFileSkDirectory(), 0755, true);
                    }

                    $dokumen_pendukung->saveAs($fullImgSource);
                }

                $ok &= $model->save();
                

                if (isset($_POST['PejabatpengadaandetM'])) {
                    PejabatpengadaandetM::model()->deleteAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));

                    foreach ($_POST['PejabatpengadaandetM']['instalasi_id'] as $i => $det) {
                        $modDetail[$i] = new PejabatpengadaandetM();
                        $modDetail[$i]->pejabatpengadaan_id = $model->pejabatpengadaan_id;
                        $modDetail[$i]->instalasi_id = $det;
                        $ok &= $modDetail[$i]->save();
                    }
                }
                
                if (isset($_POST['PejabatpengadaanunitM'])) {
                    PejabatpengadaanunitM::model()->deleteAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));

                    foreach ($_POST['PejabatpengadaanunitM']['unitkerja_id'] as $i => $det) {
                        $modUnit = new PejabatpengadaanunitM();
                        $modUnit->pejabatpengadaan_id = $model->pejabatpengadaan_id;
                        $modUnit->unitkerja_id   = $det;
                        $ok &= $modUnit->save();
                    }
                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
            
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'modDet' => $modDet,
            'modUnit' => $modUnit,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->tgl_sk= MyFormatter::formatDateTimeForUser($model->tgl_sk);
        $model->temp_file = $model->file_sk;
        $modDet = new PejabatpengadaandetM;
        $cekDet = PejabatpengadaandetM::model()->findAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));
        $ins_arr = [];
        foreach($cekDet as $det){
            $ins_arr[] = $det->instalasi_id;
        }
        $modDet->instalasi_id = $ins_arr;
        $modUnit = new PejabatpengadaanunitM();
        $cekUnit = PejabatpengadaanunitM::model()->findAllByAttributes(['pejabatpengadaan_id' => $model->pejabatpengadaan_id]);
        $unit_arr = [];
        foreach($cekUnit as $det){
            $unit_arr[] = $det->unitkerja_id;
        }
        $modUnit->unitkerja_id = $unit_arr;

        // Uncomment the following line if AJAX validation is needed
        if (isset($_POST['PejabatpengadaanM'])) {
            $ok = true;
            $trans= Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['PejabatpengadaanM'];
                $model->tgl_sk = MyFormatter::formatDateTimeForDb($_POST['PejabatpengadaanM']['tgl_sk']);

                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');


                $model->file_sk = CUploadedFile::getInstance($model, 'file_sk');
                $dokumen_pendukung = $model->file_sk;

                if (!empty($dokumen_pendukung)){
                    $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumen_pendukung));
                    $fullImgSource = Params::pathFileSkDirectory() . $fullImgName;                    
                    $model->file_sk = $fullImgName;
                }

                if (!empty($dokumen_pendukung)){						

                    if (!file_exists(Params::pathFileSkDirectory())){
                        mkdir(Params::pathFileSkDirectory(), 0755, true);
                    }

                    $dokumen_pendukung->saveAs($fullImgSource);
                }

                $ok &= $model->save();
                
                if (isset($_POST['PejabatpengadaandetM'])) {
                    PejabatpengadaandetM::model()->deleteAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));

                    foreach ($_POST['PejabatpengadaandetM']['instalasi_id'] as $i => $det) {
                        $modDetail[$i] = new PejabatpengadaandetM();
                        $modDetail[$i]->pejabatpengadaan_id = $model->pejabatpengadaan_id;
                        $modDetail[$i]->instalasi_id = $det;
                        $ok &= $modDetail[$i]->save();
                    }
                }
                
                if (isset($_POST['PejabatpengadaanunitM'])) {
                    PejabatpengadaanunitM::model()->deleteAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));

                    foreach ($_POST['PejabatpengadaanunitM']['unitkerja_id'] as $i => $det) {
                        $modUnit = new PejabatpengadaanunitM();
                        $modUnit->pejabatpengadaan_id = $model->pejabatpengadaan_id;
                        $modUnit->unitkerja_id   = $det;
                        $ok &= $modUnit->save();
                    }
                }
                
                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
            'modDet'=> $modDet,
            'cekDet'=> $cekDet,
            'modUnit'=> $modUnit,
            'cekUnit'=> $cekUnit,
        ));
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            PejabatpengadaandetM::model()->deleteAllByAttributes(array('pejabatpengadaan_id'=>$id));
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * menonaktifkan status 
     * @param type $id
     */
    public function actionNonActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
            $model->pejabatpengadaan_aktif = false;
            if ($model->update()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * mengaktifkan status 
     * @param type $id
     */
    public function actionActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);
            // set non-active this
            // example: 
            $model->pejabatpengadaan_aktif = true;
            if ($model->update()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PejabatpengadaanM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new PejabatpengadaanM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PejabatpengadaanM'])) {
            $model->attributes = $_GET['PejabatpengadaanM'];
        }
        $modDet = new PejabatpengadaandetM('search');
        $modDet->unsetAttributes();  // clear any default values
        if (isset($_GET['PejabatpengadaandetM'])) {
            $modDet->attributes = $_GET['PejabatpengadaandetM'];
        }
        $this->render($this->path_view . 'admin', array(
            'model' => $model,
            'modDet'=>$modDet,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PejabatpengadaanM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pejabatpengadaan-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new PejabatpengadaanM;
        $model->attributes = $_REQUEST['PejabatpengadaanM'];
        $judulLaporan = 'Data Pejabat Pengadaan';
        $caraPrint = $_REQUEST['caraPrint'];

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->shrink_tables_to_fit=0;
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 70, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }
    
    /**
     * Proses unduh file dok 
     * @param integer $id
     */
    public function actionUnduhDok($id) {

        $filename = PejabatpengadaanM::model()->findByPk($id);

        $path = Params::pathFileSkDirectory() . $filename->file_sk;

        if (!empty($filename->file_sk)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->file_sk, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/file_tidak_ditemukan.txt'));
        }
    }

}
