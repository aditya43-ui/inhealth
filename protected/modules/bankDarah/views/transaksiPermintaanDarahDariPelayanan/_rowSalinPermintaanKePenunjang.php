
<tr>
    <td>
    
        <?= CHtml::textField('no_urut',$jumlahtr,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField('TindakanpelayananT[' . $jumlahtr .'][jeniskomponendarah_id]', $modKirim->jeniskomponendarah_id) ?>
        <?php echo CHtml::hiddenField('TindakanpelayananT[' . $jumlahtr .'][daftartindakan_id]', $modPaketPelayanan->daftartindakan_id) ?>
        <?php echo CHtml::hiddenField('TindakanpelayananT[' . $jumlahtr .'][diambil]', $row->diambil, ['readonly' => 'true', 'class' => 'span1']) ?>
        <?php echo CHtml::hiddenField('TindakanpelayananT[' . $jumlahtr .'][dititip]', $row->dititip, ['readonly' => 'true', 'class' => 'span1']) ?>
        <?php echo CHtml::hiddenField('TindakanpelayananT[' . $jumlahtr .'][jenistarif_id]', $tarif->jenistarif_id, ['readonly' => 'true', 'class' => 'span1']) ?>
    </td>
    <td><?= $modPaketPelayanan->namatindakan ?? '' ?></td>
    <td>
        <?php echo CHtml::textField('TindakanpelayananT[' . $jumlahtr .'][qty_tindakan]', 1, ['class' => 'span1', 'onkeyup' => 'hitungTarif(this)']) ?>
    </td>
    <td>
        <?php echo CHtml::textField('TindakanpelayananT[' . $jumlahtr .'][tarif_satuan]',$modPaketPelayanan->tarifpaketpel,array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
    <td>
        <?php echo CHtml::textField('TindakanpelayananT[' . $jumlahtr .'][tarif_tindakan]',($modPaketPelayanan->tarifpaketpel * 1),array('readonly'=>true,'readonly'=>true,'class'=>'span2 integer','style'=>'width:96px')); ?>
    </td>
    <td><a onclick="batalTindakan(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan tindakan"><i class="icon-form-silang"></i></a></td>
</tr>