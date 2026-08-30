<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sarakpenyimpanan-m-form',
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
            <?php echo $form->labelEx($model, 'Lokasi Penyimpanan <span class="required">*</span>', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'lokasipenyimpanan_id'); ?>
                <?php
                $model->lokasipenyimpanan_nama = !empty($model->lokasipenyimpanan) ? $model->lokasipenyimpanan->lokasipenyimpanan_nama : "";
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'lokasipenyimpanan_nama',
                    'source' => 'js: function(request, response) {
														}',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
													}',
                        'select' => 'js:function( event, ui ) { 
													}',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3',
                        'placeholder' => 'Lokasi Penyimpanan',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLokasipenyimpanan'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_label', array('placeholder' => 'Label', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'rakpenyimpanan_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'rakpenyimpanan_aktif') . ' <label for="SARakpenyimpananM_rakpenyimpanan_aktif">Aktif</label>'; ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
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
        Yii::t('mds', '{icon} Pengaturan Rak Penyimpanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
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
    'id' => 'dialogLokasipenyimpanan',
    'options' => array(
        'title' => 'Daftar Lokasi Penyimpanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => true,
    ),
));

$modLokasipenyimpanan = new SALokasipenyimpananM('search');
$modLokasipenyimpanan->unsetAttributes();
if (isset($_GET['SALokasipenyimpananM'])) {
    $modLokasipenyimpanan->attributes = $_GET['SALokasipenyimpananM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'lokasipenyimpanan-m-grid',
    'dataProvider' => $modLokasipenyimpanan->searchDialog(),
    'filter' => $modLokasipenyimpanan,
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
								"id" => "selectLokasipenyimpanan",
								"onClick" => "
								$(\"#' . CHtml::activeId($model, 'lokasipenyimpanan_id') . '\").val(\'$data->lokasipenyimpanan_id\');
								$(\"#' . CHtml::activeId($model, 'lokasipenyimpanan_nama') . '\").val(\'$data->lokasipenyimpanan_nama\');
								
								$(\'#dialogLokasipenyimpanan\').dialog(\'close\');return false;"))'
        ),
        'lokasipenyimpanan_id',
        array(
            'name' => 'instalasi_id',
            'value' => '$data->instalasi->instalasi_nama',
            'filter' => CHtml::dropDownList('SALokasipenyimpananM[instalasi_id]', $modLokasipenyimpanan->instalasi_id, CHtml::listData($modLokasipenyimpanan->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
        ),
        'lokasipenyimpanan_kode',
        'lokasipenyimpanan_nama',
        'lokasipenyimpanan_namalain',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>