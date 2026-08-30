<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Susunan Keluarga', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/SusunanKeluargaPegawai/index')),
        array('label'=>'Pendidikan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/PendidikanPegawai/index')),
        array('label'=>'Pengalaman Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/PengalamanKerjaPegawai/index')),
        array('label'=>'Pengalaman Organisasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/PengalamanOrganisasiPegawai/index')),
		
//        array('label'=>'Diklat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/DiklatPegawai/index')),
//        array('label'=>'Jabatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/JabatanPegawai/index')),
//        array('label'=>'Mutasi Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/MutasiKerjaPegawai/index')), 
//        array('label'=>'Cuti', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/CutiPegawai/index')), 
        array('label'=>'Izin / Tugas Belajar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/IzinTugasBelajarPegawai/index')),
//        array('label'=>'Hukum disiplin', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/HukumDisiplinPegawai/index')),
//        array('label'=>'Prestasi Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/PrestasiKerjaPegawai/index')),
//        array('label'=>'Perjalanan Dinas', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'kepegawaian/PerjalananDinasPegawai/index')),
    ),
));
?>