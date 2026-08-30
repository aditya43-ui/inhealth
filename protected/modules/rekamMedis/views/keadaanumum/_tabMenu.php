<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Keluhan Anamnesis', 'url'=>$this->createUrl('/rekamMedis/keluhananamnesisM/admin'),),
        array('label'=>'Keadaan Umum', 'url'=>$this->createUrl('/rekamMedis/keadaanumum/admin'), 'active'=>true),
        array('label'=>'Body Mass Index', 'url'=>$this->createUrl('/rekamMedis/bodyMassIndex/admin'),),
        array('label'=>'Sysdia', 'url'=>$this->createUrl('/rekamMedis/sysDia/admin'),),
        ),
)); 
?>