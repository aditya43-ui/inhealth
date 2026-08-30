<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'terimaperlinensteril_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->terimaperlinensteril_tgl = !empty($model->terimaperlinensteril_tgl) ? $format->formatDateTimeForUser($model->terimaperlinensteril_tgl) : date('d M Y');
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'terimaperlinensteril_tgl',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //						'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                $model->terimaperlinensteril_tgl = !empty($model->terimaperlinensteril_tgl) ? $format->formatDateTimeForDb($model->terimaperlinensteril_tgl) : date('Y-m-d');
                ?>
                <?php echo $form->error($model, 'terimaperlinensteril_tgl'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'terimaperlinensteril_no', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
        <?php echo $form->textAreaRow($model, 'terimaperlinensteril_ket', array('placeholder' => 'Keterangan', 'rows' => 3, 'cols' => 100, 'class' => 'span4 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegpenerima_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpenerima_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaipenerima_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiPenerima') . '",
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
							$(this).val( ui.item.label);
							return false;
						}',
                        'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($model, 'pegpenerima_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Penerima',
                        'class' => 'pegawaipenerima_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegpenerima_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiPenerima'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegmengetahui_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaimengetahui_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
							$(this).val( ui.item.label);
							return false;
						}',
                        'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Mengetahui',
                        'class' => 'pegawaimengetahui_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari data Pegawai Penerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiPenerima',
    'options' => array(
        'title' => 'Pencarian Pegawai Penerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiPenerima = new STPegawaiV('searchPegawaiPenerima');
$modPegawaiPenerima->unsetAttributes();
if (isset($_GET['STPegawaiV'])) {
    $modPegawaiPenerima->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipenerima-grid',
    'dataProvider' => $modPegawaiPenerima->searchPegawaiPenerima(),
    'filter' => $modPegawaiPenerima,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pegpenerima_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaipenerima_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiPenerima\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiPenerima, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiPenerima, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiPenerima, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiPenerima, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiPenerima, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Penerima dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new STPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['STPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiMengetahui(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pegmengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>