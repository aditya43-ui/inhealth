<legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
?>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($modelLaporan, 'periodeposting_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php 
					echo $form->dropDownList($modelLaporan, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll("periodeposting_aktif = TRUE ORDER BY deskripsiperiodeposting ASC"),'periodeposting_id','deskripsiperiodeposting'), array('empty' => '-- Pilih --',
					'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm'));
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Unit Kerja', 'Unit Kerja', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    echo $form->dropDownList($modelLaporan,'ruangan_id',CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"),
                            'ruangan_id','ruangan_nama'),array('class'=>'span2','style'=>'width:140px','empty'=>'-- Pilih --')); 
                ?>
            </div>
		</div>
	</div>
</div>
    
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl($this->id.'/LaporanNeraca'), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'return refreshForm(this);')); ?>
</div>
<?php $this->endWidget(); ?>