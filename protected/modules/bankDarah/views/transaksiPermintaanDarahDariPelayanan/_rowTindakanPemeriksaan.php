<tr data-daftartindakan_id="<?php echo $modTindakan->daftartindakan_id; ?>">
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][daftartindakan_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? $modTindakan->daftartindakan->daftartindakan_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
       
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activehiddenField($modTindakan,'[ii]diambil',array('readonly'=>false,'class'=>'span1 integer')); ?>
        <?php echo CHtml::activehiddenField($modTindakan,'[ii]dititip',array('readonly'=>false,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('readonly'=>false,'class'=>'span1 integer', 'onkeyup' => 'hitungTarif(this)')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'class'=>'integer span1')); ?>
    </td>
    <td><a onclick="batalTindakan(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan tindakan"><i class="icon-form-silang"></i></a></td>
</tr>

