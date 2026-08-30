<?php
	$namaModel = 'InvgedungT';
	$noUrut = 1;
	if(count((array)$modRincian) > 0){
		foreach($modRincian as $key=>$value)
	    {
			echo"<tr>";
				echo "<td>".
    				CHtml::checkBox($namaModel."[detail][$key][is_checked]", "checked",array('class'=>'span1', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onclick'=>'checkRekening(this,'.$key.')')).
    				CHtml::hiddenfield($namaModel."[detail][$key][invgedung_id]", $value['invgedung_id'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][hargajualaktiva]", $value['hargajualaktiva'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][invgedung_harga]", $value['invgedung_harga'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][kerugian]", $value['kerugian'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][keuntungan]", $value['keuntungan'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][invgedung_akumsusut]", $value['invgedung_akumsusut'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    			"</td>";

				echo "<td>".$value['invgedung_kode'];
				echo "</td>";

				echo "<td>".$value['invgedung_noregister'];
				echo "</td>";

				echo "<td>".$value['invgedung_namabrg'];
				echo "</td>";

				echo "<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($value['invgedung_harga']);
				echo "</td>";

				echo "<td style='text-align: right;'>".CHtml::textField($namaModel."[detail][$key][hargajualaktiva]", $value['hargajualaktiva'], array('class'=>'integer2 span2', 'onkeypress'=>'return $(this).focusNextInputField(event)'));//.MyFormatter::formatNumberForPrint($value['hargajualaktiva']);
				echo "</td>";
			echo"</tr>";
		}
	}

?>