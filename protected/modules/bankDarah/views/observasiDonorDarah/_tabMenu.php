<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - diunakan untuk menambahkant tab menu
* RSST-1682
*/
?>
<div id="frame-detail">
<?php 

if ($modSeleksi->is_gagalseleksi == true){
    $tabObs = 'window.parent.myAlert("Observasi donor darah tidak dapat dilakukan, karena pendonor tidak lulus seleksi")';
}elseif ($modSeleksi->is_gagalseleksi == false){
    $tabObs = 'setTab(this,value=false);';
}

$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
   'items'=>array(
        array('label'=>'Skala Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'tabmenu-li', 'onclick'=>'setTab(this,true);','daftardonasi_id'=>$modDaftarDonasi->daftardonasi_id, 'tab'=>$module.'/observasiNyeri/index', 'tabulasi'=>'observasiNyeri')),
        array('label'=>'Observasi Donor Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'tabmenu-li', 'onclick'=>'setTab(this,true);','daftardonasi_id'=>$modDaftarDonasi->daftardonasi_id, 'tab'=>$module.'/observasiDonorDarah/penyadapan', 'tabulasi'=>'observasiDonorDarah')),
        array('label'=>'Observasi Setelah Penyadapan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'tabmenu-li', 'onclick'=>'setTab(this,true);','daftardonasi_id'=>$modDaftarDonasi->daftardonasi_id, 'tab'=>$module.'/observasiDonorDarah/pendonor', 'tabulasi'=>'observasiPendonor')),
//        array('label'=>'Pencatatan Kantong Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'tabmenu-li', 'onclick'=>'setTab(this,value=true);','daftardonasi_id'=>$modDaftarDonasi->daftardonasi_id, 'tab'=>$module.'/kantongDarah/index', 'tabulasi'=>'kantongdarah')),
    ),
    'htmlOptions'=>array(
        'id'=>'tabber',
    )
));
?>
</div>
