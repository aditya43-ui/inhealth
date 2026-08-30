<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>


<table class="tab_detail">
    <tbody>
        <tr>
            <td width="250">
                <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="width:200px;"/>
            </td>
            <td class="print_header">
                <div class="print_judul">FORM PENGKAJIAN KEPERAWATAN<BR/>KESEHATAN JIWA 
                </div>
            </td>
            <td width="250">
                <table class="tab_info tab_header">
                    <tr>
                        <td style="width: 100px;">Nama Pasien</td>
                        <td>:</td>
                        <td><?php echo $pendaftaran->pasien->nama_pasien; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><?php echo $pendaftaran->pasien->jeniskelamin; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir); ?></td>
                    </tr>
                    <tr>
                        <td>No. RM</td>
                        <td>:</td>
                        <td><?php echo $pendaftaran->pasien->no_rekam_medik; ?></td>
                    </tr>
                    <tr>
                        <td>Dokter BPJP</td>
                        <td>:</td>
                        <td><?php echo $pendaftaran->pegawai->namaLengkap; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<div class="panel_main">
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <tr>
                            <td>Setting</td>
                            <td>:</td>
                            <td>
                                <div>
                                    <?php echo $model->setting_pengakajian == "Rumah Sakit" ? $ceklis : $unceklis ?> Rumah Sakit<br/>
                                    Instalasi : <?php echo ($model->setting_pengakajian != "Rumah Sakit" || empty($model->ruangan_id)) ? "-" : $model->ruangan->instalasi->instalasi_nama; ?><br/>
                                    Ruangan : <?php echo ($model->setting_pengakajian != "Rumah Sakit" || empty($model->ruangan_id)) ? "-" : $model->ruangan->ruangan_nama; ?><br/>
                                </div>
                                <div>
                                    <?php echo $model->setting_pengakajian == "Masyarakat" ? $ceklis : $unceklis ?> Masyarakat<br/>
                                    Puskesmas : <?php echo ($model->setting_pengakajian != "Masyarakat" || empty($model->puskesmas_nama)) ? "-" : $model->puskesmas_nama; ?><br/>
                                    No. Register : <?php echo ($model->setting_pengakajian != "Masyarakat" || empty($model->puskesmas_register)) ? "-" : $model->puskesmas_register; ?><br/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <tr>
                            <td>Tanggal Pengkajian</td>
                            <td>:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($model->tgl_pengkajian); ?></td>
                        </tr>
                        <tr>
                            <td>Pukul</td>
                            <td>:</td>
                            <td><?php echo $model->jam_pengkajian; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="panel_main">
    <div class="panel_judul">
        I. INFORMASI UMUM
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?php echo $pasien->nama_pasien ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $pasien->jeniskelamin ?></td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td>:</td>
                            <td><?php echo $pendaftaran->umur ?></td>
                        </tr>
                        <tr>
                            <td>Status Perkawinan</td>
                            <td>:</td>
                            <td><?php echo empty($pasien->statusperkawinan) ? "-" : $pasien->statusperkawinan ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>
                                <?php echo $pasien->alamat_pasien ?><br/>
                                RT : <?php echo empty($pasien->rt) ? "-" : $pasien->rt; ?>
                                RW : <?php echo empty($pasien->rw) ? "-" : $pasien->rw; ?><br/>
                                Desa/Kelurahan : <?php echo $pasien->kelurahan->kelurahan_nama; ?><br/>
                                Kecamatan : <?php echo $pasien->kelurahan->kecamatan->kecamatan_nama; ?><br/>
                                Kabupaten/Kota : <?php echo $pasien->kelurahan->kecamatan->kabupaten->kabupaten_nama; ?><br/>
                                Provinsi : <?php echo $pasien->kelurahan->kecamatan->kabupaten->propinsi->propinsi_nama; ?><br/>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Telepon</td>
                            <td>:</td>
                            <td><?php echo empty($pasien->no_telepon_pasien) ? "-" : $pasien->no_telepon_pasien ?></td>
                        </tr>
                        <tr>
                            <td>No. Mobile</td>
                            <td>:</td>
                            <td><?php echo empty($pasien->no_mobile_pasien) ? "-" : $pasien->no_mobile_pasien ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <strong><u>Informan</u></strong>
                <table class="tab_info">
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?php echo $model->informan_nama ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $model->informan_jeniskelamin ?></td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td>:</td>
                            <td><?php echo $model->informan_umur ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?php echo empty($model->informan_pekerjaan) ? "-" : $model->informan_pekerjaan->pekerjaan_nama ?></td>
                        </tr>
                        <tr>
                            <td>Hubungan Dengan Pasien</td>
                            <td>:</td>
                            <td><?php echo $model->informan_hubungandenganpasien ?></td>
                        </tr>
                        <tr>
                            <td>Tinggal Serumah Dengan Pasien</td>
                            <td>:</td>
                            <td>
                                <span><?php echo $model->informan_istinggalserumah ? $ceklis : $unceklis ?> Ya </span>
                                <span><?php echo!$model->informan_istinggalserumah ? $ceklis : $unceklis ?> Tidak </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>
                                <?php echo $model->informan_alamat ?><br/>
                                RT : <?php echo empty($model->informan_rt) ? "-" : $model->informan_rt; ?>
                                RW : <?php echo empty($model->informan_rw) ? "-" : $model->informan_rw; ?><br/>
                                Desa/Kelurahan : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kelurahan_nama; ?><br/>
                                Kecamatan : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kecamatan->kecamatan_nama; ?><br/>
                                Kabupaten/Kota : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kecamatan->kabupaten->kabupaten_nama; ?><br/>
                                Provinsi : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kecamatan->kabupaten->propinsi->propinsi_nama; ?><br/>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Telepon</td>
                            <td>:</td>
                            <td><?php echo empty($model->informan_notelp) ? "-" : $model->informan_notelp ?></td>
                        </tr>
                        <tr>
                            <td>No. Mobile</td>
                            <td>:</td>
                            <td><?php echo empty($model->informan_nomobile) ? "-" : $model->informan_nomobile ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="panel_main">
    <div class="panel_judul">
        II. KELUHAN UTAMA
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <tr>
                            <td>Keluhan Utama</td>
                            <td>:</td>
                            <td><?php echo $model->keluhanutama; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <?php
                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                            'diagnosa' => $diagnosa,
                            'label_diagnosa' => 'Diagnosa Gangguan',
                            'jenisdiagnosa' => 'diagnosa_gangguan',
                            'kelompokdiagnosa' => 'keluhanutama',
                        ));
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>