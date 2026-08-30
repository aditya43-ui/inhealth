<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pendidikan', 'url'=>$this->createUrl('/kepegawaian/pendidikanM/admin'), 'active'=>true),
        array('label'=>'Kualifikasi Pendidikan', 'url'=>$this->createUrl('/kepegawaian/pendidikankualifikasiM/admin'),),
    ),
)); 
?>