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
        <label class="lbl-periksake">
            <?php echo $model->pemeriksaan_ke; ?>
        </label>
        <?php
        echo CHtml::activeHiddenField($model, '[' . $i . ']nourutlain', array('readonly' => true, 'class' => 'nourut-data'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']pemeriksaanpartografdet_id', array('readonly' => true, 'class' => 'id'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']pemeriksaan_ke', array('readonly' => true, 'class' => 'periksa_ke'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']waktucatat', array('readonly' => true, 'class' => 'kontrol-waktu'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p3_waktu', array('readonly' => true, 'class' => 'waktuperjam'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p1_djj_menit', array('readonly' => true, 'class' => 'kontrol-djj'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p2_penyusupan', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p3_pembukaanserviks', array('readonly' => true, 'class' => 'kontrol-serviks'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p3_turunnyakepala', array('readonly' => true, 'class' => 'kontrol-kepala'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p4_kontraksi_jml', array('readonly' => true, 'class' => 'kontrol-kontraksijml'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p4_kontraksi_lama_detik', array('readonly' => true, 'class' => 'kontrol-kontraksilama'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p5_oksitosin_unit', array('readonly' => true, 'class' => 'kontrol-oksitosinunit'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p5_tetes_menit', array('readonly' => true, 'class' => 'kontrol-tetesmenit'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']penepisan', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']respirasi', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']perlunakan', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']skor_pelvik', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p2_airketuban', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']gcs_eye', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']gcs_verbal', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']gcs_motorik', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']gcs_totalskor', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p6_systolic', array('readonly' => true, 'class' => 'kontrol-systolic'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p6_diastolic', array('readonly' => true, 'class' => 'kontrol-diastolic'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p6_nadi', array('readonly' => true, 'class' => 'kontrol-nadi'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p7_suhu', array('readonly' => true, 'class' => 'kontrol-suhu'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p8_urin_protein', array('readonly' => true, 'class' => 'kontrol-urinprotein'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p8_urin_aseton', array('readonly' => true, 'class' => 'kontrol-urinaseton'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']p8_urin_volume', array('readonly' => true, 'class' => 'kontrol-urinvolume'));
        echo CHtml::activeHiddenField($model, '[' . $i . ']center_venous_pressure', array('readonly' => true));
        echo CHtml::activeHiddenField($model, '[' . $i . ']qty_oa', array('readonly' => true));
        ?>
    </td>
    <td>
        <label class="lbl-waktu">
            <?php echo $model->waktucatat; ?>
        </label>
    </td>
    <td>
        <label class="lbl-djj">
            <?php echo $model->p1_djj_menit; ?>
        </label>
    </td>
    <td>
        <label class="lbl-penyisipan">
            <?php echo $model->p2_penyusupan; ?>
        </label>
    </td>
    <td>
        <label class="lbl-pembukaanserviks">
            <?php echo $model->p3_pembukaanserviks; ?>
        </label>
    </td>
    <td>
        <label class="lbl-turunyakepalajanin">
            <?php echo $model->p3_turunnyakepala; ?>
        </label>
    </td>
    <td>
        <label class="lbl-jmlkontraksi">
            <?php echo $model->p4_kontraksi_jml; ?>
        </label>
    </td>
    <td>
        <label class="lbl-lamakontraksi">
            <?php echo $model->p4_kontraksi_lama_detik; ?>
        </label>
    </td>
    <td>
        <label class="lbl-penepisan">
            <?php echo $model->penepisan; ?>
        </label>
    </td>
    <td>
        <label class="lbl-perlunakan">
            <?php echo $model->perlunakan; ?>
        </label>
    </td>
    <td>
        <label class="lbl-skorpelvik">
            <?php echo $model->skor_pelvik; ?>
        </label>
    </td>
    <td>
        <label class="lbl-ketuban">
            <?php echo $model->p2_airketuban; ?>
        </label>
    </td>
    <td>
        <label class="lbl-respirasi">
            <?php echo $model->respirasi; ?>
        </label>
    </td>
    <td>
        <label class="lbl-gcseye">
            <?php echo $model->gcs_eye; ?>
        </label>
    </td>
    <td>
        <label class="lbl-gcsverbal">
            <?php echo $model->gcs_verbal; ?>
        </label>
    </td>
    <td>
        <label class="lbl-gcsmotorik">
            <?php echo $model->gcs_motorik; ?>
        </label>
    </td>
    <td>
        <label class="lbl-sistol">
            <?php echo $model->p6_systolic; ?>
        </label>
    </td>
    <td>
        <label class="lbl-diastol">
            <?php echo $model->p6_diastolic; ?>
        </label>
    </td>
    <td>
        <label class="lbl-nadi">
            <?php echo $model->p6_nadi; ?>
        </label>
    </td>
    <td>
        <label class="lbl-suhu">
            <?php echo $model->p7_suhu; ?>
        </label>
    </td>
    <td>
        <label class="lbl-oksitosin">
            <?php echo $model->p5_oksitosin_unit; ?>
        </label>
    </td>
    <td>
        <label class="lbl-tetesmenit">
            <?php echo $model->p5_tetes_menit; ?>
        </label>
    </td>
    <td>
        <label class="lbl-urinprotein">
            <?php echo $model->p8_urin_protein; ?>
        </label>
    </td>
    <td>
        <label class="lbl-urinaseton">
            <?php echo $model->p8_urin_aseton; ?>
        </label>
    </td>
    <td>
        <label class="lbl-urinvolume">
            <?php echo $model->p8_urin_volume; ?>
        </label>
    </td>
    <td>
        <?php
        if (count((array)$arr_oa) > 0) {
            echo "<ul>";
            foreach ($arr_oa as $id => $qty) {
                echo "<li>";
                $oa = ObatalkesM::model()->findByPk($id);
                echo $oa->obatalkes_nama . " (" . $qty . " " . $oa->satuankecil->satuankecil_nama . ")";
                echo "</li>";
            }
            echo "</ul>";
        }


        ?>
    </td>
    <td>
        <?php
        echo CHtml::link("<span style='font-size:15px;'><i class='" . MyIcon::getIcons('ubah') . "'></i></span>", "javascript:;", array('onclick' => 'generateForm(this,"kontrol");'));
        ?>
    </td>
    <td>
        <?php
        echo CHtml::link("<span style='font-size:15px;'><i class='" . MyIcon::getIcons('hapus') . "'></i></span>", "javascript:;", array('onclick' => 'hapusBaris(this,"kontrol");'));
        ?>
    </td>
</tr>