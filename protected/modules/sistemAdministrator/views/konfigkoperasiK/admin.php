<?php
$this->breadcrumbs=array(
	'Konfigkoperasi Ks'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('konfigkoperasi-k-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
	<legend class="rim2">Pengaturan <b>Konfigurasi Koperasi</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php /* echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut search-form">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div><!--search-form--> */ ?>
	<div class="block-tabel">
		<h6 class="rim2">Tabel Konfigurasi Koperasi</h6>
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'konfigkoperasi-k-grid',
		'dataProvider'=>$model->search(),
		// 'filter'=>$model,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
			//'konfigkoperasi_id',
			array(
				'name'=>'persjasasimpanan',
				'value'=>'MyFormatter::formatNumberForPrint($data->persjasasimpanan, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persjasapinjaman',
				'value'=>'MyFormatter::formatNumberForPrint($data->persjasapinjaman, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persdanapengurus',
				'value'=>'MyFormatter::formatNumberForPrint($data->persdanapengurus, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persdanakaryawan',
				'value'=>'MyFormatter::formatNumberForPrint($data->persdanakaryawan, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persdanapendidikan',
				'value'=>'MyFormatter::formatNumberForPrint($data->persdanapendidikan, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persdanasosial',
				'value'=>'MyFormatter::formatNumberForPrint($data->persdanasosial, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persdanacadangan',
				'value'=>'MyFormatter::formatNumberForPrint($data->persdanacadangan, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persbiayaprovisasi',
				'value'=>'MyFormatter::formatNumberForPrint($data->persbiayaprovisasi, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'persjasadeposito',
				'value'=>'MyFormatter::formatNumberForPrint($data->persjasadeposito, 2)',
				'htmlOptions'=>array(
					'style'=>'text-align: right',
				),
			),
			array(
				'name'=>'pimpinankoperasi_id',
				'type'=>'raw',
				'value'=>function($data) {
					return empty($data->pimpinankoperasi_id)?"-":$data->pimpinan->nama_pegawai;
				},
			),
			array(
				'name'=>'penguruskoperasi_id',
				'type'=>'raw',
				'value'=>function($data) {
					return empty($data->penguruskoperasi_id)?"-":$data->pengurus->nama_pegawai;
				},
			),
			array(
				'name'=>'bendaharakoperasi_id',
				'type'=>'raw',
				'value'=>function($data) {
					return empty($data->bendaharakoperasi_id)?"-":$data->bendahara->nama_pegawai;
				},
			),
			array(
				'name'=>'bendaharars_id',
				'type'=>'raw',
				'value'=>function($data) {
					return empty($data->bendaharars_id)?"-":$data->bendahara_rs->nama_pegawai;
				},
			),
		/*
		'persdanasosial',
		'persdanacadangan',
		'persbiayaprovisasi',
		'persjasadeposito',
		'pimpinankoperasi_id',
		'penguruskoperasi_id',
		'bendaharakoperasi_id',
		'bendaharars_id',
		'status_aktif',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/ /*
			array(
				'header'=>Yii::t('zii','View'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{view}',
				'buttons'=>array(
					'view' => array(),
				 ),
			),
			*/
			array(
				'header'=>Yii::t('zii','Update'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{update}',
				'buttons'=>array(
					'update' => array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Delete'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{remove} {delete}',
				'buttons'=>array(
					'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->konfigkoperasi_id))',
							'click'=>'function(){nonActive(this);return false;}',
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
					),
					'delete'=> array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
					),
				)
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
</div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah KonfigkoperasiK',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
	$this->widget('UserTips',array('content'=>''));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#konfigkoperasi-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div>
<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('konfigkoperasi-k-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>
