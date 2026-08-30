<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Diagnosa Keperawatan', 'url'=>$this->createUrl('/rawatInap/diagnosakeperawatanM/admin'),'active'=>true),
        array('label'=>'Rencana Keperawatan', 'url'=>$this->createUrl('/rawatInap/rencanaKeperawatanM/admin'),),
        array('label'=>'Implementasi Keperawatan', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        
            ),
)); 
?>