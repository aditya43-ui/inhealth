<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Monitoring Pasca Anastesi/ Sedasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>$module.'/MonitoringPascaAnestesi/index')),
        array('label'=>'Skor Pasca Anastesi /Sedasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>$module.'/SkorpascaanestesiT/index')),
//        array('label'=>'Rencana Tindakan Dan Obat Alkes', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>$module.'/RencanaTindakanObat/index')),
//        array('label'=>'Informasi Tindakan Anestesi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=true);', 'tab'=>$module.'/InformasiTindakanAnestesi/index')),
//        array('label'=>'Persetujuan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>$module.'/PersetujuanTindakanAnastesi/index')),
        array('label'=>'Pesanan Pasca Anastesi / Sedasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this,value=false);', 'tab'=>$module.'/PesananPascaAnastesi/index')),
        
    ),
));
?>
