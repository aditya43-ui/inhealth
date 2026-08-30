<div class="white-container">
    <legend class="rim2">Transaksi <b>Pengeluaran Umum</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Pengeluaran Umum',
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
            //        'decimal'=>',',
            //        'thousands'=>'.',
            'precision' => 0,
        )
    ));
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'bkpengeluaran-umum-t-form',
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
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->

    <?php //echo $form->errorSummary(array($modPengUmum,$modBuktiKeluar)); 
    ?>

    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php //echo $form->textFieldRow($modPengUmum,'tglpengeluaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <div class="control-group">
                    <?php $modPengUmum->tglpengeluaran = MyFormatter::formatDateTimeForUser($modPengUmum->tglpengeluaran); ?>
                    <?php echo $form->labelEx($modPengUmum, 'tglpengeluaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPengUmum,
                            'attribute' => 'tglpengeluaran',
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
                <?php echo $form->textFieldRow($modPengUmum, 'nopengeluaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->dropDownListRow($modPengUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </td>
            <td>
                <?php echo $form->hiddenField($modPengUmum, 'jenispengeluaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengUmum, 'jenispengeluaran_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPengUmum,
                            'attribute' => 'jenisKodeNama',
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/jenisPengeluaran') . '",
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
                                                        $("#BKPengeluaranumumT_jenisKodeNama").val(ui.item.value);
                                                        $("#BKPengeluaranumumT_jenispengeluaran_id").val(ui.item.jenispengeluaran_id);
                                                        $("#BKTandabuktikeluarT_untukpembayaran").val(ui.item.value);
                                                        return false;
                                                    }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran', 'idTombol' => 'tombolJenisPengeluaranDialog'),
                            'htmlOptions' => array('placeholder' => 'Nama Jenis Pengeluaran'),
                        ));
                        ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modPengUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->dropDownListRow($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengUmum, 'volume', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPengUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownList($modPengUmum, 'satuanvol', LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPengUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modPengUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modPengUmum, 'keterangankeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modPengUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                ?>
                <?php //echo $form->textFieldRow($modPengUmum,'nippenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                ?>
                <?php //echo $form->textFieldRow($modPengUmum,'jabatanpenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                ?>
                <?php //echo $form->dropDownListRow($modPengUmum,'penjamin_id', CHtml::listData($modPengUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>

            </td>
        </tr>
    </table>
    <fieldset class="box">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo $form->checkBox($modPengUmum, 'isurainkeluarumum', array('onchange' => 'bukaUraian(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    Pilih Jika Transaksi Ada Uraiannya
                </div>
            </div>
            <div class="panel-body">
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
                    <tbody <?php if (!$modPengUmum->isurainkeluarumum) echo 'class="hide"' ?>>
                        <?php $this->renderPartial('_rowUraian', array('form' => $form, 'modUraian' => $modUraian)); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </fieldset>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                    <?php //$modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); 
                    ?>
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
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); 
                ?>
                <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'inputFormTabel integer span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div id="divCaraBayarTransfer" class="hide">
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
            <td>
                <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
        </tr>
    </table>

    <div class="form-actions">
        <?php
        if ($modBuktiKeluar->isNewRecord) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
            );
        }
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('pengeluaranUmum/Index'), array('disabled' => false, 'class' => 'btn btn-danger'));

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

    function cekInput() {
        var harga = 0;
        var totharga = 0;
        if ($('#BKPengeluaranumumT_isuraintransaksi').is(':checked')) {
            $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function() {
                harga = harga + unformatNumber(this.value);
            });
            $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function() {
                totharga = totharga + unformatNumber(this.value);
            });

            //if(harga != unformatNumber($('#BKPengeluaranumumT_hargasatuan').val())){
            //    myAlert('Harga tidak sesuai');return false;
            //}
            if (totharga != unformatNumber($('#BKPengeluaranumumT_totalharga').val())) {
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
        var biayaAdministrasi = unformatNumber($('#BKTandabuktikeluarT_biayaadministrasi').val());
        var vol = unformatNumber($('#BKPengeluaranumumT_volume').val());
        var harga = unformatNumber($('#BKPengeluaranumumT_hargasatuan').val());

        $('#BKPengeluaranumumT_totalharga').val(formatNumber(vol * harga));
        $('#BKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(vol * harga + biayaAdministrasi));
    }

    function hitungJmlBayar() {
        var biayaAdministrasi = unformatNumber($('#BKTandabuktikeluarT_biayaadministrasi').val());
        var totBayar = 0;
        var totHarga = unformatNumber($('#BKPengeluaranumumT_totalharga').val());

        totBayar = totHarga + biayaAdministrasi;

        $('#BKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(totBayar));
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

        renameInput('BKUraiankeluarumumT', 'uraiantransaksi');
        renameInput('BKUraiankeluarumumT', 'volume');
        renameInput('BKUraiankeluarumumT', 'satuanvol');
        renameInput('BKUraiankeluarumumT', 'hargasatuan');
        renameInput('BKUraiankeluarumumT', 'totalharga');
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
            "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
        });
        maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
    }

    function batalUraian(obj) {
        myConfirm("Apakah Anda yakin akan membatalkan Uraian?",
            "Perhatian!",
            function(r) {
                if (r) {
                    $(obj).parents('tr').next('tr').detach();
                    $(obj).parents('tr').detach();
                    renameInput('BKUraiankeluarumumT', 'uraiantransaksi');
                    renameInput('BKUraiankeluarumumT', 'volume');
                    renameInput('BKUraiankeluarumumT', 'satuanvol');
                    renameInput('BKUraiankeluarumumT', 'hargasatuan');
                    renameInput('BKUraiankeluarumumT', 'totalharga');
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

    function formCarabayar(carabayar) {
        //myAlert(carabayar);
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
        } else {
            $('#divCaraBayarTransfer').slideUp();
        }
    }

    function maskMoneyInput(tr) {
        $(tr).find('input.currency:text').maskMoney({
            "symbol": "Rp ",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 0
        });
    }
    //testestes
    $(document).ready(function() {
        <?php
        if (isset($modPengUmum->pengeluaranumum_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_KEUANGAN ?>,
                judulnotifikasi: 'Pengeluaran Umum',
                isinotifikasi: 'Telah dilakukan pengeluaran umum dengan <?php echo $modPengUmum->nopengeluaran ?> pada <?php echo $modPengUmum->tglpengeluaran ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });
</script>

<?php
//========= Dialog buat cari data Jenis Pengeluaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPengeluaran',
    'options' => array(
        'title' => 'Pencarian Jenis Pengeluaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$modJenispengeluaran = new JenispengeluaranM('searchJenisPengeluaran');
$modJenispengeluaran->unsetAttributes();
if (isset($_GET['JenispengeluaranM'])) {
    $modJenispengeluaran->attributes = $_GET['JenispengeluaranM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modJenispengeluaran->searchJenisPengeluaran(),
    'filter' => $modJenispengeluaran,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "
                                        $(\"#dialogJenisPengeluaran\").dialog(\"close\");
                                        $(\"#BKPengeluaranumumT_jenispengeluaran_id\").val(\"$data->jenispengeluaran_id\");
                                        $(\"#BKPengeluaranumumT_jenisKodeNama\").val(\"$data->jenispengeluaran_kode - $data->jenispengeluaran_nama\");
                                    "))',
        ),
        'jenispengeluaran_kode',
        'jenispengeluaran_nama',
        'jenispengeluaran_namalain',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>