<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<style type='text/css'>
    .disabled-icon{
        opacity: 0.4;
        pointer-events: none;
    }
    #pasienpenunjangrujukan-m-grid {
        width: 100%;
        height: 500px;
        overflow: auto;
    }
    #pasienpenunjangrujukan-m-grid table thead {
        position: sticky;
        top: 0;
        background-color: #f5f5f5;
    }
</style>

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
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogKonfirm',
                    'options' => array(
                        'title' => '',
                        'autoOpen' => false,
                        'modal' => true,
                        'width' => 300,
                        'resizable' => false,
                    ),
                ));
                ?>
                <div class="divForForm"></div>
                <?php $this->endWidget(); ?>
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
                $this->renderPartial('_table', [
                    'dataProvider' => $dataProvider
                ]);
                ?>
            </div>
        </div>
        
    </div>
</div>
<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
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
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPilihPendaftaran',
    'options' => array(
        'title' => 'Pilih Pendaftaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 240,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
            data: $('#search-penunjangrujukan-form').serialize()
        }); }",
    ),
));
?>
<iframe name='framePilihPendaftaran' style="width: 100%; height: 98%;"></iframe>

<?php $this->endWidget(); ?>

<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPilihTglPeriksa',
    'options' => array(
        'title' => 'Pilih Tgl. Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
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

<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPemeriksaan',
    'options' => array(
        'title' => 'Riwayat Pemeriksaan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1600,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameRiwayatPemeriksaan' style="width: 100%; height: 98%;"></iframe>

<?php $this->endWidget(); ?>

<!-- Untuk popup riwayat -->

<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>


<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailDataPenunjang',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1200,
        'height' => 700,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogPenunjang" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailKonsulHasil',
    'options' => array(
        'title' => 'Hasil Jawaban Konsul',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailKonsulHasil">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailRiwayat',
    'options' => array(
        'title' => 'Ruang Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe frameborder="0" name="frameRiwayat" width="100%" height="700px"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>



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
    }

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

    function verifkirim(pendaftaran_id, pasienkirimkeunitlain_id) {
        myConfirm('Apakah Anda ingin mengirim pesan ke Whatsapp Pasien?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('radiologi/RujukanPenunjang/kirimWAPasien') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        pasienkirimkeunitlain_id: pasienkirimkeunitlain_id
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
                                data: $('#search-penunjangrujukan-form').serialize()
                            });
                        } else {
                            myAlert(data.pesan);
                        }
                    }, 'json'
                );
            }
        });
    }

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