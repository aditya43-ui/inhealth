<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saaksespengguna-k-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Pemakai', 'nama_pemakai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pemakai', array('placeholder' => 'Nama Pemakai', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span3')); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'peranpengguna_id',  CHtml::listData(PeranpenggunaK::model()->findAll(array('order' => 'peranpenggunanama ASC'), 'peranpengguna_aktif = true'), 'peranpengguna_id', 'peranpenggunanama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'modul_id',  CHtml::listData(ModulK::model()->findAll(array('order' => 'modul_nama ASC'), 'modul_aktif = true'), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
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