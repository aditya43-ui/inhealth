<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Tabular List', 'url'=>$this->createUrl('/rekamMedis/tabularListM/admin'),'active'=>true),
        array('label'=>'DTD', 'url'=>$this->createUrl('/rekamMedis/dtdM/admin'), ),
        array('label'=>'Diagnosa Sepuluh', 'url'=>$this->createUrl('/rekamMedis/diagnosaMRK/admin'),),
        array('label'=>'Kelompok Diagnosa', 'url'=>$this->createUrl('/rekamMedis/kelompokdiagnosaM/admin'),),
        array('label'=>'Diagnosa ICD Sembilan', 'url'=>$this->createUrl('/rekamMedis/diagnosaICDIXM/admin'),),
            ),
)); 
?>