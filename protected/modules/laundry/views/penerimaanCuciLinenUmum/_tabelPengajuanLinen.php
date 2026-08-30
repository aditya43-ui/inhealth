<tr>
    <td>
        <?php echo CHtml::activeTextField($modDetail,"[1]namalinen",array('class'=>'span4 required', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[1]jumlah',array('class'=>'span2 required', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modDetail,'[1]satuan', LookupM::getItems('satuanlinen'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modDetail,'[1]keterangan', array('readonly' => false, 'disable' => false, 'rows' => 6, 'cols' => 100, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'addRow(this)','id'=>'row1-plus', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
</tr>
	