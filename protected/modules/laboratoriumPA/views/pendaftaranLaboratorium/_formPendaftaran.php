<div class="box2">
    <?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php 
	if(Yii::app()->user->getState('tgltransaksimundur')){
	?>
		<div class="control-group ">
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
		echo $form->textFieldRow($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
	}
	?>
    <div class='control-group'>
        <div class='controls'>
            <div class="checkbox inline" style="margin-left: 124px;">
                <?php echo $form->checkBox($model, 'kunjunganrumah', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <!--<i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>-->
                <?php echo CHtml::activeLabel($model, 'kunjunganrumah'); ?> 
            </div>
        </div>
    </div>

    <div class='control-group'>
        <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label refreshable')); ?>
        <div class='controls'>
            <?php
            echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array('type' => 'POST',
                    'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                    //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);setKarcis(0);setKarcis(1);}',
                ),
                'onchange' => 'setFormAsuransi(this.value); cekCaraBayarBadak(this.value);',
                'class' => 'span3',
            ));
            ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onchange' => 'setKarcis(0);setKarcis(1); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
</div>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asuransi',
            'content'=>array(
                'content-asuransi'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Asuransi')).'<b> Asuransi</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_formAsuransi',array(
                            'form'=>$form,
							'model'=>$model,
							'modPasien'=>$modPasien,
                            'modAsuransiPasien'=>$modAsuransiPasien,
                            ),true),
                    'active'=>false,
                ),   
            ),
    )); ?>
	<?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asubadak',
            'content'=>array(
                'content-asubadak'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>$this->renderPartial($this->path_viewPPRJ.'_formAsuransiBadak',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                            ),true),
                    'active'=>$model->is_asubadak,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asubadak)?'':'display:none')),
    )); 
	?>
    <?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asudepartemen',
            'content'=>array(
                'content-asudepartemen'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi Departemen </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>
					$this->renderPartial($this->path_viewPPRJ.'_formAsuransiDepartemen',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
                            ),true),
                    'active'=>$model->is_asudepartemen,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asudepartemen)?'':'display:none')),
    )); 
	?>
    <?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asupekerja',
            'content'=>array(
                'content-asupekerja'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi Pekerja PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>
					$this->renderPartial($this->path_viewPPRJ.'_formAsuransiPekerja',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                            'modPegawai'=>$modPegawai,
                            ),true),
                    'active'=>$model->is_asupekerja,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asupekerja)?'':'display:none')),
    )); 
	?>