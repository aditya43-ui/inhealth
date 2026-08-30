<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Jenis Pengeluaran', 'url'=>$this->createUrl('/akuntansi/jurnalRekPengeluaran/create'),'active'=>true),
        array('label'=>'Rekening ', 'url'=>$this->createUrl('/akuntansi/rekeningPengeluaran/create'), ),
            ),
)); 
?>