<?php

/**

 * Merubah Data Pengguna
 * controller ini untuk extends ke controller pegawai
 * 
 * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author	    Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @issue           RSST-1975
 * @package application.modules.PortalRS
 * @subpackage controllers
 */
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.PegawaiMController');

class PegawaiProfilController extends PegawaiMController
{
  public $path_viewp = "sistemAdministrator.views.pegawaiM.";

  /**
   * digunakan untuk set dat email ke dialog
   */
  public function actionSetEmail()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = $this->loadModel($_POST['pegawai_id']);

      $data['pegawai_id'] = $model->pegawai_id;
      $data['alamatemail'] = $model->alamatemail;

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk set data hp ke dialog
   */
  public function actionSetHp()
  {

    if (Yii::app()->request->isAjaxRequest) {

      $model = $this->loadModel($_POST['pegawai_id']);

      $data['pegawai_id'] = $model->pegawai_id;
      $data['hp'] = $model->nomobile_pegawai;

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk set data email ke dialog
   */
  public function actionUpdateemail()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $model = $this->loadModel($_POST['pegawai_id']);
      $model->alamatemail = $_POST['email'];
      if ($model->save()) {
        $data['status'] = 'sukses';
        $data['alamatemail'] = $model->alamatemail;
      } else {
        $data['status'] = 'gagal';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk set data hp ke dialog
   */
  public function actionUpdatehp()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $model = $this->loadModel($_POST['pegawai_id']);
      $model->nomobile_pegawai = $_POST['hp'];
      if ($model->save()) {
        $data['status'] = 'sukses';
        $data['hp'] = $model->nomobile_pegawai;
      } else {
        $data['status'] = 'gagal';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk mengambil data sesuai id untuk update data
   * 
   * @param type $id integer
   * @return type object
   * @throws CHttpException
   */
  public function loadModel($id)
  {
    $model = PegawaiM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
}
