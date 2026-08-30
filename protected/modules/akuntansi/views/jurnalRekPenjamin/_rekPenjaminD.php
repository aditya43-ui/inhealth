<?php
//    $modRekPenjamin = PenjaminrekM::model()->findAllByAttributes(array('penjamin_id'=>$penjamin_id,'saldonormal'=>$saldonormal));
    $modRekPenjamin = PenjaminrekM::model()->findAllBySql("SELECT * 
FROM penjaminrek_m 
JOIN rekening5_m as rekeningdebit ON penjaminrek_m.rekening5_id = rekeningdebit.rekening5_id AND penjaminrek_m.debitkredit = 'D'
WHERE
penjaminrek_m.penjamin_id = $penjamin_id");
    if(count((array)$modRekPenjamin)>0)
    {   
        echo "<ul>";
        foreach($modRekPenjamin as $i=>$data)
        {
           // if(isset($_GET['caraPrint'])){
             //   echo "<pre>";
               // echo !empty($data->rekening5_id)?$data->rekeningdebit->nmrekening5:" - ";
               // echo "</pre>";
           // }else{
                
            //echo "<pre>";
            echo "<li>".$data->rekeningdebit->nmrekening5." ".(($data->ispembayaran)?'(Pembayaran)':'')."</li>"; 
			/*
                    .CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                            Yii::app()->controller->createUrl("jurnalRekPenjamin/ubahRekeningDebit",array("id"=>$data->penjaminrek_id)),
                            array("class"=>"", 
                                  "target"=>"iframeEditRekeningDebitKredit",
                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk ubah Rekening Debit",
                            ));
            echo "</pre>"; */
            //}
        } 
		echo "</ul>";
    } 
    else
    {
        echo Yii::t('zii','-'); 
    }   
?>