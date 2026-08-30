<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(

        array('label'=>'Bank', 'url'=>$this->createUrl('/'.$this->link_bank.'/create'),'active'=>true ),
        array('label'=>'Rekening', 'url'=>$this->createUrl('/'.$this->link_rekening.'/create'), ),
            ),
)); 
?>