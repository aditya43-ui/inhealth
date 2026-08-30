<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        // array('label' => 'Riwayat Pasien Smartplus', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'cekRM(this);')),
        array('label'=>'Anamnesis Keperawatan (S)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'/rawatJalan/anamnesa/index')),
        array('label'=>'Anamnesis Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/anamnesaMedis/index')),
        // array('label'=>'Anamnesis (S)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTPS/index')),
        array('label'=>'Periksa Fisik (O)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisikTPS/index')),
        array('label' => 'Diagnosis (A)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => '/rawatJalan/diagnosaNew/index')),
        array('label' => 'Tindakan (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/tindakanTPS/index')),
        array('label' => 'Reseptur (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/resepturTPS/index')),
        array('label'=>'Laboratorium (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/laboratoriumTPS/index')),
        array('label'=>'Patologi Anatomi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatInap/patologiAnatomiTRI/index')),
        // array('label'=>'Radiologi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/radiologiTPS/index')),
        array('label'=>'Radiologi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/radiologiNew/index')),
        array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatJalan/mikrobiologiKlinik/index')),
        // array('label'=>'Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedisTPS/index')),
        array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGiziTPS/index')),
        array('label'=>'Konsultasi Dokter Lain', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulPoliTPS/index')),
        // array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/bedahSentralTPS/index')),
        array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/bedahSentralNew/index')),
        array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rujukanKeluarTPS/index')),
        array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTabPS/index')),        
    	array('label'=>'Surveilans PPI', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/surveilansTPS/index')),
        array('label'=>'Grafik Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/GrafikTandaVitalPS/create')),
        array('label' => 'Resume Medis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/ResumeMedis/index')),
        array('label' => 'Catatan Perkembangan Pasien Terintegrasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/CPPTRK/index')),
        array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeteranganTRM/suratKeterangan')),
        array('label'=>'Ruangan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/ruangTindakan/index')),
        array('label'=>'Permintaan Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ', 'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/PermintaanDarahDariPelayananTRJ/index&frame=1')),
        array('label'=>'Upload Dokumen Pendukung', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$module,'onclick'=>'setTab(this);', 'tab'=> '/rekamMedis/ScanRM/Index&frame=1')),
    ),
    'htmlOptions'=>[
        'id'=>'tab-periksa'
    ] 
));
?>