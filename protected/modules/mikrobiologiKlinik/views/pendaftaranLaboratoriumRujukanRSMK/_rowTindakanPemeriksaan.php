<?php

$modTindakan->tarif_tindakan = number_format($modTindakan->tarif_tindakan, "0", ".", ",");
$instalasi = Yii::app()->user->getState('instalasi_id'); 

$sama = isset($sama) ?  $sama : "beda";

$pg = isset($program) ? $program : 'non';

?>

<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> class="tr-<?= $sama ?>">
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>  class="td-nourut" rowspan="1" style="vertical-align:middle;">
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer nourut', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::hiddenField('LBTindakanPelayananT[ii][is_hide]',0,array('readonly'=>true,'class'=>'span1 integer is-hide', 'style'=>'width:20px;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>  class="td-nopel" rowspan="1" style="vertical-align:middle;">
        <?php echo CHtml::activeTextField($modTindakan,'[ii]nopelayanan',array('readonly'=> $pg == 'non', 'data-pg'=>$pg, 'class'=>'span2')); ?>
    </td>
    <td class="td-jenis" rowspan="1" style="vertical-align:middle;">
        <?php
           $jenispemeriksaan = isset($modTindakan->pemeriksaanlab_id) ? $modTindakan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama : "";

           if(!empty($modTindakan->jenispemeriksaanlab_id)) {
               $jenispemeriksaan = $modTindakan->jenispemeriksaanlab->jenispemeriksaanlab_nama;
           }
        ?>
        <?php echo $jenispemeriksaan ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo $modTindakan->daftartindakan_nama ?? "-" ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenispemeriksaanlab_id',array('readonly'=>true,'class'=>'span1 jenispemeriksaanlab_id')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1 pemeriksaanlab_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1 daftartindakan_id_dialog')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]kelaspelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>

    <td class="td-sample" rowspan="1" style="vertical-align:middle;">
        <?php echo CHtml::activeDropDownList($modTindakan, '[ii]samplelab_id', CHtml::listData(SamplelabM::model()->findAll("samplelab_aktif = TRUE ORDER BY samplelab_nama ASC"), 'samplelab_id', 'samplelab_nama'), array("class" => "span2 row_samplelab_id required", "onchange" => "", 'empty' => '-- Pilih --')) ?>
    </td>
    <td class="td-caraambil" rowspan="1" style="vertical-align:middle;">
        <?php echo CHtml::activeDropDownList($modTindakan, '[ii]caraambilsampel_id', CHtml::listData(CaraambilsampelM::model()->findAll("caraambilsampel_aktif = TRUE ORDER BY caraambilsampel_nama ASC"), 'caraambilsampel_id', 'caraambilsampel_nama'), array("class" => "span2 row_caraambilsampel_id", "onchange" => "", 'empty' => '-- Pilih --')) ?>
    </td>

    <td class="tindakan_kode"><?php echo $modTindakan->daftartindakan->daftartindakan_kode ?? "-"; ?></td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer', 'style'=>'text-align: right;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer col-sm-6 span2', 'style'=>'text-align: right;')); ?>
    </td>
    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span2 integer', 'style'=>'text-align: right;')); ?>
    </td>


    <td <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00 !important;" <?php } ?> <?php if($instalasi !== Params::INSTALASI_ID_LAB) {echo 'hidden';}?>>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    
    <td class="td-hapus td-hapus-baru td-hapus-<?= isset($modTindakan->pemeriksaanlab_id) ? $modTindakan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_id : "" ?>" rowspan="1" style="vertical-align:middle;">
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', 'javascript:void(0);', array('onclick'=>'hapusPeriksa(this, ' . (isset($modTindakan->pemeriksaanlab_id) ? $modTindakan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_id : "") .  '); return false;')); ?>
    </td>
</tr>
