
<?php
$this->breadcrumbs=array(
	'Kasuspenyakitruangan M'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Ruangan ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#kelaspelayanan').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rjkelasruangan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,)); ?>
</div><!-- search-form -->
<legend class="rim">Tabel Kelas Ruangan</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'rjkelasruangan-m-grid',
	'dataProvider'=>$model->searchTabel(),
	'filter'=>$model,
        'enableSorting'=>true,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//                'extraRowColumns' => array('ruangan.ruangan_nama'),
        'mergeColumns' =>'ruangan_nama',
	'columns'=>array(
                    array(
                        'name'=>'ruangan_nama',
                        'header'=>'Nama Ruangan',
                        'value'=>'$data->ruangan->ruangan_nama',
                    ),
                    array(
                        'header'=>'Nama Kelas',
                        'name'=>'kelaspelayanan_nama',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                        'htmlOptions'=>array(
                            'style'=>'border-left:1px solid #DDDDDD',
                        ),
                    ),
                    array(
                        'header'=>'Nama Lainnya',
                        'name'=>'kelaspelayanan_namalainnya',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_namalainnya',
                    ),
                    array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view'=>array(
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View",array("id"=>"$data->ruangan_id"))',
                            ),
                        ),
                    ),
                    array(
                        'header'=>Yii::t('zii','Update'),
                        'class'=>'ext.bootsrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Update",array("id"=>"$data->ruangan_id"))',
                            ),
                        ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                         'buttons'=>array(
                            'delete'=>array(
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Delete",array("ruangan_id"=>"$data->ruangan_id","kelaspelayanan_id"=>"$data->kelaspelayanan_id"))',
                            ),
                        ),
                    ),
	),
      'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
)); ?>

<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Kelas Ruangan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";        
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 

        $content = $this->renderPartial('laboratorium.views.tips.master2',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 

        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sanapza-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sanapza-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script>
$(document).ready(function(){
        $("input[name='LBKelasruangan[ruangan_nama]']").focus();
});
</script>