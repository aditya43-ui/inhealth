<?php

// var_dump($item->attributes); die;

$periksa = PemeriksaanradM::model()->findByPk($item->pemeriksaanrad_id);
$tarif = (!empty($item->tarif_pelayananan)) ? $item->tarif_pelayananan : 0;
    $kode = $periksa->kode_unik;
    ?>
    <tr id="periksarad_<?php echo $kode; ?>">
        <td>
            <?php echo $periksa->jenispemeriksaanrad->jenispemeriksaanrad_nama ?? "-"; ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[idDaftarTindakan][]", $item->daftartindakan_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif','readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[kode_unik][]", $kode,array('class'=>'inputFormTabel lebar3 kode_unik_tr','readonly'=>true)); ?>
            <?php // echo CHtml::hiddenField("permintaanPenunjang[tindakanpelayanan_id][]", $id_tindakan); ?>
        </td>
        <td>
            <?php
            echo $item->pemeriksaanrad->pemeriksaanrad_nama;
            if (!empty($paket)) {
                echo '</br>(' . $paket->tipepaket_nama . ')';
            }
            ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[inputpemeriksaanrad][]", $item->pemeriksaanrad_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
        </td>
        <td><?php
            echo CHtml::textField("permintaanPenunjang[inputqty][]", '1', array('readonly' => true, 'class' => 'inputFormTabel integer lebar1 qty span1', 'onkeyup' => 'hitungTotal();'));
          //  echo CHtml::hiddenField("permintaanPenunjang[inputtarifpemeriksaanrad][]", $tarif, array('class' => 'inputFormTabel lebar3 integer tarif_satuan', 'readonly' => true));
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
            <?php echo CHtml::checkBox("permintaanPenunjang[is_cito][]", $item->is_cito, array('checkValue'=>0, 'checkValue'=>1, 'onchange' => 'setTrue(this);')) ?>
            <?php echo CHtml::hiddenField("permintaanPenunjang[cito_true][]", $item->is_cito ? "ya" : "tidak", array('class'=>'inputFormTabel apa-cito','readonly'=>true)); ?>
        </td>

    </tr>
