<tr <?php if(!empty($modTindakanAnestesi->tindakansudahbayar_id)){?> style="background-color: #00FF00;" <?php } ?>>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][jenisanastesi_nama]"><?php echo (isset($modTindakanAnestesi->anastesi->jenisanastesi->jenisanastesi_nama) ? $modTindakanAnestesi->anastesi->jenisanastesi->jenisanastesi_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakanAnestesi,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakanAnestesi,'[ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakanAnestesi,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakanAnestesi,'[ii]anastesi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakanAnestesi,'[ii]ruangan_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
	<td>
        <span name="[ii][anastesi_nama]"><?php echo (!empty($modTindakanAnestesi->daftartindakan_id) ? (isset($modTindakanAnestesi->anastesi->anastesi_nama) ? $modTindakanAnestesi->anastesi->anastesi_nama : $modTindakanAnestesi->daftartindakan->daftartindakan_nama) : "-") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakanAnestesi,'[ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 float')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakanAnestesi,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakanAnestesi,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 float','style'=>'width:96px')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakanAnestesi,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 float','style'=>'width:96px')); ?>
    </td>
</tr>

