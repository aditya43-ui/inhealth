<?php
$this->breadcrumbs=array(
    'Coolboxdarah Ms'=>array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('coolboxdarah-m-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pengaturan <strong>Cool Box Darah</strong></div>
            </div>
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
                <p></p><div class="cari-lanjut2 search-form" style="display:none;padding: 10px">
                <?php $this->renderPartial($this->path_view.'_search',array(
                    'model'=>$model,
                )); ?>
                </div><!-- search-form --><hr>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Cool Box Darah</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: auto;max-width: 100%">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                            'id'=>'coolboxdarah-m-grid',
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
                                'coolboxdarah_nama',
                                'coolbox_merk',
                                'coolbox_jenis',
                                'coolbox_ukuran',
                                array(
                                    'header' => 'Jumlah Ice Pack',
                                    'name' => 'jml_icepack',
                                ),
                                array(
                                    'header' => 'Jumlah Kantong',
                                    'name' => 'jml_isikantong',
                                ),
                                'jenis_kantong',
                                array(
                                    'header' => 'Standart Suhu &deg C',
                                    'name' => 'standart_suhu',
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
                                        'update' => array(),
                                    ),
                                ),
                                array(
                                    'header'=>Yii::t('zii','Delete'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{remove} {add} {delete}',
                                    'buttons'=>array(
                                        'remove' => array (
                                            'label'=>"<i class='glyphicon glyphicon-remove'></i>",
                                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->coolboxdarah_id))',
                                            'click'=>'function(){nonActive(this);return false;}',
                                            'visible'=>'(($data->coolbox_aktif == 1) ? TRUE : FALSE)',
                                        ),
                                        'add' => array (
                                            'label'=>"<i class='".MyIcon::getIcons('tambah')."'></i>",
                                            'options'=>array('title'=>Yii::t('mds','Add Temporary')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->coolboxdarah_id))',
                                            'click'=>'function(){active(this);return false;}',
                                            'visible'=>'(($data->coolbox_aktif == 1) ? FALSE : TRUE)',
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
                echo CHtml::link(Yii::t('mds','{icon} Tambah Coolbox Darah',array('{icon}'=>'<i class="entypo-plus"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
                $content = $this->renderPartial($this->path_view.'tips/master',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                $urlPrint= $this->createUrl('print');
                $js = <<< JSCRIPT
                function print(caraPrint){
                    window.open("${urlPrint}/"+$('#coolboxdarah-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
                Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
                ?>
            </div>
        </div>
    </div>
</div>
<!--<div class="block-tabel">-->
<!--<h6 class="rim2">Tabel Indikator penilaianiku</h6>-->	
<!--</div>-->
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
							$.fn.yiiGridView.update('coolboxdarah-m-grid');
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
		myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('coolboxdarah-m-grid');
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