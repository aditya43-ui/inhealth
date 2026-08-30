
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'resephd-m-search',
	'type'=>'horizontal',
)); ?>
<br>
<!--<table width="100%">
    <tr>-->
    <div class="row-fluid">
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'shift_hd_nama',array('class'=>'span3','maxlength'=>200)); ?>
        
            <?php echo $form->textFieldRow($model,'shift_hd_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
            
            <?php echo $form->textFieldRow($model,'shift_hd_urutan',array('class'=>'span3 integer','maxlength'=>50)); ?>
        
<!--        <div class="control-group">
            <label class="control-label">Jam Awal Shift</label>
            <div class="controls">
                <?php   
//                    $model->shift_hd_jamawal = (!empty($model->shift_hd_jamawal) ? date('H:i:s', strtotime($model->shift_hd_jamawal)) : '00:00:00');
//                    $this->widget('MyDateTimePicker',array(
//                    'model'=>$model,
//                    'attribute'=>'shift_hd_jamawal',
//                    'mode'=>'time',
//                    'options'=> array(
//                            'showOn' => false,
//                            'maxDate' => 'd',
//                            'yearRange'=> "-150:+0",
//                    ),
//                    'htmlOptions'=>array('placeholder'=>"00:00:00", 'readonly'=>true, 'class'=>'dtPicker2 datemask', 'style'=>'width: 150px;'),
//                )); 
                ?>
            </div>
        </div>-->
<!--        <div class="control-group">
            <label class="control-label">Jam Akhir Shift</label>
            <div class="controls">
                //<?php   
////                    $model->shift_hd_jamakhir = (!empty($model->shift_hd_jamakhir) ? date('H:i:s', strtotime($model->shift_hd_jamakhir)) : '00:00:00');
//                    $this->widget('MyDateTimePicker',array(
//                    'model'=>$model,
//                    'attribute'=>'shift_hd_jamakhir',
//                    'mode'=>'time',
//                    'options'=> array(
//                            'showOn' => false,
//                            'maxDate' => 'd',
//                            'yearRange'=> "-150:+0",
//                    ),
//                    'htmlOptions'=>array('placeholder'=>"00:00:00", 'readonly'=>true, 'class'=>'dtPicker2 datemask', 'style'=>'width:150px;'),
//                )); 
//
//                ?>
            </div>
        </div>-->
            
        <div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'shift_hd_aktif',array('checked'=>true)); ?> <label>Aktif</label>
            </div>
        </div>
        </div>
    </div>
        <!--</td>-->
<!--    </tr>
</table>-->

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
