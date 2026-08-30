<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jenis Infeksi Nosokomial', 'url'=>$this->createUrl('/rekamMedis/jenisInfeksiNosokomialM/admin'),),
        array('label'=>'Sebab Infeksi Nosokomial', 'url'=>$this->createUrl('/rekamMedis/sebabInfeksiNosokomialM/admin'), 'active'=>true),
        array('label'=>'Sebab Diagnosa', 'url'=>$this->createUrl('/rekamMedis/sebabDiagnosaM/admin'),),
        array('label'=>'Jenis Sebab', 'url'=>$this->createUrl('/rekamMedis/jenissebabM/admin'),),
        array('label'=>'Penyebab Luar Cidera', 'url'=>$this->createUrl('/rekamMedis/penyebabLuarCederaM/admin'),),
        array('label'=>'Morfologi Neoplasma', 'url'=>$this->createUrl('/rekamMedis/morfologiNeoplasmaM/admin'), ),
        array('label'=>'Jenis Ketunaan', 'url'=>$this->createUrl('/rekamMedis/jenisKetunaanM/admin'),),
        ),
)); 
?>