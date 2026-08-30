<?php
$modTindakanRuangan=TindakanruanganM::model()->with('ruangan')->findAll('daftartindakan_id='.$daftartindakan_id.'');
if(count((array)$modTindakanRuangan)>0)
    {
        echo "<ul>";
        foreach($modTindakanRuangan as $i=>$ruangan)
        {
            echo '<li>'.$ruangan->ruangan->ruangan_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>

