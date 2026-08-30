<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->konfigemail_id),array('view','id'=>$data->konfigemail_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_host')); ?>:</b>
	<?php echo CHtml::encode($data->konfigemail_host); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_port')); ?>:</b>
	<?php echo CHtml::encode($data->konfigemail_port); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_smtp_auth')); ?>:</b>
	<?php echo CHtml::encode($data->konfigemail_smtp_auth); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_username')); ?>:</b>
	<?php echo CHtml::encode($data->konfigemail_username); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_password')); ?>:</b>
	<?php echo CHtml::encode($data->konfigemail_password); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('profilrs_id')); ?>:</b>
	<?php echo CHtml::encode($data->profilrs_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_smtp_secure')); ?>:</b>
	<?php echo CHtml::encode($data->konfigemail_smtp_secure); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigemail_ishtml')); ?>:</b>
	<?php echo CHtml::encode($data->konfigemail_ishtml); ?>
	<br>

	*/ ?>

</div>