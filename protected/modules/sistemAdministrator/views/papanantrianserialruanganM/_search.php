<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'papanantrianserialruangan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'ruangan_id',
            CHtml::listData(SARuanganM::model()->findAll(array(
                'join' => 'join instalasi_m i on i.instalasi_id = t.instalasi_id',
                'order' => 'i.instalasi_nama, t.ruangan_nama',
                'condition' => 't.ruangan_aktif = true and i.revenuecenter = true'
            )), 'ruangan_id', 'ruanganInstalasi'),
            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
        ); ?>
        <?php echo $form->textFieldRow($model, 'ip_address', array('placeholder' => 'IP Address', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'ip_port', array('placeholder' => 'IP Port', 'class' => 'span3', 'maxlength' => 10)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'serial_port', array('placeholder' => 'Serial Port', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'serial_id', array('placeholder' => 'Serial', 'class' => 'span3', 'maxlength' => 100)); ?>
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