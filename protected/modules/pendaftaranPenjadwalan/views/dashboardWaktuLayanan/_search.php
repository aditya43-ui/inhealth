<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal'
)); ?>

<div class="row">
    <div class="col-sm-4">
        <?php echo CHtml::hiddenField('type', '');
        $format = new MyFormatter(); ?>
        <?php echo CHtml::label('Periode Laporan', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo Chtml::activeDropDownList($model,'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan'), array('class' => 'span3', 'onchange' => 'ubahJnsPeriode();')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class='control-group hari'>
            <?php echo CHtml::label('Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => "span3",
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
            </div>
        </div>
        <div class='control-group bulan'>
            <?php echo CHtml::label('Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bln_awal',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => "span3",
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class='control-group'>
            <?php echo CHtml::label('Sumber Antrian', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeDropdownList($model,'sumberantrian', array('rs'=>'Rumah Sakit', 'server'=>'BPJS'),array('class'=>'span3')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit',)
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

<script type="text/javascript">
    
    function ubahJnsPeriode(){
        var obj = $("#<?php echo CHtml::activeId($model,'jns_periode'); ?>");
        if(obj.val() == 'hari'){
            $('.hari').show();
            $('.bulan').hide();
        }else if(obj.val() == 'bulan'){
            $('.hari').hide();
            $('.bulan').show();
        }
    }
    
    
    $(document).ready(function(){
        ubahJnsPeriode();
    });
</script>