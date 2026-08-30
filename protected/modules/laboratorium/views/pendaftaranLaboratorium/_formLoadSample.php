<tr id="pemeriksaanSpesimen_<?php echo $modPemeriksaan->pemeriksaanlab_id; ?>_<?php echo $modPemeriksaan->samplelab_id; ?>" class="tr-pemeriksaan">
    <td>
        <?php echo CHtml::textField("pemeriksaan[nourut]", '',array('class'=>'inputFormTabel no-urut span1','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField("pemeriksaan[no_lab]", '-- Terisi Otomatis --',array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField("pemeriksaan[jenispermintaan]", '',array('class'=>'inputFormTabel jenispermintaan_row','readonly'=>true)); ?>
    </td>
    <td><?php echo $modPemeriksaan->pemeriksaanlab_nama; ?></td>
    <td class="samplelab-td">
        <?php echo $samplelab_nama; ?>
    </td>

    <td>
        <?php echo $caraAmbilSample->caraambilsampel_nama ?? ''; ?>
        <?php echo CHtml::hiddenField("pemeriksaan[jenispemeriksaanlab_id]", $jenisPemeriksaan->jenispemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("pemeriksaan[pemeriksaanlab_id]", $modPemeriksaan->pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("pemeriksaan[samplelab_id]", $samplelab_id,array('class'=>'inputFormTabel samplelab-hide','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("pemeriksaan[caraambilsample_id]", $caraAmbilSample->caraambilsampel_id ?? '' ,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php // echo CHtml::hiddenField("pemeriksaan[is_paket]", $modPemeriksaan->is_paket,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php //echo CHtml::hiddenField("pemeriksaan[subjenis_pemeriksaanlab_id]", $modPemeriksaan->subjenis_pemeriksaanlab_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php echo CHtml::textField("pemeriksaan[kode_unik]", $modPemeriksaan->kode_unik,array('class'=>'inputFormTabel','readonly'=>true)); ?>
        <?php // echo $modPemeriksaan->subjenis_pemeriksaanlab_nama; ?>
    </td>
    <td>
        <?php echo CHtml::textField("pemeriksaan[qty_tindakan]", 1, array('class'=>'inputFormTabel span1 integer2','readonly'=>true)); ?>     
    </td>
    <td>
        <?php echo CHtml::textField("pemeriksaan[harga_tariftindakan]", $modPemeriksaan->harga_tariftindakan, array('class'=>'inputFormTabel span2 integer2','readonly'=>true)); ?>

    </td>
    <td>
        <?php echo CHtml::textField("pemeriksaan[harga_tariftindakan]", $modPemeriksaan->harga_tariftindakan, array('class'=>'inputFormTabel span2 integer2','readonly'=>true)); ?>
    </td>
</tr>   