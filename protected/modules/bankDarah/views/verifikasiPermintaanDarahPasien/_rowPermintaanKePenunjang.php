
<tr>
    <td>
        <?= $ii+1 ?>
        <?php echo CHtml::hiddenField('Permintaankepenunjang[' . $ii .'][jeniskomponendarah_id]', $modKirim->jeniskomponendarah_id) ?>
    </td>
    <td><?= $row->jeniskomponendarah->jeniskomponenedarah_nama ?? '' ?></td>
    <td>
        <?php echo CHtml::textField('Permintaankepenunjang[' . $ii .'][jumlahkantong]', $row->jumlah_kantong, ['readonly' => 'true', 'class' => 'span1']) ?>
    </td>
    <td>
        <?php echo CHtml::textField('Permintaankepenunjang[' . $ii .'][diambil]', $row->diambil, ['readonly' => 'true', 'class' => 'span1']) ?>
    </td>
    <td>
        <?php echo CHtml::textField('Permintaankepenunjang[' . $ii .'][dititip]', $row->dititip, ['readonly' => 'true', 'class' => 'span1']) ?>
    </td>

    <td>
        Belum Lunas
    </td>
</tr>