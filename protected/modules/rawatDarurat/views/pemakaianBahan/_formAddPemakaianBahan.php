<tr>
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][daftartindakan_id]", (isset($modDaftartindakan->daftartindakan_id) ? $modDaftartindakan->daftartindakan_id : "") ,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][pendaftaran_id]", isset($modPendaftaran->pendaftaran_id)?$modPendaftaran->pendaftaran_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][pasien_id]", isset($modPendaftaran->pasien_id)?$modPendaftaran->pasien_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][pegawai_id]", isset($modPendaftaran->pegawai_id)?$modPendaftaran->pegawai_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][penjamin_id]", isset($modPendaftaran->penjamin_id)?$modPendaftaran->penjamin_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][carabayar_id]", isset($modPendaftaran->carabayar_id)?$modPendaftaran->carabayar_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][kelaspelayanan_id]", isset($modPendaftaran->kelaspelayanan_id)?$modPendaftaran->kelaspelayanan_id:'',array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
		<?php echo CHtml::hiddenField('pemakaianBahan[ii][obatalkespasien_id]',isset($modObatAlkesPasien->obatalkespasien_id) ? $modObatAlkesPasien->obatalkespasien_id : '',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::hiddenField('pemakaianBahan[ii][satuankecil_id]',isset($modObatAlkesPasien->satuankecil_id) ? $modObatAlkesPasien->satuankecil_id : '',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::hiddenField('pemakaianBahan[ii][stokobatalkes_id]',isset($modObatAlkesPasien->stokobatalkes_id) ? $modObatAlkesPasien->stokobatalkes_id : '',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::hiddenField('pemakaianBahan[ii][sumberdana_id]',isset($modObatAlkesPasien->sumberdana_id) ? $modObatAlkesPasien->sumberdana_id : '',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo (isset($modDaftartindakan->daftartindakan_nama) ? $modDaftartindakan->daftartindakan_nama : "") ; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][obatalkes_id]", $modObatAlkesPasien->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modObatAlkesPasien->obatalkes_nama; ?>
    </td>
    <td style="text-align:right;">
        <?php echo $modObatAlkesPasien->hargajual_oa; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][hargajual_oa]", $modObatAlkesPasien->hargajual_oa,array('readonly'=>true,'class'=>'integer-decimal')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][hargasatuan_oa]", $modObatAlkesPasien->hargasatuan_oa,array('readonly'=>true,'class'=>'integer-decimal')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][harganetto_oa]", $modObatAlkesPasien->harganetto_oa,array('readonly'=>true,'class'=>'integer-decimal')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][sumberdana_id]", $modObatAlkesPasien->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::textField("pemakaianBahan[ii][qty_oa]", isset($modObatAlkesPasien->qty_oa) ? $modObatAlkesPasien->qty_oa : '1',array('onkeyup'=>'hitungSubTotal(this)','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal qty','style'=>'text-align: right;')); ?>
		<?php echo CHtml::hiddenField("pemakaianBahan[ii][qty_stok]",isset($modObatAlkesPasien->qty_stok) ? $modObatAlkesPasien->qty_stok : '1',array('readonly'=>true,'class'=>'span1 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][satuankecil_id]", $modObatAlkesPasien->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php
            $totalsub = $modObatAlkesPasien->hargajual_oa;
        ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[ii][iurbiaya]",$totalsub,array('readonly'=>true,'class'=>'integer-decimal lebar3 subtotal')); ?>
    </td>
    <td>
        <a onclick="removeObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat"><i class="icon-form-silang"></i></a>
    </td>
</tr>
