<?php
$modSupplierRek = AKCarapembayarRekM::model()->findAllByAttributes(array('carapembayaran'=>$carapembayaran,'debitkredit'=>$debitkredit));

if(count((array)$modSupplierRek)>0)
    {   
        echo "<ul>"; 
        foreach($modSupplierRek as $i=>$data)
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
