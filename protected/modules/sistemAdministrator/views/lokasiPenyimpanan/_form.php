<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'salokasipenyimpanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

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
                        'class' => "span3",
                        'placeholder' => 'Instalasi',
                        'onkeypress' => "return $(this).focusNextInputField(event)",

                    ),
                    'tombolDialog' => array('idDialog' => 'dialogInstalasi'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'lokasipenyimpanan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    </div>

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lokasipenyimpanan_nama', array('placeholder' => 'Nama Lokasi Penyimpanan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'lokasipenyimpanan_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'lokasipenyimpanan_aktif') . ' <label for="SALokasipenyimpananM_lokasipenyimpanan_aktif">Aktif</label>'; ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Lokasi Penyimpanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit3a', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog =========================
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
    'id' => 'intalasi-m-grid',
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
								"id" => "selectInstalasi",
								"onClick" => "
								$(\"#' . CHtml::activeId($model, 'instalasi_id') . '\").val(\'$data->instalasi_id\');
								$(\"#' . CHtml::activeId($model, 'instalasi_nama') . '\").val(\'$data->instalasi_nama\');
								
								$(\'#dialogInstalasi\').dialog(\'close\');return false;"))'
        ),
        //'instalasi_id',
        //'instalasi_nama',
        array(
            'name' => 'instalasi_id',
            'value' => '$data->instalasi_nama',
            'filter' => CHtml::dropDownList('SAInstalasiM[instalasi_id]', $modInstalasi->instalasi_id, CHtml::listData(SAInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
        ),
        'instalasi_singkatan',
        'instalasi_lokasi',
        'instalasi_namalainnya',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>