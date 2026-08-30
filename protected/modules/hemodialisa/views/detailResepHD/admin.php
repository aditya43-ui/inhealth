<?php
$this->breadcrumbs=array(
	'Resephd Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('resephddet-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">  
     <div class="panel-heading">
	   <div class="panel-title">Pengaturan <b>Detail Paket HD</b></div>				
    </div> 
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
        <hr>
	<div class="panel panel-success"> 
            <div class="panel-heading">  
                <div class="panel-title">Tabel <b>Obat/Alkes HD</b></div>
            </div>      
          <div class="panel-body">
		
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'resephddet-m-grid',
		'dataProvider'=>$dataProvider,
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
                        'header'=>'Nama Paket',
                        'type' => 'raw',
                        'value'=>'$data->resephd_nama',
                        'filter' => CHtml::activeDropDownList($model, 'resephd_id', CHtml::listData(ResephdM::model()->findAll('resephd_aktif = TRUE'), 'resephd_id', 'resephd_nama'), ['empty' => '-- Pilih --']),
                    ),
                    array(
                        'header'=>'Kode Obat/Alkes',
//                        'name'=>'obatalkes_kode',
                        'type' => 'raw',
                        'value'=>'$data->obatalkes_kode',
                        'filter' => CHtml::activeTextField($model, 'obatalkes_kode', []),
                    ),
                    array(
                        'header'=>'Nama Obat/Alkes',
                        'name'=>'obatalkes_nama',
                        'value'=>'$data->obatalkes_nama'
                    ),
                    array(
                        'header'=>'Satuan Kecil',
//                        'name'=>'resephd_nama',
                        'type' => 'raw',
                        'value'=>'$data->satuankecil_nama',
                        'filter' => CHtml::activeDropDownList($model, 'satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll('satuankecil_aktif = TRUE'), 'satuankecil_id', 'satuankecil_nama'), ['empty' => '-- Pilih --']),
                    ),
                    array(
                        'header'=>'Harga Satuan',
//                        'name'=>'resephd_nama',
                        'value'=>'$data->hargajual'
                    ),
//		'resephd_nama',
//		'resephd_desc',
//		'resephd_aktif',
//			
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
//                                'template'=>'{remove} {add} {delete}',
                                'template'=>'{delete}',
                                'buttons'=>array(
//                                        'remove' => array (
//                                                        'label'=>"<i class='glyphicon glyphicon-remove'></i>",
//                                                        'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->resephd_id))',
//                                                        'click'=>'function(){nonActive(this);return false;}',
//                                                        'visible'=>'(($data->resephd_aktif)? TRUE : FALSE)'
//                                        ),
//                                        'add' => array (
//                                                        'label'=>"<i class='".MyIcon::getIcons('tambah')."'></i>",
//                                                        'options'=>array('title'=>Yii::t('mds','Add Temporary')),
//                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->resephd_id))',
//                                                        'click'=>'function(){active(this);return false;}',
//                                                        'visible'=>'(($data->resephd_aktif)? FALSE : TRUE)'
//                                        ),
                                        'delete'=> array(),
                                )
                        ),
			
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
</div> 
</div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Detail Paket HD',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial('hemodialisa.views.tips.master',array(),true);
	$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#resephd-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div> 
</div>
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
							$.fn.yiiGridView.update('resephd-m-grid');
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
	function active(obj){
		myConfirm("Yakin akan mengaktifkan data ini?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('resephd-m-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal diaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal diaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>