<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sabagiantubuh-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'namabagtubuh', array('placeholder' => 'Nama Bagian Tubuh', 'class' => 'span3', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'bagtubuh_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 200)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kordinat_x', array('placeholder' => 'Koordinat X', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'kordinat_y', array('placeholder' => 'Koordinat Y', 'class' => 'span3')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'bagiantubuh_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'bagiantubuh_aktif', array('checked' => 'bagiantubuh_aktif')); ?>
                <label for="SABagiantubuhM_bagiantubuh_aktif">Aktif</label>
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