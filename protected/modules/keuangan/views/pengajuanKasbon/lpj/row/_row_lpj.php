<?php
$i = !empty($i) ? $i : 0;
?>
<tr row-data="<?= $i ?>" class="baris">
    <td>
        <span class="nomor"><?= ($i + 1) ?></span>
    </td>
    <td>
        <div class="control-group">
            <?php
            echo CHtml::activeHiddenField($modLPJ, '[' . $i . ']lpj_id', ['class' => 'lpj_id']);
            echo CHtml::activeTextField($modLPJ, '[' . $i . ']perincian_pembayaran_lpj', ['class' => 'required span3 pembayaran_lpj']);
            ?>
        </div>
    </td>
    <td>
        <?php
        echo CHtml::activeTextField($modLPJ, '[' . $i . ']keterangan_lpj', ['class' => 'span3 keterangan_lpj']);
        ?>
    </td>
    <td>
        <?php
        echo CHtml::activeDropDownList($modLPJ, '[' . $i . ']kategori_lpj', LookupM::getItems('pengajuan_lpj'), ['empty' => '-- Pilih --', 'class' => 'span2 kategori_lpj']);
        ?>
    </td>

    <td>
        <div class="control-group">
            <?php
            echo CHtml::activeTextField($modLPJ, '[' . $i . ']jumlah', ['readonly' => false, 'class' => 'integer2 span1 jumlah required', 'onblur' => 'hitung_jumlah()']);
            ?>
        </div>
    </td>
    <td>
        <div class="control-group">
            <?php
            echo CHtml::activeTextField($modLPJ, '[' . $i . ']harga_satuan', ['readonly' => false, 'class' => 'integer2 span2 harga_satuan required', 'onblur' => 'hitung_jumlah()']);
            ?>
        </div>
    </td>
    <td>
        <?php
        echo CHtml::activeTextField($modLPJ, '[' . $i . ']sub_total', ['readonly' => false, 'class' => 'integer2 span3 sub_total', 'readonly' => true]);
        ?>
    </td>
    <td class='btn-ulang'>
        <?= CHtml::link("<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>", 'javascript:;', ['onclick' => 'set_action(this,"tambah");', 'class' => 'btn btn-primary btn-tambah', 'style' => 'padding:5px;margin-bottom:5px;']) ?>
        <br />
        <?= CHtml::link("<i class='" . MyIcon::getIcons('hapus-baris') . "'></i>", 'javascript:;', ['onclick' => 'hapus_baris(this);', 'class' => 'btn btn-danger btn-hapus', 'style' => 'padding:5px;']) ?>
    </td>
</tr>