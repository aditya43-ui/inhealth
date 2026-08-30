<?php
/*$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Kelompok Remunerasi', 'url'=>$this->createUrl('/remunerasi/kelremM/admin'), 'active'=>true ),
        array('label'=>'Indexing', 'url'=>$this->createUrl('/remunerasi/indexingM/admin') ),
    ),
)); */

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Kelompok Remunerasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/remunerasi/kelremM/admin&tab=frame')),
    	array('label'=>'Indexing', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/remunerasi/indexingM/admin')),        
    ),
));

?>