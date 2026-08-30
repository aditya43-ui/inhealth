<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Gelar Belakang', 'url'=>$this->createUrl('/kepegawaian/gelarBelakangM/admin'), ),
        array('label'=>'Kelompok', 'url'=>$this->createUrl('/kepegawaian/KelompokpegawaiM/admin'), ),
        array('label'=>'Golongan', 'url'=>$this->createUrl('/kepegawaian/golonganPegawaiM/admin')),
        array('label'=>'Jabatan', 'url'=>$this->createUrl('/kepegawaian/jabatanM/admin'),),
        array('label'=>'Esselon', 'url'=>$this->createUrl('/kepegawaian/esselonM/admin'), 'active'=>true),
        array('label'=>'Status Kepemilikan Rumah', 'url'=>$this->createUrl('/kepegawaian/statuskepemilikanrumahM/admin'),),
        array('label'=>'Nilai','url'=>$this->createUrl('/kepegawaian/nilaiM/admin')),
        array('label'=>'Komponen Gaji','url'=>$this->createUrl('/kepegawaian/komponengajiM/admin')),
        array('label'=>'Golongan', 'url'=>$this->createUrl('/kepegawaian/golonganPegawaiM/admin'), ),
//        array('label'=>'Data Pegawai', 'url'=>$this->createUrl('/kepegawaian/pegawaiM/admin'),),
    ),
)); 
?>