<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
//        array('label'=>'Data Pegawai', 'url'=>$this->createUrl('/kepegawaian/pegawaiM/admin'),),
        array('label'=>'Status Kehadiran', 'url'=>$this->createUrl('/kepegawaian/statuskehadiranM/admin')),
        array('label'=>'Status Scan', 'url'=>$this->createUrl('/kepegawaian/statusscanM/admin'), ),
        array('label'=>'Jam Kerja', 'url'=>$this->createUrl('/kepegawaian/jamKerja/admin')),
        array('label'=>'Shift', 'url'=>$this->createUrl('/kepegawaian/shiftM/admin'),'active'=>true),
    ),
)); 
?>