
<?php
$modKasusPenyakitRuangan=KasuspenyakitruanganM::model()->findAll('ruangan_id='.$ruangan_id.'');
if(count((array)$modKasusPenyakitRuangan)>0)
    {   
        echo "<ul>"; 
        foreach($modKasusPenyakitRuangan as $i=>$penyakit)
        {
            echo "<li>".$penyakit->jeniskasuspenyakit->jeniskasuspenyakit_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
