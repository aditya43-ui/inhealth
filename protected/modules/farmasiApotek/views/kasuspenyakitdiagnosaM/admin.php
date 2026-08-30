
<?php
$this->breadcrumbs=array(
	'Kasuspenyakitdiagnosa M'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Kasus Penyakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa Kasus Penyakit', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rjkasuspenyakitdiagnosa-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array('model'=>$model,)); ?>
</div><!--search-form-->

<?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'rjkasuspenyakitdiagnosa-m-grid',
	'dataProvider'=>$model->searchTabel(),
	'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'mergeColumns'=>'jeniskasuspenyakit.jeniskasuspenyakit_nama',
	'columns'=>array(
                    array(
                        'name'=>'jeniskasuspenyakit.jeniskasuspenyakit_nama',
                        'header'=>'Jenis Kasus Penyakit',
                        'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
                    ),
                    array(
                        'header'=>'Nama Diagnosa',
                        'value'=>'$data->diagnosa->diagnosa_nama',
                        'htmlOptions'=>array(
                            'style'=>'border-left:solid 1px #DDDDDD',
                        ),
                    ),
                    array(
                        'header'=>'Nama Lainnya',
                        'value'=>'$data->diagnosa->diagnosa_namalainnya',
                    ),
                    array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view'=>array(
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View",array("id"=>"$data->jeniskasuspenyakit_id"))',
                            ),
                        ),
                    ),
                    array(
                        'header'=>Yii::t('zii','Update'),
                        'class'=>'ext.bootsrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Update",array("id"=>"$data->jeniskasuspenyakit_id"))',
                            ),
                         ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(
                            'delete'=>array(
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Delete",array("jeniskasuspenyakit_id"=>"$data->jeniskasuspenyakit_id","diagnosa"=>"$data->diagnosa_id"))',
                            ),
                         ),
                    ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php 
 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
       $content = $this->renderPartial('../tips/master',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rjkasuspenyakitdiagnosa-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>