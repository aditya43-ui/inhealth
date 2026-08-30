<?php 
$exDiambil = explode(' ', $row->diambil ?? '');
$exDititip = explode(' ', $row->dititip ?? '');
$jenisvolumdiambil = '';
if(isset($row) && isset($exDiambil[0])) {
    $row->diambil = $exDiambil[0];
}
if(isset($row) && isset($exDiambil[1])) {
    $jenisvolumdiambil = $exDiambil[1];
}
$jenisvolumdititip = '';
if(isset($row) && isset($exDititip[0])) {
    $row->dititip = $exDititip[0];
}
if(isset($exDititip[1])) {
    $jenisvolumdititip = $exDititip[1];
}
?>
<tr>
    <td>
        <?= $ii+1 ?>
    </td>
    <td>
        <?= $jeniskomponenedarah_nama ?? '' ?>
        <?php echo CHtml::hiddenField('PencatatanStok[' . $ii .'][jeniskomponendarah_id]', $jeniskomponendarah_id, ['readonly' => 'true', 'class' => 'span1 jeniskomponendarah_id']) ?>
        <?php echo CHtml::hiddenField('PencatatanStok[' . $ii .'][permintaankepenunjang_id]', $row->permintaankepenunjang_id ?? '', ['readonly' => 'true', 'class' => 'span1 permintaankepenunjang_id']) ?>
    </td>
    <td>
        <?php echo CHtml::numberField('PencatatanStok[' . $ii .'][jumlahkantong]', $row->jumlah_kantong ?? '', ['readonly' => 'true', 'class' => 'span1 jumlahkantong', 'style' => 'display: inline-block']);
        echo CHtml::dropDownList('jenis_volume', 'LABU', LookupM::getItems('jenis_volume'),array('class'=>'span1 jenisvolumejumlahkantong', 'style' => 'display: inline-block', 'disabled' => true));
        ?>
        
    </td>
    <td>
        <?php echo CHtml::numberField('PencatatanStok[' . $ii .'][diambil]', $row->diambil ?? '', ['readonly' => 'true', 'class' => 'span1 diambil']);
        echo CHtml::dropDownList('PencatatanStok[' . $ii .'][jenisvolumediambil]',empty($jenisvolumdiambil) ? 'LABU' : $jenisvolumdiambil, LookupM::getItems('jenis_volume'),array('class'=>'span1 jenisvolumediambil', 'disabled' => true))
        ?>
    </td>
    <td>
        <?php echo CHtml::numberField('PencatatanStok[' . $ii .'][dititip]', $row->dititip ?? '', ['readonly' => 'true', 'class' => 'span1 dititip']);
        echo CHtml::dropDownList('PencatatanStok[' . $ii .'][jenisvolumedititip]','LABU', LookupM::getItems('jenis_volume'),array('class'=>'span1 jenisvolumedititip', 'disabled' => true));
        ?>
    </td>
   
    <td>
        <a onclick="simpanPencatatanStok(this, <?= $jeniskomponendarah_id ?>);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk Simpan" class="simpanPencatatan hide"><i class="icon-form-check"></i></a>
        <a onclick="enableInput(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk mengubah" class="ubahpencatatan"><i class="icon-form-ubah"></i></a>
    </td>
</tr>