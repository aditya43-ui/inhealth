<fieldset id="form-realisasipenerimaan" class="box">
    <legend class="rim">Data Penerimaan</legend>
    <div class="row">
        <div class="col-sm-4">
            <div class='control-group'>
                <?php echo CHtml::label('Tgl. Bukti Bayar <span class="required">*</span>', 'tglbuktibayar', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $modTandaBuktiBayar->tglbuktibayar = $format->formatDateTimeForUser($modTandaBuktiBayar->tglbuktibayar); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modTandaBuktiBayar,
                        'attribute' => 'tglbuktibayar',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'class' => "span2 required",
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPenerimaan, 'noren_penerimaan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPenerimaan,
                        'attribute' => 'noren_penerimaan',
                        'source' => 'js: function(request, response) {
                                                                           $.ajax({
                                                                                   url: "' . $this->createUrl('AutocompletePenerimaan') . '",
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
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.label);
                                                        return false;
                                                }',
                            'select' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.label);
                                                        console.log(ui.item);
                                                        loadPenerimaan(ui.item.data); 
                                                        return false;
                                                }',
                        ),
                        'htmlOptions' => array(
                            'class' => 'penerimaan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPenerimaan, 'renanggpenerimaan_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPenerimaan'),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->hiddenField($modPenerimaan, 'renanggpenerimaan_id'); ?>
        </div>
        <div class="span8">
            <div class="control-group">
                <?php echo $form->labelEx($modPenerimaan, 'Periode Anggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPenerimaan, 'deskripsiperiode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modPenerimaan, 'konfiganggaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modPenerimaan, 'Sumber Anggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPenerimaan, 'sumberanggarannama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modPenerimaan, 'sumberanggaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
            </div>
            <?php echo $form->hiddenField($modPenerimaan, 'digitnilai', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)) ?>
        </div>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Rencana Anggaran =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenerimaan',
    'options' => array(
        'title' => 'Pencarian Anggaran Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPenerimaan = new AGRenanggpenerimaanT;
if (isset($_GET['AGRenanggpenerimaanT'])) {
    $modPenerimaan->attributes = $_GET['AGRenanggpenerimaanT'];
    $modPenerimaan->noren_penerimaan  = isset($_GET['AGRenanggpenerimaanT']['noren_penerimaan']) ? $_REQUEST['AGRenanggpenerimaanT']['noren_penerimaan'] : null;
    $modPenerimaan->sumberanggaran_id = isset($_GET['AGRenanggpenerimaanT']['sumberanggaran_id']) ? $_REQUEST['AGRenanggpenerimaanT']['sumberanggaran_id'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penerimaan-grid',
    'dataProvider' => $modPenerimaan->searchInformasiAnggPenBelumRelasasi(),
    'filter' => $modPenerimaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectPenerimaan",
                                    "onClick" => "
                                                loadPenerimaan(".$data->json.");
                                                $(\"#dialogPenerimaan\").dialog(\"close\"); 
                                                return false;
                                        "))',
        ),
        array(
            'name' => 'noren_penerimaan',
            'header' => 'Nomor Penerimaan',
            'type' => 'raw',
            'value' => '$data->noren_penerimaan',
        ),
        array(
            'header' => 'Tahun Periode',
            'type' => 'raw',
            'name' => 'konfiganggaran_id',
            'value' => '$data->konfiganggaran->deskripsiperiode',
            'filter' => CHtml::activeDropDownList($modPenerimaan, 'konfiganggaran_id', CHtml::listData(AGKonfiganggaranK::model()->findAllByAttributes(array('isclosing_anggaran' => false), array('order' => 'deskripsiperiode')), 'konfiganggaran_id', 'deskripsiperiode'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'periodeAnggaran();')),
        ),
        array(
            'header' => 'Sumber Anggaran',
            'type' => 'raw',
            'name' => 'sumberanggaran_id',
            'value' => '$data->sumberanggaran->sumberanggarannama',
            'filter' => CHtml::activeDropDownList($modPenerimaan, 'sumberanggaran_id', CHtml::listData(AGSumberanggaranM::model()->findAllByAttributes(array(), array('order' => 'sumberanggarannama')), 'sumberanggaran_id', 'sumberanggarannama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")),
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'type' => 'raw',
            'value' => '(isset($data->renpen_mengetahui_id)? $data->mengetahui->nama_pegawai : "-").
                        "<br>".MyFormatter::formatDateTimeForUser($data->renpen_tglmengetahui)',
        ),
        array(
            'header' => 'Pegawai Menyetujui',
            'type' => 'raw',
            'value' => '(isset($data->renpen_menyetujui_id)? $data->menyetujui->nama_pegawai : "-").
                        "<br>".MyFormatter::formatDateTimeForUser($data->renpen_tglmenyetujui)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>