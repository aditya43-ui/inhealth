<?php
$i = !empty($i)?$i:0;
?>
<tr row-data="<?= $i ?>"class="baris">
    <td><label><?= $model->tgl_tindakan ?></label></td>
    <td><label><?= $model->ruangan_nama ?></label></td>
    <td><label><?= $model->total_tarif ?></label></td>
    <td><label><?= $model->discount_tindakan ?></label></td>
    <td><label><?= $model->total_akhir ?></label></td>
    <td>
        <?= CHtml::link("<span style='font-size:20px;' class='entypo-pencil'></i>","javascript:;", ['onclick'=>'formGenerate("ubah", '.$model->tindakanpelayanan_id.');', 'rel'=>'tooltio', 'title'=>'Ubah Akomodasi', 'data-id'=>$model->tindakanpelayanan_id]) ?>
    </td>
    <td>
        <?= CHtml::link("<span style='font-size:20px;color:red;' class='entypo-cancel'></i>","javascript:;", ['onclick'=>'batalAkomodasi('.$model->tindakanpelayanan_id.');', 'rel'=>'tooltio', 'title'=>'Batal Akomodasi', 'data-id'=>$model->tindakanpelayanan_id]) ?>
    </td>
</tr>