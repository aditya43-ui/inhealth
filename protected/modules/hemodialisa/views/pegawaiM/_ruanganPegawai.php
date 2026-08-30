
<?php
$modRuanganPegawai=RuanganpegawaiM::model()->findAll('pegawai_id='.$pegawai_id.'');
if(COUNT($modRuanganPegawai)>0)
    {   
        echo "<ul>"; 
        foreach($modRuanganPegawai as $i=>$tampilData)
        {
            echo "<li>".$tampilData->ruangan->ruangan_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set');
    }   
?>
