<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rekonsiliasibank-info-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'rekonsiliasibank_no'),

)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Faktur', 'rekonsiliasibank_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo Chtml::hiddenField("filterTgl", 'tanggal');
                $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                ));
                $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                ));
                $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No. Faktur", 'nofaktur', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'span3 alphanumeric-only', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Supplier", 'supplier_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'supplier_nama', array('placeholder' => 'Nama Supplier', 'class' => 'span3 hurufs-only', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
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
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang2',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>