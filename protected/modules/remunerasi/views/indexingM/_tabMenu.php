<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Kelompok Remunerasi', 'url'=>$this->createUrl('/remunerasi/kelremM/admin'),),
        array('label'=>'Indexing', 'url'=>$this->createUrl('/remunerasi/indexingM/admin'), 'active'=>true ),
    ),
)); 
?>