<?php 
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Penyedia', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'onclick'=>'setTab(this);', 'tab'=>$module.'/informasiPengadaanLelang'.'/penyedia')),
        array('label'=>'Penawaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/informasiPengadaanLelang'.'/penawaran')),       
        array('label'=>'Seleksi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/ppdsPendidikanM'.'/create')),       
        array('label'=>'Pengumuman', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/ppdspelatihanM'.'/create')),       
    ),
));
?>

<?php $this->renderPartial($this->path_detail.'_jsFunctions'); ?>