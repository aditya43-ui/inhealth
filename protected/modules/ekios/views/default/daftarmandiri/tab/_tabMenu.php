<?php 
echo '<div style="margin:auto 30%;">';

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
          array('label'=>'DATA PASIEN', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/ekios/daftarMandiri/dataPasien')),    	

array('label'=>'CARI POLIKLINIK TUJUAN', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/ekios/daftarMandiri/dataPoli')),  
        array('label'=>'CARI DOKTER', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/ekios/daftarMandiri/dataDokter')),  
        array('label'=>'JADWAL DOKTER', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/ekios/daftarMandiri/dataJadwal')),  
        array('label'=>'VERIFIKASI PENDAFTARAN', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'/ekios/daftarMandiri/dataVerifikasi')),  
////        array('label'=>'DATA PASIEN', 'url'=>$this->createUrl('/ekios/daftarMandiri/dataPasien'), 'active'=>true),
//        array('label'=>'CARI POLIKLINIK TUJUAN', 'url'=>$this->createUrl('/ekios/daftarMandiri/dataPoli')),
//        array('label'=>'CARI DOKTER', 'url'=>$this->createUrl('/ekios/daftarMandiri/dataDokter')),
//        array('label'=>'JADWAL DOKTER', 'url'=>$this->createUrl('/ekios/daftarMandiri/dataJadwal')),
//        array('label'=>'VERIFIKASI PENDAFTARAN', 'url'=>$this->createUrl('/ekios/daftarMandiri/dataVerifikasi')),
    ),
));
echo '</div>';

?>
    