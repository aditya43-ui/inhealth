<?php

class DashboardController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $modMenu = new MenumodulK;
    $kelompokMenu = KelompokmenuK::model()->findAllAktif();
    $menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id' => Yii::app()->session['modul_id'], 't.kelmenu_id' => Yii::app()->session['kelMenu']));
    $this->render('index', array(
      'kelompokMenu' => $kelompokMenu,
      'menu' => $menu,
      'modMenu' => $modMenu,
    ));
  }
  /**
   * set list pencarian menu
   */
  public function actionSetListPencarianMenu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPencarian = $post['MenumodulK'];
      $criteria = new CDbCriteria;
      $criteria->join = "join kelompokmenu_k k on t.kelmenu_id = k.kelmenu_id";
      $criteria->compare('LOWER(t.menu_nama)', strtolower($postPencarian['menu_nama']), true);
      $criteria->addCondition('t.modul_id = ' . Yii::app()->session['modul_id']);
      $criteria->addCondition('t.menu_aktif IS TRUE');

      $criteria->order = 'k.kelmenu_urutan asc,t.menu_urutan asc';
      $modPencarianMenu = MenumodulK::model()->findAll($criteria);
      $content = $this->renderPartial('_listMenu', array('modPencarianMenu' => $modPencarianMenu), true);
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }
}
