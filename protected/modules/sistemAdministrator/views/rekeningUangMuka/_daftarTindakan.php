<?php
	$modDaftarTindakan=  SARekeninguangmukaM::model()->findAll('instalasi_id='.$instalasi_id.'');
//	$modTarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$modDaftarTindakan[0]->daftartindakan_id));
if(count((array)$modDaftarTindakan)>0)
    {   
        echo "<ul>"; 
        foreach($modDaftarTindakan as $i=>$tindakan)
        {
            echo "<li>".$tindakan->rekening5->nmrekening5.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
<br><br>