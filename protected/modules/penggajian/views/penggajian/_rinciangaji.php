<?php
	$namaModel = 'GJUraiankeluarumumT';
	$noUrut = 1;

	if(count((array)$modRinciangaji) > 0){
		$total = 0;
	    foreach($modRinciangaji as $key=>$value)
	    {
	    	echo '<tr>';
                echo '<td class="nourut"></td>';
	    		echo "<td>".
	    				 CHtml::textField($namaModel."[$key][uraiantransaksi]", $value['uraian'],array('class'=>'span3','style'=>"width: 300px", 'onkeypress'=>'return $(this).focusNextInputField(event)', 'readonly'=>true)).
	    				 CHtml::hiddenfield($namaModel."[$key][penggajianpeg_id]", $value['penggajianpeg_id'],array('class'=>'span3', 'maxlength'=>'100', 'onkeypress'=>'return $(this).focusNextInputField(event)')).
	    				 CHtml::hiddenfield($namaModel."[$key][thr_thrbersih]", $value['thr_thrbersih'],array('class'=>'span3 thr_thrbersih', 'maxlength'=>'100', 'onkeypress'=>'return $(this).focusNextInputField(event)')).
	    			"</td>";
	    		echo "<td>".
	    				CHtml::textField($namaModel."[$key][volume]", $value['volume'],array('class'=>'inputFormTabel integer2 span1 volume', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onkeyup'=>'hitungTotalUraian(this); totalHarga();', 'readonly'=>true)).
	    			"</td>";
	    		echo "<td>".
	    				CHtml::dropdownlist($namaModel."[$key][satuanvol]", $value['satuanvol'],array(
	                        'empty'=>'-- Pilih --', 'class'=>'span2',
	                        $value['satuanvol']=>$value['satuanvol'],
	                    )).
	    			"</td>";
	    		echo "<td>".
	    				CHtml::textField($namaModel."[$key][hargasatuan]", MyFormatter::formatNumberForPrint($value['penerimaanbersih']),array('class'=>'inputFormTabel span2 integer2 hargasatuan', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onkeyup'=>'hitungTotalUraian(this); totalHarga();')).
	    				CHtml::hiddenField($namaModel."[$key][val_hargasatuan]", $value['penerimaanbersih'],array('class'=>'inputFormTabel span2 integer2 val_hargasatuan')).
	    			"</td>";
    			echo "<td>".
    				CHtml::textField($namaModel."[$key][totalharga]", MyFormatter::formatNumberForPrint($value['totalharga']),array('class'=>'inputFormTabel span2 integer2 totalharga', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'readonly'=>'readonly')).
                                CHtml::hiddenField($namaModel."[$key][pph21]", $value['totalpajak'],array('class'=>'inputFormTabel span2 integer2 val_pph21')).
    				"</td>";
    			echo "<td>
					<a href='#' rel='tooltip' onclick='batalUraian(this);return false;' data-original-title='Klik untuk membatalkan uraian'>
    				<i class='icon-minus'></i>
					</a>
					</td>";
	    	echo '</tr>';
	    	$total += $value['totalharga'];
	    }
	}
?>