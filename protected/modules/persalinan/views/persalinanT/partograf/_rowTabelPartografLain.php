<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - mengenerate data ke tabel partograf lain - lain, per baris
 * @website     <http://> 
 * RSST-1603
 */
?>

<tr>
    <td>
        <span class="nourut hide"></span>
        <label class="lbl-pendarahan">
            <?php echo $model->pendarahan ?>
        </label>
        <?php
        echo CHtml::activeHiddenField($model, '[' . $i . ']nourutlain', array('readonly' => true, 'class' => 'nourut-data'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']pemeriksaanpartograflain_id', array('readonly' => true, 'class' => 'id'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']pendarahan', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']diagnosis_obstetri', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']diagnosis_nonobstetri', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']diagnosis_janin', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']dokter_id', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']intruksi_dokter', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']bidan_id', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']catatan_bidan', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']perawat_id', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']catatan_perawat', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']oksigen', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']cairan_infus', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']laboratorium', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']oksitosin', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']produksi_urine', array('readonly' => true));

        ?>
    </td>
    <td>
        <label class="lbl-obstetri">
            <?php echo $model->diagnosis_obstetri; ?>
        </label>
    </td>
    <td>
        <label class="lbl-nonobstetri">
            <?php echo $model->diagnosis_nonobstetri; ?>
        </label>
    </td>
    <td>
        <label class="lbl-janin">
            <?php echo $model->diagnosis_janin; ?>
        </label>
    </td>
    <td>
        <label class="lbl-dokter">
            <?php echo $model->dokter_nama; ?>
        </label>
    </td>
    <td>
        <label class="lbl-insdokter">
            <?php echo $model->intruksi_dokter; ?>
        </label>
    </td>
    <td>
        <label class="lbl-bidan">
            <?php echo $model->bidan_nama; ?>
        </label>
    </td>
    <td>
        <label class="lbl-catbidan">
            <?php echo $model->catatan_bidan; ?>
        </label>
    </td>
    <td>
        <label class="lbl-perawat">
            <?php echo $model->perawat_nama; ?>
        </label>
    </td>
    <td>
        <label class="lbl-catperawat">
            <?php echo $model->catatan_perawat; ?>
        </label>
    </td>
    <td>
        <label class="lbl-oksigen">
            <?php echo $model->oksigen; ?>
        </label>
    </td>
    <td>
        <label class="lbl-oksitosin">
            <?php echo $model->oksitosin; ?>
        </label>
    </td>
    <td>
        <label class="lbl-cairaninfus">
            <?php echo $model->cairan_infus; ?>
        </label>
    </td>

    <td>
        <label class="lbl-produksiurine">
            <?php echo $model->produksi_urine; ?>
        </label>
    </td>
    <td>
        <label class="lbl-laboratorium">
            <?php echo $model->laboratorium; ?>
        </label>
    </td>


    <td>
        <?php
        echo CHtml::link("<span style='font-size:15px;'><i class='" . MyIcon::getIcons('ubah') . "'></i></span>", "javascript:;", array('onclick' => 'generateForm(this,"lainlain");'));
        ?>
    </td>
    <td>
        <?php
        echo CHtml::link("<span style='font-size:15px;'><i class='" . MyIcon::getIcons('hapus') . "'></i></span>", "javascript:;", array('onclick' => 'hapusBaris(this,"lainlain");'));
        ?>
    </td>
</tr>