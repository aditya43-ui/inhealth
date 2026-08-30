<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);

$penerima = "";
$dpjp2 = "";
$dpjp3 = "";

if (!empty($modAdmisi->dokterpenerima_id)) {
    $peg = PegawaiM::model()->findByPk($modAdmisi->dokterpenerima_id);
    $penerima = $peg->namaLengkap;
}
if (!empty($modAdmisi->dpjp2_id)) {
    $peg = PegawaiM::model()->findByPk($modAdmisi->dpjp2_id);
    $dpjp2 = $peg->namaLengkap;
}
if (!empty($modAdmisi->dpjp3_id)) {
    $peg = PegawaiM::model()->findByPk($modAdmisi->dpjp3_id);
    $dpjp3 = $peg->namaLengkap;
}
?>

<form class="form-horizontal">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeHiddenField($modPasien, 'nama_bin', array('readonly' => true)); ?>
                    <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modAdmisi, 'kelaspelayanan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Dokter Penerima', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('dokterpenerima', $penerima, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modAdmisi->pegawai, 'dokter_pemeriksa', array('class' => 'control-label', 'label' => 'DPJP 1')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modAdmisi->pegawai, 'namaLengkap', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('DPJP 2', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('dpjp2', $dpjp2, array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('DPJP 3', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('dpjp3', $dpjp3, array('readonly' => true)); ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::Label('No. Kamar / No. Bed', (isset($modAdmisi->kamarruangan_id) ? $modAdmisi->kamarruangan->kamarruangan_nokamar : ""), array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php if (isset($modAdmisi->kamarruangan_id)) { ?>
                            <?php echo CHtml::activeTextField($modAdmisi->kamarruangan, 'kamarruangan_nokamar', array('readonly' => true, 'style' => 'width:150px;')); ?>
                    </div>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modAdmisi->kamarruangan, 'kamarruangan_nobed', array('readonly' => true, 'style' => 'width:60px;')); ?>
                    <?php } else { ?>
                        <?php echo CHtml::TextField('kamarruangan_nokamar', '', array('readonly' => true, 'style' => 'width:70%')); ?> /
                        <?php echo CHtml::TextField('kamarruangan_nobed', '', array('readonly' => true, 'style' => 'width:20%')); ?>
                    <?php } ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modAdmisi->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modAdmisi->kelaspelayanan, 'kelaspelayanan_nama', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modAdmisi->carabayar, 'cara bayar ', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modAdmisi->carabayar, 'carabayar_nama', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modAdmisi->penjamin, 'penjamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modAdmisi->penjamin, 'penjamin_nama', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php
                        if (!empty($modPasien->photopasien)) {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                        } else {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success hide">
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
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == true ? '<i class="entypo-check">' : '' ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == false ? '<i class="entypo-check">' : '' ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == true ? '<i class="entypo-check">' : '' ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == false ? '<i class="entypo-check">' : '' ?></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == true ? '<i class="entypo-check">' : '' ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == false ? '<i class="entypo-check">' : '' ?></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == true ? '<i class="entypo-check">' : '' ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == false ? '<i class="entypo-check">' : '' ?></td>
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
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == true ? '<i class="entypo-check">' : ''; ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == false ? '<i class="entypo-check">' : ''; ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak disengaja, baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == true ? '<i class="entypo-check">' : ''; ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == false ? '<i class="entypo-check">' : ''; ?></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama 1 minggu terakhir ?</td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == true ? '<i class="entypo-check">' : ''; ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == false ? '<i class="entypo-check">' : ''; ?></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1 minggu kedepan ?</td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == true ? '<i class="entypo-check">' : ''; ?></td>
                            <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == false ? '<i class="entypo-check">' : ''; ?></td>
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
</form>