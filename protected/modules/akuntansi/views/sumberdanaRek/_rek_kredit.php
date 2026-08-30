<?php
    $debet = 'K';
//    $modRekSumberdana = SumberdanarekM::model()->findAllByAttributes(array('sumberdana_id'=>$sumberdana_id,'saldonormal'=>$debet));
    $modRekSumberdana = SumberdanarekM::model()->findAllBySql("SELECT * 
FROM sumberdanarek_m 
JOIN rekening5_m as rekeningdebit ON sumberdanarek_m.rekening5_id = rekeningdebit.rekening5_id AND rekeningdebit.rekening5_nb = 'K'
WHERE
sumberdanarek_m.sumberdana_id = $sumberdana_id");
    if(count((array)$modRekSumberdana)>0)
    {   
        foreach($modRekSumberdana as $i=>$data)
        {
            echo "<pre>";
            if(isset($_GET['caraPrint'])){
                echo $data->rekening5->nmrekening5;
            }else{
                echo $data->rekening5->nmrekening5.CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                            Yii::app()->controller->createUrl("sumberdanaRek/ubahRekeningKredit",array("id"=>$data->sumberdanarek_id)),
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