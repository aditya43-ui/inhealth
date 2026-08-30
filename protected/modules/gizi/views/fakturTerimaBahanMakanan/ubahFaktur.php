<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$this->breadcrumbs = array(
    'Ubah Faktur Pembelian Bahan Makanan',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Ubah <b>Faktur Pembelian Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gzterimabahanmakan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Form Pembelian Bahan Makanan
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo Chtml::label("No Permintaan", 'No Permintaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nopengajuan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("No Penerimaan Bahan", 'temp_no', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'terimabahanmakan_id'); ?>
                                <?php echo $form->textField($model, 'nopenerimaanbahan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'sumberdanabhn', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglterimabahan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tglterimabahan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'supplier_nama', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglsurjalan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'tglsurjalan', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nosuratjalan', array('class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                        <?php echo $form->textAreaRow($model, 'keterangan_terima_bahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" style="display: none;" id="divuangmukabeli">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran Uang Muka</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pembayaran <span class="required">*</span>', 'nopembayaran', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'nopembayaran', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pembayaran <span class="required">*</span>', 'tgluangmukabeli', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'tgluangmukabeli', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Jumlah Uang Muka <span class="required">*</span>', 'jumlahuang', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'jumlahuang', array('readonly' => true, 'class' => 'integer-decimal span3')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Tabel Faktur Bahan Makanan</b></div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-condensed table-bordered" id="tableBahanMakanan">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kelompok</th>
                            <th>Nama</th>
                            <th>Jumlah Persediaan</th>
                            <th>Jumlah Terima</th>
                            <th>Tanggal Kedaluwarsa</th>
                            <th>Harga Netto (Rp)</th>
                            <th>Keringanan (%)</th>
                            <th>Keringanan (Rp)</th>
                            <th>PPN (%)</th>
                            <th>PPN (Rp)</th>
                            <th>PPh (%)</th>
                            <th>PPh (Rp)</th>
                            <th>Subtotal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count((array)$modDetails) > 0) {
                            $no = 1;
                            foreach ($modDetails as $key => $modDetail) {
                                echo $this->renderPartial($this->path_view . '_rowMakananUbah', array('modDetail' => $modDetail, 'key' => $key, 'no' => $no));
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan='13'>
                                <div class='pull-right'>Total Harga</div>
                            </td>
                            <td><?php echo CHtml::textField('tothargabruto', '', array('style' => 'text-align:right; width:120px;', 'readonly' => TRUE, 'class' => 'span2 integer-decimal total_semua')); // echo $form->textField($model, 'totalharganetto', array('readonly' => true, 'class' => 'span2 integer2 total_semua', 'onkeypress' => "return $(this).focusNextInputField(event);",'style'=>'width:120px;')); 
                                ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Faktur Pembelian Bahan Makanan
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label('No Faktur <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nofaktur', array('class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglfaktur', array('class' => 'control-label required', 'label' => 'Tanggal Faktur <span class="required">*</span>')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglfaktur',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onchange' => 'loadJatuhTempo();'),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tglfaktur'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tgljatuhtempo', array('class' => 'control-label required', 'label' => 'Tanggal Jatuh Tempo')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgljatuhtempo',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //                                                            'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tgljatuhtempo'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Jenis PPh", "pajak_id", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pajak_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textField($model, 'pajak_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Syarat Bayar <span class='required'>*</span>", "syaratbayar_id", array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList(
                                    $model,
                                    'syaratbayar_id',
                                    CHtml::listData(SyaratbayarM::model()->findAll('syaratbayar_aktif = true ORDER BY syaratbayar_nama ASC'), 'syaratbayar_id', 'syaratbayar_nama'),
                                    array(
                                        'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'empty' => '-- Pilih --',
                                    )
                                ); ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'keteranganfaktur', array('placeholder' => 'Ket. Terima Langsung Faktur', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-info-circled"></i> Informasi <b>Harga</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label('Total Harga', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalharganetto', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style' => 'text-align: right;')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keringanan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totaldiscount', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                                <?php echo $form->error($model, 'totaldiscount'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total PPN", 'pajakppn', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'pajakppn', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total PPh', 'pajakpph', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'pajakpph', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3 text-right', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total Keseluruhan", 'totalkeseluruhan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalkeseluruhan', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Jumlah Uang Muka", 'jmluangmukabeli', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'jmluangmukabeli', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total Harga Netto", 'totalhutangusaha', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalhutangusaha', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasiHpp();', 'onKeypress' => 'return formSubmit(this,event)'));
            } else {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true));
            }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])), array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
            ));
            ?>
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => TRUE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printData();return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            $content = $this->renderPartial('gizi.views.tips.transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    function renameInputRowBahanMakanan(obj_table) {
        var row = 0;
        $('#' + obj_table).find("tbody > tr").each(function() {
            $(this).find("#noUrut").val(row + 1);
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }

    function hitungSemua() {
        unformatNumberSemua();
        var totalharga = 0;
        var totaldiskon = 0;
        var totalppn = 0;
        var totalpph = 0;
        var totalsubtotal = 0;
        $('.noUrut').each(function() {
            var netto = parseFloat($(this).parents('tr').find('input[name$="[harganettobahan]"]').val());
            var jml = parseFloat($(this).parents('tr').find('input[name$="[qty_terima]"]').val());
            var persendiskon = parseFloat($(this).parents('tr').find('input[name$="[persendiscount]"]').val());
            var persenppn = parseFloat($(this).parents('tr').find('input[name$="[persenppn]"]').val());
            var persenpph = parseFloat($(this).parents('tr').find('input[name$="[persenpph]"]').val());
            var jmlQty = (netto * jml);
            if (jmlQty > 0) {
                jmlQty = parseFloat(jmlQty.toFixed(2));
            }
            var jmldiskon = ((jmlQty * persendiskon) / 100);
            if (jmldiskon > 0) {
                jmldiskon = parseFloat(jmldiskon.toFixed(2));
            }
            var jmlppn = (((jmlQty - jmldiskon) * persenppn) / 100);
            if (jmlppn > 0) {
                jmlppn = parseFloat(jmlppn.toFixed(2));
            }
            var jmlpph = (((jmlQty - jmldiskon) * persenpph) / 100);
            if (jmlpph > 0) {
                jmlpph = parseFloat(jmlpph.toFixed(2));
            }
            var subtotal = (jmlQty - jmldiskon + jmlppn - jmlpph);
            if (subtotal > 0) {
                subtotal = parseFloat(subtotal.toFixed(2));
            }
            $(this).parents('tr').find('.subNetto').val(subtotal);
            $(this).parents('tr').find('.jmldiscount').val(jmldiskon);
            $(this).parents('tr').find('.jmlhargappn').val(jmlppn);
            $(this).parents('tr').find('.jmlhargapph').val(jmlpph);
            totalharga += netto;
            totaldiskon += jmldiskon;
            totalppn += jmlppn;
            totalpph += jmlpph;
            totalsubtotal += subtotal;
        });
        $(".total_semua").val(totalsubtotal);
        $('#<?php echo CHtml::activeId($model, 'totalharganetto') ?>').val(totalharga);
        $('#<?php echo CHtml::activeId($model, 'totaldiscount') ?>').val(totaldiskon);
        $('#<?php echo CHtml::activeId($model, 'pajakppn') ?>').val(totalppn);
        $('#<?php echo CHtml::activeId($model, 'pajakpph') ?>').val(totalpph);
        $('#<?php echo CHtml::activeId($model, 'totalkeseluruhan') ?>').val(totalsubtotal);
        var jmluangmukabeli = parseFloat($("#<?php echo CHtml::activeId($model, 'jmluangmukabeli') ?>").val());
        var totalhutang = (totalsubtotal - jmluangmukabeli);
        $("#<?php echo CHtml::activeId($model, 'totalhutangusaha') ?>").val(totalhutang);
        formatNumberSemua();
    }

    function setVerifikasiHpp() {
        if (requiredCheck($("form"))) {
            var index = 0;
            var pesanharga = "";
            var kecilHpp = 0;
            var cekpph = 0;
            $('#tableBahanMakanan tbody tr').each(function() {
                unformatNumberSemua();
                var hargaLama = parseFloat($(this).find('input[name$="[harganettomaster]"]').val());
                var hargabaru = parseFloat($(this).find('input[name$="[harganettobahan]"]').val());
                var namaBahan = $(this).find('input[name$="[namabahanmaster]"]').val();
                var persenpph = parseFloat($(this).find('input[name$="[persenpph]"]').val());
                if (hargaLama != hargabaru) {
                    kecilHpp += 1;
                    if (index > 0) {
                        pesanharga += ",";
                    }
                    pesanharga += namaBahan + " (" + hargabaru + ")";
                    index++;
                } else {
                    if (kecilHpp > 1) {
                        kecilHpp -= 1;
                    }
                }
                if (persenpph > 0) {
                    cekpph += 1;
                } else {
                    if (cekpph > 1) {
                        cekpph -= 1;
                    }
                }
                $(this).find('input[name$="[hppcheck]"]').val(0);
                formatNumberSemua();
            });
            if (cekpph > 0) {
                if ($('#<?php echo CHtml::activeId($model, 'pajak_id'); ?>').val() == '') {
                    myAlert("Jenis Pajak harus diisi ");
                    return false;
                }
            }
            if (kecilHpp > 0) {
                $.alerts.okButton = "Ya";
                $.alerts.cancelButton = "Tidak";
                myConfirm("Harga Netto '" + pesanharga + "' berbeda dengan yang ada di master. Apakah Anda ingin melakukan update harga otomatis?", "Perhatian!", function(r) {
                    if (r) {
                        $('#tableBahanMakanan tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(1);
                        });
                        $('.integer-decimal, .integer2, .float2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                        $("#gzterimabahanmakan-form").submit();
                    } else {
                        $('#tableBahanMakanan tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(0);
                        });
                        $('.integer-decimal, .integer2, .float2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                        $("#gzterimabahanmakan-form").submit();
                    }
                });
            } else {
                $('#tableBahanMakanan tbody tr').each(function() {
                    $(this).find('input[name$="[hppcheck]"]').val(1);
                });
                $('.integer-decimal, .integer2, .float2').each(function() {
                    $(this).val(unformatNumber($(this).val()));
                });
                $("#gzterimabahanmakan-form").submit();
            }
        }
        return false;
    }

    function loadJatuhTempo() {
        var tanggalfaktur = $('#<?php echo CHtml::activeId($model, 'tglfaktur'); ?>').val();
        var supplierid = $('#<?php echo CHtml::activeId($model, 'supplier_id'); ?>').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadJatuhTempo'); ?>',
            data: {
                tgl_faktur: tanggalfaktur,
                supplier_id: supplierid
            },
            dataType: "json",
            success: function(data) {
                $('#<?php echo CHtml::activeId($model, 'tgljatuhtempo'); ?>').val(data.value);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function printData() {
        var terimabahanmakan_id = "<?php echo $model->terimabahanmakan_id ?>";
        window.open("<?php echo $this->createUrl('detailPenerimaan') ?>&id=" + terimabahanmakan_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
    }
    $(document).ready(function() {
        hitungSemua();
        loadJatuhTempo();
        <?php if (!empty($modUangmuka->uangmukabeli_id)) { ?>
            $('#divuangmukabeli').show();
        <?php } else { ?>
            $('#divuangmukabeli').hide();
        <?php } ?>
    });
</script>