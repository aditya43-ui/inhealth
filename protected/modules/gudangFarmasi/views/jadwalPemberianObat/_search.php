<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagolongan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
            <div class='control-group'>
                <label class='control-label'>Kemasan Alat</label>
                <div class="controls">
                    <?php echo $form->textField($model,'subjenis_nama',array('class'=>'span3')); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Jadwal</label>
                <div class="controls">
                    <?= $form->dropDownList($model, 'jadwal', LookupM::getItemsUrutan('jammonitoring'), ['empty'=>'-- Pilih --']) ?>
                </div>
            </div>
            
            <div class='control-group'>
                <?php echo CHtml::label("",'jadwalpemberianobat_aktif', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'jadwalpemberianobat_aktif',array('checked'=>'jadwalpemberianobat_aktif', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Aktif</label>
                </div>
            </div>
	</div>
	<div class="col-sm-6">
            <div class='control-group'>
                <label class='control-label'>Signa</label>
                <div class="controls">
                    <?php echo $form->textField($model,'signa_oa',array('class'=>'span3')); ?>
                </div>
            </div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
