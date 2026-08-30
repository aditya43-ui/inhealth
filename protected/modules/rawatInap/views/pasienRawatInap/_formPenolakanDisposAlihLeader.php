<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahDokter-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<div class="control-group">
    <?= $form->hiddenField($modUbahDokter, 'ubahdokter_id') ?>
    <?php echo CHtml::label('&nbsp;&nbsp;Tanggal Penolakan', 'tglubahdokter', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php $formats = MyFormatter::formatDateTimeForDb(date('d/m/Y H:i:s')); ?>
        <?php echo $form->textField($modUbahDokter,'tglubahdokter', array('readonly'=>true, 'class'=>'realtime' )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Alasan Pembatalan', 'tglubahdokter', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textArea($modUbahDokter, 'keterangan', array()); ?>
    </div>
</div>
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>

<script>
    function cloaseDialog(){
        window.parent.$('#dialogTolakAlihLeaderDanDispos').dialog('close');
    }

    $(function(){
        <?php if(isset($_GET['sukses'])) : ?>
            cloaseDialog();
        <?php endif; ?>
    })
</script>