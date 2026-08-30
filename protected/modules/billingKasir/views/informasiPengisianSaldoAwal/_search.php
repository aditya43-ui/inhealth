<?php 
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
    'type'=>'horizontal',
    ));     
?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">		
			<?php echo CHtml::label("Tanggal Pengisian Saldo Awal",'tgl_rekam', array('class' => 'control-label')) ?>
			<div class="controls">
				<div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
					<i class="entypo-calendar"></i>
					<span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
					<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
					<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php 
            // echo $form->dropDownListRow($model,'shift_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

            ?>

<div class="control-group">
            <?php echo CHtml::label('Shift', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData($model->getShiftItems(), 'shift_id', 'shift_nama'), array('empty' => 'Pilih','class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
            </div>
        </div>
        </div>
	</div>
</div>           
<div class="form-actions">
	<?php 
		  echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="fa fa-search"></i>')),
			array('class'=>'btn btn-primary', 'type'=>'submit')); 
	?>
	<?php 
		  echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="fa fa-refresh"></i>')),
			  array('class'=>'btn btn-danger', 'type'=>'reset')); 
	?>   
	<?php 
		  $content = $this->renderPartial('tips/informasi',array(),true);
		  $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
