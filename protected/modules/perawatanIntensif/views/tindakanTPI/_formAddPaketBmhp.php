<?php 
//    if(!empty($modPaketBmhp)) { 
//        foreach($modPaketBmhp as $i=>$PaketBmhp ) {
?>
<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][stokobatalkes_id]", $modObatAlkesPasien->stokobatalkes_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][daftartindakan_id]", $modObatAlkesPasien->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pendaftaran_id]", $modPendaftaran->pendaftaran_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pasien_id]", $modPendaftaran->pasien_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pegawai_id]", $modPendaftaran->pegawai_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][penjamin_id]", $modPendaftaran->penjamin_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][carabayar_id]", $modPendaftaran->carabayar_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][kelaspelayanan_id]", $modPendaftaran->kelaspelayanan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo $modObatAlkesPasien->daftartindakan_nama; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("paketBmhp[0][obatalkes_id]", $modObatAlkesPasien->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo $modObatAlkesPasien->obatalkes_nama; ?>
    </td>
    <td>
        <?php //echo number_format($modObatAlkesPasien->hargapemakaian); ?>
        <?php echo CHtml::textField("paketBmhp[0][hargapemakaian]", $modObatAlkesPasien->hargasatuan_oa,array('readonly'=>true,'class'=>'span1 integer')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargajual]", $modObatAlkesPasien->hargajual_oa,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][harganetto]", $modObatAlkesPasien->harganetto_oa,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargasatuan]", $modObatAlkesPasien->hargapemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][qtypemakaian]", $modObatAlkesPasien->qtypemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][sumberdana_id]", $modObatAlkesPasien->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][satuankecil_id]", $modObatAlkesPasien->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
    </td> 
    <td>
        <?php echo CHtml::link('<i class="icon-minus"></i>', 'javascript:void(0);',array('onclick'=>'hapusBMHP(this);','title'=>"Klik untuk menghapus ini")); ?>
    </td>
</tr>
<?php //} } ?>