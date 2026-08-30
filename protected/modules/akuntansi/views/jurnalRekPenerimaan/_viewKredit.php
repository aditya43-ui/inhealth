
<?php
$modJenispenerimaanRek = AKJnsPenerimaanRekM::model()->findAllByAttributes(array('jenispenerimaan_id'=>$jenispenerimaan_id, 'debitkredit'=>$saldonormal));

if(count((array)$modJenispenerimaanRek)>0)
    {   
        echo "<ul>"; 
        foreach($modJenispenerimaanRek as $i=>$data)
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
