

<tr>
    <td><?php
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']jenisspesimen_pa_id');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']jenisspesimen_pa_lainnya');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']teknikpengambilanspesimen_lainnya');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']teknikpengambilanspesimen_id');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']lokasipengambilanspesimen');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']volumespesimen');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']statuskirim_pa');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']tujuanpengirimanspesimen_lainnya');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']kualifikasi_operasi');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']kualifikasiluka_operasi');
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']indikasi_operasi');
    $id_periksa = empty($mod->permintaanPeriksa) ? "" : implode(",", $mod->permintaanPeriksa);
    echo CHtml::activeHiddenField($mod, '[detail]['.$idx.']permintaanPeriksa', array(
        'value'=>$id_periksa,
    ));

    if ($mod->jenisspesimen_pa_id == 3) {
        echo $mod->jenisspesimen_pa_lainnya;
    } else {
        $jenis = JenisspesimenPaM::model()->findByPk($mod->jenisspesimen_pa_id);
        echo empty($jenis) ? "" : $jenis->jenisspesimen_pa_nama;
    }


    ?></td>
    <td><?php
    $teknik = TeknikpengambilanspesimenM::model()->findByPk($mod->teknikpengambilanspesimen_id);
    if ($mod->teknikpengambilanspesimen_id == 4) {
        echo $mod->teknikpengambilanspesimen_lainnya;
    } else {
        $jenis = TeknikpengambilanspesimenM::model()->findByPk($mod->teknikpengambilanspesimen_id);
        echo empty($jenis) ? "" : $jenis->teknikpengambilanspesimen_nama;
    }
    //echo empty($teknik) ? "" : $teknik->teknikpengambilanspesimen_nama;

    ?></td>
    <td><?php echo $mod->lokasipengambilanspesimen; ?></td>
    <td><?php echo $mod->volumespesimen; ?></td>
    <td><?php echo $mod->statuskirim_pa;
        if ($mod->statuskirim_pa == "Tidak") {
            echo ", ".$mod->tujuanpengirimanspesimen_lainnya;
        }
    ?></td>
    <td>
        <?php

        if (!empty($mod->permintaanPeriksa) && count($mod->permintaanPeriksa) > 0) {
            echo "<ul>";
            foreach ($mod->permintaanPeriksa as $item) {
                $periksa = PemeriksaanlabM::model()->findByPk($item);
                if (!empty($periksa)) {
                    echo "<li>".$periksa->pemeriksaanlab_nama."</li>";
                }
            }
            echo "</ul>";
        }

        ?>
    </td>
    <td><?php echo $mod->kualifikasi_operasi; ?></td>
    <td><?php echo $mod->kualifikasiluka_operasi; ?></td>
    <td><?php echo $mod->indikasi_operasi; ?></td>
    <?php if (empty($no_hapus) || $no_hapus != true) : ?>
    <td>
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'hapusItemJaringan(this); return false;'
        )); ?>
    </td>
    <?php endif; ?>
</tr>
