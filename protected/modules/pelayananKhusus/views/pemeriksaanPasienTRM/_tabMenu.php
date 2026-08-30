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
        array('label'=>'Anamnesis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTRM/index')),
        array('label'=>'Pemeriksaan Fisik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisikTRM/index')),
        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosaTRM/index')),
        array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTRM/index')),
        array('label'=>'Asesmen Musculoskeletal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/AsesmenMusculoskeletal/index')),
        array('label'=>'Neuromuskular', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenFisioterapiNeuromuskular/index')),
        array('label'=>'Pediatri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenFisioterapiPediatri/index')),
        array('label'=>'Geriatri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenFisioterapiGeriatri/index')),
        array('label'=>'Kardiopulmonal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenFisioterapiKardiopulmonal/index')),
        array('label'=>'Kardiovaskuler', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenFisioterapiKardiovaskuler/index')),
        array('label'=>'Integument', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenFisioterapiIntegument/index')),
        array('label'=>'Konsultasi Poliklinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulPoliTRM/index')),
        //array('label'=>'SBAR', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/SbarTRM/index')), 
    ),
));
?>
