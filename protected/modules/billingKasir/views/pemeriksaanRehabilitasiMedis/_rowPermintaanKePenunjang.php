<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][tindakanrm_nama]"><?php echo (!empty($modPermintaan->tindakanrm_id) ? $modPermintaan->tindakanrm_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]jenistindakanrm_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]tindakanrm_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
</tr>