<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sasmsgateway-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->dropDownListRow(
            $model,
            'modul_id',
            CHtml::listData(ModulK::model()->findAll('modul_aktif = true order by modul_nama'), 'modul_id', 'modul_nama'),
            array('empty' => '-- Pilih --', 'class' => 'span3')
        ); ?>
        <?php echo $form->textFieldRow($model, 'tujuansms', array('placeholder' => 'Tujuan SMS', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jenissms', array('placeholder' => 'Jenis SMS', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'katawalsms', array('placeholder' => 'Kata Awal SMS', 'class' => 'span3', 'maxlength' => 5)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'kataakhirsms', array('placeholder' => 'Kata Akhir SMS', 'class' => 'span3', 'maxlength' => 5)); ?>
        <?php echo $form->textFieldRow($model, 'formatsms', array('placeholder' => 'Format SMS', 'class' => 'span3', 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'jmlkaraktersms', array('placeholder' => 'Jumlah Karakter SMS', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'modcontroller', array('placeholder' => 'Nama Controller', 'class' => 'span3', 'maxlength' => 200)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'modaction', array('placeholder' => 'Nama Action', 'class' => 'span3', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'templatesms', array('placeholder' => 'Template SMS', 'class' => 'span3', 'maxlength' => 250)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'ishurufkapital', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ishurufkapital', array('checked' => 'ishurufkapital', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label for="SASmsgatewayM_ishurufkapital">Huruf Kapital</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'statussms', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'statussms', array('checked' => 'statussms', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label for="SASmsgatewayM_statussms">Status SMS</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>