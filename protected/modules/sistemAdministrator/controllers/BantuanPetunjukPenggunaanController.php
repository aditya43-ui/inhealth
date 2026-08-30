<?php

class BantuanPetunjukPenggunaanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'application.modules.sistemAdministrator.views.bantuanPetunjukPenggunaan.';
  // application.modules.kepegawaian.views.realisasiLemburT.

  public function actionIndex()
  {
    $this->render($this->path_view . 'index', array());
  }

  public function actionLoadPencarian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $search = $_GET['search'];
      $criteria = new CDbCriteria();
      $criteria->select = "modul_k.modul_id, modul_k.modul_nama, menumodul_k.menu_id, menumodul_k.menu_nama, t.petunjukpenggunaan_versi, t.petunjukpenggunaan_deskripsi, t.petunjukpenggunaan_id";
      $criteria->join = "join menumodul_k on menumodul_k.menu_id = t.menu_id 
      JOIN modul_k on modul_k.modul_id = menumodul_k.modul_id ";
      $criteria->addCondition('t.petunjukpenggunaan_aktif = true');
      if(!empty($search)){
        $criteria->compare('lower(modul_k.modul_nama)',strtolower($search),true);
        $criteria->compare('lower(menumodul_k.menu_nama)',strtolower($search),true,'OR');
        $criteria->compare('lower(t.petunjukpenggunaan_versi)',strtolower($search),true,'OR');
        $criteria->compare('lower(t.petunjukpenggunaan_deskripsi)',strtolower($search),true,'OR');
        
      }
      $models = PetunjukpenggunaanM::model()->findAll($criteria); 
      $row = $this->renderPartial($this->path_view.'loadPetunjuk', array(
            'models' => $models
          ), true);
      echo CJSON::encode($row);
      Yii::app()->end();
    }
  }

}
