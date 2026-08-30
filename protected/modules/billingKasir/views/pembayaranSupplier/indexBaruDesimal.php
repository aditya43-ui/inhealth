<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<style type="text/css">
    .integer-decimal {
        text-align: right;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Supplier</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pembayaran Supplier',
        );
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'bayarkesupplier-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return cekInputan();'
            ),
        )); ?>
        <?php if (isset($_GET['id'])) {
            Yii::app()->user->setFlash("success", "Pembayaran berhasil disimpan.");
        }
        ?>
        <?php
        $this->widget('application.extensions.moneymask.MMask', array(
            'element' => '.currency',
            'currency' => 'PHP',
            'config' => array(
                'symbol' => 'Rp ',
                //        'showSymbol'=>true,
                //        'symbolStay'=>true,
                'defaultZero' => true,
                'allowZero' => true,
                'decimal' => '.',
                'thousands' => ',',
                'precision' => 0,
            )
        ));
        ?>
        <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); 
        ?>
        <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Faktur</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataFakturBeliBaru', array('modFakturBeli' => $modFakturBeli, 'form' => $form)); ?>

                <?php echo $form->errorSummary(array($modelBayar, $modBuktiKeluar, $modUangMuka)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Obat Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php

                echo CHtml::hiddenField('total', 0, array('id' => 'total'));
                //                            if(Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_FINANCE){
                //                                $this->renderPartial($this->path_view.'_formTambahObat',array()); 
                //                            }
                ?>

                <div class="block-tabel">
                    <table id="tblBayarOA" class="table table-bordered table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Obat dan Alkes</th>
                                <th>Jml terima</th>
                                <th>Harga Netto</th>
                                <th>Keringanan (%)</th>
                                <th>Keringanan (Rp)</th>
                                <th>PPN (%)</th>
                                <th>PPN (Rp)</th>
                                <th>PPh (%)</th>
                                <th>PPh (Rp)</th>
                                <th>HPP</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cekBayarSupp = BayarkesupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $modFakturBeli->fakturpembelian_id));


                            //										if (count((array)$cekBayarSupp)>0){
                            //											echo $this->renderPartial($this->path_view.'_rowFaktur', array('modDetailBeli'=>$modDetailBeli,), true); 
                            //										}else{
                            echo $this->renderPartial($this->path_view . '_rowFakturBaru', array('modDetailBeli' => $modDetailBeli,), true);
                            //										}

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-money-bill"></i> Pembayaran
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php // echo $modBuktiKeluar->bayarkesupplier_id;
                        ?>
                        <?php //echo $form->textFieldRow($modelBayar,'uangmukabeli_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php echo $form->hiddenField($modelBayar, 'fakturpembelian_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($modelBayar,'tandabuktikeluar_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php //echo $form->textFieldRow($modelBayar,'batalbayarsupplier_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php //echo $form->textFieldRow($modelBayar,'tglbayarkesupplier',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <div class="control-group">
                            <?php $modelBayar->tglbayarkesupplier = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modelBayar->tglbayarkesupplier, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php //$modelBayar->tglbayarkesupplier = MyFormatter::formatDateTimeForUser($modelBayar->tglbayarkesupplier); 
                            ?>
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
                                        'readonly' => true, 'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                                        'readonly' => true, 'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>

                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                        <?php echo $form->textFieldRow($modelBayar, 'totaltagihan', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($modUangMuka,'jumlahuang',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <div class="control-group " hidden>
                            <label class='control-label required'>Uang Muka <span class="required">*</span></label>
                            <div class="controls">
                                <?php echo $form->textField($modUangMuka, 'jumlahuang', array('placeholder' => '00', 'readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modelBayar, 'jmldibayarkan', array('placeholder' => '00', 'class' => 'inputFormTabel integer-decimal span3', 'onblur' => 'hitungKasKeluar();', 'onkeyup' => 'hitungKasKeluar()', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->hiddenField($modelBayar, 'sudahbayar', array('class' => 'inputFormTabel integer-decimal span3', 'onblur' => 'hitungKasKeluar();', 'onkeyup' => 'hitungKasKeluar()', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('placeholder' => '00', 'onkeyup' => 'hitungKasKeluar();', 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaongkos_kirim', array('placeholder' => '00', 'onkeyup' => 'hitungKasKeluar();', 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Cara Pembayaran ", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>

                        <div id="divCaraBayarTransfer">
                            <div class="control-group">
                                <?php echo CHtml::label("Nama Bank Pengirim", 'bank_id', array('class' => 'control-label')); ?>
                                <?php // echo CHtml::activeLabel($modBuktiKeluar, 'bank_id', array('class' => 'control-label')); 
                                ?>
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
                                'placeholder' => '00',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                            )); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array(
                                'class' => 'span3',
                                'placeholder' => '00',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                            )); ?>
                        </div>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('placeholder' => '00', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('placeholder' => '00', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('placeholder' => '00', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disabled = ((isset($modFakturBeli->bayarkesupplier_id)) ? true : null);

            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabled)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                );
            }
            //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($modTandaBukti->tandabuktibayar_id);return false",'disabled'=>false)); 
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    //                                      'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
                )
            ); ?>
            <?php
            if (isset($_GET['id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => FALSE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE));
            }
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        <?php if (isset($_GET['frame'])) { ?>
            <?php if (isset($_GET['idFakturPembelian'])) {
                if (count((array)$cekBayarSupp) > 0) {
            ?>
                    $("#sudahadapembayaran").attr("style", "display:block;");
                    $("#belumadapembayaran").attr("style", "display:none;");
                    $("#sudahadapembayaran2").attr("style", "display:block;");
                    $("#panelharga").attr("style", "display:none;");
                    $("#<?php echo CHtml::activeId($modFakturBeli, 'supplier_id'); ?>").removeClass('required');
                    $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah'); ?>").removeClass('required');
                <?php
                } else {
                ?>
                    refreshDialogOA();
                    hitungTotal();
                    $("#sudahadapembayaran").attr("style", "display:none;");
                    $("#belumadapembayaran").attr("style", "display:block;");
                    $("#sudahadapembayaran2").attr("style", "display:none;");
                    $("#panelharga").attr("style", "display:block;");
                    $("#<?php echo CHtml::activeId($modFakturBeli, 'supplier_id'); ?>").addClass('required');
                    $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah'); ?>").addClass('required');
            <?php }
            } ?>
            <?php } else {

            if (count((array)$cekBayarSupp) > 0) {
            ?>
                $("#sudahadapembayaran").attr("style", "display:block;");
                $("#belumadapembayaran").attr("style", "display:none;");
                $("#sudahadapembayaran2").attr("style", "display:block;");
                $("#panelharga").attr("style", "display:none;");
            <?php
            } else {
            ?>

                hitungTotal();
                $("#sudahadapembayaran").attr("style", "display:none;");
                $("#belumadapembayaran").attr("style", "display:block;");
                $("#sudahadapembayaran2").attr("style", "display:none;");
                $("#panelharga").attr("style", "display:block;");
            <?php }
            ?>
            //alert('asdasd');
        <?php

        } ?>

        formCarabayar($('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val());
        $('.integer2').each(function() {
            this.value = formatNumber(this.value)
        });
    });

    function cekInputan() {
        var supplier = $("#<?php echo CHtml::activeId($modFakturBeli, 'supplier_id') ?>");
        var no_faktur = $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>");
        var fakturpembelian_id = $("#FAPendaftaranT_fakturpembelian_id").val();
        var cekOA = $('#tblBayarOA > tbody > tr');

        if (fakturpembelian_id == '') {
            myAlert("Data pada faktur pembelian belum di load");
            return false;
        }

        if (cekOA.length < 1) {
            myAlert("Data pada tabel pembayaran obat alkes, belum ada data detail obatnya");
            return false;
        }

        if (supplier.hasClass("required")) {
            if (supplier.val() == '') {
                myAlert("Silakan isi yang bertanda <span class='required'>*</span>");
                return false;
            }
        }

        if (no_faktur.hasClass("required")) {
            if (no_faktur.val() == '') {
                myAlert("Silakan isi yang bertanda <span class='required'>*</span>");
                return false;
            }
        }

        $('.integer-decimal, .integer2, .float2').each(function() {
            $(this).val(unformatNumber($(this).val()));
        });

        //    $('.integer2').each(function(){this.value = unformatNumber(this.value)});
        //	$('.float2').each(function(){this.value = unformatNumber(this.value)});	
        //	$('.integer-decimal').each(function(){this.value = unformatNumber(this.value)});	
        return true;

    }

    function allowUbahFaktur(obj) {
        var fakturpembelian_id = $("#FAPendaftaranT_fakturpembelian_id").val();

        if (fakturpembelian_id != '') {
            if ($(obj).prop("checked") == true) {
                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").attr("readonly", false);
                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").addClass("required");
            } else {
                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").attr("readonly", true);
                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").removeClass("required");
                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").val("");
            }
        } else {
            myAlert("Data pada faktur pembelian belum di load");
            $(obj).prop("checked", false);
            $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").val("");
            return false;
        }
    }

    function ubahNoFaktur(obj) {
        var fakturpembelian_id = $("#FAPendaftaranT_fakturpembelian_id").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionAjax/cekNoFaktur'); ?>',
            data: {
                nofaktur: $(obj).val(),
                fakturpembelian_id: fakturpembelian_id
            }, //
            dataType: "json",
            success: function(data) {
                if (data.boleh == 'tidak') {
                    myAlert("No Faktur <b>" + $(obj).val() + "</b> sudah digunakan");
                    $(obj).val('');
                    return false;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function tambahObatAlkes() {
        var obatalkes_id = $('#obatalkes_id').val();
        var jumlah = $('#qty_input').val();
        var statusobat = $("#statusobat").val();
        var tipesatuan = $("#tipesatuan").val();
        var supplier_id = $("#BKFakturPembelianT_supplier_id").val();
        var cek = true;

        $('#tblBayarOA > tbody ').each(function() {

            if ($(this).find('.obat_id').val() == obatalkes_id) {
                cek = false;
            }
        });

        if (cek == false) {
            myAlert("Obat sudah ditambahkan");
            return false;
        }

        if (obatalkes_id != '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('LoadTambahOA'); ?>',
                data: {
                    supplier_id: supplier_id,
                    tipesatuan: tipesatuan,
                    statusobat: statusobat,
                    obatalkes_id: obatalkes_id,
                    jumlah: jumlah
                }, //
                dataType: "json",
                success: function(data) {
                    var last = null;

                    if (data.sukses == 1) {
                        $('#tblBayarOA > tbody').append(data.form);

                        last = $("#tblBayarOA > tbody tr:last-child");

                        $(last).find('.obat_id').val(obatalkes_id);
                        $(last).find('.integer2').maskMoney({
                            "symbol": "",
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": ".",
                            "precision": 0
                        });
                        $(last).find('.float2').maskMoney({
                            "symbol": "",
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": "",
                            "precision": 2
                        });
                        $(last).find('.integerFloat, .integer-decimal').maskMoney({
                            "symbol": "",
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": ".",
                            "precision": 2
                        });

                        renameInputRowObatAlkes($("#tblBayarOA"));

                        hitungTotal();
                        $("#tblBayarOA").find(".satuanobat").change();
                    } else {
                        myAlert(data.pesan)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Isikan item obat terlebih dahulu");
        }

    }

    /**
     * rename input grid
     */
    function renameInputRowObatAlkes(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").html(row + 1);
            $(this).find('.add-on').each(function() { //element <input>
                var old_name = $(this).attr("id");
                var old_name_arr = old_name.split("_");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3]);

                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[tglkadaluarsa]"]').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
        $('#obatalkes_id').val('');
        $('#obatalkes_nama').val('');
        $('#qty_input').val(1);
    }

    /**
     * - digunakan untuk berpindah dialog box sesuai checkbox berdasarkan master oa
     * @param {type} obj
     * @returns {change dialog box show}
     */
    function setValue(obj) {
        if ($(obj).is(":checked")) {
            //alert('chek');
            $("#obatalkes_nama").parent().find("a").removeAttr("onclick");
            $("#obatalkes_nama").parent().find("a").attr("onclick", '$("#dialogObatAlkes").dialog("open");return false;');
        } else {
            //alert('unchek');
            $("#obatalkes_nama").parent().find("a").removeAttr("onclick");
            $("#obatalkes_nama").parent().find("a").attr("onclick", '$("#dialogObatAlkesSupplier").dialog("open");return false;');
        }
    }

    function refreshDialogOA() {
        $("#obatalkes_nama").addClass("animation-loading-1");
        var su = $("#BKFakturPembelianT_supplier_id option:selected").text();
        if (su == "") {
            su = "(Supplier Belum Dipilih)";
        }

        setTimeout(function() {
            $("#suppliernama").html(su);
            $("#obatalkes_nama").removeClass("animation-loading-1");
            var supplier_id = $('#BKFakturPembelianT_supplier_id').val();

            $(".dialog_supplier_id").val(supplier_id);
            $.fn.yiiGridView.update('obatalkessupplier-m-grid', {
                data: {
                    "GFObatSupplierM[supplier_id]": supplier_id,
                }
            });
        }, 500);
    }

    function cekTipeSatuan(obj) {
        var tipesatuan = $(obj).val();

        if (tipesatuan == '<?php echo Params::SATUANOBAT_KECIL ?>') {
            $("#ceksatuankecil").attr("style", "display:block;");
            $("#ceksatuanbesar").attr("style", "display:none;");
        } else if (tipesatuan == '<?php echo Params::SATUANOBAT_BESAR ?>') {
            $("#ceksatuankecil").attr("style", "display:none;");
            $("#ceksatuanbesar").attr("style", "display:block;");
        }
    }

    function batalObat(obj) {
        myConfirm('Apakah Anda akan membatalkan obat & alkes <b>' + $(obj).parents('tr').find('.nama_obat').html() + '<b>ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $(obj).parents('tr').detach();
                    $("#tblBayarOAHapus > tbody").append("<tr><td><input type='hidden' value='" + $(obj).parents("tr").find(".fakturdetail_id").val() + "' name='delete[fakturdetail_id][]'>\n\
															<input type='hidden' value='" + $(obj).parents("tr").find(".penerimaandetail_id").val() + "' name='delete[penerimaandetail_id][]'></td></tr>");
                    hitungTotal();
                }
            });

    }

    function hitungKasKeluar() {
        unformatNumberSemua();
        var jmlBayar = parseFloat($('#BKBayarkeSupplierT_jmldibayarkan').val());
        var biayaAdmin = parseFloat($('#BKTandabuktikeluarT_biayaadministrasi').val());
        var biayaongkos_kirim = parseFloat($('#BKTandabuktikeluarT_biayaongkos_kirim').val());

        var kasKeluar = jmlBayar + biayaAdmin + biayaongkos_kirim;

        $('#BKTandabuktikeluarT_jmlkaskeluar').val(kasKeluar);
        formatNumberSemua();
    }

    function formCarabayar(carabayar) {
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').show();
        } else {
            $('#divCaraBayarTransfer').hide();
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
            $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
        }
    }

    function loadFakturPembelian(id) {

        $.post('<?php echo $this->createUrl('loadFakturFarmasi'); ?>', {
            id: id
        }, function(data) {
            $("#tblBayarOA tbody").html(data.tabFaktur);
            $("#FAPendaftaranT_tglfaktur").val(data.fakturBeli.tglfaktur);
            $("#FAPendaftaranT_tgljatuhtempo").val(data.fakturBeli.tgljatuhtempo);

            $("#FAPendaftaranT_umur_hutang").val(data.umur_hutang);
            $("#FAPendaftaranT_fakturpembelian_id").val(data.fakturBeli.fakturpembelian_id);
            $("#FAPendaftaranT_supplier_id").val(data.supplier_id);
            $("#FAPendaftaranT_supplier_nama").val(data.supplier_nama);
            $("#FAPasienM_keteranganfaktur").val(data.fakturBeli.keteranganfaktur);
            $("#nopermintaan").val(data.nopermintaan);
            $("#nopenerimaan").val(data.penerimaan.noterima);

            $("#BKFakturPembelianT_nofaktur").val(data.fakturBeli.nofaktur);

            $("#BKBayarkeSupplierT_fakturpembelian_id").val(data.fakturBeli.fakturpembelian_id);
            $("#BKBayarkeSupplierT_totaltagihan").val(data.modelBayar.totaltagihan);
            $("#BKUangMukaBeliT_jumlahuang").val(data.uangMuka);
            $("#BKBayarkeSupplierT_jmldibayarkan").val(data.modelBayar.jmldibayarkan);
            //$("#BKTandabuktikeluarT_nokaskeluar").val(data.buktiKeluar.nokaskeluar);
            $("#BKTandabuktikeluarT_biayaadministrasi").val(data.buktiKeluar.biayaadministrasi);
            $("#BKTandabuktikeluarT_jmlkaskeluar").val(data.buktiKeluar.jmlkaskeluar);
            $("#BKTandabuktikeluarT_namapenerima").val(data.buktiKeluar.namapenerima);
            $("#BKTandabuktikeluarT_alamatpenerima").val(data.buktiKeluar.alamatpenerima);
            $("#BKTandabuktikeluarT_untukpembayaran").val(data.buktiKeluar.untukpembayaran);

            $("#FAPendaftaranT_totalhargabruto").val(data.fakturBeli.totalhargabruto);
            $("#FAPendaftaranT_totharganetto").val(data.fakturBeli.totharganetto);
            $("#FAPendaftaranT_jmldiscount").val(data.fakturBeli.jmldiscount);
            $("#FAPendaftaranT_totalpajakppn").val(data.fakturBeli.totalpajakppn);

            if (data.ada == false) {
                hitungTotal();
                $("#<?php echo CHtml::activeId($modFakturBeli, 'adapembayaran') ?>").val('tidak');
                $("#<?php echo CHtml::activeId($modFakturBeli, 'adapembayaran') ?>").attr('value', 'tidak');
                $("#panelharga").attr("style", "display:block;");
                $("#sudahadapembayaran").attr("style", "display:none;");
                $("#belumadapembayaran").attr("style", "display:block;");
                $("#sudahadapembayaran2").attr("style", "display:none;");

                $("#belumadapembayaran").find("#FAPendaftaranT_umur_hutang").val(data.umur_hutang);
                $("#belumadapembayaran").find("#FAPendaftaranT_supplier_id").val(data.supplier_nama);

                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur') ?>").addClass('required');
                $("#<?php echo CHtml::activeId($modFakturBeli, 'supplier_id') ?>").addClass('required');

                $("#<?php echo CHtml::activeId($modFakturBeli, 'supplier_id') ?>").val(data.fakturBeli.supplier_id);
                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").val('');

                $("#mengubahnofaktur").show();

                refreshDialogOA();
            } else {
                $("#<?php echo CHtml::activeId($modFakturBeli, 'adapembayaran') ?>").val('ada');
                $("#<?php echo CHtml::activeId($modFakturBeli, 'adapembayaran') ?>").attr('value', 'ada');
                $("#panelharga").attr("style", "display:none;");
                $("#sudahadapembayaran").attr("style", "display:block;");
                $("#belumadapembayaran").attr("style", "display:none;");
                $("#sudahadapembayaran2").attr("style", "display:block;");

                $("#sudahadapembayaran").find("#FAPendaftaranT_umur_hutang").val(data.umur_hutang);
                $("#sudahadapembayaran").find("#FAPendaftaranT_supplier_id").val(data.supplier_nama);


                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur') ?>").removeClass('required');
                $("#<?php echo CHtml::activeId($modFakturBeli, 'supplier_id') ?>").removeClass('required');
                $("#<?php echo CHtml::activeId($modFakturBeli, 'nofaktur_ubah') ?>").val('');

                $("#mengubahnofaktur").hide();
            }

            $(".integer-decimal").unmaskMoney().maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": ".",
                "precision": 2
            });
            $(".float2").unmaskMoney().maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": "",
                "precision": 2
            });

            //console.log("Kicker");
        }, 'json');
    }

    function print() {
        var fakturpembelian_id = "<?php echo isset($modelBayar->bayarkesupplier_id) ? $modelBayar->bayarkesupplier_id : (isset($_GET['id']) ? $_GET['id'] : null); ?>";
        window.open("<?php echo $this->createUrl('print') ?>&id=" + fakturpembelian_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
    }

    var totppnterima = 0;

    function hitungTotal() {
        unformatNumberSemua();
        var total = 0;
        var persenppn = 0;
        var persenpph = 0;
        var totnetto = 0;
        var totdisc = 0;
        var totbruto = 0
        var tothpp = 0;
        var subhpp = 0;
        var totppn = 0;
        var totpph = 0;
        var totnettqty = 0;
        var totpphterima = 0;
        var totdisterima = 0;
        var sudahbayar = $("#<?php echo CHtml::activeId($modelBayar, 'sudahbayar') ?>").val();

        var totdisfaktur = 0;
        //	totppnterima = 0;
        var totalppnpajak = 0;

        $('#tblBayarOA tbody tr').each(function() {
            //		setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));	

            var jmlterima = parseFloat($(this).find('input[name$="[jmlterima]"]').val());
            var harganetto = parseFloat($(this).find('input[name$="[harganettofaktur]"]').val());
            //        var harganettoubah  = parseFloat(($(this).find('input[name$="[harganettoubah]"]').val()));
            var persendis = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
            //        var jmldis  = parseFloat($(this).find('.jmldiscount_raw').val());
            var persen_ppn = parseFloat($(this).find('input[name$="[persenppnfaktur]"]').val());
            var persen_pph = parseFloat($(this).find('input[name$="[persenpphfaktur]"]').val());
            //		var hpp  = parseFloat(unformatNumber($(this).find('input[name$="[hargasatuan]"]').val()));
            var kemasanbesar = parseInt($(this).find('input[name$="[kemasanbesar]"]').val());

            if ((typeof kemasanbesar === "undefined") || isNaN(kemasanbesar)) {
                kemasanbesar = 0;
            }
            var jmlkms = 0;
            if (kemasanbesar > 0) {
                jmlkms = (jmlterima * kemasanbesar);
            } else {
                jmlkms = jmlterima;
            }

            //Rumus Baru     

            var JumlahNetto = (harganetto * jmlkms);
            if (JumlahNetto > 0) {
                JumlahNetto = parseFloat(JumlahNetto.toFixed(2));
            }
            //diskon
            var jmlDiskon = (JumlahNetto * (persendis / 100));
            if (jmlDiskon > 0) {
                jmlDiskon = parseFloat(jmlDiskon.toFixed(2));
            }
            // ppn
            var jmlPPn = ((JumlahNetto - jmlDiskon) * (persen_ppn / 100));
            if (jmlPPn > 0) {
                jmlPPn = parseFloat(jmlPPn.toFixed(2));
            }
            //pph
            var jmlPPh = ((JumlahNetto - jmlDiskon) * (persen_pph / 100));
            if (jmlPPh > 0) {
                jmlPPh = parseFloat(jmlPPh.toFixed(2));
            }
            var subtotal = (JumlahNetto - jmlDiskon + jmlPPn - jmlPPh);
            if (subtotal > 0) {
                subtotal = parseFloat(subtotal.toFixed(2));
            }

            totdisc += jmlDiskon;
            totppn += jmlPPn;
            totpph += jmlPPh;
            totbruto += subtotal;
            totnetto += JumlahNetto;

            $(this).find('input[name$="[subtotal]"]').val(subtotal);
            $(this).find('input[name$="[jmldiscount]"]').val(jmlDiskon);
            $(this).find('input[name$="[hargasatuan]"]').val(subtotal);
            $(this).find('input[name$="[jmlppn]"]').val(jmlPPn);
            $(this).find('input[name$="[jmlpph]"]').val(jmlPPh);
            $(this).find('input[name$="[harganettofaktur]"]').val(harganetto);
            $(this).find('input[name$="[harganettoubah]"]').val(harganetto);
        });
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totharganetto'); ?>').val(totnetto);
        $('#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount'); ?>').val(totdisc);
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakppn'); ?>').val(totppn);
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakpph'); ?>').val(totpph);
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalhargabruto'); ?>').val(totbruto);

        //    var totalnetto = parseFloat($("#<?php // echo CHtml::activeId($modFakturBeli, 'totharganetto'); 
                                                ?>").val()); 
        //	var jmldiscount = parseFloat($("#<?php // echo CHtml::activeId($modFakturBeli, 'jmldiscount'); 
                                                ?>").val()); 
        //	var persendiscount = parseFloat($("#<?php // echo CHtml::activeId($modFakturBeli, 'persendiscount'); 
                                                    ?>").val()); 
        //	var persenppn = parseFloat($("#<?php // echo CHtml::activeId($modFakturBeli, 'persenppn'); 
                                                ?>").val()); 
        //	var totalppn = parseFloat($("#<?php // echo CHtml::activeId($modFakturBeli, 'totalpajakppn'); 
                                            ?>").val()); 
        //	var totalpph = parseFloat($("#<?php // echo CHtml::activeId($modFakturBeli, 'totalpajakpph'); 
                                            ?>").val());

        //    $('#<?php // echo CHtml::activeId($modFakturBeli,'totalpajakppn'); 
                    ?>').val(formatNumber(totppnterima));
        $("#<?php echo CHtml::activeId($modelBayar, 'totaltagihan'); ?>").val(totbruto);
        $("#<?php echo CHtml::activeId($modelBayar, 'jmldibayarkan'); ?>").val(totbruto);
        $('#total').val(totbruto);
        formatNumberSemua();

        //	hitungTotalFaktur();
        hitungKasKeluar();

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

    function hitungTotalByHPP() {
        unformatNumberSemua();
        var total = 0;
        var persenppn = 0;
        var persenpph = 0;
        var totnetto = 0;
        var totdisc = 0;
        var totbruto = 0;
        var tothpp = 0;
        var subhpp = 0;
        var totppn = 0;
        var totpph = 0;
        var totnettqty = 0;
        var totpphterima = 0;
        var totdisterima = 0;
        var sudahbayar = $("#<?php echo CHtml::activeId($modelBayar, 'sudahbayar') ?>").val();

        var totdisfaktur = 0;
        totppnterima = 0;

        $('#tblBayarOA tbody tr').each(function() {
            //        setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));	

            var jmlterima = parseFloat($(this).find('input[name$="[jmlterima]"]').val());
            var harganetto = parseFloat($(this).find('input[name$="[harganettofaktur]"]').val());
            var harganettoubah = parseFloat($(this).find('input[name$="[harganettoubah]"]').val());
            var persendis = parseFloat($(this).find('.jmldiscount_raw').val());
            var jmldis = parseFloat($(this).find('input[name$="[jmldiscount]"]').val());
            var persen_ppn = parseFloat($(this).find('input[name$="[persenppnfaktur]"]').val());
            var hpp = parseFloat($(this).find('input[name$="[hargasatuan]"]').val());

            var subtotal = 0;
            var ppn = 0;
            var rpppn = 0;
            var pph = 0;
            var rppph = 0;

            ppn = persen_ppn;
            rpppn = (harganetto - jmldis) * (ppn / 100);

            subhpp = hpp;

            subtotal = Math.round((subhpp * jmlterima));

            persenpph += (((rppph * 100) / 100) * jmlterima);

            total += (subtotal);

            totbruto += (subtotal);

            tothpp += subhpp;

            totppn += ((rpppn * 100) / 100);

            totnettqty += harganetto * jmlterima;
            //alert(Math.round(rpppn));
            totppnterima += ((((rpppn * 100) / 100)) * jmlterima);
            totpphterima += ((((rppph * 100) / 100)) * jmlterima);
            totdisterima += ((jmldis) * jmlterima);

            //        $(this).find('input[name$="[subtotal]"]').val(formatThousandDecimal((subtotal)));
            //        $(this).find('input[name$="[jmldiscount]"]').val(formatThousandDecimal(jmldis));
            //        $(this).find('input[name$="[persenppnfaktur]"]').val(formatThousandDecimal(ppn));
            //        $(this).find('input[name$="[persenpphfaktur]"]').val(formatThousandDecimal(pph));
            //		$(this).find('input[name$="[hargasatuan]"]').val(formatThousandDecimal(subhpp));
            //		$(this).find('input[name$="[jmlppn]"]').val(formatThousandDecimal(rpppn));
            //		$(this).find('input[name$="[harganettofaktur]"]').val(formatThousandDecimal(harganetto));
            //		$(this).find('input[name$="[harganettoubah]"]').val(formatThousandDecimal(harganettoubah));
        });
        //alert(total);
        //	totdisfaktur = (totdisterima/totnettqty)*100;
        //alert(totdisterima);
        //	console.log("diskon faktur",(((totdisfaktur.toFixed(2)))));
        //$("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiskonasli') ?>").val(formatNumber(Math.floor(totdisterima)));	
        //	$('#<?php // echo CHtml::activeId($modFakturBeli,'persendiscount'); 
                    ?>').val(((totdisfaktur.toFixed(2))));
        //    $('#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount'); ?>').val((totdisterima));
        //    $('#<?php // echo CHtml::activeId($modFakturBeli,'totharganetto'); 
                    ?>').val(formatNumber(Math.round(totnettqty)));

        //    $('#total').val(formatThousandDecimal(Math.round(total)));  

        formatNumberSemua();
        //	hitungTotalFaktur();
        //	hitungKasKeluar();
    }

    function roundToTwo(num) {
        return +(Math.round(num + "e+2") + "e-2");
    }

    function setPersenDiskon(obj) {
        var jmldiscount = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[jmldiscount]"]').val()));
        var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
        var persen = 0;

        persen = (jmldiscount / satuan) * 100;

        $(obj).parents("tr").find('input[name$="[persendiscount]"]').val(formatFloat((persen)));
    }

    function setJmlDiskon(obj) {
        var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));
        var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
        var qty = $(obj).parents("tr").find(".qty").val();
        //alert(formatFloat(satuan * (persen / 100)));

        //console.log(persen, satuan, qty);

        //$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * qty * persen / 100));
        var jmldiskon = Math.round((satuan * (persen / 100)));

        console.log(persen, jmldiskon);

        //alert(jmldiskon);

        $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(jmldiskon));
    }

    function setPersenPPN(obj) {
        var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppnfaktur]"]').val());

        if (ppnpersen > 0) {
            ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
        }

        $(obj).parents("tr").find('input[name$="[persenppnfaktur]"]').val(ppnpersen);
    }

    function setNettoUbah(obj) {
        var netto = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[harganettofaktur]"]').val()));
        $(obj).parents("tr").find('input[name$="[harganettoubah]"]').val(formatFloat(netto));
    }

    function setHPP(obj) {
        //unformatNumberSemua();
        var hpp = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[hargasatuan]"]').val()));
        var nettoubah = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[harganettoubah]"]').val()));
        var ppnpersen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persenppnfaktur]"]').val()));
        var diskonpersen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));
        var jmlterima = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[jmlterima]"]').val()));

        var harganetto = 0;

        if (hpp == 0) {
            $(obj).parents("tr").find('input[name$="[harganettofaktur]"]').val(nettoubah);
        } else {
            if (parseInt(diskonpersen) == 100) {
                $(obj).parents("tr").find('input[name$="[hargasatuan]"]').val(0);
                myAlert("HPP tidak bisa lebih dari 0, karena diskon di set 100%");
            } else {

                console.log("SET HPP", hpp, diskonpersen, ppnpersen);

                harganetto = ((hpp / (((100 - diskonpersen + ppnpersen) / 100) - (ppnpersen * diskonpersen) / 10000)));
                //alert(harganetto);
                $(obj).parents("tr").find('input[name$="[harganettofaktur]"]').val(formatThousandDecimal(harganetto));

                $(obj).parents("tr").find('input[name$="[subtotal]"]').val(formatThousandDecimal(hpp * jmlterima));
            }
        }

        //formatNumberSemua();
    }

    function setJmlDiskonFaktur(obj, update_faktur) {
        var persen = parseFloat(unformatNumber($(obj).val()));
        var satuan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modFakturBeli, 'totharganetto') ?>").val()));

        if (update_faktur == true) {
            $(".persendiscount_terima").each(function() {
                $(this).val($(obj).val());
            });
            $(".persendiscount_terima").each(function() {
                setJmlDiskon(this);
                hitungTotal();
            });
        } else {
            var jmldiscount = Math.round(satuan * (persen / 100));

            $("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount') ?>").val((jmldiscount));

        }
    }

    /*function setJmlDiskon(obj){
        var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));	
        var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
        var qty = $(obj).parents("tr").find(".qty").val();
            
    	jmldiskon = Math.round((satuan * (persen / 100)));		
    	
    	$(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(jmldiskon));
    }*/

    function setJmlDiskon2(obj) {

        var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));
        var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
        var qty = $(obj).parents("tr").find(".qty").val();

        var jmldiskon = (satuan * (persen / 100));

        console.log(persen, jmldiskon);

        $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatFloat(jmldiskon));
        $(obj).parents("tr").find('.jmldiscount_raw').val(jmldiskon);
    }

    function setPersenDisFaktur(obj) {
        unformatNumberSemua();

        var jmldiscount = parseInt(unformatNumber($(obj).val()));
        var satuan = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modFakturBeli, 'totharganetto') ?>").val()));
        var persen = 0;

        persen = ((jmldiscount / satuan) * 100);

        $("#<?php echo CHtml::activeId($modFakturBeli, 'persendiscount') ?>").val(persen.toFixed(2));
        formatNumberSemua();
    }

    /**
     * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
     * @returns {set persen ppn -- dalam field yang sama} 
     **/

    function setPersenPPNTerima(obj, update_faktur) {
        //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
        var ppnpersen = parseInt($(obj).val());

        if (ppnpersen > 0) {
            ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
        }

        if (update_faktur == true) {
            $(".ppn_terima").each(function() {
                $(this).val(ppnpersen);
            });

            $(".ppn_terima").each(function() {
                hitungTotal();
            });
        }
        $(obj).val(ppnpersen);
    }

    function hitungTotalFaktur() {
        var sudahbayar = $("#<?php echo CHtml::activeId($modelBayar, 'sudahbayar') ?>").val();
        $("#BKFakturPembelianT_persendiscount").val(formatFloat($("#BKFakturPembelianT_persendiscount").val()));
        unformatNumberSemua();

        //var jmldiskonasli = parseInt($("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiskonasli'); ?>").val()); 

        var totalnetto = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'totharganetto'); ?>").val());
        var jmldiscount = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount'); ?>").val());
        var persendiscount = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'persendiscount'); ?>").val());
        var persenppn = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'persenppn'); ?>").val());
        var totalppn = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakppn'); ?>").val());
        var totalpph = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakpph'); ?>").val());

        var totalbruto = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'totalhargabruto'); ?>").val());
        var totalbruto = parseFloat(unformatNumber($('#total').val()));
        //    var diskontot = 0;
        //	var totalseluruh = 0;
        //	var ppntot = 0;
        //	var totalpajakppn = 0;
        //        
        //	//  console.log("diskon ",formatThousandDecimal(persendiscount));
        //	
        //	diskontot = jmldiscount;//(totalnetto*(persendiscount/100));
        //	ppntot = Math.round(totppnterima);
        //        totalpajakppn = ((totalnetto - diskontot) * persenppn)/100;
        //    
        //    
        //    totalnetto = totalbruto - ppntot + diskontot;
        //        var totalhpp = totalnetto - jmldiscount + totalpajakppn; 
        ////	var totalseluruh = totalbruto;
        var totalseluruh = totalbruto;

        //	$("#<?php // echo CHtml::activeId($modFakturBeli, 'totalpajakppn') 
                    ?>").val(formatNumber(totalpajakppn));

        //	$("#<?php // echo CHtml::activeId($modFakturBeli, 'totalhargabruto') 
                    ?>").val(formatNumber(Math.round(totalseluruh)));

        formatNumberSemua();

        $("#BKBayarkeSupplierT_totaltagihan").val(formatNumber((Math.round(totalseluruh) - sudahbayar)));
        $("#BKBayarkeSupplierT_jmldibayarkan").val(formatNumber((Math.round(totalseluruh) - sudahbayar)));

        hitungKasKeluar();
    }

    /**
     * class integer2 di unformat 
     * @returns {undefined}
     */
    //function unformatNumberSemua(){
    //    $(".integer2").each(function(){
    //        $(this).val(parseInt(unformatNumber($(this).val())));
    //    });
    //    $(".integerfloat").each(function(){
    //        $(this).val(parseInt(unformatNumber($(this).val())));
    //    });
    //	
    //	$('.float2').each(function(){
    //      $(this).val(parseFloat(unformatNumber($(this).val())));
    //});
    //}
    /**
     * class integer2 di format kembali
     * @returns {undefined}
     */
    //function formatNumberSemua(){
    //    $(".integer2").each(function(){
    //        $(this).val(formatInteger($(this).val()));
    //    });

    //$('.float2').each(function(){
    //  $(this).val(formatFloat($(this).val()));
    //});
    //}
</script>