<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kebutuhan Psikologi, Sosial Ekonomi</strong></div>
        </div>
         <div class="panel-body">
           <div class="panel panel-default">
              <div class="panel-heading">
                  <div class="panel-title">Kebutuhan Psikologi (Untuk Orang Tua)</div>
              </div>
               <div class="panel-body">
                 <div class="row">
                     <div class="col-sm-6">
                       <div class="control-group ">
                          <?php echo $form->labelEx($model,'neonatus_kebpsikologidikasikpd', array('class'=>'control-label')) ?>
                          <div class="controls">
                              <?php echo $form->radioButtonList($model,'neonatus_kebpsikologidikasikpd', array('Ayah'=>'Ayah','Ibu'=>'Ibu'), array('class'=>'neonatus_kebpsikologidikasikpd','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                          </div>
                      </div>
                      <div class="control-group ">
                         <?php echo $form->labelEx($model,'neonatus_masalahperkawinanortu', array('class'=>'control-label')) ?>
                         <div class="controls">
                             <?php echo $form->radioButtonList($model,'neonatus_masalahperkawinanortu', array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada'), array('class'=>'neonatus_masalahperkawinanortu','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'changeMasalahPerkawinan(this);')); ?>
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label"></label>
                         <div class="controls">
                             <?php echo $form->dropDownList($model,'neonatus_masalahperkawinanortuket', LookupM::getItems('asesmen_masalahperkawinan'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                         </div>
                     </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($model,'neonatus_kekerasanfisikortu', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($model,'neonatus_kekerasanfisikortu', array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada'), array('class'=>'neonatus_masalahperkawinanortu','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'changeKekerasanFisik(this);')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="padding-left: 10px;">
                          <label class="checkbox inline">
                              <?php echo $form->checkbox($model,'neonatus_kekerasanfisikortu_iscederadiri',array('class'=>'kekerasanfisik')); ?> <label>Mencederai Diri</label>
                          </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls" style="padding-left: 10px;">
                          <label class="checkbox inline">
                              <?php echo $form->checkbox($model,'neonatus_kekerasanfisikortu_isorglain',array('class'=>'kekerasanfisik')); ?> <label>Orang Lain</label>
                          </label>
                        </div>
                    </div>
                    <div class="control-group ">
                       <?php echo $form->labelEx($model,'neonatus_traumadlmhiduportu', array('class'=>'control-label')) ?>
                       <div class="controls">
                           <?php echo $form->radioButtonList($model,'neonatus_traumadlmhiduportu', array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada'), array('class'=>'neonatus_masalahperkawinanortu','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'changeTraumaKehidupan(this);')); ?>
                       </div>
                   </div>
                   <div class="control-group">
                       <label class="control-label"></label>
                       <div class="controls">
                           <?php echo $form->textArea($model, 'neonatus_traumadlmhiduportuket', array('disabled'=>true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                       </div>
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <div class="control-group ">
                      <?php echo $form->labelEx($model,'gangguantidur_status', array('class'=>'control-label')) ?>
                      <div class="controls">
                          <?php echo $form->radioButtonList($model,'gangguantidur_status', array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada'), array('class'=>'neonatus_kebpsikologidikasikpd','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'changeGangguanTidur(this);')); ?>
                      </div>
                  </div>
                  <div class="control-group">
                      <label class="control-label"></label>
                      <div class="controls">
                          <?php echo $form->textArea($model, 'gangguantidur_keterangan', array('disabled'=>true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                     <?php echo $form->labelEx($model,'neonatus_konsulpsikologortu', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->radioButtonList($model,'neonatus_konsulpsikologortu', array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada'), array('class'=>'neonatus_kebpsikologidikasikpd','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                     </div>
                 </div>
                 <div class="control-group ">
                    <?php echo $form->labelEx($model,'neonatus_penerimaankondisibayi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($model,'neonatus_penerimaankondisibayi', array('Menerima'=>'Menerima','Tidak Menerima'=>'Tidak Menerima'), array('class'=>'neonatus_kebpsikologidikasikpd','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Dukungan Sosial Dari','', array('class'=>'control-label')) ?>
                    <div class="controls">
                      <label class="checkbox inline">
                          <?php echo $form->checkbox($model,'neonatus_dukungansosialdr_issuami',array()); ?> <label>Suami</label>
                      </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                      <label class="checkbox inline">
                          <?php echo $form->checkbox($model,'neonatus_dukungansosialdr_isistri',array()); ?> <label>Istri</label>
                      </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                      <label class="checkbox inline">
                          <?php echo $form->checkbox($model,'neonatus_dukungansosialdr_isortu',array()); ?> <label>Orang Tua</label>
                      </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                      <label class="checkbox inline">
                          <?php echo $form->checkbox($model,'neonatus_dukungansosialdr_iskeluarga',array()); ?> <label>Keluarga</label>
                      </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                      <label class="checkbox inline">
                          <?php echo $form->checkbox($model,'neonatus_dukungansosialdr_islainnya',array('onchange'=>'changeDukunganSosialLainnya(this);')); ?> <label>Lainnya</label>
                      </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls" style="padding-left: 10px">
                      <?php echo $form->textField($model,'neonatus_dukungansosialdr_lainnyaket',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>

              </div>
             </div>

           </div>
         </div>

             <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Kebutuhan Sosial Ekonomi (Untuk Orang Tua)</div>
                </div>
                 <div class="panel-body">
                   <div class="row">
                       <div class="col-sm-6">
                         <div class="control-group ">
                            <?php echo $form->labelEx($model,'neonatus_kebsosialekonomi_pihakygdikaji', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($model,'neonatus_kebsosialekonomi_pihakygdikaji', array('Ayah'=>'Ayah','Ibu'=>'Ibu','Keluarga'=>'Keluarga','Lainnya'=>'Lainnya'), array('class'=>'neonatus_kebsosialekonomi_pihakygdikaji','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'changePihakDikaji(this);')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls" style="padding-left: 20px">
                              <?php echo $form->textField($model,'neonatus_kebsosialekonomi_pihakygdikajilainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'neonatus_kebsosialekonomi_statusperkawinan', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'neonatus_kebsosialekonomi_statusperkawinan', LookupM::getItems('statusperkawinan'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'changeStatusPernikahan(this);')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                              <span style="color: black">Jumlah Menikah </span> <?php echo $form->textField($model,'neonatus_jmlmenikahortu',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?> <span style="color: black">Kali</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'neonatus_pendidikanortu', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'neonatus_pendidikanortu', CHtml::listdata(PendidikanM::model()->findAll('pendidikan_aktif = true'),'pendidikan_nama','pendidikan_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'neonatus_warganegaraortu', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'neonatus_warganegaraortu', LookupM::getItems('warganegara'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'neonatus_pekerjaanortu', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'neonatus_pekerjaanortu', CHtml::listdata(PekerjaanM::model()->findAll('pekerjaan_aktif = true'),'pekerjaan_nama','pekerjaan_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo $form->labelEx($model,'neonatus_tinggalbersama', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'neonatus_tinggalbersama', LookupM::getItems('asesmen_tinggalbersama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'changeTinggalBersama(this);')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                              <span style="color: black">Nama Pihak Lainnya </span> <br/><?php echo $form->textField($model,'neonatus_tinggalbersamalainnya_nama',array('class'=>'span3 tinggalbersama', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                              <span style="color: black">No. telp Pihak Lainnya</span> <br/><?php echo $form->textField($model,'neonatus_tinggalbersamalainnya_notlp',array('class'=>'span3 tinggalbersama', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                            </div>
                        </div>
                       </div>
                       <div class="col-sm-6">
                         <div class="control-group ">
                           <div class="controls">
                             <span style="color:black"><u>Kebiasaan</u></span>
                           </div>
                         </div>
                         <div class="control-group ">
                  					<?php echo $form->labelEx($model,'statusmerokok', array('class'=>'control-label')) ?>
                  					<div class="controls">
                  						<div class="radio inline">
                  							<div class="form-inline">
                  								<?php echo $form->radioButtonList($model,'statusmerokok',array('0'=>'Tidak','1'=>'Ya'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusrokok','onclick'=>'setJumlahRokokNeunatus(this);','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                  							</div>
                  						</div>
                  					</div>
                  				</div>
                  				<div class="control-group">
                  					<?php echo $form->labelEx($model, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                  					<div class="controls">
                  						<?php echo $form->textField($model, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  						Per Hari
                  					</div>
                  				</div>
                          <div class="control-group ">
                   					<?php echo $form->labelEx($model,'neonatus_kebiasaanortualkohol_status', array('class'=>'control-label')) ?>
                   					<div class="controls">
                   						<div class="radio inline">
                   							<div class="form-inline">
                   								<?php echo $form->radioButtonList($model,'neonatus_kebiasaanortualkohol_status',array('0'=>'Tidak','1'=>'Ya'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'neonatus_kebiasaanortualkohol_status','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                   							</div>
                   						</div>
                   					</div>
                   				</div>
                          <div class="control-group">
                              <label class="control-label">Jenis & Jumlah Alkohol yang dikonsumsi</label>
                              <div class="controls">
                                <?php echo $form->textField($model,'neonatus_kebiasaanortualkohol_jenis',array('placeholder'=>'Jenis','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?> <span style="color: black">/</span>
                                <?php echo $form->textField($model,'neonatus_kebiasaanortualkohol_jml',array('placeholder'=>'Jumlah','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                                <span style="color: black">Per Hari</span>
                              </div>
                          </div>
                          <?php echo $form->textAreaRow($model, 'neonatus_kebiasaanortulainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                          <div class="control-group">
                              <?php echo $form->labelEx($model,'neonatus_agamaortu', array('class'=>'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->dropDownList($model,'neonatus_agamaortu', LookupM::getItems('agama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                              </div>
                          </div>
                       </div>
                     </div>

                 </div>
             </div>

         </div>
     </div>
</div>
