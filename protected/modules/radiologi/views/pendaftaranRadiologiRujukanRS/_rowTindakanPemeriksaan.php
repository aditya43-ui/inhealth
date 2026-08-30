<?php

if(!is_numeric($modTindakan->tarif_tindakan)) {
    $modTindakan->tarif_tindakan = (!empty($modTindakan->tarif_tindakan)) ? $modTindakan->tarif_tindakan : 0;
} else {
    $modTindakan->tarif_tindakan = (!empty($modTindakan->tarif_tindakan)) ? number_format(floatval($modTindakan->tarif_tindakan), "0", ".", ",") : 0;
}

?>

<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
    <span name="[ii][jenispemeriksaanrad_nama]" class="jenispemeriksaanrad_nama"><?php echo $modTindakan->jenispemeriksaanrad_nama ?></span>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <span name="[ii][pemeriksaanrad_nama]"><?php echo $modTindakan->daftartindakan_nama ?? (!empty($modTindakan->pemeriksaanrad_id) ? $modTindakan->pemeriksaanrad->pemeriksaanrad_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]pemeriksaanrad_id',array('readonly'=>true,'class'=>'span1 pemeriksaanrad_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1 daftartindakan_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]kelaspelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td class="tgl_rencana">
    <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modTindakan,
            'attribute' => '[ii]tgl_tindakan',
            'value' => null,
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 htpd tgl_tindakan tgl_tindakan_last required',
                // 'placeholder' => date('d M Y H:i:s'),
                'placeholder' => 'Pilih Tanggal Tindakan *',
            ),
        ));
    ?>
    </td>
    <td>
    <?= CHtml::activeCheckBox($modTindakan, '[ii]is_elektif', array('title'=>'Klik untuk masukan nama dokter luar.' , 'id' =>'', 'onclick' => "setElektif();", 'class' => 'is_elektif_row'))?>
    </td>
    <td class="tindakan_kode"><?php echo $modTindakan->daftartindakan->daftartindakan_kode ?? "-"; ?></td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span2 integer')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> hidden>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer col-sm-6')); ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'hapusPeriksa(this); return false;')); ?>
    </td>
</tr>
