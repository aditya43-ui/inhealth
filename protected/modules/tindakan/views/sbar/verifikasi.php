<style>
    body {
        color: black;
    }

    .border th, .border td{
        border:1px solid #000;
        padding: 2px;
    }


    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }

    .text-center{
        text-align: center !important;
    }
</style>
<?php
  $this->widget('bootstrap.widgets.BootAlert');

  $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
  	'id'=>'frmverifikasi-t-form',
  	'enableAjaxValidation'=>false,
  	'type'=>'horizontal',
  	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
  ));
?>
<?php echo $form->hiddenField($model,'pendaftaran_id',array()); ?>
<?php echo $form->hiddenField($model,'sbar_id',array()); ?>
<div class="row">
  <div class="col-sm-12">
    <div class="control-group ">
        <?php echo CHtml::label('Petugas Pengisi','pegawaiverifikasi_id', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
        <div class="controls">
          <?php echo $form->hiddenField($model,'pegawaiverifikasi_id'); ?>
          <?php echo $form->textField($model,'pegawaiverifikasi_nama',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label('Tgl. Verifikasi','tgl_verifikasi', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
        <div class="controls">
          <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_verifikasi',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3',
                ),
            ));
          ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo CHtml::label('Hasil Review SBAR','hasil_review', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
        <div class="controls" style="width: 70%">
          <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'hasil_review', 'toolbar'=>'mini','height'=>'200px')) ?>
        </div>
    </div>
  </div>
</div>

<div class="form-actions">
  <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Verifikasi SBAR',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
</div>
<?php $this->endWidget(); ?>
