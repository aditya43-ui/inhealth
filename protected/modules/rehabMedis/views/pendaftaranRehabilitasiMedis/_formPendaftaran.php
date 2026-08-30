<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
    <?php 
	if(Yii::app()->user->getState('tgltransaksimundur')){
	?>
		<div class="control-group">
			<?php echo $form->labelEx($model,'tgl_pendaftaran', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php
				$model->tgl_pendaftaran = (!empty($model->tgl_pendaftaran) ? date("d/m/Y H:i:s",strtotime($model->tgl_pendaftaran)) : date("d/m/Y H:i:s"));
				$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_pendaftaran',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
									'maxDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
				)); 
				?>
			</div>
		</div>
	<?php
	}else{ 
		echo $form->textFieldRow($model,'tgl_pendaftaran',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
	}
	?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'tglrenkontrol', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php   
                $model->tglrenkontrol = (!empty($model->tglrenkontrol) ? date("d/m/Y H:i:s",strtotime($model->tglrenkontrol)) : null);
                $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tglrenkontrol',
                                'mode'=>'datetime',
                                'options'=> array(
    //                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'minDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'span3 dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'00/00/0000 00:00:00'),
            )); ?>
            <?php echo $form->error($model, 'tglrenkontrol'); ?>
        </div>
    </div>
    <div class='control-group'>
        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
        <div class='controls'>
            <div class="checkbox inline">
                <?php echo $form->checkBox($model,'kunjunganrumah', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <!--<i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>-->
                <?php echo CHtml::activeLabel($model, 'kunjunganrumah'); ?> 
            </div>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label refreshable')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'style' => 'width:170px;'
            ));
            ?>
            <?php echo $form->error($model, 'carabayar_id'); ?>
        </div>
        <div class="controls cekBPJS hidden">
                <?php echo $form->checkBox($model, 'is_bpjs_manual', array('onclick' => 'bpjsManual()', 'uncheckedvalue' => 0, 'class' => 'permanent'))."Non Bridging BPJS"; ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'penjamin_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'penjamin_id', empty($model->carabayar_id) ? array() : CHtml::listData($modPasien->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
                'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'style' => 'width:170px;'
            ));
            ?>
            <?php echo $form->error($model, 'penjamin_id'); ?>
        </div>
    </div>
	<!-- <div class="control-group">
		<?php //echo $form->labelEx($model,'carabayar_id', array('class'=>'control-label refreshable')) ?>
		<div class="controls">
			<?php //echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
//                                                     'ajax' => array('type'=>'POST',
//                                                         'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
// //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
//                                                         'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data);setKarcis(0);setKarcis(1);}',
//                                                     ),
//                                                     'onchange'=>'setFormAsuransi(this.value);',
//                                                     'class'=>'span3',
// 			)); ?>
		</div>
	</div>     -->
    <?php //echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onchange'=>'setKarcis(0);setKarcis(1);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>

    