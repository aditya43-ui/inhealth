<style>
    .fieldtd {
        font-size: 12px;
    }

    .a {
        background: #ffffff;
        width: 100%;
        margin-top: 5px;
        margin-bottom: 10px;
        font-size: 11px;
        box-shadow: 0 0px 3px #AAA7A7;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
</style>
<?php
$format = new MyFormatter;
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Profil User
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="row" style="width:100%">
            <fieldset class="box" style="border:none;">
                <div class="span12">
                    <div class="span11" style="width:100%">
                        <table class="a table-condensed" style="background:none;box-shadow:none;">
                            <tr valign="middle">
                                <td rowspan="5" width="20%">
                                    <p><br></p>
                                    <?php
                                    $url_photopegawai = (!empty($model->photopegawai) ? Params::urlPegawaiTumbsDirectory() . "kecil_" . $model->photopegawai : Params::urlPegawaiDirectory() . "no_photo.jpeg");
                                    ?>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"><img style="width:200px;height:200px;" src="<?php echo $url_photopegawai; ?>" /></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <i class="glyphicon glyphicon-file"></i> Data <b>Pribadi</b>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <table class="a table-condensed" style="background:none;box-shadow:none;">
                                                <tr>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('unit_perusahaan') . '</b>', $model->getAttributeLabel('unit_perusahaan'), array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->unit_perusahaan; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('jeniskelamin') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->jeniskelamin; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('nomorindukpegawai') . '</b>', $model->getAttributeLabel('nomorindukpegawai'), array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->nomorindukpegawai; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CHtml::label('<b>Golongan Darah / Rhesus</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->golongandarah . ' / ' . $model->rhesus; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php echo CHtml::label('<b>No. Identitas</b>', $model->getAttributeLabel('jenisidentitas'), array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->jenisidentitas . ' - ' . $model->noidentitas; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('agama') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->agama; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('nama_pegawai') . '</b>', $model->getAttributeLabel('nama_rumahsakit'), array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CHtml::label($model->gelardepan . ' ' . $model->nama_pegawai . ' ' . (isset($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : ""), $model->gelardepan . ' ' . $model->nama_pegawai . ' ' . (isset($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "")); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('suku_id') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->getSukuNama(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('nama_keluarga') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->nama_keluarga; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('warganegara_pegawai') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->warganegara_pegawai; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('tempatlahir_pegawai') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->tempatlahir_pegawai; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('statusperkawinan') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $model->statusperkawinan; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('tgl_lahirpegawai') . '</b>', '', array('class' => 'fieldtd')); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $format->formatDateTimeForUser($model->tgl_lahirpegawai); ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Alamat / Kontak
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="a table-condensed" style="background:none;box-shadow:none;">
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('alamat_pegawai') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo $model->alamat_pegawai; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('propinsi_id') . '</b>', $model->getAttributeLabel('nomorindukpegawai')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->propinsi_id) ? $model->propinsi->propinsi_nama : ""; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kabupaten_id') . '</b>', $model->getAttributeLabel('nomorindukpegawai')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->kabupaten_id) ? $model->kabupaten->kabupaten_nama : ""; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kecamatan_id') . '</b>', $model->getAttributeLabel('nomorindukpegawai')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->kecamatan_id) ? $model->kecamatan->kecamatan_nama : ""; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kelurahan_id') . '</b>', $model->getAttributeLabel('nomorindukpegawai')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->kelurahan_id) ? $model->kelurahan->kelurahan_nama : ""; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('garis_latitude') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo $model->garis_latitude; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('garis_longitude') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo $model->garis_longitude; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>No. Telp / Hp</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo $model->notelp_pegawai . ' / ' . $model->nomobile_pegawai; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('alamatemail') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo $model->alamatemail; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="width:48%">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Data <b>Lain-Lain</b>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="a table-condensed" style="background:none;box-shadow:none;">

                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('statuskepemilikanrumah_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo isset($model->statuskepemilikanrumah_id) ? $model->statuskepemilikanrumah->statuskepemilikanrumah_nama : ""; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kemampuanbahasa') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo $model->kemampuanbahasa; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">
                                        <?php echo CHtml::label('<b>' . $model->getAttributeLabel('warnakulit') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                    </td>
                                    <td width="30%">
                                        <?php echo $model->warnakulit; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo CHtml::label('<b>Tinggi</b>', ''); ?>
                                    </td>
                                    <td>
                                        <?php echo (isset($model->tinggibadan)) ? $model->tinggibadan . ' cm' : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo CHtml::label('<b>Berat</b>', ''); ?>
                                    </td>
                                    <td>
                                        <?php echo (isset($model->beratbadan)) ? $model->beratbadan . ' kg' : ''; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="span12">
                    <div class="col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-file"></i> Data <b>User</b>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="a table-condensed" style="background:none;box-shadow:none;">
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>Nama Pemakai</b>', 'nama_pemakai'); ?>
                                        </td>
                                        <td width="30%">
                                            <?php
                                            $loginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                                            echo $loginpemakai->nama_pemakai;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>Terakhir Login</b>', 'terakhir login'); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $format->formatDateTimeForUser($loginpemakai->lastlogin); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>Tanggal Pembuatan</b>', 'tanggal pembuatan'); ?>
                                        </td>
                                        <td width="30%">
                                            <?php $format->formatDateTimeForUser($loginpemakai->tglpembuatanlogin); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>Tanggal Update</b>', 'tanggal update'); ?>
                                        </td>

                                        <td width="30%">
                                            <?php echo $format->formatDateTimeForUser($loginpemakai->tglupdatelogin); ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-file"></i> Data <b>Kepegawaian</b>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="a table-condensed" style="background:none;box-shadow:none;">
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('golonganpegawai_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo isset($model->golonganpegawai_id) ? $model->golonganpegawai->golonganpegawai_nama : ""; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('jabatan_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo isset($model->jabatan_id) ? $model->jabatan->jabatan_nama : ""; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('pangkat_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo isset($model->pangkat_id) ? $model->pangkat->pangkat_nama : ""; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kelompokpegawai_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo isset($model->kelompokpegawai_id) ? $model->kelompokpegawai->kelompokpegawai_nama : ""; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('jenistenagamedis_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo isset($model->jenistenagamedis_id) ? $model->jenistenagamedis->jenistenagamedis_nama : ""; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kategoripegawai') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->kategoripegawai; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kategoripegawaiasal') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->kategoripegawaiasal; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('kelompokjabatan') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->kelompokjabatan; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('jeniswaktukerja') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->jeniswaktukerja; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('pendidikan_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo isset($model->pendidikan_id) ? $model->pendidikan->pendidikan_nama : ""; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('pendkualifikasi_id') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo isset($model->pendkualifikasi_id) ? $model->pendkualifikasi->pendkualifikasi_nama : ""; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('tglditerima') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $format->formatDateTimeForUser($model->tglditerima); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('surattandaregistrasi') . '</b>', $model->getAttributeLabel('unit_perusahaan')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->surattandaregistrasi; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('suratizinpraktek') . '</b>', $model->getAttributeLabel('suratizinpraktek')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->suratizinpraktek; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('npwp') . '</b>', $model->getAttributeLabel('npwp')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->npwp; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('no_rekening') . '</b>', $model->getAttributeLabel('no_rekening')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->no_rekening; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('bank_no_rekening') . '</b>', $model->getAttributeLabel('bank_no_rekening')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo $model->bank_no_rekening; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            <?php echo CHtml::label('<b>' . $model->getAttributeLabel('gajipokok') . ' (Rp)</b>', $model->getAttributeLabel('gajipokok')); ?>
                                        </td>
                                        <td width="30%">
                                            <?php echo number_format($model->gajipokok, 0, '', '.'); ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Akses SIMRS
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="a table-condensed" style="background:none;box-shadow:none;">
                                    <tr valign="top">
                                        <td>
                                            <?php echo CHtml::label('<b>Akses Ruangan</b>', $model->getAttributeLabel('ruangan')); ?>
                                        </td>
                                        <td>
                                            <?php //$this->renderPartial('_ruanganPegawai',array('pegawai_id'=>$model->pegawai_id))
                                            ?>
                                            <?php
                                            $modRuang = $model->getAksesRuangan();
                                            if (count((array)$modRuang) > 0) {
                                                echo "<ul>";
                                                foreach ($modRuang as $i => $tampilDataR) {
                                                    echo "<li>" . $tampilDataR->ruangan->ruangan_nama . '</li>';
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo Yii::t('zii', 'Not set');
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td>
                                            <?php echo CHtml::label('<b>Akses Modul</b>', $model->getAttributeLabel('ruangan')); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $modModul = $model->getAksesModul();
                                            if (count((array)$modModul) > 0) {
                                                echo "<ul>";
                                                foreach ($modModul as $i => $tampilData) {
                                                    echo "<li>" . $tampilData->modul->modul_nama . '</li>';
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo Yii::t('zii', 'Not set');
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </div>
    <?php
    if (isset($_GET['frame'])) {
        if ($_GET['frame'] == 'frame') :
            $frame = 'frame';
        else :
            $frame = '';
        endif;
    } else {
        $frame = '';
    }
    if (!empty($model->pegawai_id)) {
        echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')), $this->createUrl('updateUser', array('modul_id' => Yii::app()->session['modul_id'], 'frame' => $frame)), array('class' => 'btn btn-danger',));
    }
    ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>