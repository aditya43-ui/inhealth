<table class="table table-bordered table-striped table-condensed">
    <thead>
        <th colspan="4" width="50%"></th>
        <th>Total Harga /Tarif <br>(Rp.)</th>
        <th>Total Tarif Cyto <br>(Rp.)</th>
        <th>Total Keringanan <br>(%)</th>
        <th>Total Tanggungan Asuransi <br>(%)</th>
        <th>Total Tanggungan Rumah Sakit <br>(%)</th>
        <th>Total Tanggungan Pemerintah    <br>(%)</th>
        <th>Total Tanggungan Pasien <br>(Rp.)</th> <!-- Tanggungan Pasien = Iur Biaya -->
        <th>Total <br>(Rp.)</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <td colspan="4" style="text-align: right; font-weight: bold;"><?php echo CHtml::checkBox('is_proporsisemua',false,array('onchange'=>'setProporsiSemua();','rel'=>'tooltip','title'=>'Centang untuk masukan proporsi dari total semua','onkeyup'=>"return $(this).focusNextInputField(event);")) ?> Total Tagihan</td>
        <td><?php echo CHtml::textField('tot_tarif_semua',0,array('readonly'=>true,'class'=>'inputFormTabel span2 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_tarifcyto_semua',0,array('readonly'=>true,'class'=>'inputFormTabel span2 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_discount_semua',0,array('onblur'=>'proporsiDiskonSemua();','readonly'=>true,'class'=>'inputFormTabel span2 float2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidiasuransi_semua',0,array('onblur'=>'proporsiSubsidiAsuransiSemua();','readonly'=>true,'class'=>'inputFormTabel span2 float2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidirumahsakit_semua',0,array('onblur'=>'proporsiSubsidiRsSemua();','readonly'=>true,'class'=>'inputFormTabel span2 float2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidipemerintah_semua',0,array('onblur'=>'proporsiSubsidiPemerintahSemua();','readonly'=>true,'class'=>'inputFormTabel span2 float2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_iurbiaya_semua',0,array('readonly'=>true,'class'=>'inputFormTabel span2 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('total_semua',0,array('readonly'=>true,'class'=>'inputFormTabel span2 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
    </tfoot>
</table>