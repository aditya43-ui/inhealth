<?php

/**		digunakan untuk menampilkan data profil user menggunakan template neon
 *		@author		Muhammad Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *		@website	<http://piindonesia.co.id>
 */
$controller = Yii::app()->controller->id;
$module = Yii::app()->controller->module->id;
$urlCuti =  Yii::app()->createAbsoluteUrl($module . '/cutiPegawai' . $this->init . '/index');
$urlGaji =  Yii::app()->createAbsoluteUrl($module . '/InformasiGajiPegawai' . $this->init . '');
?>
<?php
$this->breadcrumbs = array(
    'Profil User',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Profil User
        </div>
    </div>
    <div class="panel-body">
        <div class="profile-env">
            <header class="row">
                <div class="col-sm-2">
                    <a href="#" class="profile-picture">
                        <?php
                        if ($model->photopegawai != '') :
                            if (file_exists(Params::pathPegawaiDirectory() . $model->photopegawai)) {
                                $src = Params::urlPegawaiDirectory() . $model->photopegawai;
                            } else {
                                $src =  Params::urlPegawaiDirectory() . Params::ICON_PROFIL_PEGAWAI;
                            }
                        else :
                            $src =  Params::urlPegawaiDirectory() . Params::ICON_PROFIL_PEGAWAI;
                        endif;
                        ?>
                        <img src="<?php echo $src; ?>" class="img-responsive img-circle" width="110px;" />
                    </a>
                </div>
                <div class="col-sm-7">
                    <ul class="profile-info-sections">
                        <li>
                            <div class="profile-name">
                                <b>
                                    <a href="#"><?php echo !empty($model->nama_pegawai) ? $model->nama_pegawai : Yii::app()->user->getState('nama_pemakai'); ?></a>
                                    <a href="#" class="user-status is-online tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Online"></a>
                                    <!--User statuses available classes "is-online", "is-offline", "is-idle", "is-busy"-->
                                </b>
                                <span><a href="#"><?php echo !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : '-'; ?> di <?php echo !empty($model->profilrs_id) ? $model->profilrs->nama_rumahsakit : '-' ?></a></span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-3">
                </div>
            </header>
            <section class="profile-info-tabs" style="background:#ffffec;border:1px solid #bdedbc;margin-left: 0;margin-right: 0;padding-bottom: 0;">
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-10">
                        <ul class="user-details">
                            <li>
                                <a href="#">
                                    <i class="entypo-location"></i>
                                    <?php //echo !empty($model->profilhotel->propinsi_id)?$model->profilhotel->propinsi->propinsi_nama:'-' 
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="entypo-suitcase"></i>
                                    Bekerja sebagai <span><?php echo !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : '-'; ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="entypo-calendar"></i>
                                    <?php echo !empty($model->tglditerima) ?  MyFormatter::formatDateTimeForUser($model->tglditerima) : '-' ?>
                                </a>
                            </li>
                        </ul>
                        <!--tabs for the profile links-->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#profile-info" data-toggle="tab">
                                    <span class="visible-xs"><i class="entypo-home"></i></span>
                                    <span class="hidden-xs">Profil</span></a>
                            </li>
                            <li><a href="#user" data-toggle="tab">
                                    <span class="visible-xs"><i class="entypo-user"></i></span>
                                    <span class="hidden-xs">Pengguna</span></a>
                            </li>
                            <li><a href="#access" data-toggle="tab">
                                    <span class="visible-xs"><i class="entypo-network"></i></span>
                                    <span class="hidden-xs">Akses</span></a>
                            </li>
                            <li><a href="#cuti" data-toggle="tab" onclick="generateCuti();">
                                    <span class="visible-xs"><i class="entypo-network"></i></span>
                                    <span class="hidden-xs">Cuti</span></a>
                            </li>
                            <li><a href="#gaji" data-toggle="tab" onclick="generateGaji();">
                                    <span class="visible-xs"><i class="entypo-network"></i></span>
                                    <span class="hidden-xs">Penggajian</span></a>
                            </li>
                            <!--<li><a href="#gaji"  data-toggle="tab" onclick="generateGaji();">
										<span class="visible-xs"><i class="entypo-network"></i></span>
										<span class="hidden-xs">Gaji</span></a>
									</li>-->
                        </ul>
                    </div>
                </div>
            </section>
            <section class="profile-feed">
                <div class="tab-content">
                    <div class="tab-pane active" id="profile-info">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <i class="entypo-user"></i> Informasi <b>Personal</b>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Tipe Identitas</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->jenisidentitas) ? $model->jenisidentitas : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Nomor Identitas</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->noidentitas) ? $model->noidentitas : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Nama</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->nama_pegawai) ? $model->nama_pegawai : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Tempat/Tanggal Lahir</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->tempatlahir_pegawai) ? $model->tempatlahir_pegawai : '-'; ?>
                                                <?php echo ', '; ?>
                                                <?php echo !empty($model->tanggal_lahirpegawai) ?  MyFormatter::formatDateTimeEn($model->tanggal_lahirpegawai) : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Alamat</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->alamat_pegawai) ? $model->alamat_pegawai : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Provinsi</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->propinsi_id) ? $model->propinsi->propinsi_nama : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Kota</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->kabupaten_id) ? $model->kabupaten->kabupaten_nama : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Kecamatan</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->kecamatan_id) ? $model->kecamatan->kecamatan_nama : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Kelurahan</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->kelurahan_id) ? $model->kelurahan->kelurahan_nama : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Longitude</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->longitude) ? $model->longitude : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Latitude</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->latitude) ? $model->latitude : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Jenis Kelamin</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->jeniskelamin) ? $model->jeniskelamin : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Status Perkawinan</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->statusperkawinan) ? $model->statusperkawinan : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Kewarganegaraan</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->warganegara_pegawai) ? $model->warganegara_pegawai : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Agama</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->agama) ? $model->agama : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Golongan Darah</b></label>
                                            <div class="col-sm-6">
                                                <?php
                                                echo !empty($model->golongandarah) ? $model->golongandarah : '-';
                                                echo " ";
                                                echo !empty($model->rhesus) ? $model->rhesus : '-';
                                                ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Nomor Telepon</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->notelp_pegawai) ? $model->notelp_pegawai : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Nomor Handphone</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->nomobile_pegawai) ? $model->nomobile_pegawai : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Alamat Email</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->alamatemail) ? $model->alamatemail : '-'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <i class="entypo-user"></i> Informasi <b>Karyawan</b>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Nomor Karyawan</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->nomorindukpegawai) ? $model->nomorindukpegawai : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Jabatan</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Tanggal Mulai Bekerja</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->tglditerima) ? MyFormatter::formatDateTimeEn($model->tglditerima) : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Tanggal Berhenti Bekerja</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->tglberhenti) ? MyFormatter::formatDateTimeEn($model->tglberhenti) : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Nomor NPWP</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->npwp) ? $model->npwp : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Bank</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->bank_no_rekening) ? $model->bank_no_rekening : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5"><b>Nomor Rekening Bank</b></label>
                                            <div class="col-sm-6">
                                                <?php echo !empty($model->no_rekening) ? $model->no_rekening : '-'; ?>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="user">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <i class="entypo-info-circled"></i> Informasi <b>Akun Pengguna</b>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Nama Akun</b></label>
                                                    <div class="col-sm-6">
                                                        <?php echo !empty($modPemakai->nama_pemakai) ? $modPemakai->nama_pemakai : '-'; ?>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Tanggal Pembuatan Akun</b></label>
                                                    <div class="col-sm-6">
                                                        <?php echo !empty($modPemakai->create_time) ? MyFormatter::formatDateTimeEn($modPemakai->create_time) : '-'; ?>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Terakhir Diperbarui</b></label>
                                                    <div class="col-sm-6">
                                                        <?php echo !empty($modPemakai->update_time) ? MyFormatter::formatDateTimeEn($modPemakai->update_time) : '-'; ?>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Terakhir Login</b></label>
                                                    <div class="col-sm-6">
                                                        <?php echo !empty($modPemakai->lastlogin) ? MyFormatter::formatDateTimeEn($modPemakai->lastlogin) : '-'; ?>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Waktu Aktivitas Terakhir</b></label>
                                                    <div class="col-sm-6">
                                                        <?php echo !empty($modPemakai->waktuterakhiraktifitas) ? MyFormatter::formatDateTimeEn($modPemakai->waktuterakhiraktifitas) : '-'; ?>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="access">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <i class="entypo-info-circled"></i> Informasi <b>Akses</b>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Jabatan</b></label>
                                                    <div class="col-sm-6">
                                                        <?php echo !empty($modRole->peranpengguna_id) ? $modRole->peranpengguna->peranpenggunanama : '-'; ?>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Bidang Kerja</b></label>
                                                    <div class="col-sm-6">
                                                        <?php //echo !empty($modRole->tugas_nama)?$modRole->tugas_nama:'-'; 
                                                        foreach ($modRoleAll as $all) {
                                                            echo "<li>" . $all->tugas_nama . "</li>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <br>
                                                <p>&nbsp;</p>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-5"><b>Akses Modul</b></label>
                                                    <div class="col-sm-6">
                                                        <?php
                                                        if (Params::cekAksesSysAdmin(Yii::app()->user->getState('peranpengguna_id'))) {
                                                            echo "All Modules";
                                                        } else {
                                                            //echo "<ul>";
                                                            // var_dump(count((array)$modModule));
                                                            foreach ($modModule as $modModule) {
                                                                echo "<li>" . $modModule->modul_nama . "</li>";
                                                            }
                                                            //echo "</ul>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="cuti">
                        <iframe class="biru" src="" id="frameCuti" width="100%" height='100%' onload="">
                        </iframe>
                    </div>
                    <div class="tab-pane" id="gaji">
                        <iframe class="biru" src="" id="frameGaji" width="100%" height='100%' onload="">
                        </iframe>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
    function generateCuti() {
        var frameObj = document.getElementById("frameCuti");
        resetIframe(frameObj);
        $(frameObj).attr('src', '<?php echo $urlCuti; ?> ');
        $(frameObj).load(function() {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }

    function generateGaji() {
        var frameObj = document.getElementById("frameGaji");
        resetIframe(frameObj);
        $(frameObj).attr('src', '<?php echo $urlGaji; ?> ');
        $(frameObj).load(function() {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }

    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }

    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }
</script>