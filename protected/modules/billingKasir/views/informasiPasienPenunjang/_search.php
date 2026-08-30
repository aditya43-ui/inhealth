<?php 
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
        'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
        'type'=>'horizontal',
    ));     
?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">		
			<?php echo CHtml::label("Tanggal Pendaftaran",'tgl_rekam', array('class' => 'control-label')) ?>
			<div class="controls">
				<div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
					<i class="entypo-calendar"></i>
					<span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
					<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
					<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
				</div>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3', 'maxlength'=>50)); ?>
		</div>
		<div class="control-group">
			<?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik nama pasien','class'=>'span3', 'maxlength'=>50)); ?>
		</div>
        <div class="control-group">
                    <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span3 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                    </div>
                </div>
		<div class="control-group">
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik no. pendaftaran','class'=>'span3', 'maxlength'=>20)); ?>       
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php 
            $sp = LookupM::getItems('statusperiksa');
            unset($sp['BATAL PERIKSA'], $sp['SEDANG DIRAWAT INAP']);
            
            $carabayar = CarabayarM::model()->findAll(array(
                'condition'=>'carabayar_aktif = true',
                'order'=>'carabayar_nourut',
            ));
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition'=>'penjamin_aktif = true',
                'order'=>'penjamin_nama',
            ));
            
            $pegawai = DokterV::model()->findAllByAttributes(array(
                'pegawai_aktif'=>true,
            ), array(
                'order'=>'nama_pegawai',
            ));
            foreach ($carabayar as $idx=>$item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                    'carabayar_id'=>$item->carabayar_id,
                    'penjamin_aktif'=>true,
               ));
               if (empty($penjamins)) unset($carabayar[$idx]);
            }
            
            
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
            <?php echo $form->dropDownListRow($model,'ruangan_id', Chtml::listData(RuanganM::model()->findAllByAttributes(array(
                'instalasi_id'=>array(5, 6, Params::INSTALASI_ID_REHAB, Params::INSTALASI_ID_JZ), 'ruangan_aktif'=>true,
            ), array('order'=>'ruangan_nama')),'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
            <?php echo $form->dropDownListRow($model,'pegawai_id', CHtml::listData($pegawai, 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            <?php //echo $form->dropDownListRow($model,'statusperiksa', $sp, array('options' => array('SUDAH DI PERIKSA'=>array('selected'=>true)), 'class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'statusperiksa', $sp, array('empty'=>'-- Pilih --','class'=>'span3')); ?>
            <?php // echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); ?>      
		</div>
	</div>
</div>           
<div class="form-actions">
	<?php 
		  echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
			array('class'=>'btn btn-primary', 'type'=>'submit')); 
	?>
	<?php 
		  echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
			  array('class'=>'btn btn-danger', 'type'=>'reset')); 
	?>   
	<?php 
		  $content = $this->renderPartial('laboratorium.views.tips.informasi_pencarian',array(),true);
		  $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
