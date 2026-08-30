<?php
$this->breadcrumbs = array(
    'Informasi Permintaan Darah Pasien',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#permintaandarah-r-search').submit(function(){
            $.fn.yiiGridView.update('permintaandarah-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$module  = $this->module->name;
$controller = $this->id;
$format = new MyFormatter();
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Permintaan Darah Pasien </b>
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
                <?php $this->renderPartial($this->path_view . '/_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Darah Pasien </b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'permintaandarah-r-grid',
                    'replaceUrl' => true,
                    'dataProvider' => $model->searchInformasiPermintaanDarahPasien(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'Tanggal Pendaftaran / Nomor Pendaftaran',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser($data['tgl_pendaftaran'] . " / " . $data['no_pendaftaran']);
                            },
                        ),
                        array(
                            'header' => 'Tanggal Permintaan / No. Permintaan',
                            'value' => function ($data) {
                                echo MyFormatter::formatDateTimeForUser($data['tglpermintaan']) . " / " . $data['no_permintaandarah'];
                            }
                        ),
                        array(
                            'header' => 'Ruangan Asal / DPJP ',
                            'value' => function ($data) {
                                echo $data['ruangan_nama'] . " / " . $data['dpjp_nama'];
                            }
                        ),
                        array(
                            'header' => 'No. RM',
                            'value' => '$data["no_rekam_medik"]',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => '$data["nama_pasien"]',
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'value' => '$data["jeniskelamin"]',
                        ),
                        array(
                            'header' => 'Alamat',
                            'value' => '$data["alamat_pasien"]',
                        ),
                        array(
                            'header' => 'Umur',
                            'value' => '$data["umur"]',
                        ),
                        array(
                            'header' => 'Gol. Darah / Rhesus',
                            'value' => '$data["kesimpulan_uji"]',
                        ),
                        array(
                            'header' => 'Penerimaan',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'value' => function ($data) {
                                if (empty($data['is_pasiensama']) && $data['is_pasiensama'] === false) {
                                    return CHtml::link(
                                        "BELUM DITERIMA",
                                        '',
                                        array(
                                            "class" => 'hover',
                                            "rel" => "tooltip",
                                            "onclick" => "myAlert('Verifikasi permintaan darah belum dilakukan');return false;",
                                            "title" => "Klik untuk melakukan penyerahan darah"
                                        )
                                    );
                                } else {
                                    if (empty($data['penyerahandarah'])) {
                                        if (!empty($data['penyiapandarah'])) {
                                            echo CHtml::link("<i class='icon-profuser'></i>", Yii::app()->createUrl('bankDarah/penyerahanDarah/index&id=' . $data['permintaandarah_id']), array("rel" => "tooltip", "title" => "Klik untuk melakukan Penerimaan Darah"));
                                        } else {
                                            echo CHtml::link("<i class='icon-profuser'></i>", "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk melakukan Penerimaan Darah", 'onclick' => 'myAlert("transaksi Penyiapan darah belum dilakukan ")', 'data-html' => true));
                                        }
                                    } else {
                                        foreach ($data['penyerahandarah'] as $siap) {
                                            echo CHtml::link(
                                                "<u>" . $siap['tglpenyerahandarah'] . "</u>",
                                                Yii::app()->createUrl('bankDarah/penyerahanDarah/index', array(
                                                    'id' => $data['permintaandarah_id'],
                                                    'ujidarahtube_id' => empty($siap['ujidarahtube_id']) ? $siap['ujidarahslide_id'] : $siap['ujidarahtube_id'],
                                                    'penyerahandarah_ke' => $siap['penyerahandarah_ke'],
                                                    'frame' => 1
                                                )),
                                                array(
                                                    "target" => "framePenyerahan",
                                                    "onclick" => "$('#dialogPenyerahan').dialog('open');",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk menampilkan Detail Penerimaan Darah"
                                                )
                                            );
                                            echo "<hr>";
                                        }
                                        if (!empty($data['penyiapandarahid'])) {
                                            if (count((array)$data['penyerahandarahid']) != count((array)$data['penyiapandarahid'])) {
                                                echo CHtml::link("<i class='icon-profuser'></i>", Yii::app()->createUrl('bankDarah/penyerahanDarah/index&id=' . $data['permintaandarah_id']), array("rel" => "tooltip", "title" => "Klik untuk melakukan Penerimaan Darah"));
                                            } else {
                                                if (count((array)$data['penyiapandarahid']) != count((array)$data['ujikompatibilitasrelease'])) {
                                                    echo CHtml::link("<i class='icon-pasienrujuk'></i>", "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk melakukan Penyiapan Darah", 'onclick' => 'myAlert("pengujian penyiapan darah belum dilakukan ")', 'data-html' => true));
                                                } else {
                                                    if (!empty($data['permintaandet'])) {
                                                        if (count((array)$data['permintaandet']) != $data['count_det']) {
                                                            echo CHtml::link("<i class='icon-pasienrujuk'></i>", "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk melakukan Penyiapan Darah", 'onclick' => 'myAlert("pengujian penyiapan darah belum dilakukan ")', 'data-html' => true));
                                                        }
                                                    } else {
                                                        echo CHtml::link("<i class='icon-pasienrujuk'></i>", "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk melakukan Penyiapan Darah", 'onclick' => 'myAlert("pengujian penyiapan darah belum dilakukan ")', 'data-html' => true));
                                                    }
                                                }
                                            }
                                        } else {
                                            echo CHtml::link("<i class='icon-pasienrujuk'></i>", "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk melakukan Penyiapan Darah", 'onclick' => 'myAlert("pengujian penyiapan darah belum dilakukan ")', 'data-html' => true));
                                        }
                                    }
                                }
                            }
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPembuatan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Permintaan Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 370,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('permintaandarah-r-grid'); }",
    ),
));
?>
<iframe src="" name="framePembuatan" style="width:100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pengujian Golongan Darah',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKompatibilitas',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pengujian Kompatibilitas',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameDetailKompatibilitas" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
// ===========================Dialog Penyiapan Darah =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenyiapan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penyiapan Darah',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="framePenyiapan" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
// ===========================Dialog Penyerahan Darah =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenyerahan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penyerahan Darah',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="framePenyerahan" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
// ===========================Dialog Verifikasi=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogVerifikasi',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Verifikasi Permintaan Darah',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 650,
        'resizable' => false,
        'scroll' => false,
    ),
));
?>
<iframe src="" id="frameVerifikasi" name="frameVerifikasi" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Daftar Petugas ',
        'autoOpen' => false,
        'modal' => true,
        'height' => 500,
        'width' => 800,
        'resizable' => false,
    ),
));
$modPegawai = new BDPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['BDPegawaiM']))
    $modPegawai->attributes = $_GET['BDPegawaiM'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugaspengirim-m-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $res = json_encode($data->attributes);
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setData(" . $res . "); return false; "
                ));
            }
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<script type="text/javascript">
    function reloadTabel() {
        myAlert('Pembatalan permintaan darah berhasil dilakukan');
        $.fn.yiiGridView.update('permintaandarah-r-grid');
    }

    function reloadTabelVerifikasi() {
        myAlert('Verifikasi permintaan darah berhasil dilakukan');
        $.fn.yiiGridView.update('permintaandarah-r-grid');
    }

    function setDialog(obj) {
        var dialog = "#dialogPetugas";
        $(dialog).dialog("open");
    }

    function setPeneliti(data) {
        $("#<?php echo CHtml::activeId($model, 'peneliti_id') ?>").val(data.peneliti_id);
        $("#<?php echo CHtml::activeId($model, 'peneliti_nama') ?>").val(data.peneliti_nama);
    }

    function setData(data) {
        var childiFrame = document.getElementById("frameVerifikasi").contentWindow.document;
        var pegawai_penerima_nama = childiFrame.getElementById("PermintaandarahT_pegawai_penerima_nama");
        pegawai_penerima_nama.value = data.nama_pegawai;
        var pegawai_penerima_id = childiFrame.getElementById("PermintaandarahT_pegawai_penerima_id");
        pegawai_penerima_id.value = data.pegawai_id;
        $("#dialogPetugas").dialog('close');
    }
</script>