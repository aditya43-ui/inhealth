<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'peluang-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
                <?php echo Chtml::label('Descriptor', 'peluang_descriptor', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'peluang_descriptor', array('class' => 'span3', 'placeholder' => 'Ketik Descriptor', 'maxlength' => 100)); ?>		
            </div>
        </div> 
        <div class="control-group">
                <?php echo Chtml::label('Bobot Descriptor', 'peluang_bobotdescriptor', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'peluang_bobotdescriptor', array('class' => 'span3 numbers-only', 'placeholder' => 'Ketik Bobot Descriptor', 'maxlength' => 100)); ?>		
            </div>
        </div>
        <div class="control-group">
                <?php echo Chtml::label('Deskripsi', 'peluang_deskripsi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'peluang_deskripsi', array('class' => 'span3', 'placeholder' => 'Ketik Deskripsi', 'maxlength' => 100)); ?>		
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("",'peluang_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'peluang_aktif',array('checked'=>'peluang_aktif')); ?> <label>Aktif</label>
                </div>				
            </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Frekuensi', 'peluang_frekuensi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'peluang_frekuensi', array('class' => 'span3', 'placeholder' => 'Ketik Frekuensi', 'maxlength' => 100)); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo Chtml::label('Kemungkinan', 'peluang_kemungkinan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'peluang_kemungkinan', array('class' => 'span3', 'placeholder' => 'Ketik Kemungkinan', 'maxlength' => 100)); ?>
            </div>
        </div> 
    </div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
