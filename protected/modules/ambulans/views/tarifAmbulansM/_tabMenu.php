<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Mobil Ambulans', 'url'=>$this->createUrl('/ambulans/MobilAmbulansM/admin'),),
        array('label'=>'Tarif Ambulans', 'url'=>$this->createUrl('/ambulans/TarifAmbulansM/admin'), 'active'=>true),
    ),
)); 
?>