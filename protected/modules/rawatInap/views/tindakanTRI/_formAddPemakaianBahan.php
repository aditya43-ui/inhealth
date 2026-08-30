<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][stokobatalkes_id]", (isset($modObatAlkesPasien->stokobatalkes_id) ? $modObatAlkesPasien->stokobatalkes_id : "") ,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][daftartindakan_id]", (isset($modDaftartindakan->daftartindakan_id) ? $modDaftartindakan->daftartindakan_id : "") ,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pendaftaran_id]", isset($modPendaftaran->pendaftaran_id)?$modPendaftaran->pendaftaran_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pasien_id]", isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pegawai_id]", isset($modPendaftaran->pegawai_id)?$modPendaftaran->pegawai_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][penjamin_id]", isset($modPendaftaran->penjamin_id)?$modPendaftaran->penjamin_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][carabayar_id]", isset($modPendaftaran->carabayar_id)?$modPendaftaran->carabayar_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][kelaspelayanan_id]", isset($modPendaftaran->kelaspelayanan_id)?$modPendaftaran->kelaspelayanan_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo (isset($modDaftartindakan->daftartindakan_nama) ? $modDaftartindakan->daftartindakan_nama : "") ; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][obatalkes_id]", $modObatAlkesPasien->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modObatAlkesPasien->obatalkes_nama; ?>
    </td>
<!--<td>
        
    </td>-->
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][hargajual]", $modObatAlkesPasien->hargajual_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][hargasatuan]", $modObatAlkesPasien->hargasatuan_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][harganetto]", $modObatAlkesPasien->harganetto_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][sumberdana_id]", $modObatAlkesPasien->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::textField("pemakaianBahan[0][qty]", $modObatAlkesPasien->qty_oa,array('onkeyup'=>'hitungSubTotal(this)','readonly'=>true,'class'=>'inputFormTabel lebar1 integer qty')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][satuankecil_id]", $modObatAlkesPasien->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
    </td>
    <td <?php echo Params::HIDDEN_HARGA ?>>
        <?php
            $totalsub = $modObatAlkesPasien->hargasatuan_oa *$modObatAlkesPasien->qty_oa  + '';
        ?>
        <?php echo CHtml::textField("pemakaianBahan[0][subtotal]",$totalsub,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer subtotal')); ?>
    </td>
    <td>
        <a onclick="removeObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat"><i class="icon-form-silang"></i></a>
    </td>
</tr>
