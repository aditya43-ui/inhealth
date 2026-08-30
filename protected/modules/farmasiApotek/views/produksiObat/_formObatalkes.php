<div class="row" style="margin-top: 17px;">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Obat</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset class="" id="obatAlkes">
                            <?php
                            echo $form->textFieldRow($modObatalkesM, 'obatalkes_kode', array(
                                'class' => 'span3',
                                'placeholder' => 'Kode',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                            ));
                            ?>
                            <?php
                            echo $form->textFieldRow($modObatalkesM, 'obatalkes_nama', array(
                                'class' => 'span3',
                                'placeholder' => 'Nama obat & alkes',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200,
                                'onkeyup' => 'generateKode(this)'
                            ));
                            ?>
                            <div class="control-group">
                                <div class="control-label">
                                    <?php echo CHtml::label("Asal Barang<span color='red'> *</span>", 'sumberdana_id', array('class' => 'control-label')); ?>
                                </div>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($modObatalkesM, 'sumberdana_id', CHtml::listData($modObatalkesM->SumberDanaItems, 'sumberdana_id', 'sumberdana_nama'), array(
                                        'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'empty' => '-- Pilih --', 'style' => 'width:100px;'
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">
                                    <?php echo CHtml::label('Jenis Obat Alkes', 'jenisobatalkes_id'); ?>
                                    <?php echo $form->hiddenField($modObatalkesM, 'jenisobatalkes_id'); ?>
                                </div>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyJuiAutoComplete', array(
                                        'name' => 'jenisobatalkes',
                                        'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutoCompleteJenisObat') . '",
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
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                $(\'#FAObatalkesM_jenisobatalkes_id\').val(ui.item.jenisobatalkes_id);
                                                $(\'#jenisobatalkes\').val(ui.item.jenisobatalkes_nama);
                                                 return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => false,
                                            'placeholder' => 'Jenis Obat Alkes',
                                            'size' => 13,
                                            'class' => 'span3',
                                            'onkeypress' => "return $(this).focusNextInputField(event);",
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogjenisobatalkes'),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Tgl. Kedaluwarsa<span color='red'> *</span>", 'tglkadaluarsa', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php $format = new MyFormatter(); ?>
                                    <?php $modObatalkesM->tglkadaluarsa = $format->formatDateTimeForUser($modObatalkesM->tglkadaluarsa); ?>
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modObatalkesM,
                                        'attribute' => 'tglkadaluarsa',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => 'Tanggal kedaluwarsa',
                                            'class' => 'span3 dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>
                                    <?php $modObatalkesM->tglkadaluarsa = $format->formatDateTimeForDb($modObatalkesM->tglkadaluarsa); ?>
                                </div>
                            </div>

                            <?php
                            echo $form->dropDownListRow($modObatalkesM, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                                'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --', 'style' => 'width:150px;'
                            ));
                            ?>

                            <?php
                            echo $form->dropDownListRow($modObatalkesM, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                                'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --', 'style' => 'width:100px;'
                            ));
                            ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Jenis Kelompok <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList(
                                        $modObatalkesM,
                                        'jnskelompok',
                                        LookupM::getItems('jnskelompok'),
                                        array(
                                            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'empty' => '-- Pilih --', 'style' => 'width:100px;'
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> HPP
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="row" id="fieldsetHargaNetto">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo $form->labelEx($modObatalkesM, 'harganetto', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'harganetto', array(
                                    'class' => 'span3 integer2',
                                    'placeholder' => 'Harga netto',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modObatalkesM, 'discount', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'discount', array(
                                    'class' => 'span1 float2',
                                    'placeholder' => '00',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'
                                ));
                                ?> %
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modObatalkesM, 'ppn_persen', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'ppn_persen', array(
                                    'class' => 'span1 float2',
                                    'placeholder' => '00',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'
                                ));
                                ?> %
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo Chtml::label('HPP', 'hpp', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'hpp', array(
                                    'class' => 'span1 integer2', 'onkeyup' => 'hitungSemua();',
                                    'placeholder' => '00',
                                    'onkeypress' => "return $(this).focusNextInputField(event);"
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="col-sm-12 control">
                                <span size="1px">HPP = (HARGA NETTO - (HARGA NETTO * DISCOUNT) + ((HARGA NETTO - (HARGA NETTO * DISCOUNT) * PPN))</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 17px;">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Stok
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="" id="fieldsetStok">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-group">
                                <?php echo $form->labelEx($modObatalkesM, 'satuanbesar_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($modObatalkesM, 'satuanbesar_id', CHtml::listData($modObatalkesM->SatuanBesarItems, 'satuanbesar_id', 'satuanbesar_nama'), array(
                                        'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'empty' => '-- Pilih --', 'style' => 'width:130px;'
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modObatalkesM, 'satuankecil_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($modObatalkesM, 'satuankecil_id', CHtml::listData($modObatalkesM->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'), array(
                                        'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'empty' => '-- Pilih --',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modObatalkesM, 'minimalstok', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modObatalkesM, 'minimalstok', array(
                                        'class' => 'span1 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);"
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Stok Sekarang <span class="required">*</span></label>
                                <div class="controls">
                                    <?php echo $form->textField($modObatalkesM, 'stoksekarang', array(
                                        'class' => 'span1 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);"
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modObatalkesM, 'kemasanbesar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modObatalkesM, 'kemasanbesar', array(
                                        'class' => 'span1 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);"
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modObatalkesM, 'lokasigudang_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($modObatalkesM, 'lokasigudang_id', CHtml::listData($modObatalkesM->lokasiGudangItems, 'lokasigudang_id', 'lokasigudang_nama'), array(
                                        'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'empty' => '-- Pilih --', 'style' => 'width:130px;'
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Harga Jual Apotek
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="" id="fieldsetHargaJualApotek">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo $form->labelEx($modObatalkesM, 'marginresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'marginresep', array(
                                    'class' => 'span1 float2',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'
                                ));
                                ?> %
                            </div>
                        </div>
                        <?php echo $form->hiddenField($modObatalkesM, 'jasadokter', array(
                            'class' => 'span1 integer2',
                            'onkeypress' => "return $(this).focusNextInputField(event);"
                        ));
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modObatalkesM, 'hjaresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('hjaresep', 0, array(
                                    'class' => 'span3 integer2', 'value' => 0, 'readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:80px;'
                                ));
                                ?> Rupiah
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modObatalkesM, 'hjaresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'hjaresep', array(
                                    'class' => 'span3 integer2',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:80px;'
                                ));
                                ?> Rupiah
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogjenisobatalkes',
    'options' => array(
        'title' => 'Pencarian Jenis Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 'auto',
        'resizable' => false,
    ),
));

$modTherapiobat = new JenisobatalkesM('searchDialog');
$modTherapiobat->unsetAttributes();
if (isset($_GET['JenisobatalkesM'])) {
    $modTherapiobat->attributes = $_GET['JenisobatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenisobatalkes-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTherapiobat->searchDialog(),
    'filter' => $modTherapiobat,
    'template' => "{items}\n{pager}",
    //        'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectjenisobatalkes",
                                                    "onClick" => "\$(\"#FAObatalkesM_jenisobatalkes_id\").val($data->jenisobatalkes_id);
                                                                \$(\"#jenisobatalkes\").val(\"$data->jenisobatalkes_nama\");
                                                                \$(\"#dialogjenisobatalkes\").dialog(\"close\");
                                                                return false;
                                                                "
                                             )
                             )',
        ),
        'jenisobatalkes_nama',
        'jenisobatalkes_namalain',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>
    function hitungSemua() {
        var harganetto = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'harganetto') ?>').val());
        var discount = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'discount') ?>').val()) / 100;
        var ppn = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'ppn_persen') ?>').val()) / 100;
        var marginresep = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'marginresep') ?>').val()) / 100.0;
        var marginnonresep = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'marginnonresep') ?>').val()) / 100.0;
        var persenjasadokter = parseFloat($('#persenjasadokter').val());

        var hpp = (harganetto - (harganetto * discount)) + ((harganetto - (harganetto * discount)) * ppn);
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hpp') ?>').val(formatInteger(hpp));

        var hjanonresep = (harganetto + (harganetto * ppn)) + ((harganetto + (harganetto * ppn)) * marginnonresep);
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hjanonresep') ?>').val(formatInteger(hjanonresep));
        $('#hjanonresep').val(formatInteger(hjanonresep));

        if (persenjasadokter == '') {
            persenjasadokter = 0;
        }
        $.post('<?php echo Yii::app()->createUrl('gudangFarmasi/ObatAlkesM/getPersenDokter'); ?>', {
            hargaNetto: harganetto
        }, function(data) {
            $('#persenjasadokter').val(data.jasaResep);
            $('#persenjasadokter_kons').val(data.jasaResep);
        }, 'json');
        var hjaresep = hjanonresep + (hjanonresep * marginresep);
        var jasadokter = hjaresep * (persenjasadokter / 100)
        //JASA DOKTER DIBEBANKAN KE KONSUMEN ATAU DI TANGGUNG APOTEK?? >> hjaresep = hjaresep + jasadokter;
        $('#<?php echo CHtml::activeId($modObatalkesM, 'jasadokter') ?>').val(parseFloat(jasadokter));
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hjaresep') ?>').val(formatInteger(hjaresep));
        $('#hjaresep').val(formatInteger(hjaresep));
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hargajual') ?>').val(formatInteger(hjaresep));

    }

    function jasaDokter(obj) {
        myAlert("Jasa resep dokter tidak bisa diubah!");
        $(obj).val($('#persenjasadokter_kons').val());
    }
</script>