<?php
$oa = new ObatalkespasienT;

?>

<tr>
    <td class="label_no"></td>
    <td>
        <?php echo CHtml::activeHiddenField($oa, '[detail][ii]obatalkes_id', array('class'=>'row_obatalkes_id')); ?>
        <?php echo CHtml::activeHiddenField($oa, '[detail][ii]tglpelayanan', array('class'=>'row_tglpelayanan')); ?>
        <?php echo CHtml::activeHiddenField($oa, '[detail][ii]pegawai_id', array('class'=>'row_pegawai_id')); ?>
        <span class="label_obatalkes_nama"></span>
    </td>
    <td><?php echo CHtml::activeTextField($oa, '[detail][ii]dosis_jml', array('class'=>'span3 row_dosis_jml')); ?></td>
    <td><?php echo CHtml::activeTextField($oa, '[detail][ii]carapemberian', array('class'=>'span3 row_carapemberian')); ?></td>
    <td class="label_tglpelayanan"></td>
    <td class="label_nama_pegawai"></td>
    <td><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
        'onclick'=>'hapusItemMedikasi(this); return false;',
    )); ?></td>
</tr>