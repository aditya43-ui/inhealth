<?php
/**
 * Master Tujuan
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 */
class TujuanController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $path_view = 'sistemAdministrator.views.tujuan.';

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
        $format = new MyFormatter;
        $model = new SATujuanM();
        $model->tujuan_aktif = true;
        
        if (isset($_POST['SATujuanM'])) {
            $model->attributes = $_POST['SATujuanM'];
            $model->diagnosakep_id = null;
            $model->tujuan_nama = $_POST['SATujuanM']['tujuan_nama'];
            $model->tujuan_aktif = $_POST['SATujuanM']['tujuan_aktif'];
            $model->luarankeperawatan_id = $_POST['SATujuanM']['luarankeperawatan_id'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->tujuan_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> Data gagal disimpan.');
                $this->redirect(array('admin', 'id' => $model->tujuan_id));
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $format = new MyFormatter;
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        if (!empty($model->luarankeperawatan_id)) {
            $model->luarankeperawatan_nama = $model->luarankeperawatan->luarankeperawatan_nama;
        }

        if (isset($_POST['SATujuanM'])) {
            $model->attributes = $_POST['SATujuanM'];
            $model->diagnosakep_id = null;
            $model->tujuan_nama = $_POST['SATujuanM']['tujuan_nama'];
            $model->tujuan_aktif = $_POST['SATujuanM']['tujuan_aktif'];
            $model->luarankeperawatan_id = $_POST['SATujuanM']['luarankeperawatan_id'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('admin', 'id' => $model->tujuan_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> Data gagal disimpan.');
                $this->redirect(array('admin', 'id' => $model->tujuan_id));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {
            // we only allow deletion via POST request
            $transaction = Yii::app()->db->beginTransaction();
            try {
                SATujuanM::model()->deleteAllByAttributes(array('tujuan_id' => $_GET['id']));
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal Dihapus");
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
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SATujuanM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new SATujuanM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SATujuanM'])) {
            $model->attributes = $_GET['SATujuanM'];
//            $model->diagnosakep = isset($_GET['SATujuanM']['diagnosakep']) ? $_GET['SATujuanM']['diagnosakep'] : NULL;
            $model->luarankeperawatan_nama = isset($_GET['SATujuanM']['luarankeperawatan_nama']) ? $_GET['SATujuanM']['luarankeperawatan_nama'] : NULL;
            $model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : NULL;
            $model->tujuan_aktif = isset($_GET['SATujuanM']['tujuan_aktif']) ? $_GET['SATujuanM']['tujuan_aktif'] : NULL;
        }
        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->with = array('diagnosakep');
        $criteria->addCondition('tujuan_id =' . $id);
        $model = SATujuanM::model()->find($criteria);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sarekeningcolumn-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new SATujuanM('searchPrint');
        $model->unsetAttributes();
        if (isset($_REQUEST['SATujuanM'])) {
            $model->attributes = $_REQUEST['SATujuanM'];
        }
        $judulLaporan = 'Data Tujuan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Autocompelete luaran
     */
    public function actionAutoCompleteLuaranKeperawatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $term = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria = new CDbCriteria();
            $term = strtolower(trim($_GET['term']));

            $condition = "LOWER(luarankeperawatan_nama) LIKE '%" . $term . "%'";
            $criteria->addCondition($condition);
            $criteria->order = 'luarankeperawatan_nama';
            $criteria->limit = 5;

            $models = LuarankeperawatanM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->luarankeperawatan_nama;
                $returnVal[$i]['value'] = $model->luarankeperawatan_nama;
                $returnVal[$i]['luarankeperawatan_id'] = $model->luarankeperawatan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Menonaktifkan status 
     */
    public function actionNonActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = TujuanM::model()->findByPk($id);
            // set non-active this
            // example: 
            $model->tujuan_aktif = false;
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Mengaktifkan data 
     * @param type $id
     */
    public function actionActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = TujuanM::model()->findByPk($id);
            // set non-active this
            // example: 
            $model->tujuan_aktif = true;
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

}
