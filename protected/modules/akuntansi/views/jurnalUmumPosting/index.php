<script type="text/javascript">
    var id_rek = [];
</script>
<fieldset id="inputJurnalUmum">
    <legend class="rim2">Jurnal Umum</legend>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js');

    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'id' => 'form-jurnal-umum',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)'
            ),
            'focus' => '#',
        )
    );

    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.currency',
        'currency' => 'PHP',
        'config' => array(
            'symbol' => 'Rp',
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '.',
            'precision' => 0,
        )
    ));

    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => '.',
            'thousands' => '',
            'precision' => 0,
        )
    ));

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <table>
        <tr>
            <td width="50%">
                <?php
                echo $form->hiddenField(
                    $model,
                    "jurnalrekening_id",
                    array(
                        'class' => 'span1',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'readonly' => false
                    )
                );
                ?>

                <?php echo $form->dropDownListRow($model, 'jenisjurnal_id', JenisjurnalM::items(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglbuktijurnal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglbuktijurnal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nobuktijurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
                <?php echo $form->textFieldRow($model, 'kodejurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
            </td>
            <td>
                <?php
                echo $form->hiddenField(
                    $model,
                    "rekperiod_id",
                    array(
                        'class' => 'span1',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'readonly' => false
                    )
                );
                //                    echo $form->dropDownListRow($model,'rekperiod_id', RekperiodM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm'));
                ?>
                <?php echo $form->textFieldRow($model, 'noreferensi', array('class' => 'span3 reqForm numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglreferensi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglreferensi',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>

                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nobku', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
                <?php echo $form->textAreaRow($model, 'urianjurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
    </table>

    <legend class="rim">Detail Jurnal</legend>
    <div class="control-group">
        <label class="control-label">Pilih Rekening</label>
        <div class="controls">
            <?php
            echo CHtml::dropDownList(
                'isJenisRekenig',
                "",
                LookupM::getItems('jenis_rekening'),
                array(
                    'empty' => '-- Pilih --',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'style' => 'float:left;margin-right:5px;',
                    'class' => 'span2',
                )
            );
            ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'rekening_nama',
                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ){return false;}',
                    'select' => 'js:function( event, ui ){
                            tambahDataRekening(ui.item.rincianobyek_id);
                            return false;
                        }'
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => 'Nama Jenis Pengeluaran',
                    'class' => 'span3',
                ),
                'tombolDialog' => array('idDialog' => 'dialogRincianRek',),
            ));
            ?>
        </div>
    </div>
    <?php echo $this->renderPartial('__gridDetailJurnal', array('modelJurDetail' => $modelJurDetail, 'form' => $form)); ?>
    <?php
    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons' => array(
            array(
                'label' => 'Jurnal Posting',
                'icon' => 'entypo-check',
                'url' => '#',
                'htmlOptions' => array(
                    'onclick' => 'simpanJurnalUmum(\'posting\');return false;'
                )
            ),/*
                array(
                    'label'=>'',
                    'items'=>array(
                        array(
                            'label'=>'Posting',
                            'icon'=>'icon-download',
                            'url'=>'#',
                            'itemOptions'=>array(
                                'onclick'=>'simpanJurnalUmum(\'posting\');return false;'
                            )
                        ),
                    )
                ),*/
        )
    ));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('index'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php $this->endWidget(); ?>
</fieldset>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianRek',
    'options' => array(
        'title' => 'Saldo Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 450,
        'resizable' => false,
    ),
));

