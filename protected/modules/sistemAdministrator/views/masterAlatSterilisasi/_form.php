<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saalatsterilisasi-m-form',
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
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                        'placeholder' => 'Instalasi',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogInstalasi'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jenis Alat Sterilisasi <span class="required">*</span>', array('class' => 'control-label required')); ?>
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
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                        'placeholder' => 'Jenis Alat Sterilisasi',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisalatmedis'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'alatmedis_noaset', array('placeholder' => 'No. Aset', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'alatmedis_nama', array('placeholder' => 'Nama Alat Sterilisasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_namalain', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'alatmedis_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'alatmedis_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'alatmedis_aktif'); ?> <label for="SAAlatsterilisasiM_alatmedis_aktif">Aktif</label>
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
        Yii::t('mds', '{icon} Pengaturan Alat Sterilisasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit', array(), true);
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
        'height' => 480,
        'resizable' => true,
    ),
));

$modJenis = new SAJenisalatsterilisasiM('search');
$modJenis->unsetAttributes();
if (isset($_GET['SAJenisalatsterilisasiM'])) {
    $modJenis->attributes = $_GET['SAJenisalatsterilisasiM'];
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
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
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
        'height' => 480,
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
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
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