<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saalatmedis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Instalasi <span class="required">*</span>', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'instalasi_id'); ?>
                <?php
                $model->instalasi_nama = !empty($model->instalasi_id) ? $model->instalasi->instalasi_nama : "";
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'instalasi_nama',
                    'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteInstalasi') . '",
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
														$(this).val( ui.item.label);
														return false;
													}',
                        'select' => 'js:function( event, ui ) { 
														$("#' . CHtml::activeId($model, 'instalasi_id') . '").val(ui.item.instalasi_id);
														$("#instalasi_nama").val(ui.item.instalasi_nama);
														return false;
													}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Instalasi', 
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'hurufs-only span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogInstalasi'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jenis Alat Medis <span class="required">*</span>', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'jenisalatmedis_id'); ?>
                <?php
                $model->jenisalatmedis_nama = !empty($model->jenisalatmedis_id) ? $model->jenisalatmedis->jenisalatmedis_nama : "";
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'jenisalatmedis_nama',
                    'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteJenisalatmedis') . '",
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
														$(this).val( ui.item.label);
														return false;
													}',
                        'select' => 'js:function( event, ui ) { 
														$("#' . CHtml::activeId($model, 'jenisalatmedis_id') . '").val(ui.item.jenisalatmedis_id);
														$("#jenisalatmedis_nama").val(ui.item.jenisalatmedis_nama);
														return false;
													}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Jenis Alat Medis', 
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'hurufs-only span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisalatmedis'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'alatmedis_noaset', array('placeholder' => 'No. Aset', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_nama', array('placeholder' => 'Nama Alat Medis', 'class' => 'span3 kode-alatmedis', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_merk', array('placeholder' => 'Merk', 'class' => 'span3 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'alatmedis_kode', array('placeholder' => 'Kode', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2, 'style' => 'text-align:right;')); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_format', array('placeholder' => 'Format', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'style' => 'text-align:right;')); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_harga', array('placeholder' => 'Harga', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'style' => 'text-align:right;')); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_hppperhari', array('placeholder' => 'HPP/Hari', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'style' => 'text-align:right;')); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'alatmedis_trgtbep', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'alatmedis_trgtbep', array('placeholder' => '00', 'class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2, 'style' => 'text-align:right;')); ?>
                <?php echo $form->dropDownList($model, 'alatmedis_trgtbep_sat', Params::satuanWaktu(), array('class' => 'span2 numbers-only', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'alatmedis_tglkalibrasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'alatmedis_tglkalibrasi',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'onchange' => 'resetTgl(this);', 'readonly' => true, 'class' => 'span3 dtPicker3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'alatmedis_aktif', array()) ?>
                <label for="SAAlatmedisM_alatmedis_aktif">Aktif</label>
            </div>
        </div>
    </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Alat Medis', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $tips = array(
        '0' => 'autocomplete-search',
        '1' => 'simpan',
        '2' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data jenisalatmedis =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisalatmedis',
    'options' => array(
        'title' => 'Daftar Jenis Alat Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 580,
        'resizable' => true,
    ),
));

$modJenis = new SAJenisalatmedisM('search');
$modJenis->unsetAttributes();
if (isset($_GET['SAJenisalatmedisM'])) {
    $modJenis->attributes = $_GET['SAJenisalatmedisM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenisalatmedis-m-grid',
    'dataProvider' => $modJenis->searchDialog(),
    'filter' => $modJenis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectAlatmedis",
								"onClick" => "
								$(\"#' . CHtml::activeId($model, 'jenisalatmedis_id') . '\").val(\'$data->jenisalatmedis_id\');
								$(\"#' . CHtml::activeId($model, 'jenisalatmedis_nama') . '\").val(\'$data->jenisalatmedis_nama\');
								
								$(\'#dialogJenisalatmedis\').dialog(\'close\');return false;"))'
        ),
        'jenisalatmedis_id',
        'jenisalatmedis_nama',
        'jenisalatmedis_namalain',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Instalasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogInstalasi',
    'options' => array(
        'title' => 'Daftar Instalasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 580,
        'resizable' => true,
    ),
));

$modInstalasi = new SAInstalasiM('search');
$modInstalasi->unsetAttributes();
if (isset($_GET['SAInstalasiM'])) {
    $modInstalasi->attributes = $_GET['SAInstalasiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'instalasi-m-grid',
    'dataProvider' => $modInstalasi->searchDialog(),
    'filter' => $modInstalasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectAlatmedis",
								"onClick" => "
								$(\"#' . CHtml::activeId($model, 'instalasi_id') . '\").val(\'$data->instalasi_id\');
								$(\"#' . CHtml::activeId($model, 'instalasi_nama') . '\").val(\'$data->instalasi_nama\');
								
								$(\'#dialogInstalasi\').dialog(\'close\');return false;"))'
        ),
        'instalasi_id',
        'instalasi_nama',
        'instalasi_namalainnya',
        'instalasi_lokasi',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>