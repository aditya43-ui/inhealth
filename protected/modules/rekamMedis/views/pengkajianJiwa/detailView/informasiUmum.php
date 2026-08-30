<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>



<div class="panel panel-success panel_detail" id='panel_1'>
    <div class="panel-heading">
        <div class="panel-title">Informasi Umum</div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Pengkajian</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div>
                            <div class="label_d">Setting</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div>
                            <div class="label_d">Tanggal Pengkajian</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo MyFormatter::formatDateTimeForUser($model->tgl_pengkajian); ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Jam Pengkajian</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $model->jam_pengkajian; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Perawat Pengkaji</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d"> 
                                <?php echo $model->perawatpengkaji->namaLengkap; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Informasi Umum</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div>
                            <div class="label_d">Nama</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $pasien->nama_pasien ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Jenis Kelamin</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $pasien->jeniskelamin ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Umur</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $pendaftaran->umur ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Status Perkawinan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $pasien->statusperkawinan ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Alamat</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $pasien->alamat_pasien ?><br/>
                                RT : <?php echo empty($pasien->rt) ? "-" : $pasien->rt; ?>
                                RW : <?php echo empty($pasien->rw) ? "-" : $pasien->rw; ?><br/>
                                Desa/Kelurahan : <?php echo $pasien->kelurahan->kelurahan_nama; ?><br/>
                                Kecamatan : <?php echo $pasien->kelurahan->kecamatan->kecamatan_nama; ?><br/>
                                Kabupaten/Kota : <?php echo $pasien->kelurahan->kecamatan->kabupaten->kabupaten_nama; ?><br/>
                                Provinsi : <?php echo $pasien->kelurahan->kecamatan->kabupaten->propinsi->propinsi_nama; ?><br/>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">No. Telepon</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($pasien->no_telepon_pasien) ? "-" : $pasien->no_telepon_pasien ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">No. Mobile</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($pasien->no_mobile_pasien) ? "-" : $pasien->no_mobile_pasien ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <u><strong>Informan</strong></u><br/>
                        <div>
                            <div class="label_d">Nama</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $model->informan_nama ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Jenis Kelamin</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $model->informan_jeniskelamin ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Umur</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $model->informan_umur ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Pekerjaan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->informan_pekerjaan) ? "-" : $model->informan_pekerjaan->pekerjaan_nama ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Hubungan Dengan Pasien</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $model->informan_hubungandenganpasien ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Tinggal Serumah Dengan Pasien</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <span><?php echo $model->informan_istinggalserumah ? $ceklis : $unceklis?> Ya </span>
                                <span><?php echo !$model->informan_istinggalserumah ? $ceklis : $unceklis?> Tidak </span>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Alamat</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo $model->informan_alamat ?><br/>
                                RT : <?php echo empty($model->informan_rt) ? "-" : $model->informan_rt; ?>
                                RW : <?php echo empty($model->informan_rw) ? "-" : $model->informan_rw; ?><br/>
                                Desa/Kelurahan : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kelurahan_nama; ?><br/>
                                Kecamatan : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kecamatan->kecamatan_nama; ?><br/>
                                Kabupaten/Kota : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kecamatan->kabupaten->kabupaten_nama; ?><br/>
                                Provinsi : <?php echo empty($model->informan_kelurahan) ? "-" : $model->informan_kelurahan->kecamatan->kabupaten->propinsi->propinsi_nama; ?><br/>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">No. Telepon</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->informan_notelp) ? "-" : $model->informan_notelp ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">No. Mobile</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->informan_nomobile) ? "-" : $model->informan_nomobile ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>