
<?php
$modObatSupplier=GZObatSupplierM::model()->findAll('supplier_id='.$supplier_id.'');
if(count((array)$modObatSupplier)>0)
    {   
        echo "<ul>"; 
        foreach($modObatSupplier as $i=>$data)
        {
            echo "<li>".$data->obatalkes->obatalkes_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
