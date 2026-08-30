<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Golongan', 'url'=>$this->createUrl('/sistemAdministrator/golonganM/admin'),),
        array('label'=>'Kelompok', 'url'=>$this->createUrl('/sistemAdministrator/kelompokM/admin'),),
        array('label'=>'Sub Kelompok', 'url'=>$this->createUrl('/sistemAdministrator/subkelompokM/admin'),),
        array('label'=>'Bidang', 'url'=>$this->createUrl('/sistemAdministrator/bidangM/admin'),),
        array('label'=>'Satuan Barang', 'url'=>$this->createUrl('/sistemAdministrator/lookupM/admin'), 'active'=>true),
        
    ),
)); 
?>