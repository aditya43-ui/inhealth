<?php
$this->breadcrumbs=array(
	'Samberita Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('samberita-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<legend class="rim2">Pengaturan Berita</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
    <?php $this->renderPartial('_search',array(
            'model'=>$model,
    )); ?>
</div><!--search-form-->
<div class="block-tabel">
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'samberita-m-grid',
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
		////'mberita_id',
//		array(
//                        'name'=>'mberita_id',
//                        'value'=>'$data->mberita_id',
//                        'filter'=>false,
//                ),
		// 'mkategoriberita_id',
        'mkategoriberita.kategoriberita',
		'judulberita',
		'ringkasanberita',
		array(
			'name'=>'isiberita',
			'type'=>'raw',
			'value'=>'$data->isiberita',
		),
		// 'gambarberita_path',
        array(
                'name'=>'gambarberita_path',
                'type'=>'raw',
                'value'=>'CHtml::image(Params::urlBerita().$data->gambarberita_path,"", array("width"=>"120px","height"=>"110px"))',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'headerHtmlOptions'=>array('style'=>'color:#373e4a;vertical-align:top;text-align:center;'),
                'filter'=>false,
            ),
		/*
		'gambarberita_text',
		'keteranganberita',
		'beritaterkait',
		'waktutampilberita',
		'waktuselesaitampil',
		'tglbuatberita',
		'create_user',
		*/
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
                            'update' => array(),
                         ),
		),
		array(
			'header'=>Yii::t('zii','Delete'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{delete}',
			'buttons'=>array(
			
//				'remove' => array ( //dihilangkan karena tidak ada field untuk nonaktif di tabel
//						'label'=>"<i class='icon-form-silang'></i>",
//						'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//						'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->mberita_id))',
//						'click'=>'function(){removeTemporary(this);return false;}',
//				),
				'delete'=> array(),
			)
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<?php 
 
        echo CHtml::link(Yii::t('mds','{icon} Tambah Berita',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $content = $this->renderPartial('tips/admin',array(),true);
        $this->widget('UserTips',array('type'=>'admin', 'content'=>$content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#samberita-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(obj){
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('samberita-m-grid');
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