<?php $linkHalaman = CustomFunction::getUrlByMenuID(2500); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemulasaran Jenazah',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemulasaran Jenazah</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari wew', "
            $('#daftarPasien-form').submit(function(){
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
        ");
        ?>
        <?php $this->renderPartial('_searchDaftarPasien', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemulasaran Jenazah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                    $this->renderPartial('_table', ['model' => $model]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk masuk kamar jenazah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCetakSurat',
    'options' => array(
        'title' => 'Print Surat Keterangan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 950,
        'height' => 450,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeCetakSurat" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end masuk kamar jenazah =============================
?>
<script>
    //document.getElementById('PJPasienmasukpenunjangV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('PJPasienmasukpenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#PJPasienmasukpenunjangV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('PJPasienmasukpenunjangV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('PJPasienmasukpenunjangV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('PJPasienmasukpenunjangV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('PJPasienmasukpenunjangV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        //		'show'=>'blind',
        //		'hide'=>'explode',
        'zIndex' => 1002,
        'width' => 350,
        'minHeight' => 100,
        'height' => 160,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianSudahBayar',
    'options' => array(
        'title' => 'Rincian Pasien Sudah Bayar',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincianSudahBayar' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>