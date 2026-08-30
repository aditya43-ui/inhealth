<?php
/*$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Gelar Belakang', 'url'=>$this->createUrl('/kepegawaian/gelarBelakangM/admin'), 'active'=>true ),
        array('label'=>'Kelompok', 'url'=>$this->createUrl('/kepegawaian/KelompokpegawaiM/admin'), ),
        array('label'=>'Jabatan', 'url'=>$this->createUrl('/kepegawaian/jabatanM/admin'),),
        array('label'=>'Status Kepemilikan Rumah', 'url'=>$this->createUrl('/kepegawaian/statuskepemilikanrumahM/admin'),),
        array('label'=>'Nilai','url'=>$this->createUrl('/kepegawaian/nilaiM/admin')),
        array('label'=>'Komponen Gaji','url'=>$this->createUrl('/kepegawaian/komponengajiMKP/admin')),
        array('label'=>'Golongan', 'url'=>$this->createUrl('/kepegawaian/golonganPegawaiM/admin')),
        array('label'=>'Golongan Gaji', 'url'=>$this->createUrl('/kepegawaian/golonganGajiMKP/admin')),
        array('label'=>'PTKP', 'url'=>$this->createUrl('/kepegawaian/PtkpMKP/admin')),
        array('label'=>'Minat Pekerjaan', 'url'=>$this->createUrl('/kepegawaian/LookupM/admin')),
//        array('label'=>'Pendidikan', 'url'=>$this->createUrl('/kepegawaian/pendidikanM/admin'), ),
//        array('label'=>'Esselon', 'url'=>$this->createUrl('/kepegawaian/esselonM/admin'),),
    ),
)); */
?>

<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Kelompok', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/KelompokpegawaiM/admin')),
        //array('label'=>'Golongan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/golonganPegawaiM/admin')),
        //array('label'=>'Pangkat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/pangkatMKP/admin')),
        array('label'=>'Jabatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/jabatanM/admin')),
        array('label'=>'Gelar Belakang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/gelarBelakangM/admin&tab=frame')),
       // array('label'=>'Komponen Gaji', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/komponengajiMKP/admin')),        
       // array('label'=>'Golongan Gaji', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/golonganGajiMKP/admin')),
       // array('label'=>'PTKP', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/PtkpMKP/admin')),
        array('label'=>'Status Kepemilikan Rumah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/statuskepemilikanrumahM/admin')),
        array('label'=>'Nilai', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/nilaiM/admin')),
        array('label'=>'Minat Pekerjaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/kepegawaian/LookupM/admin')),
    		
    ),
));
?>