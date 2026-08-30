<?php
$konfigFarmasi = KonfigfarmasiK::model()->find();
$isKondisi = false;
if (!empty($konfigFarmasi) && $konfigFarmasi->ishargaperpenjamin) {
    $isKondisi = true;
}
?>
<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut', 0, array('readonly' => true, 'class' => 'integer2', 'style' => 'width:40px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]r', array('readonly' => true, 'style' => 'width:20px;')); ?>
        <span id="isi-r" name="[ii][isi_r]">R/</span>
    </td>
    <td>
        <span name="resep_ke" class="resep_ke"><?php echo $modDetail->rke ?></span>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]satuan_permintaandosis', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]satuankecil_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]rke', array('readonly' => true, 'style' => 'width:40px;', 'class' => 'rke')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]paketobatdetail_id', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'paketobatdetail_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]racikan_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]obatalkes_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]is_permintaandosispecahan', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]permintaandosis_pembilang', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]permintaandosis_penyebut', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]sediaan', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]frekuensi', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]dosis', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]resepturketerangan', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]etiketwaktu', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <span name="[ii][obatalkes_kode]" class="obatalkes_kode"><?php echo $modDetail->obatalkes_kode ?></span> /<br>
        <span name="[ii][obatalkes_nama]" class="obatalkes_nama"><?php echo $modDetail->obatalkes_nama ?></span>

    </td>
    <?php if(!empty($modDetail->obatlain_nama)){?>
        <td>
            <?php echo CHtml::activeTextArea($modDetail, '[ii]obatlain_nama', array('class' => 'obatlain span3')); ?>
        </td>
    <?php }else{?>
        <td>
            <?php echo CHtml::activeTextArea($modDetail, '[ii]obatlain_nama', array('readonly'=>true,'class' => 'obatlain span3')); ?>
        </td>
    <?php }?>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]temp_permintaan_dosis', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]permintaan_dosis', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'permintaan_dosis')); ?>
        <?php echo CHtml::activeHiddenField($modDetail, '[ii]satuankekuatan', array('readonly' => true, 'style' => 'width:110px;')); ?>
        <span class="satuankekuatan" name="[ii][satuan]">
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]jumlah', array('class' => 'qty_stok', 'readonly' => true, 'style' => 'width:50px;', 'title' => 'Jumlah Obat'));
        echo " " . $modDetail->obatalkes->satuankecil->satuankecil_nama;
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]signa_oa', array('readonly' => true, 'style' => 'width:50px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]etiket', array('readonly' => true, 'style' => 'width:180px;', 'class' => 'span6')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]jml_permintaan', array('readonly' => true, 'style' => 'width:110px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]satuan_jmlpermintaan', array('readonly' => true, 'style' => 'width:110px;', 'class' => 'satuan_jmlpermintaan')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modDetail, '[ii]resepturketerangan', array('class' => 'keterangan span3')); ?>
    </td>
    <td>
        <center>
            <a onclick="editObatAlkesPasienDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk edit penjualan obat alkes ini"><i class="icon-eye-open"></i></a>
        </center>
    </td>
    <td>
        <center>
            <a onclick="hapusObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk obat ini"><i class="entypo-trash"></i></a>
        </center>
    </td>
</tr>