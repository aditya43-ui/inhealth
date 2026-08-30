<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
//        array('label'=>'Data Pegawai', 'url'=>$this->createUrl('/kepegawaian/pegawaiM/admin'), 'active'=>true),
        array('label'=>'Gelar Belakang', 'url'=>$this->createUrl('/kepegawaian/gelarBelakangM/admin'), ),
        array('label'=>'Kelompok', 'url'=>$this->createUrl('/kepegawaian/KelompokpegawaiM/admin'), ),
        array('label'=>'Jabatan', 'url'=>$this->createUrl('/kepegawaian/jabatanM/admin'),),
//        array('label'=>'Pendidikan', 'url'=>$this->createUrl('/kepegawaian/pendidikanM/admin'), ),
    ),
)); 
?>