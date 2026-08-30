<?php $a = Yii::app()->user->id;
$modLog = LoginpemakaiK::model()->findByPk($a);
if(!empty($modLog->pegawai_id)){
    $modPeg = PegawaiM::model()->findByPk($modLog->pegawai_id);
    $nama = $modPeg->nama_pegawai;
}
$format = new MyFormatter();
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvperalatan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>    
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <label for="prevmainten_pegawaiskip">Nama Pegawai <span class="required">*</span></label>                    </label>
            <div class="controls">
                <input class="span3" value="<?php echo $nama ?>" readonly="true" type="text">                                            
            </div>
        </div>
        <?php echo CHtml::ActivehiddenField($model, 'prevmainten_pegawaiskip', array('class'=>'span3','value'=>$a)); ?>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Tanggal Skip <span class='required'>*</span>",'prevmainten_tglskip');?>
            </label>
            <div class="controls">
                <?php $model->prevmainten_tglskip = $format->formatDateTimeForUser($model->prevmainten_tglskip); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'prevmainten_tglskip', 
                        'mode'=>'date',
                        'options'=>array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                        'class' => "span3 required",
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Alasan Skip <span class='required'>*</span>",'prevmainten_alasanskip');?>
            </label>
            <div class="controls">
                <?php echo CHtml::activeTextArea($model, 'prevmainten_alasanskip', array('class'=>'span3')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>($model->prevmainten_skip==1)? true : false));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/invperalatanT/admin'), array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php if($model->prevmainten_skip == 1){ ?>
<script>
    parent.location.reload();
</script>
<?php } ?>