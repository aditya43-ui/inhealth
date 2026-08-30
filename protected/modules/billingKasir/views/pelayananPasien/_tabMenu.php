<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Karcis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'default-tab','onclick'=>'setTab(this);', 'tab'=>$module.'/Karcis/index')),
        array('label'=>'Rawat Jalan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/TindakanRawatJalan/index&instalasi_id='.Params::INSTALASI_ID_RJ)),
        array('label'=>'Rawat Darurat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/TindakanRawatDarurat/index&instalasi_id='.Params::INSTALASI_ID_RD)),
        array('label'=>'Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/TindakanRawatInap/index&instalasi_id='.Params::INSTALASI_ID_RI)),
        //array('label'=>'Akomodasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/Akomodasi/index&instalasi_id='.Params::INSTALASI_ID_RI)),
        array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/PemeriksaanLaboratorium/index')),
        array('label'=>'Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/PemeriksaanRadiologi/index')),
        //array('label'=>'Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/PemeriksaanRehabilitasiMedis/index')),
        array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/KonsultasiGizi/index')),
        array('label'=>'Diet Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/dietPasien/index&instalasi_id='.Params::INSTALASI_ID_GIZI)),
        // array('label'=>'Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/TindakanBedah/index')),
        //array('label'=>'Ambulans', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/PemakaianAmbulans/index&instalasi_id='.Params::INSTALASI_ID_AMBULAN)),
        //array('label'=>'Pemakaian Bmhp', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/PemakaianBmhp/index')),
        array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/PemakaianBahan/index')),
        //array('label'=>'Lain-lain', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/TindakanLain/index')),
        array('label'=>'Persalinan / VK', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/TindakanPersalinan/index&instalasi_id='.Params::INSTALASI_ID_PERSALINAN)),
        array('label'=>'Perawatan Intensif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/TindakanPerawatanIntensif/index&instalasi_id='.Params::INSTALASI_ID_PI)),
    ),
));
?>