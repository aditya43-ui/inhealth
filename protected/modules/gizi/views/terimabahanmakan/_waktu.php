<?php   
	$modDetail->tglkadaluarsabahan = (!empty($modDetail->tglkadaluarsabahan) ? MyFormatter::formatDateTimeForUser($modDetail->tglkadaluarsabahan) : null);

	$this->widget('MyDateTimePicker',array(		                                        
		'name'=>"TerimabahandetailT[0][tglkadaluarsabahan]",
		'mode'=>'date',
							'value'=>$modDetail->tglkadaluarsabahan,                                        
		'options'=> array(
			'showOn' => false,
			'yearRange'=> "-150:+0",
			'dateFormat' => Params::DATE_FORMAT,
			'format' => 'Y-m-d',
			'onSelect' => 'js:function() {$(this).val(this.value);}',//$("#'.CHtml::activeId($detail,'[ii]pemeliharaanasetdet_tgl').'").val(selectedDate);
		),
		'htmlOptions'=>array('readonly'=>TRUE,'class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event),"
		),
));

?>
                        