<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Diklat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/DiklatPegawai/index')),
        array('label'=>'Jabatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/JabatanPegawai/index')),
        array('label'=>'Mutasi Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/MutasiKerjaPegawai/index&tab=frame')), 
        array('label'=>'Cuti', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/CutiPegawai/index')), 
        array('label'=>'Izin / Tugas Belajar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/IzinTugasBelajarPegawai/index')),
        array('label'=>'Hukum disiplin', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/HukumDisiplinPegawai/index')),
        array('label'=>'Prestasi Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/PrestasiKerjaPegawai/index')),
        array('label'=>'Perjalanan Dinas', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/PerjalananDinasPegawai/index')),
    ),
));
?>