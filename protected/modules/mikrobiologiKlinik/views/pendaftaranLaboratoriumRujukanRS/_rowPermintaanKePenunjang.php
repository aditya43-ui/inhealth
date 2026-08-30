<?php
$kirim = PasienkirimkeunitlainT::model()->findByPk($modPermintaan->pasienkirimkeunitlain_id);
if (empty($tindakan)) {

    $pemeriksaan = MKTarifpemeriksaanlabruanganV::model()->findByAttributes(array(
        'daftartindakan_id' => $modPermintaan->daftartindakan_id,
        'ruangan_id' => $kirim->ruangan_id,
        'penjamin_id' => $kirim->pendaftaran->penjamin_id,
        'kelaspelayanan_id' => $kirim->kelaspelayanan_id,
    ));

    $modTindakan = new MKTindakanPelayananT();
    if (!empty($pemeriksaan) && empty($modPermintaan->tindakanpelayanan_id) ) {
        $modTindakan->daftartindakan_id = $pemeriksaan->daftartindakan_id;
        $modTindakan->pemeriksaanlab_id = $pemeriksaan->pemeriksaanlab_id;
        $modTindakan->jenistarif_id = $pemeriksaan->jenistarif_id;
        $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
        $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
        $modTindakan->tarif_satuan = $pemeriksaan->harga_tariftindakan;
        $modTindakan->tarif_tindakan = $pemeriksaan->harga_tariftindakan * $modTindakan->qty_tindakan;
    }else{
        $modTindakan = MKTindakanPelayananT::model()->findByPk($modPermintaan->tindakanpelayanan_id);
    }
}
?>
<tr>
     <td style="text-align: center"> <?= $i;?></td>
    <td>
        <?= $modSpesimen['samplelab_nama'];?>
        <?php echo CHtml::activeHiddenField($modPermintaan, '[' . $i . ']permintaankepenunjang_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan, '[' . $i . ']pemeriksaanlab_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan, '[' . $i . ']daftartindakan_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan, '[' . $i . ']tindakanpelayanan_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaan, '[' . $i . ']tindakanpelayanan_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']tindakanpelayanan_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']tindakansudahbayar_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']pemeriksaanlab_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']daftartindakan_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']jenistarif_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']qty_tindakan', array('readonly' => true, 'onkeyup' => 'hitungTotal(this);', 'class' => 'span1 integer')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']satuantindakan', array('readonly' => true, 'class' => 'span2')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']tarif_satuan', array('readonly' => true, 'class' => 'span2 integer')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']tarif_tindakan', array('readonly' => true, 'readonly' => true, 'class' => 'span1 integer', 'style' => 'width:96px')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[' . $i . ']spesimen_id', array('value' => $modSpesimen['spesimen_id'], 'readonly' => true, 'readonly' => true, 'class' => 'span1 integer', 'style' => 'width:96px')); ?>
    </td>
    <td>
        <?= $modSpesimen['pemeriksaanlab_nama'];?>
        <?php echo CHtml::activeHiddenField($modPermintaan, '[' . $i . '][ii]qtypermintaan', array('readonly' => true, 'onkeyup' => 'hitungTotal(this);', 'class' => 'span1 integer')); ?>
    </td>
    <td> <?= $modSpesimen['status'];?></td>
    <td> <?= $modSpesimen['kualitas_spesimen'];?></td>
    <td> <?= $modSpesimen['alasan'];?></td>
</tr>