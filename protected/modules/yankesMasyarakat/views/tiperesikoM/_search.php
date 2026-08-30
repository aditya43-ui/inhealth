<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'tiperesiko-m-search',
	'type'=>'horizontal',
)); ?>
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
                    <?php echo $form->checkBox($model,'tiperesiko_aktif',array('checked'=>'tiperesiko_aktif')); ?> <label>Aktif</label>
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
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
