<div class="row">
	<div class="col-sm-6">
		&nbsp;
	</div>
	<div class="clear"></div>
	<div class="col-sm-6"> 		
		<?php echo $form->textFieldRow($model,'no_permohonanpertukaran',array('readonly'=>true,'class'=>'span3')); ?>
		
		<div class="control-group">
			<?php echo $form->labelEx($model,'tglpermohonanpertukaran',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php   
					$model->tglpermohonanpertukaran = (!empty($model->tglpermohonanpertukaran) ? date("d/m/Y",strtotime($model->tglpermohonanpertukaran)) : null);
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tglpermohonanpertukaran',
											'mode'=>'date',
											'options'=> array(
												'showOn' => false,
												'maxDate' => 'd',
												'yearRange'=> "-150:+0",
											),
											'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:130px;'
											),
				)); ?>
				<?php echo $form->error($model, 'tglpermohonanpertukaran'); ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		&nbsp;
	</div>	
	<div class="col-sm-6">
		&nbsp;
	</div>
	<div class="col-sm-6">
		
		
		<div class="control-group">
			<?php echo $form->labelEx($model, 'ygmengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'ygmengetahui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'ygmengetahui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
										   dataType: "json",
										   data: {
											   nama_pegawai: request.term,
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
							$("#'.Chtml::activeId($model, 'ygmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimengetahui span3  required',						
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'ygmengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
	</div>
</div>