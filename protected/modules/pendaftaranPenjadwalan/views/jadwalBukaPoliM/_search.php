<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppjadwal-buka-poli-m-search',
    'focus' => '#' . CHtml::activeId($model, 'ruangan_id'),
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'jadwalbukapoli_id',array('class'=>'span5')); 
?>

<?php //echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span3')); 
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'ruangan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'ruangan_id',
                    CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),
                    array(
                        'empty' => '-- Pilih --',
                        'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'hari', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'hari', CustomFunction::getNamaHari(), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'Jadwal Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jmabuka',
                    'mode' => 'time',

                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jmabuka'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'Jam Buka Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulai',
                    'mode' => 'time',

                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jammulai'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'Jam Tutup Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamtutup',
                    'mode' => 'time',

                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jamtutup'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jam Mulai Pendaftaran Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulaipendaftaran',
                    'mode' => 'time',
                    'options' => array(
                        'onSelect' => 'js:function(){getJamBukaDariJamMulaiPendaftaran(this);}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jammulaipendaftaran'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jam Akhir Pendaftaran Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamakhirpendaftaran',
                    'mode' => 'time',
                    'options' => array(
                        'onSelect' => 'js:function(){getJamBukaDariJamAkhirPendaftaran(this);}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jamakhirpendaftaran'); ?>
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