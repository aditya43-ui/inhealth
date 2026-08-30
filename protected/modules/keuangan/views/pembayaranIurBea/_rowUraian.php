<?php 
    $removeButton = '';
    foreach ($modUraian as $i => $uraian) { ?>
<tr class="<?php echo ($removeButton == true ? "child" : "") ?>">
    <td>
        <?php echo CHtml::activeHiddenField($uraian,"[$i]iurbea_id",array('readonly'=>true, 'class'=>'span5 iurbea_id', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <?php echo CHtml::activeTextField($uraian,"[$i]uraiantransaksi",array('readonly'=>true, 'class'=>'span5 uraiantransaksi', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($uraian,"[$i]volume",array('onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel integer_x span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeDropDownList($uraian,"[$i]satuanvol", LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($uraian,"[$i]hargasatuan",array('readonly'=>true,'onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($uraian,"[$i]totalharga",array('readonly'=>true,'class'=>'inputFormTabel span2 integer2 totalharga', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
</tr>
<?php } ?>