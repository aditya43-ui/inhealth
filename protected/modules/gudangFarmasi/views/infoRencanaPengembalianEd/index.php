<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
	<legend class="rim2">Informasi <b>Rencana Pengembalian Obat Alkes Expired Date</b></legend>
	<div class="block-tabel">
		<h6>Tabel <b>Rencana Pengembalian Obat Alkes Expired Date </b></h6>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'rencana-m-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-condensed',
			'columns'=>array(
					array(
						'name'=>'Tanggal Rencana',
						'type'=>'raw',
						'value'=>'MyFormatter::formatDateTimeForUser($data->tglrenpengembalian)',
					),
					'norenpengembalian',
					array(
						'name'=>'ruangan_id',
						'type'=>'raw',
						'value'=>'$data->ruangan->ruangan_nama',
					),
					array(
						'header'=>'Pegawai Mengetahui',
						'type'=>'raw',
						'value'=>'(isset($data->mengetahui_id)? $data->PegawaimengetahuiLengkap : "-").
						(isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmengetahui) : 
						(!isset($data->mengetahui_id)? "" :
						(!isset($data->tglmenyetujui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui", array("renpengembalianed_id"=>$data->renpengembalianed_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk approvement mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
						))',
					),
					array(
						'header'=>'Pegawai Menyetujui',
						'type'=>'raw',
						'value'=>'(isset($data->menyetujui_id)? $data->PegawaimenyetujuiLengkap : "-").
								(isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmenyetujui) : 
								((isset($data->menyetujui_id))&&(isset($data->mengetahui_id)) ? 
										
											CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui", array("renpengembalianed_id"=>$data->renpengembalianed_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk approvement menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');"))
										
										: 
											"<a rel=\'tooltip\' title=\'Tombol akan aktif jika data memiliki nama mengetahui dan menyetujui\'><icon class=\'icon-form-check\' style=\'opacity: 0.3\'></icon></a> "
									)
						)',
					),    
					array(
						'header'=>'Penerimaan Obat Alkes ED',
						'type'=>'raw',
						'value'=>'((isset($data->tglmenyetujui))&&(isset($data->tglmengetahui)) ?
									CHtml::Link("<i class=\"icon-form-mintatawar\"></i>","'.$this->createUrl("PenerimaanObatAlkesED/Index").'&rencana_id=$data->renpengembalianed_id",
										array("class"=>"", "rel"=>"tooltip","title"=>"Klik Penerimaan Obat Alkes",)) :
									"<a rel=\'tooltip\' title=\'Tombol akan aktif jika rencana sudah disetujui dan diketahui\'><icon class=\'icon-form-mintatawar\' style=\'opacity: 0.3\'></icon></a> "
									)	
						',
						'htmlOptions'=>array('style'=>'text-align:center;'),
					),
					array(
						'header'=>'Rincian',
						'type'=>'raw',
						'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Rincian", array("renpengembalianed_id"=>$data->renpengembalianed_id)),
									 array("class"=>"", 
										   "target"=>"rencana",
										   "onclick"=>"$(\"#dialogRencana\").dialog(\"open\");",
										   "rel"=>"tooltip",
										   "title"=>"Klik untuk melihat details Rencana",
									 ))',
						'htmlOptions'=>array('style'=>'text-align:center;'),
					),
					/*array(
						'header'=>'Batal',
						'type'=>'raw',
						'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->rencanakebfarmasi_id)",array("id"=>"$data->rencanakebfarmasi_id","rel"=>"tooltip","title"=>"Batalkan Rencana Kebutuhan"));',
						'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
					),
					 * 
					 */
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
	</div>
	<?php echo $this->renderPartial('search',array('model'=>$model,'format'=>$format)); ?>
</div>
<?php 
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id'=>'dialogRencana',
						// additional javascript options for the dialog plugin
						'options'=>array(
						'title'=>'Details Rencana',
						'autoOpen'=>false,
						'minWidth'=>900,
						'minHeight'=>100,
						'resizable'=>false,
						 ),
					));
?>
<iframe src="" name="rencana" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

?>
<script type="text/javascript">
	 function deleteRecord(id){
		var id = id;
		var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id)."/delete"; ?>';
		myConfirm('Yakin Akan Membatalkan Rencana Kebutuhan ini?','Perhatian!',
		function(r){
			if(r){
				$.post(url, {id: id},
					 function(data){
						if(data.status == 'proses_form'){
								$.fn.yiiGridView.update('rencana-m-grid');
							}else{
								myAlert('Rencana Kebutuhan Gagal di Dibatalkan')
							}
				},"json");
			}
		}); 

	}

</script>

<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
		'id' => 'dialogMengetahui',
		'options' => array(
			'title' => 'Approvement Pegawai Mengetahui',
			'autoOpen' => false,
			'modal' => true,
			'width' => 800,
			'height' => 500,
			'resizable' => false,
			'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
					data: $(this).serialize()
				}); }",
		),
));
?>
<iframe name='frameMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
		'id' => 'dialogMenyetujui',
		'options' => array(
			'title' => 'Approvement Rencana',
			'autoOpen' => false,
			'modal' => true,
			'width' => 800,
			'height' => 500,
			'resizable' => false,
			'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
					data: $(this).serialize()
				}); }",
		),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>