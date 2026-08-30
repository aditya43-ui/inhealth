<?php 
/**
 * digunakan untuk menampilkan tabulasi menu
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        //DIPISAH DARI RAWAT JALAN KARENA ADA PERBEDAAN DI CONTROLLER TAB NYA
        array('label'=>'Anamnesis Awal (S)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTRM/index')),
        array('label'=>'Anamnesis Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: block;','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/anamnesaMedis/index')),        
        array('label'=>'Periksa Fisik Awal (O)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisikTRM/index')),
        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosaTRMNew/index')),
        array('label'=>'Tindakan/Pemeriksaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/tindakan/index')), 
        array('label'=>'Laboratorium Patologi Klinik (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: block;','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/laboratorium/index')),
        array('label'=>'Patologi Anatomi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: block;','onclick'=>'setTab(this);', 'tab'=>'rawatInap/patologiAnatomiTRI/index')),
        array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: block;','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/mikrobiologiKlinik/index')),
        array('label'=>'Radiologi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: block;','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/radiologiNew/index')),
        // array('label'=>'Tindakan/Pemeriksaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanRehabilitasiMedis/pemeriksaan')),
        array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTRM/index')),
        array('label'=>'Reseptur', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/resepturTRM/index')),
        array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/laboratoriumTRM/index')),
        array('label'=>'Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/radiologiTRM/index')),
        array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeteranganTRM/suratKeterangan')),
        array('label'=>'Upload Dokumen Rekam Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: block;','onclick'=>'setTab(this);', 'tab'=> '/rekamMedis/ScanRM/Index')),
        array('label'=>'Catatan Tindakan Dokter', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rawatJalan/catatanTindakan/index')),   
        
        
    ),
    'htmlOptions'=>[
        'id'=>'tab-periksa'
    ] 
));
?>