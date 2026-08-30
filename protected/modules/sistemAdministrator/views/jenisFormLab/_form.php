<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenisformlab-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisform_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nama')); ?>
        <?php echo $form->textFieldRow($model, 'jenisform_namalainnya', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Nama Lainnya')); ?>
        
        <div class="control-group">
            <?php echo CHtml::label("", 'jenisform_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenisform_aktif', array('id' => 'aktif')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Kelompok <span style="color:red">*</span>', 'jenisform_kelompok', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisform_kelompok', LookupM::getItems(Params::LOOKUPTYPE_JENISPEMERIKSAANLAB_KELOMPOK), array('empty' => '-- Pilih --', 'class' => 'required span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Pemeriksaan Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Form', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreate', array(), true);
    $this->widget('UserTips', array('content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>