<style>
    .button-status {
        margin-right: 8px;
    }

    .badge-status {
        position: relative;
        top: 8px;
        left: 8px;
    }

    .btn-status {
        min-width: 150px;
    }

    .badge-status-jmlPanggil {
        position: relative;
        top: 10px;
        left: 10px;
        z-index: 10;
    }
    
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Pasien Rujukan</strong></div>
            </div>
            <div class="panel-body">
                <?php
                Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('#search-penunjangrujukan-form').submit(function(){
					$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
							data: $(this).serialize()
					});
					return false;
				});
				");
                ?>
                <?php if (!empty($_GET['pendaftaran_id'])) { ?>
                    <div class="mds-form-message success">
                        <?php echo Yii::app()->user->getFlash('success'); ?>
                    </div>
                <?php } ?>

                <?php
                if (!empty($_GET['succes'])) {
                ?>

                    <div class="alert alert-block alert-success">
                        <a class="close" data-dismiss="alert">×</a>
                        <?php
                        if ($_GET['succes'] == 2) {
                        ?>
                            Pemeriksaan Pasien berhasil di batalkan
                        <?php
                        }
                        if ($_GET['succes'] == 1) {
                        ?>
                            Pasein Berhasil Di Rujuk
                        <?php
                        }
                        ?>
                    </div>

                <?php
                }
                ?>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Pasien Rujukan</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="block-tabel">
                            <?php
                            $this->widget('bootstrap.widgets.BootAlert');
                            $this->renderPartial('_table', ['model' => $model]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formSearch', array('model' => $model, 'format' => $format)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================

?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Penjadwalan Pemeriksaan Mikrobiologi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMintaUlang',
    'options' => array(
        'title' => 'Permintaan Ulang Sampel',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<iframe name='frameMintaUlang' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKonsultasi',
    'options' => array(
        'title' => 'Konsultasi Poliklinik',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe name='frameKonsultasi' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php echo $this->renderPartial('_jsFunctions', array()); ?>
<?php
// tgl pemeriksaan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPilihTglPeriksa',
    'options' => array(
        'title' => 'Pilih Tgl. Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
            data: $('#search-penunjangrujukan-form').serialize()
        }); }",
    ),
));
?>
<iframe name='framePilihTglPeriksa' style="width: 100%; height: 98%;"></iframe>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    /*
    document.getElementById('LBPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:none;");
    document.getElementById('LBPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:none;");
    function cekTanggal() {

        var checklist = $('#LBPasienKirimKeUnitLainV_cbTglMasuk');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
    */


    function batalperiksa(pendaftaran_id, idKirimUnit) {
        myConfirm('Anda yakin akan membatalkan rujukan laboratorium pasien ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalRujuk') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idKirimUnit: idKirimUnit
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            if (data.smspasien == 0) {
                                var params = [];
                                params = {
                                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                                    isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                                }; // 16 
                                insert_notifikasi(params);
                            }
                            myAlert(data.keterangan);
                            // window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                            //                                 $('#dialogKonfirm div.divForForm').html(data.keterangan);
                            $('#dialogKonfirm').dialog('open');
                            //console.log('test');
                            $('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
                            //                        JQuery('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
                        } else {
                            myAlert(data.keterangan);
                        }
                    }, 'json'
                );
            }
        });
    }


    /**
     * 
     * @param {type} pendaftaran_id
     * @param {type} statusperiksa
     * @param {type} namaPasien
     * @returns {undefined}
     */
    function dialogBatalPeriksa(pendaftaran_id, pasienkirimkeunit_id, namaPasien) {
        $('#titleNamaPasienBatal').html(namaPasien);
        $('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
        $('#DialogBatalperiksa #pasienkirimkeunit_id').val(pasienkirimkeunit_id);
        $('#DialogBatalperiksa').dialog('open');
    }

    function ubahPeriksaKarenaBatal() {
        var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
        var pasienkirimkeunit_id = $('#DialogBatalperiksa #pasienkirimkeunit_id').val();
        var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
        var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();

        $('#DialogBatalperiksa #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
            $('#DialogBatalperiksa #keterangan_batal').attr('class', 'error');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('batalRujuk'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal,
                idKirimUnit: pasienkirimkeunit_id
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    $('#DialogBatalperiksa').dialog('close');
                    if (data.smspasien == 0) {
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                            judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                            isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                        }; // 16 
                        insert_notifikasi(params);
                    }
                    myAlert(data.keterangan);
                    // window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                    //                                 $('#dialogKonfirm div.divForForm').html(data.keterangan);
                    $('#dialogKonfirm').dialog('open');

                    //console.log('test');
                    $('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
                    //                        JQuery('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
                } else {
                    myAlert(data.keterangan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
</script>