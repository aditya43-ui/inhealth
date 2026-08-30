<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('edukasipenjelasan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Penjelasan Edukasi</strong></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
        <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
            'model'=>$model,
        )); ?>
        </div>
        <hr/>
            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tabel Penjelasan Edukasi</div>
                </div>
                <div class="panel-body">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                        'id'=>'edukasipenjelasan-m-grid',
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
                                'name'=>'kodeedukator',
                                'filter'=>CHtml::activeDropDownList($model, 'kodeedukator', LookupM::getItems('kodeedukator'), array(
                                    'empty'=>'-- Pilih --',
                                ))
                            ),
                        'nama_penjelasan',
                        'urutan',
                            array(
                                'header'=>'Status',
                                'name'=>'is_aktif',
                                'type'=>'raw',
                                'value'=>function($data){
                                    return $data->is_aktif ? "Aktif" : "Tidak Aktif";
                                },
                                'filter'=>false,
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
                                            // 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    ),
                                 ),
                            ),
                            array(
                                'header'=>Yii::t('zii','Delete'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{remove} {delete}',
                                'buttons'=>array(
                                    'remove' => array (
                                            'label'=>"<i class='glyphicon glyphicon-remove'></i>",
                                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->edukasipenjelasan_id))',
                                            'click'=>'function(){nonActive(this);return false;}',
                                            // 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                                    ),
                                    'delete'=> array(
                                            //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                    ),
                                )
                            ),
                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    )); ?>

                </div>
            </div>    
            
        <?php 
        echo CHtml::link(Yii::t('mds','{icon} Tambah Penjelasan Edukasi',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $this->widget('UserTips',array('content'=>''));
        $urlPrint= $this->createUrl('print');
        ?>
    </div>
</div>

    <?php

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#edukasipenjelasan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div>
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
							$.fn.yiiGridView.update('edukasipenjelasan-m-grid');
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