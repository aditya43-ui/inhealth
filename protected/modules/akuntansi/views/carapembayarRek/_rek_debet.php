<?php
    $debet = 'D';
//    $modRekCarapemb = CarapembrekM::model()->findAllByAttributes(array('carapembayaran'=>$carapembayaran));
    $modRekCarapemb = CarapembrekM::model()->findAllBySql("SELECT * 
FROM carapembrek_m 
JOIN rekening5_m as rekeningdebit ON carapembrek_m.rekening5_id = rekeningdebit.rekening5_id
WHERE
carapembrek_m.carapembayaran = '".$carapembayaran."'
AND carapembrek_m.debitkredit = '".$debet."'");
    if(count((array)$modRekCarapemb)>0)
    {   
        foreach($modRekCarapemb as $i=>$data)
        {
            echo "<pre>";
            if(isset($_GET['caraPrint'])){
                echo $data->rekening5->nmrekening5;
            }else{
                echo $data->rekening5->nmrekening5.CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                            Yii::app()->controller->createUrl("carapembayarRek/ubahRekeningDebit",array("id"=>$data->carapembayaran)),
                            array("class"=>"", 
                                  "target"=>"iframeEditRekeningDebitKredit",
                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk ubah Rekening Debit",
                            ));
            }
            echo "</pre>";
        }
    }
    else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>