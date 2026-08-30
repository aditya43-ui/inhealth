<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Golongan', 'url'=>$this->createUrl('/gudangUmum/golonganM/admin'),),
        array('label'=>'Kelompok', 'url'=>$this->createUrl('/gudangUmum/kelompokM/admin'),),
        array('label'=>'Sub Kelompok', 'url'=>$this->createUrl('/gudangUmum/subkelompokM/admin'),),
        array('label'=>'Bidang', 'url'=>$this->createUrl('/gudangUmum/bidangM/admin'),),
        array('label'=>'Satuan Barang', 'url'=>$this->createUrl('/gudangUmum/lookupM/admin'), 'active'=>true),
        
    ),
)); 
?>