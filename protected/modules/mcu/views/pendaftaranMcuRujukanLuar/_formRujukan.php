<div class="control-group">
    <?php echo CHtml::label('Rumah Sakit Tujuan','rujukankeluar_id', array('class'=>'control-label refreshable required')) ?>
    <div class="controls">
    <?php echo $form->dropDownList($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanKeluarItems(), 'rujukankeluar_id', 'rumahsakitrujukan'), 
                                      array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->error($modRujukanKeluar, 'rujukankeluar_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukanKeluar,'nosuratrujukan', array('placeholder'=>'Nomor Surat Rujukan','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanKeluar,'tgldirujuk', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
				$modRujukanKeluar->tgldirujuk = (!empty($modRujukanKeluar->tgldirujuk) ? date("d/m/Y",strtotime($modRujukanKeluar->tgldirujuk)) : null);
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modRujukanKeluar,
                                'attribute'=>'tgldirujuk',
                                'mode'=>'date',
                                'options'=> array(
                                    'showOn' => false,
                                    //'maxDate' => 'd',
								'onkeyup'=>"js:function(){setTglAkhir(this.value);}",
								'onSelect'=>'js:function(){setTglAkhir(this.value);}',
                                ),
                                'htmlOptions'=>array('onblur'=>'setTglAkhir(this.value);','placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modRujukanKeluar, 'tgldirujuk'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Dokter Perujuk','pegawai_id', array('class'=>'control-label refreshable required')) ?>
    <div class="controls">
    <?php echo $form->dropDownList($model,'pegawai_id', CHtml::listData($model->getDokterItems(), 'pegawai_id', 'NamaLengkap'), 
                                      array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->error($modRujukanKeluar, 'pegawai_id'); ?>
    </div>
</div>
<?php echo $form->textAreaRow($modRujukanKeluar,'alasandirujuk', array('placeholder'=>'Nomor Surat Rujukan','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanKeluar,'tglberlakusurat', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
				$modRujukanKeluar->tglberlakusurat = (!empty($modRujukanKeluar->tglberlakusurat) ? date("d/m/Y",strtotime($modRujukanKeluar->tglberlakusurat)) : null);
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modRujukanKeluar,
                                'attribute'=>'tglberlakusurat',
                                'mode'=>'date',
                                'options'=> array(
                                    'showOn' => false,
                                    //'maxDate' => 'd',
									'onkeyup'=>"js:function(){setTglAkhir(this.value);}",
									'onSelect'=>'js:function(){setTglAkhir(this.value);}',
                                ),
                                'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask','onblur'=>'setTglAkhir(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modRujukanKeluar, 'tgldirujuk'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukanKeluar,'sampaidengan', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
			$modRujukanKeluar->sampaidengan = (!empty($modRujukanKeluar->sampaidengan) ? date("d/m/Y",strtotime($modRujukanKeluar->sampaidengan)) : null);
			$this->widget('MyDateTimePicker',array(
				'model'=>$modRujukanKeluar,
				'attribute'=>'sampaidengan',
				'mode'=>'date',
				'options'=> array(
					'showOn' => false,
					//'maxDate' => 'd',
				),
				'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modRujukanKeluar, 'tgldirujuk'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Jumlah Lampiran','lampiransurat', array('class'=>'control-label refreshable required')) ?>
    <div class="controls">
	    <?php echo $form->textField($modRujukanKeluar,'lampiransurat', array('placeholder'=>'Jumlah Lampiran','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    </div>
</div>

