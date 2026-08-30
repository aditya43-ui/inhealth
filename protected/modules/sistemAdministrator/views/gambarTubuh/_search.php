<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sagambartubuh-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_gambar', array('placeholder' => 'Nama Gambar', 'class' => 'span4', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'nama_file_gbr', array('placeholder' => 'File Gambar', 'class' => 'span4', 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($model, 'path_gambar', array('placeholder' => 'Path Gambar', 'rows' => 3, 'cols' => 50, 'class' => 'span4')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'gambar_resolusi_x', array('placeholder' => 'Gambar Resolusi X', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'gambar_resolusi_y', array('placeholder' => 'Gambar Resolusi Y', 'class' => 'span3')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'gambartubuh_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'gambartubuh_aktif', array('checked' => 'gambartubuh_aktif')); ?>
                <label for="SAGambartubuhM_gambartubuh_aktif">Aktif</label>
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