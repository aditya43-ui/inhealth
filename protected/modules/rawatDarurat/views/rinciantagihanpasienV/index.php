<?php

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rincian Tagihan Pasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RDRinciantagihanpasienV', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RDRinciantagihanpasienV', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
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

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>

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
	'dataProvider'=>$model->searchDaftarPasienRincian(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                'tgl_pendaftaran',
                array(
                    'header'=>'No. Rekam Medik<br>No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik.\'<br>\'.$data->no_pendaftaran',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->NamaNamaBIN',
                ),
                array(
                    'header'=>'Jenis Penjamin <br>Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->CaraBayarPenjamin',
                ),
//                'nama_pegawai',
                array(
                    'header'=>'Dokter/<br>Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'"$data->nama_pegawai"."<br>"."$data->kelaspelayanan_nama"',
                ),
                'jeniskasuspenyakit_nama',
                
                array(
                    'header'=>'Total Tagihan',
                    'type'=>'raw',
                    'value'=>'number_format($data->Totaltagihan,0,\',\',\'.\')',  
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Status Bayar',
                    'type'=>'raw',
                    'value'=>'(empty($data->pendaftaran->pembayaranpelayanan_id)) ? "Belum Lunas" : "Lunas"' ,
                ),
//                'totaltagihan',
                array(
                    'header'=>'Rincian',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></idcon>", Yii::app()->createUrl("'.$module.'/RinciantagihanpasienExtendsV/rincianBelumBayarRD", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<div class="search-form">
<?php $this->renderPartial('rawatJalan.views.rinciantagihanpasienV._search',array(
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
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>