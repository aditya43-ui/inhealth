<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Komponen Gaji','url'=>$this->createUrl('/penggajian/komponengajiMGJ/admin')),
        array('label'=>'Golongan Gaji', 'url'=>$this->createUrl('/penggajian/golonganGajiMGJ/admin')),
        array('label'=>'PTKP', 'url'=>$this->createUrl('/penggajian/PtkpMGJ/admin'),'active'=>true),
    ),
)); 
?>