<tr>
    <td>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][daftartindakan_id]", $modDaftartindakan->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modDaftartindakan->daftartindakan_nama; ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][alatmedis_id]", $modAlat->alatmedis_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
        <?php echo $modAlat->alatmedis_nama; ?>
    </td>
    <td>
        <?php echo CHtml::textField("pemakaianAlat[0][qty]", '1',array('onblur'=>'hitungSubTotal(this)','readonly'=>false,'class'=>'inputFormTabel span1 number')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][satuankecil_id]", $modObatAlkes->satuankecil_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
    </td>
    <td>
        <?php echo CHtml::textField("pemakaianAlat[0][hargajual]", $modObatAlkes->hargajual,array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][hargasatuan]", $modObatAlkes->hargajual,array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][harganetto]", $modObatAlkes->harganetto,array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
        <?php echo CHtml::hiddenField("pemakaianAlat[0][sumberdana_id]", $modObatAlkes->sumberdana_id,array('readonly'=>true,'class'=>'inputFormTabel span1')); ?>
    </td>
    <td>
        <?php echo CHtml::textField("pemakaianAlat[0][subtotal]", $modObatAlkes->hargajual,array('readonly'=>true,'class'=>'inputFormTabel span2 currency')); ?>
    </td>
    <td>
        <a onclick="$(this).parents('tr').remove(); hitungTotal(); return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat"><i class="icon-form-silang"></i></a>
    </td>
</tr>
