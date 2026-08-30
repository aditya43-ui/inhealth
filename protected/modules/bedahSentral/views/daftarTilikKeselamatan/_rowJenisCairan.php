<?php

if (empty($row)) {
    $row = new CairanpasienanestesiT();
}

?>

<tr>
    <td>
        <?php echo CHtml::activeTextField($row, '['.$i.']cairan_jenis', array('class'=>'span3 cairan_jenis')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($row, '['.$i.']cairan_volume', array('class'=>'span2 cairan_volume numbers-only', 'style'=>'text-align: right;')); ?>
    </td>
    <td>
        <?php echo CHtml::htmlButton('<i class="entypo-minus"></i>', array(
            'class' => 'btn btn-default', 'onclick'=>'hapusJenisCairan(this);'
        )); ?>
    </td>
</tr>