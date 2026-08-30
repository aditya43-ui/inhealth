<?php echo $form->errorSummary($modSterilisasi); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($modSterilisasi, 'sterilisasi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modSterilisasi, 'sterilisasi_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modSterilisasi->sterilisasi_tgl = (!empty($modSterilisasi->sterilisasi_tgl) ? date("d/m/Y H:i:s", strtotime($modSterilisasi->sterilisasi_tgl)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modSterilisasi,
                    'attribute' => 'sterilisasi_tgl',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        //                                'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000 00:00:00', 'class' => 'span3 dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>
        <?php
        echo $form->textFieldRow($modSterilisasi, 'sterilisasi_no', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
        ?>
        <div class="control-group">
            <?php echo Chtml::label('Status Sterilisasi', 'sterilisasi_status', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modSterilisasi, 'sterilisasi_status', LookupM::getItems("status_sterilisasi"), array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Proses', 'sterilisasi_status', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modSterilisasi, 'status_proses', LookupM::getItems("statusproses"), array('class' => 'span3')); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modSterilisasi, 'sterilisasi_ket', array('placeholder' => 'Keterangan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Sterilisasi')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modSterilisasi, 'pegsterilisasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modSterilisasi, 'pegsterilisasi_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modSterilisasi,
                    'attribute' => 'pegsterilisasi_nama',
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
							$("#' . Chtml::activeId($modSterilisasi, 'pegsterilisasi_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Sterilisasi',
                        'class' => 'span3 pegsterilisasi_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modSterilisasi, 'pegsterilisasi_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiSterilisasi'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSterilisasi, 'pegmengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modSterilisasi, 'pegmengetahui_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modSterilisasi,
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
							$(this).val( ui.item.label);
							return false;
						}',
                        'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($modSterilisasi, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Mengetahui',
                        'class' => 'span3 pegmengetahui_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modSterilisasi, 'pegmengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
        <?php
        echo $form->textFieldRow($modSterilisasi, 'sterilisasi_siklus', array('placeholder' => 'Siklus Mesin/Komputer', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20));
        ?>
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
        'height' => 500,
        'resizable' => true,
    ),
));

//$modPegawaiMengetahui = new STPegawaiV('searchDialog');
$modPegawaiMengetahui = new STPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['STPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahuisterilisasi-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiMengetahui(),
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
										  $(\"#' . CHtml::activeId($modSterilisasi, 'pegmengetahui_id') . '\").val(\"$data->pegawai_id\");
										  $(\"#' . CHtml::activeId($modSterilisasi, 'pegmengetahui_nama') . '\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
										  return false;
								"))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        /*array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
			'value'=>'$data->gelardepan',
		),*/
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),/*
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		),*/
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiSterilisasi',
    'options' => array(
        'title' => 'Pencarian Pegawai Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

//$modPegawaiMengetahui = new STPegawaiV('searchDialog');
$modPegawaiMengetahui = new PegawairuanganV();
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaisterilisasi-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
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
										  $(\"#' . CHtml::activeId($modSterilisasi, 'pegsterilisasi_id') . '\").val(\"$data->pegawai_id\");
										  $(\"#' . CHtml::activeId($modSterilisasi, 'pegsterilisasi_nama') . '\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiSterilisasi\").dialog(\"close\"); 
										  return false;
								"))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        /*array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
			'value'=>'$data->gelardepan',
		),*/
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),/*
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		),*/
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>