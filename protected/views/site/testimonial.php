<?php
$form=$this->beginWidget('CActiveForm',array(
        'id'=>'testimonial-form',
	'action'=>Yii::app()->controller->createUrl('Testimonial'),
        'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),

)); ?>



<table width="300" border="0">
    <tr>
        <td><?php echo $form->labelEx($modKomen,'namakomentar'); ?></td>
        <td><?php echo $form->textField($modKomen,'namakomentar', array('class'=>'span2')); ?>
            <?php echo $form->error($modKomen,'namakomentar',array('style'=>'font-size:11px;'));?>
        </td>
    </tr>
    
    <tr>
        <td><?php echo $form->labelEx($modKomen,'instanasi'); ?></td>
        <td><?php echo $form->textField($modKomen,'instanasi', array('class'=>'span2')); ?>
            <?php echo $form->error($modKomen,'instanasi',array('style'=>'font-size:11px;'));?>
        </td>
    </tr>
    
    <tr>
        <td><?php echo $form->labelEx($modKomen,'emailkomentar'); ?></td>
        <td><?php echo $form->textField($modKomen,'emailkomentar', array('class'=>'span2')); ?>
            <?php echo $form->error($modKomen,'emailkomentar',array('style'=>'font-size:11px;'));?>
        </td>
    </tr>
    
    <tr>
        <td><?php echo $form->labelEx($modKomen,'websitekomentar'); ?></td>
        <td><?php echo $form->textField($modKomen,'websitekomentar', array('class'=>'span2')); ?>
            <?php echo $form->error($modKomen,'websitekomentar',array('style'=>'font-size:11px;'));?>
        </td>
    </tr>
    
    <tr>
        <td><?php echo $form->labelEx($modKomen,'deskripsikomentat'); ?></td>
        <td><?php echo $form->textArea($modKomen,'deskripsikomentat', array('class'=>'span2')); ?>
            <?php echo $form->error($modKomen,'deskripsikomentat',array('style'=>'font-size:11px;'));?>
        </td>
    </tr>
  
<?php if(CCaptcha::checkRequirements()): ?>
  <tr>
    <td>
        <?php $this->widget('CCaptcha', array('imageOptions'=>array('class'=>'span2','id'=>'verifyKomen'))); ?>
    </td>
    <td>
        <?php echo $form->textField($modKomen,'verifyCode', array('class'=>'span2')); ?>
        <p style="font-size: 11px;">Masukkan huruf seperti yang terlihat pada gambar di samping.</p>
    </td>
  </tr>
<?php endif; ?>
  
    <tr>
        <td colspan="2">
            <div class="form-actions">
            <?php echo CHtml::htmlButton('Simpan',array('class'=>'btn btn-primary pull-right', 'type'=>'submit')); ?>
            </div>
        </td>
    </tr>
</table> 

 
<?php $this->endWidget(); ?>
