<?php
//$modSumberdanaRek = AKSumberdanaRekM::model()->findAllByAttributes(array('sumberdana_id'=>$sumberdana_id,'saldonormal'=>$saldonormal));
$modSumberdanaRek = AKSumberdanaRekM::model()->findAllBySql("SELECT * 
FROM sumberdanarek_m 
JOIN rekening5_m as rekeningdebit ON sumberdanarek_m.rekening5_id = rekeningdebit.rekening5_id AND sumberdanarek_m.debitkredit = '". $saldonormal ."'
WHERE
sumberdanarek_m.sumberdana_id = $sumberdana_id");
if(count((array)$modSumberdanaRek)>0)
    {   
        echo "<ul>"; 
        foreach($modSumberdanaRek as $i=>$data)
        {
            echo "<li>".$data->rekening5->nmrekening5.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
