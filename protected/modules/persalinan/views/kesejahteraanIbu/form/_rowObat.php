<tr>
    <td><?php echo $model->obatalkes->obatalkes_nama; ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[detail]['.$model->obatalkes_id.']obatalkes_id', array('class'=>'tab_obatalkes_id')); ?>
        <?php echo CHtml::activeTextField($model, '[detail]['.$model->obatalkes_id.']qty_obat', array('class'=>'integer span1', 'style'=>'text-align: right;')); ?>
    </td>
    <td>
        <?php echo CHtml::htmlButton('-', array('class'=>'btn btn-danger', 'onclick'=>"$(this).parents('tr').remove();")); ?>
    </td>
</tr>