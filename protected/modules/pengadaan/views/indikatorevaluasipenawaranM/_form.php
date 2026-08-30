<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'indikatorevaluasipenawaran-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class="control-group">
        <?php echo CHtml::label("Jenis Pengadaan <span class='required'>*</span>",'jenispengadaan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'jenispengadaan_id', Chtml::listData(JenispengadaanM::model()->findAllByAttributes(array('jenispengadaan_aktif' => true)), 'jenispengadaan_id', 'jenispengadaan_nama'), array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'class'=>'span4 required'));?>
        </div>				
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Evaluasi <span class='required'>*</span>",'evaluasipenawaran_jenis', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'evaluasipenawaran_jenis', Chtml::listData(LookupM::model()->findAll("lookup_type = 'jenisevaluasipenawaran' AND lookup_aktif IS TRUE"),'lookup_name','lookup_name'),array('empty' => '-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4 required')) ?>
        </div>				
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Evaluasi <span class='required'>*</span>",'evaluasipenawaran_nama', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'evaluasipenawaran_nama', array('class' => 'span4 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 255)); ?>
        </div>				
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Urutan",'urutan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'urutan', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 255)); ?>
        </div>				
    </div>
    <div class="control-group">
        <?php echo CHtml::label("",'indikatorevaluasipenawaran_aktif', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
                if ($model->indikatorevaluasipenawaran_aktif == true) {
            ?>
            <?php echo $form->checkBox($model, 'indikatorevaluasipenawaran_aktif', array('value' => 1, 'uncheckValue' => 0, 'checked' => 'indikatorevaluasipenawaran_aktif')); ?> <label>Aktif</label>
            <?php
            }else{
            ?>
            <?php echo $form->checkBox($model, 'indikatorevaluasipenawaran_aktif', array('value' => 1, 'uncheckValue' => 0)); ?> <label>Aktif</label>
            <?php
            }
            ?>
        </div>				
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Indikator Evaluasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
