<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jenisbarang-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php // echo $form->textFieldRow($model,'jenisbarang_id',array('class'=>'span3 numbers-only')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Barang", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenisbarang_nama', array('placeholder' => 'Jenis Barang', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisbarang_namalain', array('placeholder' => 'Nama Lain Jenis Barang', 'class' => 'span3', 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'barang_statusregister', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenisbarang_aktif', array('checked' => 'jenisbarang_aktif')) ?> <label>Aktif</label>
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