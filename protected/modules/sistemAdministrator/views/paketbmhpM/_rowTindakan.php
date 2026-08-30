<tr>
    <td>
        <?php 
        $daftar = DaftartindakanM::model()->findByPk($tindakan->daftartindakan_id);

        echo CHtml::activeHiddenField($tindakan, '['.$tindakan->daftartindakan_id.']daftartindakan_id');

        echo $daftar->daftartindakan_nama;
        ?>
    </td>
    <td><?php echo CHtml::activeTextField($tindakan, '['.$tindakan->daftartindakan_id.']qty', array(
        'class'=>'integer2 span1 qty', 'onblur'=>'hitungTotalTindakan();',
    )); ?></td>
    <td><?php echo CHtml::activeTextField($tindakan, '['.$tindakan->daftartindakan_id.']tarifsatuan', array(
        'class'=>'integer-decimal span2 tarifsatuan', 'onblur'=>'hitungTotalTindakan();', 'style'=>'text-align: right',
    )); ?></td>
    <td><?php echo CHtml::activeTextField($tindakan, '['.$tindakan->daftartindakan_id.']totaltarif', array(
        'class'=>'integer-decimal span2 totaltarif', 'readonly'=>true, 'style'=>'text-align: right',
    )); ?>
    <td>
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'hapusTindakan(this); return false;'
        )); ?>
    </td>
</tr>

