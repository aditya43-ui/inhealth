<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'konsekuensi-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                        <?php echo Chtml::label('Domain', 'konsekuensi_domain', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'konsekuensi_domain', array('class' => 'span3', 'placeholder' => 'Ketik Domain', 'maxlength' => 100)); ?>		
                    </div>
                </div> 
                <div class="control-group">
                        <?php echo Chtml::label('Bobot Domain', 'konsekuensi_bobot', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'konsekuensi_bobot', array('class' => 'span3 numbers-only', 'placeholder' => 'Ketik Bobot Domain', 'maxlength' => 100)); ?>		
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label("",'konsekuensi_aktif', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                if($model->konsekuensi_aktif == true){
                            ?>
                            <?php  echo $form->checkBox($model,'konsekuensi_aktif',array('value'=>1,'uncheckValue'=>0,'checked'=>'konsekuensi_aktif')); ?> <label>Aktif</label>
                            <?php
                                }else{
                            ?>
                            <?php  echo $form->checkBox($model,'konsekuensi_aktif',array('value'=>1,'uncheckValue'=>0)); ?> <label>Aktif</label>
                            <?php
                                }
                            ?>
                        </div>				
                    </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label('Bobot Nama', 'konsekuensi_namabobot', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'konsekuensi_namabobot', array('class' => 'span3', 'placeholder' => 'Ketik Bobot Nama', 'maxlength' => 100)); ?>
                    </div>
                </div> 
                <div class="control-group">
                    <?php echo Chtml::label('Deskripsi', 'konsekuensi_deskripsi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'konsekuensi_deskripsi', array('class' => 'span3', 'placeholder' => 'Ketik Deskripsi', 'maxlength' => 100)); ?>
                    </div>
                </div> 
            </div>
            <
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Konsekuensi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>