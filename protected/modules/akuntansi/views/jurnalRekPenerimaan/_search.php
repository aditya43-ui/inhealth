<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jenispenerimaan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenispenerimaan_kode', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenispenerimaan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenispenerimaan_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenispenerimaan_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label("", 'jenispenerimaan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenispenerimaan_aktif', array('checked' => 'jenispenerimaan_aktif')) ?> <label for="AKJenispenerimaanM_jenispenerimaan_aktif">Aktif</label>
                <?php //echo $form->textField($model,'jenispenerimaan_namalain',array('class'=>'span3','maxlength'=>50)); 
                ?>
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