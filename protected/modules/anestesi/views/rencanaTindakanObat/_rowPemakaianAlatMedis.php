<tr>
    <td>
		<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][daftartindakan_id]", $modDaftartindakan->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php // echo $modDaftartindakan->daftartindakan_nama; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][alatmedis_id]", $modAlat->alatmedis_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modAlat->alatmedis_nama; ?>
    </td>
    <td>
        <?php echo CHtml::textField("pemakaianAlat[0][hargajual]", (isset($modObatAlkes->hargajual) ? $modObatAlkes->hargajual : 0),array('readonly'=>true,'class'=>'inputFormTabel lebar3 float')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][hargasatuan]", (isset($modObatAlkes->hargajual) ? $modObatAlkes->hargajual : 0),array('readonly'=>true,'class'=>'inputFormTabel lebar3 float')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][harganetto]", (isset($modObatAlkes->harganetto) ? $modObatAlkes->harganetto : 0),array('readonly'=>true,'class'=>'inputFormTabel lebar3 float')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][sumberdana_id]", (isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : 0),array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][qty]", '1',array('onblur'=>'hitungSubTotal(this)','readonly'=>false,'class'=>'inputFormTabel lebar1 float')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][satuankecil_id]", (isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil_id : 0),array('readonly'=>true,'class'=>'inputFormTabel lebar1')); ?>
		<?php echo CHtml::hiddenField("pemakaianAlat[0][subtotal]", (isset($modObatAlkes->hargajual) ? $modObatAlkes->hargajual : 0),array('readonly'=>true,'class'=>'inputFormTabel lebar3 float')); ?>
    </td>
	<td>
        <?php echo CHtml::link('<i class="icon-minus"></i>', 'javascript:void(0);',array('onclick'=>'hapusAlatMedis(this);','title'=>"Klik untuk menghapus ini")); ?>
    </td>
</tr>
