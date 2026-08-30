<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'aksesvaskular-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'aksesvaskular_nama')
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class = "span6">
                    <?php echo $form->textFieldRow($model,'aksesvaskular_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'aksesvaskular_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <div class="control-group">
                    <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'aksesvaskular_aktif',array('checked'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);")); ?> <label>Jenis Dialisat Aktif</label>
                    </div>
                </div>
            </div>
            <div class = "span6">
                <?php echo $form->textAreaRow($model,'aksesvaskular_deskripsi',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php 
			if(isset($_GET['id']) && !empty($_GET['id'])){
				echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('update',array('id'=>$_GET['id'])), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
			}else{
				echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
			}
			?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Akses Vaskular',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
			$content = $this->renderPartial('hemodialisa.views.tips.tipsaddedit3',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
		</div>
	</div>
<?php $this->endWidget(); ?>
