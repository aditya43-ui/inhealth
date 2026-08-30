<?php

class InformasiTabularListController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Icd-10";
    $modTabularList = new PITabularlistM;
    $modDTDM = new PIDtdM;
    $modDiagnosa = new PIDiagnosaM;

    // =========================Update Dari Grid==================================== 
    if (isset($_GET['PITabularlistM'])) {
      $modTabularList->attributes = $_GET['PITabularlistM'];
    }

    if (isset($_GET['PIDtdM'])) {
      $modDTDM->attributes = $_GET['PIDtdM'];
    } else if (isset($_GET['RJDtdM_tabularlist_id'])) {
      $modDTDM->tabularlist_id = $_GET['RJDtdM_tabularlist_id'];
    }

    if (isset($_REQUEST['PIDiagnosaM'])) {
      $modDiagnosa->attributes = $_REQUEST['PIDiagnosaM'];
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
