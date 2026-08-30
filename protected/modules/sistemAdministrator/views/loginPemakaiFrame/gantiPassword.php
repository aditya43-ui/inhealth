
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'loginpemakai-k-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($model,'old_password'),
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                    'onsubmit'=>'return cekSubmit();'),
)); ?>

	<!--<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->-->

            <?php 
                        echo $form->errorSummary($model); 
                        $this->widget('bootstrap.widgets.BootAlert');
            ?>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'old_password',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->passwordField($model,'old_password',array('value'=>'','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200)); ?><?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array('class' => 'btn btn-danger', "data-toggle"=>"tooltip", "data-placement"=>"right", "title"=>"", "data-original-title"=>"Isi Password Lama, jika Anda ingin mengganti password lama", "data-html" => true )); ?>
                    <?php echo $form->error($model,'old_password'); ?>
                </div>
            </div>
            
            <?php  
                        
                        ?>
             
                <div class="control-group">
                    <?php echo $form->labelEx($model,'new_password',array('class'=>'control-label required')); ?>
                    <div class="controls">
                        <?php echo $form->passwordField($model,'new_password',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200,'onchange' => 'checkPass(this,8)')); ?>
                        <?php echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array('class' => 'btn btn-danger', "data-toggle"=>"tooltip", "data-placement"=>"bottom", "title"=>"", 
                            "data-original-title"=> "<span style='text-align:left;'>Cara Pengisian Password<br>"
                                                   ."1. minimal terdiri dari 8 karakter,<br> "
                                                   ."2. minimal mengandung satu huruf kecil,<br> "
                                                   ."3. minimal mengandung satu huruf kapital,<br> "
                                                   ."4. minimal mengandung satu angka,<br> "
                                                   ."5. minimal mengandung satu simbol dash (-),<br>"
                                                   ."Contoh : <b>AxY12-092Nnsb</b></span> "
                            , "data-html" => true )); ?>
                        <br>
                            <span id="reset_password-error2" style="color:#cc2424" hidden></span>
                    </div>
                </div>
<?php
                        echo $form->passwordFieldRow($model,'new_password_repeat',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50));
                        echo CHtml::hiddenfield('prevUrl',$prevUrl);
            ?>
            <div class="form-actions">
                                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                         array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)')); ?>
                                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                                                        Yii::app()->request->getUrlReferrer(), 
                                                                        array('class' => 'btn btn-default',
                                                                         'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            </div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_old_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;
Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);
?>

<script>
    function cekSubmit(){
        var confirm = $("#<?php echo CHtml::activeId($model, 'new_password') ?>");	
        var old = $("#<?php echo CHtml::activeId($model, 'old_password') ?>");
        var reconfirm = $("#<?php echo CHtml::activeId($model, 'new_password_repeat') ?>");
        //alert(confirm);

        if (confirm.val() != '' && old.val() != ''){			
            confirm.attr("style",'');
            old.attr("style",'');
            reconfirm.attr("style",'');
                        if (checkPass(confirm,8)){					
                            if (reconfirm.val() == confirm.val() ){
                                jQuery("#loginpemakai-k-form").submit();                                
                            }else{
                                confirm.attr("style",'border:1px solid red;');
                                reconfirm.attr("style",'border:1px solid red;');
                                myAlert("Maaf, Ulangi Kata Kunci tidak sama dengan password baru");
                                return false;
                            }
                        }else{                            
                            confirm.attr("style",'border:1px solid red;');
                            myAlert("Maaf, inputan password tidak sesuai cara pengisian password");
                                return false;
                        }

        }else{
            if (confirm.val() == ''){
                confirm.attr("style",'border:1px solid red;');
            }
            
            if (old.val() == ''){
                old.attr("style",'border:1px solid red;');
            }
            myAlert("Maaf, password baru dan password lama tidak boleh kosong!");
            return false;
        }
    }
</script>