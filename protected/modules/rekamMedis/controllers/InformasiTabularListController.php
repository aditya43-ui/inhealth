<?php

class InformasiTabularListController extends MyAuthController
{
  public function actionIndex()
  {
    $modTabularList = new RKTabularlistM;
    $modDTDM = new RKDtdM;
    $modDiagnosa = new RKDiagnosaM;

    // =========================Update Dari Grid==================================== 
    if (isset($_GET['RKTabularlistM'])) {
      $modTabularList->attributes = $_GET['RKTabularlistM'];
    }

    if (isset($_GET['RKDtdM'])) {
      $modDTDM->attributes = $_GET['RKDtdM'];
    } else if (isset($_GET['RKDtdM_tabularlist_id'])) {
      $modDTDM->tabularlist_id = $_GET['RKDtdM_tabularlist_id'];
    }

    if (isset($_REQUEST['RKDiagnosaM'])) {
      $modDiagnosa->attributes = $_REQUEST['RKDiagnosaM'];
    } else if (isset($_GET['RKDDiagnosaM_dtd_id'])) {
      $modDiagnosa->dtd_id = $_GET['RKDDiagnosaM_dtd_id'];
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
