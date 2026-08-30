<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'tiperesiko-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                        <?php echo Chtml::label('Nama', 'tiperesiko_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tiperesiko_nama', array('class' => 'span3', 'placeholder' => 'Ketik Nama', 'maxlength' => 100)); ?>		
                    </div>
                </div> 
                <div class="control-group">
                        <?php echo Chtml::label('Nama Lain', 'tiperesiko_namalain', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tiperesiko_namalain', array('class' => 'span3', 'placeholder' => 'Ketik Nama Lain', 'maxlength' => 100)); ?>		
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label("",'tiperesiko_aktif', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                if($model->tiperesiko_aktif == true){
                            ?>
                            <?php  echo $form->checkBox($model,'tiperesiko_aktif',array('value'=>1,'uncheckValue'=>0,'checked'=>'tiperesiko_aktif')); ?> <label>Aktif</label>
                            <?php
                                }else{
                            ?>
                            <?php  echo $form->checkBox($model,'tiperesiko_aktif',array('value'=>1,'uncheckValue'=>0)); ?> <label>Aktif</label>
                            <?php
                                }
                            ?>
                        </div>				
                    </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label('Kode', 'tiperesiko_kode', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tiperesiko_kode', array('class' => 'span3', 'placeholder' => 'Ketik Kode', 'maxlength' => 100)); ?>
                    </div>
                </div> 
                <div class="control-group">
                    <?php echo Chtml::label('Keterangan', 'tiperesiko_keterangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tiperesiko_keterangan', array('class' => 'span3', 'placeholder' => 'Ketik Keterangan', 'maxlength' => 100)); ?>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tipe Risiko',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>