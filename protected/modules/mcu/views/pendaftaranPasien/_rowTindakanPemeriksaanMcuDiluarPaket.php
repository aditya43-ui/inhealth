<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:30px;')); ?>
    </td>
    <td>
        <span class="namatindakan" name="[ii][namatindakan]"><?php echo (!empty($modTindakan->daftartindakan_nama) ? $modTindakan->namatindakan : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[i][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[i][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[i][ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[i][ii]ruangan_id',array('readonly'=>true,'class'=>'span1 r_id')); ?>
		<?php echo CHtml::activeHiddenField($modTindakan,'[i][ii]ruangan_nama',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[i][ii]ruangan_nama',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td style="text-align:right;">
        <?php echo CHtml::activeTextField($modTindakan,'[i][ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer','style'=>'text-align:right;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[i][ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td style="text-align:right;">
        <?php echo CHtml::activeTextField($modTindakan,'[i][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px;text-align:right;')); ?>
    </td>
    <td style="text-align:right;">
        <?php echo CHtml::activeTextField($modTindakan,'[i][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px;text-align:right;')); ?>
    </td>
    <td style="text-align:right;">
        <?php echo CHtml::link('<span style="font-size:20px;" name="[ii][link]""><i class="'.MyIcon::getIcons('batal').'"></i></span>','javascript:;',array('onclick'=>'batalTindakan(this);', 'rel'=>'tooltip', 'data-original-title'=>'klink icon ini untuk membatalkan pemeriksaan','data-placement'=>'left','id'=>'linkbatal')); ?>
    </td>
</tr>
