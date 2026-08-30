<?php
$modPelayananRek = AKPelayananRekM::model()->findAllByAttributes(array('daftartindakan_id'=>$daftartindakan_id,'ruangan_id'=>$ruangan_id,'saldonormal'=>$saldonormal));

if(count((array)$modPelayananRek)>0)
    {   
        echo "<ul>"; 
        foreach($modPelayananRek as $i=>$data)
        {
            echo "<li>".(isset($data->rekening5->nmrekening5) ? $data->rekening5->nmrekening5 : "-").'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
