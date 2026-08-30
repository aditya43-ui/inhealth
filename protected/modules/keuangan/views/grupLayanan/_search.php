<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gfgenerik-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'grouplayanan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'grouplayanan_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'grouplayanan_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Pengelompokkan", '', array('class' => 'control-label')) ?>
            <div class="controls" id="radio-sesuai">
                <?php echo $form->dropDownList($model, 'is_oa', array(
                    'is_oa' => 'Jenis Obat dan Alkes',
                    'is_tindakan' => 'Tindakan'
                ), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'grouplayanan_aktif', array('checked' => 'grouplayanan_aktif', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?><label for="KUGrouplayananM_grouplayanan_aktif">Aktif</label>
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