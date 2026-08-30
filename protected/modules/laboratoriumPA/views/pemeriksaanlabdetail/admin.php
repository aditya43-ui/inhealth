<?php
$this->breadcrumbs=array(
	'Lkpemeriksaanlabdet Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' LKPemeriksaanlabdet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//array_push($arrMenu,array('label'=>Yii::t('mds','List').' LBPemeriksaanlabdetM', 'icon'=>'list', 'url'=>array('index'))) ;
//(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' LBPemeriksaanlabdetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Nilairujukan', 'icon'=>'file', 'url'=>array('nilaiNormalPemeriksaan/create','modul_id'=>Yii::app()->session['modul_id']))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('lkpemeriksaanlabdet-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'lkpemeriksaanlabdet-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        //'extraRowColumns' => array('nilairujukan.kelompokumur'),
        'mergeColumns' => array('nilairujukan.kelompokumur','pemeriksaanlab.pemeriksaanlab_nama','nilairujukan.kelompokdet','nilairujukan.namapemeriksaandet','nilairujukan.nilairujukan_jeniskelamin'),
	'columns'=>array(
		////'pemeriksaanlabdet_id',
		array(
                        'header'=>'ID',
                        'name'=>'pemeriksaanlabdet_id',
                        'value'=>'$data->pemeriksaanlabdet_id',
                        'filter'=>false,
                ),
//		'nilairujukan_id',
                array(
                    'name'=>'pemeriksaanlab.pemeriksaanlab_nama',
                    'header'=>'Pemeriksaan LAB',
                    'value'=>'$data->pemeriksaanlab->pemeriksaanlab_nama',
                    'filter'=>$model->pemeriksaanlab->pemeriksaanlab_nama,
                ),
                'nilairujukan.kelompokdet',
                'nilairujukan.namapemeriksaandet',
                'nilairujukan.kelompokumur',
                'nilairujukan.nilairujukan_jeniskelamin',
                'nilairujukan.nilairujukan_nama',
                'nilairujukan.nilairujukan_min',
                'nilairujukan.nilairujukan_max',
                'nilairujukan.nilairujukan_satuan',
                'nilairujukan.nilairujukan_metode',
                'nilairujukan.nilairujukan_keterangan',
		//'pemeriksaanlab.pemeriksaanlab_nama',
		//'pemeriksaanlabdet_nourut',
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
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
                                                'label'=>"<i class='icon-remove'></i>",
                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pemeriksaanlabdet_id"))',
                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                        ),
                                        'delete'=> array(
                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                        ),
                        )
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<div class="form-actions">
<?php 
 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#lkpemeriksaanlabdet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
</div>
