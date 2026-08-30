
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'klasifikasisubkelas-m-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('onsubmit' => 'return requiredCheck(this);'),
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'klasifikasisubkelas_kode'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->dropdownListRow($model,'subkelas_id', CHtml::listData(SubkelasM::model()->findAll(),'subkelas_id','subkelas_nama'),array('empty'=>'---Pilih---')); ?>
            <?php echo $form->textFieldRow($model,'klasifikasisubkelas_kode',array('placeholder'=>'klasifikasi subkelas Kode','class'=>'span3 form-control', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'klasifikasisubkelas_noterperinci',array('placeholder'=>'klasifikasi subkelas No terperinci','class'=>'span3 form-control', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'klasifikasisubkelas_nama',array('placeholder'=>'klasifikasi subkelas Nama','class'=>'span3 form-control', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'klasifikasisubkelas_nama2',array('placeholder'=>'klasifikasi subkelas Nama Lainya','class'=>'span3 form-control', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
			<?php echo CHtml::label("",'klasifikasisubkelas_aktif', array('class'=>'control-label')) ?>
				  <div class="controls">
                  <?php echo $form->checkBox($model,'klasifikasisubkelas_aktif',array('placeholder'=>'klasifikasi subkelas Aktif', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 <label>Aktif</label>
				  </div>
			</div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-floppy"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl('admin'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan ', array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            <?php
                $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

<?php
$this->endWidget(); ?>
