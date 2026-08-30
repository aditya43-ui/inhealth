<?php
$this->breadcrumbs=array(
	'Shift HD'=>array('index'),
	'Pengaturan',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('resephd-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">  
     <div class="panel-heading">
	   <div class="panel-title">Pengaturan <b>Shift HD</b></div>				
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
                <div class="panel-title">Tabel <b>Shift HD</b></div>
            </div>      
          <div class="panel-body">
		
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'resephd-m-grid',
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
		'shift_hd_nama',
		'shift_hd_namalainnya',
                    array(
                        'header'=>'Jam Awal Shift',
                        'value'=>'$data->shift_hd_jamawal'
                    ),
                    array(
                        'header'=>'Jam Akhir Shift',
                        'value'=>'$data->shift_hd_jamakhir'
                    ),
//		'shift_hd_jamawal',
//                'shift_hd_jamakhir',
                    array(
                        'name' => 'shift_hd_urutan',
                        'htmlOptions'=>array('class'=>'integer')
                    ),
//                    'shift_hd_urutan',
			array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->shift_hd_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
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
                                'template'=>'{remove} {add} {delete}',
                                'buttons'=>array(
                                        'remove' => array (
                                                        'label'=>"<i class='icon-form-silang'></i>",
                                                        'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->shift_hd_id))',
                                                        'click'=>'function(){nonActive(this);return false;}',
                                                        'visible'=>'(($data->shift_hd_aktif)? TRUE : FALSE)'
                                        ),
                                        'add' => array (
                                                        'label'=>"<i class='".MyIcon::getIcons('tambah')."'></i>",
                                                        'options'=>array('title'=>Yii::t('mds','Add Temporary')),
                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->shift_hd_id))',
                                                        'click'=>'function(){active(this);return false;}',
                                                        'visible'=>'(($data->shift_hd_aktif)? FALSE : TRUE)'
                                        ),
                                        'delete'=> array(),
                                )
                        ),
			
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
</div> 
</div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Shift HD',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
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
                                                            myAlert('Data berhasil dinonaktifkan!');
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
                                                            myAlert('Data berhasil diaktifkan!');
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