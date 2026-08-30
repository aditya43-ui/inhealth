<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">
			Laporan Barber-Johnson
		</div>
	</div>
	<div class="panel-body">
		<div class="search-form">
			<?php
			$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
				'action' => Yii::app()->createUrl($this->route),
				'method' => 'get',
				'type' => 'horizontal',
				'id' => 'searchLaporan',
				'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
			));

			$format = new MyFormatter();
			?>
			<style>
				table{
					margin-bottom: 0;
				}
				.form-actions{
					padding:4px;
					margin-top:5px;
				}
				.nav-tabs>li>a{display:block; cursor:pointer;}
				.nav-tabs > .active a:hover{cursor:pointer;}

				#penjamin label.checkbox{
					width: 100px;
					display:inline-block;
				}
			</style>

			<?php //echo CHtml::hiddenField('type', ''); ?>
			<?php //echo CHtml::hiddenField('src', ''); ?>
				<div class="col-sm-6">
					<?php echo CHtml::hiddenField('type', ''); ?>
					<?php /*
						<div class="control-group">
								<?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
								<div class="controls">
										<div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
												<i class="entypo-calendar"></i>
												<span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
												<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
												<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
										</div>
								</div>
						</div>
					 * 
					 */ ?>
						<div class="control-group">
								<?php echo CHtml::label("Tahun Periode",'tahun', array('class' => 'control-label')) ?>
								<div class="controls">
									<?php 
									$tahun = array();
									
									for ($i = 2018; $i <= date('Y'); $i++) {
										$tahun[$i] = $i;
									}
									
									echo $form->dropDownList($model, 'tahun', $tahun); ?>
								</div>
						</div>

				</div>
			
			<div class="clear"></div>
			<div class="form-actions">
				<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
				<?php
					echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
					'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
				?>
			</div>
			<hr>
			<?php $this->renderPartial('_line', array('model' => $model, 'dataBarLineChart' => $result,
				)); ?>
			
			<?php $this->endWidget(); ?>
		</div>  
	</div>
</div>
