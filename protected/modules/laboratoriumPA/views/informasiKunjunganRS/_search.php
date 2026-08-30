<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
        'htmlOptions'=>array(),

)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">		
            <?php echo CHtml::label("Tanggal Kunjungan",'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>		
		<?php echo $form->textFieldRow($model,'no_rekam_medik',array('autofocus'=>true, 'class'=>'span3 numbers-only','maxlength'=>8,'onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik no. rekam medik')); ?>
		<?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik no. pendaftaran')); ?>
		<?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik nama pasien')); ?>
		<?php //echo $form->textFieldRow($model,'alias',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Alias')); ?>
		<?php 
			$carabayar = CarabayarM::model()->findAll(array(
				'condition'=>'carabayar_aktif = true',
				'order'=>'carabayar_nourut',
			));
			foreach ($carabayar as $idx=>$item) {
				$penjamins = PenjaminpasienM::model()->findByAttributes(array(
					'carabayar_id'=>$item->carabayar_id,
					'penjamin_aktif'=>true,
			   ));
			   if (empty($penjamins)) unset($carabayar[$idx]);
			}
			$penjamin = PenjaminpasienM::model()->findAll(array(
				'condition'=>'penjamin_aktif = true',
				'order'=>'penjamin_nama',
			));
			echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
				'empty'=>'-- Pilih --',
				'class'=>'span3', 
				'ajax' => array('type'=>'POST',
					'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
					'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
				),
			 ));
			echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

		?>
	</div>
	<div class="col-sm-6">

		<div class="control-group ">
			<?php echo CHtml::label('Dokter Penanggung Jawab','Dokter Penanggung Jawab', array('class'=>'control-label inline')) ?>
			<div class="controls">
				<?php   
					echo $form->dropDownList($model,'nama_pegawai',CHtml::listData(DokterV::model()->findAll(" pegawai_aktif = true ORDER BY nama_pegawai ASC "), 'nama_pegawai', 'namaLengkap'),array('empty'=>'--Pilih--','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
				?>

			</div>
		</div>	
		 <?php
			$instalasi = InstalasiM::model()->findAllByAttributes(array(
				'instalasi_id' => array(2,3,4),
			));
			$ruangan = RuanganM::model()->findAllByAttributes(array(
				'instalasi_id' => array(2,3,4),
				'ruangan_aktif' => true,
			), array(
				'order'=>'instalasi_id, ruangan_nama',
			));
			echo $form->dropDownListRow($model,'instalasi_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
				'empty'=>'-- Pilih --',
				'class'=>'span3', 
				'onchange' => 'setClearDropdownRuangan();',
				'ajax' => array('type'=>'POST',
					'url'=> $this->createUrl('/ActionDynamic/getRuanganDariInstalasi',array('encode'=>false,'namaModel'=>get_class($model))), 
					'success'=>'function(data){$("#'.CHtml::activeId($model, "ruangan_id").'").html(data); }',
				),
			 ));
			echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

			echo $form->dropDownListRow($model,'statusperiksa',  Params::statusPeriksa(),array('empty'=>'-- Pilih --', 'class'=>'span3',))
		?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
			array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
						Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	<?php $content = $this->renderPartial('laboratoriumPA.views.informasiKunjunganRS.tips.tipsInformasiKunjunganRS',array(),true);
					$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));    ?>			
</div>
    
<?php $this->endWidget();?>

<script type="text/javascript">	
/** bersihkan dropdown ruangan */
function setClearDropdownRuangan()
{
    $("#<?php echo CHtml::activeId($model,"ruangan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

</script>