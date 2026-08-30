<?php

$selisih = $row->totalsubsidiasuransi + $row->total_inacbg;
$noPeserta = "";
$ruangannama = "";
$instalasinama = "";

$oriAsuransiP = AsuransipasienM::model()->findByPk($row->pendaftaran->asuransipasien_id);

if (isset($oriAsuransiP) && !empty($oriAsuransiP->asuransipasien_id)) {
    $noPeserta = $oriAsuransiP->nopeserta;
}

$admisi = PasienadmisiT::model()->findByPk($row->pendaftaran->pasienadmisi_id);

if (isset($admisi) && !empty($admisi->pasienadmisi_id)) {
    $ruangannama = $admisi->ruangan->ruangan_nama;
    $instalasinama = $admisi->ruangan->instalasi->instalasi_nama;
} else {
    $ruangannama = $row->pendaftaran->ruangan->ruangan_nama;
    $instalasinama = $row->pendaftaran->ruangan->instalasi->instalasi_nama;
}

?>

<tr>
    <?php if ($text == false) : ?>
        <td>
            <?php
            echo CHtml::checkBox('BKPengajuanklaimdetailT[' . $i . '][cekList]', true, array('value' => $row->pembayaranpelayanan_id, 'class' => 'cek', 'onClick' => 'setCeklisPengajuan(this);'));
            ?>
        </td>
    <?php endif; ?>
    <td>
        <?php
        echo CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][pendaftaran_id]', $row->pendaftaran_id);
        echo CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][pasien_id]', $row->pasien_id);
        echo CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][pembayaranpelayanan_id]', $row->pembayaranpelayanan_id);
        echo CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][tandabuktibayar_id]', $row->tandabuktibayar_id);
        echo CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][carabayar_id]', $row->carabayar_id);
        echo CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][penjamin_id]', $row->penjamin_id);
        ?>
        <?php echo ($i + 1); ?></td>
    <td><?php echo MyFormatter::formatDateTimeForUser($row->pendaftaran->tgl_pendaftaran) . '/<br>' . $row->pendaftaran->no_pendaftaran; ?></td>
    <td><?php

        $label = '<u>' . MyFormatter::formatDateTimeForUser($row->tglpembayaran) . "<br>" . $row->nopembayaran . '</u>';

        echo CHtml::link($label, Yii::app()->createURL('/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar2', array(
            'pembayaranpelayanan_id' => $row->pembayaranpelayanan_id,
            'frame' => true,
        )), array(
            'target' => 'iframeRincian',
            'onclick' => '$("#dialogRincian").dialog("open");',
        ));

        ?></td>
    <td><?php echo $noPeserta; ?></td>
    <td><?php echo $row->pasien->no_rekam_medik; ?></td>
    <td><?php echo $instalasinama . ' / <br>' . $ruangannama; ?></td>
    <td><?php echo $row->pasien->nama_pasien; ?></td>
    <?php if ($text == true) : ?>
        <td><?php echo MyFormatter::formatNumberForPrint($row->totalbiayapelayanan, 2); ?></td>
        <td><?php echo MyFormatter::formatNumberForPrint($row->totalsisatagihan, 2); ?></td>
        <td><?php echo MyFormatter::formatNumberForPrint($row->uangditerima, 2); ?></td>
        <td><?php echo MyFormatter::formatNumberForPrint($row->totalbayartindakan, 2); ?></td>
        <td><?php echo MyFormatter::formatNumberForPrint($row->totalsisatagihan, 2); ?></td>
    <?php else : 
        
        $selisih = MyFormatter::formatNumberForPrint($selisih, 2);
        $jmltelahbayar = MyFormatter::formatNumberForPrint($jmltelahbayar, 2);
        $jmlpengajuan = MyFormatter::formatNumberForPrint($jmlpengajuan, 2);
        $jmlpengajuan = MyFormatter::formatNumberForPrint($jmlpengajuan, 2);
        
        ?>
        <td><?php echo CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][noreferensi]', '', array('class' => 'span2', 'style' => 'width: 100px;')); ?></td>
        <td><?php echo CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmltagihan]', $selisih, array('class' => 'span2 jmltagihan integer-decimal', 'readonly' => true, 'style' => 'width: 100px;')); ?></td>
        <td><?php echo CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmlbayar]', $jmltelahbayar, array('class' => 'span2 jmlbayar integer-decimal ', 'readonly' => true, 'style' => 'width: 100px;')); ?></td>
        <td><?php echo CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][nilai_diskon]', 0, array('class' => 'span2 nilai_diskon  integer-decimal ', 'onblur' => 'hitungDiskon();', 'style' => 'width: 100px;')); ?>
            <?php echo CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][discount]', $diskon, array('class' => 'span1 discount')); ?></td>
        <td>
            <?php echo CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmlpiutang]', $jmlpengajuan, array('readonly' => true, 'class' => 'span2 jmlpiutang integer-decimal ', 'style' => 'width: 100px;')) .
                CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][jmlpiutang2]', (empty($row->pembklaimdetal_id) ? $row->totalsisatagihan : $row->detailklaim->jmlpiutang), array('class' => 'span2 jmlpiutang2 integer-decimal')); ?>
        </td>
        <td><?php echo CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmlpengajuan]', $jmlpengajuan, array('class' => 'span2 jmlpengajuan integer-decimal ', 'onblur' => 'hitungPengajuan();', 'style' => 'width: 100px;')); ?></td>
        <td><?php echo CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmlsisapiutang]', 0, array('readonly' => true, 'class' => 'span2 jmlsisapiutang integer-decimal', 'style' => 'width: 100px;')); ?></td>
    <?php endif; ?>
</tr>