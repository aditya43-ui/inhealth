<?php

if(!is_string($modTindakan->tarif_tindakan)) {
    $modTindakan->tarif_tindakan = number_format($modTindakan->tarif_tindakan, "0", ".", ",");
}

$pemeriksaanlab = PemeriksaanlabM::model()->find("daftartindakan_id = $modTindakan->daftartindakan_id");
if(!empty($modTindakan->daftartindakan->daftartindakan_kode)) {
    $pemeriksaanlab = PemeriksaanlabM::model()->find("daftartindakan_id = $modTindakan->daftartindakan_id and pemeriksaanlab_kode = '" . $modTindakan->daftartindakan->daftartindakan_kode . "'");

}
$instalasi = Yii::app()->user->getState('instalasi_id');            

?>

<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]nopelayanan',array('readonly'=>true,'readonly'=>true,'class'=>'span2 integer')); ?>
    </td>
    <td>
     <span name="[ii][jenispemeriksaanlab_nama]"><?php echo (!empty($pemeriksaanlab) ? $pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama : "-") ?></span>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($pemeriksaanlab) ? $pemeriksaanlab->pemeriksaanlab_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1 pemeriksaanlab_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1 daftartindakan_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]kelaspelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>

    <td <?php if($instalasi == Params::INSTALASI_ID_LAB) {echo 'hidden';}?>>
        <?php echo CHtml::activeDropDownList($modTindakan, '[ii]samplelab_id', CHtml::listData(SamplelabM::model()->findAll("samplelab_aktif = TRUE ORDER BY samplelab_nama ASC"), 'samplelab_id', 'samplelab_nama'), array("class" => "span2", "onchange" => "", 'empty' => '-- Pilih --')) ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeDropDownList($modTindakan, '[ii]caraambilsampel_id', CHtml::listData(CaraambilsampelM::model()->findAll("caraambilsampel_aktif = TRUE ORDER BY caraambilsampel_nama ASC"), 'caraambilsampel_nama', 'caraambilsampel_nama'), array("class" => "span2", "onchange" => "", 'empty' => '-- Pilih --')) ?>
    </td>

    <td class="tindakan_kode"><?php echo $modTindakan->daftartindakan->daftartindakan_kode ?? "-"; ?></td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span2 integer')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> hidden>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span2')); ?>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer col-sm-6')); ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-form-silang" style="cursor: not-allowed;"></i>', '#', array('style' => 'opacity: 0.6;', 'onclick'=>'return false;')); ?>
    </td>
</tr>
