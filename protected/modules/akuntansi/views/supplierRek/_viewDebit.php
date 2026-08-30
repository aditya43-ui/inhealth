<?php
$modSupplierRek = AKSupplierRekM::model()->findAllBySql("SELECT * 
FROM supplierrek_m 
JOIN rekening5_m as rekeningdebit ON supplierrek_m.rekening5_id = rekeningdebit.rekening5_id AND supplierrek_m.debitkredit = '". $saldonormal ."'
WHERE
supplierrek_m.supplier_id = $supplier_id");
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
