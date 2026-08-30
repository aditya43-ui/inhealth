<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Lokasi Rak', 'url'=>$this->createUrl('/rekamMedis/lokasiRak/admin'),),
        array('label'=>'Sub Rak', 'url'=>$this->createUrl('/rekamMedis/subRak/admin'),),
        array('label'=>'Warna Nomor', 'url'=>$this->createUrl('/rekamMedis/warnaNomor/admin'), 'active'=>true),
        ),
)); 
?>