<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
		<div class="control-group">		
            <?php echo CHtml::label("Tanggal Pendaftaran",'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>        
        <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3', 'maxlength'=>20)); ?>
        <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3', 'maxlength'=>10)); ?>    
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','maxlength'=>50)); ?>
        <?php echo $form->textFieldRow($model,'no_masukpenunjang',array('placeholder'=>'Ketik No. Masuk Penunjang','class'=>'span3', 'maxlength'=>20)); ?>
    </div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'
	));  ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
		Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
		array('class'=>'btn btn-danger',
		'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	<?php
		$content = $this->renderPartial('laboratoriumPA.views.informasiBatalPeriksaLab.tips.informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>