<style>
    .error {
        background: #b94a48 1px solid !important;
        color: #b94a48;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien MCU' => Yii::app()->request->getUrlReferrer(),
    'Pendaftaran Pasien MCU'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Pendaftaran Pasien <b>Medical Check Up</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'class'=>'form_pendaftaran'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>

        <div class="clear"></div>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien Baru</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php
                echo $form->hiddenField($modPasien, 'pegawai_id', array('class' => ''));
                $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab));
                ?>
            </div>
        </div>

        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view_mcu . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modPegawai' => $modPegawai, 'modSep' => $modSep)); ?>
                <?php echo $form->hiddenField($model, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-users"></i> Riwayat Kunjungan Pasien
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view_mcu . '_tableRiwayatPasien', array('form' => $form, 'modPasien' => $modPasien,), true); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Paket <b>Medical Check Up</b>
                </div>
            </div>
            <div class="panel-body">
                <div id='content-pemeriksaan-mcu-paket'>
                    <?php
                    $this->renderPartial($this->path_view_mcu . '_formCariPemeriksaan', array(
                        'modPaketPelayanan' => $modPaketPelayanan,
                    ));
                    ?>
                    <div class="row">
                        <div class='checklists'></div>
                    </div>
                </div>

                <!-- <table id="tabel-paketmcu">
            <tbody>
            </tbody>
        </table> -->

                <hr style="margin: 10px 0;">

                <div class="control-group">
                    <div class="checkbox inline">
                        <i class="glyphicon glyphicon-file"></i> <b>Pernah Ke MCU</b>
                        <?php echo CHtml::activeCheckBox($modPemeriksaanMcu, 'pernahmcu', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanMcu, 'tglrencanaperiksa', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaanMcu,
                            'attribute' => 'tglrencanaperiksa',
                            'mode' => 'datetime',
                            'options' => array(
                                'showOn' => false,
                                'minDate' => 'd',
                            ),
                            'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($modPemeriksaanMcu, 'tglrencanaperiksa'); ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modPemeriksaanMcu, 'keteranganpermintaan', array('placeholder' => 'Keterangan Permintaan', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanMcu, 'keteranganpermintaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php //echo $modPemeriksaanMcu->keteranganpermintaan; 
                        ?>
                        <?php
                        //LNG-2729
                        echo $form->textarea($modPemeriksaanMcu, 'keteranganpermintaan', array('row' => 3, 'class' => 'span4', 'placeholder' => 'Keterangan Permintaan'))
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Tabel <b>Pemeriksaan MCU</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="form-tindakanpemeriksaan">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Ruangan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Nominal Tarif (Rp)</th>
                        <th>Total Tarif (Rp)</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right;"><label>Grand Total</label></th>
                            <th style="text-align:right;"><?php echo CHtml::textField('totalMcu', '', array('readonly' => true, 'readonly' => true, 'class' => 'span1 integer', 'style' => 'width:96px;text-align:right')); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Pilih Pemeriksaan Diluar Paket', array('{icon}' => '<i class="icon-check icon-white"></i>')), '#', array(
                'class' => 'btn btn-primary',
                'onclick' => '$("#dialogPemeriksaan").dialog("open");updateChecklistTindakanMcuDiluarPaket();return false;'
            ));
            ?>
        </div>

        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan MCU - Di Luar Paket</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="form-tindakanpemeriksaan-diluar-paket">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Ruangan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Nominal Tarif (Rp)</th>
                        <th>Total Tarif (Rp)</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right;"><label>Grand Total</label></th>
                            <th style="text-align:right;"><?php echo CHtml::textField('totalDiluarMcu', '', array('readonly' => true, 'readonly' => true, 'class' => 'span1 integer', 'style' => 'width:96px;text-align:right')); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                );
                ?>
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien('$model->pasien_id');return false", 'disabled' => FALSE));
                ?>
                <?php
                $content = $this->renderPartial($this->path_view_mcu . 'tips/tipsPendaftaranRawatJalan', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaan',
    'options' => array(
        'title' => 'Pemeriksaan di Luar Paket',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 550,
        'resizable' => false,
    ),
));
?>

