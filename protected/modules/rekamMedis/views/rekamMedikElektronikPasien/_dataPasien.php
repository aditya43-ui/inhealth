<?php
$this->widget('bootstrap.widgets.BootAlert');
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
?>
<?php
if (!empty($modPasien)) {
?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
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

                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                    </td>

                    <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar, 'cara bayar', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                <?php if(!empty($modPenunjang)):?>
                    <td><?php echo CHtml::activeLabel($modPenunjang->pegawai, 'nama_pegawai', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPenunjang->pegawai, 'namaLengkap', array('readonly' => true)); ?></td>
                <?php else:?>
                        <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPendaftaran->dokter, 'namaLengkap', array('readonly' => true)); ?></td>
                <?php endif;?>

                    <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?></td>
                </tr>

            </table>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">

        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <?php
                $this->renderPartial($this->path_view . '_riwayatPasien', array('pages' => $pages, 'modKunjungan' => $modKunjungan, 'pasien_id' => $modPasien->pasien_id));

                ?>
            </div>

        </div>
    </div>

    <?php
    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    //     'id' => 'tabel-riwayatpemeriksaanfisik',
    //     'content' => array(
    //         'content-detailpemeriksaanfisik' => array(
    //             'header' => '<b>Tabel Riwayat Pasien</b>',
    //             'isi' =>'<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
    //             'active' => true,
    //         ),
    //     ),
    // ));

    ?>

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

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsulHasil',
    'options' => array(
        'title' => 'Hasil Jawaban Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailKonsulHasil">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>