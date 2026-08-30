<?php
    $i = !empty($i)?$i:0;
?>
<tr row-data="<?= $i ?>" class="baris">    
    <td>
        <?php
            echo CHtml::activeHiddenField($model, '['.$i.']usulanpenghapusanasetdet_id', ['class'=>'det_id pengeringanbjdet_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']invperalatan_id', ['class'=>'invperalatan_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']kondisi', ['class'=>'kondisi']);                        
            
            ?>        
        <span class='lbl label-nama'><?= $model->invperalatan_namabrg ?></span>
    </td>
    <td>
        <span class='lbl label-kode'><?= $model->invperalatan_kode ?></span>
    </td>
    <td>
        <span class='lbl label-merk'><?= $model->invperalatan_merk ?></span>
    </td>
    <td>
        <span class='lbl label-tanggal-perolehan'><?= $model->tanggal_perolehan ?></span>
    </td>
    <td>
        <span class='lbl label-keadaan'><?= $model->invperalatan_keadaan ?></span>
    </td>
    <td>
        <span class='lbl label-keadaan'><?= $model->alasan ?></span>
    </td>
    <td align="center;">
        <?= CHtml::activeCheckBox($model, '['.$i.']is_disetujui') ?>
    </td>
    <td>
        <?= CHtml::activeTextArea($model, '['.$i.']catatan') ?>
    </td>    
</tr>

