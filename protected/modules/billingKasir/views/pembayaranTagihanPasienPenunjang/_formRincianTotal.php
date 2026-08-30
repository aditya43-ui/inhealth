<?php
if (!isset($totInacbg)) {
    $totInacbg = 0;
    $readOnly = false;
}
?>
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <th colspan="4" width="50%"></th>
        <th>Total Harga /Tarif <br>(Rp)</th>
        <!--<th>Total Tarif Cyto <br>(Rp)</th>-->
        <th>Total Keringanan <br>(Rp)</th>
        <th>Total INACBG / Tanggungan Asuransi <br>(Rp)</th>
        <th>Total Tanggungan Rumah Sakit <br>(Rp)</th>
        <th>Total Tanggungan Pasien <br>(Rp)</th>
        <!--Tanggungan Pasien = Iur Biaya-->
        <th>Total yang Harus Dibayar <br>(Rp)</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <td colspan="4" style="text-align: right; font-weight: bold;"><?php echo CHtml::checkBox('is_proporsisemua', false, array('onchange' => 'setProporsiSemua();', 'rel' => 'tooltip', 'title' => 'Centang untuk masukan proporsi dari total semua', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?> Total Tagihan</td>
        <td><?php echo CHtml::textField('tot_tarif_semua', 0, array('readonly' => true, 'style' => 'width:100px;', 'class' => 'inputFormTabel lebar3 span2 integer-decimal float2', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?></td>
        <!--<td><?php // echo CHtml::textField('tot_tarifcyto_semua',0,array('readonly'=>true,'style'=>'width:100px;', 'class'=>'inputFormTabel lebar3 span2 integer','onkeyup'=>"return $(this).focusNextInputField(event);")) 
                ?></td>-->
        <td><?php echo CHtml::textField('tot_discount_semua', 0, array('onblur' => 'proporsiDiskonSemua();', 'readonly' => true, 'style' => 'width:100px;', 'class' => 'inputFormTabel lebar3 span2 integer-decimal float2', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?></td>
        <td>
            <?php // echo CHtml::textField('tot_inacbg',$totInacbg,array('readonly'=>true,'onblur'=>'proporsiSubsidiAsuransiSemua();','readonly'=>$readOnly,'class'=>'inputFormTabel lebar3 integer','title'=>'Total INACBG', 'onkeyup'=>"return $(this).focusNextInputField(event);")) 
            ?>
            <!--RND-12325-->
            <?php echo CHtml::textField('tot_inacbg', $totInacbg, array('readonly' => true, 'style' => 'width:100px;', 'onblur' => 'proporsiInacbgSemua();', 'class' => 'inputFormTabel lebar3 span2 integer-decimal total_inacbg', 'data-index' => 0, 'title' => 'Total INACBG', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?>
            <?php echo CHtml::textField('tot_subsidiasuransi_semua', 0, array('onblur' => 'proporsiSubsidiAsuransiSemua();', 'readonly' => true, 'style' => 'width:100px;', 'class' => 'inputFormTabel lebar3 span2 integer-decimal float2', 'title' => 'Total Tanggungan Asuransi', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?>
        </td>
        <td><?php echo CHtml::textField('tot_subsidirumahsakit_semua', 0, array('onblur' => 'proporsiSubsidiRsSemua();', 'readonly' => true, 'style' => 'width:100px;', 'class' => 'inputFormTabel lebar3 span2 float2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_iurbiaya_semua', 0, array('onblur' => 'proporsiTanggunganRsSemua();', 'readonly' => true, 'style' => 'width:100px;', 'class' => 'inputFormTabel lebar3 span2 float2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?></td>
        <td hidden><?php echo CHtml::textField('tot_jmlselisihbpjs_semua', 0, array('readonly' => true, 'style' => 'width:100px;', 'class' => 'inputFormTabel lebar3 span2 float2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('total_semua', 0, array('readonly' => true, 'style' => 'width:100px;', 'class' => 'inputFormTabel lebar3 span2 integer-decimal float2', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?></td>
    </tfoot>
</table>