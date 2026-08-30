
	<td>
		<?php echo $form->textField($model,'[1]kecamatan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kecamatan_nama'))); ?>
		 <span class="required">*</span>
	</td>
	<td>
		<?php echo $form->textField($model,'[1]kecamatan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kecamatan_namalainnya'))); ?>
	</td>
	<td>
		<?php echo $form->textField($model, '[1]longitude',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>$model->getAttributeLabel('longitude')));?>
		<?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
			array(
				'class'=>'btn btn-primary btn-location',
				'rel'=>'tooltip',
				'id'=>'yw1',
				'title'=>'Klik untuk mencari Longitude & Latitude',)); ?>
	</td>
	<td>
		<?php echo $form->textField($model,'[1]latitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=>$model->getAttributeLabel('latitude'))); ?>
	</td>
	<td>
		<?php echo CHtml::button( '+', array('class' => 'btn btn-danger','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).focusNextInputField(event)','id'=>'row1-plus')); ?>
	</td>