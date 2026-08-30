<?php echo $form->errorSummary($modPenyimpananSterilisasi); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($modPenyimpananSterilisasi, 'penyimpanansteril_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modPenyimpananSterilisasi, 'penyimpanansteril_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPenyimpananSterilisasi->penyimpanansteril_tgl = (!empty($modPenyimpananSterilisasi->penyimpanansteril_tgl) ? date("d/m/Y H:i:s", strtotime($modPenyimpananSterilisasi->penyimpanansteril_tgl)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPenyimpananSterilisasi,
                    'attribute' => 'penyimpanansteril_tgl',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        //                                'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>
        <?php
        echo $form->textFieldRow($modPenyimpananSterilisasi, 'penyimpanansteril_no', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPenyimpananSterilisasi, 'pegmengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPenyimpananSterilisasi, 'pegmengetahui_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPenyimpananSterilisasi,
                    'attribute' => 'pegmengetahui_nama',
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
							$(this).val( ui.item.nama_pegawai);
							return false;
						}',
                        'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($modPenyimpananSterilisasi, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Mengetahui',
                        'class' => 'span3 pegmengetahui_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPenyimpananSterilisasi, 'pegmengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPenyimpananSterilisasi, 'Pegawai Menyetujui', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPenyimpananSterilisasi, 'pegpenyimpanan_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPenyimpananSterilisasi,
                    'attribute' => 'pegpenyimpanan_nama',
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
							$(this).val( ui.item.nama_pegawai);
							return false;
						}',
                        'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($modPenyimpananSterilisasi, 'pegpenyimpanan_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Menyetujui',
                        'class' => 'span3 pegpenyimpanan_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPenyimpananSterilisasi, 'pegpenyimpanan_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modPenyimpananSterilisasi, 'penyimpanansteril_ket', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Dekontaminasi')); ?>
    </div>

</div>

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
        'resizable' => true,
    ),
));

$modPegawaiMengetahui = new STPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['STPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
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
										  $(\"#' . CHtml::activeId($modPenyimpananSterilisasi, 'pegmengetahui_id') . '\").val(\"$data->pegawai_id\");
										  $(\"#' . CHtml::activeId($modPenyimpananSterilisasi, 'pegmengetahui_nama') . '\").val(\"$data->NamaLengkap\");
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

<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pencarian Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));

$modPegawaiMenyetujui = new STPegawaiV('searchDialog');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['STPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchDialog(),
    'filter' => $modPegawaiMenyetujui,
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
										  $(\"#' . CHtml::activeId($modPenyimpananSterilisasi, 'pegpenyimpanan_id') . '\").val(\"$data->pegawai_id\");
										  $(\"#' . CHtml::activeId($modPenyimpananSterilisasi, 'pegpenyimpanan_nama') . '\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
										  return false;
								"))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>