
<?php
//$modPenjaminRek = AKPenjaminRekM::model()->findAllByAttributes(array('penjamin_id'=>$penjamin_id,'saldonormal'=>$saldonormal));
$modRekRekonBank = RekonsiliasibankrekeningM::model()->findAllBySql("SELECT * 
FROM rekonsiliasibankrekening_m 
JOIN rekening5_m as rekeningkredit ON rekonsiliasibankrekening_m.rekening5_id = rekeningkredit.rekening5_id AND rekeningkredit.rekening5_nb = 'K'
WHERE
rekonsiliasibankrekening_m.jenisrekonsiliasibank_id = $jenisrekonsiliasibank_id");
if(count((array)$modRekRekonBank)>0)
    {   
        echo "<ul>"; 
        foreach($modRekRekonBank as $i=>$data)
        {
            echo "<li>".$data->rekeningkredit->nmrekening5.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
