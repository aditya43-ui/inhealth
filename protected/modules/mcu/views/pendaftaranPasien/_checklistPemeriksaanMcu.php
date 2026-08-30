<?php

/**
 * supply $modPemeriksaanmcus
 */
?>


<?php

$tipepaketsebelumnya = "";
$totaltarif = 0;
foreach ($modPemeriksaanmcus as $x => $pemeriksaanMCU) {
    $tipepaketsetelahnya = (isset($modPemeriksaanmcus[$x + 1]) ? $modPemeriksaanmcus[$x + 1]->tipepaket_id : $modPemeriksaanmcus[$x]->tipepaket_id);

?>
    <?php
    if ($pemeriksaanMCU->tipepaket_id != $tipepaketsebelumnya && $pemeriksaanMCU->tipepaket->tipepaket_aktif == true ) {
        $totaltarif = $totaltarif + $pemeriksaanMCU->tarifpaketpel;
    ?>
        <div class="col-sm-4">
            <?php
            echo '<label class="checkbox inline">' . CHtml::CheckBox('pilihSemua', '', array(
                'value' => $modPemeriksaanmcus[$x]->tipepaket_id,
                'onclick' => "pilihPemeriksaanSemua(this)", 'class' => 'pilih-paketpelayanan'
            )) . ' ' . $modPemeriksaanmcus[$x]->tipepaket->tipepaket_nama . ' - ' . MyFormatter::formatNumberForPrint($modPemeriksaanmcus[$x]->tipepaket->tarifpaket, 2) . "</label>";
            ?>
        </div>

<?php

    }
    if ($pemeriksaanMCU->tipepaket_id != $tipepaketsetelahnya) {
        // echo "</div>";
    }
    $tipepaketsebelumnya = $pemeriksaanMCU->tipepaket_id;
}
?>