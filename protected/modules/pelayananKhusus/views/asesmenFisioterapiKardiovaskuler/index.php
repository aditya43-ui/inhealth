<?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'asesmenkardiovaskuler-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<?php echo $form->hiddenField($model, 'pasien_id'); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id'); ?>

<div class="panel panel-gradient">
  <div class="panel-heading">
      <div class="panel-title">
          <strong>Transaksi Asesmen Kardiovaskuler</strong>
      </div>
  </div>
  <div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model,'tanggal_catat', array('class'=>'control-label','label'=>'Tanggal Pengisian')) ?>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tanggal_catat',
                    'mode'=>'datetime',
                    'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                )); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jam_pengisian', array('class' => 'control-label')) ?>
            <div class="controls">
              <?php
                  $this->widget('MyDateTimePicker', array(
                          'model' => $model,
                          'attribute' => 'jam_pengisian',
                          'mode' => 'time',
                          'options' => array(
                          ),
                          'htmlOptions' => array('class'=>'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:150px;'),
                  ));
              ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->label($model,'pegawai_id', array('class'=>'control-label required','label'=>'Petugas Pengisi <span class="required">*</span>')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.Yii::app()->user->getState("ruangan_id").' ORDER BY nama_pegawai ASC'), 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

      </div>
			<div class="clear"></div>
			<div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Medis RS
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo $form->label($model, 'diagnosa_id', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textArea($model,'diagnosa_nama',array('cols'=>20,'rows'=>4,'readonly'=>true)) ?>
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('Penunjang Diagnosa', '', array('class' => 'control-label')) ?>
                  </div>
                  <div class="control-group">
                      <div class="controls">
                        <?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'Rontgen','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Rontgen</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'Lab','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Lab</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'CT Scan','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>CT Scan</label>
                        <br/>
                        <?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'MRI','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>MRI</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'ENMG','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>ENMG</label>
                        <span style='padding-left: 20px'></span><?php echo $form->radioButton($model,'diagnosis_penunjang',array('class'=>'diagnosis_penunjang','value'=>'EEG','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>EEG</label>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo $form->label($model, 'resume', array('class' => 'control-label','style'=>'width: 65px')) ?>
                      <div class="controls">
                        <?php echo $form->textArea($model,'resume',array('cols'=>20,'rows'=>4)) ?>
                      </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
			<div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Anamnesa
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('1. Keluhan', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
                  </div>
                  <div class="control-group ">
                      <div class="controls" style="padding-left: 10px">
                        <?php echo $form->textArea($model,'keluhanutama',array('cols'=>20,'rows'=>4,'readonly'=>false)) ?>
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('2. Riwayat Penyakit', '', array('class' => 'control-label','style'=>'width: 110px')) ?>
                  </div>
                  <div class="control-group ">
                      <div class="controls" style="padding-left: 10px">
                        <?php echo $form->textArea($model,'riwayatpenyakit',array('cols'=>20,'rows'=>4,'readonly'=>false)) ?>
                      </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
			<div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Pemeriksaan Umum
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('1. Tanda Vital', '', array('class' => 'control-label','style'=>'width: 80px')) ?>
                  </div>
                  <div class="control-group" style="padding-left: 5px">
                      <?php echo CHtml::label('Tekanan Darah', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php  echo $form->textField($model,'td_systolic',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah();', 'style'=>'text-align: right;'));?>Mm
                        <?php echo $form->textField($model,'td_dyastolic',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'getTekananDarah();', 'style'=>'text-align: right;')); ?>Hg
                      </div>
                  </div>
                  <div class="control-group " style="padding-left: 5px">
                      <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php  echo CHtml::textField('tekanandarah','000/000',array('readonly'=>true,'class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>MmHg
                      </div>
                  </div>
                  <div class="control-group " style="padding-left: 5px">
                      <?php echo CHtml::label('Detak Nadi', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textField($model,'nadi',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?> /Menit
                      </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                  </div>
                  <div class="control-group">
                      <?php echo CHtml::label('Pernapasan', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textField($model,'pernapasan',array('class'=>'span2  integer numbersOnly', 'maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)"));?> /Menit
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('Suhu Tubuh', '', array('class' => 'control-label')) ?>
                      <div class="controls">
                        <?php echo $form->textField($model,'suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?> &#176; Celcius
                      </div>
                  </div>
                </div>
                <div class="clear"></div>
                <div class="col-sm-12">
                  <div class="control-group ">
                      <?php echo CHtml::label('2. Inspeksi', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
                  </div>
                  <div class="control-group" style="padding-left: 5px">
                      <?php echo CHtml::label('Statik (bentuk dada)', '', array('class' => 'control-label')) ?>
                  </div>
                  <div class="control-group ">
                     <div class="controls">
                       <div class="radio inline">
                         <div class="form-inline">
                           <?php //echo $form->radioButtonList($model,'inspeksi_statik_bentukdada',LookupM::getItems(Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_STATIK_DADA) , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statik','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                           <?php
                                $htmlSpasme = "";
                                $look_spasme = LookupM::getItems(Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_STATIK_DADA);

                                if(count($look_spasme) > 0){
                                  foreach ($look_spasme as $i => $lookp) {
                                    $ischeck = false;
                                    if(!empty($model->inspeksi_statik_bentukdada)){
                                      $arrOriSpasme = json_decode($model->inspeksi_statik_bentukdada);
                                      
                                      if(count($arrOriSpasme) > 0){
                                        foreach ($arrOriSpasme as $dt=>$dataSpasme) {
                                          
                                          if($lookp == $dataSpasme){
                                              
                                              $ischeck = true;
                                          }
                                        }
                                      }
                                    }
                                    $htmlSpasme .= CHtml::hiddenField('inspeksi_statik_bentukdada['.$i.']',$lookp);
                                    if ($lookp == 'Lainnya'){
                                        $htmlSpasme .= CHtml::activecheckBox($model,'inspeksi_statik_bentukdada['.$i.']',array('class'=>'statik','onClick'=>'setStatik();','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                        $htmlSpasme .= $form->textField($model,'statiklainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                    }else{
                                        $htmlSpasme .= CHtml::activecheckBox($model,'inspeksi_statik_bentukdada['.$i.']',array('class'=>'statik','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                    }
                                  }
                                }
                                echo $htmlSpasme;
                              ?>
                         </div>
                       </div>

                     </div>
                 </div>
								 <div class="control-group">
										<div class="controls" style="padding-left: 10px">
											<?php echo $form->textArea($model,'inspeksi_detail',array('style'=>'width:400px','rows'=>2)) ?>
										</div>
								</div>
                 <div class="control-group"  style="padding-left: 5px">
                     <?php echo CHtml::label('Dinamis', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
                 </div>
                 <div class="control-group " style="padding-left: 10px">
                    <div class="controls">
                      <?php echo $form->textArea($model,'inspeksi_dinamis',array('style'=>'width:400px','rows'=>2,'maxlength'=>100)) ?>
                    </div>
                </div>
              </div>
							<div class="clear"></div>
							<div class="col-sm-6">
								<div class="control-group ">
										<?php echo CHtml::label('3. Palpasi', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
								</div>
								<div class="control-group " style="padding-left: 15px">
										<?php echo CHtml::label('Ekspansi Thorax', '', array('class' => 'control-label','style'=>'width: 100px')) ?>
								</div>
								<div class="control-group ">
									 <div class="controls">
										 <div class="radio inline">
											 <div class="form-inline">
												 <?php //echo $form->radioButtonList($model,'palpasi_ekspansi_thorax',LookupM::getItems(Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_THORAX) , array('onkeyup'=>"return $(this).focusNextInputField(event)",'uncheckValue'=>null,'class'=>'palpasi','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                         <?php
                                $htmlSpasme = "";
                                $look_spasme = LookupM::getItems(Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_THORAX);

                                if(count($look_spasme) > 0){
                                  foreach ($look_spasme as $i => $lookp) {
                                    $ischeck = false;
                                    if(!empty($model->palpasi_ekspansi_thorax)){
                                      $arrOriSpasme = json_decode($model->palpasi_ekspansi_thorax);
                                      
                                      if(count($arrOriSpasme) > 0){
                                        foreach ($arrOriSpasme as $dt=>$dataSpasme) {
                                          
                                          if($lookp == $dataSpasme){
                                              
                                              $ischeck = true;
                                          }
                                        }
                                      }
                                    }
                                    $htmlSpasme .= CHtml::hiddenField('palpasi_ekspansi_thorax['.$i.']',$lookp);
                                    if ($lookp == 'Lainnya'){
                                        $htmlSpasme .= CHtml::activecheckBox($model,'palpasi_ekspansi_thorax['.$i.']',array('class'=>'dinamis','onClick'=>'setStatik();','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                        $htmlSpasme .= $form->textField($model,'statiklainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                    }else{
                                        $htmlSpasme .= CHtml::activecheckBox($model,'palpasi_ekspansi_thorax['.$i.']',array('class'=>'dinamis','value'=>$lookp,'checked'=>$ischeck)) .' '."<label>".$lookp."</label>&nbsp;";
                                    }
                                  }
                                }
                                echo $htmlSpasme;
                              ?>
											 </div>
										 </div>
									 </div>
							 </div>
							</div>
							<div class="col-sm-6">
								<div class="control-group ">
										<?php echo CHtml::label('&nbsp;', '', array('class' => 'control-label','style'=>'width: 90px')) ?>
								</div>
								<div class="control-group ">
										<?php echo CHtml::label('Spasme Otot', '', array('class' => 'control-label','style'=>'width: 70px')) ?>
								</div>
								<div class="control-group ">
									 <div class="controls">
										 <div class="row">
										 <?php
										 		$htmlSpasme = "";
												$look_spasme = LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_SPASME));

												if(count($look_spasme) > 0){
													foreach ($look_spasme as $i => $lookp) {
                            $ischeck = false;
                            if(!empty($model->palpasi_spasme_otot)){
                              $arrOriSpasme = json_decode($model->palpasi_spasme_otot);
                              if(count($arrOriSpasme) > 0){
                                foreach ($arrOriSpasme as $dataSpasme) {
                                  if($lookp->lookup_value == $dataSpasme){
                                    $ischeck = true;
                                  }
                                }
                              }
                            }

														$htmlSpasme .= "<div class='col-sm-6'>";
                            $htmlSpasme .= CHtml::hiddenField('PalpasiOtot['.$i.'][nama]',$lookp->lookup_value);
                            $htmlSpasme .= CHtml::checkBox('PalpasiOtot['.$i.'][ischeckotot]',$ischeck,array('class'=>'palpasi_spasme_otot')) .' '."<label>".$lookp->lookup_name."</label>";
														$htmlSpasme .= "</div>";
													}
												}
												echo $htmlSpasme;
										  ?>

									 </div>
								 </div>
							 </div>
							</div>
            </div>
          </div>
        </div>
      </div>
			<div class="clear"></div>
			<div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Data Pemeriksaan Khusus
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
              <div class="row">
								<div class="col-sm-12">
									<div class="control-group ">
                      <?php echo CHtml::label('1. Perkusi', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
                  </div>
                  <div class="control-group ">
										<div class="radio inline">
											<div class="form-inline">
												<?php echo $form->radioButtonList($model,'khusus_perkusi',LookupM::getItems(Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_PERKUSI) , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statik','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
											</div>
										</div>
                  </div>
								</div>
								<div class="clear"></div>
                <div class="col-sm-6">
									<div class="control-group">
                      <?php echo CHtml::label('2. Auskultasi', '', array('class' => 'control-label','style'=>'width: 75px')) ?>
                  </div>
                  <div class="control-group">
                      <?php echo CHtml::label('Suara Nafas', '', array('class' => 'control-label','style'=>'width: 85px')) ?>
                  </div>
                  <div class="control-group ">
                     <div class="controls">
                       <div class="radio inline">
                         <div class="form-inline">
                           <?php echo $form->radioButtonList($model,'khusus_auskultasi_suaranafas',LookupM::getItems(Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_AUSKULTASI_SUARA) , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statik','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                         </div>
                       </div>
                     </div>
                 </div>
								 <div class="control-group">
										 <?php echo CHtml::label('Lokasi Sputum', '', array('class' => 'control-label','style'=>'width: 100px')) ?>
								 </div>
								 <div class="control-group " style="padding-left: 15px">
										<div class="controls">
												<?php echo $form->textField($model,'khusus_auskultasi_lokasisputum',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?>
										</div>
								</div>
                </div>
                <div class="col-sm-6">
									<div class="control-group">
                      <?php echo CHtml::label('&nbsp;', '', array('class' => 'control-label','style'=>'width: 75px')) ?>
                  </div>
                  <div class="control-group">
                      <?php echo CHtml::label('Suara Jantung', '', array('class' => 'control-label','style'=>'width: 85px')) ?>
                  </div>
                  <div class="control-group ">
                     <div class="controls">
                       <div class="radio inline">
                         <div class="form-inline">
                           <?php echo $form->radioButtonList($model,'khusus_auskultasi_suarajantung',LookupM::getItems(Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_AUSKULTASI_JANTUNG) , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statik','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                         </div>
                       </div>
                     </div>
                 </div>
                </div>
                <div class="clear"></div>
								<div class="col-sm-4">
									<div class="control-group ">
                      <?php echo CHtml::label('3. Pengukuran ekspansi thoraks', '', array('class' => 'control-label','style'=>'width: 180px')) ?>
                  </div>
                  <div class="control-group">
                      <?php echo CHtml::label('Axilla', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
                  </div>
                  <div class="control-group">
                     <div class="controls">
                       <div class="radio inline">
                         <div class="form-inline">
                           <?php echo $form->textField($model,'khusus_pengukuran_eksthoraks_axilla',array('class'=>'span3 float', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?> cm
                         </div>
                       </div>

                     </div>
                 </div>
								</div>
								<div class="col-sm-4">
									<div class="control-group ">
                      <?php echo CHtml::label('&nbsp;', '', array('class' => 'control-label','style'=>'width: 90px')) ?>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('ICS 5', '', array('class' => 'control-label','style'=>'width: 60px')) ?>
                  </div>
                  <div class="control-group ">
                     <div class="controls">
                       <div class="radio inline">
                         <div class="form-inline">
                           <?php echo $form->textField($model,'khusus_pengukuran_eksthoraks_ics5',array('class'=>'span3 float', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?> cm
                         </div>
                       </div>

                     </div>
                 </div>
								</div>
                <div class="col-sm-4">
									<div class="control-group ">
                      <?php echo CHtml::label('&nbsp;', '', array('class' => 'control-label','style'=>'width: 90px')) ?>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label('Processus Xyphoideus', '', array('class' => 'control-label','style'=>'width: 150px')) ?>
                  </div>
                  <div class="control-group ">
                     <div class="controls">
                       <div class="radio inline">
                         <div class="form-inline">
                           <?php echo $form->textField($model,'khusus_pengukuran_eksthoraks_processus',array('class'=>'span3 float', 'onkeypress'=>"return $(this).focusNextInputField(event)"));?> cm
                         </div>
                       </div>

                     </div>
                 </div>
              	</div>
								<div class="clear"></div>

							<div class="col-sm-6">
								<div class="control-group ">
										<?php echo CHtml::label('4. Pemeriksaan sesak napas (VAS, BORG Scale)', '', array('class' => 'control-label','style'=>'width: 250px')) ?>
								</div>
								<div class="control-group ">
										<?php echo CHtml::label('', '', array('class' => 'control-label','style'=>'width: 5px')) ?>
										<div class="controls">
											<?php echo $form->textArea($model,'pemeriksaan_sesaknafas',array('style'=>'width: 300px','rows'=>4)) ?>
										</div>
								</div>
								<div class="control-group ">
										<?php echo CHtml::label('6. Pemeriksaan Spirometri', '', array('class' => 'control-label','style'=>'width: 145px')) ?>
								</div>
								<div class="control-group ">
										<?php echo CHtml::label('', '', array('class' => 'control-label','style'=>'width: 5px')) ?>
										<div class="controls">
											<?php echo $form->textArea($model,'pemeriksaan_spirometri',array('style'=>'width: 300px','rows'=>4)) ?>
										</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="control-group ">
										<?php echo CHtml::label('5. Pemeriksaan nyeri', '', array('class' => 'control-label','style'=>'width: 115px')) ?>
								</div>
								<div class="control-group ">
										<?php echo CHtml::label('', '', array('class' => 'control-label','style'=>'width: 5px')) ?>
										<div class="controls">
											<?php echo $form->textArea($model,'pemeriksaan_nyeri',array('style'=>'width: 300px','rows'=>4)) ?>
										</div>
								</div>
							</div>

            </div>
          </div>
        </div>
      </div>
		</div>
		<div class="row-fluid">
        <div class="form-actions">
            <?php
              $disabledSukses = (isset($_GET['sukses'])?false:true);

                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan', 'disabled'=>(($disabledSukses==true)?false:true)));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                    $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                    array('class'=>'btn btn-danger',
                        'onclick'=>'return refreshForm(this);'));

                echo "&nbsp&nbsp". CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print("'.$_GET['pendaftaran_id'].'","'.$_GET['pasienmasukpenunjang_id'].'")', 'disabled'=>$disabledSukses));

            ?>
            <?php
                $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>
    </div>
	</div>

</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
