<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan'
);
$module = $this->module->id;
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Rujukan</b>
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
                <?php $this->renderPartial('_formSearch', array('model' => $model)); ?>
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
                    $this->renderPartial('_table', ['dataProvider' => $dataProvider, 'module' => $module]);
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#cbTglMasuk');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('tgl_akhir_date').setAttribute("style", "display:none;");
        }
    } {
        function batalRujuk(pendaftaran_id, idKirimUnit) {
            myConfirm("Apakah Anda yakin akan membatalkan rujukan bedah sentral pasien ini?", "Perhatian!", function(r) {
                if (r) {
                    $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalRujuk') ?>', {
                            pendaftaran_id: pendaftaran_id,
                            idKirimUnit: idKirimUnit
                        },
                        function(data) {
                            //if(data.status == 'ok'){
                            // window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                            // $('#dialogKonfirm div.divForForm').html(data.keterangan);
                            ///$('#dialogKonfirm').dialog('open');
                            // }
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
                                //$('#dialogKonfirm').dialog('open');
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

        function cekDataSignIn(obj) {
            var url = $(obj).attr('url');
            myConfirm("Apakah Anda yakin, tetap melanjutkan ke transaksi rencana operasi, karena data <b>Sign In</b> belum di inputkan", "perhatian", function(r) {
                if (r) {
                    window.location = url;
                } else {
                    return false;
                }
            });
            return false;
        }
    }
</script>

<script>

function batalperiksa(pendaftaran_id, idKirimUnit) {
        myConfirm("Apakah Anda yakin akan membatalkan rujukan radiologi pasien ini?", "Perhatian!", function(r) {
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
                            // window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                            myAlert(data.keterangan);
                            //                                 $('#dialogKonfirm').dialog('open');
                            $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
                                data: $('#search-penunjangrujukan-form').serialize()
                            });
                            return false;
                        }
                    }, 'json'
                );
            }
        });
    }
    
</script>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKonfirm',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 500,
        'height' => 200,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<!--Dialog untuk persetujuan-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPersetujuan',
    'options' => array(
        'title' => 'Persetujuan Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close'=>"js:function(){ $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
                        data: $(this).serialize()
                }); }",
    ),
));
?>
<iframe name='framePersetujuan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
// Dialog untuk mengisi form sign in =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSignIn',
    'options' => array(
        'title' => 'Transaksi Sign In',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 700,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
			data: $('#daftarPasiens-form').serialize()
		}); }",
    ),
));
?>
<iframe name='frameStatusDokumen' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget();
// end ============== 
?>

<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogInformConsent',
    'options' => array(
        'title' => 'Inform Consent',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
    ),
));
?>
<iframe name='frameInformConsent' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>

    <?php
// Dialog cetak label gelang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogGeneralConsent',
    'options' => array(
        'title' => 'General Consent',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,        
    ),
));
?>
<iframe id="frameGeneralConsent" name='frameGeneralConsent' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<script>

function ubahWarna() {
        // find baris kolom 
        $('#pasienpenunjangrujukan-m-grid > table > tbody > tr').each(function () {
            var tbl = $(this).find('.ubah').val();
            if (tbl === "cito") {
                // set jika nilai selain kondisi di atas warna merah
                $(this).find('td').attr('style', 'background: #F5B9B9 !important');
            } else {
                // set jika kondisi di atas warna putih
                $(this).find('td').attr('style', 'background: white !important');
            }
        });
    }

    $(document).ready(function () {
        ubahWarna();
    });
    
</script>