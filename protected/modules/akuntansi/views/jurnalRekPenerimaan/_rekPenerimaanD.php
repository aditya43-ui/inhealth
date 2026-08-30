<?php
//    $modRekPenerimaan = JnspenerimaanrekM::model()->findAllByAttributes(array('jenispenerimaan_id'=>$jenispenerimaan_id));
    $modRekPenerimaan = JnspenerimaanrekM::model()->findAllBySql("SELECT * 
FROM jnspenerimaanrek_m 
JOIN rekening5_m as rekeningdebit ON jnspenerimaanrek_m.rekening5_id = rekeningdebit.rekening5_id
WHERE
jnspenerimaanrek_m.jenispenerimaan_id = $jenispenerimaan_id AND jnspenerimaanrek_m.debitkredit = 'D'"
);
    if(count((array)$modRekPenerimaan)>0)
    {   
        foreach($modRekPenerimaan as $i=>$data)
        {
            
            if(isset($_GET['caraPrint'])){
                
                echo "<pre>";
                echo $data->rekeningdebit->nmrekening5;
                echo "</pre>";
            }else{
                echo "<pre>";
                echo $data->rekeningdebit->nmrekening5.CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                                Yii::app()->controller->createUrl("rekeningPenerimaan/ubahRekeningDebit",array("id"=>$data->jnspenerimaanrek_id)),
                                array("class"=>"", 
                                      "target"=>"iframeEditRekeningDebitKredit",
                                      "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk ubah Rekening Debit",
                                ));
                echo "</pre>";
            }
        }
    }
    else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>