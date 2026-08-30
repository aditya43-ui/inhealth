<?php
//    $modRekPenjamin = PenjaminrekM::model()->findAllByAttributes(array('penjamin_id'=>$penjamin_id,'saldonormal'=>$saldonormal));
    $modRekRekonBank = RekonsiliasibankrekeningM::model()->findAllBySql("SELECT * 
FROM rekonsiliasibankrekening_m 
JOIN rekening5_m as rekeningdebit ON rekonsiliasibankrekening_m.rekening5_id = rekeningdebit.rekening5_id AND rekeningdebit.rekening5_nb = 'D'
WHERE
rekonsiliasibankrekening_m.jenisrekonsiliasibank_id = $jenisrekonsiliasibank_id");
    if(count((array)$modRekRekonBank)>0)
    {   
        foreach($modRekRekonBank as $i=>$data)
        {
            if(isset($_GET['caraPrint'])){
                echo "<pre>";
                echo !empty($data->rekening5_id)?$data->rekeningdebit->nmrekening5:" - ";
                echo "</pre>";
            }else{
                
            echo "<pre>";
            echo $data->rekeningdebit->nmrekening5.CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                            Yii::app()->controller->createUrl(Yii::app()->controller->id ."/ubahRekeningDebit",array("id"=>$data->rekonsiliasibankrekening_id)),
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