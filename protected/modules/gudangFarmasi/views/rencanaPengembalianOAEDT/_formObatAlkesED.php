<div class="row">
	<div class="span3">
		<div class="control-group">
			<?php echo CHtml::label('Obat ED <span class="required">*</span>', '', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::hiddenField('storeeddetail_id','',array('readonly'=>true)) ?>
				<?php echo CHtml::hiddenField('satuankecil_id','',array('readonly'=>true)) ?>
				<?php echo CHtml::hiddenField('tglkadaluarsa_renpeng','',array('readonly'=>true)) ?>
				<?php echo CHtml::hiddenField('obatalkes_id','',array('readonly'=>true)) ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'name'=>'obatalkes_nama',
					'attribute' => 'obatalkes_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#obatalkes_id").val(ui.item.obatalkes_id); 
							$("#storeeddetail_id").val(ui.item.storeeddetail_id); 
							$("#satuankecil_id").val(ui.item.satuankecil_id); 
							$("#tglkadaluarsa_renpeng").val(ui.item.tglkadaluarsa); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'obatalkes_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogObatED'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Jumlah <span class="required">*</span>', '', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('jumlah','',array('class'=>'span1 integer')); ?>
			</div>
		</div>
		<div style="margin-left:200px; margin-top: -38px;">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),
					array('onclick'=>'tambahObatED();return false;',
						  'onkeypress'=>'tambahObatED();return false;',
						  'class' => 'btn btn-danger',
						  'rel'=>"tooltip",
						  'title'=>"Klik untuk tambah",)); ?>
		</div> 
	</div>
	
<?php 
//========= Dialog buat cari data Obat Alkes ED =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatED',
    'options'=>array(
        'title'=>'Pencarian Obat Alkes ED',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modStoreeddetail = new GFStoreeddetailT('search');
$modStoreeddetail->unsetAttributes();
if(isset($_GET['GFStoreeddetailT'])) {
    $modStoreeddetail->attributes = $_GET['GFStoreeddetailT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sumberanggaran-grid',
	'dataProvider'=>$modStoreeddetail->searchDialog(),
	'filter'=>$modStoreeddetail,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
										  $(\"#obatalkes_nama\").val(\"$data->obatalkes_nama\");
										  $(\"#storeeddetail_id\").val(\"$data->storeeddetail_id\");
										  $(\"#satuankecil_id\").val(\"$data->satuankecil_id\");
										  $(\"#tglkadaluarsa_renpeng\").val(\"$data->tglkadaluarsa\");
										  $(\"#dialogObatED\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'name'=>'obatalkes_id',
			'type'=>'raw',
			'value'=>'$data->obatalkes->obatalkes_nama',
		),
		array(
			'name'=>'storeed_id',
			'type'=>'raw',
			'value'=>'$data->storeed->nostoreed',
		),
		array(
			'name'=>'tglkadaluarsa',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
		),
		array(
			'name'=>'qtystoked',
			'type'=>'raw',
			'value'=>'$data->qtystoked',
		),
		array(
			'name'=>'satuankecil_id',
			'type'=>'raw',
			'value'=>'$data->satuankecil->satuankecil_nama',
		),     
		array(
			'name'=>'qtystoked',
			'type'=>'raw',
			'value'=>'$data->qtystoked',
		),    
		array(
			'name'=>'keterangan_obated',
			'type'=>'raw',
			'value'=>'$data->keterangan_obated',
		),       
	),
		'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
$this->endWidget();
//========= end Obat Alkes ED dialog =============================
?>