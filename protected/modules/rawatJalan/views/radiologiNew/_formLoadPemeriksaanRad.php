<?php
$tarif = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0;
    $kode = $modTarif->kode_unik;
    ?>
    <tr id="periksarad_<?php echo $kode; ?>">
        <td>
            <?php echo $modTarif->jenispemeriksaanrad_nama; ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $modTarif->daftartindakan_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[pemeriksaanrad_id][]", $modTarif->pemeriksaanrad_id,array('class'=>'inputFormTabel lebar3 kode_unik_tr','readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[kode_unik][]", $kode,array('class'=>'inputFormTabel lebar3 kode_unik_tr','readonly'=>true)); ?>
            <?php // echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
        </td>
        <td>
            <?php
            echo $modTarif->pemeriksaanrad_nama;
            if (!empty($paket)) {
                echo '</br>(' . $paket->tipepaket_nama . ')';
            }
            ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[inputpemeriksaanrad][]", $modTarif->pemeriksaanrad_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
        </td>
        <td><?php
            echo CHtml::textField("permintaanPenunjang[inputqty][]", '1', array('readonly' => true, 'class' => 'inputFormTabel integer lebar1 qty span1', 'onkeyup' => 'hitungTotal();'));
            echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif, array('class' => 'inputFormTabel lebar3 integer tarif_satuan', 'readonly' => true));
        ?>

        </td>
        <!-- <td> -->
        <?php //echo MyFormatter::formatNumberForPrint($tarif);  ?>
        <?php //echo CHtml::textField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
        <!-- </td> -->
        <td hidden><?= MyFormatter::formatNumberForPrint($tarif); ?></td>       
        <td hidden>
            <?php //echo CHtml::checkBox("permintaanPenunjang[is_paket][]", false, array('class' => 'is_paket', 'checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);')) ?>
            <?php //echo CHtml::hiddenField("permintaanPenunjang[paket_true][]", "tidak", array('class'=>'inputFormTabel apa-cito apa-paket','readonly'=>true)); ?>
        </td> 
        <td>
            <?php echo CHtml::checkBox("permintaanPenunjang[is_cito][]", false, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);')) ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[cito_true][]", "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>
        </td>
        <td>
            <a class="" onclick="deletePemeriksaan(this)" type="button"><i class="icon-form-silang"></i></a>
        </td>

    </tr>
