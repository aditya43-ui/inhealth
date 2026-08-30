
<legend class="rim">Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'GET',
	'id'=>'infoRencanaPenerimaan-search-form',
	'type'=>'horizontal',
)); ?>
<fieldset>
<div class="row">
	<div class="col-sm-4">
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Pengajuan','tgl_awalPengajuan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
					$modKlaimPiutang->tgl_awalPengajuan = MyFormatter::formatDateTimeForUser($modKlaimPiutang->tgl_awalPengajuan);
					$this->widget('MyDateTimePicker',array(
									'model'=>$modKlaimPiutang,
									'attribute'=>'tgl_awalPengajuan',
									'mode'=>'date',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
									),
				)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sampai Dengan','tgl_akhirPengajuan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
					$modKlaimPiutang->tgl_akhirPengajuan = MyFormatter::formatDateTimeForUser($modKlaimPiutang->tgl_akhirPengajuan);
					$this->widget('MyDateTimePicker',array(
									'model'=>$modKlaimPiutang,
									'attribute'=>'tgl_akhirPengajuan',
									'mode'=>'date',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
									),
				)); ?>
			</div>
		</div> 
	</div>
	<div class="col-sm-4">
		<div class="control-group">
			<label class="control-label">
				<?php echo CHtml::checkBox('berdasarkanJatuhTempo','',array('uncheckValue'=>0,'onClick'=>'cekTanggal()')); ?>
				Tanggal Jatuh Tempo
			</label>
			<div class="controls">
				<?php   
					$modKlaimPiutang->tgl_awalJatuhTempo = MyFormatter::formatDateTimeForUser($modKlaimPiutang->tgl_awalJatuhTempo);
					$this->widget('MyDateTimePicker',array(
									'model'=>$modKlaimPiutang,
									'attribute'=>'tgl_awalJatuhTempo',
									'mode'=>'datetime',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
									),
				)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sampai Dengan','tgl_akhirJatuhTempo', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
					$modKlaimPiutang->tgl_akhirJatuhTempo = MyFormatter::formatDateTimeForUser($modKlaimPiutang->tgl_akhirJatuhTempo);
						$this->widget('MyDateTimePicker',array(
										'model'=>$modKlaimPiutang,
										'attribute'=>'tgl_akhirJatuhTempo',
										'mode'=>'datetime',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
					)); ?>
				</div>
		</div> 
	</div>
	<div class="col-sm-4">
		<div class="control-group">
			<?php echo CHtml::label('Jenis Penjamin', 'cara bayar',array('class'=>'control-label')); ?>
			<div class="controls">
					<?php 
						echo CHtml::activeDropDownList($modKlaimPiutang,'carabayar_id', CHtml::listData($modKlaimPiutang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,
									array('style'=>'width:120px;','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
											'ajax' => array('type'=>'POST',
												'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'KUPengajuanklaimpiutangT')), 
											'update'=>'#KUPengajuanklaimpiutangT_penjamin_id'  //selector to update
									),
						)); 
					?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Penjamin', 'penjamin',array('class'=>'control-label')); ?>
			<div class="controls">
					<?php 
						echo CHtml::activeDropDownList($modKlaimPiutang,'penjamin_id', CHtml::listData($modKlaimPiutang->getPenjaminItems($modKlaimPiutang->carabayar_id), 
								'penjamin_id', 'penjamin_nama') ,array('style'=>'width:120px;','empty'=>'-- Pilih --',
											'onkeypress'=>"return $(this).focusNextInputField(event)",)); 
					?> 
			</div>
		</div>
	</div>
</div>
</fieldset>

<div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
        <?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
); ?>
</div>
<?php $this->endWidget(); ?>

<script>
document.getElementById('KUPengajuanklaimpiutangT_tgl_awalJatuhTempo_date').setAttribute("style","display:none;");
document.getElementById('KUPengajuanklaimpiutangT_tgl_akhirJatuhTempo_date').setAttribute("style","display:none;");
	function cekTanggal(){
    var checklist = $('#berdasarkanJatuhTempo');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('KUPengajuanklaimpiutangT_tgl_awalJatuhTempo_date').setAttribute("style","display:block;");
        document.getElementById('KUPengajuanklaimpiutangT_tgl_akhirJatuhTempo_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('KUPengajuanklaimpiutangT_tgl_awalJatuhTempo_date').setAttribute("style","display:none;");
        document.getElementById('KUPengajuanklaimpiutangT_tgl_akhirJatuhTempo_date').setAttribute("style","display:none;");
    }
	}  
</script>
