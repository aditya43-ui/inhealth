<?php
$this->widget('bootstrap.widgets.BootMenu',
    array(
        'type'=>'tabs',
        'stacked'=>false,
        'items'=>array(
            array('label'=>'Alat Finger', 'url'=>$this->createUrl('/kepegawaian/AlatfingerM/admin'), 'active'=>true ),
            array('label'=>'Backup User Alat', 'url'=>$this->createUrl('/kepegawaian/AlatfingerM/admin')),
        ),
    )
); 
?>