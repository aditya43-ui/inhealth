
<?php
$modDaftarTindakan=TindakanruanganM::model()->findAll('ruangan_id='.$ruangan_id.'');
if(COUNT($modDaftarTindakan)>0)
    {   
        echo "<ul>"; 
        foreach($modDaftarTindakan as $i=>$tindakan)
        {
            echo "<li>".$tindakan->daftartindakan->daftartindakan_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
