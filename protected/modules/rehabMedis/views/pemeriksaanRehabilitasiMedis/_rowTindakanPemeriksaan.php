<tr data-daftartindakan_id="<?php echo $modTindakan->daftartindakan_id; ?>">
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][tindakanrm_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? $modTindakan->daftartindakan->daftartindakan_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1 tindakanpelayanan_id', 'data-id'=>$modTindakan->tindakanpelayanan_id, 'data-master'=>$modTindakan->daftartindakan_id)); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistindakanrm_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanrm_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('class'=>'span1 integer', 'onblur'=>'hitungTotal()')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer span1')); ?>
    </td>
</tr>

