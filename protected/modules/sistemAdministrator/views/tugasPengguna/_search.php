<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'satugaspengguna-k-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'peranpengguna_id',  CHtml::listData(PeranpenggunaK::model()->findAll(array('order' => 'peranpenggunanama ASC'), 'peranpengguna_aktif = true'), 'peranpengguna_id', 'peranpenggunanama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
        <?php echo $form->dropDownListRow($model, 'modul_id',  CHtml::listData(ModulK::model()->findAll(array('order' => 'modul_nama ASC'), 'modul_aktif = true'), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>

        <?php echo $form->textFieldRow($model, 'tugas_nama', array('placeholder' => 'Nama Tugas', 'class' => 'span3', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'tugas_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 200)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", "tugaspengguna_aktif", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'tugaspengguna_aktif', array('checked' => 'tugaspengguna_aktif')); ?>
                <label for="SATugaspenggunaK_tugaspengguna_aktif">Aktif</label>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'controller_nama', array('placeholder' => 'Nama Controller', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'action_nama', array('placeholder' => 'Nama Action', 'class' => 'span3', 'maxlength' => 100)); ?>

        <?php echo $form->textAreaRow($model, 'keterangan_tugas', array('placeholder' => 'Keterangan Tugas', 'rows' => 5, 'class' => 'span3')); ?>
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