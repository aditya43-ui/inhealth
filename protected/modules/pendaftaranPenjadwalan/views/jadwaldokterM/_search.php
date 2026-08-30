<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rdjadwaldokter-m-search',
        'focus'=>'#PPJadwaldokterM_jadwaldokter_hari',
        'type'=>'horizontal',        
)); ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'ruangan_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(PPPendaftaranT::model()->getRuanganJadwalDokter(), 'ruangan_id', 'ruangan_nama') ,
                  array('empty'=>'-- Pilih --',
                        'onchange'=>"listDokterRuangan(this.value)",
						'class' => 'form-control',
                        'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'pegawai_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'pegawai_id', CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai') ,array('class' => 'form-control','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'jadwaldokter_hari',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'jadwaldokter_hari',array('class'=>'span3 form-control','maxlength'=>20)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'Tanggal',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'bulan', Params::getBulan() ,array('class' => 'form-control','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'jadwaldokter_buka',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'jadwaldokter_buka',array('class'=>'span3 form-control','maxlength'=>50)); ?>
            </div>
        </div>
	<?php //echo $form->textFieldRow($model,'jadwaldokter_mulai',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'jadwaldokter_tutup',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'maximumantrian',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
