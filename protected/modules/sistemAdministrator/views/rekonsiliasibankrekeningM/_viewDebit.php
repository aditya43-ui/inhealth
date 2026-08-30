
<?php
//$modPenjaminRek = SARekonsiliasibankrekeningM::model()->findAllByAttributes(array('rekonsiliasibankrekening_id'=>$penjamin_id,'rekening5_nb'=>$saldonormal));
$modRekRekonBank = RekonsiliasibankrekeningM::model()->findAllBySql("SELECT * 
FROM rekonsiliasibankrekening_m 
JOIN rekening5_m as rekeningdebit ON rekonsiliasibankrekening_m.rekening5_id = rekeningdebit.rekening5_id AND rekeningdebit.rekening5_nb = 'D'
WHERE
rekonsiliasibankrekening_m.jenisrekonsiliasibank_id = $jenisrekonsiliasibank_id");
if(count((array)$modRekRekonBank)>0)
    {   
        echo "<ul>"; 
        foreach($modRekRekonBank as $i=>$data)
        {
            echo "<li>".$data->rekeningdebit->nmrekening5.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
