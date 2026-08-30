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
                <?php $this->renderPartial($this->path_view . '/_search', array('model' => $model)); ?>
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
                    $this->renderPartial($this->path_view. '._table', ['model' => $model]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '/_jsFunctions', []); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogCetakUlang',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Cetak Ulang</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 400,
        'resizable' => true
    ),
));
?>
<iframe name='iframeCetakUlang' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
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
        'height' => 500,
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
        'height' => 500,
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
        'title' => 'Detail Pengiriman Darah',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
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
        'title' => 'Detail Penerimaan Darah',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
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
        'height' => 500,
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

<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBuatJadwal',
    'options' => array(
        'title' => 'Penjadwalan Permintaan darah',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('permintaandarah-r-grid', {
            data: $('#permintaandarah-r-search').serialize()
        }); }",
    ),
));
?>
<iframe id='frameBuatJadwal', name='frameBuatJadwal' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>
<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKonsul',
    'options' => array(
        'title' => 'Konsultasi Poliklinik',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('permintaandarah-r-grid', {
            data: $('#permintaandarah-r-search').serialize()
        }); }",
    ),
));
?>
<iframe id='frameKonsul', name='frameKonsul' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>