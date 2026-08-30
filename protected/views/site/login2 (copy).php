<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/login.js"></script>
<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<div class="latar">
	<div class="logors">

	</div>
<div class="span4" align="center">
<p></p><br/>
<h1>Login</h1>

<p>Silakan isi formulir berikut dengan akun Anda:</p>


<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
        'focus'=>'#LoginForm_username',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Kolom ini<span class="required">*</span> harus diisi.</p>

	<div class="row2">
		<?php echo $form->labelEx($model,'Nama Pemakai'); ?>
		<?php echo $form->textField($model,'username',array('onBlur'=>'cekUsername(this)')); ?>
                                <?php echo CHtml::hiddenField('user_id') ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row2">
		<?php echo $form->labelEx($model,'Kata Kunci'); ?><img id="capsLockNotice" class="ssdlogo" alt="Caps Lock Is ON" title="Caps Lock Is ON" src="<?php echo Yii::app()->request->baseUrl; ?>/images/capslock-notice.png">
		<?php echo $form->passwordField($model,'password',array('class'=>'input capLocksCheck')); ?> 
		<?php echo $form->error($model,'password'); ?>
                
	</div>
	<div class="row2">
		<?php echo $form->labelEx($model, 'instalasi'); ?>
		<?php echo $form->dropDownList($model, 'instalasi', array(),array('empty'=>'-- Pilih --',
                                                                            'ajax'=>array(
                                                                                'type'=>'POST',
                                                                                'url'=>  CController::createUrl('site/dynamicRuangan'),
                                                                                'update'=>'#LoginForm_ruangan',))); ?>
                                <?php echo $form->error($model,'instalasi'); ?>
	</div>
	<div class="row2">
		<?php echo $form->labelEx($model, 'ruangan'); ?>
		<?php echo $form->dropDownList($model, 'ruangan', array(),array('empty'=>'-- Pilih --',)); ?>
                                <?php echo $form->error($model,'ruangan'); ?>
	</div>
	<div class="row2">
		<?php echo $form->labelEx($model, 'modul'); ?>
		<?php echo $form->dropDownList($model, 'modul', array(),array('empty'=>'-- Pilih --',)); ?>
                
	</div>
	<div class="row buttons">
		<?php echo CHtml::htmlButton(Yii::t('Login','{icon} Login',array('{icon}'=>' <i class="icon-user icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>
 

</div>



<?php
$url = CController::createUrl('site/AjaxCekUsername');
$js = <<< JSCRIPT

   function cekUsername(obj){
        $.post("${url}", { username: obj.value},
        function(data){
            $('#user_id').val(data.id);
            $('#LoginForm_instalasi').html(data.instalasi)
            $('#LoginForm_ruangan').html(data.ruangan)
            $('#LoginForm_modul').html(data.modul)
        }, "json");
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('hapusPenjualan', $js, CClientScript::POS_HEAD);
?>
