<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Zat Gizi', 'url'=>$this->createUrl('/gizi/zatgiziM/admin'),),
        array('label'=>'Tipe Diet', 'url'=>$this->createUrl('/gizi/tipeDietM/admin'),),
        array('label'=>'Jenis Diet', 'url'=>$this->createUrl('/gizi/jenisdietM/admin'),),
        array('label'=>'Diet', 'url'=>$this->createUrl('/gizi/dietM/admin'), ),
        array('label'=>'Menu Diet', 'url'=>$this->createUrl('/gizi/menuDietM/admin'), ),
        array('label'=>'Zat Menu Diet', 'url'=>$this->createUrl('/gizi/zatMenuDietM/admin'), 'active'=>true),
        array('label'=>'Bahan Diet', 'url'=>$this->createUrl('/gizi/bahandietM/admin'), ),
        array('label'=>'Jenis Waktu', 'url'=>$this->createUrl('/gizi/jenisWaktuM/admin'), ),
        array('label'=>'Bahan Menu Diet', 'url'=>$this->createUrl('/gizi/bahanMenuDietM/admin'),),
    ),
)); 
?>