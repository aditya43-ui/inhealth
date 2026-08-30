<div class="row-fluid">
<div class="span6">
	<div class="control-group ">
		<?php echo CHtml::activeLabel($modPascaAnestesi, 'Instalasi  <span class=required>*</span>', array('class' => 'control-label required')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modPascaAnestesi,'instalasipasca_id', CHtml::listData($modPraAnestesi->InstalasiItems, 'instalasi_id', 'instalasi_nama') ,
					array('empty'=>'-- Pilih --',
				  'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
				  'ajax'=>array(
						'type'=>'POST',
						'url'=>$this->createUrl('SetDropDownRuangan',array('encode'=>false,'namaModel'=>get_class($modPascaAnestesi))),
						'update'=>'#'.CHtml::activeId($modPascaAnestesi, 'ruanganpasca_id'),
						)));?>
		</div>
	</div>
	<div class="control-group ">
		<?php echo CHtml::activeLabel($modPascaAnestesi, 'Ruangan <span class=required>*</span>', array('class' => 'control-label required')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modPascaAnestesi,'ruanganpasca_id', !empty($modPascaAnestesi->instalasipasca_id) ? CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$modPascaAnestesi->instalasipasca_id,'ruangan_aktif'=>true)),'ruangan_id','ruangan_nama') : array() ,
                            array('empty'=>'-- Pilih --',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'span2',
								'ajax'=>array(
									'type'=>'POST',
									'url'=>$this->createUrl('SetDropDownKamarKosong',array('encode'=>false,'namaModel'=>get_class($modPascaAnestesi))),
									'update'=>'#'.CHtml::activeId($modPascaAnestesi, 'kamarruangan_id'),
									)
                              )); ?>
		</div>
	</div>
	
    
</div>
<div class="span6">
    <div class="control-group">
		<?php echo CHtml::activelabel($modPascaAnestesi,'Kamar Ruangan <font style="color:red;">*</font>',array('class'=>'control-label required'));?>
        <div class='controls'>
            <?php echo $form->dropDownList($modPascaAnestesi,'kamarruangan_id', !empty($modPascaAnestesi->ruanganpasca_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$modPascaAnestesi->ruanganpasca_id,'kamarruangan_status'=>true)),'kamarruangan_id','KamarDanTempatTidur') : array() ,
                            array('empty'=>'-- Pilih --',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'span2',
                              )); ?>
        </div>
    </div>	
	<div class="control-group ">
		<?php echo $form->label($modPascaAnestesi, 'perawatruangan_id', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($modPascaAnestesi,'perawatruangan_id', CHtml::listData($modPraAnestesi->ParamedisItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
		</div>
	</div>
</div>
</div>