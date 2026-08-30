<tr>
    <td width="100px">
        <?php echo CHtml::activeTextField($modLampiran,'['.$i.']lampiransuratsehat_nama',array('class'=>'span7', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td width="20px">
        <?php echo CHtml::link('<i class="icon-plus icon-white"></i>', 'javascript:;', array('class' => 'btn btn-danger','onclick'=>'addRow(this)','id'=>'row1-plus', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::link('<i class="icon-minus icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick'=>'removeRow(this); return false;', )); ?>
    </td>
</tr>