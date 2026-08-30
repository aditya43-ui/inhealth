<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<table>
	<tr>
		<td><?php echo CHtml::label('Nama Pemakai','username', array('class'=>'control-label')) ?></td>
		<td>
			<?php echo CHtml::textField('username', '',array('class'=>'span3')); ?>
		</td>
	</tr>
	<tr>
		<td><?php echo CHtml::label('Kata Kunci','password', array('class'=>'control-label')) ?></td>
		<td>
			<?php echo CHtml::passwordField('password', '',array('class'=>'span3')); ?>
		</td>
	</tr>
</table>
<div class="form-actions">
    <?php 
        echo CHtml::hiddenField('pasienmasukpenunjang_id', '');
        echo CHtml::hiddenField('pendaftaran_id', '');
        echo CHtml::hiddenField('statusperiksa', '');
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'onclick'=>'batalperiksa();', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Batal', array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), array('type'=>'button','onclick'=>'$(\'#DialogBatalperiksa\').dialog(\'close\');','class'=>'btn btn-danger')); ?>
</div>




