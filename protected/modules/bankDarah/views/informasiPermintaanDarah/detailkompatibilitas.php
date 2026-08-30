<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengujiankompabilitas-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<?php
$nama_pasien = '';
$jeniskelamin = ' ';
$no_rekam_medik = '';
$dokter = '';
$tgl_lahir = '';
$gol_darah = '';
$ruangan_nama = '';
$kelaspelayanan_nama = '';
$modPasien = '';
$modPegawai = '';
$ruangan = '';
$kelaspelayanan = '';
$penjamin = '';
$no_pendaftaran = '';
if (isset($modPendaftaran)) {
    $modPasien = isset($modPendaftaran->pasien_id) ? PasienM::model()->findByPk($modPendaftaran->pasien_id) : ' ';
    $modPegawai = isset($modPendaftaran->pegawai_id) ? PegawaiM::model()->findByPk($modPendaftaran->pegawai_id) : ' ';
    $no_pendaftaran = isset($modPendaftaran->no_pendaftaran) ?: ' ';
    $umur = isset($modPendaftaran->umur) ?: ' ';
    $nama_pasien = isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : ' ';
    $jeniskelamin = isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : ' ';
    $no_rekam_medik = isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : ' ';
    $dokter = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : ' ';
    $gol_darah = isset($modPasien->golongandarah) ? $modPasien->golongandarah . '/' . $modPasien->rhesus : ' ';
    $ruangan = isset($modPendaftaran->ruangan_id) ? BDRuanganM::model()->findByPk($modPendaftaran->ruangan_id) : ' ';
    $ruangan_nama = isset($ruangan->ruangan_nama) ? $ruangan->ruangan_nama : ' ';
    $kelaspelayanan = isset($modPendaftaran->kelaspelayanan_id) ? BDKelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id) : ' ';
    $kelaspelayanan_nama = isset($kelaspelayanan->kelaspelayanan_nama) ? $kelaspelayanan->kelaspelayanan_nama : ' ';
    $penjamin = isset($modPendaftaran->penjamin_id) ? PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id) : ' ';
    $penjamin_nama = isset($penjamin->penjamin_nama) ? $penjamin->penjamin_nama : ' ';
    $alamat_pasien = isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : ' ';
}

$tgl_pengujian = '';
$nama_penguji = '';
$anti_a = '';
$anti_b = '';
$anti_d = '';
$kesimpulan = '';

if (isset($modUjiDarah)) {
    $tgl_pengujian = isset($modUjiDarah->tglujidarahpasien) ? $format->formatDateTimeForUser($modUjiDarah->tglujidarahpasien) : ' ';
    $modPegawai = isset($modUjiDarah->peg_pemeriksa_id) ? PegawaiM::model()->findByPk($modUjiDarah->peg_pemeriksa_id) : ' ';
    $nama_penguji = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : ' ';
    $anti_a = isset($modUjiDarah->anti_a) ? $modUjiDarah->anti_a : ' ';
    $anti_b = isset($modUjiDarah->anti_b) ? $modUjiDarah->anti_b : ' ';
    $anti_d = isset($modUjiDarah->anti_d) ? $modUjiDarah->anti_d : ' ';
    $sel_A = isset($modUjiDarah->sel_a) ? $modUjiDarah->sel_a : ' ';
    $sel_B = isset($modUjiDarah->sel_b) ? $modUjiDarah->sel_b : ' ';
    $sel_O = isset($modUjiDarah->sel_o) ? $modUjiDarah->sel_o : ' ';
    $kesimpulan = isset($modUjiDarah->kesimpulan_uji) ? $modUjiDarah->kesimpulan_uji : ' ';
}

