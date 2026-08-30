<?php
$this->widget('bootstrap.widgets.BootAlert');
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;

$kunjungan = InfokunjunganrjV::model()->findByAttributes(array(
    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
));

$modPendaftaran->dokter_pemeriksa = $modPendaftaran->dokter->namaLengkap;

$jns_kunjungan = $modPendaftaran->kunjungan;

if (!empty($kunjungan)) {
    $modPendaftaran->dokter_pemeriksa =  $kunjungan->gelardepan.$kunjungan->nama_pegawai.(empty($kunjungan->gelarbelakang_nama) ? "" : (", ".$kunjungan->gelarbelakang_nama));
}

echo CHtml::hiddenField('kunjungan', $jns_kunjungan, array('readonly' => true));
echo CHtml::hiddenField('judul_sblm', '', array('readonly' => true));


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
                    <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true, 'class'=>'idrm')); ?></td>
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

                    <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar, 'jenis', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'dokter_pemeriksa', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly' => true)); ?></td>
                </tr>

            </table>
        </div>
    </div>

    <!-- <div class="isContent">
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Riwayat Pasien
                </div>
            </div>
            <div class="panel-body table-responsive">
                <iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>
            </div>
        </div>
    </div> -->

    <?php
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'riwayat-pasien',
        'content' => array(
            'content-' => array(
                'header' => 'Riwayat Pasien',
                'isi' => '<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
                'active' => true,
            ),
        ),
    ));
    ?>

<div class="isContent">
    <?php
    if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) {
        $modDaftar = new PendaftaranT();
        $modDaftar->unsetAttributes();
        $modDaftar->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');
        $modDaftar->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modDaftar->pasien_id = $modPendaftaran->pasien_id;
        $modDaftar->isprmrj = true;
        $modDaftar->instalasi_id = Params::INSTALASI_ID_RJ;
        $modDaftar->ceklispendaftaran = false;
        if (isset($_GET['PendaftaranT'])) {
            $modDaftar->attributes = $_GET['PendaftaranT'];
            $modDaftar->ceklispendaftaran = $_GET['PendaftaranT']['ceklispendaftaran'];
            $modDaftar->pasien_id = $modDaftar->pendaftaran_id;
        }

        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-riwayatprofil',
            'content' => array(
                'content-riwayatprofil' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Profil Ringkasan Medis Rawat Jalan (PRMRJ)')) . '<b> Profil Ringkas Medis Rawat Jalan</b>',
                    'isi' => $this->renderPartial($this->path_view . '_riwayatProfilRingkasMedis', array(
                        'modPendaftaran' => $modPendaftaran,
                        'modDaftar' => $modDaftar
                    ), true),
                    'active' => false,
                ),
            ),
        ));
    }
    ?>
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
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailDataPenunjang',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1200,
        'height' => 700,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogPenunjang" style="width: 100%; height: 98%;"></iframe>
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

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailRiwayat',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe frameborder="0" name="frameRiwayat" width="100%" height="100%"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>