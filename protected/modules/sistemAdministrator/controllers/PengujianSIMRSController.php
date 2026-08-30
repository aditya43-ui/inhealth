<?php

/**
 * untuk menguji SIMRS (koneksi & perfoma)
 */
class PengujianSIMRSController extends MyAuthController
{
  public $layout = "//layouts/column1";

  public function actionIndex()
  {
    $dataForm = array();
    //default
    $dataForm['method'] = 'ajaxpost';
    $dataForm['refreshinterval'] = 1;
    $dataForm['pattern'] = 'cactiverecord';
    $dataForm['table_uji'] = 'infokunjunganrj_v';
    $dataForm['model_uji'] = 'InfokunjunganrjV';
    $this->render('index', array('dataForm' => $dataForm));
  }
  /**
   * pengujian melalui ajax
   */
  public function actionAjaxPengujian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "sukses";
      $limit = 50;
      if (isset($_REQUEST['dataForm'])) {
        $req = $_REQUEST['dataForm'];
        if ($req['pattern'] == 'dao') {
          $sql = "SELECT * FROM " . $req['table_uji'] . " LIMIT " . $limit;
          $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
          $criteria = new CDbCriteria();
          $criteria->limit = $limit;
          $loadDatas = $req['model_uji']::model()->findAll($criteria);
        }
        $data['database'] = $loadDatas;
      }

      echo CJSON::encode($data);
    }
  }
}
