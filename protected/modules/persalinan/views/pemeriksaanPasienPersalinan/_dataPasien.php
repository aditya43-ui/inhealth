<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modPasien)) {
    $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
    $modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <table width='100%' class="table-condensed">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>


                    <td rowspan="3" colspan="2">
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

                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true, 'class'=>'idrm')); ?></td>


                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>

                    <td hidden><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td hidden><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                    </td>

                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>
                    <td><label>Jenis Penjamin</label></td>
                    <td><?php echo CHtml::textField("", $modPendaftaran->carabayar->carabayar_nama, array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->pegawai, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->pegawai, 'namaLengkap', array('readonly' => true)); ?></td>
                    <td><label>Penjamin</label></td>
                    <td><?php echo CHtml::textField("", $modPendaftaran->penjamin->penjamin_nama, array('readonly' => true)); ?></td>
                </tr>

            </table>
        </div>
    </div>

    <div class="isContent">
        <style>
            .table thead tr th {
                vertical-align: middle;
            }
        </style>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><?php echo CHtml::checkBox('cekRiwayatPasien', false, array('onclick' => 'cekRiwayat(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) ?> Riwayat Pasien</div>
            </div>
            <div class="panel-body">
                <div id="divRiwayatPasien" class="control-group">
                    <iframe src="" id="riwayatPasien" width="100%" height="100%">
                    </iframe>
                </div>
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
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
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
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<script>

    function cekRiwayat() {
        
    }

</script>