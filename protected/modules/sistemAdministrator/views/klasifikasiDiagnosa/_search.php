<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saklasifikasidiagnosa-m-search',
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'klasifikasidiagnosa_id',array('class'=>'span3')); 
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'klasifikasidiagnosa_kode', array('placeholder' => 'Kode Klasifikasi', 'class' => 'span3', 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'klasifikasidiagnosa_nama', array('placeholder' => 'Nama Klasifikasi', 'class' => 'span3', 'maxlength' => 500)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'klasifikasidiagnosa_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'klasifikasidiagnosa_desc', array('placeholder' => 'Deskripsi Klasifikasi', 'class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <?php //echo $form->checkBoxRow($model,'klasifikasidiagnosa_aktif'); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'klasifikasidiagnosa_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'klasifikasidiagnosa_aktif', array('checked' => 'klasifikasidiagnosa_aktif')); ?> <label for="SAKlasifikasidiagnosaM_klasifikasidiagnosa_aktif">Aktif</label>
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