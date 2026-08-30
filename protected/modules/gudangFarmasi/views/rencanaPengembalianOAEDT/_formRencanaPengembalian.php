<div class="row">
	<div class="col-sm-4">
		<?php echo $form->textFieldRow($model,'norenpengembalian',array('class'=>'span3','readonly'=>true)); ?>
	</div>
	<div class="col-sm-4">
		<div class='control-group'>
			<?php echo CHtml::label('Tgl. <span class="required">*</span>', 'tglrenpengembalian', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php $model->tglrenpengembalian = $format->formatDateTimeForUser($model->tglrenpengembalian); ?>
				<?php 
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tglrenpengembalian', 
						'mode'=>'date',
						'options'=>array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,
							'class' => "span2 required",
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));  
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class='control-group'>
			<?php echo CHtml::label('Supplier <span class="required">*</span>', 'supplier_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'supplier_id',CHtml::listData(SupplierM::model()->findAllByAttributes(array('supplier_aktif'=>true), array('order'=>'supplier_nama')),'supplier_id','supplier_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
			</div>
		</div>
	</div>
</div>