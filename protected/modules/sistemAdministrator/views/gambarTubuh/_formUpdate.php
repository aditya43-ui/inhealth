<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sagambartubuh-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onsubmit' => 'return requiredCheck(this);', 'onKeyPress' => 'return disableKeyPress(event);', 'enctype' => 'multipart/form-data'),
    'focus' => '#SAGambartubuhM_nama_gambar',
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_gambar', array('placeholder' => 'Nama Gambar', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php // echo $form->textFieldRow($model,'nama_file_gbr',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
        ?>
        <?php // echo $form->textAreaRow($model,'path_gambar',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'gambar_resolusi_x',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'gambar_resolusi_y',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'gambar_create',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->hiddenField($model, 'temp_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
        <?php echo $form->fileFieldRow($model, 'nama_file_gbr', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
        <?php // echo $form->textFieldRow($model,'gambar_update',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div>
            <div class="control-group">
                <?php echo CHtml::label("", 'gambartubuh_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'gambartubuh_aktif', array('checked' => 'gambartubuh_aktif')); ?>
                    <label for="SAGambartubuhM_gambartubuh_aktif">Aktif</label>
                </div>
            </div>
            <?php //echo $form->checkBoxRow($model,'gambartubuh_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("", 'ispemeriksaanfisik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ispemeriksaanfisik', array('onclick' => 'cekCeklis("pemeriksaanfisik")')); ?> <label>Pemeriksaan Fisik</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'isasesmennyeri', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isasesmennyeri', array('onclick' => 'cekCeklis("asesmennyeri")')); ?> <label>Asesmen Nyeri</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'isareabedah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isareabedah', array('onclick' => 'cekCeklis("areabedah")')); ?> <label>Area Bedah</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'isronggamulut', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isronggamulut', array('onclick' => 'cekCeklis("areabedah")')); ?> <label>Rongga Mulut</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'isginekologi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isginekologi', array('onclick' => 'cekCeklis("ginekologi")')); ?> <label>Pemeriksaan Ginekologi</label>
            </div>
        </div>


        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jeniskelamin',  LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("Urutan", 'isareabedah', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'gambartubuh_urutan', array('class' => 'numbers-only')); ?>
            </div>
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
        '',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Gambar Tubuh', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function cekCeklis(st) {
        if (st == 'areabedah') {
            $("#<?php echo CHtml::activeId($model, 'ispemeriksaanfisik') ?>").prop("checked", false);
            $("#<?php echo CHtml::activeId($model, 'isareabedah') ?>").prop("checked", true);
            $("#<?php echo CHtml::activeId($model, 'isasesmennyeri') ?>").prop("checked", false);
        } else if (st == 'asesmennyeri') {
            $("#<?php echo CHtml::activeId($model, 'ispemeriksaanfisik') ?>").prop("checked", false);
            $("#<?php echo CHtml::activeId($model, 'isareabedah') ?>").prop("checked", false);
            $("#<?php echo CHtml::activeId($model, 'isasesmennyeri') ?>").prop("checked", true);
        } else {
            $("#<?php echo CHtml::activeId($model, 'ispemeriksaanfisik') ?>").prop("checked", true);
            $("#<?php echo CHtml::activeId($model, 'isareabedah') ?>").prop("checked", false);
            $("#<?php echo CHtml::activeId($model, 'isasesmennyeri') ?>").prop("checked", false);
        }
    }
</script>