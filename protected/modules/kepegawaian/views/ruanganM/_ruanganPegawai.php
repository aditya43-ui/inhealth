
<?php
$modRuanganPegawai=RuanganpegawaiM::model()->findAll('ruangan_id='.$ruangan_id.'');
if(count((array)$modRuanganPegawai)>0)
    {   
        echo "<ul>"; 
        foreach($modRuanganPegawai as $i=>$tampilData)
        {
            echo "<li>".$tampilData->pegawai->nama_pegawai.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
