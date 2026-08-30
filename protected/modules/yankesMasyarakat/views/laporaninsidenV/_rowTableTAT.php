<tr>
    <td style="text-align: center">
        <?php echo isset($data->pilihan) ? $data->pilihan : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']pilihan', array('readonly' => true, 'class' => 'pilihan')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_kuning) ? $data->grade_kuning : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_kuning', array('readonly' => true, 'class' => 'grade_kuning')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_hijau) ? $data->grade_hijau : " - " ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_hijau', array('readonly' => true, 'class' => 'grade_hijau')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_biru) ? $data->grade_biru : " - " ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_biru', array('readonly' => true, 'class' => 'grade_biru')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_merah) ? $data->grade_merah : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_merah', array('readonly' => true, 'class' => 'grade_merah')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_low) ? $data->grade_low : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_low', array('readonly' => true, 'class' => 'grade_low')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_moderate) ? $data->grade_moderate : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_moderate', array('readonly' => true, 'class' => 'grade_moderate')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_high) ? $data->grade_high : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_high', array('readonly' => true, 'class' => 'grade_high')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->grade_extrem) ? $data->grade_extrem : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']grade_extrem', array('readonly' => true, 'class' => 'grade_extrem')); ?>
    </td>
</tr>

