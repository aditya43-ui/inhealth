<?php
$this->breadcrumbs=array(
	'Nurse Station'=>array('admin'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('nursestation-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pengaturan <strong>Nurse Station</strong></div>
            </div>
            <div class="panel-body">
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
				<div class="cari-lanjut search-form" style="display:none">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
				</div><!-- search-form -->
				<hr/>
				<div class="block-tabel">
				<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'nursestation-m-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
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
						array(
							'header'=>'Nama',
							'name'=>'nursestation_nama',
							'value' => '$data->nursestation_nama',
							'type'=>'raw',
							'filter'=>  CHtml::activeTextField($model,'nursestation_nama'),
						),
						array(
							'header'=>'Nama Lainnya',
							'value' => '$data->nursestation_namalain',
							'type'=>'raw',
						),
						array(
							'header'=>'Lokasi',
							'name'=>'nursestation_lokasi',
							'value' => '$data->nursestation_lokasi',
							'type'=>'raw',
							'filter'=>  CHtml::activeTextField($model,'nursestation_lokasi'),
						),
						array(
							'header'=>'Ruangan',
							'value' => '$data->getRuangan()',
							'type'=>'raw',
						),
						array(
							'header'=>'Telepon',
							'name'=>'nursestation_telp',
							'value' => '$data->nursestation_telp',
							'type'=>'raw',
							'filter'=>  CHtml::activeTextField($model,'nursestation_telp'),
						),
						array(
							'header'=>'Penanggung Jawab',
							'value' => 'isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : ""',
							'type'=>'raw',
						),
						array(
							'header'=>'Aktif',
							'value' => '($data->nursestation_akitf==1) ? "AKTIF" : "TIDAK"',
							'type'=>'raw',
						),
						array(
							'header'=>Yii::t('zii','View'),
							'class'=>'bootstrap.widgets.BootButtonColumn',
							'template'=>'{view}',
							'buttons'=>array(
								'view' => array(),
							),
						),
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
										'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->nursestation_id))',
										'click'=>'function(){nonActive(this);return false;}',
										'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
									'visible'=>($model->nursestation_akitf==0)? 'false' : 'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
								),
								'delete'=> array(
										'label'=>"<i class='icon-form-trash'></i>",
										'options'=>array('title'=>Yii::t('mds','Delete')),
										'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>$data->nursestation_id))',
										'click'=>'function(){dataDelete(this);return false;}',
										'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"delete"))',
								),
							)
						),
					),
					'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
						$("table").find("input[type=text]").each(function(){
										cekForm(this);
								})
								$("table").find("select").each(function(){
										cekForm(this);
								})
						}',
				)); ?>
				<div class="form-actions">
				<?php 
					echo CHtml::link(Yii::t('mds','{icon} Tambah Nurse station',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
					echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
					echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
					echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
					$this->widget('UserTips',array('content'=>''));
					$urlPrint= $this->createUrl('print');
				?>
				</div>
			</div>
		</div>
		
	</div>
</div>

<?php

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#nursestation-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#nursestation-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('nursestation-m-grid');
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
	function dataDelete(obj){
		myConfirm("Yakin akan menghapus data ini ?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('nursestation-m-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dihapus, data sedang digunakan di tabel lain!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dihapus!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>