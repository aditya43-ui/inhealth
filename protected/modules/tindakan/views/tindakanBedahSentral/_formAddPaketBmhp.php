<tr>
    <td>
        <?php echo CHtml::hiddenField("paketBmhp[0][daftartindakan_id]", $paketBmhp->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pendaftaran_id]", $modPendaftaran->pendaftaran_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pasien_id]", $modPendaftaran->pasien_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][pegawai_id]", $modPendaftaran->pegawai_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][penjamin_id]", $modPendaftaran->penjamin_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][carabayar_id]", $modPendaftaran->carabayar_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][kelaspelayanan_id]", $modPendaftaran->kelaspelayanan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][stokobatalkes_id]", $paketBmhp->stokobatalkes_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo $paketBmhp->daftartindakan_nama; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("paketBmhp[0][obatalkes_id]", $paketBmhp->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][stokobatalkes_id]", $paketBmhp->stokobatalkes_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo $paketBmhp->obatalkes_nama; ?>
    </td>
    <td>
        <?php echo number_format($paketBmhp->hargapemakaian); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargapemakaian]", $paketBmhp->hargapemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargajual]", $paketBmhp->hargajual_oa,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][harganetto]", $paketBmhp->harganetto_oa,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][hargasatuan]", $paketBmhp->hargasatuan_oa,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][qtypemakaian]", $paketBmhp->qtypemakaian,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
		<?php echo CHtml::hiddenField("paketBmhp[0][qty_stok]",$paketBmhp->qty_stok,array('readonly'=>true,'class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][sumberdana_id]", $paketBmhp->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][satuankecil_id]", $paketBmhp->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTable span1')); ?>
		<?php
            $totalsub = $paketBmhp->hargajual + '';
        ?>
        <?php echo CHtml::hiddenField("paketBmhp[0][subtotal]",$totalsub,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer subtotal')); ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-minus"></i>', 'javascript:void(0);',array('onclick'=>'hapusBMHP(this);','title'=>"Klik untuk menghapus ini")); ?>
    </td>
</tr>