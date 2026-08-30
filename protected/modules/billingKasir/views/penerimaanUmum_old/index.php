<div class="white-container">
    <legend class="rim2">Transaksi <b>Penerimaan Umum</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Penerimaan Umum',
    ); ?>

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
            'precision' => 0,
        )
    ));
    ?>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); 
    ?>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
    ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'bkpenerimaan-umum-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)',
            // 'onsubmit'=>'return cekInput();'
            'onsubmit' => 'return requiredCheck(this);'
        ),
        'focus' => '#',
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->

    <?php //echo $form->errorSummary(array($modPenUmum,$modTandaBukti)); 
    ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php //echo $form->textFieldRow($modPenUmum,'tglpenerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <div class="control-group">
                    <?php $modPenUmum->tglpenerimaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenUmum->tglpenerimaan, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modPenUmum, 'tglpenerimaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPenUmum,
                            'attribute' => 'tglpenerimaan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($modPenUmum, 'nopenerimaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->dropDownListRow($modPenUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->hiddenField($modPenUmum, 'jenispenerimaan_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPenUmum, 'jenispenerimaan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPenUmum,
                            'attribute' => 'jenisKodeNama',
                            'source' => 'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/jenisPenerimaan') . '",
                                                                   dataType: "json",
                                                                   data: {
                                                                       term: request.term,
                                                                   },
                                                                   success: function (data) {
                                                                           response(data);
                                                                   }
                                                               })
                                                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                           $(this).val("");
                                                            return false;
                                                        }',
                                'select' => 'js:function( event, ui ) {
                                                            $("#BKPenerimaanUmumT_jenisKodeNama").val(ui.item.value);
                                                            $("#BKPenerimaanUmumT_jenispenerimaan_id").val(ui.item.jenispenerimaan_id);
                                                            return false;
                                                        }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogJenisPenerimaan', 'idTombol' => 'tombolJenisPenerimaanDialog'),
                            'htmlOptions' => array('placeholder' => 'Kode/Nama Jenis Penerimaan'),
                        ));
                        ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modPenUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->dropDownListRow($modPenUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                ?>
                <div class="control-group">
                    <?php //$modPenUmum->tglpenerimaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenUmum->tglpenerimaan, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
                    ?>
                    <?php echo $form->labelEx($modPenUmum, 'volume', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPenUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownList($modPenUmum, 'satuanvol', LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($modPenUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modPenUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modPenUmum, 'keterangan_penerimaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modPenUmum, 'namapenandatangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($modPenUmum, 'nippenandatangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($modPenUmum, 'jabatanpenandatangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php //echo $form->dropDownListRow($modPenUmum,'penjamin_id', CHtml::listData($modPenUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>

            </td>
        </tr>
    </table>

    <legend class="rim">
        <?php echo CHtml::checkBox('adaUraian', $modPenUmum->isuraintransaksi, array('onchange' => 'bukaUraian(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        Pilih Jika Transaksi Ada Uraiannya
    </legend>
    <table id="tblInputUraian" class="table table-striped table-condensed">
        <thead>
            <tr>
                <th>
                    Uraian
                </th>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody <?php if (!$modPenUmum->isuraintransaksi) echo 'class="hide"' ?>>
            <?php $this->renderPartial('_rowUraian', array('form' => $form, 'modUraian' => $modUraian, 'removeButton' => false)); ?>
        </tbody>
    </table>

    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Total Tagihan', 'totTagihan', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('totTagihan', (isset($totTagihan) ? $totTagihan : null), array('readonly' => true, 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modTandaBukti,'nobuktibayar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'jmlpembulatan', array('readonly' => true, 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'biayamaterai', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'jmlpembayaran', array('onkeyup' => 'hitungKembalian();', 'readonly' => true, 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modTandaBukti, 'uangditerima', array('onkeyup' => 'hitungKembalian();', 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'uangkembalian', array('class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php $modTandaBukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modTandaBukti, 'tglbuktibayar', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modTandaBukti,
                            'attribute' => 'tglbuktibayar',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <?php //echo $form->textFieldRow($modTandaBukti,'tglbuktibayar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>

                <?php echo $form->dropDownListRow($modTandaBukti, 'carapembayaran',  LookupM::getItems('carapembayaran'), array('onchange' => 'ubahCaraPembayaran(this)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Menggunakan Kartu', 'pakeKartu', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::checkBox('pakeKartu', false, array('onchange' => "enableInputKartu();", 'onkeypress' => "return $(this).focusNextInputField(event);")) ?> <i class="icon-chevron-down"></i>
                    </div>
                </div>
                <div id="divDenganKartu" class="hide">
                    <?php echo $form->dropDownListRow($modTandaBukti, 'dengankartu',  LookupM::getItems('dengankartu'), array('onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'bankkartu', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'nokartu', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'nostrukkartu', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($modTandaBukti, 'darinama_bkm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($modTandaBukti, 'alamat_bkm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'sebagaipembayaran_bkm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
        </tr>
    </table>

    <div class="form-actions">
        <?php
        if ($modTandaBukti->isNewRecord) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
            );
        }
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('penerimaanUmum/Index'), array('disabled' => false, 'class' => 'btn btn-danger'));
        ?>
        <?php //TIDAK ADA FUNGSINYA >>> echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 
        ?>

        <?php
        $content = $this->renderPartial('tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    var trUraian = new String(<?php echo CJSON::encode($this->renderPartial('_rowUraian', array('form' => $form, 'modUraian' => array(0 => $modUraian[0]), 'removeButton' => true), true)); ?>);
    $('.integer').each(function() {
        this.value = unformatNumber(this.value)
    });

    function cekInput() {

        var harga = 0;
        var totharga = 0;
        if ($('#BKPenerimaanUmumT_isuraintransaksi').is(':checked')) {
            $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function() {
                harga = harga + unformatNumber(this.value);
            });
            $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function() {
                totharga = totharga + unformatNumber(this.value);
            });

            //if(harga != unformatNumber($('#BKPenerimaanUmumT_hargasatuan').val())){
            //    myAlert('Harga tidak sesuai');return false;
            //}
            if (totharga != unformatNumber($('#BKPenerimaanUmumT_totalharga').val())) {
                myAlert('Harga Uraian tidak sesuai');
                return false;
            }
        }
        $('.integer').each(function() {
            this.value = unformatNumber(this.value)
        });

        return true;
    }

    function hitungTotalUraian(obj) {
        var volume = unformatNumber($(obj).parents('tr').find('input[name$="[volume]"]').val());
        var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());

        $(obj).parents('tr').find('input[name$="[totalharga]"]').val(formatNumber(volume * hargasatuan));
    }

    function hitungTotalHarga() {
        var biayaAdministrasi = unformatNumber($('#BKTandabuktibayarT_biayaadministrasi').val());
        var biayaMaterai = unformatNumber($('#BKTandabuktibayarT_biayamaterai').val());
        var vol = unformatNumber($('#BKPenerimaanUmumT_volume').val());
        var harga = unformatNumber($('#BKPenerimaanUmumT_hargasatuan').val());

        $('#BKPenerimaanUmumT_totalharga').val(formatNumber(vol * harga));
        $('#BKTandabuktibayarT_jmlpembayaran').val(formatNumber((vol * harga) + biayaAdministrasi + biayaMaterai));
    }

    function bukaUraian(obj) {
        if ($(obj).is(':checked')) {
            $('#tblInputUraian').children('tbody').slideDown();
        } else {
            $('#tblInputUraian').children('tbody').slideUp();
        }
    }

    function addRowUraian(obj) {
        $(obj).parents('table').children('tbody').append(trUraian.replace());

        renameInput('BKUraianpenumumT', 'uraiantransaksi');
        renameInput('BKUraianpenumumT', 'volume');
        renameInput('BKUraianpenumumT', 'satuanvol');
        renameInput('BKUraianpenumumT', 'hargasatuan');
        renameInput('BKUraianpenumumT', 'totalharga');
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
            "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
        });
        maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
    }

    function totaltagihankeseluruhan(obj) {
        var totaltagihan = 0;
        var totalharga = 0;
        var totalbaris = 0;
        $(obj).each(function() {
            totalbaris = $(obj).parents("tr").children(".totalharga").val();
            totalharga = unformatNumber(totalbaris);
            totaltagihan += totalharga;
        });
        //    $('#totTagihan').hide();
        $('#totTagihan').val(totaltagihan);
    }

    function batalUraian(obj) {
        myConfirm("Apakah Anda yakin akan membatalkan Uraian?",
            "Perhatian!",
            function(r) {
                if (r) {
                    $(obj).parents('tr').next('tr').detach();
                    $(obj).parents('tr').detach();

                    renameInput('BKUraianpenumumT', 'uraiantransaksi');
                    renameInput('BKUraianpenumumT', 'volume');
                    renameInput('BKUraianpenumumT', 'satuanvol');
                    renameInput('BKUraianpenumumT', 'hargasatuan');
                    renameInput('BKUraianpenumumT', 'totalharga');
                }
            });
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#tblInputUraian tr').length;
        var i = -1;
        $('#tblInputUraian tr').each(function() {
            if ($(this).has('input[name$="[uraiantransaksi]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function enableInputKartu() {
        if ($('#pakeKartu').is(':checked'))
            $('#divDenganKartu').show();
        else
            $('#divDenganKartu').hide();
        if ($('#BKTandabuktibayarT_dengankartu').val() != '') {
            //myAlert('isi');
            $('#BKTandabuktibayarT_bankkartu').removeAttr('readonly');
            $('#BKTandabuktibayarT_nokartu').removeAttr('readonly');
            $('#BKTandabuktibayarT_nostrukkartu').removeAttr('readonly');
        } else {
            //myAlert('kosong');
            $('#BKTandabuktibayarT_bankkartu').attr('readonly', 'readonly');
            $('#BKTandabuktibayarT_nokartu').attr('readonly', 'readonly');
            $('#BKTandabuktibayarT_nostrukkartu').attr('readonly', 'readonly');

            $('#BKTandabuktibayarT_bankkartu').val('');
            $('#BKTandabuktibayarT_nokartu').val('');
            $('#BKTandabuktibayarT_nostrukkartu').val('');
        }
    }

    function ubahCaraPembayaran(obj) {
        if (obj.value == 'CICILAN') {
            $('#BKTandabuktibayarT_jmlpembayaran').removeAttr('readonly');
        } else {
            $('#BKTandabuktibayarT_jmlpembayaran').attr('readonly', true);
            hitungJmlBayar();
        }

        if (obj.value == 'TUNAI') {
            hitungJmlBayar();
        }
    }

    function hitungJmlBayar() {
        var biayaAdministrasi = unformatNumber($('#BKTandabuktibayarT_biayaadministrasi').val());
        var biayaMaterai = unformatNumber($('#BKTandabuktibayarT_biayamaterai').val());
        var totBayar = 0;
        var totTagihan = unformatNumber($('#BKPenerimaanUmumT_totalharga').val());
        var jmlPembulatan = unformatNumber($('#BKTandabuktibayarT_jmlpembulatan').val());

        totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai;

        $('#BKTandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
        hitungKembalian();
    }

    function hitungKembalian() {
        var jmlBayar = unformatNumber($('#BKTandabuktibayarT_jmlpembayaran').val());
        var uangDiterima = unformatNumber($('#BKTandabuktibayarT_uangditerima').val());
        var uangKembalian = uangDiterima - jmlBayar;

        $('#BKTandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));
    }

    function maskMoneyInput(tr) {
        $(tr).find('input.currency:text').maskMoney({
            "symbol": "Rp ",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ".",
            "thousands": ",",
            "precision": 0
        });
    }

    $(document).ready(function() {
        <?php
        if (isset($modPenUmum->penerimaanumum_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_KEUANGAN ?>,
                judulnotifikasi: 'Penerimaan Umum',
                isinotifikasi: 'Telah dilakukan penerimaan umum dengan <?php echo $modPenUmum->nopenerimaan ?> pada <?php echo $modPenUmum->tglpenerimaan ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
</script>

<?php
//========= Dialog buat cari data Jenis Penerimaan =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPenerimaan',
    'options' => array(
        'title' => 'Pencarian Jenis Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$modJenispenerimaan = new JenispenerimaanM('searchJenisPenerimaan');
$modJenispenerimaan->unsetAttributes();
if (isset($_GET['JenispenerimaanM'])) {
    $modJenispenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modJenispenerimaan->searchJenisPenerimaan(),
    'filter' => $modJenispenerimaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "
                                        $(\"#dialogJenisPenerimaan\").dialog(\"close\");
                                        $(\"#BKPenerimaanUmumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
                                        $(\"#BKPenerimaanUmumT_jenisKodeNama\").val(\"$data->jenispenerimaan_kode - $data->jenispenerimaan_nama\");
                                    "))',
        ),
        'jenispenerimaan_kode',
        'jenispenerimaan_nama',
        'jenispenerimaan_namalain',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>