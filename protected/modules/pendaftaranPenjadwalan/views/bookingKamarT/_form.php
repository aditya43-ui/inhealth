<div class="white-container">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'ppbooking-kamar-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#PPPasienM_jenisidentitas',
    )); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <legend class="rim2">Pemesanan <b>Kamar</b></legend>
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
        <?php echo $form->errorSummary(array($model,$modPasien)); ?>

        <div class="control-group">
			<label class="control-label"><?php echo CHtml::checkBox('isPasienLama', $modPasien->isPasienLama, array('rel'=>'tooltip','title'=>'Pilih jika pasien lama','onclick'=>'enableInputPasien(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'pilihNoRm()',)) ?> No. Rekam Medik</label>
			<div class="controls" id="controlNoRekamMedik">
				<?php 
					$enable['readonly'] = true;
					$readOnly = ($model->isPasienLama) ? '' : $enable ; 
				?>
				<?php   $this->widget('MyJuiAutoComplete',array(
							'model'=>$modPasien,
							'attribute'=>'no_rekam_medik',
							'sourceUrl'=> $this->createUrl('PasienLama'),
							'options'=>array(
							   'showAnim'=>'fold',
							   'style'=>'height:20px;',
							   'minLength' => 4,
							   'focus'=> 'js:function( event, ui ) {
									$("#no_pendaftaran").val( ui.item.value );
									return false;
								}',
							   'select'=>'js:function( event, ui ) {
									$("#'.CHtml::activeId($modPasien,'no_rekam_medik').'").val(ui.item.no_rekam_medik);
									$("#'.CHtml::activeId($modPasien,'jenisidentitas').'").val(ui.item.jenisidentitas);
									$("#'.CHtml::activeId($modPasien,'no_identitas_pasien').'").val(ui.item.no_identitas_pasien);
									$("#'.CHtml::activeId($modPasien,'namadepan').'").val(ui.item.namadepan);
									$("#'.CHtml::activeId($modPasien,'nama_pasien').'").val(ui.item.nama_pasien);
									$("#'.CHtml::activeId($modPasien,'nama_bin').'").val(ui.item.nama_bin);
									$("#'.CHtml::activeId($modPasien,'tempat_lahir').'").val(ui.item.tempat_lahir);
									$("#'.CHtml::activeId($modPasien,'tanggal_lahir').'").val(ui.item.tanggal_lahir);
									$("#'.CHtml::activeId($modPasien,'kelompokumur_id').'").val(ui.item.kelompokumur_id);
									$("#'.CHtml::activeId($modPasien,'jeniskelamin').'").val(ui.item.jeniskelamin);
									setJenisKelaminPasien(ui.item.jeniskelamin);
									setRhesusPasien(ui.item.rhesus);
									loadDaerahPasien(ui.item.propinsi_id, ui.item.kabupaten_id, ui.item.kecamatan_id, ui.item.kelurahan_id);
									$("#'.CHtml::activeId($modPasien,'statusperkawinan').'").val(ui.item.statusperkawinan);
									$("#'.CHtml::activeId($modPasien,'golongandarah').'").val(ui.item.golongandarah);
									$("#'.CHtml::activeId($modPasien,'rhesus').'").val(ui.item.rhesus);
									$("#'.CHtml::activeId($modPasien,'alamat_pasien').'").val(ui.item.alamat_pasien);
									$("#'.CHtml::activeId($modPasien,'rt').'").val(ui.item.rt);
									$("#'.CHtml::activeId($modPasien,'rw').'").val(ui.item.rw);
									$("#'.CHtml::activeId($modPasien,'propinsi_id').'").val(ui.item.propinsi_id);
									$("#'.CHtml::activeId($modPasien,'kabupaten_id').'").val(ui.item.kabupaten_id);
									$("#'.CHtml::activeId($modPasien,'kecamatan_id').'").val(ui.item.kecamatan_id);
									$("#'.CHtml::activeId($modPasien,'kelurahan_id').'").val(ui.item.kelurahan_id);
									$("#'.CHtml::activeId($modPasien,'no_telepon_pasien').'").val(ui.item.no_telepon_pasien);
									$("#'.CHtml::activeId($modPasien,'no_mobile_pasien').'").val(ui.item.no_mobile_pasien);
									$("#'.CHtml::activeId($modPasien,'suku_id').'").val(ui.item.suku_id);
									$("#'.CHtml::activeId($modPasien,'alamatemail').'").val(ui.item.alamatemail);
									$("#'.CHtml::activeId($modPasien,'anakke').'").val(ui.item.anakke);
									$("#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'").val(ui.item.jumlah_bersaudara);
									$("#'.CHtml::activeId($modPasien,'pendidikan_id').'").val(ui.item.pendidikan_id);
									$("#'.CHtml::activeId($modPasien,'pekerjaan_id').'").val(ui.item.pekerjaan_id);
									$("#'.CHtml::activeId($modPasien,'agama').'").val(ui.item.agama);
									$("#'.CHtml::activeId($modPasien,'warga_negara').'").val(ui.item.warga_negara);
									$("#'.CHtml::activeId($model,'pasien_id').'").val(ui.item.pasien_id);
									$("dataPesan").html(\'\');
									getRuanganberdasarkanRM(ui.item.no_rekam_medik);
									loadUmur(ui.item.tanggal_lahir);
									return false;
								}',

							),
						  'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly','disabled'=>TRUE),
								'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
				)); ?>
			</div>
		</div>
    <?php echo $this->renderPartial($this->path_view.'_formPasienBookingKamar',array('form'=>$form,'model'=>$model,'modPasien'=>$modPasien)); ?> 
    <fieldset class="box">
        <legend class="rim">Data Pemesanan</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width:50%;">
                    <?php echo $form->hiddenField($model,'pasienadmisi_id',array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                    <?php echo $form->hiddenField($model,'pasien_id',array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                    <?php echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                    <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'),array('class'=>'span4','empty'=>'-- Pilih --',
                                                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                                        'ajax'=>array(
                                                                            'type'=>'POST',
                                                                            'url'=>$this->createUrl('GetKamarRuangan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                            'update'=>'#PPBookingKamarT_kamarruangan_id',),
        //                                                                                'ajax'=>array(
        //                                                                                    'type'=>'POST',
        //                                                                                    'url'=>$this->createUrl('SetDropdownKelasPelayanan',array('encode'=>false,'namaModel'=>get_class($model))),
        //                                                                                    'update'=>'#'.CHtml::activeId($model, 'kelaspelayanan_id')),
                                                                        )); 
                    ?>

                    <?php echo $form->dropDownListRow($model,'kamarruangan_id', array(),array('class'=>'span4','empty'=>'-- Pilih --',
                                                                        'onkeyup'=>"return $(this).focusNextInputField(event)",'onChange'=>'getStatus(this)',
                                                                        'ajax'=>array(
                                                                            'type'=>'POST',
                                                                            'url'=>$this->createUrl('GetKelasPelayanan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                            'update'=>'#PPBookingKamarT_kelaspelayanan_id',))); 

                    ?>
                    <div class="divForForm" style="margin-left:400px;margin-top:-25px;font-family:tahoma;">

                    </div><br>
                    <br><?php echo $form->dropDownListRow($model,'kelaspelayanan_id', array() ,array('class'=>'span4','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

                    <?php echo $form->textFieldRow($model,'bookingkamar_no',array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'readonly'=>true)); ?> 
                </td>
                <td>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model,'tglbookingkamar', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglbookingkamar',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'minDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker4', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                            )); ?>
                            <?php echo $form->error($model, 'tglbookingkamar'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model,'statusbooking', LookupM::getItems('statusbooking'),array('class'=>'span4','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textAreaRow($model,'keteranganbooking',array('rows'=>3, 'cols'=>50, 'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Keterangan Pemesanan')); ?> 
                </td>
            </tr>
        </table>    
    </fieldset>
    <div class='form-actions'>
        <?php if($model->isNewRecord)
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>'btn btn-primary', 'type'=>'button','onKeypress'=>'cekInputan(this);return false;','onClick'=>'cekInputan(this);return false;')); 
                    else 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('disabled'=>true,'class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
            ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                $this->createUrl($this->id.'/create'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'return refreshForm(this);')); ?>
        <?php if((!$model->isNewRecord) OR (Yii::app()->user->getState('printkartulsng')==TRUE)){ ?>
			<script>
				print(<?php echo $model->bookingkamar_id ?>);
			</script>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$model->bookingkamar_id');return false",'disabled'=>FALSE  )); 
			   }else{
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
			   } 
		?> 
		<?php 
			$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'create','content'=>$content));?>   				
    </div>
</div>
<?php $this->renderPartial('_jsFunctions',array('form'=>$form,'model'=>$model,'modPasien'=>$modPasien)); ?>
<?php $this->endWidget(); ?>