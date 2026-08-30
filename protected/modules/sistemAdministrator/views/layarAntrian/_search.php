<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'salayarantrian-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'layarantrian_jenis', array('placeholder' => 'Jenis Layar Antrian', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'layarantrian_nama', array('placeholder' => 'Nama Layar Antrian', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'layarantrian_judul', array('placeholder' => 'Judul Layar Antrian', 'class' => 'span3', 'maxlength' => 200)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'layarantrian_runningtext', array('placeholder' => 'Running Text', 'rows' => 4, 'cols' => 50, 'class' => 'span4')); ?>
        <?php echo $form->checkBoxRow($model, 'layarantrian_aktif', array('checked' => 'layarantrian_aktif')); ?>
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