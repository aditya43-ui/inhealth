<?php
//    $modRekPengeluaran = JnspengeluaranrekM::model()->findAllByAttributes(array('jenispengeluaran_id'=>$jenispengeluaran_id));
    $modRekPengeluaran = JnspengeluaranrekM::model()->findAllBySql("SELECT * 
FROM jnspengeluaranrek_m 
JOIN rekening5_m as rekeningdebit ON jnspengeluaranrek_m.rekening5_id = rekeningdebit.rekening5_id 
WHERE
jnspengeluaranrek_m.jenispengeluaran_id = $jenispengeluaran_id AND jnspengeluaranrek_m.debitkredit = 'K'");
    if(count((array)$modRekPengeluaran)>0)
    {   
        foreach($modRekPengeluaran as $i=>$data)
        {
            
            if(isset($_GET['caraPrint'])){
                echo "<pre>";
                echo $data->rekeningdebit->nmrekening5;
                echo "</pre>";
            }else{                
                echo "<pre>";
                echo $data->rekeningdebit->nmrekening5.CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                                Yii::app()->controller->createUrl("rekeningPengeluaran/ubahRekeningKredit",array("id"=>$data->jnspengeluaranrek_id)),
                                array("class"=>"", 
                                      "target"=>"iframeEditRekeningDebitKredit",
                                      "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk ubah Rekening Kredit",
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