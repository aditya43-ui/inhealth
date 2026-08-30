<?php
$modKelasRuangan=KelasruanganM::model()->with('ruangan')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.'');
if(count((array)$modKelasRuangan)>0)
    {
        echo "<ul>";
        foreach($modKelasRuangan as $i=>$ruangan)
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

