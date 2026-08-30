<tr>
    <td>
        <?php 
        $daftar = ObatalkesM::model()->findByPk($oa->obatalkes_id);

        echo CHtml::activeHiddenField($oa, '['.$oa->obatalkes_id.']obatalkes_id');

        echo $daftar->obatalkes_nama;
        ?>
    </td>
    <td><?php echo CHtml::activeTextField($oa, '['.$oa->obatalkes_id.']qty', array(
        'class'=>'integer2 span1 qty', 'onblur'=>'hitungTotalObat();',
    )); ?><br/>
    <?php echo empty($daftar->satuankecil) ? "" : $daftar->satuankecil->satuankecil_nama; ?></td>
    <td><?php echo CHtml::activeTextField($oa, '['.$oa->obatalkes_id.']tarifsatuan', array(
        'class'=>'integer-decimal span2 tarifsatuan', 'onblur'=>'hitungTotalObat();', 'style'=>'text-align: right',
    )); ?></td>
    <td><?php echo CHtml::activeTextField($oa, '['.$oa->obatalkes_id.']totaltarif', array(
        'class'=>'integer-decimal span2 totaltarif', 'readonly'=>true, 'style'=>'text-align: right',
    )); ?>
    <td>
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'hapusOa(this); return false;'
        )); ?>
    </td>
</tr>

