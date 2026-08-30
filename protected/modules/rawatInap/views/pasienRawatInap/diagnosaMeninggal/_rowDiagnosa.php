<?php $no = $jumlahtr+1  ?>
<tr>
    <td><?= $no ?></td>
    <td>
        <?= CHtml::hiddenField("Diagnosa[". $no ."][diagnosa_id]", $diagnosa_id, ['class' => 'span2','readonly' => true]) ?>
        <?= CHtml::textField("Diagnosa[". $no ."][diagnosa_kode]", $diagnosa_kode, ['class' => 'span1','readonly' => true]) ?>
    </td>
    <td>
        <?= CHtml::textField("Diagnosa[". $no ."][diagnosa_nama]", $diagnosa_nama, ['class' => 'span2','readonly' => true]) ?>
    </td>
    <td>
        <?= CHtml::textField("Diagnosa[". $no ."][diagnosa_namalainnya]", $diagnosa_namalainnya, ['class' => 'span2','readonly' => true]) ?>
    </td>
    <td>
        <?php 
            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#", array("onclick" => "hapusDiagnosa(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosis"));
        ?>
    </td>
</tr>