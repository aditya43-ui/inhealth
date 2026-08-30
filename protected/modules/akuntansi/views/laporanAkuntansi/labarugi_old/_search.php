<legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
?>

<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'periodeposting_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php 
					echo $form->dropDownList($model, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll(),'periodeposting_id','deskripsiperiodeposting'), array('empty' => '-- Pilih --',
					'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm'));
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		
	</div>
</div>
<!--<table width='100%'>
    <tr>
        <td>
        <div class="control-group">
            <?php echo $form->labelEx($model,'Periode Awal', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tgl_awal',
                    'mode'=>'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array('readonly'=>true,
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'class'=>'dtPicker3',
                    ),
                )); ?> 
            </div>
        </div>
        </td>
        <td>
        <div class="control-group">
            <?php echo $form->labelEx($model,'sampai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tgl_akhir',
                    'mode'=>'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array('readonly'=>true,
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'class'=>'dtPicker3',
                    ),
                )); ?> 
            </div>
        </div>
        </td>
    </tr>
</table>-->
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>            
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl($this->id.'/Laporanlabarugi'), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'return refreshForm(this);')); ?>
    </div>
<?php
$this->endWidget();
?>