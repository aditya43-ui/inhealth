<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rencana-t-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'nopermintaan'),
)); ?>
	<div class="row-fluid">
		<div class="col-sm-6">
			<div class="control-group">		
				<?php echo CHtml::label("Tanggal Permintaan",'tglpermintaanpembelian', array('class' => 'control-label')) ?>
				<div class="controls">
					<div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
						<i class="entypo-calendar"></i>
						<span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
						<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
						<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
					</div>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'nopermintaan',array('placeholder'=>'Ketik No. Permintaan','class'=>'angkahuruf-only','class'=>'span3')); ?>
                    
                    <div class = "control-group">
				<?php echo CHtml::label('Sumber Dana', 'sumberdana_id', array('class'=>'control-label')) ?>
				<div class = "controls">
					<?php echo $form->dropDownList($model, 'sumberdana_id', Chtml::ListData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE"),'sumberdana_id','sumberdana_nama'),array('empty'=>'-- Pilih --','class'=>'span3'))?>
				</div>
			</div>
                    <div class="control-group ">
				<?php echo $form->labelEx($model,'statuspembelian', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'statuspembelian',LookupM::getItems('statuspembelian'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="control-group ">
				<?php echo CHtml::label('Jenis PPh','', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'pajak_id',CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
				</div>
			</div>
			<?php // echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->getRuanganByInstalasi(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
//				array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
//				'empty'=>'-- Pilih --')); ?>
			<?php echo $form->dropDownListRow($model,'supplier_id',
				CHtml::listData(SupplierM::model()->getSupplierFarmasiItems(), 'supplier_id', 'supplier_nama'),
				array('class'=>'span3 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event)",
				'empty'=>'-- Pilih --')); ?>	
                    <div class="control-group ">
                        <?php echo CHtml::label('Permintaan Uang Muka','', array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php echo $form->dropDownList($model,'statuspermintaanuangmuka',array(1=>'Ada',2=>'Tidak Ada'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
                        </div>
                    </div>
		</div>
	</div>   
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			Yii::app()->createUrl($this->module->id.'index',array('modul_id'=>Yii::app()->session['modul_id'])), 
			array('class'=>'btn btn-danger',
			'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
        ?>
		<?php
			$tips = array(
				'0' => 'tanggal',
				'1' => 'ubah',
				'2' => 'terima',
				'3' => 'detail',
				'4' => 'cari',
				'5' => 'ulang2'
			);
			$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
    </div>
	<?php $this->endWidget(); ?>
</div>