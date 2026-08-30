<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bedahanastesilokalpasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<?php echo $form->errorSummary($model); ?>

<div class="col-sm-6">
    <?php echo $form->textAreaRow($model, 'rencanaoperasipasien', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Spesimen Yang Diambil</div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial($this->path_view . "_spesimen", array(
                'form' => $form,
                'model' => $model,
            ), true); ?>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'posisipasien', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->radioButtonList($model, 'posisipasien', array(
                'Terlentang' => 'Terlentang',
                'Tengkurap' => 'Tengkurap',
                'Litotomi' => 'Litotomi',
                'Miring' => 'Miring',
                'Duduk' => 'Duduk',
                'Lainnya' => 'Lainnya',
            ), array('class' => 'posisipasien', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->textField($model, 'posisipasien_lainnya', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

        </div>
    </div>

</div>
<div class="clear"></div>

<?php // echo $form->textFieldRow($model,'rencanaoperasi_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'perdarahan_jml',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'td_systolic',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'td_dyastolic',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'hb_nilai',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'suhubadan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'respirationrate',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'ht_nilai',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'beratbadan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang', 
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan BedahanastesilokalpasienT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>
<script>
    function cekPosisi() {
        var v = $(".posisipasien:checked").val();

        if (v == "Lainnya") {
            $("#BedahanastesilokalpasienT_posisipasien_lainnya").prop("readonly", false);
        } else {
            $("#BedahanastesilokalpasienT_posisipasien_lainnya").prop("readonly", true).val("");
        }
    }

    $(document).ready(function() {
        $(".posisipasien").on("click", cekPosisi);
        cekPosisi();
    });
</script>