<?php

class ApprovalMenuFarmasiController extends MyAuthController
{
    function actionIndex() {
        
        $modMenuModul = new MenumodulK('findMenuById');
        $modMenuModul->modul_id = Params::MODUL_ID_APOTEK;

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'samenu-modul-k-grid') {
                $this->renderPartial('_table', ['modMenuModul' => $modMenuModul]);
                Yii::app()->end();
            }
        }
        $this->render('index', [
            'modMenuModul' => $modMenuModul
        ]);
    }

    function actionMenuRuangan($menu_id) {
        $dataRuanganDipilih = $this->getData($menu_id);

        if(isset($_POST['menuRuangan'])) {
           
            try {
                $transaction = Yii::app()->db->beginTransaction();
      
                $save = true;
                $delete = $this->deleteMenuRuangan($menu_id);
                if(isset($_POST['ruangan_id']) && count($_POST['ruangan_id']) > 0) {
                    foreach ($_POST['ruangan_id'] as $i => $ruangan_id) {
                        $model = new MenuruanganfarmasiK();
                        $model->menu_id = $menu_id;
                        $model->ruangan_id = $ruangan_id;
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
                    $this->redirect(array('index'));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan");
                }
            } catch (Exception $exc) {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan" . $exc->getMessage());
            }
        }
       
        $this->render('menuRuangan', [
            'dataRuanganDipilih' => $dataRuanganDipilih
        ]);
    }

    function deleteMenuRuangan($menu_id) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('menu_id =' . $menu_id);
        return MenuruanganfarmasiK::model()->deleteAll($criteria);
    }

    function getData($menu_id) {
        $model = MenuruanganfarmasiK::model()->findAllByAttributes(['menu_id' => $menu_id]);
        if(empty($model)) {
          $model = [];
        } else {
          foreach ($model as $val) {
              $arr[] = $val->ruangan_id;
          }
          $model = $arr;
        }
        return $model;
      }
}