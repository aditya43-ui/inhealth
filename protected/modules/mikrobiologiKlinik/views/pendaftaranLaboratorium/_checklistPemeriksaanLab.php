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

                
                $daftartindakan = DaftartindakanM::model()->find(" daftartindakan_id = " . $pemeriksaanLab->daftartindakan_id);

                $nama_tindakan = str_replace("'", "''", $daftartindakan->daftartindakan_nama);


                $c2 = new CDbCriteria;
                $c2->select = 'harga_tariftindakan';
                $c2->addCondition(" daftartindakan_nama = '$nama_tindakan' and kelaspelayanan_id in (5, 6) order by kelaspelayanan_id asc");
                $perda = TariftindakanperdaruanganV::model()->find($c2);

                $pemeriksaanLab->harga_tariftindakan = !empty($perda) ? $perda->harga_tariftindakan : null;

                // $jenistarif_id = null;
                // if ($tindakanpelayanan) {
                //     $penjamin = JenistarifpenjaminM::model()->findByAttributes(['penjamin_id' => $modPermintaan->tindakanpelayanan_id]);
                //     if (!empty($penjamin)) {
                //         $jenistarif_id = $penjamin->jenistarif_id;
                //     }
                // }

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