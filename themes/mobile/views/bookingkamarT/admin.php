<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppbooking-kamar-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset>
    <legend class="rim2">Informasi Pesan Kamar</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ppbooking-kamar-t-grid',
	'dataProvider'=>$model->searchBooking(),
//	'filter'=>$model,
        'template'=>"{pager}{summary}\n{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'bookingkamar_id',
		
		'tgltransaksibooking',
                array(
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->pendaftaran->no_pendaftaran',
                ),
                'tglbookingkamar',
                  array(
                   'name'=>'pasien_id',
                   'type'=>'raw',
                   'value'=>'(!empty($data->pasien_id) ? CHtml::link("<i class=\'icon-user\'></i> ".$data->pasien->no_rekam_medik, "javascript:daftarKeRI(\'$data->pasien_id\',\'$data->pendaftaran_id\',\'$data->bookingkamar_id\');",array("id"=>"$data->pasien_id","title"=>"Klik Untuk Mendaftarkan ke Rawat Inap")) : "-") ',
                   'htmlOptions'=>array('style'=>'text-align: center')
                ),
               'NamaNamaBIN',
                array(
                        'name'=>'ruangan_id',
                        'type'=>'raw',
                        'value'=>'$data->ruangan->ruangan_nama',
                ),
                array(
                        'name'=>'kamarruangan_id',
                        'type'=>'raw',
                        'value'=>'$data->kamarruangan->kamarruangan_nokamar',
                ),
                array(
                        'name'=>'kelaspelayanan_id',
                        'type'=>'raw',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                ),
//                'bookingkamar_no',
                'statusbooking',
            
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
                                          'visible'=>'Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)',
                                        ),
                         ),
		),
		array(
                        'header'=>Yii::t('zii','Batal'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(
                                        'delete'=> array(
                                                'visible'=>'Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)',
                                        ),
                        )
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<div class="search-form" style="display:block">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

</fieldset>
<?php 
 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
      //  $this->widget('UserTips',array('type'=>'admin'));
       // $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
      //  $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
      //  $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
      //  $urlPendaftaranRI=Yii::app()->createAbsoluteUrl($module.'/Pendaftaran/RawatInap');


$js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppbuat-janji-poli-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function daftarKeRI(pasien_id,pendaftaran_id,bookingkamar_id)
{
    $('#pasien_id').val(pasien_id);
    $('#pendaftaran_id').val(pendaftaran_id);
    $('#bookingkamar_id').val(bookingkamar_id);
    $('#form_hidden').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'form_hidden',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'action'=>$urlPendaftaranRI,
        'htmlOptions'=>array('target'=>'_new'),
)); ?>
    <?php echo CHtml::hiddenField('pasien_id','',array('readonly'=>true));?>
    <?php echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true));?>
    <?php echo CHtml::hiddenField('bookingkamar_id','',array('readonly'=>true));?>
<?php $this->endWidget(); ?>
