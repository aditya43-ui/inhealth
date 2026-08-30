<div class="row" id="rowfuild-treadmill">
	<div class="span12">
		<div id="form-input">
			<div class="control-group">
				<?php echo $form->LabelEx($modTreadmill,'duration_treadmill',array('class'=>'control-label'));?>
				<div class="controls">
					 <?php echo $form->dropDownList($modTreadmill,'duration_treadmill',CHtml::listData(KlasifikasifitnesM::model()->findAll(), 'klasifikasifitnes_id', 'lama_menit'),
															  array('style'=>'width:70px;','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>	
			<div class="control-group">
				<?php echo $form->LabelEx($modTreadmill,'blood_preasure',array('class'=>'control-label'));?>
				<div class="controls">
				 <?php
					$this->widget('CMaskedTextField', array(
					'model' => $modTreadmill,
					'attribute' => 'td_systolic',
					'mask' => '999',
					'placeholder'=>'0',
					'htmlOptions' => array('class'=>'span1 numbers-only systolic', 'onkeypress'=>"return $(this).focusNextInputField(event)",'onkeyup'=>'returnValue(this); getText();', 'onblur'=>'setRange(this);') // change(this); getTekananDarah(this) change(this);getText();
					));
				?> /
					<?php // echo $form->textField($modPemeriksaanFisik,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 integer numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));?>
				 <?php
						$this->widget('CMaskedTextField', array(
						'model' => $modTreadmill,
						'attribute' => 'td_diastolic',
						'mask' => '999',
						'placeholder'=>'0',
						'htmlOptions' => array('class'=>'span1 numbers-only diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onkeyup'=>'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
						));
				?> mmHg
				<?php // echo $form->textField($modPemeriksaanFisik,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));?>			
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->LabelEx($modTreadmill,'heart_rate',array('class'=>'control-label'));?>
				<div class="controls">
					<?php echo $form->textField($modTreadmill,'heart_rate',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));?>
					<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
											array('onclick'=>'tambahTreadmill();return false;',
												  'id'=>'btn-input',
												  'class' => 'btn btn-danger',
												  'onkeypress'=>"tambahTreadmill();return false;",
												  'rel'=>"tooltip",
												  'title'=>"Klik untuk menambahkan Treadmill",
												  'disabled'=>true,)); ?>
				</div>
			</div>
		</div>

		<br>
		<div class="block-tabel">
		<h6>Tabel <b>Detail Treadmill</b></h6>
			<table id="form-treadmilldetail-mcu" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Duration</th>
						<th>Blood Preasure</th>
						<th>Heart Rate</th>
						<th>Work Load</th>
						<th>Est. 02 Rate</th>
						<th>Max. 02 Intake</th>
						<th>Mets</th>
						<th>Fitness Clasification</th>
						<th>Walking</th>
						<th>Jogging</th>
						<th>Bicycling</th>
						<th>Other Sport</th>
						<?php echo !isset($_GET['id'])?'<th>Batal</th>':''; ?>
					</tr>
				</thead>
				<tbody>
					<?php
					if(isset($_GET['id'])){
						if(count((array)$modTreadmillDetail)>0){
							foreach($modTreadmillDetail as $key => $treadmilldetail){
								echo $this->renderPartial('_rowTreadmill', array('modTreadmillDetail'=>$treadmilldetail), true);
							}
						}
					}
					?>
				</tbody>
			</table>
		</div>
		<br>
		
	</div>
</div>
<div class="row box2" id="rowfuild-treadmill2">
	<div class="col-sm-6">
		<br>
		<div class="control-group">
			<?php echo $form->LabelEx($modTreadmill,'resttime_menit',array('class'=>'control-label'));?>
			<div class="controls">
				<?php echo $form->textField($modTreadmill,'resttime_menit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> /min
			</div>
		</div>		
		<div class="control-group">
			<?php echo $form->LabelEx($modTreadmill,'worktime_menit',array('class'=>'control-label'));?>
			<div class="controls">
				<?php echo $form->textField($modTreadmill,'worktime_menit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> /min
			</div>
		</div>		
		<div class="control-group">
			<?php echo $form->LabelEx($modTreadmill,'recoverytime_menit',array('class'=>'control-label'));?>
			<div class="controls">
				<?php echo $form->textField($modTreadmill,'recoverytime_menit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> /min
			</div>
		</div>		
		<div class="control-group">
			<?php echo $form->LabelEx($modTreadmill,'totaltime_menit',array('class'=>'control-label'));?>
			<div class="controls">
				<?php echo $form->textField($modTreadmill,'totaltime_menit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> /min
			</div>
		</div>		
	</div>
	<div class="col-sm-6">
		<br>
		<div class="control-group">
			<?php echo $form->LabelEx($modTreadmill,'interpretation_tradmill',array('class'=>'control-label'));?>
			<div class="controls">
					<?php echo $form->textArea($modTreadmill,'interpretation_tradmill',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			</div>
		</div>	
		<div class="control-group">
			<?php echo $form->LabelEx($modTreadmill,'namapemeriksa_treadmill',array('class'=>'control-label'));?>
			<div class="controls">
					<?php $this->widget('MyJuiAutoComplete',array(
									  'model'=>$modTreadmill,
									  'attribute'=>'namapemeriksa_treadmill',
									  'value'=>'',
									  'sourceUrl'=> $this->createUrl('AutocompletePemeriksa'),
									  'options'=>array(
											 'showAnim'=>'fold',
											 'minLength' => 2,
											 'focus'=> 'js:function( event, ui ) {
													  $(this).val( ui.item.nama_pegawai);
													  return false;
											  }',
									  ),
			  )); ?>
					<?php // echo $form->textField($modTreadmill,'namapemeriksa_treadmill',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			</div>
		</div>	
		<div class="control-group">
			<?php // echo $form->LabelEx($modTreadmill,'hasiltreadmill',array('class'=>'control-label'));?>
			<!--<div class="controls">-->
					<?php echo $form->radioButtonListInlineRow($modTreadmill, 'hasiltreadmill', array('Normal'=>'Normal', 'Ada Kelainan'=>'Ada Kelainan'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			<!--</div>-->
		</div>	
	</div>
</div>

<script type="text/javascript">

</script>
