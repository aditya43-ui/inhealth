<?php foreach ($modPaketBmhp as $i => $bmhp) { ?>
<tr>
    <td>
        <?php echo CHtml::hiddenField("paketBmhp[$i][daftartindakan_id]", $bmhp->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo $bmhp->daftartindakan->daftartindakan_nama ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("paketBmhp[$i][obatalkes_id]", $bmhp->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo $bmhp->obatalkes->obatalkes_nama ?>
    </td>
    <td>
        <?php echo $bmhp->hargapemakaian ?>
        <?php echo CHtml::hiddenField("paketBmhp[$i][hargapemakaian]", $bmhp->hargapemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[$i][hargajual]", $bmhp->obatalkes->hargajual,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[$i][harganetto]", $bmhp->obatalkes->harganetto,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[$i][hargasatuan]", $bmhp->obatalkes->hargajual,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[$i][qtypemakaian]", $bmhp->qtypemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[$i][sumberdana_id]", $bmhp->obatalkes->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[$i][satuankecil_id]", $bmhp->obatalkes->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
    </td>
</tr> 
<?php } ?>
