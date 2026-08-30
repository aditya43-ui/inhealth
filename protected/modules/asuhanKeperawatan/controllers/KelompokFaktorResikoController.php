<?php
/**
 * Master Kelompok Faktor Risiko
 * 
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 */
class KelompokFaktorResikoController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $simpan = true;
    public $path_view = 'asuhanKeperawatan.views.kelompokFaktorResiko.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = KelompokfaktorrisikodaftarM::model()->findByAttributes(array('kelompokfaktorrisikodaftar_id' => $id));
        $this->render($this->path_view . 'view', array(
            'model' => $model,
        ));
    }
    
    /**
     * Halaman tambah master kelompok faktor resiko
     */
    public function actionCreate() {
        $model = new ASKelompokFaktorResikoM();
        $modDetail = new ASKelompokFaktorResikoM;
        $modDet = new KelompokfaktorrisikodaftarM;
        if (isset($_POST['KelompokfaktorrisikodaftarM'])) {
            echo '<pre>';
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                foreach ($_POST['KelompokfaktorrisikodaftarM'] as $key => $val) {
                    if (!empty($val['kelompokfaktorrisikodaftar_id'])) {
                        $model = KelompokfaktorrisikodaftarM::model()->findByPk($val['kelompokfaktorrisikodaftar_id']);
                        $model->update_time = date('Y-m-d H:i:s');
                        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    } else {
                        $model = new KelompokfaktorrisikodaftarM;
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $model->kelompokfaktorrisikodaftar_urutan = 1;
                    }
                    $model->attributes = $val;
                    $model->jenisfaktorrisiko_id = $val['jenisfaktorrisiko_id'];
                    $model->faktorrisiko_daftar_id = $val['faktorrisiko_daftar_id'];
                    $model->kelompokfaktorrisikodaftar_aktif = $val['kelompokfaktorrisikodaftar_aktif'];

                    $ok = $ok && $model->save();
                }

                if ($ok) {
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
            'model' => $model,
            'modDetail' => $modDetail,
            'modDet' => $modDet
        ));
    }
    
    /**
     * Halaman ubah master kelompok faktor resiko
     * @param type $id
     */
    public function actionUpdate($id) {
        $model = ASKelompokFaktorResikoM::model()->findByPk($id);
        $modDet = new KelompokfaktorrisikodaftarM;
        if (isset($_POST['KelompokfaktorrisikodaftarM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                foreach ($_POST['KelompokfaktorrisikodaftarM'] as $key => $val) {
                    if (!empty($val['kelompokfaktorrisikodaftar_id'])) {
                        $model = KelompoktandagejaladaftarM::model()->findByPk($val['kelompokfaktorrisikodaftar_id']);
                        $model->update_time = date('Y-m-d H:i:s');
                        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    } else {
                        $model = new KelompoktandagejaladaftarM;
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $model->kelompokfaktorrisikodaftar_urutan = 1;
                    }
                    $model->attributes = $val;
                    $model->jenisfaktorrisiko_id = $val['jenisfaktorrisiko_id'];
                    $model->faktorrisiko_daftar_id = $val['faktorrisiko_daftar_id'];
                    $model->kelompokfaktorrisikodaftar_aktif = $val['kelompokfaktorrisikodaftar_aktif'];

                    $ok = $ok && $model->save();
                }

                if ($ok) {
                    $transaction->commit();
                    $this->redirect(array('index', 'sukses' => 1));
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
            'model' => $model,
            'modDet' => $modDet
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ASKelompokFaktorResikoM');
        $this->render($this->path_view . 'index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ASKelompokFaktorResikoM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ASKelompokFaktorResikoM'])) {
            $model->attributes = $_GET['ASKelompokFaktorResikoM'];
            $model->jenisfaktorrisiko_nama = isset($_GET['ASKelompokFaktorResikoM']['jenisfaktorrisiko_nama']) ? $_GET['ASKelompokFaktorResikoM']['jenisfaktorrisiko_nama'] : NULL;
            $model->faktorrisiko_daftar_nama = isset($_GET['ASKelompokFaktorResikoM']['faktorrisiko_daftar_nama']) ? $_GET['ASKelompokFaktorResikoM']['faktorrisiko_daftar_nama'] : NULL;
            $model->kelompokfaktorrisikodaftar_aktif = $_GET['ASKelompokFaktorResikoM']['kelompokfaktorrisikodaftar_aktif'];
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

        $model= ASKelompokFaktorResikoM::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
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
     * Fungsi hapus master kelompok faktor resiko
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            KelompokfaktorrisikodaftarM::model()->deleteByPk($id);
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
    
    /**
     * Mengubah status aktif menjadi nonaktif
     * @param type $id 
     */
    public function actionremoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = KelompokfaktorrisikodaftarM::model()->updateByPk($id, array('kelompokfaktorrisikodaftar_aktif' => false));
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
     * Mengubah status nonaktif menjadi aktif
     * @param type $id 
     */
    public function actionaddTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = KelompokfaktorrisikodaftarM::model()->updateByPk($id, array('kelompokfaktorrisikodaftar_aktif' => true));
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
     * Get data master kelompok faktor resiko yang sudah pernah diinputkan
     * @param type $jenistandagejala_id
     */
    public function actionGetData($jenisfaktorrisiko_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['form'] = "";
            $modDet = KelompokfaktorrisikodaftarM::model()->findAllByAttributes(array('jenisfaktorrisiko_id' => $jenisfaktorrisiko_id), array('order' => 'jenisfaktorrisiko_id'));
            if (count($modDet) > 0) {
                foreach ($modDet as $det) {
                    $cekkelompok = KelompokfaktorrisikodaftarM::model()->findByPk($det->kelompokfaktorrisikodaftar_id);
                    if (!empty($cekkelompok->faktorrisiko_daftar_id)) {
                        $cekJenis = FaktorrisikoDaftarM::model()->findByPk($cekkelompok->faktorrisiko_daftar_id);
                        if (!empty($cekJenis)) {
                            $det->faktorrisiko_daftar_nama = $cekJenis->faktorrisiko_daftar_nama;
                        }
                    }
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowFaktorRisiko', array('model' => $det), true);
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Generate faktor resiko 
     */
    public function actionGetGejala() {
        if (Yii::app()->request->isAjaxRequest) {
            $jenisfaktorrisiko_id = isset($_POST['jenisfaktorrisiko_id']) ? $_POST['jenisfaktorrisiko_id'] : null;
            $faktorrisiko_daftar_id = isset($_POST['faktorrisiko_daftar_id']) ? $_POST['faktorrisiko_daftar_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;

            $cri = new CDbCriteria();
            if (is_array($faktorrisiko_daftar_id)) {
                $cri->addInCondition("t.faktorrisiko_daftar_id", $faktorrisiko_daftar_id);
            } else {
                $cri->addCondition("t.faktorrisiko_daftar_id = '" . $faktorrisiko_daftar_id . "' ");
            }
            $modGejala = FaktorrisikoDaftarM::model()->findAll($cri);

            $tr = '';
            foreach ($modGejala as $det) {
                $model = new KelompokfaktorrisikodaftarM();
                $model->kelompokfaktorrisikodaftar_aktif = $status;
                $model->jenisfaktorrisiko_id = $jenisfaktorrisiko_id;
                $model->faktorrisiko_daftar_id = $det->faktorrisiko_daftar_id;
                $model->faktorrisiko_daftar_nama = $det->faktorrisiko_daftar_nama;
                $tr .= $this->renderPartial($this->path_view . '_rowFaktorRisiko', array('model' => $model), true);
            }
            echo json_encode($tr);
            Yii::app()->end();
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
}