<div id='content-pemeriksaan-mcu-diluar-paket'>
    <div class="col-sm-12">
        <?php
        $this->renderPartial($this->path_view_mcu . '_formCariPemeriksaanDiluarPaket', array(
            'modPaketPelayanan' => $modPaketPelayanan,
        ));
        ?>
        <div class='checklists-mcu-diluar-paket'></div>
    </div>
</div>

<?php
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-verifikasi',
    'options' => array(
        'title' => 'Verifikasi Pendaftaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';
?>

<div class="col-sm-12 clear">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this);$("#content-pemeriksaan-mcu-diluar-paket").html("");$("#pppendaftaran-t-form").submit();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php echo $this->renderPartial($this->path_view_mcu . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modPermintaanMcu' => $modPermintaanMcu, 'modPemeriksaanMcu' => $modPemeriksaanMcu, 'modAsuransiPasien' => $modAsuransiPasien, 'modPegawai' => $modPegawai, 'modTindakan' => $modTindakan, 'modPenanggungJawab' => $modPenanggungJawab)); ?>
<script>
    function loadPaketTindakan() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadDataPaket'); ?>',
            data: {
                tipepaket_id: <?= $modPermintaanMcu->tipepaket_id; ?>,
                ruangan_id: <?= $model->ruangan_id; ?>
            },
            dataType: "json",
            success: function(data) {
                $("#form-tindakanpemeriksaan").find('tbody').html(data.gen);
                totalPaketMcu();
                $("input[class*='pilih-paketpelayanan'][value='<?= $modPermintaanMcu->tipepaket_id ?>']").attr('checked', true);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function loadNonPaketTindakan() {
        <?php
        if (count((array)$dataTindakans) > 0) {
            foreach ($dataTindakans as $key => $value) {
        ?>
                var daftartindakan_id = <?= $value->daftartindakan_id ?>;
                var daftartindakan_nama = '<?= $value->daftartindakan->daftartindakan_nama ?>';
                var tipepaket_id = <?= $value->tipepaket_id ?>;
                var ruangan_id = <?= $value->ruangan_id ?>;
                var tarifpaketpel = <?= $value->tarif_tindakan ?>;
                var ruangan_nama = '<?= $value->ruangan->ruangan_nama ?>';
                var rowtindakan = [];
                rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_mcu . '_rowTindakanPemeriksaanMcuDiluarPaket', array('i' => 0, 'modTindakan' => $modTindakan), true)); ?>';
                $("#form-tindakanpemeriksaan-diluar-paket").find('tbody').append(rowtindakan);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tindakanpelayanan_id]"]').val(<?= $value->tindakanpelayanan_id ?>);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tipepaket_id]"]').val(tipepaket_id);
                $("#form-tindakanpemeriksaan-diluar-paket").find('span[name$="[ii][namatindakan]"]').html(daftartindakan_nama);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][ruangan_id]"]').val(ruangan_id);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][ruangan_nama]"]').val(ruangan_nama);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][ruangantujuan_id]"]').val(ruangan_id);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][qty_tindakan]"]').val(1);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tarif_satuan]"]').val(tarifpaketpel);
                $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(tarifpaketpel));
                $("#form-tindakanpemeriksaan-diluar-paket").find('a').tooltip({
                    "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
                });
                totalDiluarMcu();
                renameInputRowTindakan($("#form-tindakanpemeriksaan-diluar-paket"), ruangan_id);
        <?php
            }
        }
        ?>

    }

    $(document).ready(function() {

        updateChecklistTindakanMcu();
        loadPaketTindakan();
        loadNonPaketTindakan();

        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form');
        });
        cekDisabled('form');
        $("#content-pemeriksaan-mcu-diluar-paket").find("input, select, textarea").attr("readonly", false);
    });
</script>