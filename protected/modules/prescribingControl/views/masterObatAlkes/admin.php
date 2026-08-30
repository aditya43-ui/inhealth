<?php
$this->breadcrumbs=array(
	'Pcobatalkesdetail Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pcobatalkesdetail-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Obat</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); 
        ?>
    </div> <!--search-form--> 
    
        <!--<h6>Tabel <b>Obat</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pcobatalkesdetail-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    ////'obatalkesdetail_id',
                    array(
                            'header'=>'Kode Obat',
                            'name'=>'obatalkes_id',
                            'value'=>'$data->obatalkes->obatalkes_kode',
                            'filter'=>  CHtml::listData(ObatalkesM::model()->findAll(),'obatalkes_id','obatalkes_kode'),
                    ),
                    array(
                            'header'=>'Nama Obat',
                            'name'=>'obatalkes_id',
                            'value'=>'$data->obatalkes->obatalkes_nama',
                            'filter'=>  CHtml::listData(ObatalkesM::model()->findAll(),'obatalkes_id','obatalkes_nama'),
                    ),
    //		'obatalkes_id',
    //		'indikasi',
    //		'kontraindikasi',
                    array(
                            'name'=>'komposisi',
                            'type'=>'raw',
                            'value'=>'$data->komposisi',
                    ),
                    array(
                            'name'=>'efeksamping',
                            'type'=>'raw',
                            'value'=>'$data->efeksamping',
                    ),
                    array(
                            'name'=>'peringatan',
                            'type'=>'raw',
                            'value'=>'$data->peringatan',
                    ),
                    array(
                            'header'=>'Status',
                            'type'=>'raw',
                            'value'=>'isset($data->obatalkes->obatalkes_aktif)? "Aktif" : "Tidak Aktif"',
                    ),
                    /*
                    'interaksiobat',
                    'carapenyimpanan',
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
                                    'delete'=> array(),
                            )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    <!--</div>-->
    <?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Obat',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
	$this->widget('UserTips',array('type'=>'admin'));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pcobatalkesdetail-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
</div>