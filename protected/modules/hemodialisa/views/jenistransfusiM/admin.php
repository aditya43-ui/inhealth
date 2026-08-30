<?php
$this->breadcrumbs=array(
	'Jenistransfusi Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('jenistransfusi-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">  
     <div class="panel-heading">
	   <div class="panel-title">Pengaturan <b>Jenis Transfusi</b></div>				
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
                <div class="panel-title">Tabel <b>Jenis Transfusi</b></div>
            </div>      
          <div class="panel-body">
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'jenistransfusi-m-grid',
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
		'jenistransfusi_nama',
		'jenistransfusi_namalain',
			array(
				'header'=>'Deskripsi',
				'value' => '$data->jenistransfusi_desc',
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
//							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Delete'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
//				'template'=>'{remove} {delete}',
				'template'=>'{delete}',
				'buttons'=>array(
//					'remove' => array (
//							'label'=>"<i class='icon-form-silang'></i>",
//							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->jenistransfusi_id))',
//							'click'=>'function(){nonActive(this);return false;}',
//							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
//					),
					'delete'=> array(
							'label'=>"<i class='entypo-trash'></i>",
							'options'=>array('title'=>Yii::t('mds','Delete')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>$data->jenistransfusi_id))',
							'click'=>'function(){dataDelete(this);return false;}',
//							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"delete"))',
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
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Transfusi', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('hemodialisa.views.tips.master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#jenistransfusi-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenistransfusi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div></div>
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
							$.fn.yiiGridView.update('jenistransfusi-m-grid');
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
							$.fn.yiiGridView.update('jenistransfusi-m-grid');
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