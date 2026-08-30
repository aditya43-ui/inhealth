<?php
$noPeserta = "";
$ruangannama = "";
$instalasinama = "";

$oriAsuransiP = AsuransipasienM::model()->findByPk($modDetail->pendaftaran->asuransipasien_id);
if (isset($oriAsuransiP) && !empty($oriAsuransiP->asuransipasien_id)) {
    $noPeserta = $oriAsuransiP->nopeserta;
}

$admisi = PasienadmisiT::model()->findByPk($modDetail->pendaftaran->pasienadmisi_id);

if (isset($admisi) && !empty($admisi->pasienadmisi_id)) {
    $ruangannama = $admisi->ruangan->ruangan_nama;
    $instalasinama = $admisi->ruangan->instalasi->instalasi_nama;
} else {
    $ruangannama = $modDetail->pendaftaran->ruangan->ruangan_nama;
    $instalasinama = $modDetail->pendaftaran->ruangan->instalasi->instalasi_nama;
}
$bkm = PembayaranpelayananT::model()->findByPk($modDetail->pembayaranpelayanan_id);
?>
<tr>
    <td>
        <?php echo CHtml::checkBox('BKPembayarklaimdetailT[' . $i . '][cekList]', true, array('class' => 'cek', 'onClick' => 'setNol(this);')); ?>
        <?php echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pasien_id]', $modDetail->pasien_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')); ?>
        <?php //echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][jmlpiutang2]', (empty($bkm->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($bkm->totalsisatagihan) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang2 integer-decimal')); 
        ?>
        <?php //echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][jmlpiutang3]', (empty($bkm->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($jumlahPiutang) : MyFormatter::formatNumberForPrint($bkm->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang3 integer-decimal ', 'readonly' => true)); 
        ?>
        <?php echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pendaftaran_id]', $modDetail->pendaftaran_id, array()); ?>
        <?php echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pembayaranpelayanan_id]', $modDetail->pembayaranpelayanan_id, array('style' => 'width:70px;', 'class' => 'span3 ')); ?>
        <?php echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][pengajuanklaimdetail_id]', $modDetail->pengajuanklaimdetail_id, array()); ?>
        <?php echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][tandabuktibayar_id]', $modDetail->tandabuktibayar_id, array('style' => 'width:70px;', 'class' => '')); ?>
        <?php //echo CHtml::hiddenField('BKPembayarklaimdetailT[' . $i . '][jmldiskon]', $bkm->penjamin_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3 integer-decimal')); 
        ?>
    </td>
    <td>
        <?php echo $index; ?>
    </td>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($modDetail->pendaftaran->tgl_pendaftaran) . "<br>" . $modDetail->pendaftaran->no_pendaftaran; ?>
    </td>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($bkm->tglpembayaran) . "<br>" . $bkm->nopembayaran; ?>
    </td>
    <td>
        <?php echo $noPeserta; ?>
    </td>
    <td>
        <?php echo $modDetail->pasien->no_rekam_medik; ?>
    </td>
    <td>
        <?php echo $instalasinama . '/<br>' . $ruangannama; ?>
    </td>
    <td>
        <?php echo $modDetail->pasien->nama_pasien; ?>
    </td>
    <td>
        <?php echo $modDetail->noreferensi; ?>
    </td>
    <td>
        <?php echo CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmltagihan]', MyFormatter::formatNumberForPrint($modDetail->jmltagihan, 2), array('style' => 'width:120px;', 'class' => 'inputFormTabel span3 jmltagihan integer-decimal', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmldiskon]', MyFormatter::formatNumberForPrint($modDetail->jmldiskon, 2), array('style' => 'width:120px;', 'class' => 'inputFormTabel span3 jmldiskon integer-decimal', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmlpiutang]', MyFormatter::formatNumberForPrint($modDetail->jmlpiutang, 2), array('style' => 'width:120px;', 'class' => 'inputFormTabel span3 jmlpiutang integer-decimal', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmltelahbayar]', MyFormatter::formatNumberForPrint($jmlbayarKlaim, 2), array('style' => 'width:120px;', 'class' => 'inputFormTabel span3 jmltelahbayar integer-decimal', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jumlahbayar]', MyFormatter::formatNumberForPrint($modDetail->jumlahbayar, 2), array('style' => 'width:120px;', 'class' => 'inputFormTabel span3 jumlahbayar integer-decimal', 'onblur' => 'hitungTotalAll()')); ?>
    </td>
    <td>
        <?php echo CHtml::textField('BKPembayarklaimdetailT[' . $i . '][jmlsisapiutang]', MyFormatter::formatNumberForPrint(0, 2), array('style' => 'width:120px;', 'class' => 'inputFormTabel span3 jmlsisapiutang integer-decimal', 'readonly' => true)); ?>
    </td>


</tr>