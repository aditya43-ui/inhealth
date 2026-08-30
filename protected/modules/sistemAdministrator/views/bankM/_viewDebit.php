
<?php
$modBankRek = SABankRekM::model()->findAllByAttributes(array('bank_id'=>$bank_id,'saldonormal'=>$saldonormal));

if(count((array)$modBankRek)>0)
    {   
        echo "<ul>"; 
        foreach($modBankRek as $i=>$data)
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
