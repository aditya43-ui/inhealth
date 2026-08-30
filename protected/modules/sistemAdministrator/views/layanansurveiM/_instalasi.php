<?php
$modInstalasi= LayanansurveiM::model()->with('instalasirl')->findByPk($layanansurvei_id);
if(!empty($modInstalasi->instalasirl->instalasi_nama)){
  
            echo $modInstalasi->instalasirl->instalasi_nama;
 }else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>

