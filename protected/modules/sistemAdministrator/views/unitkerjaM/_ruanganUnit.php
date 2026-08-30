<?php
$modRuangan=UnitkerjaruanganM::model()->with('ruangan')->findAll('unitkerja_id='.$unitkerja_id.'');
if(count((array)$modRuangan)>0)
    {
        echo "<ul>";
        foreach($modRuangan as $i=>$ruangan)
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

