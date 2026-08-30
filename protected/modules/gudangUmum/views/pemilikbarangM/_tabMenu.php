<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Asal Aset', 'url'=>$this->createUrl('/gudangUmum/asalasetM/admin'),),
        array('label'=>'Lokasi Aset', 'url'=>$this->createUrl('/gudangUmum/lokasiasetM/admin'),),
        array('label'=>'Pemilik Barang', 'url'=>$this->createUrl('/gudangUmum/pemilikbarangM/admin'), 'active'=>true),
        
        
    ),
)); 
?>