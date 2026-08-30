<?php
	$namaModel = 'AKUraiankeluarumumT';
	$noUrut = 1;

	if(count((array)$modRinciangaji) > 0){
		$total = 0;
	    foreach($modRinciangaji as $key=>$value)
	    {
	    	echo '<tr>';
	    		echo "<td>".
	    				 CHtml::textField($namaModel."[$key][uraiantransaksi]", $value['uraian'],array('class'=>'span3', 'maxlength'=>'100', 'onkeypress'=>'return $(this).focusNextInputField(event)')).
	    				 CHtml::hiddenfield($namaModel."[$key][penggajianpeg_id]", $value['penggajianpeg_id'],array('class'=>'span3', 'maxlength'=>'100', 'onkeypress'=>'return $(this).focusNextInputField(event)')).
	    			"</td>";
	    		echo "<td>".
	    				CHtml::textField($namaModel."[$key][volume]", $value['volume'],array('class'=>'inputFormTabel lebar2', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onkeyup'=>'hitungTotalUraian(this);')).
	    			"</td>";
	    		echo "<td>".
	    				CHtml::dropdownlist($namaModel."[$key][satuanvol]", $value['satuanvol'],array(
	                        'empty'=>'-- Pilih --',
	                        $value['satuanvol']=>$value['satuanvol'],
	                    )).
	    			"</td>";
	    		echo "<td>".
	    				CHtml::textField($namaModel."[$key][hargasatuan]", $value['penerimaanbersih'],array('class'=>'inputFormTabel lebar3 currency', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onkeyup'=>'hitungTotalUraian(this);')).
	    			"</td>";
    			echo "<td>".
    				CHtml::textField($namaModel."[$key][totalharga]", $value['totalharga'],array('class'=>'inputFormTabel lebar3 currency', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'readonly'=>'readonly')).
    				"</td>";
    			echo "<td>
					<a href='#' rel='tooltip' onclick='batalUraian(this);return false;' data-original-title='Klik untuk membatalkan uraian'>
    				<i class='icon-minus'></i>
					</a>
					</td>";
	    	echo '</tr>';
	    	$total += $value['totalharga'];
	    }
	    echo "<tr>
	    	<td colspan=4>Total</td>
	    	<td>".CHtml::textField("total_uraian", $total,array('class'=>'inputFormTabel lebar3 currency', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'readonly'=>'readonly'))."</td>
	    </tr>";
	}
?>