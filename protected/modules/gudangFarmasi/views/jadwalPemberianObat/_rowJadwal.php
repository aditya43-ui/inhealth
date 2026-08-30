<?php
    $i = !empty($i)?$i:0;
?>
<tr class="baris"  row-data="<?= $i ?>">
    <td>
        <span class="nourut"><?= $i+1 ?></span>
    </td>
    <td>
        <?= CHtml::activeDropDownList($model, '['.$i.']jadwal', $listjadwal, ['empty'=>'-- Pilih --', 'class'=>'required']) ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$i.']urutan', ['class'=>'numbers-only']) ?>
    </td>
    <td style="text-align: center;">
        <?= CHtml::activeCheckBox($model, '['.$i.']jadwalpemberianobat_aktif', []) ?>
    </td>
    <td>
        <?php
            echo CHtml::activeHiddenField($model,'['.$i.']jadwalpemberianobat_id',['class'=>'det_id']);
        ?>
        <?= CHtml::link("<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>", 'javascript:;', ['onclick' => 'set_action(this,"tambah");', 'class' => 'btn btn-primary btn-tambah', 'style' => 'padding:5px;']) ?>
        <?= CHtml::link("<i class='" . MyIcon::getIcons('hapus-baris') . "'></i>", 'javascript:;', ['onclick' => 'set_action(this,"hapus");', 'class' => 'btn btn-danger btn-hapus', 'style' => 'padding:5px;']) ?>
    </td>
</tr>