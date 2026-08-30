<tr>
    <td>
		<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][daftartindakan_id]", (isset($modDaftartindakan->daftartindakan_id) ? $modDaftartindakan->daftartindakan_id : "") ,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pendaftaran_id]", isset($modPendaftaran->pendaftaran_id)?$modPendaftaran->pendaftaran_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pasien_id]", isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][pegawai_id]", isset($modPendaftaran->pegawai_id)?$modPendaftaran->pegawai_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][penjamin_id]", isset($modPendaftaran->penjamin_id)?$modPendaftaran->penjamin_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][carabayar_id]", isset($modPendaftaran->carabayar_id)?$modPendaftaran->carabayar_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][kelaspelayanan_id]", isset($modPendaftaran->kelaspelayanan_id)?$modPendaftaran->kelaspelayanan_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][stokobatalkes_id]", isset($modObatAlkesPasien->stokobatalkes_id) ? $modObatAlkesPasien->stokobatalkes_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo (isset($modDaftartindakan->daftartindakan_nama) ? $modDaftartindakan->daftartindakan_nama : "") ; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][obatalkes_id]", $modObatAlkesPasien->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modObatAlkesPasien->obatalkes_nama; ?>
    </td>
	<td>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][qty_stok]",$modObatAlkesPasien->qty_stok,array('readonly'=>true,'class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
        <?php echo CHtml::textField("pemakaianBahan[0][qty_oa]",$modObatAlkesPasien->qty_oa,array('class'=>'span1 integer', 'onblur'=>'hitungSubTotal(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
    </td>
    <td <?php echo Params::HIDDEN_HARGA; ?>>
        <?php echo CHtml::textField("pemakaianBahan[0][harganetto_oa]", $modObatAlkesPasien->harganetto_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][hargajual_oa]", $modObatAlkesPasien->hargajual_oa,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][sumberdana_id]", $modObatAlkesPasien->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][satuankecil_id]", $modObatAlkesPasien->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php
            $totalsub = $modObatAlkesPasien->harganetto_oa + '';
        ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][subtotal]",$totalsub,array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer subtotal')); ?>
    </td>
	
    <td>
        <a onclick="batalOaPasien(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Obat / Alat Kesehatan"><i class="icon-form-silang"></i></a>
    </td>
</tr>
