<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpindikatorpenilaianiku-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'nama_jenis')
)); ?>
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Jenis Kantong', 'nama_jenis', array('class' => 'control-label required')) ?>
            <div class="controls"><span style="margin-left:-10px" class="required">*</span>
                <?php echo $form->textField($model, 'nama_jenis', array('placeholder' => 'Nama jenis kantong', 'class' => 'span3', 'maxlength' => 300)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Singkatan', 'nama_jenis_sngkt', array('class' => 'control-label required')) ?>
            <div class="controls"><span style="margin-left:-10px" class="required">*</span>
                <?php echo $form->textField($model, 'nama_jenis_sngkt', array('placeholder' => 'Singkatan', 'class' => 'span3 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'jeniskantongdarah_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jeniskantongdarah_aktif', array('checked' => 'jeniskantongdarah_aktif')); ?>
                <label for="BDJeniskantongdarahM_jeniskantongdarah_aktif">Aktif</label>
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
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Kantong Darah', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>