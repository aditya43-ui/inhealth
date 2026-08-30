<?php

class BantuanFaqController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.bantuanFaq.';

  public function actionIndex()
  {
    
    $this->render($this->path_view .'index', array());
  }

  public function actionLoadPencarianFaq()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $search = $_GET['search'];
      $criteria = new CDbCriteria();
      $criteria->select = "modul_k.modul_id, modul_k.modul_nama, t.faq_pertanyaan, t.faq_jawaban";
      $criteria->join = "JOIN modul_k on modul_k.modul_id = t.modul_id";
      $criteria->addCondition('t.faq_aktif = true');
      if(!empty($search)){
        $criteria->compare('lower(modul_k.modul_nama)',strtolower($search),true);
        $criteria->compare('lower(t.faq_pertanyaan)',strtolower($search),true,'OR');
        $criteria->compare('lower(t.faq_jawaban)',strtolower($search),true,'OR');
        
      }
      $models = FaqM::model()->findAll($criteria); 
      $row = $this->renderPartial($this->path_view.'loadFaq', array(
            'models' => $models
          ), true);
      echo CJSON::encode($row);
      Yii::app()->end();
    }
  }

}
