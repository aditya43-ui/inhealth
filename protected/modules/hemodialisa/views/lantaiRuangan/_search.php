<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'sakonfigfarmasi-k-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Nama Lantai</label>
                    <div class="controls">
                        <?php echo $form->textField($model,'lookup_name',array('class'=>'span3','maxlength'=>50)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nama Lainnya</label>
                    <div class="controls">
                        <?php echo $form->textField($model,'lookup_value',array('class'=>'span3','maxlength'=>50)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Lantai</label>
                    <div class="controls">
                        <?php echo $form->textField($model,'lookup_urutan',array('class'=>'span3','maxlength'=>50)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Kode</label>
                    <div class="controls">
                        <?php echo $form->textField($model,'lookup_kode',array('class'=>'span3','maxlength'=>50)); ?>
                    </div>
                </div>
            <?php // echo $form->textFieldRow($model,'lookup_type',array('class'=>'span3','maxlength'=>50)); ?>

            <?php // echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3','maxlength'=>50)); ?>
            <?php // echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span3','maxlength'=>50)); ?>
            <?php // echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span3 integer','maxlength'=>50)); ?>
            </div>
            
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'lookup_aktif',array('checked'=>'lookup_aktif')); ?><label>Aktif</label>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'lookup_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'lookup_value',array('class'=>'span5','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="' . MyIcon::getIcons('ulang') . '"></i>')), Yii::app()->createUrl($this->module->id . '/' . $this->id . '/create'), array('class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang data ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            ?>        </div>

<?php $this->endWidget(); ?>
