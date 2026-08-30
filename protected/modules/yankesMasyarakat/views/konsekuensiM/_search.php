<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'konsekuensi-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
                <?php echo Chtml::label('Domain', 'konsekuensi_domain', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'konsekuensi_domain', array('class' => 'span3', 'placeholder' => 'Ketik Domain', 'maxlength' => 100)); ?>		
            </div>
        </div> 
        <div class="control-group">
                <?php echo Chtml::label('Bobot Domain', 'konsekuensi_bobot', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'konsekuensi_bobot', array('class' => 'span3 numbers-only', 'placeholder' => 'Ketik Bobot Domain', 'maxlength' => 100)); ?>		
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("",'konsekuensi_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'konsekuensi_aktif',array('checked'=>'konsekuensi_aktif')); ?> <label>Aktif</label>
                </div>				
            </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Bobot Nama', 'konsekuensi_namabobot', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'konsekuensi_namabobot', array('class' => 'span3', 'placeholder' => 'Ketik Bobot Nama', 'maxlength' => 100)); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo Chtml::label('Deskripsi', 'konsekuensi_deskripsi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'konsekuensi_deskripsi', array('class' => 'span3', 'placeholder' => 'Ketik Deskripsi', 'maxlength' => 100)); ?>
            </div>
        </div> 
    </div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
