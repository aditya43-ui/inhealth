<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'penerimaanpiutangprsh-t-search',
        ));
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
            <?php echo CHtml::label('Tanggal Rencana','tgl_entry', array('class'=>'control-label inline')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_awal',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
//                                                    'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                    )); 
                ?>
                <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama ','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'supplier_nama', array('class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
            <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_akhir',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
    //                                                    'minDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                    )); 
                ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No Bukti Kas','', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_voucher', array('class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
                'javascript:void(0);', array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
?>
</div>
<?php $this->endWidget(); ?>
