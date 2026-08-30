<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <?php
            $pemrad = PemeriksaanradM::model()->findByPk($modTindakan->pemeriksaanrad_id);
        ?>
        <span name="[ii][pemeriksaanrad_nama]" class="nama-daftatindakan"><?php echo (!empty($pemrad) ? $pemrad->pemeriksaanrad_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]pemeriksaanrad_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1 id-daftartindakan')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer col-sm-6')); ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>' col-sm-6 integer')); ?>
    </td>
    <td style="text-align: center;">
        -
    </td>
	<td style="text-align: center;"><?php echo CHtml::link('<i class="entypo-cancel-circled"></i>', '#', array(
		'onclick'=>'delItems(this); return false;'
	)); ?></td>
</tr>

