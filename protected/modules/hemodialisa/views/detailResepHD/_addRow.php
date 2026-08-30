<tr class="tr-obatalkes" baris="<?= $key; ?>">
    <td>
        <?= CHtml::activeHiddenField($modResep, '['.$key.']resephd_det_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
        <?= CHtml::activeHiddenField($modResep, '['.$key.']obatalkes_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
        <?= CHtml::activeHiddenField($modResep, '['.$key.']resephd_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '')); ?>
        
        <?= CHtml::activeTextField($modResep, '['.$key.']obatalkes_kode', array('disabled'=>true)) ?>
    </td>
    <td><?= CHtml::activeTextField($modResep, '['.$key.']obatalkes_nama', array('disabled'=>true)) ?></td>
    <td><?= CHtml::activeTextField($modResep, '['.$key.']satuankecil_nama', array('disabled'=>true)) ?></td>
    <td><?= CHtml::activeTextField($modResep, '['.$key.']harga_satuan', array('disabled'=>true)) ?></td>
    <td>
        <a href="javascript:void(0)" onclick="hapusBaris(this)"><i class="icon-minus-sign"></i></a>
    </td>
</tr>

