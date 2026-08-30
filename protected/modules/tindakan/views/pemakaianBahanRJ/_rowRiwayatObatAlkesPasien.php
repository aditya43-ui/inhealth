<tr id="row_<?php echo $modObatAlkesPasien->obatalkespasien_id; ?>">
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField('riwayatOaPasien[ii][obatalkespasien_id]',$modObatAlkesPasien->obatalkespasien_id,array('readonly'=>true,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::textField('riwayatOaPasien[ii][tglpelayanan]',$modObatAlkesPasien->tglpelayanan,array('readonly'=>true,'class'=>'span3','style'=>'width:120px;')); ?>
    </td>
    <td>
        <span name="riwayatOaPasien[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkesPasien->obatalkes_id) ? $modObatAlkesPasien->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <span name="riwayatOaPasien[ii][satuankecil_nama]"><?php echo (!empty($modObatAlkesPasien->satuankecil_id) ? $modObatAlkesPasien->satuankecil->satuankecil_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::textField('riwayatOaPasien[ii][qty_oa]',$modObatAlkesPasien->qty_oa,array('readonly'=>true,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <a onclick="hapusOaPasien('<?php echo $modObatAlkesPasien->obatalkespasien_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat / Alat Kesehatan"><i class="icon-trash"></i></a>
    </td>
</tr>