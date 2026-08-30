<div id="divSearch-form">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		'id'=>'rencana-t-search',
		'type'=>'horizontal',
		'focus'=>'#'.CHtml::activeId($model,'nostokopnamegizi'),
    )); ?> 
	<div class="row">
		<div class="col-sm-6">
			<div class="control-group">		
				<?php echo CHtml::label("Tgl. Stok Opname",'tglstokopnamegizi', array('class' => 'control-label')) ?>
				<div class="controls">
					<div class="daterange daterange-inline input-inline span4" data-format="DD MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
						<i class="entypo-calendar"></i>
						<span ><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
						<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
						<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
					</div>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'nostokopnamegizi',array('placeholder'=>'Ketik No. Stock Opname','class'=>'angkahuruf-only span4',)); ?>
			<?php echo $form->dropDownListRow($model, 'jenisstokopnamegizi', LookupM::getItems('jenisstokopname'),array('empty'=>'-- Pilih --', 'class' => 'span4',)) ?>
		</div>               
		<div class="col-sm-6">                
			<div class = "control-group">
				<?php echo Chtml::label('Petugas Mengetahui','pegawaimengetahui_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'pegawaimengetahui_id', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --', 'class' => 'span4',)) ?>
				</div>
			</div>                                               
			<div class = "control-group">
				<?php echo Chtml::label('Petugas 1','petugas1_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'petugas1_id', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --', 'class' => 'span4',)) ?>
				</div>
			</div>                
			 <div class = "control-group">
				<?php echo Chtml::label('Petugas 2','petugas2_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'petugas2_id', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --', 'class' => 'span4',)) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); echo "&nbsp;"; ?><?php
		   $content = $this->renderPartial($this->path_view.'tips/tipsInformasi',array(),true);
		   $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
	</div>
	<?php $this->endWidget(); ?>
</div>