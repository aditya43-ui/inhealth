<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Tabular List', 'url'=>$this->createUrl('/rawatInap/tabularListM/admin'),),
        array('label'=>'DTD', 'url'=>$this->createUrl('/rawatInap/dtdM/admin'),'active'=>true ),
        array('label'=>'Diagnosa ICD X', 'url'=>$this->createUrl('/rawatInap/diagnosaM/admin'),),
        array('label'=>'Kelompok Diagnosa', 'url'=>$this->createUrl('/rawatInap/kelompokdiagnosaM/admin'),),
        array('label'=>'Diagnosa ICD IX', 'url'=>$this->createUrl('/rawatInap/diagnosaICDIXM/admin'),),
            ),
)); 
?>