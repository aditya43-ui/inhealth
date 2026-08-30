<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][operasi_nama]"> <?php echo isset($modTindakan->operasi_nama) ? $modTindakan->operasi_nama : ""; ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php // echo CHtml::activeHiddenField($modTindakan,'[ii]operasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php // echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
</tr>

