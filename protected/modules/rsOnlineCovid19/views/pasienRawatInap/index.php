<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien'
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
        $('#daftarPasien-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
?>
<div id="alertpesanPasien"></div>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_formPencarian', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!-- <div class="" style="overflow-x: auto"> -->
                <!--div class="block-tabel"-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchRI(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Admisi / Masuk Kamar',
                            'type' => 'raw',
                            'value' => '$data->tglAdmisiMasukKamar'
                        ),
                        //                    'ruangan_nama',
                        array(
                            'name' => 'caramasuk_nama',
                            'type' => 'raw',
                            'value' => '$data->caramasuk_nama',
                        ),
                        array(
                            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->namadepan . $data->nama_pasien;
                            },
                        ),
                        array(
                            'header' => 'Tanggal Lahir',
                            'name' => 'tanggal_lahir',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)'
                        ),
                        array(
                            'header' => 'Jenis Penjamin / Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        array(
                            'header' => 'Dokter Penerima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->dokterpenerima_id)) {
                                    return "-";
                                }
                                $pegawai = PegawaiM::model()->findByPk($data->dokterpenerima_id);
                                return $pegawai->namaLengkap;
                            },
                        ),
                        array(
                            'header' => 'DPJP',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $nama = "<br>";
                                if (!empty($data->dpjp1_id)) {
                                    $pegawai = PegawaiM::model()->findByPk($data->dpjp1_id);
                                    $nama .= "DPJP 1 : " . $pegawai->namaLengkap . "</br>";
                                }
                                if (!empty($data->dpjp2_id)) {
                                    $pegawai = PegawaiM::model()->findByPk($data->dpjp2_id);
                                    $nama .= "DPJP 2 : " . $pegawai->namaLengkap . "</br>";
                                }
                                if (!empty($data->dpjp3_id)) {
                                    $pegawai = PegawaiM::model()->findByPk($data->dpjp3_id);
                                    $nama .= "DPJP 3 : " . $pegawai->namaLengkap . "</br>";
                                }
                                return $nama;
                            },
                        ),
                        array(
                            'name' => 'kelaspelayanan_nama',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->jeniskasuspenyakit_nama;
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                                'class' => 'list_kasus_penyakit'
                            )
                        ),
                        array(
                            'header' => 'No. Kamar/<br>No. Bed',
                            'name' => 'kamarruangan_nokamar',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return "Kmr : " . $data->kamarruangan_nokamar .
                                    "<br>" . "Bed : " .
                                    $data->kamarruangan_nobed;
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'name' => 'Alergi Obat',
                            'type' => 'raw',
                            'value' => '$data->AlergiObat',
                            'htmlOptions' => array('style' => 'text-align: left; width:120px'),
                            'headerHtmlOptions' => array('style' => 'width:120px'),
                        ),
                        array(
                            'name' => 'Kirim Data Kemenkes',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                if (!empty($pendaftaran->tglpengiriminkemenkes)) {
                                    $namaPeg = "";
                                    if (!empty($pendaftaran->pegawaipengirimkemenkes)) {
                                        $modPeg = PegawaiM::model()->findByPk($pendaftaran->pegawaipengirimkemenkes);
                                        $namaPeg = (isset($modPeg) ? $modPeg->namaLengkap : "");
                                    }
                                    return "Sudah Dikirim " . MyFormatter::formatDateTimeForUser($pendaftaran->tglpengiriminkemenkes) . " oleh " . $namaPeg;
                                } else {
                                    return CHtml::htmlButton(Yii::t('mds', '{icon} Belum Terkirim', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'tambahPasien("' . $data->pendaftaran_id . '")'));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            //                                    'headerHtmlOptions'=>array('style'=>'width:120px'),
                        ),
                        array(
                            'name' => 'Ubah Data Kemenkes',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                $label = "";
                                if (!empty($pendaftaran->tglubahpengirimankemenkes)) {
                                    $namaPeg = "";
                                    if (!empty($pendaftaran->pegawaiubahpengirimankemenkes)) {
                                        $modPeg = PegawaiM::model()->findByPk($pendaftaran->pegawaiubahpengirimankemenkes);
                                        $namaPeg = (isset($modPeg) ? $modPeg->namaLengkap : "");
                                    }
                                    $label = "Perubahan Terakhir " . MyFormatter::formatDateTimeForUser($pendaftaran->tglubahpengirimankemenkes) . " oleh " . $namaPeg;
                                } else {
                                    $label = "Belum Ada Perubahan";
                                }
                                return CHtml::htmlButton(Yii::t('mds', '{icon} ' . $label, array('{icon}' => '<i class="' . MyIcon::getIcons('ubah') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'ubahPasien("' . $data->pendaftaran_id . '")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            //                                    'headerHtmlOptions'=>array('style'=>'width:120px'),
                        ),
                        array(
                            'name' => 'Hapus Data Kemenkes',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                $label = "";
                                if (!empty($pendaftaran->tglpenghapusankemenkes)) {
                                    $namaPeg = "";
                                    if (!empty($pendaftaran->pegawaipenghapusankemenkes)) {
                                        $modPeg = PegawaiM::model()->findByPk($pendaftaran->pegawaipenghapusankemenkes);
                                        $namaPeg = (isset($modPeg) ? $modPeg->namaLengkap : "");
                                    }
                                    $label = "Penghapusan data " . MyFormatter::formatDateTimeForUser($pendaftaran->tglpenghapusankemenkes) . " oleh " . $namaPeg;
                                } else {
                                    $label = "Tidak Ada Penghapusan";
                                }
                                return CHtml::htmlButton(Yii::t('mds', '{icon} ' . $label, array('{icon}' => '<i class="' . MyIcon::getIcons('hapus') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'hapusPasien("' . $data->pendaftaran_id . '")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            //                                    'headerHtmlOptions'=>array('style'=>'width:120px'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
                <!--/div-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function tambahPasien(pendaftaran_id) {
        $('#alertpesanPasien').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('PasienKemenkes'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                type: 'tambah'
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses > 0) {
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()
                    });
                    myAlert(data.pesan);
                } else {
                    $('#alertpesanPasien').html("");
                    if (data.pesanType == 0) {
                        myAlert(data.pesan);
                    } else {
                        $('#alertpesanPasien').html(data.pesan);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function ubahPasien(pendaftaran_id) {
        $('#alertpesanPasien').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('PasienKemenkes'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                type: 'ubah'
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses > 0) {
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()
                    });
                    myAlert(data.pesan);
                } else {
                    if (data.pesanType == 0) {
                        myAlert(data.pesan);
                    } else {
                        $('#alertpesanPasien').html(data.pesan);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hapusPasien(pendaftaran_id) {
        $('#alertpesanPasien').html("");
        myConfirm("Apakah Anda yakin ingin menghapus data dari kemenkes?", "Perhatian !", function(r) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('deletePasienKemenkes'); ?>',
                data: {
                    pendaftaran_id: pendaftaran_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses > 0) {
                        $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $(this).serialize()
                        });
                        myAlert(data.pesan);
                    } else {
                        $('#alertpesanPasien').html("");
                        if (data.pesanType == 0) {
                            myAlert(data.pesan);
                        } else {
                            $('#alertpesanPasien').html(data.pesan);
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    }
</script>