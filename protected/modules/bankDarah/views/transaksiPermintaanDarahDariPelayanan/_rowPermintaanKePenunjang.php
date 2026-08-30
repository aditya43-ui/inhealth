<?php 
 $tarif = TariftindakanM::model()->find('daftartindakan_id = ' . $row->daftartindakan_id . ' and ' . ' komponentarif_id = 6');
 $harga_tariftindakan = 0;
 if(!empty($tarif)) {
     $harga_tariftindakan = $tarif->harga_tariftindakan;
 }
?>
<tr>
    <td>
        <?= $ii+1 ?>
        <?php echo CHtml::hiddenField('Permintaankepenunjang[' . $ii .'][jeniskomponendarah_id]', $modKirim->jeniskomponendarah_id) ?>
        <?php echo CHtml::hiddenField('Permintaankepenunjang[' . $ii .'][daftartindakan_id]', $row->daftartindakan_id) ?>
    </td>
    <td><?= $row->jeniskomponendarah->tipepaket_nama ?? '' ?></td>
    <td>
        <?php echo CHtml::textField('Permintaankepenunjang[' . $ii .'][jumlahkantong]', $row->jumlah_kantong, ['readonly' => 'true', 'class' => 'span1']) ?>
    </td>
    <td>
        <?php echo CHtml::textField('Permintaankepenunjang[' . $ii .'][diambil]', $row->diambil, ['readonly' => 'true', 'class' => 'span1']) ?>
    </td>
    <td>
        <?php echo CHtml::textField('Permintaankepenunjang[' . $ii .'][dititip]', $row->dititip, ['readonly' => 'true', 'class' => 'span1']) ?>
    </td>
    <td class="tarif hide">
        <?php echo CHtml::textField('Permintaankepenunjang[' . $ii .'][tarif_tindakan]',$harga_tariftindakan,array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
    <td>
        Belum Lunas
    </td>
</tr>