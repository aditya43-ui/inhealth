<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanrad_nama]"><?php echo (!empty($modPermintaan->daftartindakan_id) ? $modPermintaan->pemeriksaanrad->pemeriksaanrad_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]permintaankepenunjang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]pemeriksaanrad_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
</tr>

