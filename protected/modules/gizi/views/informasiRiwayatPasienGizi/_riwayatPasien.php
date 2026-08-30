<?php
$this->breadcrumbs = array(
    'Informasi Riwayat Pasien' => Yii::app()->request->getUrlReferrer(),
    'Informasi Riwayat Pasien Gizi'
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Riwayat Pasien Gizi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial('_ringkasDataPasien', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pasien Gizi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->renderPartial('/_periksaDataPasien/_riwayatPasien', array(
                    'pages' => $pages,
                    'modKunjungan' => $modKunjungan,
                ));
                ?>
                <table class="items table table-striped table-bordered table-condensed" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tgl. Pendaftaran</th>
                            <th>Tgl. Anamnesis</th>
                            <th>Waktu Makan</th>
                            <th>Menu</th>
                            <th>Bahan Makanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count((array)$modAnamnesa) > 0) {
                            foreach ($modAnamnesa as $key => $detail) {
                        ?>
                                <tr>
                                    <td><?php echo ($key + 1); ?> </td>
                                    <td><?php echo MyFormatter::formatDateTimeForUser($detail->pendaftaran->tgl_pendaftaran); ?></td>
                                    <td><?php echo MyFormatter::formatDateTimeForUser($detail->tglanamesadiet); ?></td>
                                    <td><?php echo $detail->jeniswaktu->jeniswaktu_nama; ?></td>
                                    <td><?php echo $detail->menudiet->menudiet_nama; ?></td>
                                    <td><?php echo $detail->bahanmakanan->namabahanmakanan; ?></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6"><i>Data tidak ditemukan.</i></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    //========= Dialog Detail Anamnesa Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetailAnamnesa',
        'options' => array(
            'title' => 'Data Anamnesa Diet',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailDialogAnamnesa" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>
    <?php
    //========= Dialog Detail Konsultasi Gizi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetailGizi',
        'options' => array(
            'title' => 'Data Konsultasi Gizi',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailDialogGizi" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>
    <?php
    //========= Dialog Detail Pemeriksaan Fisik Gizi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPeriksaFisik',
        'options' => array(
            'title' => 'Data Periksa Fisik',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="dialogPeriksaFisik" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>
    <?php
    //========= Dialog Detail Anamnesa Keperawatan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'detailAnamnesisPerawatan',
        'options' => array(
            'title' => 'Data Anamnesa Keperawatan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailAnamnesisPerawatan" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>
    <?php
    //========= Dialog Detail Konsultasi Gizi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetailData',
        'options' => array(
            'title' => 'Detail Data',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
    ?>