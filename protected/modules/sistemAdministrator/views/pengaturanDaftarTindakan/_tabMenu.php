<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Kelompok Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/KelompokTindakanM/admin')),
        array('label'=>'Komponen Unit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/KomponenUnitM/admin')),
    	array('label'=>'Kategori Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/KategoriTindakanM/admin')),
    	array('label'=>'Daftar Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/DaftarTindakanM/admin')),
        array('label'=>'Jenis Kegiatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/JenisKegiatanM/admin')),
    ),
));
?>