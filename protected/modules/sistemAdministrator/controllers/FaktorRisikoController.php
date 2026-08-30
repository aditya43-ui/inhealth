<?php

/**
 * Master Faktor Risiko
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 */
class FaktorRisikoController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'sistemAdministrator.views.faktorRisiko.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render($this->path_view . 'view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model      = new SAFaktorrisikoM;
        $modDetail  = new SAFaktorrisikodetM;
        $kelompok   = [];
        if (isset($_POST['SAFaktorrisikoM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                /*
                $model->attributes = $_POST['SAFaktorrisikoM'];
                $model->faktorrisiko_nama = $_POST['SAFaktorrisikoM']['faktorrisiko_nama'];

                $batkar = SAFaktorrisikoM::model()->findByAttributes(array('diagnosakep_id' => $_POST['SAFaktorrisikoM']['diagnosakep_id'], 'faktorrisiko_nama' => $_POST['SAFaktorrisikoM']['faktorrisiko_nama']));
                if (!empty($batkar)) {
                    $this->simpanBatasDetail($batkar->faktorrisiko_id, $_POST['SAFaktorrisikodetM']);
                } else {
                    if ($model->save()) {
                        $this->simpanBatasDetail($model->faktorrisiko_id, $_POST['SAFaktorrisikodetM']);
                    }
                }
                 */
                $model->attributes      = $_POST['SAFaktorrisikoM'];
                $model->diagnosakep_id  = $_POST['SAFaktorrisikoM']['diagnosakep_id'];
                
                foreach($_POST['SAFaktorrisikoM']['detail'] As $key => $val){
                    $new = new SAFaktorrisikoM;
                    $new->attributes = $val;
                    $new->diagnosakep_id = $model->diagnosakep_id;
                    $new->faktorrisiko_nama = $val['faktorrisiko_nama'];
                    $new->kelompokfaktorrisikodaftar_id = $val['kelompokfaktorrisikodaftar_id'];
                    $new->faktorrisiko_aktif = true;
                    
                    if($new->save()){
                        $this->simpan &= true;
                    }else{
                        $this->simpan &= true;
                    }
                }

                if ($this->simpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
            }
        }
        $this->render($this->path_view . 'create', array(
            'model'     => $model,
            'modDetail' => $modDetail,
            'kelompok'  => $kelompok,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model      = $this->loadModel($id);
        $detail     = $this->loadDetail($model->diagnosakep_id, $model->jenisfaktorrisiko_id);
        $modDetail  = new SAFaktorrisikodetM;
        $kelompok   = [];
        $model->faktorrisiko_nama = $model-> jenisfaktorrisiko_id;
        
        foreach ($detail As $key => $val){
            $kelompok[] = $val->kelompokfaktorrisikodaftar_id;
        }
        
        if (isset($_POST['SAFaktorrisikoM'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($detail As $i => $ii){
                    SAFaktorrisikoM::model()->deleteByPk($ii->faktorrisiko_id);
                }
                
                foreach($_POST['SAFaktorrisikoM']['detail'] As $key => $val){
                    $new = new SAFaktorrisikoM;
                    $new->attributes = $val;
                    $new->diagnosakep_id = $_POST['SAFaktorrisikoM']['diagnosakep_id'];
                    $new->faktorrisiko_nama = $val['faktorrisiko_nama'];
                    $new->kelompokfaktorrisikodaftar_id = $val['kelompokfaktorrisikodaftar_id'];
                    
                    if($new->save()){
                        $this->simpan &= true;
                    }else{
                        $this->simpan &= true;
                    }
                }
                
                if ($this->simpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model'     => $model,
            'modDetail' => $modDetail,
            'kelompok'  => $kelompok,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SAFaktorrisikoM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SAFaktorrisikoM;
        $model->unsetAttributes();  // clear any default values
        $model->faktorrisiko_aktif = 1;
        $model->aktif = 'y';
        if (isset($_GET['SAFaktorrisikoM'])) {
            $model->attributes = $_GET['SAFaktorrisikoM'];
            $model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : null;
            
            if(isset($_GET['SAFaktorrisikoM']['faktorrisiko_aktif'])){
                if($_GET['SAFaktorrisikoM']['faktorrisiko_aktif'] == 1){
                    $model->aktif = 'y';
                }else{
                    $model->aktif = 'n';
                }                
            }
            
            $model->diagnosakep_nama = isset($_GET['SAFaktorrisikoM']['diagnosakep_nama']) ? $_GET['SAFaktorrisikoM']['diagnosakep_nama'] : null;
            $model->faktorrisiko_nama = isset($_GET['SAFaktorrisikoM']['faktorrisiko_nama']) ? $_GET['SAFaktorrisikoM']['faktorrisiko_nama'] : null;
            $model->jenisfaktorrisiko_id = isset($_GET['SAFaktorrisikoM']['jenisfaktorrisiko_id']) ? $_GET['SAFaktorrisikoM']['jenisfaktorrisiko_id'] : null;
            $model->jenisfaktorrisiko_nama = isset($_GET['SAFaktorrisikoM']['jenisfaktorrisiko_nama']) ? $_GET['SAFaktorrisikoM']['jenisfaktorrisiko_nama'] : null;
        }
        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {

        $model = SAFaktorrisikoM::model()->findBySql('SELECT t.*
            , a.diagnosakep_id
            , a.diagnosakep_nama
            , c.jenisfaktorrisiko_id
            , c.jenisfaktorrisiko_nama
            , faktorrisiko_daftar_nama
            FROM faktorrisiko_m t 
            left join diagnosakep_m a on a.diagnosakep_id = t.diagnosakep_id 
            left join kelompokfaktorrisikodaftar_m b on b.kelompokfaktorrisikodaftar_id = t.kelompokfaktorrisikodaftar_id 
            left join jenisfaktorrisiko_m c on c.jenisfaktorrisiko_id = b.jenisfaktorrisiko_id
            left join faktorrisiko_daftar_m f on f.faktorrisiko_daftar_id = b.faktorrisiko_daftar_id
            WHERE t.faktorrisiko_id =' . $id);
        
        return $model;
    }
    
    public function loadDetail($diagnosakep_id, $jenisfaktorrisiko_id)
    {
        
        $filter_jenisfaktorrisiko_id = !empty($jenisfaktorrisiko_id) ? " and c.jenisfaktorrisiko_id = ".$jenisfaktorrisiko_id."" : "";
        $model = SAFaktorrisikoM::model()->findAllBySql("SELECT t.*
            , a.diagnosakep_id
            , a.diagnosakep_nama
            , c.jenisfaktorrisiko_id
            , c.jenisfaktorrisiko_nama
            , faktorrisiko_daftar_nama
            , b.kelompokfaktorrisikodaftar_id
            FROM faktorrisiko_m t 
            left join diagnosakep_m a on a.diagnosakep_id = t.diagnosakep_id 
            left join kelompokfaktorrisikodaftar_m b on b.kelompokfaktorrisikodaftar_id = t.kelompokfaktorrisikodaftar_id 
            left join jenisfaktorrisiko_m c on c.jenisfaktorrisiko_id = b.jenisfaktorrisiko_id
            left join faktorrisiko_daftar_m f on f.faktorrisiko_daftar_id = b.faktorrisiko_daftar_id
            WHERE a.diagnosakep_id = '".$diagnosakep_id."'". $filter_jenisfaktorrisiko_id);
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'salookup-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Fungsi simpan batas
     * @param type $post
     */
    public function simpanBatas($post) {
        $model = new SAFaktorrisikoM;
        $model->attributes = $post;
        $model->faktorrisiko_nama = $post['faktorrisiko_nama'];

        if (!$model->save()) {
            $this->simpan &= false;
        }
    }

    /**
     * Fungsi simpan batas detail
     * @param type $faktorrisiko_id
     * @param type $post
     */
    public function simpanBatasDetail($faktorrisiko_id, $post) {
        foreach ($post as $i => $row) {

            /*
              if (!empty($row['faktorrisikodet_id'])) {
              SAFaktorrisikodetM::model()->updateByPk($row['faktorrisikodet_id'], array('faktorrisikodet_indikator' => $row['faktorrisikodet_indikator'],
              'faktorrisikodet_aktif' => $row['faktorrisikodet_aktif']));
              $this->simpan &= true;
              } else {
             * 
             */
            $model = new SAFaktorrisikodetM;
            $model->attributes = $row;
            $model->faktorrisiko_id = $faktorrisiko_id;
            $model->faktorrisikodet_indikator = $row['faktorrisikodet_indikator'];
            $model->faktorrisikodet_aktif = $row['faktorrisikodet_aktif'];
            if (!$model->save()) {
                $this->simpan &= false;
            }
            // }
        }
    }

    /**
     * Fungsi cetak
     */
    public function actionPrint() {
        $model = new SAFaktorrisikoM;
        $model->attributes = $_REQUEST['SAFaktorrisikoM'];
        $judulLaporan = 'Data Faktor Risiko';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }


    /**
     * Get data
     * @param type $diagnosakep_id
     * @param type $faktorrisiko_id
     */
    public function actionGetLookup($diagnosakep_id, $faktorrisiko_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new FaktorrisikoM();
            $data['form'] = "";
            $models = $this->loadModelByType($diagnosakep_id, $faktorrisiko_id);
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $modDet = FaktorrisikoM::model()->findAllByAttributes(array('faktorrisiko_id' => $model->faktorrisiko_id), array('order' => 'faktorrisiko_id'));
                    if (count($modDet) > 0) {
                        foreach ($modDet as $det) {
                            $cekkelompok = KelompokfaktorrisikodaftarM::model()->findByPk($det->kelompokfaktorrisikodaftar_id);
                            if (!empty($cekkelompok->faktorrisiko_daftar_id)) {
                                $cekJenis = FaktorrisikoDaftarM::model()->findByPk($cekkelompok->faktorrisiko_daftar_id);
                                if (!empty($cekJenis)) {
                                    $det->faktorrisiko_daftar_nama = $cekJenis->faktorrisiko_daftar_nama;
                                }
                            }
                            $data['form'] .= $this->renderPartial($this->path_view . '_rowKelompok', array('model' => $det), true);
                        }
                    }
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load model by diagnosaaskep
     * @param type $diagnosakep_id
     * @param type $faktorrisiko_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelByType($diagnosakep_id, $faktorrisiko_id) {
        $criteria = new CDbCriteria();
        $criteria->join = 'JOIN kelompokfaktorrisikodaftar_m ON kelompokfaktorrisikodaftar_m.kelompokfaktorrisikodaftar_id = t.kelompokfaktorrisikodaftar_id';
        $criteria->addCondition('t.diagnosakep_id = ' . $diagnosakep_id);
        $criteria->addCondition('kelompokfaktorrisikodaftar_m.jenisfaktorrisiko_id = ' . $faktorrisiko_id);
        $criteria->order = 'faktorrisiko_id';
        $model = SAFaktorrisikoM::model()->findAll($criteria);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Fungsi hapus data detail
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            SAFaktorrisikoM::model()->deleteByPk($id);
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Mengubah status aktif
     */
    public function actionremoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = SAFaktorrisikoM::model()->updateByPk($id, array('faktorrisiko_aktif' => false));
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
     * untuk aktifkan faktor resiko
     */
    public function actionAktif() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = SAFaktorrisikoM::model()->updateByPk($id, array('faktorrisiko_aktif' => true));
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
     * Autocomplete Faktor Risiko
     */
    public function actionAutoCompleteFaktorRisiko() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(faktorrisiko_daftar_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition('faktorrisiko_daftar_aktif is true');
            $criteria->limit = 5;
            $models = FaktorrisikoDaftarM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->faktorrisiko_daftar_nama;
                $returnVal[$i]['value'] = $model->faktorrisiko_daftar_id;
                $returnVal[$i]['faktorrisiko_daftar_nama'] = $model->faktorrisiko_daftar_nama;
                $returnVal[$i]['faktorrisiko_daftar_id'] = $model->faktorrisiko_daftar_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * gi gunakan untuk multi centang
     */
    public function actionSetResiko() {
        if (Yii::app()->request->isAjaxRequest) {
            $id     = isset($_POST['id']) ? $_POST['id'] : null;
            $cri    = new CDbCriteria();
            $cri->select = "t.kelompokfaktorrisikodaftar_id"
                . ", jenisfaktorrisiko_id"
                . ", faktorrisiko_daftar_nama"
                . ", faktorrisiko_daftar_namalain";
            $cri->join = " left join faktorrisiko_daftar_m f on f.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id";
            
            if (is_array($id)) {
                $cri->addInCondition("t.kelompokfaktorrisikodaftar_id", $id);
            } else {
                $cri->$id("t.kelompoktandagejaladaftar_id = '" . $id . "' ");
            }
            $modKelompok = SAKelompokfaktorrisikodaftarM::model()->findAll($cri);

            $tr = '';
            foreach($modKelompok as $det){
                $model = new SAFaktorrisikoM();
                $model->kelompokfaktorrisikodaftar_id = $det['kelompokfaktorrisikodaftar_id'];
                $model->faktorrisiko_nama = $det['faktorrisiko_daftar_nama'];
                $tr .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model, 'from'=>$_POST['from']), true);
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

}
