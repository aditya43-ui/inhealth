<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
   'items'=>array(
        array('label'=>'Skala Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>$module.'/observasiDonorDarah/detailtabnyeri&daftardonasi_id='.$daftardonasi_id, 'tabulasi'=>'observasiNyeri')),
        array('label'=>'Observasi Donor Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/observasiDonorDarah/detailtabobservasi&daftardonasi_id='.$daftardonasi_id.'&observasipendonor_id='.$observasipendonor_id, 'tabulasi'=>'observasiDonorDarah')),
    ),
));
?>