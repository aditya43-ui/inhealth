<tr>
    <td>
        <?php echo CHtml::hiddenField("no_urut", '',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][stokobatalkes_id]", (isset($modObatAlkesPasien->stokobatalkes_id) ? $modObatAlkesPasien->stokobatalkes_id : "") ,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][daftartindakan_id]", (isset($modDaftartindakan->daftartindakan_id) ? $modDaftartindakan->daftartindakan_id : "") ,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pendaftaran_id]", isset($modPendaftaran->pendaftaran_id)?$modPendaftaran->pendaftaran_id:'',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pasien_id]", isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien_id:'',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pegawai_id]", isset($modPendaftaran->pegawai_id)?$modPendaftaran->pegawai_id:'',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][penjamin_id]", isset($modPendaftaran->penjamin_id)?$modPendaftaran->penjamin_id:'',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][carabayar_id]", isset($modPendaftaran->carabayar_id)?$modPendaftaran->carabayar_id:'',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][kelaspelayanan_id]", isset($modPendaftaran->kelaspelayanan_id)?$modPendaftaran->kelaspelayanan_id:'',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][ruangan_id]", isset($modObatAlkesPasien->ruangan_id) ? $modObatAlkesPasien->ruangan_id:'',array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo (isset($modDaftartindakan->daftartindakan_nama) ? $modDaftartindakan->daftartindakan_nama : "") ; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][obatalkes_id]", $modObatAlkesPasien->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modObatAlkesPasien->obatalkes_nama; ?>
    </td>
<!--<td>
        
    </td>-->
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][hargajual]", $modObatAlkesPasien->hargajual,array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][hargasatuan]", $modObatAlkesPasien->hargasatuan,array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][harganetto]", $modObatAlkesPasien->harganetto,array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][sumberdana_id]", $modObatAlkesPasien->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo CHtml::textField("pemakaianBahan[0][qty]", '1',array('onkeyup'=>'hitungSubTotal(this)','readonly'=>false,'class'=>'inputFormTabel span1 number qty')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][satuankecil_id]", $modObatAlkesPasien->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php
            $totalsub = $modObatAlkesPasien->hargasatuan + '';
        ?>
        
    </td>
    <td>
        <?php echo CHtml::textField("pemakaianBahan[0][hargasatuan]", number_format($modObatAlkesPasien->hargasatuan, 0, ".", ","),array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
        <?php
            $totalsub = $modObatAlkesPasien->hargasatuan + '';
        ?>
        
    </td>
    <td>
        <?php echo CHtml::textField("pemakaianBahan[0][subtotal]",number_format($totalsub, 0, ".", ","),array('readonly'=>true,'class'=>'inputFormTabel span2 currency subtotal')); ?>
    </td>
    <td>
        <a onclick="$(this).parents('tr').remove(); hitungTotal(); return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat"><i class="icon-form-silang"></i></a>
    </td>
</tr>
