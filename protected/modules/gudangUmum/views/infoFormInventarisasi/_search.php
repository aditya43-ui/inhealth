<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'searchInformasi',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'forminvbarang_no'),
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Formulir', 'tglformulir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'forminvbarang_no', array('placeholder' => 'No. Formulir', 'class' => 'angkahuruf-only')); ?>
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
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
    );

    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')
    );

    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')
    );

    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="entypo-newspaper"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'CSV\')')
    );
    ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $urlEksportCsv =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/eksportCSV');

    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchInformasi :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function exportTemplateCsv()
{
    window.open("${urlEksportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>

    <?php
    $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>