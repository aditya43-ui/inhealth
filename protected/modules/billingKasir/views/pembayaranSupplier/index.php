<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-money-bill"></i> Pembayaran Supplier
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
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
                <?php $this->renderPartial($this->path_view . '_dataFakturBeli', array('modFakturBeli' => $modFakturBeli)); ?>

                <?php echo $form->errorSummary(array($modelBayar, $modBuktiKeluar, $modUangMuka)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-money-bill"></i> Pembayaran Obat Alkes
                </div>
            </div>
            <div class="panel-body">
                <div class="block-tabel">
                    <table id="tblBayarOA" class="table table-bordered table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Obat dan Alkes</th>
                                <th>Jml terima</th>
                                <th>Harga Netto</th>
                                <th>Keringanan %</th>
                                <th>Keringanan Rp</th>
                                <th>PPN</th>
                                <th hidden>PPh</th>
                                <th>HPP</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cekBayarSupp = BayarkesupplierT::model()->findAllByAttributes(array('fakturpembelian_id' => $modFakturBeli->fakturpembelian_id));
                            if (count((array)$cekBayarSupp) > 0) {
                                echo $this->renderPartial($this->path_view . '_rowFaktur', array('modDetailBeli' => $modDetailBeli,), true);
                            } else {
                                echo $this->renderPartial($this->path_view . '_rowFakturBaru', array('modDetailBeli' => $modDetailBeli,), true);
                            }

                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <?php

                                    if (count((array)$cekBayarSupp) > 0) {
                                        echo $form->hiddenField($modFakturBeli, 'adapembayaran', array('value' => 'tidak', 'class' => 'span2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                    } else {
                                        echo $form->hiddenField($modFakturBeli, 'adapembayaran', array('value' => 'ada', 'class' => 'span2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                        echo $form->hiddenField($modFakturBeli, 'totharganetto', array('class' => 'span2 integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                        echo $form->hiddenField($modFakturBeli, 'persendiscount', array('class' => 'span2  float2', 'readonly' => false));
                                        echo $form->hiddenField($modFakturBeli, 'jmldiskonasli', array('class' => 'span2 integer2', 'readonly' => false));
                                        echo $form->hiddenField($modFakturBeli, 'jmldiscount', array('class' => 'span2 integer2', 'readonly' => false));
                                        echo $form->hiddenField($modFakturBeli, 'totalpajakppn', array('class' => 'span2 integer2', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                        echo $form->hiddenField($modFakturBeli, 'totalpajakpph', array('class' => 'span2 integer2', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                        echo $form->hiddenField($modFakturBeli, 'biayamaterai', array('class' => 'span2 integer2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'display:none;'));
                                        echo $form->hiddenField($modFakturBeli, 'totalhargabruto', array('class' => 'span2 integer2', 'readonly' => TRUE));
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tfoot>
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
                        <div class="control-group">
                            <?php echo CHtml::label(" Metode Bayar ", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>

                        <div id="divCaraBayarTransfer" class="hide">
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>



                        <?php //echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); 
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modelBayar, 'totaltagihan', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($modUangMuka,'jumlahuang',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <div class="control-group " hidden>
                            <label class='control-label required'>Uang Muka <span class="required">*</span></label>
                            <div class="controls">
                                <?php echo $form->textField($modUangMuka, 'jumlahuang', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modelBayar, 'jmldibayarkan', array('class' => 'inputFormTabel integer2 span3', 'onblur' => 'hitungKasKeluar();', 'onkeyup' => 'hitungKasKeluar()', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->hiddenField($modelBayar, 'sudahbayar', array('class' => 'inputFormTabel integer2 span3', 'onblur' => 'hitungKasKeluar();', 'onkeyup' => 'hitungKasKeluar()', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('onkeyup' => 'hitungKasKeluar();', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onfocus' => '$(this).select();')); ?>
                        <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>



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
                    array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabled)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                );
            }
            //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($modTandaBukti->tandabuktibayar_id);return false",'disabled'=>false)); 
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
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
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.integer2').each(function() {
            this.value = formatNumber(this.value)
        });
    });

    function cekInputan() {
        $('.integer2').each(function() {
            this.value = unformatNumber(this.value)
        });
        $('.float2').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;


    }

    function hitungKasKeluar() {
        var jmlBayar = parseFloat(unformatNumber($('#BKBayarkeSupplierT_jmldibayarkan').val()));
        var biayaAdmin = parseFloat(unformatNumber($('#BKTandabuktikeluarT_biayaadministrasi').val()));
        var kasKeluar = jmlBayar + biayaAdmin;

        $('#BKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(kasKeluar));
    }

    function formCarabayar(carabayar) {
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
        } else {
            $('#divCaraBayarTransfer').slideUp();
        }
    }

    function loadFakturPembelian(id) {
        console.log(id);
        $.post('<?php echo $this->createUrl('loadFakturFarmasi'); ?>', {
            id: id
        }, function(data) {
            $("#tblBayarOA tbody").html(data.tabFaktur);
            $("#FAPendaftaranT_tglfaktur").val(data.fakturBeli.tglfaktur);
            $("#FAPendaftaranT_tgljatuhtempo").val(data.fakturBeli.tgljatuhtempo);

            $("#FAPendaftaranT_umur_hutang").val(data.umur_hutang);
            $("#FAPendaftaranT_supplier_id").val((data.supplier == '') ? data.supplier : data.supplier.supplier_nama);
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
            } else {
                $("#<?php echo CHtml::activeId($modFakturBeli, 'adapembayaran') ?>").val('ada');
                $("#<?php echo CHtml::activeId($modFakturBeli, 'adapembayaran') ?>").attr('value', 'ada');
            }

            $(".integer3").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": ".",
                "precision": 0
            });
            $(".float2").maskMoney({
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
        var fakturpembelian_id = "<?php echo isset($modFakturBeli->bayarkesupplier_id) ? $modFakturBeli->bayarkesupplier_id : null; ?>";
        window.open("<?php echo $this->createUrl('print') ?>&id=" + fakturpembelian_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
    }

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
        var totppnterima = 0;
        var totpphterima = 0;
        var totdisterima = 0;
        var sudahbayar = $("#<?php echo CHtml::activeId($modelBayar, 'sudahbayar') ?>").val();


        $('#tblBayarOA tbody tr').each(function() {
            setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));

            var jmlterima = parseInt($(this).find('input[name$="[jmlterima]"]').val());
            var harganetto = parseInt($(this).find('input[name$="[harganettofaktur]"]').val());
            var persendis = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
            var jmldis = parseInt($(this).find('input[name$="[jmldiscount]"]').val());
            var persen_ppn = parseInt($(this).find('input[name$="[persenppnfaktur]"]').val());
            var hpp = parseInt($(this).find('input[name$="[hargasatuan]"]').val());

            var ppn = 0;
            var rpppn = 0;
            var pph = 0;
            var rppph = 0;


            ppn = persen_ppn;
            rpppn = (harganetto - jmldis) * (ppn / 100);


            subhpp = ((harganetto - jmldis) + rppph + rpppn);

            subtotal = Math.round(subhpp) * jmlterima;

            persenpph += (rppph * jmlterima);

            total += subtotal;


            totbruto += subtotal;

            tothpp += subhpp;

            totppn += rpppn;

            totnettqty += harganetto * jmlterima;
            //alert(Math.round(rpppn));
            totppnterima += (Math.round(rpppn) * jmlterima);
            totpphterima += (Math.round(rppph) * jmlterima);
            totdisterima += (Math.round(jmldis) * jmlterima);

            $(this).find('input[name$="[subtotal]"]').val(Math.round(subtotal));
            $(this).find('input[name$="[jmldiscount]"]').val(Math.round(jmldis));
            $(this).find('input[name$="[persenppnfaktur]"]').val(Math.round(ppn));
            $(this).find('input[name$="[persenpphfaktur]"]').val(Math.round(pph));
            $(this).find('input[name$="[hargasatuan]"]').val(Math.round(subhpp));
            $(this).find('input[name$="[jmlppn]"]').val(Math.round(rpppn));
        });
        //alert(total);
        $("#BKBayarkeSupplierT_totaltagihan").val(total - sudahbayar);
        $("#BKBayarkeSupplierT_jmldibayarkan").val(total - sudahbayar);
        //alert(totdisterima);
        $("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiskonasli') ?>").val(totdisterima);
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totharganetto'); ?>').val(Math.round(totnettqty));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakppn'); ?>').val(Math.round(totppnterima));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakpph'); ?>').val(Math.round(totpphterima));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount'); ?>').val(Math.round(totdisterima));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalhargabruto'); ?>').val(Math.round(totbruto));

        formatNumberSemua();
        hitungTotalFaktur();
        hitungKasKeluar();
    }

    function hitungTotalByHPP() {
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
        var totppnterima = 0;
        var totpphterima = 0;
        var totdisterima = 0;
        var sudahbayar = $("#<?php echo CHtml::activeId($modelBayar, 'sudahbayar') ?>").val();

        $('#tblBayarOA tbody tr').each(function() {
            setJmlDiskon2($(this).find('input[name$="[persendiscount]"]'));

            var jmlterima = parseInt($(this).find('input[name$="[jmlterima]"]').val());
            var harganetto = parseInt($(this).find('input[name$="[harganettofaktur]"]').val());
            var persendis = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
            var jmldis = parseInt($(this).find('input[name$="[jmldiscount]"]').val());
            var persen_ppn = parseInt($(this).find('input[name$="[persenppnfaktur]"]').val());
            var hpp = parseInt($(this).find('input[name$="[hargasatuan]"]').val());


            subtotal = 0;


            var ppn = 0;
            var rpppn = 0;
            var pph = 0;
            var rppph = 0;


            ppn = persen_ppn;
            rpppn = (harganetto - jmldis) * (ppn / 100);


            subhpp = ((harganetto - jmldis) + rppph + rpppn);

            subtotal = Math.round(subhpp) * jmlterima;

            persenpph += (rppph * jmlterima);


            total += subtotal;


            totbruto += subtotal;

            tothpp += subhpp;

            totppn += rpppn;

            totnettqty += harganetto * jmlterima;
            //alert(Math.round(rpppn));
            totppnterima += (Math.round(rpppn) * jmlterima);
            totpphterima += (Math.round(rppph) * jmlterima);
            totdisterima += (Math.round(jmldis) * jmlterima);


            $(this).find('input[name$="[subtotal]"]').val(Math.round(subtotal));
            $(this).find('input[name$="[jmldiscount]"]').val(Math.round(jmldis));
            $(this).find('input[name$="[persenppnfaktur]"]').val(Math.round(ppn));
            $(this).find('input[name$="[persenpphfaktur]"]').val(Math.round(pph));
            $(this).find('input[name$="[hargasatuan]"]').val(Math.round(subhpp));
            $(this).find('input[name$="[jmlppn]"]').val(Math.round(rpppn));
        });
        $("#BKBayarkeSupplierT_totaltagihan").val(total - sudahbayar);
        $("#BKBayarkeSupplierT_jmldibayarkan").val(total - sudahbayar);
        $("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiskonasli') ?>").val(totdisterima);
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totharganetto'); ?>').val(Math.round(totnettqty));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakppn'); ?>').val(Math.round(totppnterima));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakpph'); ?>').val(Math.round(totpphterima));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount'); ?>').val(Math.round(totdisterima));
        $('#<?php echo CHtml::activeId($modFakturBeli, 'totalhargabruto'); ?>').val(Math.round(totbruto));
        formatNumberSemua();
        //setPersenDisFaktur($("#GFFakturpembelianT_jmldiscount"));
        hitungTotalFaktur();
        hitungKasKeluar();
    }

    function roundToTwo(num) {
        return +(Math.round(num + "e+2") + "e-2");
    }

    function setPersenDiskon(obj) {
        var jmldiscount = parseInt(unformatNumber($(obj).parents("tr").find('input[name$="[jmldiscount]"]').val()));
        var satuan = parseInt(unformatNumber($(obj).parents("tr").find('.netto').val()));
        var persen = 0;

        persen = roundToTwo((jmldiscount / satuan) * 100);

        $(obj).parents("tr").find('input[name$="[persendiscount]"]').val(formatFloat(parseFloat(persen)));
    }

    function setJmlDiskon(obj) {
        var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));
        var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
        var qty = $(obj).parents("tr").find(".qty").val();

        $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(satuan * (persen / 100)));
    }

    function setPersenPPN(obj) {
        var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppnfaktur]"]').val());

        if (ppnpersen > 0) {
            ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
        }

        $(obj).parents("tr").find('input[name$="[persenppnfaktur]"]').val(ppnpersen);
    }

    function setNettoUbah(obj) {
        var netto = unformatNumber($(obj).parents("tr").find('input[name$="[harganettofaktur]"]').val());
        $(obj).parents("tr").find('input[name$="[harganettoubah]"]').val(formatNumber(netto));
    }

    function setHPP(obj) {
        unformatNumberSemua();
        var hpp = parseInt($(obj).parents("tr").find('input[name$="[hargasatuan]"]').val());
        var nettoubah = parseInt($(obj).parents("tr").find('input[name$="[harganettoubah]"]').val());
        var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppnfaktur]"]').val());
        var diskonpersen = parseFloat($(obj).parents("tr").find('input[name$="[persendiscount]"]').val());
        var jmlterima = parseInt($(obj).parents("tr").find('input[name$="[jmlterima]"]').val());

        var harganetto = 0;

        if (hpp == 0) {
            $(obj).parents("tr").find('input[name$="[harganettofaktur]"]').val(nettoubah);
        } else {
            if (parseInt(diskonpersen) == 100) {
                $(obj).parents("tr").find('input[name$="[hargasatuan]"]').val(0);
                myAlert("HPP tidak bisa lebih dari 0, karena diskon di set 100%");
            } else {
                harganetto = Math.round(hpp / (((100 - diskonpersen + ppnpersen) / 100) - (ppnpersen * diskonpersen) / 10000));

                $(obj).parents("tr").find('input[name$="[harganettofaktur]"]').val(Math.floor(harganetto));

                $(obj).parents("tr").find('input[name$="[subtotal]"]').val(hpp * jmlterima);
            }
        }

        formatNumberSemua();
    }

    function setJmlDiskon(obj) {
        var persen = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[persendiscount]"]').val()));
        var satuan = parseFloat(unformatNumber($(obj).parents("tr").find('.netto').val()));
        var qty = $(obj).parents("tr").find(".qty").val();

        jmldiskon = Math.round((satuan * (persen / 100)));

        $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(formatNumber(jmldiskon));
    }

    function setJmlDiskon2(obj) {
        var persen = parseFloat($(obj).parents("tr").find('input[name$="[persendiscount]"]').val());
        var satuan = parseFloat($(obj).parents("tr").find('.netto').val());
        var qty = $(obj).parents("tr").find(".qty").val();

        jmldiskon = Math.round((satuan * (persen / 100)));

        $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(jmldiskon);
    }

    function hitungTotalFaktur() {
        unformatNumberSemua();

        var jmldiskonasli = parseInt($("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiskonasli'); ?>").val());

        var totalnetto = parseInt($("#<?php echo CHtml::activeId($modFakturBeli, 'totharganetto'); ?>").val());
        var jmldiscount = parseInt($("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount'); ?>").val());
        var persendiscount = parseFloat($("#<?php echo CHtml::activeId($modFakturBeli, 'persendiscount'); ?>").val());
        var totalppn = parseInt($("#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakppn'); ?>").val());
        var totalpph = parseInt($("#<?php echo CHtml::activeId($modFakturBeli, 'totalpajakpph'); ?>").val());
        var diskontot = 0;
        var totalseluruh = 0;

        diskontot = totalnetto * (persendiscount / 100);

        var totalseluruh = totalnetto - (jmldiskonasli + diskontot) + totalppn - totalpph;

        if (diskontot == 0) {
            $("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount') ?>").val(jmldiskonasli + diskontot);
        } else {
            $("#<?php echo CHtml::activeId($modFakturBeli, 'jmldiscount') ?>").val(jmldiskonasli + diskontot);
        }
        $("#<?php echo CHtml::activeId($modFakturBeli, 'totalhargabruto') ?>").val(totalseluruh);

        formatNumberSemua();
    }

    $(document).ready(function() {
        <?php if (isset($_GET['frame'])) { ?>
            <?php if (isset($_GET['idFakturPembelian'])) {
                if (count((array)$cekBayarSupp) > 0) {
                } else {
            ?>
                    hitungTotal();
            <?php }
            } ?>
        <?php } ?>
    })
</script>