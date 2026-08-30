<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'sapenjamin-pasien-m-search',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'carabayar_nama', array('class' => 'control-label')); ?> &nbsp;&nbsp;
        <?php //echo $form->textFieldRow($model,'carabayar_nama',array('class'=>'span3','maxlength'=>30)); 
        ?>
        <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::ListData(CarabayarM::model()->findAll(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'penjamin_nama', array('placeholder' => 'Nama Penjamin', 'class' => 'span3', 'maxlength' => 30)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'penjamin_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'penjamin_aktif', array('checked' => 'checked')); ?>
                <label for="SAPenjaminPasienM_penjamin_aktif">Aktif</label>
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