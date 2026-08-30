<?php
	$namaModel = 'InvtanahT';
	$noUrut = 1;
	if(count((array)$modRincian) > 0){
		foreach($modRincian as $key=>$value)
	    {
			echo"<tr>";
				echo "<td>".
    				CHtml::checkBox($namaModel."[detail][$key][is_checked]", "checked",array('class'=>'span1', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onclick'=>'checkRekening(this)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][invtanah_id]", $value['invtanah_id'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][hargajualaktiva]", $value['hargajualaktiva'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[detail][$key][invtanah_harga]", $value['invtanah_harga'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    			"</td>";

				echo "<td>".$value['invtanah_kode'];
				echo "</td>";

				echo "<td>".$value['invtanah_noregister'];
				echo "</td>";

				echo "<td>".$value['invtanah_namabrg'];
				echo "</td>";

				echo "<td>".$value['invtanah_alamat'];
				echo "</td>";

				echo "<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($value['invtanah_harga']);
				echo "</td>";

				echo "<td style='text-align: right;'>".CHtml::textField($namaModel."[detail][$key][hargajualaktiva]", $value['hargajualaktiva'], array('class'=>'integer2 span2', 'onkeypress'=>'return $(this).focusNextInputField(event)'));//MyFormatter::formatNumberForPrint($value['hargajualaktiva']);
				echo "</td>";
			echo"</tr>";
		}
	}

?>