$this->widget(
    'ext.bootstrap.widgets.HeaderGroupGridView',
    array(
        'id' => 'list-rekening-m-grid',
        'dataProvider' => $rekeningakuntansiV->cariRekening(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'No. Urut',
                'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
            ),
            array(
                'header' => 'Kode Rekening',
                'value' => '$data->getKodeRekening()',
            ),
            array(
                'header' => 'Nama',
                'value' => '$data->getNamaRekening()',
            ),
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                    array(
                        "class"=>"btn-small",
                        "onClick" =>"
                            var iDRek = \'$data->id_temp_rek\';
                            tambahDataRekening(iDRek);
                            return false;
                        ")
                    )
                ',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);
$this->endWidget();
?>

<script type="text/javascript">
    var frmDetailRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputRekening', array('form' => $form, 'modelJurDetail' => $modelJurDetail), true)); ?>);
    var periodeID = <?php echo json_encode($redirect[0]); ?>;
    var urlRedirect = "<?php echo $redirect[1]; ?>";

    function cekSessionPeriode() {
        if (periodeID.length > 1 || periodeID.length == 0) {
            myAlert('Periode tidak valid, silakan cek kembali!');
            window.location.href = urlRedirect;
        }
    }
    cekSessionPeriode();

    function hapusIndexMenu() {
        for (key in id_rek) {
            delete id_rek[key];
        }
        $("#grid_AKJurnaldetailT").find('tbody').empty();
        $("#reseter").click();
    }

    function batalInputJurnal(obj) {
        myConfirm("Apakah Anda yakin akan membatalkan tindakan?", 'Perhatian!', function(r) {
            if (r) {
                $(obj).parents('tr').detach();
            }
        });
    }

    function tambahDataRekening(params) {
        var jenisRekenig = $("#isJenisRekenig").val();

        if (jenisRekenig.length > 0) {
            unMaskMoneyAll();
            /*
            var xxx = params+ '_' +jenisRekenig
            if (id_rek[xxx] == undefined)
            {
                $("#grid_AKJurnaldetailT").find('tbody').append(frmDetailRekening.replace());
                if(jenisRekenig == 'D')
                {
                    $("#grid_AKJurnaldetailT").find('input[name$="[99][saldokredit]"]').attr('disabled','disabled');
                }else{
                    $("#grid_AKJurnaldetailT").find('input[name$="[99][saldodebit]"]').attr('disabled','disabled');
                }
                getDataRekening(params);
                
                id_rek[xxx] = 'yes';
                $("#dialogRincianRek").dialog("close");
            }else{
                myAlert("Pilih rekening yang lain");
            }*/
            $("#grid_AKJurnaldetailT").find('tbody').append(frmDetailRekening.replace());
            if (jenisRekenig == 'D') {
                $("#grid_AKJurnaldetailT").find('input[name$="[99][saldokredit]"]').attr('disabled', 'disabled');
            } else {
                $("#grid_AKJurnaldetailT").find('input[name$="[99][saldodebit]"]').attr('disabled', 'disabled');
            }
            getDataRekening(params);
            $("#dialogRincianRek").dialog("close");
            jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({
                'placement': 'bottom'
            });
        } else {
            myAlert("Pilih Jenis rekening terlebih dahulu");
        }


    }

    function getDataRekening(params) {
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDataRekening'); ?>", {
                id: params
            },
            function(data) {
                var n = 0;
                $.each(data, function(key, value) {
                    $("#grid_AKJurnaldetailT").find("span[name$='[99][" + key + "]']").text(value);
                    n++;
                });
                $("#grid_AKJurnaldetailT").find("input[name$='[99][rekening1_id]']").val(data.struktur_id);
                $("#grid_AKJurnaldetailT").find("input[name$='[99][rekening2_id]']").val(data.kelompok_id);
                $("#grid_AKJurnaldetailT").find("input[name$='[99][rekening3_id]']").val(data.jenis_id);
                $("#grid_AKJurnaldetailT").find("input[name$='[99][rekening4_id]']").val(data.obyek_id);
                $("#grid_AKJurnaldetailT").find("input[name$='[99][rekening5_id]']").val(data.rincianobyek_id);

                if (n == 39) {
                    maskMoneyAll();
                    renameInput('AKJurnaldetailT', 'nourut');
                    renameInput('AKJurnaldetailT', 'jurnaldetail_id');
                    renameInput('AKJurnaldetailT', 'uraiantransaksi');
                    renameInput('AKJurnaldetailT', 'rekening1_id');
                    renameInput('AKJurnaldetailT', 'rekening2_id');
                    renameInput('AKJurnaldetailT', 'rekening3_id');
                    renameInput('AKJurnaldetailT', 'rekening4_id');
                    renameInput('AKJurnaldetailT', 'rekening5_id');
                    renameInput('AKJurnaldetailT', 'saldodebit');
                    renameInput('AKJurnaldetailT', 'saldokredit');
                    renameInput('AKJurnaldetailT', 'catatan');

                    renameInput('AKJurnaldetailT', 'kdstruktur');
                    renameInput('AKJurnaldetailT', 'kdkelompok');
                    renameInput('AKJurnaldetailT', 'kdjenis');
                    renameInput('AKJurnaldetailT', 'kdobyek');
                    renameInput('AKJurnaldetailT', 'kdrincianobyek');
                    renameInput('AKJurnaldetailT', 'nmrincianobyek');
                }
            }, "json"
        );
    }

    function maskMoneyAll() {
        $('#grid_AKJurnaldetailT tbody tr').each(function() {
            $(this).find("input[class$='currency']").maskMoney({
                "symbol": "Rp ",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ".",
                "thousands": ",",
                "precision": 0
            });
        });
    }

    function unMaskMoneyAll() {
        $('#grid_AKJurnaldetailT tbody tr').each(function() {
            $(this).find("input[class$='currency']").unmaskMoney({
                "symbol": "Rp ",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ".",
                "thousands": ",",
                "precision": 0
            });
        });
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#grid_AKJurnaldetailT tbody tr').length;
        var i = -1;
        $('#grid_AKJurnaldetailT tbody tr').each(function() {
            if ($(this).has('span[name$="[kdstruktur]"]').length) {
                i++;
            }
            $(this).find('span[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('span[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');

            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');

            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');

            $(this).find('span[name$="[nourut_ex]"]').text(i + 1);
            $(this).find('input[name$="[nourut]"]').val(i + 1);
        });
    }

    function hitungTotalUang() {
        var saldokredit = 0;
        var saldodebit = 0;
        $('#grid_AKJurnaldetailT tbody tr').each(
            function() {
                saldodebit += parseInt(unformatNumber($(this).find('input[name$="[saldodebit]"]').val()));
                saldokredit += parseInt(unformatNumber($(this).find('input[name$="[saldokredit]"]').val()));
            }
        );
        $("#totalSaldoDebit").val(saldodebit);
        $("#totalSaldoKredit").val(saldokredit);
    }

    function simpanJurnalUmum(params) {
        var jenis_simpan = params;
        var kosong = "";
        var jumlahKosong = $("#inputJurnalUmum").find(".reqForm[value=" + kosong + "]");

        if (jumlahKosong.length > 0) {
            myAlert('Inputan yang bertanda bintang harus diisi, silakan cek kembali!');
        } else {
            var x = 0;
            $('#grid_AKJurnaldetailT tbody tr').each(
                function() {
                    x++;
                }
            );
            var totalSaldoDebit = $("#totalSaldoDebit").val();
            var totalSaldoKredit = $("#totalSaldoKredit").val();
            if (totalSaldoDebit !== totalSaldoKredit) {
                myAlert('Saldo kredit dan debit tidak sama, silakan cek kembali!');
                return false
            }

            if (x > 0) {
                $('.currency').each(
                    function() {
                        this.value = unformatNumber(this.value)
                    }
                );
                $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanJurnalUmum'); ?>", {
                        jenis_simpan: jenis_simpan,
                        data: $("#form-jurnal-umum").serialize()
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            if (data.action == 'insert') {
                                myAlert("Simpan data berhasil");
                                hapusIndexMenu();
                                $("#inputJurnalUmum").find("input[name$='[nobuktijurnal]']").val(data.pesan.nobuktijurnal);
                                $("#inputJurnalUmum").find("input[name$='[kodejurnal]']").val(data.pesan.kodejurnal);
                                $("#inputJurnalUmum").find("input[name$='[rekperiod_id]']").val(data.pesan.rekperiod_id);
                            } else {
                                myAlert("Update data berhasil");
                            }
                        }
                    }, "json"
                );
            } else {
                myAlert('Detail jurnal masih kosong!');
            }

        }
        return false;
    }
</script>