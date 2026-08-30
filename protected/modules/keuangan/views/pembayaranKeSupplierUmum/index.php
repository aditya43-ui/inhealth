<style type="text/css">
    .integer-decimal {
        text-align: right;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->breadcrumbs = array(
    'Pembayaran Ke Supplier Umum',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bayarkesupplier-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return cekInputan();'
    ),
));

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Supplier</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Faktur</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                //if (!empty($modTerimaPersediaan->terimapersediaan_id)){
                //	$this->renderPartial('_dataFakturBeli',array('modTerimaPersediaan'=>$modTerimaPersediaan)); 
                //}else{
                $this->renderPartial('_dataFakturBeliBaru', array(
                    'modTerimaPersediaan' => $modTerimaPersediaan,
                    'modTerimaMakanan' => $modTerimaMakanan,
                ));
                //}
                ?>

                <?php echo $form->errorSummary(array($modelBayar, $modBuktiKeluar)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Detail Pembayaran Supplier</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="tblBayarOA" class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>Jenis Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Terima</th>
                            <th>Harga Satuan</th>
                            <th>Keringanan (Rp)</th>
                            <th>PPN (Rp)</th>
                            <th>PPh (Rp)</th>
                            <!--<th>Harga Beli</th>-->
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        if (!empty($modTerimaPersediaan->terimapersediaan_id)) {
                            foreach ($modDetailPersediaan as $i => $detail) {
                                $jmlQty = ($detail->hargasatuan * $detail->jmlterima);
                                $jmlDiskon = round((($jmlQty * $detail->persendiscount) / 100), 2);
                                $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn) / 100), 2);
                                $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph) / 100), 2);
                                $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph), 2);

                                $total += $totalAll;
                        ?>
                                <tr>
                                    <td>
                                        <?php echo (isset($detail->barang->jenisbarangs) ? $detail->barang->jenisbarangs->jenisbarang_nama : ""); ?>
                                    </td>
                                    <td>
                                        <?php echo $detail->barang->barang_nama; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($detail->jmlterima, 2, ",", ".") . ' ' . $detail->satuanbeli; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($detail->hargasatuan, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($jmlDiskon, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($jmlPpn, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($jmlPph, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($detail->hargabeli, 2, ",", "."); ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else if (!empty($modTerimaMakanan->terimabahanmakan_id)) {
                            foreach ($modDetailMakanan as $i => $detail) {
                                $jmlQty = ($detail->harganettobhn * $detail->qty_terima);
                                $jmlDiskon = round((($jmlQty * $detail->persendiscount) / 100), 2);
                                $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn) / 100), 2);
                                $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph) / 100), 2);
                                $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph), 2);

                                $total += $totalAll;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $detail->bahanmakanan->kelbahanmakanan; ?>
                                    </td>
                                    <td>
                                        <?php echo $detail->bahanmakanan->namabahanmakanan; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($detail->qty_terima, 2, ",", ".") . ' ' . $detail->satuanbahan; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($detail->harganettobhn, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($jmlDiskon, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($jmlPpn, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($jmlPph, 2, ",", "."); ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php echo number_format($detail->hargajualbhn, 2, ",", "."); ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tbody>
                        <tr>
                            <td style="text-align: right" colspan="7">Total</td>
                            <td style="text-align: right"><?php echo number_format($total, 2, ",", "."); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pembayaran Ke Supplier Umum
                </div>
            </div>
            <div class="panel-body">
                <div class='row'>
                    <div class='col-sm-6'>
                        <?php echo $form->hiddenField($modelBayar, 'terimapersediaan_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($modelBayar, 'terimabahanmakan_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                        <div class="control-group">
                            <?php $modelBayar->tglbayarkesupplier = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modelBayar->tglbayarkesupplier, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php echo $form->labelEx($modelBayar, 'tglbayarkesupplier', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modelBayar,
                                    'attribute' => 'tglbayarkesupplier',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                    ),
                                )); ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modBuktiKeluar,
                                    'attribute' => 'tglkaskeluar',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                    ),
                                )); ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modelBayar->tgljatuhtempo = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modelBayar->tgljatuhtempo, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php echo $form->labelEx($modelBayar, 'tgljatuhtempo', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modelBayar,
                                    'attribute' => 'tgljatuhtempo',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                    ),
                                )); ?>

                            </div>
                        </div>
                        <?php
                        $modelBayar->totaltagihan = number_format($modelBayar->totaltagihan, 2, ",", ".");
                        echo $form->textFieldRow($modelBayar, 'totaltagihan', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        $modelBayar->jmldibayarkan = number_format($modelBayar->jmldibayarkan, 2, ",", ".");
                        echo $form->textFieldRow($modelBayar, 'jmldibayarkan', array('class' => 'inputFormTabel integer-decimal span3', 'onblur' => 'hitungKasKeluar();', 'onkeyup' => 'hitungKasKeluar()', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>


                        <?php // if(isset($modTerimaMakanan)){ 
                        ?>

                        <?php // } 
                        ?>


                        <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('onkeyup' => 'hitungKasKeluar();', 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaongkos_kirim', array('onkeyup' => 'hitungKasKeluar();', 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class='col-sm-6'>
                        <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <div id="divCaraBayarTransfer">
                            <div class="control-group">
                                <?php echo CHtml::label('Nama Bank Pengirim', 'bank_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $modBank = BankM::getItems($modBuktiKeluar->bank_id);
                                    echo $form->dropDownList($modBuktiKeluar, 'bank_id', CHtml::listData($modBank, 'bank_id', 'namabank'), array(
                                        'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank(this);',
                                        'onkeyup' => "return $(this).focusNextInputField(event);"
                                    ));
                                    ?>
                                </div>
                            </div>
                            <?php echo CHtml::activeHiddenField($modBuktiKeluar, 'melalubank', array('readonly' => true, 'class' => 'span3')); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array(
                                'class' => 'span3',
                                'placeholder' => 'Dengan Rekening',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                            )); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array(
                                'class' => 'span3',
                                'placeholder' => 'Atas Nama Rekening',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                            )); ?>
                        </div>

                        <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('placeholder' => 'Nama Penerima', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('placeholder' => 'Alamat Penerima', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('placeholder' => 'Sebagai Pembayaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disabled = ((isset($_GET['bayarkesupplier_id'])) ? true : false);
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanDataTransaksi();', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabled)
            );
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/pembayaranKeSupplierUmum/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/pembayaranKeSupplierUmum/index') . '";}); return false;'
                )
            );
            ?>
            <?php
            if (isset($_GET['terimapersediaan_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => FALSE));
            } else {

                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE));
            }
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        formCarabayar($('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val());
        $('.integer2').each(function() {
            this.value = formatNumber(this.value)
        });
        hitungKasKeluar();
    });

    function bukaDialogTerima() {
        $("#" + $("#jenisterima :selected").data('dialog')).dialog('open');
    }

    function resetTerima() {
        resetFormBayarSupplier();
    }

    function cekInputan() {
        $('.integer2').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }

    function simpanDataTransaksi() {
        if (requiredCheck($("form"))) {
            $('.integer-decimal, .integer2, .float2').each(function() {
                $(this).val(unformatNumber($(this).val()));
            });
            $("#bayarkesupplier-t-form").submit();
        }
        return false;
    }

    function hitungKasKeluar() {
        unformatNumberSemua();
        var jmlBayar = parseFloat($('#<?php echo CHtml::activeId($modelBayar, 'jmldibayarkan') ?>').val());
        var biayaAdmin = parseFloat($('#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi') ?>').val());
        var biayaongkos_kirim = parseFloat($('#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaongkos_kirim') ?>').val());
        var kasKeluar = jmlBayar + biayaAdmin + biayaongkos_kirim;

        $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar') ?>').val(kasKeluar);
        formatNumberSemua();
    }

    function formCarabayar(carabayar) {
        if (carabayar === 'TRANSFER') {
            $('#divCaraBayarTransfer').show();
        } else {
            $('#divCaraBayarTransfer').hide();
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
        }
    }

    function setNamaBank(obj) {
        var bank = $(obj).val();

        if (bank !== '') {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('GetMasterBank'); ?>',
                data: {
                    bank_id: bank
                },
                dataType: "json",
                success: function(data) {
                    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val(data.norekening);
                    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val(data.namabank);
                    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val(data.namabank);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    myAlert("Data Setoran Utang Pajak tidak ditemukan!");
                }
            });
        }
    }

    function print() {
        var terimapersediaan_id = "<?php echo isset($modTerimaPersediaan->terimapersediaan_id) ? $modTerimaPersediaan->terimapersediaan_id : null; ?>";
        var terimabahanmakan_id = "<?php echo isset($modelBayar->terimabahanmakan_id) ? $modelBayar->terimabahanmakan_id : null; ?>";
        var bayarkesupplier_id = "<?php echo isset($modelBayar->bayarkesupplier_id) ? $modelBayar->bayarkesupplier_id : null; ?>";

        window.open("<?php echo $this->createUrl('print') ?>&terimapersediaan_id=" + terimapersediaan_id + "&terimabahanmakan_id=" + terimabahanmakan_id + "&bayarkesupplier_id=" + bayarkesupplier_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
    }

    function loadDetail(id) {
        $.post('<?php echo $this->createUrl('LoadDetailTerima'); ?>', {
            id: id
        }, function(data) {
            $("#tblBayarOA tbody").html(data.tr);

            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'namapenerima') ?>").val(data.modBuktiKeluar.namapenerima);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'alamatpenerima') ?>").val(data.modBuktiKeluar.alamatpenerima);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran') ?>").val(data.modBuktiKeluar.untukpembayaran);

            $("#<?php echo CHtml::activeId($modelBayar, 'terimapersediaan_id') ?>").val(data.modBayarSupplier.terimapersediaan_id);
            $("#<?php echo CHtml::activeId($modelBayar, 'totaltagihan') ?>").val(data.modBayarSupplier.totaltagihan);
            $("#<?php echo CHtml::activeId($modelBayar, 'jmldibayarkan') ?>").val(data.modBayarSupplier.jmldibayarkan);

            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nopenerimaan') ?>").val(data.modTerima.nopenerimaan);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglterima') ?>").val(data.modTerima.tglterima);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nosuratjalan') ?>").val(data.modTerima.nosuratjalan);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglsuratjalan') ?>").val(data.modTerima.tglsuratjalan);

            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'totalharga') ?>").val(data.modTerima.totalharga);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'discount') ?>").val(data.modTerima.discount);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'pajakppn') ?>").val(data.modTerima.pajakppn);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'biayaadministrasi') ?>").val(data.modTerima.biayaadministrasi);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'totalkeseluruhan') ?>").val(data.modTerima.totalkeseluruhan);

            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'supplier_nama') ?>").val(data.modBuktiKeluar.namapenerima);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nofaktur') ?>").val(data.modTerima.nofaktur);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglfaktur') ?>").val(data.modTerima.tglfaktur);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'keterangan_persediaan') ?>").val(data.modTerima.keterangan_persediaan);

            hitungKasKeluar();

            //		unformatNumberSemua();
            //		formatNumberSemua();
        }, 'json');
    }

    function loadDetailBahan(id) {
        $.post('<?php echo $this->createUrl('LoadDetailTerimaBahan'); ?>', {
            id: id
        }, function(data) {
            $("#tblBayarOA tbody").html(data.tr);

            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'namapenerima') ?>").val(data.modBuktiKeluar.namapenerima);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'alamatpenerima') ?>").val(data.modBuktiKeluar.alamatpenerima);
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran') ?>").val(data.modBuktiKeluar.untukpembayaran);

            $("#<?php echo CHtml::activeId($modelBayar, 'terimapersediaan_id') ?>").val(data.modBayarSupplier.terimapersediaan_id);
            $("#<?php echo CHtml::activeId($modelBayar, 'terimabahanmakan_id') ?>").val(data.modBayarSupplier.terimabahanmakan_id);
            $("#<?php echo CHtml::activeId($modelBayar, 'totaltagihan') ?>").val(data.modBayarSupplier.totaltagihan);
            $("#<?php echo CHtml::activeId($modelBayar, 'jmldibayarkan') ?>").val(data.modBayarSupplier.jmldibayarkan);

            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nopenerimaan') ?>").val(data.modTerima.nopenerimaan);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglterima') ?>").val(data.modTerima.tglterima);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nosuratjalan') ?>").val(data.modTerima.nosuratjalan);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglsuratjalan') ?>").val(data.modTerima.tglsuratjalan);

            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'totalharga') ?>").val(data.modTerima.totalharga);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'discount') ?>").val(data.modTerima.discount);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'pajakppn') ?>").val(data.modTerima.pajakppn);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'biayaadministrasi') ?>").val(data.modTerima.biayaadministrasi);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'totalkeseluruhan') ?>").val(data.modTerima.totalkeseluruhan);

            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'supplier_nama') ?>").val(data.modBuktiKeluar.namapenerima);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nofaktur') ?>").val(data.modTerima.nofaktur);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglfaktur') ?>").val(data.modTerima.tglfaktur);
            $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'keterangan_persediaan') ?>").val(data.modTerima.keterangan_persediaan);

            hitungKasKeluar();

            //		unformatNumberSemua();
            //		formatNumberSemua();
        }, 'json');
    }

    function resetFormBayarSupplier() {
        $("#tblBayarOA tbody").empty();

        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'namapenerima') ?>").val(null);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'alamatpenerima') ?>").val(null);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran') ?>").val(null);

        $("#<?php echo CHtml::activeId($modelBayar, 'terimapersediaan_id') ?>").val(null);
        $("#<?php echo CHtml::activeId($modelBayar, 'terimabahanmakan_id') ?>").val(null);
        $("#<?php echo CHtml::activeId($modelBayar, 'totaltagihan') ?>").val(0);
        $("#<?php echo CHtml::activeId($modelBayar, 'jmldibayarkan') ?>").val(0);

        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nopenerimaan') ?>").val(null);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglterima') ?>").val(null);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nosuratjalan') ?>").val(null);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglsuratjalan') ?>").val(null);

        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'totalharga') ?>").val(0);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'discount') ?>").val(0);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'pajakppn') ?>").val(0);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'biayaadministrasi') ?>").val(0);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'totalkeseluruhan') ?>").val(0);

        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'supplier_nama') ?>").val(null);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'nofaktur') ?>").val(null);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'tglfaktur') ?>").val(null);
        $("#<?php echo CHtml::activeId($modTerimaPersediaan, 'keterangan_persediaan') ?>").val(null);

        hitungKasKeluar();

        //		unformatNumberSemua();
        //		formatNumberSemua();
    }
</script>