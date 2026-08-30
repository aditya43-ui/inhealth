<tr>
    <td class="nomor"></td>
    <td>
        <?php echo $form->hiddenField($modForm, '[detail][ii]bedahanastesilokal_medikasiintraop_id', array('class'=>'bedahanastesilokal_medikasiintraop_id')); ?>
        <?php echo $form->hiddenField($modForm, '[detail][ii]obatalkes_id', array('class'=>'obatalkes_id')); ?>
        <?php echo $form->hiddenField($modForm, '[detail][ii]obatalkes_dosis', array('class'=>'pemakaian_jumlah')); ?>

        <span class="label_nama_obat"><?php echo empty($modForm->obatalkes) ? "" : $modForm->obatalkes->obatalkes_nama; ?></span>
    </td>
    <td class="label_jumlah"><?php echo $modForm->obatalkes_dosis; ?></td>
    <td><?php echo CHtml::htmlButton('<i class="entypo-minus"></i>', array(
        'class' => 'btn btn-default',
        'onclick'=>'hapusRowPemakaianObat(this)',
    )); ?></td>
</tr>
