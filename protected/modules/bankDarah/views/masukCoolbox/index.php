<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<style>        
    .control-label{
        text-align:right !important;
        vertical-align: top !important;
    }        
    .form-horizontal .control-label{
        width: 160px !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Transaksi <b>Masuk Coolbox</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'masukcoolbox-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus'=>'#nomorbarcode',
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Penggunaan Coolbox</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '/_dataPenggunaanCoolbox', array('model' => $model, 'form'=>$form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Kantong Darah</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '/_form', array( 'modDet'=>$modDet, 'model' => $model, 'form'=>$form)); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="control-group ">
                    <label class="control-label">Tanggal</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modDet,
                            'attribute' => 'tanggal_masukcoolbox',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                // 'maxDate' => 'd',
                                'onClose' => 'js:function(){hitungShift();}',
                            ),
                            'htmlOptions' => array('class'=>'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tanggal_masukcoolbox'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <label class="control-label">Nama Petugas</label>
                    <div class="controls">
                        <?php echo $form->hiddenField($modDet, 'petugas_id', array('class' => 'span3', 'readonly'=>true)); ?>
                        <?php echo $form->textField($modDet, 'petugas_nama', array('class' => 'span3', 'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) : Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onclick' => 'cekForm();','id'=>'btn_submit','disabled'=>(isset($_GET['sukses']))? true : false));?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/bahanMenuDietM/admin'), array('class' => 'btn btn-danger', 'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    function cekForm(){
        if (requiredCheck($("#masukcoolbox-t-form"))){
            
            var length = $("#tableKantong > tbody > tr").length;
            
            if (length == 0){
                myAlert("Pilih data kantong darah terlebih dahulu","Perhatian!");
                return false;
            }
            
            $("#masukcoolbox-t-form").submit();
            disableOnSubmit($("#bnt_submit"));
        }
            
        return false;
    }
   
</script>