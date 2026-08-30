<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saloket-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "col-sm-6">
			<?php echo $form->textFieldRow($model,'lokasi_karcisantrian_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textAreaRow($model,'keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($model,'lokasi_karcisantrian_judul',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
			
                        
		<div class = "col-sm-6">
			<?php echo $form->textFieldRow($model,'lokasi_karcisantrian_lebartombol',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
                        <?php echo $form->textFieldRow($model,'lokasi_karcisantrian_tinggitombol',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
                        <?php echo $form->dropDownListRow($model,'set_antrian', array(
                            'antrian' => 'antrian',
                            'antrianHasilPenunjang' => 'antrianHasilPenunjang',
                            'antrianPendaftaranRadiologi' => 'antrianPendaftaranRadiologi',
                            'antrianRuangPeriksaRadiologi' => 'antrianRuangPeriksaRadiologi',
                            'antrianSpecimenLab' => 'antrianSpecimenLab',
                            'antrianPendaftaranLab' => 'antrianPendaftaranLab',
                            'antrianPendaftaranMCU' => 'antrianPendaftaranMCU',                            
                            
                        ),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label("","",array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model,'lokasi_karcisantrian_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?> <label> Aktif</label>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Lokasi Karcis Antrian',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
                $content = $this->renderPartial($this->path_tips.'tipsaddedit3a',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));                 
                ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
