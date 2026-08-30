<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'rjkasuspenyakitobat-m-search',
                 'type'=>'horizontal',
)); ?>
		<?php  echo $form->textFieldRow($model,'jumlahobat',array('class'=>'span3 interger','size'=>50,'maxlength'=>50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'menu_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_aktif', array('checked' => 'menu_aktif')); ?>
                <label for="FormulaobatkronisMK_is_aktif">Aktif</label>
            </div>
        </div>           
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
