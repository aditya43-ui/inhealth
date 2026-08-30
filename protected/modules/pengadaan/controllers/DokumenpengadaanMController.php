
<?php
/**
 * Master Dokumen Pengadaan di modul pengadaan
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 */
class DokumenpengadaanMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'pengadaan.views.dokumenpengadaanM.';
    public $dokumenTersimpan = true;
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
        $model = new DokumenpengadaanM;
        $modDetail = new DokumenpengadaanM;

        if (isset($_POST['DokumenpengadaanM'])) {
            try {
                $this->simpanDokumen($_POST['DokumenpengadaanM']['dokumenpengadaan_jenistransaksi'], $_POST['DokumenpengadaanM']['jenispengadaan_id'], $_POST['DokumenpengadaanM']['metodepengadaan_id'], $_POST['DokumenpengadaanM']);    
		if ($this->dokumenTersimpan){
                    $this->redirect(array('admin','sukses'=>1));
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                }else{
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error', '<strong>b!</strong> Data gagal disimpan!'.MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modDetail' => $modDetail
        ));
    }
    
    /**
     * Menyimpan data dokumen pendukung
     * @param type $jenistransaksi
     * @param type $jenispengadaan
     * @param type $post
     */
    public function simpanDokumen($jenistransaksi, $jenispengadaan = null, $metodepengadaan = null, $post){
        foreach ($post as $i => $dokumen) {
            if (empty($dokumen['dokumenpengadaan_id'])) {
                $model = new DokumenpengadaanM;
                $model->attributes = $dokumen;
                $model->jenispengadaan_id = $jenispengadaan;
                $model->dokumenpengadaan_jenistransaksi = $jenistransaksi;
                $model->metodepengadaan_id = $metodepengadaan;
                $model->dokumenpengadaan_aktif = true;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->save();
            }
        }
    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $modDetail=new DokumenpengadaanM;
        if(isset($_POST['DokumenpengadaanM']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $this->updateDokumen($id, $_POST['DokumenpengadaanM']);
		if ($this->dokumenTersimpan){
                    $transaction->commit();
                    $this->redirect(array('admin','sukses'=>1));
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>a!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>b!</strong> Data gagal disimpan!'.MyExceptionMessage::getMessage($exc));
            }
        }    
        $this->render('update',array('model'=>$model,'modDetail'=>$modDetail));
    }

    /**
     * Update Dokumen Pengadaan
     * @param type $id
     * @param type $post
     */
    public function updateDokumen($id, $post){
        foreach ($post as $i => $dokumen) {
            $mod = DokumenpengadaanM::model()->findByPk($id);
            if(!empty($dokumen['dokumenpengadaan_id'])){
                $model= new DokumenpengadaanM;
                $model->attributes = $dokumen;
                $wajib = true;
                if (empty($model->dokumenpengadaan_wajib)) {
                    $wajib = false;
                }
                DokumenpengadaanM::model()->updateByPk($dokumen['dokumenpengadaan_id'],array(
                    'dokumenpengadaan_nama'=>$model->dokumenpengadaan_nama,
                    'dokumenpengadaan_namalain'=>$model->dokumenpengadaan_namalain,
                    'dokumenpengadaan_deskripsi'=>$model->dokumenpengadaan_deskripsi,
                    'dokumenpengadaan_wajib'=> $wajib,
                    'dokumenpengadaan_urutan'=>$model->dokumenpengadaan_urutan,
                    'metodepengadaan_id'=>$model->metodepengadaan_id,
                    'file_zip'=>$model->file_zip,
                    'file_rar'=>$model->file_rar,
                    'file_word'=>$model->file_word,
                    'file_pdf'=>$model->file_pdf,
                    'file_excel'=>$model->file_excel,
                    'file_excel'=>$model->file_excel,
                    'file_image'=>$model->file_image,
                    'dokumenpengadaan_aktif'=>$model->dokumenpengadaan_aktif,
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')
                ));
            } else {
                $model= new DokumenpengadaanM;
                $model->attributes = $dokumen;
                $model->jenispengadaan_id = $mod->jenispengadaan_id;
                $model->dokumenpengadaan_jenistransaksi = $mod->dokumenpengadaan_jenistransaksi;
                $model->metodepengadaan_id = $mod->metodepengadaan_id;
                if (empty($model->dokumenpengadaan_aktif)) {
                    $model->dokumenpengadaan_aktif = false;
                } else{
                    $model->dokumenpengadaan_aktif = true;
                }
                
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->save();
            }
        }
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if($this->loadModel($id)->delete()){
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang sudah digunakan di Transaksi Persiapan Pengadaan tidak dapat dihapus";
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data yang sudah digunakan di Transaksi Persiapan Pengadaan tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }
    
    /**
     * Delete data 
     */
    public function actionDeleteRow() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        echo CJSON::encode($this->loadData($_POST['id']));
    }
    
    /**
     * Load data untuk dihapus
     * @param type $id
     * @return type
     */
    public function loadData($id){
        $ok = 1;
        $msg = " ";
        $persiapan = PengadaandokumenpendukungT::model()->findByAttributes(array('dokumenpengadaan_id' => $id));
            
        if (!empty($persiapan)) {
            $ok = 0;
            $msg = "Data yang sudah digunakan di Transaksi Persiapan Pengadaan tidak dapat dihapus";
            return array('ok'=>$ok, 'msg'=>$msg);
        } else {
            $this->loadModel($id)->delete();
            $ok = 1;
            $msg = "Data berhasil dihapus";
            return array('ok'=>$ok, 'msg'=>$msg);
        }            
    }
    
    /**
     * Mengubah status menjadi nonaktif
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = DokumenpengadaanM::model()->updateByPk($id, array('dokumenpengadaan_aktif' => false));
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
            $update = DokumenpengadaanM::model()->updateByPk($id, array('dokumenpengadaan_aktif' => true));
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
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('DokumenpengadaanM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new DokumenpengadaanM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DokumenpengadaanM'])) {
            $model->attributes = $_GET['DokumenpengadaanM'];
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
        $model = DokumenpengadaanM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dokumenpengadaan-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new DokumenpengadaanM;
        $model->attributes = $_REQUEST['DokumenpengadaanM'];
        $judulLaporan = 'Data Dokumen Pengadaan';
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
     * Load row dokumen
     */
    public function actionGetDokumen(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new DokumenpengadaanM;
            $data['form'] = "";
            $models = $this->loadModelByType($_POST['jenistransaksi'], $_POST['jenispengadaan'], $_POST['metodepengadaan']);
            if(count($models) > 0){
                foreach ($models AS $i=>$model){
                    $data['form'] .= $this->renderPartial('_rowDokumen',array('model'=>$model),true);
                }
            }else{
                $data['form'] .= $this->renderPartial('_rowDokumen',array('model'=>$model),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Load data berdasarkan jenis transaksi dan jenis pengadaan 
     * Jika jenis pengadaan tidak ada maka data dipilih berdasarkan 'jenispengadaan_id IS NULL'
     * @param type $jenistransaksi
     * @param type $jenispengadaan
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($jenistransaksi, $jenispengadaan = null, $metodepengadaan = null){
        if (!empty($jenispengadaan) && !empty($metodepengadaan)) {
            $model = DokumenpengadaanM::model()->findAllByAttributes(array('dokumenpengadaan_jenistransaksi' => $jenistransaksi, 'jenispengadaan_id' => $jenispengadaan, 'metodepengadaan_id' => $metodepengadaan), array('order' => 'dokumenpengadaan_urutan asc'));
        } else if (!empty($jenispengadaan) && empty($metodepengadaan)) {
            $model = DokumenpengadaanM::model()->findAllByAttributes(array('dokumenpengadaan_jenistransaksi' => $jenistransaksi, 'jenispengadaan_id' => $jenispengadaan, 'metodepengadaan_id' => null), array('order' => 'dokumenpengadaan_urutan asc'));
        } else if (empty($jenispengadaan) && !empty($metodepengadaan)) {
            $model = DokumenpengadaanM::model()->findAllByAttributes(array('dokumenpengadaan_jenistransaksi' => $jenistransaksi, 'jenispengadaan_id' => null, 'metodepengadaan_id' => $metodepengadaan), array('order' => 'dokumenpengadaan_urutan asc'));
        } else {
            $cr = new CDbCriteria();
            $cr->addCondition("dokumenpengadaan_jenistransaksi = '" . $jenistransaksi . "'");
            $cr->addCondition("jenispengadaan_id IS NULL");
            $cr->addCondition("metodepengadaan_id IS NULL");
            $cr->order = "dokumenpengadaan_urutan asc";
            $model = DokumenpengadaanM::model()->findAll($cr);
        }
        
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
