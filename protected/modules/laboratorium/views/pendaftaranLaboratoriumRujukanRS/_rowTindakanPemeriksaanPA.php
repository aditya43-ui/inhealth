<?php

$modTindakan->tarif_tindakan = number_format($modTindakan->tarif_tindakan, "0", ".", ",");
$instalasi = Yii::app()->user->getState('instalasi_id');       
$pemeriksaanlab = PemeriksaanlabM::model()->find("daftartindakan_id = " . $modTindakan->daftartindakan_id);     

?>

<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::textField('no_urut',$i+1,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[' . $i . ']nopelayanan',array('readonly'=>true,'readonly'=>true,'class'=>'span2 integer')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <span name="[' . $i . '][pemeriksaanlab_nama]"><?php echo $pemeriksaanlab->pemeriksaanlab_nama; ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1 pemeriksaanlab_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']daftartindakan_id',array('readonly'=>true,'class'=>'span1 daftartindakan_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']kelaspelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[' . $i . ']satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>

    <td <?php if($instalasi == Params::INSTALASI_ID_LAB) {echo 'hidden';}?>>
        <?php echo CHtml::activeDropDownList($modTindakan, '[' . $i . ']samplelab_id', CHtml::listData(SamplelabM::model()->findAll("samplelab_aktif = TRUE ORDER BY samplelab_nama ASC"), 'samplelab_id', 'samplelab_nama'), array("class" => "span2", "onchange" => "", 'empty' => '-- Pilih --')) ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeDropDownList($modTindakan, '[' . $i . ']caraambilsampel_id', CHtml::listData(CaraambilsampelM::model()->findAll("caraambilsampel_aktif = TRUE ORDER BY caraambilsampel_nama ASC"), 'caraambilsampel_nama', 'caraambilsampel_nama'), array("class" => "span2", "onchange" => "", 'empty' => '-- Pilih --')) ?>
    </td>

    <td class="tindakan_kode"><?php echo $modTindakan->daftartindakan_kode ?? "-"; ?></td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[' . $i . ']tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span2 integer')); ?>
    </td>
   
    <td>
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'hapusPeriksa(this); return false;')); ?>
    </td>
</tr>
