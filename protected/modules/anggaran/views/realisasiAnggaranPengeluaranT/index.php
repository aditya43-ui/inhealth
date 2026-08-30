<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="white-container">
    <legend class="rim2">Transaksi Realisasi <b>Anggaran Pengeluaran</b></legend>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'realisasianggpeng-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event); ', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#' . CHtml::activeId($modTandaBuktiKeluar, 'tglkaskeluar'),
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data realisasi anggaran pengeluaran berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <fieldset id="form-rencanapengeluaran" class="box">
        <legend class="rim">Data Anggaran Pengeluaran</legend>
        <div class="row">
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php echo CHtml::label('Tgl. Kas Keluar <span class="required">*</span>', 'tglkaskeluar', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $modTandaBuktiKeluar->tglkaskeluar = $format->formatDateTimeForUser($modTandaBuktiKeluar->tglkaskeluar); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modTandaBuktiKeluar,
                            'attribute' => 'tglkaskeluar',
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
                <?php echo $form->textFieldRow($model, 'no_realisasi_peng', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Unit Kerja <span class="required">*</span>', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'unitkerja_id', CHtml::listData(AGUnitkerjaM::model()->findAllByAttributes(array('unitkerja_aktif' => true), array('order' => 'namaunitkerja')), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php // echo $form->textField($model,'unitkerja_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Periode Anggaran <span class="required">*</span>', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(AGRealisasianggpengT::model()->getTglPeriodeRealisasi(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php // echo CHtml::textField('konfiganggaran_id','',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true))
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset id="form-rencanapengeluarandetail" class="box">
        <legend class="rim">Data Realisasi Anggaran Pengeluaran</legend>
        <div class="row" id="program-kerja">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Program Kerja', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'alokasianggaran_id'); ?>
                        <?php echo $form->hiddenField($model, 'subkegiatanprogram_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'subkegiatanprogram_nama',
                            'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompleteProgramKerja') . '",
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
                                'minLength' => 1,
                                'focus' => 'js:function( event, ui ) {
								$(this).val( ui.item.label);
								return false;
							}',
                                'select' => 'js:function( event, ui ) {
									$("#AGRealisasianggpengT_sumberanggarannama").val(ui.item.programkerja_nama); 
									$("#' . CHtml::activeId($model, 'subkegiatanprogram_id') . '").val(ui.item.subkegiatanprogram_id);
									$("#' . CHtml::activeId($model, 'subkegiatanprogram_nama') . '").val(ui.item.subkegiatanprogram_nama);
									$("#' . CHtml::activeId($model, 'sumberanggaran_id') . '").val(ui.item.sumberanggaran_id);
									$("#' . CHtml::activeId($model, 'sumberanggarannama') . '").val(ui.item.sumberanggarannama);
									$("#' . CHtml::activeId($model, 'nilaialokasi_pengeluaran') . '").val(ui.item.nilaiygdialokasikan);
									$("#' . CHtml::activeId($model, 'bulanDb') . '").val(ui.item.tglapprrencanggaran);
									formatNumberSemua();
									formatDateMonth();
									return false;
							}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'programkerja',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'subkegiatanprogram_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogProgramKerja'),
                        ));
                        ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label('Sumber Anggaran', 'sumberanggarannama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'sumberanggarannama', array('readonly' => true, 'class' => 'span3')); ?>
                        <?php echo $form->hiddenField($model, 'sumberanggaran_id', array('readonly' => true, 'class' => 'span2')); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label('Bulan', 'bulanDb', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'bulanUser', array('readonly' => true, 'class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bulanDb', array('readonly' => true, 'class' => 'span2')); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label('Tgl. Pelaksanaan <span class="required">*</span>', 'tglrealisasianggaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $model->tglrealisasianggaran = $format->formatDateTimeForUser($model->tglrealisasianggaran); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglrealisasianggaran',
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
            </div>
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php echo CHtml::label('Nilai Alokasi', 'nilaialokasi_pengeluaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nilaialokasi_pengeluaran', array('readonly' => true, 'class' => 'span3 integer2')); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label('Nilai Realisasi', 'nilairealisasi_pengeluaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nilairealisasi_pengeluaran', array('class' => 'span3 integer2', 'onkeyup' => 'hitungPersentase();')); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label('Persentase (%)', 'persentase_realisasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'persentase_realisasi', array('readonly' => true, 'class' => 'span3', 'style' => 'text-align: right;')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modTandaBuktiKeluar, 'namapenerima', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modTandaBuktiKeluar,
                            'attribute' => 'namapenerima',
                            'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompleteNamaPenerima') . '",
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
								return false;
							}',
                            ),
                            'htmlOptions' => array(
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogNamaPenerima'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset id="form-rencanapengeluarandetail" class="box">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'realisasimengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'realisasimengetahui_id', array('readonly' => true)); ?>
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
									$("#' . Chtml::activeId($model, 'realisasimengetahui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimengetahui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'realisasimengetahui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'realisasimenyetujui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'realisasimenyetujui_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegawaimenyetujui_nama',
                            'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
								$("#' . Chtml::activeId($model, 'realisasimenyetujui_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimenyetujui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'realisasimenyetujui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => !$model->isNewRecord)); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array('class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
        ); ?>
        <?php
        echo (!isset($_GET['realisasianggpeng_id']) ?
            CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)) . "&nbsp&nbsp" :
            CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'print(\'REALISASI\')')) . "&nbsp&nbsp");
        echo (!isset($_GET['realisasianggpeng_id']) ?
            CHtml::htmlButton(Yii::t('mds', '{icon} Print Tanda Bukti Keluar', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)) . "&nbsp&nbsp" :
            CHtml::htmlButton(Yii::t('mds', '{icon} Print Tanda Bukti Keluar', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'print(\'TANDABUKTIKELUAR\')')) . "&nbsp&nbsp");
        $urlPrint = $this->createUrl('printRealisasi', array('realisasianggpeng_id' => isset($_GET['realisasianggpeng_id']) ? $_GET['realisasianggpeng_id'] : null));
        $js = <<< JSCRIPT
