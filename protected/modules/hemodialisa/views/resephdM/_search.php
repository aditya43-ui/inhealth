<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'resephd-m-search',
	'type'=>'horizontal',
)); ?>

	<?php // echo $form->textFieldRow($model,'resephd_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php // echo $form->textFieldRow($model,'resephd_desc',array('class'=>'span3','maxlength'=>200)); ?>

	<?php // echo $form->checkBoxRow($model,'resephd_aktif',array('checked'=>true)); ?>
<br>
<!--<table width="100%">
    <tr>-->
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Nama Paket HD <span class='required'>*</span>","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'resephd_nama',array('class'=>'span3','maxlength'=>200)); ?>
                </div>
            </div>
            <?php // echo $form->textFieldRow($model,'resephd_nama',array('class'=>'span3','maxlength'=>200)); ?>
        
            <?php echo $form->textFieldRow($model,'resephd_desc',array('class'=>'span3','maxlength'=>50)); ?>
            
        <div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'resephd_aktif',array('checked'=>true)); ?> <label>Aktif</label>
            </div>
        </div>
        </div>
    </div>
        <!--</td>-->
<!--    </tr>
</table>-->

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
