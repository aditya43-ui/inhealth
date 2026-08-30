<?php

$bantuan_item = array(
    'Bantuan Minimal' => 'Bantuan Minimal',
    'Bantuan Total' => 'Bantuan Total'
);

$yatidak_item = array(
    1 => 'Ya',
    0 => 'Tidak',
);

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Kebutuhan Persiapan Pulang
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <table class='form_predispo'>
                    <tr>
                        <td width='10'><label>1.</label></td>
                        <td width='200'><label>Makan</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_makan', $bantuan_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>2.</label></td>
                        <td><label>BAB/BAK</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_bab', $bantuan_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>Jelaskan</label></td>
                        <td>
                            <?php echo $form->textArea($model, 'kebutuhanpulang_penjelasan_makanbab', array('rows' => 2)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'kebutuhanpulang_masalahkeperawatan_makanbab'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>3.</label></td>
                        <td><label>Mandi</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_mandi', $bantuan_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>4.</label></td>
                        <td><label>Berpakaian/berhias</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_berpakaian', $bantuan_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>5.</label></td>
                        <td><label>Istirahat</label></td>
                        <td>
                            <?php echo $form->checkBox($model, 'kebutuhanpulang_istirahat[siang_lama][nilai]', array(
                                'value' => '1', 'uncheckValue' => null,
                            )); ?>
                            <label>Tidur Siang Lama :</label>
                            <?php echo $form->textField($model, 'kebutuhanpulang_istirahat[siang_lama][awal]', array('class' => 'span1')); ?>
                            <label>s/d</label>
                            <?php echo $form->textField($model, 'kebutuhanpulang_istirahat[siang_lama][akhir]', array('class' => 'span1')); ?>
                            <br>
                            <?php echo $form->checkBox($model, 'kebutuhanpulang_istirahat[malam_lama][nilai]', array(
                                'value' => '1', 'uncheckValue' => null,
                            )); ?>
                            <label>Tidur Malam Lama :</label>
                            <?php echo $form->textField($model, 'kebutuhanpulang_istirahat[malam_lama][awal]', array('class' => 'span1')); ?>
                            <label>s/d</label>
                            <?php echo $form->textField($model, 'kebutuhanpulang_istirahat[malam_lama][akhir]', array('class' => 'span1')); ?>
                            <br>
                            <?php echo $form->checkBox($model, 'kebutuhanpulang_istirahat[kegiatan][nilai]', array(
                                'value' => '1', 'uncheckValue' => null,
                            )); ?>
                            <label>Kegiatan sebelum/sesudah tidur</label>
                        </td>
                    </tr>
                    <tr>
                        <td><label>6.</label></td>
                        <td><label>Penggunaan Obat</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_penggunaanobat', $bantuan_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class='form_predispo'>
                    <tr>
                        <td><label>7.</label></td>
                        <td><label>Pemeliharaan Kesehatan</label></td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Perawatan Lanjutan</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_pemeliharaankesehatan_lanjutan', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Perawatan Pendukung</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_pemeliharaankesehatan_pendukung', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>8.</label></td>
                        <td><label>Kegiatan di dalam rumah</label></td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Memperisapkan Makanan</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_kegiatanrumah_makanan', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Menjaga kerapihan rumah</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_kegiatanrumah_kerapihan', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Mencuci Pakaian</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_kegiatanrumah_mencuci', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Pengaturan Keuangan</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_kegiatanrumah_keuangan', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>9.</label></td>
                        <td><label>Kegiatan di luar rumah</label></td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Belanja</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_kegiatanluarrumah_belanja', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Transportasi</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_kegiatanluarrumah_transportasi', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label></label></td>
                        <td><label>Lain-lain</label></td>
                        <td>
                            <?php echo $form->RadioButtonList($model, 'kebutuhanpulang_kegiatanluarrumah_lain2', $yatidak_item, array(
                                'template' => '{input}{label}&nbsp;&nbsp;', 'uncheckValue' => null,
                            )); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>Jelaskan</label></td>
                        <td>
                            <?php echo $form->textArea($model, 'kebutuhanpulang_penjelasan', array('rows' => 2)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label><b>Masalah Keperawatan</b></label></td>
                        <td>
                            <?php echo $form->textArea($model, 'kebutuhanpulang_masalahkeperawatan'); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>