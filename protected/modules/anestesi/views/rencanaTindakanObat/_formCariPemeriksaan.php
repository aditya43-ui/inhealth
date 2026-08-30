<div id="form-caripemeriksaan" class="form-horizontal box">
	<?php echo CHtml::activeHiddenField($modPemeriksaanAnestesi, 'ruangan_id',array('readonly'=>true,'class'=>'span3')); ?>
	<?php echo CHtml::activeHiddenField($modPemeriksaanAnestesi, 'penjamin_id',array('readonly'=>true,'class'=>'span3')); ?>
	<?php echo CHtml::activeHiddenField($modPemeriksaanAnestesi, 'kelaspelayanan_id',array('readonly'=>true,'class'=>'span3')); ?>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group" style="float:left;">
				<?php echo CHtml::activeLabel($modPemeriksaanAnestesi, 'Jenis Anestesi',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPemeriksaanAnestesi, 'jenisanastesi_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanAnestesi();",)); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group" style="float:left;">
				<?php echo CHtml::activeLabel($modPemeriksaanAnestesi, 'Anestesi',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPemeriksaanAnestesi, 'anastesi_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanAnestesi();",)); ?>
				</div>
			</div>
		</div>
		<div style="float:right;">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button',"onclick"=>"updateChecklistPemeriksaanAnestesi();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari pemeriksaan')); ?>
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanAnestesiReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang pemeriksaan')); ?>
		</div>
	</div>
</div>