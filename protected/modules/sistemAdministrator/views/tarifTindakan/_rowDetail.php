<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]tariftindakan_id',array('class'=>'tariftindakan_id')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]jenistarif_id',array('class'=>'jenistarif_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]daftartindakan_id',array('class'=>'daftartindakan_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]komponentarif_id',array('class'=>'komponentarif_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]kelaspelayanan_id',array('class'=>'kelaspelayanan_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]perdatarif_id',array('class'=>'perdatarif_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]persendiskon_tind',array('class'=>'persendiskon_tind integer-decimal')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]persencyto_tind',array('class'=>'persencyto_tind integer-decimal')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]jeniswaktukerja',array('class'=>'jeniswaktukerja')); ?>
    </td>
    <td>
        <span name="[ii][perdanama_sk]" id="perdanama_sk"><?php echo isset($model->perdatarif->perdanama_sk) ? $model->perdatarif->perdanama_sk : "" ?></span>
    </td>
    <td>
        <span name="[ii][jenistarif_nama]" id="jenistarif_nama"><?php echo isset($model->jenistarif->jenistarif_nama) ? $model->jenistarif->jenistarif_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][kelaspelayanan_nama]" id="kelaspelayanan_nama"><?php echo isset($model->kelaspelayanan->kelaspelayanan_nama) ? $model->kelaspelayanan->kelaspelayanan_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][daftartindakan_nama]" id="daftartindakan_nama"><?php echo isset($model->daftartindakan->daftartindakan_nama) ? $model->daftartindakan->daftartindakan_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][komponentarif_nama]" id="komponentarif_nama"><?php echo isset($model->komponentarif->komponentarif_nama) ? $model->komponentarif->komponentarif_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][jeniswaktukerja]" id="jeniswaktukerja"><?php echo isset($model->jeniswaktukerja) ? $model->jeniswaktukerja : "" ?></span>
    </td>
    <td style = "text-align: right;">
		<?php
				echo CHtml::activeTextField($model,'[ii]harga_tariftindakan',array('class'=>'harga_tariftindakan span2 integer-decimal', 'style'=>'text-align:right;', 'onblur'=>'hitungTotal()'));
		?>
    </td>
    <td style = "text-align: right;">
      <?php echo CHtml::activeTextField($model,'[ii]hargadiskon_tind',array('class'=>'hargadiskon_tind span2 integer-decimal', 'style'=>'text-align:right;', 'readonly'=>true)); ?>
    </td>
    <td style = "text-align: right;">
      <?php echo CHtml::activeTextField($model,'[ii]total_tarifakhir',array('class'=>'total_tarifakhir integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true)); ?>
    </td>
    <td style = "text-align: right;">
      <?php echo CHtml::activeTextField($model,'[ii]hargacyto_tind',array('class'=>'hargacyto_tind integer-decimal span2', 'style'=>'text-align:right;', 'readonly'=>true)); ?>
    </td>
    <td style = "text-align: right;">
      <?php echo CHtml::activeTextField($model,'[ii]totaltarifakhir_cyto',array('class'=>'totaltarifakhir_cyto integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true)); ?>
    </td>
    <td>
        <a onclick="hapus(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus tarif tindakan" data-placement="left"><i class="icon-form-silang"></i></a>
    </td>
</tr>
