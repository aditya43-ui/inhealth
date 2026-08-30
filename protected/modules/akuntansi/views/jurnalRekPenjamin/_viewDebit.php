
<?php
//$modPenjaminRek = AKPenjaminRekM::model()->findAllByAttributes(array('penjamin_id'=>$penjamin_id,'saldonormal'=>$saldonormal));
$modPenjaminRek = AKPenjaminRekM::model()->findAllBySql("SELECT * 
FROM penjaminrek_m 
JOIN rekening5_m as rekeningdebit ON penjaminrek_m.rekening5_id = rekeningdebit.rekening5_id AND penjaminrek_m.debitkredit = 'D'
WHERE
penjaminrek_m.penjamin_id = $penjamin_id");
if(count((array)$modPenjaminRek)>0)
    {   
        echo "<ul>"; 
        foreach($modPenjaminRek as $i=>$data)
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
