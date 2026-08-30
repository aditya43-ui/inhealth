<tr>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[ii]lookup_id', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, '[ii]lookup_type', array('readonly' => true)); ?>
        <?php echo CHtml::activeTextField($model, '[ii]lookup_name', array('class' => 'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]lookup_value', array('class' => 'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]lookup_kode', array('class' => 'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '[ii]lookup_urutan', array('class' => 'span3 integer')); ?>
    </td>
    <td style="width: 60px; text-align: center">
        <?php if (isset($_POST['is_update'])) : ?>
            <?php echo CHtml::activeCheckBox($model, '[ii]lookup_aktif', array()); ?>
        <?php endif; ?>
    </td>
    <td style="width: 120px; text-align: center;" class="rowbutton">
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'hapusLookup(this)')); ?>
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahLookup()')); ?>
    </td>
</tr>