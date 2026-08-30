<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'penyedia-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama Penyedia","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'penyedia_nama',array('class'=>'span3','maxlength'=>200)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Lain Penyedia","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'penyedia_namalain',array('class'=>'span3','maxlength'=>200)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alamat","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($model,'penyedia_alamat',array('class'=>'span3','maxlength'=>200)); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Direktur","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'penyedia_direktur',array('class'=>'span3','maxlength'=>200)); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model,'penyedia_cp',array('class'=>'span3','maxlength'=>200)); ?>

        <?php echo $form->checkBoxRow($model,'penyedia_aktif', array('checked' => 'checked')); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>

        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
