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
$hiddenData = "";
if(isset($_GET['sukses'])){
    $hiddenData = "hidden";
    Yii::app()->user->setFlash('success',"Berhasil di Verifikasi DPJP!");
}

$this->widget('bootstrap.widgets.BootAlert'); 
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'verifikasidpjp-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="control-group">		
            <?php echo CHtml::label("DPJP",'', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('dpjp_nama', $model->dpjp->namaLengkap,array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">		
            <?php echo CHtml::label("Tgl. Verifikasi",'', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'verifikasidpjp_tanggal',
                    'mode'=>'datetime',
                    'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                )); ?>
            </div>
        </div>
        <div class="control-group">		
            <?php echo CHtml::label("Hasil Review DPJP",'', array('class' => 'control-label')) ?>
            <div class="controls">
            </div>
        </div>
        <div class="control-group">	
            <div style="width: 100%">
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'verifikasidpjp_hasilreview', 'toolbar'=>'mini','height'=>'100px')) ?>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
   <div class="form-actions">
        <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Verifikasi SOAP/ ADIME',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button', 'onKeypress'=>'return formSubmit(this,event)','onclick'=>'simpanVerifikasi()'));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function simpanVerifikasi(){
        $('#verifikasidpjp-t-form').submit();
    }
</script>