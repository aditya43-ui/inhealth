
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary(array($modelPulang)); ?>
        <table>
            <tr>
                <td width="50%">
                    <?php //echo $form->textFieldRow($modelPulang,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPulang,'tglpasienpulang', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modelPulang,
                                                    'attribute'=>'tglpasienpulang',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                            )); ?>
                            <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?> 
                        </div>
                    </div>
                    
                    <?php echo $form->dropDownListRow($modelPulang,'ruanganakhir_id', CHtml::listData($modelPulang->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),array('disabled'=>false,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    
                    <?php echo $form->hiddenfield($modelPulang,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    <?php echo $form->hiddenfield($modelPulang,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    
                    <?php if($instalasi_id == Params::INSTALASI_ID_RI && isset($modMasukKamar)) { ?>
                        <?php echo $form->textFieldRow($modMasukKamar,'tglmasukkamar',array('readonly'=>true)) ?>
                        <?php echo $form->textFieldRow($modMasukKamar,'tglkeluarkamar',array('readonly'=>true)) ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modMasukKamar,'lamadirawat_kamar', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modMasukKamar,'lamadirawat_kamar',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Hari
                                <?php echo $form->hiddenField($modelPulang,'lamarawat',array('class'=>'span1','value'=>$modMasukKamar->lamadirawat_kamar, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    <?php } else{ ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modelPulang,'lamarawat', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modelPulang,'lamarawat',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Jam
                            </div>
                        </div>
                        <?php echo $form->error($modelPulang, 'lamarawat'); } ?>
                   
                     <?php //echo $form->textFieldRow($modelPulang,'satuanlamarawat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td width="50%">                    
                    <?php //RND-3003>>echo $form->dropDownListRow($modelPulang,'carakeluar', LookupM::getItems('carakeluar'),array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php //RND-3003>>echo $form->dropDownListRow($modelPulang,'kondisipulang', LookupM::getItems('kondisipulang'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'pasienmeninggal(this.value)')); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPulang,'carakeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onclick'=>'carakeluar(this.value);',
                                                'ajax'=>array('type'=>'POST',
                                                            'url'=>$this->createUrl('SetDropDownKondisiKeluar',array('encode'=>false,'model_nama'=>get_class($modelPulang))),
                                                            'update'=>"#".CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                                ),));?>                            
                            <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kondisi Pulang <span class="required">*</span>', 'PJPasienpulangT_kondisikeluar_id', array('class'=>'control-label'))?>
                        <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'kondisikeluar_id', CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'pasienmeninggal(this.value);'));?>
                            <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                        </div>
                    </div>    
                        <div class="control-group">
                            <?php echo $form->labelEx($modelPulang,'tgl_meninggal', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$modelPulang,
                                                        'attribute'=>'tgl_meninggal',
                                                        'mode'=>'datetime',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5','disabled'=>false),
                                )); ?>

                            </div>
                        </div>
                    
                    <?php //echo $form->textFieldRow($modelPulang,'ruanganakhir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($modelPulang,'penerimapasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    
                </td>
            </tr>
        </table>
        		
	<div class="form-actions">
                 <?php echo CHtml::htmlButton($modelPulang->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                       Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                        array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-cancel"></i>')),
                                                                        array('class' => 'btn btn-default','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<script>
    function konfirmasi()
    {
        myConfirm("<?php echo Yii::t('mds','Do You want to cancel?') ?>","Perhatian!",function(r) {
            if(r)
            {
                window.parent.$('#dialogMasukKamar').dialog('close');
            }
            else
            {   
                $('#PJPasienpulangT_carakeluar').focus();
                return false;
            }
        });
    }

    $(document).ready(function(){
        <?php 
            if(isset($modelPulang->pasienpulang_id)){
                if($instalasi_id==Params::INSTALASI_ID_RD){
                ?>
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RD ?>, judulnotifikasi:'Masuk Kamar Jenazah', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan  <?php echo $modPasien->no_rekam_medik ?> telah dipindahkan ke kamar jenazah  '}; // 16 
                    simpanNotifikasi(params);
                <?php   
                }elseif ($instalasi_id==Params::INSTALASI_ID_RJ) {
                ?>
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RJ ?>, judulnotifikasi:'Masuk Kamar Jenazah', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan  <?php echo $modPasien->no_rekam_medik ?> telah dipindahkan ke kamar jenazah  '}; // 16 
                    simpanNotifikasi(params);
                <?php   
                }elseif ($instalasi_id==Params::INSTALASI_ID_RI) {
                ?>
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RI ?>, judulnotifikasi:'Masuk Kamar Jenazah', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan  <?php echo $modPasien->no_rekam_medik ?> telah dipindahkan ke kamar jenazah  '}; // 16 
                    simpanNotifikasi(params);
                <?php   
                }

            }
        ?>
        
    })
</script>
