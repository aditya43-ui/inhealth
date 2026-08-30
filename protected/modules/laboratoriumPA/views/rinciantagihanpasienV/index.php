<?php

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rincian Tagihan Pasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJRinciantagihanpasienV', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RJRinciantagihanpasienV', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rjrinciantagihanpasien-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>


    <?php
//    $data[] = array(
//'rowid' => 1,
//'id' => 2,
//'name' =>3,
//'qty' => 4,
//'price' => 5,
//'subtotal' => 6
//);
//    echo print_r($data[0]['price']);
    ?>

<?php 
$module  = $this->module->name; 
$controller = $this->id;
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjrinciantagihanpasien-v-grid',
	'dataProvider'=>$model->searchRincianTagihan(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                'tgl_pendaftaran',
                array(
                    'header'=>'No. Rekam Medik<br/>No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->noRMNoPend',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->NamaNamaBIN',
                ),
                array(
                    'header'=>'Jenis Penjamin <br/>Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->CaraBayarPenjamin',
                ),
                'nama_pegawai',
                'jeniskasuspenyakit_nama',
                array(
                    'header'=>'Status Bayar',
                    'type'=>'raw',
                    'value'=>'(empty($data->pembayaranpelayanan_id)) ? "Belum Lunas" : "Lunas"' ,
                ),
                'totaltagihan',
                array(
                    'header'=>'Rincian',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-list\'></idcon>", Yii::app()->createUrl("'.$module.'/'.$controller.'/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                ),		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<div class="search-form">
<?php $this->renderPartial('laboratoriumPA.views.rinciantagihanpasienV._search',array(
	'model'=>$model,
)); ?>
    </div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>