<?php
$modRek = PenjaminrekM::model()->findAllBySql("SELECT *
FROM penjaminrek_m 
JOIN rekening5_m as rekeningdebit ON penjaminrek_m.rekening5_id = rekeningdebit.rekening5_id 
JOIN penjaminpasien_m ON penjaminrek_m.penjamin_id = penjaminpasien_m.penjamin_id
WHERE
penjaminrek_m.penjaminrek_id = $penjaminrek_id AND penjaminrek_m.debitkredit = 'K'");
    if(COUNT($modRek)>0)
    {   
        foreach($modRek as $i=>$data)
        {
            
            if(isset($_GET['caraPrint'])){
                echo "<pre>";
                echo $data->nmrekening5;
                echo "</pre>";
            }else{
                echo "<pre>";
                echo $data->nmrekening5.CHtml::Link("<i class=\"icon-pencil\"></i>",
                                Yii::app()->controller->createUrl(Yii::app()->controller->id ."/ubahRekeningKredit",array("id"=>$data->penjaminrek_id)),
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
        echo ""; 
    }   
?>