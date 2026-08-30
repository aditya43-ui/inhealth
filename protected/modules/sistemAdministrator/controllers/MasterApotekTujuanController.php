<?php
class MasterApotekTujuanController extends MyAuthController
{
    function actionIndex() {
        $model = new RuanganM();

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'ruanganapotek-grid') {
                $this->renderPartial('_table', [
                    'model' => $model
                ]);
                Yii::app()->end();
            }
        }
        $this->render('index', [
            'model' => $model
        ]);
    }

    function actionCreate() {
        $this->layout = '//layouts/iframe';

        $ruanganapotektujuan_id = $_GET['ruanganapotektujuan_id'];

        $modRuangan = RuanganM::model()->findByPk($ruanganapotektujuan_id);
        $dataRuanganDipilih = $this->getData($ruanganapotektujuan_id);
        
        $model = RuanganapotektujuanK::model()->findByAttributes(['ruanganapotektujuan_id' => $ruanganapotektujuan_id]);
        
        if(empty($model)) {
            $model = new RuanganapotektujuanK();
        }
        
        if(isset($_POST['RuanganapotektujuanK'])) {
            // echo '<pre>';var_dump($_POST);die;
            try {
                $transaction = Yii::app()->db->beginTransaction();
                
                $save = true;
                $this->delete($ruanganapotektujuan_id);
                if(isset($_POST['ruangan_pelayanan_id']) && count($_POST['ruangan_pelayanan_id']) > 0) {
                    foreach ($_POST['ruangan_pelayanan_id'] as $i => $ruangan_pelayanan_id) {
                        $model = new RuanganapotektujuanK();
                        $model->ruanganapotektujuan_id = $ruanganapotektujuan_id;
                        $model->ruanganpelayanan_id = $ruangan_pelayanan_id;
                        $model->is_alih = $_POST['RuanganapotektujuanK']['is_alih'];
                        $model->alihke_ruanganapotektujuan_id = $_POST['RuanganapotektujuanK']['alihke_ruanganapotektujuan_id'];
                        $model->alihkan_jam = !empty($_POST['RuanganapotektujuanK']['alihkan_jam']) ? $_POST['RuanganapotektujuanK']['alihkan_jam'] : null;
                        if($model->save()) {
                            $save = true;
                        } else {
                            $save = false;
                        }
                    }
                }
                
                if ($save) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    // $this->redirect(array('view','id'=>$model->approvalotorisasi_id));
                    $this->redirect(array('create', 'ruanganapotektujuan_id' => $ruanganapotektujuan_id));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan");
                }
            } catch (Exception $exc) {
                // echo '<pre>';var_dump($exc);die;
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan" . $exc->getMessage());
            }
        }

        $this->render('_form', [
            'model' => $model,
            'modRuangan' => $modRuangan,
            'dataRuanganDipilih' => $dataRuanganDipilih
        ]);
    }

    function getData($ruanganapotektujuan_id) {
        $model = RuanganapotektujuanK::model()->findAllByAttributes(['ruanganapotektujuan_id' => $ruanganapotektujuan_id]);
        if(empty($model)) {
        $model = [];
        } else {
        foreach ($model as $val) {
            $arr[] = $val->ruanganpelayanan_id;
        }
        $model = $arr;
        }
        return $model;
    }

    function delete($ruanganapotektujuan_id) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('ruanganapotektujuan_id =' . $ruanganapotektujuan_id);
        return RuanganapotektujuanK::model()->deleteAll($criteria);
    }
}