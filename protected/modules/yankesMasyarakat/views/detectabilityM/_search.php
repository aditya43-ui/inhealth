<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'detectability-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
                <?php echo Chtml::label('Bobot', 'detectability_bobot', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'detectability_bobot', array('class' => 'span3 numbers-only', 'placeholder' => 'Ketik Bobot', 'maxlength' => 100)); ?>		
            </div>
        </div> 
        <div class="control-group">
                <?php echo Chtml::label('Deskripsi', 'detectability_deskripsi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'detectability_deskripsi', array('class' => 'span3', 'placeholder' => 'Ketik Deskripsi', 'maxlength' => 100)); ?>		
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("",'detectability_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'detectability_aktif',array('checked'=>'detectability_aktif')); ?> <label>Aktif</label>
                </div>				
            </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Kemungkinan Deteksi', 'detectability_kemungkinan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'detectability_kemungkinan', array('class' => 'span3', 'placeholder' => 'Ketik Kemungkinan Deteksi', 'maxlength' => 100)); ?>
            </div>
        </div> 
    </div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
