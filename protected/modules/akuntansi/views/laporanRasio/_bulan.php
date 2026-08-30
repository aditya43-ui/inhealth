<?php
	echo CHtml::activeCheckBoxList($model, 'bulan', array($i=>MyFormatter::getMonthId($i)."-".$tahun), array('value' => 'bulan', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'&nbsp;&nbsp;';
?>