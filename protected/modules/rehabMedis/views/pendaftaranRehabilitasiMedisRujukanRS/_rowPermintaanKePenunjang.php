<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][tindakanrm_nama]"><?php echo (!empty($modPermintaan->tindakanrm_id) ? $modPermintaan->tindakanrm_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']jenistindakanrm_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']tindakanrm_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']qtypermintaan',array('readonly'=>false,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']tarif_pelayananan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.']tarif_satuan',array('readonly'=>true,'class'=>'integer span1')); ?>
    </td>
</tr>