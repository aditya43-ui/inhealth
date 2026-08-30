<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modPasien)) {
?>
    <fieldset class="box">
        <legend class="rim">Data Pasien</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
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

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                <td>
                    <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran->pegawai, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->pegawai, 'nama_pegawai', array('readonly' => true)); ?></td>
                <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly' => true)); ?></td>
            </tr>

        </table>
    </fieldset>
    <div class="isContent">
        <style>
            .table thead tr th {
                vertical-align: middle;
            }
        </style>

        <fieldset>
            <!--<legend class="accord1" style="width:460px;"><?php // echo CHtml::checkBox('cekRiwayatPasien',false, array('onclick'=>'cekRiwayat(this);','onkeypress'=>"return $(this).focusNextInputField(event)")) 
                                                                    ?> Riwayat Pasien </legend>
    <div id="divRiwayatPasien" class="control-group">
        <iframe src="" id="riwayatPasien" width="100%" height="100%">
        </iframe>        
    </div>-->
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-riwayat',
                'content' => array(
                    'content-detailpasien' => array(
                        'header' => '<b>Riwayat Pasien</b>',
                        'isi' => '<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
                        'active' => false,
                    ),
                ),
            )); ?>
        </fieldset>

    </div>
<?php
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

?>

<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" style="width: 100%; height: 98%;"></iframe>
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
        'zIndex' => 1002,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>