<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'searchLaporan',
        'type'=>'horizontal',
)); ?>
	<style>
        #penjamin label.checkbox{
            width: 200px;
            display:inline-block;
        }
        label.checkbox, label.radio{
			width:260px;
            display:inline-block;
        }
    </style>   
	<div class="row">
		<div class="col-sm-6">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<div class="control-group">
				<?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
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
		</div>  
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo Chtml::label("No. Pendaftaran",'no_pendaftaran', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model, 'no_pendaftaran', array('class'=>'span4 angkahuruf-only')) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<fieldset>
			<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'institusi',
					'slide' => true,
					'content' => array(
						'content1' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Institusi',
							'isi' => CHtml::hiddenField('filter', 'asalrujukan_id', array('disabled' => 'disabled')) . 
								'<div class="control-group">
									'.CHtml::label('Institusi','asalrujukan_id', array('class' => 'control-label')).' 
									<div class="controls">
										'.$form->dropDownList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true ORDER BY asalrujukan_nama ASC'), 'asalrujukan_id', 'asalrujukan_nama'),array(
										'class'=>'form-control', 'multiple'=>'multiple')).'											
									</div>
								</div>
								<div class="control-group">
									'.CHtml::label('Perujuk','namaperujuk', array('class' => 'control-label')).' 
									<div class="controls">												 
										'.$form->dropDownList($model,'namaperujuk',
											array(),
											array('class'=>'form-control', 'multiple'=>'multiple')).' 													
									</div>
								</div>',
							'active' => true,
						),
					),
				));
			?>
			</fieldset>
		</div>
	</div>
                                                      
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
</div>
<script>
function checkAllPerujuk(){
    if($('#checkAllRujukan').is(':checked')){
       $('#searchLaporan input[name*="namaperujuk"]').each(function(){
            $(this).attr('checked',true);
       });
    }else{
         $('#searchLaporan input[name*="namaperujuk"]').each(function(){
            $(this).removeAttr('checked');
       });
    }
}
</script>