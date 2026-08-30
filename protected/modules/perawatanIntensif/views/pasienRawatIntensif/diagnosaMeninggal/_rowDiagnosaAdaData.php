<?php $no = $jumlahtr+1  ?>
<tr>
    <td><?= $no ?></td>
    <td>
        <?= CHtml::activehiddenField($modMortalitas, '['. $no.']diagnosa_id', ['class' => 'span2 row_diagnosa_x_id','readonly' => true]) ?>
        <?= CHtml::activetextField($modMortalitas, '['. $no.']diagnosa_kode', ['class' => 'span1','readonly' => true]) ?>
    </td>
    <td>
        <?= CHtml::activetextField($modMortalitas, '['. $no.']diagnosa_nama', ['class' => 'span2','readonly' => true]) ?>
    </td>
    <td>
        <?= CHtml::activetextField($modMortalitas,  '['. $no.']diagnosa_namalainnya', ['class' => 'span2','readonly' => true]) ?>
    </td>
    <td>
        <?php 
            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#", array("onclick" => "hapusDiagnosa(this, " . $modMortalitas->mortalitas_id .");return false;", "title" => "Klik untuk Menghapus Diagnosis"));
        ?>
    </td>
</tr>