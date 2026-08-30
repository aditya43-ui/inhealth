<style>
    li {
        background : white !important;
        padding-right:10px;
    }
    
</style>
<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pasien Anak (< 13 Tahun)','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPasienAnak())),
        array('label'=>'Pasien Dewasa (>= 13 Tahun)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPasienDewasa())),
        
    ),
    'htmlOptions'=>array('class'=>'menu')
));
?>