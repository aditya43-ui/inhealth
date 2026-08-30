<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Batang', 'url'=>'',  'itemOptions'=>array('onclick'=>'setType(this, 1);', 'type'=>'batang')),
        array('label'=>'Pie', 'url'=>'', 'itemOptions'=>array('onclick'=>'setType(this, 2);', 'type'=>'pie')),
        array('label'=>'Garis', 'url'=>'', 'itemOptions'=>array('onclick'=>'setType(this, 3);', 'type'=>'garis')),
    ),
));
?>