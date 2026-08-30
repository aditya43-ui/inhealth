<?php 
/**
 * view yang digunakan untuk menambahkan tabulasi menu
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
$module = '/'.$this->module->id;
$is_verifikasi = $modPendaftaran->verifikasitagihan_id != null;
// var_dump($is_verifikasi);die;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(      
        
        array('label'=>'Verifikasi Apoteker', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pasienRawatInap/pilihResep')),
        array('label'=>'Reseptur', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/resepturVerifikasiApoteker/index')),
        array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CPPTRI/index')),
        
    ),
    'htmlOptions'=>[
        'id'=>'tab-periksa'
    ] 
));
?>