<div class="col-sm-6">
	<?php echo $form->hiddenField($model, 'pengirimanlinen_id',array('readonly'=>true)); ?>
	<?php echo $form->textFieldRow($model,'nopenlinenruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'tglpenlinenruangan', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php
			$model->tglpenlinenruangan = !empty($model->tglpenlinenruangan) ? $format->formatDateTimeForUser($model->tglpenlinenruangan) : date('d M Y');
			$this->widget('MyDateTimePicker', array(
				'model' => $model,
				'attribute' => 'tglpenlinenruangan',
				'mode' => 'date',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
//						'maxDate' => 'd',
				),
				'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
			));
			$model->tglpenlinenruangan = !empty($model->tglpenlinenruangan) ? $format->formatDateTimeForDb($model->tglpenlinenruangan) : date('Y-m-d');
			?>
			<?php echo $form->error($model, 'tglpenlinenruangan'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('Ruangan Asal', 'ruanganasal_nama', array('class' => 'control-label')) ?>
		<div class="controls">
		<?php echo $form->hiddenField($model,'ruanganasal_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		<?php echo $form->textField($model, 'ruanganasal_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		</div>
	</div>
	<?php echo $form->textAreaRow($model,'keterangan_penlinenruangan',array('rows'=>6, 'cols'=>100, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	
</div>
<div class="col-sm-6">
	<div class="control-group">
		<?php echo $form->labelEx($model, 'pegpenerima_id', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->hiddenField($model, 'pegpenerima_id',array('readonly'=>true)); ?>
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'model'=>$model,
				'attribute' => 'pegawaimenerima_nama',
				'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompletePegawaiMenerima') . '",
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
						$("#'.Chtml::activeId($model, 'pegpenerima_id') . '").val(ui.item.pegawai_id); 
						return false;
					}',
				),
				'htmlOptions' => array(
					'class'=>'pegawaimenerima_nama',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegpenerima_id') . '").val(""); '
				),
				'tombolDialog' => array('idDialog' => 'dialogPegawaiMenerima'),
			));
			?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->hiddenField($model, 'pegmengetahui_id',array('readonly'=>true)); ?>
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'model'=>$model,
				'attribute' => 'pegawaimengetahui_nama',
				'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
						$("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
						return false;
					}',
				),
				'htmlOptions' => array(
					'class'=>'pegawaimengetahui_nama',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
				),
				'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
			));
			?>
		</div>
	</div>
	
</div>

<div class="clear"></div>
<?php 
//========= Dialog buat cari data Pegawai Menerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenerima',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menerima',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMenerima = new LAPegawaiV('searchPegawaiMenerima');
$modPegawaiMenerima->unsetAttributes();
if(isset($_GET['LAPegawaiV'])) {
    $modPegawaiMenerima->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengajukan-grid',
	'dataProvider'=>$modPegawaiMenerima->searchPegawaiMenerima(),
	'filter'=>$modPegawaiMenerima,
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
                                                  $(\"#'.CHtml::activeId($model,'pegpenerima_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimenerima_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenerima\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menerima dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new LAPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['LAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
	'filter'=>$modPegawaiMengetahui,
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
                                                  $(\"#'.CHtml::activeId($model,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>