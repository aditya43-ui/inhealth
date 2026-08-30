<?php
$this->breadcrumbs=array(
	'Gfkonfigfarmasi Ks'=>array('index'),
	'Manage',
);

$arrMenu = array();
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Konfigurasi Farmasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Konfigurasi Farmasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
        $('#GFKonfigfarmasiK_persenppn').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gfkonfigfarmasi-k-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->
<legend class="rim">Tabel Konfigurasi Farmasi</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'gfkonfigfarmasi-k-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                ),
                array(
                    'header'=>'Tanggal Berlaku',
                    'value'=>'$data->tglberlaku',
                    'name'=>'tglberlaku',
                    'type'=>'raw',
                    'filter'=>CHtml::activeTextField($model,'tglberlaku'),
                ),
		'persenppn',
		'persenpph',            
                array(
                    'header'=>'Adm. Racikan',
                    'value'=>'$data->admracikan',
                    'name'=>'admracikan',
                    'type'=>'raw',
                ),
                array(
                    'header'=>'Total Persen Harga Jual Bebas',
                    'value'=>'$data->persjualbebas',
                    'name'=>'persjualbebas',
                    'type'=>'raw',
                ),
		'totalpersenhargajual',
                'marginresep',
                'marginnonresep',
                array(
                    'header'=>'Status',
                    'value'=>'($data->konfigfarmasi_aktif = 1 ) ? "Aktif" : "Tidak Aktif" ',
                ),
		array(
                    'header'=>Yii::t('zii','View'),
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                    'template'=>'{view}',
                    'buttons'=>array(
                        'view' => array (
                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Konfigurasi Farmasi'),
                                ),
                    ),
		),
		array(
                    'header'=>Yii::t('zii','Update'),
                    'class'=>'bootstrap.widgets.BootButtonColumn',
                    'template'=>'{update}',
                    'buttons'=>array(
                        'update' => array (
                                      'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                      'options'=>array('rel'=>'tooltip','title'=>'Ubah Konfigurasi Farmasi'),
                                    ),
                     ),
		),
//		array(
//                        'header'=>Yii::t('zii','Delete'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{remove} {delete}',
//                        'buttons'=>array(
//                                        'remove' => array (
//                                                'label'=>"<i class='icon-form-silang'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->konfigfarmasi_id"))',
//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                        ),
//                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//                                        ),
//                        )
//		),
	),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
         }',
));
?>
<?php 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $content = $this->renderPartial('../tips/masterPresentasiHarga',array(),true);
        $this->widget('UserTips',array('type'=>'admin','content'=>$content));        
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#gfkonfigfarmasi-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gfkonfigfarmasi-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script>
$('.filters #GFKonfigfarmasiK_tglberlaku').focus();    
</script>