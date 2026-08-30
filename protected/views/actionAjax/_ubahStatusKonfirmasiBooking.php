
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'bookingkamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<legend class="rim">Ubah Status Konfirmasi Booking Kamar</legend>
	<p class="help-block"><?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <table class="table">
            <tr>
                <td>
                     <?php echo $form->dropDownListRow($model,'statuskonfirmasi', CustomFunction::getStatusKonfirmasiBooking(),array('empty'=>'-- Pilih --')); ?>
                     <?php //echo $transaksibooking = $model->tgltransaksibooking; ?>
                    
                </td>
            </tr>
        </table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
                        Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/BookingkamarT/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'$("#dialogUbahStatusKonfirmasiBooking").attr("src",$(this).attr("href")); window.parent.$("#dialogUbahStatusKonfirmasiBooking").dialog("close");return false;'));  
//$content = $this->renderPartial('../tips/informasi',array(),true);
//$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
	</div>

<?php $this->endWidget(); ?>
