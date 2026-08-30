<?php $linkHalaman = CustomFunction::getUrlByMenuID(3564); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Kebutuhan APD'
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
        $('#daftarkebutuhanapd-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarkebutuhanapd-grid', {
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
            <i class="entypo-info-circled"></i> Transaksi <b>Kebutuhan APD</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kebutuhan APD</b>
                </div>
            </div>
            <!--<div class="panel-body table-responsive">-->
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarkebutuhanapd-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Jenis Obat Alkes',
                            'type' => 'raw',
                            'value' => '$data->jenisobatalkes_nama'
                        ),
                        array(
                            'header' => 'Obat Alkes',
                            'type' => 'raw',
                            'value' => '$data->obatalkes_nama',
                        ),
                        array(
                            'header' => 'Sumber Dana',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->sumberdana_nama;
                            },
                        ),
                        array(
                            'name' => 'Kirim Data Kemenkes',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->tglpengiriminkemenkes)) {
                                    $namaPeg = "";
                                    if (!empty($data->pegawaipengirimkemenkes)) {
                                        $modPeg = PegawaiM::model()->findByPk($data->pegawaipengirimkemenkes);
                                        $namaPeg = (isset($modPeg) ? $modPeg->namaLengkap : "");
                                    }
                                    return "Sudah Dikirim " . MyFormatter::formatDateTimeForUser($data->tglpengiriminkemenkes) . " oleh " . $namaPeg;
                                } else {
                                    return CHtml::htmlButton(Yii::t('mds', '{icon} Belum Terkirim', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'tambahPasien("' . $data->obatalkes_id . '")'));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'name' => 'Ubah Data Kemenkes',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $label = "";
                                if (!empty($data->tglubahpengirimankemenkes)) {
                                    $namaPeg = "";
                                    if (!empty($data->pegawaiubahpengirimankemenkes)) {
                                        $modPeg = PegawaiM::model()->findByPk($data->pegawaiubahpengirimankemenkes);
                                        $namaPeg = (isset($modPeg) ? $modPeg->namaLengkap : "");
                                    }
                                    $label = "Perubahan Terakhir " . MyFormatter::formatDateTimeForUser($data->tglubahpengirimankemenkes) . " oleh " . $namaPeg;
                                } else {
                                    $label = "Belum Ada Perubahan";
                                }
                                return CHtml::htmlButton(Yii::t('mds', '{icon} ' . $label, array('{icon}' => '<i class="' . MyIcon::getIcons('ubah') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'ubahPasien("' . $data->obatalkes_id . '")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'name' => 'Hapus Data Kemenkes',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $label = "";
                                if (!empty($data->tglpenghapusankemenkes)) {
                                    $namaPeg = "";
                                    if (!empty($data->pegawaipenghapusankemenkes)) {
                                        $modPeg = PegawaiM::model()->findByPk($data->pegawaipenghapusankemenkes);
                                        $namaPeg = (isset($modPeg) ? $modPeg->namaLengkap : "");
                                    }
                                    $label = "Penghapusan data " . MyFormatter::formatDateTimeForUser($data->tglpenghapusankemenkes) . " oleh " . $namaPeg;
                                } else {
                                    $label = "Tidak Ada Penghapusan";
                                }
                                return CHtml::htmlButton(Yii::t('mds', '{icon} ' . $label, array('{icon}' => '<i class="' . MyIcon::getIcons('hapus') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'hapusPasien("' . $data->obatalkes_id . '")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
                <!--/div-->
            </div>
        </div>
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
    </div>
</div>
<script type="text/javascript">
    function tambahPasien(obatalkes_id) {
        $('#alertpesanPasien').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('PasienKemenkes'); ?>',
            data: {
                obatalkes_id: obatalkes_id,
                type: 'tambah'
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses > 0) {
                    $.fn.yiiGridView.update('daftarkebutuhanapd-grid', {
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

    function ubahPasien(obatalkes_id) {
        $('#alertpesanPasien').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('PasienKemenkes'); ?>',
            data: {
                obatalkes_id: obatalkes_id,
                type: 'ubah'
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses > 0) {
                    $.fn.yiiGridView.update('daftarkebutuhanapd-grid', {
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

    function hapusPasien(obatalkes_id) {
        $('#alertpesanPasien').html("");
        myConfirm("Apakah Anda yakin ingin menghapus data dari kemenkes?", "Perhatian !", function(r) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('deletePasienKemenkes'); ?>',
                data: {
                    obatalkes_id: obatalkes_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses > 0) {
                        $.fn.yiiGridView.update('daftarkebutuhanapd-grid', {
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