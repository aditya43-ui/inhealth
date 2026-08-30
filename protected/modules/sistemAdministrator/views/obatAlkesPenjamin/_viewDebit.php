<?php
$modSupplierRek = SAObatalkespenjaminM::model()->findAllByAttributes(array('penjamin_id'=>$penjamin_id));

if(COUNT($modSupplierRek)>0)
    {   
        echo "<ul>"; 
        foreach($modSupplierRek as $i=>$data)
        {
            echo "<li>".$data->jenisobatalkes->jenisobatalkes_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
