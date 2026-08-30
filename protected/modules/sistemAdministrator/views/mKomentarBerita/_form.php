<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'samberitakomentar-t-form',
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
        <?php // echo $form->textFieldRow($model,'mberita_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("Cari " . $model->getAttributeLabel('mberita_id'), 'mberita_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'cari_berita',
                    'value' => $model->mberita_id,
                    'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompleteBerita') . '",
                                                           dataType: "json",
                                                           data: {
                                                               berita: request.term,
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
                    'options' => array(
                        'minLength' => 4,
                        'focus' => 'js:function( event, ui ) {
                                                     $(this).val( "");
                                                     return false;
                                                 }',
                        'select' => 'js:function( event, ui ) {
                                                    $(this).val(ui.item.value);
                                                    $(' . CHtml::activeId($model, 'mberita_id') . ').val(ui.item.id);
                                                    return false;
                                                }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBerita'),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Berita', 'rel' => 'tooltip', 'title' => 'Ketik nama berita untuk mencari berita',
                        'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'mberita_id'); ?>
                <?php echo $form->hiddenField($model, 'mberita_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model,'tglkomentar',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglkomentar', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglkomentar = (!empty($model->tglkomentar) ? date("d/m/Y", strtotime($model->tglkomentar)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglkomentar',
                    'mode' => 'date',
                    'options' => array(
                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'tglkomentar'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'namakomentar', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'emailkomentar', array('class' => 'span3 email', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php //echo $form->textAreaRow($model,'isikomentar',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'isikomentar', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'isikomentar', 'toolbar' => 'mini', 'height' => '100px', 'htmlOptions' => array('class' => 'span3',))) ?>
                <?php echo $form->error($model, 'isikomentar'); ?>
            </div>
        </div>
        <div>
            <?php echo $form->checkBoxRow($model, 'tampilkankomentar', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Berita Komentar', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('tips/create', array(), true);
    $this->widget('UserTips', array('type' => 'create', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBerita',
    'options' => array(
        'title' => 'Pencarian Data Berita',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));
$modBerita = new SAMberitaM('search');
$modBerita->unsetAttributes();
if (isset($_GET['SAMberitaM'])) {
    $modBerita->attributes = $_GET['SAMberitaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modBerita->search(),
    'filter' => $modBerita,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectBerita",
                                        "onClick" => "
                                        $(\"#' . CHtml::activeId($model, 'mberita_id') . '\").val(\"$data->mberita_id\");
                                        $(\"#cari_berita\").val(\"$data->judulberita\");
                                            $(\"#dialogBerita\").dialog(\"close\");
                                        "))',
        ),
        'judulberita',
        'mkategoriberita.kategoriberita',
        'ringkasanberita',
        'waktutampilberita',
        'waktuselesaitampil',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>