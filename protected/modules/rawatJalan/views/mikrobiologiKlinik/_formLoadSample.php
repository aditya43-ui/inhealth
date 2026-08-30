<tr id="pemeriksaanSpesimen_<?php echo $modPemeriksaan->pemeriksaanlab_id; ?>_<?php echo $modPemeriksaan->samplelab_id; ?>">
    <td>
        <?php echo CHtml::textField("pemeriksaan[jenispermintaan][]", '',array('class'=>'inputFormTabel jenispermintaan_row','readonly'=>true)); ?>
    </td>
    <td>
        <?php // echo CHtml::hiddenField("pemeriksaan[is_paket][]", $modPemeriksaan->is_paket,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("pemeriksaan[subjenis_pemeriksaanlab_id][]", $modPemeriksaan->subjenis_pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("pemeriksaan[kode_unik][]", $modPemeriksaan->kode_unik,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php // echo $modPemeriksaan->subjenis_pemeriksaanlab_nama; ?>
    </td>
    <td>
        <?php echo $jenisPemeriksaan->jenispemeriksaanlab_nama; ?>
        <?php echo CHtml::hiddenField("pemeriksaan[jenispemeriksaanlab_id][]", $jenisPemeriksaan->jenispemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("pemeriksaan[pemeriksaanlab_id][]", $modPemeriksaan->pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("pemeriksaan[samplelab_id][]", $samplelab_id,array('class'=>'inputFormTabel samplelab-hide','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("pemeriksaan[caraambilsample_id][]", $caraAmbilSample->caraambilsampel_id ?? '' ,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td><?php echo $modPemeriksaan->pemeriksaanlab_nama; ?></td>
    <td class="samplelab-td">
        <?php echo $samplelab_nama; ?>
    </td>
    <td>
        <?php echo $caraAmbilSample->caraambilsampel_nama ?? ''; ?>
    </td>
    <td>
        <?php echo CHtml::checkBox("pemeriksaan[is_cito][]", false, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);', 'class' => 'cek-cito')) ?>
        <?php echo CHtml::hiddenField("pemeriksaan[cito_true][]", "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::textField("pemeriksaan[catatan][]", $catatan,array('class'=>'span2')); ?>
    </td>
    <!-- <td>
        <?php //echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            //'onclick'=>"$(this).parents('tr').remove();"
        //)); ?>
    </td> -->
</tr>   