<?php

class InformasiTabularListController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - ICD-10";
    $modTabularList = new RJTabularListM;
    $modDTDM = new RJDtdM;
    $modDiagnosa = new RJDiagnosaM;

    // =========================Update Dari Grid==================================== 
    if (isset($_GET['RJTabularListM'])) {
      $modTabularList->attributes = $_GET['RJTabularListM'];
    }
    if (isset($_GET['RJDtdM'])) {
      $modDTDM->attributes = $_GET['RJDtdM'];
    } else if (isset($_GET['RJDtdM_tabularlist_id'])) {
      $modDTDM->tabularlist_id = $_GET['RJDtdM_tabularlist_id'];
    }

    if (isset($_REQUEST['RJDiagnosaM'])) {
      $modDiagnosa->attributes = $_GET['RJDiagnosaM'];
      $modDiagnosa->dtd_id = $_GET['RJDiagnosaM']['dtd_id'];
    } else if (isset($_GET['RJDDiagnosa_dtd_id'])) {
      $modDiagnosa->dtd_id = $_GET['RJDDiagnosa_dtd_id'];
    }

    // =========================Akhir Update Dari Grid============================== 

    //==========================Update Dari Klik====================================




    //==========================Akhir Update Dari Klik==============================

    //if (Yii::app()->request->isAjaxRequest) {
    //       echo $this->renderPartial('_table', array('modDTDM'=>$modDTDM),true);
    //    }else{
    $this->render('index', array(
      'modTabularList' => $modTabularList, 'modDTDM' => $modDTDM,
      'modDiagnosa' => $modDiagnosa
    ));

    //     }

  }
}
