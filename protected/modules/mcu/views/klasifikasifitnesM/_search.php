<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'mcklasifikasifitnes-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'age_elev', array('placeholder' => 'Age Elev', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'lama_menit', array('placeholder' => 'Duration (min)', 'class' => 'span3 integer')); ?>
        <?php echo $form->textFieldRow($model, 'workload_kph', array('placeholder' => 'Work Load (Kph)', 'class' => 'span3 integer')); ?>
        <?php echo $form->textFieldRow($model, 'estimasirate', array('placeholder' => 'Estimate 02 1/min', 'class' => 'span3 integer')); ?>
        <?php echo $form->textFieldRow($model, 'max_intake', array('placeholder' => 'Max 02 Intake ml/kg/min', 'class' => 'span3 integer')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'umur_min', array('placeholder' => 'Umur Minimal', 'class' => 'span3 integer')); ?>
        <?php echo $form->textFieldRow($model, 'umur_maks', array('placeholder' => 'Umur Maksimal', 'class' => 'span3 integer')); ?>
        <?php echo $form->textFieldRow($model, 'mets', array('placeholder' => 'Mets', 'class' => 'span3 integer')); ?>
        <?php echo $form->textFieldRow($model, 'klasifikasifitnes', array('placeholder' => 'Klasifikasi Fitnes', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'functional_class', array('placeholder' => 'Functional Class', 'class' => 'span3', 'maxlength' => 5)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'walking_kmhr', array('placeholder' => 'Walking KM/Hr', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jogging_kmhr', array('placeholder' => 'Jogging KM/Hr', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'bicycling_kmhr', array('placeholder' => 'Bicycling KM/Hr', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($model, 'other_sports', array('placeholder' => 'Other Sports', 'rows' => 2, 'cols' => 50, 'class' => 'span3')); ?>
        <?php echo $form->checkBoxRow($model, 'klasifikasifitnes_aktif'); ?>
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