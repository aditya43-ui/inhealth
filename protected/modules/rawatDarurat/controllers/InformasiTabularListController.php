<?php

class InformasiTabularListController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - ICD-10";
    $modTabularList = new RDTabularListM;
    $modDTDM = new RDDtdM;
    $modDiagnosa = new RDDiagnosaM;

    // =========================Update Dari Grid==================================== 
    if (isset($_GET['RDTabularListM'])) {
      $modTabularList->attributes = $_GET['RDTabularListM'];
    }

    if (isset($_GET['RDDtdM'])) {
      $modDTDM->attributes = $_GET['RDDtdM'];
    } else if (isset($_GET['RDDtdM_tabularlist_id'])) {
      $modDTDM->tabularlist_id = $_GET['RDDtdM_tabularlist_id'];
    }

    if (isset($_REQUEST['RDDiagnosaM'])) {
      $modDiagnosa->attributes = $_REQUEST['RDDiagnosaM'];
    } else if (isset($_GET['RDDiagnosaM_dtd_id'])) {
      $modDiagnosa->dtd_id = $_GET['RDDiagnosaM_dtd_id'];
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
