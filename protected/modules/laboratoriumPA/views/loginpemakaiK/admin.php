<?php
$this->breadcrumbs=array(
	'Loginpemakai Ks'=>array('index'),
	'Manage',
);
$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Login Pemakai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Login Pemakai', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Login Pemakai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('loginpemakai-k-grid', {
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

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'loginpemakai-k-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		'loginpemakai_id',
		'nama_pemakai',
		'katakunci_pemakai',
		'lastlogin',
		'tglpembuatanlogin',
		'tglupdatelogin',
		/*
		'statuslogin',
		'loginpemakai_aktif',
		*/
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->loginpemakai_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//                array(
//                        'header'=>'Aktif',
//                        'class'=>  'CCheckBoxColumn',
//                        'selectableRows'=>0,
//                        'checked'=>'$data->loginpemakai_aktif',
//                        ),
		array(
                                                'header'=>'Lihat',
			'class'=>'bootstrap.widgets.BootButtonColumn',
                                                'template'=>'{view}',
		),
		array(
                                                'header'=>'Ubah',
			'class'=>'bootstrap.widgets.BootButtonColumn',
                                                'template'=>'{update}',
                                                'buttons'=>array(
                                                    'update' => array
                                                                        (
                                                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                                                        ),
                                                 ),
		),
		array(
                                                'header'=>'Hapus',
			'class'=>'bootstrap.widgets.BootButtonColumn',
                                                'template'=>'{remove}{delete}',
                                                     'buttons'=>array(
                                                        'remove' => array
                                                            (
                                                                'label'=>"<i class='icon-remove'></i>",
                                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->loginpemakai_id"))',
                                                                'visible'=>'($data->loginpemakai_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                                            ),
                                                         'delete' => array
                                                                        (
                                                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                                        ),
                                        )          
		),
                                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>


<?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
            $this->widget('UserTips',array('type'=>'admin'));

 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//


 
JSCRIPT;
Yii::app()->clientScript->registerScript('alert',$js,CClientScript::POS_BEGIN);

$js = <<< JSCRIPT
    function print(obj)
    {
         window.open("${urlPrint}/"+$('#loginpemakai-m_search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>