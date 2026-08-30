<div id="frame-detail">
<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
   'items'=>array(
        array('label'=>'Seleksi Kuesioner', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'tabmenu-li', 'onclick'=>'setTab(this,value="cekseleksi");','pendonor_id'=>$modPendonor->pendonor_id,'daftardonasi_id'=>$modDaftarDonasi->daftardonasi_id, 'tab'=>$module.'/InformasiDaftarPendonor/seleksiIndex', 'tabulasi'=>'seleksi')),
        array('label'=>'Seleksi Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'tabmenu-li', 'onclick'=>'setTab(this,value="cektandavital");','pendonor_id'=>$modPendonor->pendonor_id,'daftardonasi_id'=>$modDaftarDonasi->daftardonasi_id, 'tab'=>$module.'/InformasiDaftarPendonor/seleksiTandaVitalIndex', 'tabulasi'=>'TandaVital')), 
        array('label'=>'Pencatatan Kantong Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('class'=>'tabmenu-li', 'onclick'=>'setTab(this,value="cekkantong");','pendonor_id'=>$modPendonor->pendonor_id,'daftardonasi_id'=>$modDaftarDonasi->daftardonasi_id, 'tab'=>$module.'/InformasiDaftarPendonor/detailKantongDarah', 'tabulasi'=>'kantongdarah')),
    
    ),
    'htmlOptions'=>array(
        'id'=>'tabber',
    )
));
?>
</div>
