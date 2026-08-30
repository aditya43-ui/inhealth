<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(LBPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
		echo $form->hiddenField($modPasienMasukPenunjang,'pegawai_id', array('readonly' => true, 'class' => 'required'));
					
			$this->widget('MyJuiAutoComplete', array(
				'model'=>$modPasienMasukPenunjang,
				'attribute'=>'pegawai_nama',
				'source'=>'js: function(request, response) {
					$.ajax({
					url: "'.$this->createUrl('/ActionAutoComplete/dropDokterRuangan').'",
					dataType: "json",
					data: {
						term: request.term,
						ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
					},
					success: function (data) {
						response(data);
					}
				})
			}',
			'options'=>array(
				'showAnim'=>'fold',
				'minLength' => 0,
				'focus'=> 'js:function( event, ui ) {
					 $(this).val( ui.item.label);
					 return false;
				 }',
				'select'=>'js:function( event, ui ) {
					 $("#'.CHtml::ActiveId($modPasienMasukPenunjang, 'pegawai_id').'").val(ui.item.value); 
					 return false;
				 }',
			),		
			'htmlOptions' => array('class'=>'span3 required')	
			)); 
		
		?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Analis Lab','perawat_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php //echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
		echo $form->hiddenField($modPasienMasukPenunjang,'perawat_id', array('readonly' => true));
		
			$this->widget('MyJuiAutoComplete', array(
				'model'=>$modPasienMasukPenunjang,
				'attribute'=>'perawat_nama',
				'source'=>'js: function(request, response) {
					$.ajax({
					url: "'.$this->createUrl('/ActionAutoComplete/dropPerawatRuangan').'",
					dataType: "json",
					data: {
						term: request.term,
						ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
					},
					success: function (data) {
						response(data);
					}
				})
			}',
			'options'=>array(
				'showAnim'=>'fold',
				'minLength' => 0,
				'focus'=> 'js:function( event, ui ) {
					 $(this).val( ui.item.label);
					 return false;
				 }',
				'select'=>'js:function( event, ui ) {
					 $("#'.CHtml::ActiveId($modPasienMasukPenunjang, 'perawat_id').'").val(ui.item.value); 
					 return false;
				 }',
			),		
			'htmlOptions' => array('class'=>'span3')	
			)); 
		
		?>
    </div>
</div>

