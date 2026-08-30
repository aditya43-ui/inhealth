<?php
	if(!isset($totInacbg)){
		$totInacbg = 0;
		$readOnly = false;
	}

  $max_penjamin = 5;


?>
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <th colspan="4" width="50%"></th>
        <th>Total Harga /Tarif <br>(Rp.)</th>
        <!--<th>Total Tarif Cyto <br>(Rp.)</th>-->
        <th>Total Keringanan <br>(Rp.)</th>
        <?php for ($ci = 0; $ci < $max_penjamin; $ci++): 
        ?>
        <th class="col_th_penjamin col_subsidi_<?php echo $ci; ?>" 
            data-is_umum="0" 
            data-penjamin_id="" 
            data-col_index="<?php echo $ci; ?>"
        >Total Tanggungan<br/>
        <span class="nama_tanggungan"></span></br>
        (Rp.)
        </th>
        <?php endfor; ?>
        
        <th>Total Yang Harus Dibayar <br>(Rp.)</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <td colspan="4" style="text-align: right; font-weight: bold;">
        Total Tagihan
        </td>
        <td><?php echo CHtml::textField('tot_tarif_semua',0,array('readonly'=>true,'style'=>'width:100px;', 'class'=>'inputFormTabel lebar3 span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <!--<td><?php // echo CHtml::textField('tot_tarifcyto_semua',0,array('readonly'=>true,'style'=>'width:100px;', 'class'=>'inputFormTabel lebar3 span2 integer','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>-->
        <td><?php echo CHtml::textField('tot_discount_semua',0,array('onblur'=>'proporsiDiskonSemua();','readonly'=>true,'style'=>'width:100px;', 'class'=>'inputFormTabel lebar3 span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <?php for ($ic = 0; $ic < $max_penjamin; $ic++) {

        echo '<td class="col_subsidi_'.$ic.'">';
        echo CHtml::textField('tot_subsidiasuransi_semua['.$ic.']', 0, array('readonly'=>true,'class'=>'inputFormTabel span2 total_subsidiasuransi_semua_'.$ic.' integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;'));
        echo '</td>';
        } ?>
        <td><?php echo CHtml::textField('total_semua',0,array('readonly'=>true,'style'=>'width:100px;','class'=>'inputFormTabel lebar3 span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
    </tfoot>
</table>

<?php // tot_subsidiasuransi_semua ?>
