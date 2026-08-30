<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sajenis-anastesi-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model,'jenisanastesi_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'onkeyup'=>'namalain(this)')); ?>
                <?php echo $form->textFieldRow($model,'jenisanastesi_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>	
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model,'jenisanastesi_teknik',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php if(isset($_GET['id'])){ ?>
                <?php // echo $form->checkBoxRow($model,'jenisanastesi_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo CHtml::label("",'jenisanastesi_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'jenisanastesi_aktif',array('checked'=>'jenisanastesi_aktif')); ?> <label>Aktif</label>
                    </div>				
                </div>
                <?php } ?>
            </div>
        </div>

	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-default',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Anestesi',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
			$content = $this->renderPartial($this->path_tips.'transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
		</div>
	</div>
<?php $this->endWidget(); ?>
