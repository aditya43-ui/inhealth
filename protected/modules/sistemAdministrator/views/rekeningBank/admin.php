<?php
$this->breadcrumbs=array(
	'Jenispenerimaan Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
	(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bank', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bank', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('bank-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

//$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'jenispenerimaan-m-grid',
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
                    'header'=>'Kode',
                    'name'=>'jenispenerimaan_kode',
                    'value'=>'$data->jenispenerimaan_kode',
                ),
		array(
                    'header'=>'Jenis Penerimaan',
                    'name'=>'jenispenerimaan_nama',
                    'value'=>'$data->jenispenerimaan_nama',
                ),
		array(
                    'header'=>'Nama Lain',
                    'name'=>'jenispenerimaan_namalain',
                    'value'=>'$data->jenispenerimaan_namalain',
                ),
//		array(
//                    'header'=>'Rekening Debit',
//                    'name'=>'rekeningdebit_id',
//                    'type'=>'raw',
//                    'value'=>'$data->rekeningdebit->nmrekening5.CHtml::Link("<i class=\"icon-pencil\"></i>",Yii::app()->controller->createUrl("jurnalRekPenerimaan/ubahRekeningDebitKredit",array("id"=>$data->jenispenerimaan_id)),
//                            array("class"=>"", 
//                                  "target"=>"iframeEditRekeningDebitKredit",
//                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
//                                  "rel"=>"tooltip",
//                                  "title"=>"Klik untuk ubah Rekening Debit",
//                            ))',
//                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
//                ),
//		array(
//                    'header'=>'Rekening Kredit',
//                    'type'=>'raw',
//                    'name'=>'rekeningkredit_id',
//                    'value'=>'$data->rekeningkredit->nmrekening5.CHtml::Link("<i class=\"icon-pencil\"></i>",Yii::app()->controller->createUrl("jurnalRekPenerimaan/ubahRekeningDebitKredit",array("id"=>$data->jenispenerimaan_id)),
//                            array("class"=>"", 
//                                  "target"=>"iframeEditRekeningDebitKredit",
//                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
//                                  "rel"=>"tooltip",
//                                  "title"=>"Klik untuk ubah Rekening Kredit",
//                            ))',
//                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
//                ),
		array(
                    'header'=>'Status',
                    'value'=>'($data->jenispenerimaan_aktif = 1 ) ? "Aktif" : "Tidak Aktif" ',
                ),
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
                                                'label'=>"<i class='icon-form-silang'></i>",
                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->jenispenerimaan_id"))',
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

<?php 
 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenispenerimaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php 
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogUbahRekeningDebitKredit',
    'options'=>array(
        'title'=>'Ubah Data Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300"></iframe>
<?php $this->endWidget(); ?>
