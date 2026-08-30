<div style="margin-top: 17px;">
<?php 
/**
 * view yang digunakan untuk menambahkan tabulasi menu
 * 
 * @author Deni Hamdani <deinhamdani@piindonesia.co.id>
 */
$module = '/'.$this->module->id;

$items = array(        
    array('label'=>'Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'base-tab'=>'/gizi/tindakanGZ/index', 'tab'=>'/gizi/tindakanGZ/index', 'class' => 'tabulasi_asuhan')),
);

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=> $items,
));
?>
</div>