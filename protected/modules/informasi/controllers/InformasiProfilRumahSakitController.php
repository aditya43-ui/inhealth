<?php
class InformasiProfilRumahSakitController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Profil Rs";
    $model = INProfilRumahSakitM::model()->findByPk(Params::getDefaultProfilRS());

    $this->render('index', array(
      'model' => $model,
    ));
  }

  public function actionAjaxListData()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = INProfilRumahSakitM::model()->findByPk(Params::getDefaultProfilRS());
      $modMisiRS = MisirsM::model()->findAllByAttributes(array('profilrs_id' => $model->profilrs_id));
      $form = '';
      if ($_POST['listData'] == 'visi') {
        $form .= $this->renderPartial('_visi', array('model' => $model), true);
      } else if ($_POST['listData'] == 'motto') {
        $form .= $this->renderPartial('_motto', array('model' => $model), true);
      } else if ($_POST['listData'] == 'misi') {
        $form .= $this->renderPartial('_misi', array('modMisiRS' => $modMisiRS), true);
      } else if ($_POST['listData'] == 'fasilitas') {
        $criteria = new CDbCriteria;
        $criteria->addCondition('instalasi_id = ' . Params::INSTALASI_ID_RI . ' OR instalasi_id = ' . Params::INSTALASI_ID_RD . ' OR instalasi_id = ' . Params::INSTALASI_ID_RJ);
        $modInstalasi = InstalasiM::model()->findAll($criteria);
        $form .= $this->renderPartial('_fasilitas', array('modInstalasi' => $modInstalasi), true);

        //				$criteria=new CDbCriteria;
        //				$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI.' OR instalasi_id = '.Params::INSTALASI_ID_RD.' OR instalasi_id = '.Params::INSTALASI_ID_RJ);
        //				$modInstalasi = RuanganM::model()->findAll($criteria);
        //				$form .= $this->renderPartial('_fasilitas',array('modInstalasi'=>$modInstalasi),true);
      }

      $data['isidata'] = $form;
      echo json_encode($data);
    }
  }
}
