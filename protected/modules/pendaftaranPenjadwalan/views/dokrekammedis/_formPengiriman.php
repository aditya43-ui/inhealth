<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($modPengiriman, 'tglpengirimanrm', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$modPengiriman->tglpengirimanrm = isset($modPengiriman->tglpengirimanrm) ? date('d/m/Y',strtotime($modPengiriman->tglpengirimanrm)) : date('dd/mm/Y');
				$this->widget('MyDateTimePicker', array(
					'model' => $modPengiriman,
					'attribute' => 'tglpengirimanrm',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions' => array('placeholder'=>'00:00:0000','style'=>'width:120px;','class' => 'form-control datemask', 'onkeypress' => "return $(this).focusNextInputField(event)",'readonly'=>true),
				));
				?>
				<?php echo $form->error($modPengiriman, 'tglpengirimanrm'); ?>
			</div>
		</div>		
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPengiriman, 'petugaspengirim', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model' => $modPengiriman,
					'attribute' => 'petugaspengirim',
					'value' => '',
					'sourceUrl' => $this->createUrl('GetPetugasPengirim'),
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 2,
						'focus' => 'js:function( event, ui ) {
								$(this).val(ui.item.petugaspengirim);
								return false;
							}',
						'select' => 'js:function( event, ui ) {
								$("#'.CHtml::activeId($modPengiriman, 'petugaspengirim') . '").val(ui.item.nama_pegawai);
								return false; }',
					),
					'htmlOptions'=>array(
						'onkeypress'=>'return $(this).focusNextInputField(event)',
						'disabled'=>($modPengiriman->isNewRecord)?'':'disabled', 
						'class'=>'span2 form-control', 
					),
					'tombolDialog'=>array('idDialog'=>'dialogPetugasPengirim'),

				));
				?>
			</div>
		</div>
	</div>
</div>