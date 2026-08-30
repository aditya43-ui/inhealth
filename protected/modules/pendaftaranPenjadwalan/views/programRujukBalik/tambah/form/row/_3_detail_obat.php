<?php
    $i = isset($i)?$i:0;
?>
<tr row-data='<?= $i ?>' class="baris">
    <td><?= CHtml::activeTextField($model, '['.$i.']obatalkes_nama',['readonly'=>true]) ?></td>
    <td><?= CHtml::activeTextField($model, '['.$i.']obatbpjsprb',['readonly'=>true]) ?></td>
    <td><label class="lbl"><?= $model->signa.'x'.$model->signa_2 ?></label></td>
    <td><label class="lbl"><?= $model->carapenggunaanobat ?></label></td>
    <td><?= CHtml::activeTextField($model, '['.$i.']qty_obat',['class'=>'float2 span2 qty_obat required']) ?><label class="lbl">pcs</label></td>
    <td>
        <?php
            echo CHtml::activeHiddenField($model, '['.$i.']obatprogramrujukbalikpasien_id' ,['obatprogramrujukbalikpasien_id det_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']obatalkes_id' ,['obatalkes_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']signa' ,['signa']);
            echo CHtml::activeHiddenField($model, '['.$i.']signa_2' ,['signa_2']);
            echo CHtml::activeHiddenField($model, '['.$i.']obatprb_bpjskode' ,['obatprb_bpjskode']);
            echo CHtml::activeHiddenField($model, '['.$i.']obatprb_bpjsnama' ,['obatprb_bpjsnama']);
            echo CHtml::activeHiddenField($model, '['.$i.']carapenggunaanobat' ,['carapenggunaanobat']);
            
            echo CHtml::link("<span class='icon-form-silang'></i>","javascript:;",['onclick'=>'hapusObat(this);']);
        ?>
    </td>
</tr>