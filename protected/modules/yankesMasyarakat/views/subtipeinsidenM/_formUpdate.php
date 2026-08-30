<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'subtipeinsiden-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tipe Insiden","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'tipeinsiden_id',Chtml::listData(TipeinsidenM::model()->findAllByAttributes(array('tipeinsiden_aktif'=>true)),'tipeinsiden_id','tipeinsiden_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                    </div>
                </div> 
                                <div class="control-group">
                    <?php echo CHtml::label("Kelompok Subtipe Insiden","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'kelompoksubtipeinsiden_id',Chtml::listData(KelompoksubtipeinsidenM::model()->findAllByAttributes(array('kelompoksubtipeinsiden_aktif'=>true)),'kelompoksubtipeinsiden_id','kelompoksubtipeinsiden_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                    </div>
                </div> 

                <div class="control-group">
                        <?php echo Chtml::label('Nama', 'subtipeinsiden_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'subtipeinsiden_nama', array('class' => 'span3', 'placeholder' => 'Ketik Nama', 'maxlength' => 100,'onkeyup'=>'namaLain(this);')); ?>		
                    </div>
                </div> 
                <div class="control-group">
                        <?php echo Chtml::label('Nama Lain', 'subtipeinsiden_namalainnya', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'subtipeinsiden_namalainnya', array('class' => 'span3', 'placeholder' => 'Ketik Nama Lain', 'maxlength' => 100)); ?>		
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label("",'subtipeinsiden_aktif', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                if($model->subtipeinsiden_aktif == true){
                            ?>
                            <?php  echo $form->checkBox($model,'subtipeinsiden_aktif',array('value'=>1,'uncheckValue'=>0,'checked'=>'subtipeinsiden_aktif')); ?> <label>Aktif</label>
                            <?php
                                }else{
                            ?>
                            <?php  echo $form->checkBox($model,'subtipeinsiden_aktif',array('value'=>1,'uncheckValue'=>0)); ?> <label>Aktif</label>
                            <?php
                                }
                            ?>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Subtipe Insiden',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script>
    function namaLain(nama)
    {
        document.getElementById('SubtipeinsidenM_subtipeinsiden_namalainnya').value = nama.value.toUpperCase();
    }
</script>