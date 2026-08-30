<?php

class InformasiTabularListController extends MyAuthController
{
	public function actionIndex()
	{
                $modTabularList= new HDTabularListM;
                $modDTDM=new HDDtdM;
                $modDiagnosa=new HDDiagnosaM;
                
// =========================Update Dari Grid==================================== 
                if(isset($_GET['HDTabularListM'])){
                    $modTabularList->attributes=$_GET['HDTabularListM'];
                }
                
                if(isset($_GET['HDDtdM'])){
                    $modDTDM->attributes=$_GET['HDDtdM'];
                }
                else if(isset($_GET['HDDtdM_tabularlist_id'])){
                       $modDTDM->tabularlist_id=$_GET['HDDtdM_tabularlist_id']; 
                } 
                
                 if(isset($_REQUEST['HDDiagnosaM'])){
                    $modDiagnosa->attributes=$_REQUEST['HDDiagnosaM'];
                }
                else if(isset($_GET['HDDiagnosaM_dtd_id'])){
                    $modDiagnosa->dtd_id=$_GET['HDDiagnosaM_dtd_id'];
                } 
// =========================Akhir Update Dari Grid============================== 

//==========================Update Dari Klik====================================
                
                
                   
//==========================Akhir Update Dari Klik==============================

            $this->render('index',array('modTabularList'=>$modTabularList,'modDTDM'=>$modDTDM,
                       'modDiagnosa'=>$modDiagnosa));
    	
	}

	
}