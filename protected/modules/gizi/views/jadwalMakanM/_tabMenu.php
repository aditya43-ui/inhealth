<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Bahan Makanan', 'url'=>$this->CreateUrl('/gizi/bahanMakananM/admin'),),
        array('label'=>'Zat Bahan Makanan', 'url'=>$this->CreateUrl('/gizi/zatBahanMakananM/admin'),),
        array('label'=>'Jadwal Makan', 'url'=>$this->CreateUrl('/gizi/jadwalMakanM/admin'), 'active'=>true),
        array('label'=>'Golongan Bahan Makanan', 'url'=>$this->CreateUrl('/gizi/golBahanMakananM/admin'),),
    ),
)); 
?>