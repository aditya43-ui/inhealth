<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagolongan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Periode Opname</label>
                <div class="controls">
                    <?= $form->textField($model,'periodeasetopname_nama',['class'=>'span3']) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'periodeasetopname_aktif',array('checked'=>'periodeasetopname_aktif')); ?> <label>Aktif</label>
                </div>
            </div>  
            
            
	</div>
	<div class="col-sm-6">                        
            <div class="control-group">
                <label class="control-label">Tanggal</label>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggal_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 
                                'class' => 'span2', 
                                'onkeypress' => "return $(this).focusNextInputField(event)", 
                                'style' => 'width:114px;'
                            ),
                        ));
                    ?>
                </div>
                <div class="controls">
                    <label>s/d</label>
                </div>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggal_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 
                                'class' => 'span2', 
                                'onkeypress' => "return $(this).focusNextInputField(event)", 
                                'style' => 'width:114px;'
                            ),
                        ));
                    ?>
                </div>
            </div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php 
    $this->endWidget();     
?>
