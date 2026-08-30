<!--<legend class="rim">Pencarian</legend>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'searchLaporan',
    'type' => 'horizontal',
)); ?>

<div class="row" style="margin-bottom: 8px;">
    <div class="col-sm-6">
        <?php $model->tgl_awal  = $format->formatDateTimeForUser($model->tgl_awal); ?>
        <?php echo CHtml::label('Dari Tanggal', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_awal',
                'mode' => 'date',
                'options' => array(
                    'maxDate' => 'd',
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'dtPicker2 span2',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <?php $model->tgl_awal  = $format->formatDateTimeForDb($model->tgl_awal); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
        <?php echo CHtml::label(' Sampai Dengan', ' Sampai Dengan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_akhir',
                'mode' => 'date',
                'options' => array(
                    'maxDate' => 'd',
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'dtPicker2 span2',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <?php $model->tgl_akhir  = $format->formatDateTimeForDb($model->tgl_akhir); ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>