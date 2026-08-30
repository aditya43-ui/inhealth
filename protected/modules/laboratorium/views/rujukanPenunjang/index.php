<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Informasi <b>Pasien Rujukan</b>
        </div>
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formSearch', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rujukan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                    $this->widget('bootstrap.widgets.BootAlert');
                    $this->renderPartial('_table', ['model' => $model]);
                ?>
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
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================
?>


<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPilihTglPeriksa',
    'options' => array(
        'title' => 'Pilih Tgl. Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
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

     /**
     * print status
     */
    function printStatus(pendaftaran_id, pasienkirimkeunitlain_id) {
        window.open('<?php echo $this->createUrl('printStatusLab'); ?>&pendaftaran_id=' + pendaftaran_id +'&pasienkirimkeunitlain_id=' + pasienkirimkeunitlain_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
</script>