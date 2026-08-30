<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'peluang-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                        <?php echo Chtml::label('Descriptor', 'peluang_descriptor', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'peluang_descriptor', array('class' => 'span3', 'placeholder' => 'Ketik Descriptor', 'maxlength' => 100)); ?>		
                    </div>
                </div> 
                <div class="control-group">
                        <?php echo Chtml::label('Bobot Descriptor', 'peluang_bobotdescriptor', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'peluang_bobotdescriptor', array('class' => 'span3 numbers-only', 'placeholder' => 'Ketik Bobot Descriptor', 'maxlength' => 100)); ?>		
                    </div>
                </div>
                <div class="control-group">
                        <?php echo Chtml::label('Deskripsi', 'peluang_deskripsi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'peluang_deskripsi', array('class' => 'span3', 'placeholder' => 'Ketik Deskripsi', 'maxlength' => 100)); ?>		
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label("",'peluang_aktif', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                if($model->peluang_aktif == true){
                            ?>
                            <?php  echo $form->checkBox($model,'peluang_aktif',array('value'=>1,'uncheckValue'=>0,'checked'=>'peluang_aktif')); ?> <label>Aktif</label>
                            <?php
                                }else{
                            ?>
                            <?php  echo $form->checkBox($model,'peluang_aktif',array('value'=>1,'uncheckValue'=>0)); ?> <label>Aktif</label>
                            <?php
                                }
                            ?>
                        </div>				
                    </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label('Frekuensi', 'peluang_frekuensi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'peluang_frekuensi', array('class' => 'span3', 'placeholder' => 'Ketik Frekuensi', 'maxlength' => 100)); ?>
                    </div>
                </div> 
                <div class="control-group">
                    <?php echo Chtml::label('Kemungkinan', 'peluang_kemungkinan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'peluang_kemungkinan', array('class' => 'span3', 'placeholder' => 'Ketik Kemungkinan', 'maxlength' => 100)); ?>
                    </div>
                </div> 
            </div>
            
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Peluang',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>