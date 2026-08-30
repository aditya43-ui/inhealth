<?php
$modInstalasi= LayanansurveiM::model()->with('ruanganrl')->findByPk($layanansurvei_id);
if(!empty($modInstalasi->ruanganrl->ruangan_nama)){
  
            echo $modInstalasi->ruanganrl->ruangan_nama;
 }else
    {
        echo Yii::t('zii','Tidak di set'); 
    }   
?>