function print(jenisPrint)
{
    window.open("${urlPrint}"+"&jenisPrint="+jenisPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php $content = $this->renderPartial('../tips/transaksiRealisasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new AGPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['AGPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['AGPegawaiV'];
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
                                                  $(\"#' . CHtml::activeId($model, 'realisasimengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
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
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMenyetujui = new AGPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['AGPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['AGPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchPegawaiMenyetujui(),
    'filter' => $modPegawaiMenyetujui,
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
                                                  $(\"#' . CHtml::activeId($model, 'realisasimenyetujui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimenyetujui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
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
//========= end Pegawai Menyetujui dialog =============================
?>

<?php
//========= Dialog buat cari data Penerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogNamaPenerima',
    'options' => array(
        'title' => 'Pencarian Pegawai Penerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMenyetujui = new AGPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['AGPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['AGPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchPegawaiMenyetujui(),
    'filter' => $modPegawaiMenyetujui,
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
                                                  $(\"#' . CHtml::activeId($modTandaBuktiKeluar, 'namapenerima') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogNamaPenerima\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
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
//========= end Penerima dialog =============================
?>
<?php
//========= Dialog buat cari data Program Kerja =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogProgramKerja',
    'options' => array(
        'title' => 'Data Program Kerja',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modProgramKerja = new AGInformasialokasianggaranV('searchProgramKerja');
$modProgramKerja->unsetAttributes();
if (isset($_GET['AGInformasialokasianggaranV'])) {
    $modProgramKerja->attributes = $_GET['AGInformasialokasianggaranV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'programkerja-grid',
    'dataProvider' => $modProgramKerja->searchProgramKerjaRealisasi(),
    'filter' => $modProgramKerja,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No. ',
            'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center; width:5px;'),
        ),
        array(
            'header' => 'Program Kerja',
            'type' => 'raw',
            'value' => '$this->grid->owner->renderPartial("_detail",array(
					"programkerja_kode"=>$data->programkerja_kode,
					"programkerja_nama"=>$data->programkerja_nama,
					"subprogramkerja_kode"=>$data->subprogramkerja_kode,
					"subprogramkerja_nama"=>$data->subprogramkerja_nama,
					"kegiatanprogram_kode"=>$data->kegiatanprogram_kode,
					"kegiatanprogram_nama"=>$data->kegiatanprogram_nama,
					"subkegiatanprogram_kode"=>$data->subkegiatanprogram_kode,
					"subkegiatanprogram_nama"=>$data->subkegiatanprogram_nama),true)',
        ),
        array(
            'header' => 'Bulan',
            'value' => 'MyFormatter::formatMonthForUser($data->tglapprrencanggaran)',
        ),
        array(
            'header' => 'Nilai Alokasi',
            'value' => 'MyFormatter::formatNumberForPrint($data->nilaiygdialokasikan)',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Sumber Anggaran',
            'value' => '$data->sumberanggarannama',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectProgramKerja",
                                    "onClick" => "
													$(\"#' . CHtml::activeId($model, 'alokasianggaran_id') . '\").val(\"$data->alokasianggaran_id\");
													$(\"#' . CHtml::activeId($model, 'subkegiatanprogram_id') . '\").val(\"$data->subkegiatanprogram_id\");
													$(\"#' . CHtml::activeId($model, 'subkegiatanprogram_nama') . '\").val(\"$data->subkegiatanprogram_nama\");
													$(\"#' . CHtml::activeId($model, 'sumberanggaran_id') . '\").val(\"$data->sumberanggaran_id\");
													$(\"#' . CHtml::activeId($model, 'sumberanggarannama') . '\").val(\"$data->sumberanggarannama\");
													$(\"#' . CHtml::activeId($model, 'nilaialokasi_pengeluaran') . '\").val(\" $data->nilaiygdialokasikan\");
													$(\"#' . CHtml::activeId($model, 'bulanDb') . '\").val(\"$data->tglapprrencanggaran\");
													formatNumberSemua();
													formatDateMonth();
													$(\"#dialogProgramKerja\").dialog(\"close\"); 
													return false;
                                        "))',
            'htmlOptions' => array('style' => 'text-align:center; width:10px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Program Kerja dialog =============================
?>
<script>
    function formatDateMonth() {
        var bulanDb = $("#<?php echo CHtml::activeId($model, "bulanDb"); ?>").val();
        $("#program-kerja").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('FormatBulan'); ?>',
            data: {
                bulanDb: bulanDb
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "bulanUser"); ?>").val(data.bulanUser);
                $("#program-kerja").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hitungPersentase() {
        unformatNumberSemua();
        var total_persentase = 0;
        var nilaialokasi_pengeluaran = parseFloat($("#<?php echo CHtml::activeId($model, "nilaialokasi_pengeluaran"); ?>").val());
        var nilairealisasi_pengeluaran = parseFloat($("#<?php echo CHtml::activeId($model, "nilairealisasi_pengeluaran"); ?>").val());
        total_persentase = (nilairealisasi_pengeluaran / nilaialokasi_pengeluaran) * 100;

        // bisa diadjust berapa angka dibelakang koma (x) via -> toFixed(x)
        $("#<?php echo CHtml::activeId($model, "persentase_realisasi"); ?>").val(total_persentase.toFixed(2).replace(".", ","));
        formatNumberSemua();
    }
</script>