if (isset($modUjiDarahPasien)) {
    $tgl_pengujian = isset($modUjiDarah->tglujidarahpasien) ? $format->formatDateTimeForUser($modUjiDarah->tglujidarahpasien) : ' ';
    $modPegawai = isset($modUjiDarah->peg_pemeriksa_id) ? PegawaiM::model()->findByPk($modUjiDarah->peg_pemeriksa_id) : ' ';
    $nama_penguji = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : ' ';
    $anti_A = isset($modUjiDarah->anti_a) ? $modUjiDarah->anti_a : ' ';
    $anti_B = isset($modUjiDarah->anti_b) ? $modUjiDarah->anti_b : ' ';
    $anti_AB = isset($modUjiDarah->anti_ab) ? $modUjiDarah->anti_ab : ' ';
    $anti_D = isset($modUjiDarah->anti_d) ? $modUjiDarah->anti_d : ' ';
    $sel_A = isset($modUjiDarah->sel_a) ? $modUjiDarah->sel_a : ' ';
    $sel_B = isset($modUjiDarah->sel_b) ? $modUjiDarah->sel_b : ' ';
    $sel_O = isset($modUjiDarah->sel_o) ? $modUjiDarah->sel_o : ' ';
    $kesimpulan = isset($modUjiDarah->kesimpulan_uji) ? $modUjiDarah->kesimpulan_uji : ' ';
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Pengujian Kompatibilitas</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pendaftaran', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php $tgl = isset($modPendaftaran->tgl_pendaftaran) ? $format->formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) : ' '; ?>
                            <?php echo CHtml::TextField('tgl_pendaftaran', $tgl, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Pendaftaran', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('no_pendaftaran', $no_pendaftaran, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('ruangan_nama', $ruangan_nama, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kelas Pelayanan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('kelas_pelayanan', $kelaspelayanan_nama, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Diagnosis', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('diagnosis', '', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Penjamin', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('penjamin', $penjamin_nama, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Alamat Pasien', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textArea('alamat_pasien', $alamat_pasien, array('readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('No. Rekam Medik', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('no_rekam_medik', $no_rekam_medik, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('nama-pasien', $nama_pasien, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Lahir', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php $tgl_lahir = isset($modPasien->tanggal_lahir) ? $format->formatDateTimeForUser($modPasien->tanggal_lahir) : ' '; ?>
                            <?php echo CHtml::TextField('tgl_lahir', $tgl_lahir, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Umur', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('umur', $umur, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Kelamin', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('jenis_kelamin', $jeniskelamin, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Golongan darah/Rhesus', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('gol_darah', $gol_darah, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Dokter yang Menangani', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::TextField('Dokter', $dokter, array('readonly' => true)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pemeriksaan Golongan Darah ABO & Rhesus D Pasien Metode Slide Test</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Waktu Pengujian', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('tgl_pengujian', $tgl_pengujian, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Anti A', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('anti_a', $anti_a, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Anti B', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('anti_b', $anti_b, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Anti D', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('anti_d', $anti_d, array('readonly' => true)) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Kesimpulan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textArea('kesimpulan', $kesimpulan, array('readonly' => true)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" hidden>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Golongan Darah ABO & Rhesus D Pasien Metode Tube Test
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Sel Grouping :', '', array('class' => 'control-label')); ?>
                        <div class="controls">

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Anti A', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('anti_a', $anti_A, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Anti B', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('anti_b', $anti_B, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Anti AB', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('anti_ab', $anti_AB, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Anti D', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('anti_d', $anti_D, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kesimpulan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($modUjiDarahPasien, 'kesimpulan_uji', array('class' => 'required', 'readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Sel Typing :', '', array('class' => 'control-label')); ?>
                        <div class="controls">

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Sel A', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('sel_a', $sel_A, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Sel B', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('sel_b', $sel_B, array('readonly' => true)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Sel O', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('sel_o', $sel_O, array('readonly' => true)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengujian Kompabilitas</b>
                </div>
            </div>
            <div class='panel-body table-responsive'>
                <div class="panel-body" style="overflow-y: auto;">
                    <table id="table-detailbarang" class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Nomor Kantong</th>
                                <th>Jenis Darah</th>
                                <th colspan="5" style="text-align: center;">Pemeriksaan Goldar Metode Slide Test</th>
                                <th colspan="6" style="text-align: center;">Hasil Uji Silang Serasi</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th colspan='4' style="text-align: center;">Sel Grouping</th>
                                <th colspan='3' style="text-align: center;" hidden>Serum Typing</th>
                                <th>Kesimpulan</th>
                                <th>Mayor</th>
                                <th>Minor</th>
                                <th>Auto Kontrol</th>
                                <th>DCT</th>
                                <th>Kesimpulan</th>
                                <th>Rilis</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Anti A</th>
                                <th>Anti B</th>
                                <th>Anti AB</th>
                                <th>Anti D</th>
                                <th hidden>Test Cell A</th>
                                <th hidden>Test Cell B</th>
                                <th hidden>Test Cell O</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $modKantong = UjikompatibilitasT::model()->findAllByAttributes(array('ujidarahpasien_id' => $modUjiKompatibilitas->ujidarahpasien_id, 'tglujikompabilitas' => $modUjiKompatibilitas->tglujikompabilitas));
                            foreach ($modKantong as $value) {
                                $modPengujian = PengujiandarahT::model()->findByPk($value->pengujiandarah_id);
                            ?>
                                <tr>
                                    <td><?php echo $value->nomorbarcode; ?></td>
                                    <td><?php echo substr($value->nomorbarcode, 0, 3); ?></td>
                                    <td><?php echo $modPengujian->anti_a; ?></td>
                                    <td><?php echo $modPengujian->anti_b; ?></td>
                                    <td><?php echo $modPengujian->anti_ab; ?></td>
                                    <td><?php echo $modPengujian->anti_d; ?></td>
                                    <td hidden><?php echo $modPengujian->sel_a; ?></td>
                                    <td hidden><?php echo $modPengujian->sel_b; ?></td>
                                    <td hidden><?php echo $modPengujian->sel_o; ?></td>
                                    <td><?php echo $modPengujian->ket_hasiluji; ?></td>
                                    <td><?php echo $value->ujikomp_mayor; ?></td>
                                    <td><?php echo $value->ujikomp_minor; ?></td>
                                    <td><?php echo $value->ujikomp_autokontrol; ?> </td>
                                    <td><?php echo $value->ujikomp_dct; ?> </td>
                                    <td><?php echo $value->ujikomp_kesimpulan; ?></td>
                                    <td><?php echo $value->rilis; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class='panel-body'>
            <div class='control-group'>
                <?php echo CHtml::label('Waktu Pemeriksaan', '', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php $tgl_ujidarahpasien = isset($modUjiDarahPasien->tglujidarahpasien) ? $format->formatDateTimeForUser($modUjiDarahPasien->tglujidarahpasien) : ' '; ?>
                    <?php echo CHtml::TextField('tglujidarahpasien', $tgl_ujidarahpasien, array('readonly' => true)); ?>
                </div>
            </div>
            <div class='control-group'>
                <?php echo CHtml::label('Pemeriksa <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::TextField('peg_pemeriksa_id', $nama_penguji, array('readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>