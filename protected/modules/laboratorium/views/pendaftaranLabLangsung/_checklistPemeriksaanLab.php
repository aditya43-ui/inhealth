<?php

/**
 * supply @modPemeriksaanLabs
 */
?>

<style>
    .panel-default {
        margin-bottom: 17px !important;
    }
</style>

<fieldset>
    <div class="checkboxlist-tile">
        <?php

        $jenispemeriksaansebelum = "";
        $modPemeriksaanlabsRes = array();
        foreach ($modPemeriksaanlabs as $x => $pemeriksaanLab) {
            if (empty($modPemeriksaanlabsRes[$pemeriksaanLab->jenispemeriksaanlab_id])) {
                $modPemeriksaanlabsRes[$pemeriksaanLab->jenispemeriksaanlab_id] = array(
                    'nama' => $pemeriksaanLab->jenispemeriksaanlab_nama,
                    'detail' => array()
                );
            }

            $modPemeriksaanlabsRes[$pemeriksaanLab->jenispemeriksaanlab_id]['detail'][] = $pemeriksaanLab;
        }

        foreach ($modPemeriksaanlabsRes as $jenis) {
            echo '<div class="panel panel-default boxtindakan">';
            echo '<div class="panel-heading"><div class="panel-title">';
            echo "<h6 style='color: #fff !important;'>" . $jenis['nama'] . "</h6>";
            echo '</div></div>';
            echo '<div class="panel-body">';

            foreach ($jenis['detail'] as $x => $pemeriksaanLab) {

                echo '<label class="checkbox inline">' . CHtml::activeCheckBox($pemeriksaanLab, '[' . $pemeriksaanLab->pemeriksaanlab_id . ']is_pilih', array(
                    'value' => $pemeriksaanLab->pemeriksaanlab_id,
                    'onclick' => "pilihPemeriksaanIni(this)"
                ));
                echo '<span>' . $pemeriksaanLab->pemeriksaanlab_nama . '</span>';
                echo CHtml::activeHiddenField($pemeriksaanLab, '[' . $pemeriksaanLab->pemeriksaanlab_id . ']jenispemeriksaanlab_id', array('readonly' => true, 'class' => 'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab, '[' . $pemeriksaanLab->pemeriksaanlab_id . ']pemeriksaanlab_nama', array('readonly' => true, 'class' => 'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab, '[' . $pemeriksaanLab->pemeriksaanlab_id . ']daftartindakan_id', array('readonly' => true, 'class' => 'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab, '[' . $pemeriksaanLab->pemeriksaanlab_id . ']harga_tariftindakan', array('readonly' => true, 'class' => 'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab, '[' . $pemeriksaanLab->pemeriksaanlab_id . ']jenistarif_id', array('readonly' => true, 'class' => 'span1'));
                echo "</label><br>";
            }

            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</fieldset>