<tr data-row="0">
    <td>
        <?php 
            echo $model->obatalkes_nama;
        ?>
        <?php echo CHtml::activeHiddenField($model,'[1]obatalkes_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo CHtml::activeHiddenField($model,'[1]jenisformularium',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo CHtml::activeHiddenField($model,'[1]carabayar_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo CHtml::activeHiddenField($model,'[1]penjamin_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo CHtml::activeHiddenField($model,'[1]is_aktif',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    </td>
    <td>
        <?php echo $model->jenisformularium; ?>
    </td>
    <td>
        <?php echo $model->carabayar_nama; ?>
    </td>
    <td>
        <?php echo $model->penjamin_nama; ?>
    </td>
    <td>
        <?php echo ($model->is_aktif == 'true') ? 'Aktif' : 'Tidak Aktif';?>
    </td>
    <td>
        <?php 
            echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusBaris(this);'));
        ?>
    </td>
</tr>