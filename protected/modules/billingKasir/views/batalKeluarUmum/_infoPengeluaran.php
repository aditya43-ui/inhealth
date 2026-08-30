<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPengeluaran, 'nopengeluaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget(
                    'MyJuiAutoComplete',
                    array(
                        'name' => 'BKPengeluaranumumT[nopengeluaran]',
                        'value' => $modPengeluaran->nopengeluaran,
                        'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutoCompleteInfoPengeluaranUmum') . '",
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
												$(this).val(""); //UNTUK MENANDAI SDH TERPILIH ATAU BELUM
												return false;
											}',
                            'select' => 'js:function( event, ui ) {
												isiInfoPengeluaran(ui.item);
												return false;
											}',
                        ),
                        'htmlOptions' => array('placeholder' => 'No. Pengeluaran', 'class' => 'span3',),
                        'tombolDialog' => array('idDialog' => 'dialogPengeluaran', 'idTombol' => 'tombolPengeluaran'),
                    )
                );
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($modPengeluaran, 'jenispengeluaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="control-group">
            <?php //echo $form->textFieldRow($modPengeluaran,'batalkeluarumum_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->hiddenField($modPengeluaran, 'tandabuktikeluar_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modPengeluaran, 'kelompoktransaksi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php //echo $form->textFieldRow($modPengeluaran,'nopengeluaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
            ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($modPengeluaran, 'tglpengeluaran', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($modPengeluaran, 'volume', array('readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->textFieldRow($modPengeluaran, 'satuanvol', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($modPengeluaran, 'hargasatuan', array('readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($modPengeluaran, 'totalharga', array('readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($modPengeluaran, 'biayaadministrasi', array('readonly' => true, 'class' => 'integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textAreaRow($modPengeluaran, 'keterangankeluar', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<?php //echo $form->checkBoxRow($modPengeluaran,'isurainkeluarumum', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>


<?php
//========= Dialog buat cari data no pengeluaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPengeluaran',
    'options' => array(
        'title' => 'Pencarian Data Pengeluaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));

$modDialogPengeluaran = new BKPengeluaranumumT('searchPengeluaran');
$modDialogPengeluaran->unsetAttributes();
if (isset($_GET['BKPengeluaranumumT'])) {
    $modDialogPengeluaran->attributes = $_GET['BKPengeluaranumumT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modDialogPengeluaran->searchPengeluaran(),
    'filter' => $modDialogPengeluaran,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $tandabukti = TandabuktikeluarT::model()->findByPk($data->tandabuktikeluar_id);
                $jenis = JenispengeluaranM::model()->findByPk($data->jenispengeluaran_id);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectPendaftaran",
                    "onClick" => "
                        $(\"#dialogPengeluaran\").dialog(\"close\");
                        $(\"#BKPengeluaranumumT_jenispengeluaran_id\").val(\"$jenis->jenispengeluaran_nama\");
                        $(\"#BKPengeluaranumumT_tandabuktikeluar_id\").val(\"$data->tandabuktikeluar_id\");
                        $(\"#BKPengeluaranumumT_kelompoktransaksi\").val(\"$data->kelompoktransaksi\");
                        $(\"#BKPengeluaranumumT_tglpengeluaran\").val(\"$data->tglpengeluaran\");
                        $(\"#BKPengeluaranumumT_volume\").val(\"" . $data->volume . "\");
                        $(\"#BKPengeluaranumumT_satuanvol\").val(\"" . $data->satuanvol . "\");
                        $(\"#BKPengeluaranumumT_hargasatuan\").val(\"" . MyFormatter::formatNumberForPrint($data->hargasatuan) . "\");
                        $(\"#BKPengeluaranumumT_totalharga\").val(\"" . MyFormatter::formatNumberForPrint($data->totalharga) . "\");
                        $(\"#BKPengeluaranumumT_biayaadministrasi\").val(\"" . MyFormatter::formatNumberForPrint($data->biayaadministrasi) . "\");
                        $(\"#BKPengeluaranumumT_keterangankeluar\").val(\"$data->keterangankeluar\");
                        $(\"#BKPengeluaranumumT_nopengeluaran\").val(\"$data->nopengeluaran\");

                        $(\"#BKBatalKeluarUmumT_tandabuktikeluar_id\").val(\"$data->tandabuktikeluar_id\");
                        $(\"#BKBatalKeluarUmumT_pengeluaranumum_id\").val(\"$data->pengeluaranumum_id\");
                        $(\"#TandabuktibayarT_jmlpembayaran\").val(\"" . MyFormatter::formatNumberForPrint($data->totalharga) . "\");
                        $(\"#TandabuktibayarT_uangditerima\").val(\"" . MyFormatter::formatNumberForPrint($data->totalharga) . "\");
                        $(\"#TandabuktibayarT_darinama_bkm\").val(\"" . $tandabukti->namapenerima . "\");
                        $(\"#TandabuktibayarT_alamat_bkm\").val(\"" . $tandabukti->alamatpenerima . "\");
                        $(\"#TandabuktibayarT_sebagaipembayaran_bkm\").val(\"Batal Pengeluaran Kas/Umum - " . $data->nopengeluaran . "\");

                        $(\"#.integer2\").each(function(){this.value = formatNumber(this.value)});
                    "
                ));
            },
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$row+1',
            'htmlOptions' => array('style' => 'width:20px')
        ),
        array(
            'name' => 'tglpengeluaran',
            'filter' => false,
        ),
        'nopengeluaran',
        'jenispengeluaran.jenispengeluaran_nama',
        array(
            'header' => 'Harga Satuan (Rp)',
            'name' => 'hargasatuan',
            'value' => 'MyFormatter::formatNumberForPrint($data->hargasatuan)',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        array(
            'header' => 'Total Harga (Rp)',
            'name' => 'totalharga',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalharga)',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end no pengeluaran dialog =============
?>

<script type="text/javascript">
    function isiInfoPengeluaran(data) {
        $('#<?php echo CHtml::activeId($modPengeluaran, 'jenispengeluaran_id'); ?>').val(data.jenispengeluaran_id);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'tandabuktikeluar_id'); ?>').val(data.tandabuktikeluar_id);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'kelompoktransaksi'); ?>').val(data.kelompoktransaksi);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'tglpengeluaran'); ?>').val(data.tglpengeluaran);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'volume'); ?>').val(data.volume);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'satuanvol'); ?>').val(data.satuanvol);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'hargasatuan'); ?>').val(data.hargasatuan);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'totalharga'); ?>').val(data.totalharga);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'biayaadministrasi'); ?>').val(data.biayaadministrasi);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'keterangankeluar'); ?>').val(data.keterangankeluar);
        $('#<?php echo CHtml::activeId($modPengeluaran, 'nopengeluaran'); ?>').val(data.value);

        $('#BKBatalKeluarUmumT_tandabuktikeluar_id').val(data.tandabuktikeluar_id);
        $('#BKBatalKeluarUmumT_pengeluaranumum_id').val(data.pengeluaranumum_id);

        $('.integer2').each(function() {
            this.value = formatNumber(this.value)
        });
    }
</script>