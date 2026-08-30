<?php echo $form->errorSummary($modPencucianLinen); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($modPencucianLinen, 'pencucianlinen_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modPencucianLinen, 'tglpencucianlinen', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPencucianLinen->tglpencucianlinen = (!empty($modPencucianLinen->tglpencucianlinen) ? date("d/m/Y H:i:s", strtotime($modPencucianLinen->tglpencucianlinen)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPencucianLinen,
                    'attribute' => 'tglpencucianlinen',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
//                                'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array('placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <?php
        echo $form->textFieldRow($modPencucianLinen, 'nopencucianlinen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
        
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($modPencucianLinen, 'keterangan_pencucianlinen', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Perawatan')); ?>
        <div class="control-group">
                <?php echo $form->labelEx($modPencucianLinen, 'pegpenerima_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPencucianLinen, 'pegpenerima_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPencucianLinen,
                    'attribute' => 'pegpenerima_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
							$("#' . Chtml::activeId($modPencucianLinen, 'pegpenerima_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => Params::setLabelKepegawaianKonfig().' Mengetahui',
                        'class' => 'pegpenerima_nama span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPencucianLinen, 'pegpenerima_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian '.Params::setLabelKepegawaianKonfig().' Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));

$modPegawaiMengetahui = new LAPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['LAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchDialog(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#' . CHtml::activeId($modPencucianLinen, 'pegpenerima_id') . '\").val(\"$data->pegawai_id\");
										  $(\"#' . CHtml::activeId($modPencucianLinen, 'pegpenerima_nama') . '\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
										  return false;
								"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama '.Params::setLabelKepegawaianKonfig(),
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat '.Params::setLabelKepegawaianKonfig(),
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>