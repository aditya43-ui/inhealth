
<?php
$this->breadcrumbs = array(
    'Informed to Consent',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ubahjadwalhemodialisa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
//        'focus'=>'#namaObatNonRacik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<div class="row-fluid">
    <div class="span12">
        <div class="control-group">
            <label class="control-label">Nama Pasien</label>
            <div class="controls">
                <?= CHtml::activeTextField($model, 'pasien_nama', array('class' => '', 'disabled' => true)); ?>
            </div>
        </div>   
        <div class="control-group">
            <label class="control-label">No. RM</label>
            <div class="controls">
                <?= CHtml::activeTextField($model, 'no_rekam_medik', array('class' => '', 'disabled' => true)); ?>
            </div>
        </div>   
        <div class="control-group">
            <label class="control-label">Tanggal</label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jadwalhemodialisa_tgl_ke',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'yearRange' => "-60:+0",
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>   
        <div class="control-group">
            <label class="control-label">Shift</label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData(ShiftHdM::model()->findAll("shift_hd_aktif = TRUE ORDER BY shift_hd_nama ASC"), 'shift_hd_id', 'shift_hd_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>   
<!--        <div class="control-group">
            <label class="control-label">Lantai</label>
            <div class="controls">
                <?php //echo $form->dropDownList($model, 'kamarruangan_id', CHtml::listData(ShiftHdM::model()->findAll("shift_hd_aktif = TRUE ORDER BY shift_hd_nama ASC"), 'shift_hd_id', 'shift_hd_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>   -->
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="form-action" style="text-align: center">
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'id'=>'btn_submit', 'onclick'=>'cekUpdate();', 'onKeypress'=>'cekUpdate();', 'disabled'=>false))."&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/update&jadwalhemodialisa_id='.$_GET['jadwalhemodialisa_id']), array(
				'class'		 => 'btn btn-danger',
				'onclick'	 => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id . '/update&jadwalhemodialisa_id='.$_GET['jadwalhemodialisa_id']).'";}); return false;'
                ))."&nbsp";
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    function cekUpdate(){
        $('#ubahjadwalhemodialisa-t-form').submit();
    }
</script>