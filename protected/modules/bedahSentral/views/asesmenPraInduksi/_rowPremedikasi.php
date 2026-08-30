<tr>
    <td class="nomor"></td>
    <td>
        <?php echo $form->hiddenField($modForm, '[detail][ii]premedikasiprainduksi_id', array('class'=>'premedikasiprainduksi_id')); ?>
        <?php echo $form->hiddenField($modForm, '[detail][ii]obatalkes_id', array('class'=>'obatalkes_id')); ?>
        <?php echo $form->hiddenField($modForm, '[detail][ii]premedikasi_jumlah', array('class'=>'premedikasi_jumlah')); ?>
        <?php echo $form->hiddenField($modForm, '[detail][ii]premedikasi_jam', array('class'=>'premedikasi_jam')); ?>

        <span class="label_nama_obat"><?php echo empty($modForm->obatalkes) ? "" : $modForm->obatalkes->obatalkes_nama; ?></span>
    </td>
    <td class="label_jumlah"><?php echo $modForm->premedikasi_jumlah; ?></td>
    <td class="label_waktu"><?php echo $modForm->premedikasi_jam; ?></td>
    <td class="label_hasil"><?php echo $form->textArea($modForm, '[detail][ii]premedikasi_hasil', array('class'=>'premedikasi_hasil span3', 'cols'=>2)); ?></td>
    <td><?php echo CHtml::htmlButton('<i class="entypo-minus"></i>', array(
        'class' => 'btn btn-default',
        'onclick'=>'hapusRowPraMedikasi(this)',
    )); ?></td>
</tr>
