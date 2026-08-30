<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modPasien)) {
?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-users"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                        <?php
                        $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
                        echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
                    </td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
                    <td rowspan="4">
                        <?php
                        if (!empty($modPasien->photopasien)) {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                        } else {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php
                        $modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
                        echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                    </td>

                    <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
                    <td><?php
                        $modPendaftaran->kelaspelayanan_id = !empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->admisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id;
                        $modPendaftaran->kelaspelayanan->kelaspelayanan_nama = !empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->admisi->kelaspelayanan->kelaspelayanan_nama : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
                        echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->dokter, 'namaLengkap', array('readonly' => true)); ?></td>


                </tr>

            </table>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <?php echo CHtml::checkBox('cekRiwayatPasien', false, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?> Riwayat Pasien
            </div>
        </div>
        <div class="panel-body">
            <div id="divRiwayatPasien" class="control-group">
                <iframe src="" id="riwayatPasien" width="100%" height="98%"></iframe>
            </div>
        </div>
    </div>
<?php
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

?>
<?php
//========= Dialog Konsultasi Gizi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailGizi',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));
?>
<iframe class="biru" src="" name="detailDialogGizi" width="100%" height="100%" onload="javascript:resizeIframe(this);"> </iframe>
<?php $this->endWidget(); ?>

<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" width="100%" height="100%" onload="javascript:resizeIframe(this);"></iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" width="100%" height="100%" onload="javascript:resizeIframe(this);"></iframe>
<?php
$this->endWidget();
?>
<?php
//========= dialogPeriksaFisik =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPeriksaFisik',
    'options' => array(
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="dialogPeriksaFisik" width="100%" height="100%" onload="javascript:resizeIframe(this);"></iframe>
<?php
$this->endWidget();
?>
<?php
//========= dialogPeriksaFisik =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'detailAnamnesisPerawatan',
    'options' => array(
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailAnamnesisPerawatan" width="100%" height="100%" onload="javascript:resizeIframe(this);"></iframe>
<?php
$this->endWidget();
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailAnamnesa',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogAnamnesa" width="100%" height="100%" onload="javascript:resizeIframe(this);"></iframe>
<?php
$this->endWidget();
?>