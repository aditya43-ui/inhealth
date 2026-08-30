<?php

class InformasiTabularListController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - ICD-10";
    $modTabularList = new RITabularlistM;
    $modDTDM = new RIDtdM;
    $modDiagnosa = new RIDiagnosaM;

    // =========================Update Dari Grid==================================== 
    if (isset($_GET['RITabularlistM'])) {
      $modTabularList->attributes = $_GET['RITabularlistM'];
    }

    if (isset($_GET['RIDtdM'])) {
      $modDTDM->attributes = $_GET['RIDtdM'];
    } else if (isset($_GET['RJDtdM_tabularlist_id'])) {
      $modDTDM->tabularlist_id = $_GET['RJDtdM_tabularlist_id'];
    }

    if (isset($_REQUEST['RIDiagnosaM'])) {
      $modDiagnosa->attributes = $_REQUEST['RIDiagnosaM'];
    } else if (isset($_GET['RJDiagnosaM_dtd_id'])) {
      $modDiagnosa->dtd_id = $_GET['RJDiagnosaM_dtd_id'];
    }
    // =========================Akhir Update Dari Grid============================== 

    //==========================Update Dari Klik====================================




    //==========================Akhir Update Dari Klik==============================
    $this->render('index', array(
      'modTabularList' => $modTabularList, 'modDTDM' => $modDTDM,
      'modDiagnosa' => $modDiagnosa
    ));
  }
}
