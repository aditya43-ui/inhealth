<?php
    $modRekBank = BankrekM::model()->findAllByAttributes(array('bank_id'=>$bank_id,'saldonormal'=>$saldonormal));
    
    if(count((array)$modRekBank)>0)
    {   
		//echo "<ul>";
        foreach($modRekBank as $i=>$data)
        {
           // if(isset($_GET['caraPrint'])){
                //echo "<pre>";
                //echo "<li>";
				echo empty($data->rekeningdebit)?Yii::t('zii','Not set'):$data->rekeningdebit->nmrekening5."<br>";
				//echo "</li>";
                //echo "</pre>";
            /* }else{
                echo "<pre>";
                echo $data->rekeningdebit->nmrekening5.CHtml::Link("<i class=\"icon-pencil\"></i>",
                                Yii::app()->controller->createUrl("rekeningBank/ubahRekeningDebit",array("id"=>$data->bankrek_id)),
                                array("class"=>"", 
                                      "target"=>"iframeEditRekeningDebitKredit",
                                      "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk ubah Rekening Debit",
                                ));
                echo "</pre>";
            }
			 * 
			 */
        }
		//echo "</ul>";
    }
    else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>