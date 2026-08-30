<tr class="paket_id_<?php echo $modPermintaanMcu->tipepaket_id;?>">
        <td>
                <?php echo CHtml::textField('no_urut',$i+1,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:30px;')); ?>
        </td>
        <td>
                <span name="[ii][namatindakan]"><?php echo (!empty($modPermintaanMcu->namatindakan) ? $modPermintaanMcu->namatindakan : "-") ?></span>
                <?php echo CHtml::activeHiddenField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
                <?php echo CHtml::activeHiddenField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']paketpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
                <?php echo CHtml::activeHiddenField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
                <?php echo CHtml::activeTextField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']tipepaket_id',array('readonly'=>true,'class'=>'span1 tipepaket_id')); ?>
                <?php echo CHtml::activeHiddenField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']ruangantujuan_id',array('readonly'=>true,'class'=>'span1')); ?>
        </td>
        <td>
                <?php echo CHtml::activeTextField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']ruangan_nama',array('readonly'=>true,'class'=>'span2')); ?>
        </td>
        <td style="text-align:right;">
                <?php echo CHtml::activeTextField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer','style'=>'text-align:right;')); ?>
        </td>
        <td>
                <?php echo CHtml::activeTextField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
        </td>
        <td style="text-align:right;">
                <?php echo CHtml::activeTextField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']tarif_satuan',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px;text-align:right;')); ?>
        </td>
        <td style="text-align:right;">
                <?php echo CHtml::activeTextField($modPermintaanMcu,'['.$modPermintaanMcu->ruangantujuan_id.']['.$i.']tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px;text-align:right;')); ?>
        </td>
</tr>
