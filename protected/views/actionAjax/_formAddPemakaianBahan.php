<tr>
    <td>
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
        <?php echo CHtml::hiddenField("pemakaianBahan[0][obatalkes_id]", $modObatAlkes->obatalkes_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modObatAlkes->obatalkes_nama; ?>
    </td>
<!--    <td>
        
    </td>-->
    <td>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][hargajual]", $modObatAlkes->hargajual,array('readonly'=>true,'class'=>'inputFormTabel lebar3 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][hargasatuan]", $modObatAlkes->hargajual,array('readonly'=>true,'class'=>'inputFormTabel lebar3 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][harganetto]", $modObatAlkes->harganetto,array('readonly'=>true,'class'=>'inputFormTabel lebar3 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][sumberdana_id]", $modObatAlkes->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::textField("pemakaianBahan[0][qty]", '1',array('onkeyup'=>'hitungSubTotal(this)','readonly'=>false,'class'=>'inputFormTabel lebar1 number qty')); ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][satuankecil_id]", $modObatAlkes->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php
            $totalsub = $modObatAlkes->hargajual + '';
        ?>
        <?php echo CHtml::hiddenField("pemakaianBahan[0][subtotal]",$totalsub,array('readonly'=>true,'class'=>'inputFormTabel lebar3 currency subtotal')); ?>
    </td>
<!--    <td>
        
    </td>-->
    <td>
        <a onclick="removeObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat"><i class="icon-remove"></i></a>
    </td>
</tr>
