<?php 
    if(!empty($modPaketBmhp)) { 
        foreach($modPaketBmhp as $i=>$PaketBmhp ) {
?>
<tr>
    <td>
        <?php echo CHtml::hiddenField("paketBmhp[0][daftartindakan_id]", $PaketBmhp->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pendaftaran_id]", $modPendaftaran->pendaftaran_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pasien_id]", $modPendaftaran->pasien_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pegawai_id]", $modPendaftaran->pegawai_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][penjamin_id]", $modPendaftaran->penjamin_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][carabayar_id]", $modPendaftaran->carabayar_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][kelaspelayanan_id]", $modPendaftaran->kelaspelayanan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo $PaketBmhp->daftartindakan->daftartindakan_nama; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("paketBmhp[0][obatalkes_id]", $PaketBmhp->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo $PaketBmhp->obatalkes->obatalkes_nama; ?>
    </td>
    <td>
        <?php echo number_format($PaketBmhp->hargapemakaian); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargapemakaian]", $PaketBmhp->hargapemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargajual]", $PaketBmhp->obatalkes->hargajual,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][harganetto]", $PaketBmhp->obatalkes->harganetto,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargasatuan]", $PaketBmhp->obatalkes->hargajual,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][qtypemakaian]", $PaketBmhp->qtypemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][sumberdana_id]", $PaketBmhp->obatalkes->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][satuankecil_id]", $PaketBmhp->obatalkes->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-minus"></i>', 'javascript:void(0);',array('onclick'=>'hapusBMHP(this);','title'=>"Klik untuk menghapus ini")); ?>
    </td>
</tr>
<?php } } ?>