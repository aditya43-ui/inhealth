<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'indikatorevaluasipenawaran-m-search',
    'type' => 'horizontal',
        ));
?>
<div class="control-group">
    <label class="control-label">Jenis Pengadaan</label>
    <div class="controls">
        <?php echo $form->dropDownList($model, 'jenispengadaan_id', Chtml::listData(JenispengadaanM::model()->findAllByAttributes(array('jenispengadaan_aktif' => true)), 'jenispengadaan_id', 'jenispengadaan_nama'), array('disabled' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --','class'=>'span4')); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Jenis Evaluasi Penawaran</label>
    <div class="controls">
        <?php echo $form->dropDownList($model,'evaluasipenawaran_jenis', Chtml::listData(LookupM::model()->findAll("lookup_type = 'jenisevaluasipenawaran' AND lookup_aktif IS TRUE"),'lookup_name','lookup_name'),array('empty' => '-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4')) ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Nama Evaluasi Penawaran</label>
    <div class="controls">
        <?php echo $form->textField($model, 'evaluasipenawaran_nama', array('class' => 'span3', 'maxlength' => 255)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Urutan</label>
    <div class="controls">
        <?php echo $form->textField($model, 'urutan', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 255)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("", 'indikatorevaluasipenawaran_aktif', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->checkBox($model, 'indikatorevaluasipenawaran_aktif', array('checked' => 'indikatorevaluasipenawaran_aktif')); ?> <label> Aktif</label>
    </div>				
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>
