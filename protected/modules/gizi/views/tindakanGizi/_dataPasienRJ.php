

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
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true, 'class'=>'idrm')); ?>
                </td>
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
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                </td>
                <td>
                    <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                </td>

                <?php if(isset($modPendaftaran->carabayar)):?>
                <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar_id, 'cara bayar', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?>
                </td>
                <?php else:?>
                <td><?php echo CHtml::label('Jenis Penjamin', 'cara bayar', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::textField('carabayar', '', array('readonly' => true)); ?>
                </td>
                <?php endif;?>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'dokter_pemeriksa', array('readonly' => true)); ?>
                </td>


                <?php if(isset($modPendaftaran->penjamin)):?>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?>
                </td>
                <?php else:?>
                <td><?php echo CHtml::label('Penjamin', 'penjamin', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::textField('penjamin', '', array('readonly' => true)); ?>
                </td>
                <?php endif;?>

            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir', array('class' => 'control-label')); ?>
                </td>
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
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Skrining Gizi
        </div>
    </div>
    <div class="panel-body">
        <?php

            $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);

            $modAnamnesa = AnamnesaT::model()->findByAttributes(array(
                'pendaftaran_id' => $p->pendaftaran_id,
                'create_ruangan' => $p->ruangan_id,
            ), array(
                'condition' => 'skrining_dewasa = true or skrining_anak = true',
                'order' => 'anamesa_id desc'
            ));

            if (!empty($modAnamnesa) && $modAnamnesa->skrining_dewasa) :
            ?>

        <div style="text-align: center">SKRINING GIZI DEWASA</div>
        <table width="100%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT < 20,5 atau LLA < 25 cm untuk wanita dan LLA < 26,3 cm untuk pria ?</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria1 == true ? '<i class="entypo-check">' : '' ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria1 == false ? '<i class="entypo-check">' : '' ?>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria2 == true ? '<i class="entypo-check">' : '' ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria2 == false ? '<i class="entypo-check">' : '' ?>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria3 == true ? '<i class="entypo-check">' : '' ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria3 == false ? '<i class="entypo-check">' : '' ?>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria4 == true ? '<i class="entypo-check">' : '' ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_dewasa_kriteria4 == false ? '<i class="entypo-check">' : '' ?>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_dewasa_skor ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_dewasa_hasil; ?></td>
                </tr>

            </tfoot>
        </table>

        <?php endif; ?>

        <?php if (!empty($modAnamnesa) && $modAnamnesa->skrining_anak) : ?>
        <div style="text-align: center">SKRINING GIZI ANAK</div>
        <table width="100%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT anak berada dibawah nilai cut-off tabel IMT rujukan ?</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria1 == true ? '<i class="entypo-check">' : ''; ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria1 == false ? '<i class="entypo-check">' : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak
                        disengaja, baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria2 == true ? '<i class="entypo-check">' : ''; ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria2 == false ? '<i class="entypo-check">' : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama
                        1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria3 == true ? '<i class="entypo-check">' : ''; ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria3 == false ? '<i class="entypo-check">' : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1
                        minggu kedepan ?</td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria4 == true ? '<i class="entypo-check">' : ''; ?>
                    </td>
                    <td class="pilih_center" width="50">
                        <?php echo $modAnamnesa->skrining_anak_kriteria4 == false ? '<i class="entypo-check">' : ''; ?>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_anak_skor; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_anak_hasil; ?></td>
                </tr>

            </tfoot>
        </table>

        <?php endif; ?>

    </div>
</div>

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