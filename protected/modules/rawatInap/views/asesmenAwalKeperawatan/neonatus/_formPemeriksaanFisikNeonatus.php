<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Pemeriksaan Fisik Neonatus</strong></div>
        </div>
         <div class="panel-body">
             <div class="row">
               <div class="col-sm-6">
                 <br/>
                 <div class="panel panel-darkk">
                     <span class="group-title">
                         Kepala
                     </span>
                     <div class="panel-body">
                       <div class="control-group ">
                          <?php echo $form->labelEx($modPeriksaFisikNeonatusRI,'kepala_kesimetrisan', array('class'=>'control-label','label'=>'Kesimetrisan')) ?>
                          <div class="controls">
                            <div class="radio inline">
                              <div class="form-inline">
                                <?php echo $form->radioButtonList($modPeriksaFisikNeonatusRI,'kepala_kesimetrisan', array('Simestri'=>'Simestri','Asimestri'=>'Asimestri'), array('class'=>'kepala_kesimetrisan','onkeyup'=>"return $(this).focusNextInputField(event)",'labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="control-group">
                         <div class="controls">
                           <div class="row">
                             <div class="col-sm-6">
                               <div class="control-group ">
                                  <div class="controls">
                                    <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kepala_iscephalhematoma',array('class'=>'kepala_iscephalhematoma')) ?> <label>Cephal Hematoma</label>
                                  </div>
                              </div>
                              <div class="control-group ">
                                 <div class="controls">
                                   <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kepala_iscaputsuccedanium',array('class'=>'kepala_iscaputsuccedanium')) ?> <label>Caput Succedanium</label>
                                 </div>
                             </div>
                              <div class="control-group ">
                                 <div class="controls">
                                   <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kepala_isanencephali',array('class'=>'kepala_isanencephali')) ?> <label>Anencephali</label>
                                 </div>
                             </div>
                               <div class="control-group ">
                                  <div class="controls">
                                    <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kepala_ismicrocephali',array('class'=>'kepala_ismicrocephali')) ?> <label>Microcephali</label>
                                  </div>
                              </div>
                             </div>
                             <div class="col-sm-6">
                               <div class="control-group ">
                                  <div class="controls">
                                    <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kepala_ishydrocephali',array('class'=>'kepala_ishydrocephali')) ?> <label>Hydricephalus</label>
                                  </div>
                              </div>
                               <div class="control-group ">
                                  <div class="controls">
                                    <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kepala_islainnya',array('class'=>'kepala_islainnya','onchange'=>'setKepalaLainnya();')) ?> <label>Lainnya</label>
                                  </div>
                              </div>
                              <div class="control-group ">
                                 <div class="controls" style="padding-left: 20px">
                                   <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'kepala_lainnyaket', array('class' => 'span3 disabledinputan')); ?>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                  </div>

                  <br/>
                  <div class="panel panel-darkk">
                      <span class="group-title">
                        Ubun-Ubun Besar (UUB)
                      </span>
                      <div class="panel-body">
                        <div class="control-group ">
                           <div class="controls">
                               <?php echo $form->radioButtonList($modPeriksaFisikNeonatusRI,'ubunubunbesar_status', array('Datar'=>'Datar','Cembung'=>'Cembung','Cekung'=>'Cekung','Lainnya'=>'Lainnya'), array('class'=>'ubunubunbesar_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setStatusUbunubunbesar()')); ?>
                           </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls" style="padding-left: 20px">
                                <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'ubunubunbesar_ket', array('class' => 'span3 disabledinputan')); ?>
                            </div>
                        </div>

                      </div>
                  </div>
                  <br/>

                  <div class="panel panel-darkk">
                      <span class="group-title">
                          Mulut
                      </span>
                      <div class="panel-body">
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'mulut_isnormal',array('class'=>'mulut_isnormal')) ?> <label>Normal</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'mulut_islabioschzis',array('class'=>'mulut_islabioschzis')) ?> <label>Labioschzis</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'mulut_islabiognatopalatoschizis',array('class'=>'mulut_islabiognatopalatoschizis')) ?> <label>Labiognatopalatoschizis</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'mulut_islainnya',array('class'=>'mulut_islainnya','onchange'=>'setMulutLainnya();')) ?> <label>Lainnya</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls" style="padding-left: 20px">
                             <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'mulut_lainnyaket', array('class' => 'span3 disabledinputan')); ?>
                           </div>
                         </div>
                         <div class="control-group ">
                           <label class="control-label" style="width: 50px">Mukosa</label>
                          </div>
                          <div class="control-group ">
                            <label class="control-label" style="width: 10px"></label>
                             <div class="controls">
                               <div class="control-group ">
                                 <label class="control-label" style="width: 50px">Warna</label>
                                  <div class="controls">
                                    <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'mulut_mukosa', array('class' => 'span3')); ?>
                                  </div>
                                </div>
                                <div class="control-group ">
                                  <label class="control-label" style="width: 50px">Lainnya</label>
                                   <div class="controls">
                                     <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'mulut_mukosalainnya', array('class' => 'span3')); ?>
                                   </div>
                                 </div>
                             </div>
                           </div>
                      </div>
                  </div>
                  <br/>

                  <div class="panel panel-darkk">
                      <span class="group-title">
                          Punggung
                      </span>
                      <div class="panel-body">
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'punggung_isnormal',array('class'=>'punggung_isnormal')) ?> <label>Normal</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'punggung_isspina_bifida',array('class'=>'punggung_isspina_bifida')) ?> <label>Spina Bifida</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'punggung_isgibus',array('class'=>'punggung_isgibus')) ?> <label>Gibus</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'punggung_islainnya',array('class'=>'punggung_islainnya','onchange'=>'setPunggungLainnya();')) ?> <label>Lainnya</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls" style="padding-left: 20px">
                             <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'punggung_lainnyaket', array('class' => 'span3 disabledinputan')); ?>
                           </div>
                         </div>
                      </div>
                  </div>
                  <br/>

                  <div class="panel panel-darkk">
                      <span class="group-title">
                          Anus
                      </span>
                      <div class="panel-body">
                        <div class="control-group ">
                           <div class="controls">
                               <?php echo $form->radioButtonList($modPeriksaFisikNeonatusRI,'anus_isada', array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada'), array('class'=>'anus_isada','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                           </div>
                       </div>
                      </div>
                  </div>
                  <br/>

                  <div class="panel panel-darkk">
                      <span class="group-title">
                          Ekstremitas
                      </span>
                      <div class="panel-body">
                        <div class="control-group ">
                          <label class="control-label">Kesimetrisan</label>
                           <div class="controls">
                             <div class="radio inline">
                               <div class="form-inline">
                                 <?php echo $form->radioButtonList($modPeriksaFisikNeonatusRI,'ekstremitas_simetris', array('Simestri'=>'Simestri','Asimestri'=>'Asimestri'), array('class'=>'ekstremitas_simetris','onkeyup'=>"return $(this).focusNextInputField(event)",'labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                               </div>
                             </div>
                           </div>
                       </div>
                       <div class="control-group ">
                          <div class="controls">
                            <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'ekstremitas_islainnya',array('class'=>'ekstremitas_islainnya','onchange'=>'setEkstremitasLainnya();')) ?> <label>Lainnya</label>
                          </div>
                       </div>
                       <div class="control-group ">
                          <div class="controls" style="padding-left: 20px">
                            <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'ekstremitas_islainnyaket', array('class' => 'span3 disabledinputan')); ?>
                          </div>
                        </div>
                      </div>
                  </div>

               </div>
               <div class="col-sm-6">
                 <br/>

                 <div class="panel panel-darkk">
                   <span class="group-title">
                       Mata
                   </span>
                   <div class="panel-body">
                     <div class="row">
                       <div class="col-sm-6">
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo $form->radioButton($modPeriksaFisikNeonatusRI,'mata_status',array('class'=>'mata_status','value'=>'Normal','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setStatusMata();')); ?> <label>Normal</label>
                            </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo $form->radioButton($modPeriksaFisikNeonatusRI,'mata_status',array('class'=>'mata_status','value'=>'Anemia','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setStatusMata();')); ?> <label>Anemia</label>
                            </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo $form->radioButton($modPeriksaFisikNeonatusRI,'mata_status',array('class'=>'mata_status','value'=>'Ikterus','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setStatusMata();')); ?> <label>Ikterus</label>
                            </div>
                         </div>

                       </div>
                       <div class="col-sm-6">
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo $form->radioButton($modPeriksaFisikNeonatusRI,'mata_status',array('class'=>'mata_status','value'=>'Sekret','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setStatusMata();')); ?> <label>Sekret</label>
                            </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo $form->radioButton($modPeriksaFisikNeonatusRI,'mata_status',array('class'=>'mata_status','value'=>'Lainnya','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setStatusMata();')); ?> <label>Lainnya</label>
                            </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls" style="padding-left: 20px">
                              <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'mata_ket', array('class' => 'span3 disabledinputan')); ?>
                            </div>
                          </div>
                       </div>
                     </div>
                   </div>
                 </div>
                 <br/>

                 <div class="panel panel-darkk">
                   <span class="group-title">
                       THT
                   </span>
                   <div class="panel-body">
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'tht_isnormal',array('class'=>'tht_isnormal')) ?> <label>Normal</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'tht_isnch',array('class'=>'tht_isnch')) ?> <label>Nafas Cuping Hidung (NCH)</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'tht_iscianosis',array('class'=>'tht_iscianosis')) ?> <label>Cianosis</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'tht_issekret',array('class'=>'tht_issekret')) ?> <label>Sekret</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'tht_islainnya',array('class'=>'tht_islainnya','onchange'=>'setThtLainnya();')) ?> <label>Lainnya</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls" style="padding-left: 20px">
                          <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'tht_lainnyaket', array('class' => 'span3 disabledinputan')); ?>
                        </div>
                      </div>
                   </div>
                 </div>
                 <br/>

                 <div class="panel panel-darkk">
                   <span class="group-title">
                     Thoraks
                   </span>
                   <div class="panel-body">
                     <div class="control-group ">
                        <div class="controls">
                            <?php echo $form->radioButtonList($modPeriksaFisikNeonatusRI,'thorax_status', array('Normal'=>'Normal','Retraksi'=>'Retraksi','Lainnya'=>'Lainnya'), array('class'=>'thorax_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setStatusThorax()')); ?>
                        </div>
                      </div>
                      <div class="control-group ">
                         <div class="controls" style="padding-left: 20px">
                             <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'thorax_lainnya', array('class' => 'span3 disabledinputan')); ?>
                         </div>
                     </div>
                   </div>
                 </div>
                 <br/>

                 <div class="panel panel-darkk">
                   <span class="group-title">
                       Abdomen
                   </span>
                   <div class="panel-body">
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'abdomen_isnormal',array('class'=>'abdomen_isnormal')) ?> <label>Normal</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'abdomen_isdistensi',array('class'=>'abdomen_isdistensi')) ?> <label>Distensi</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'abdomen_isomphalocele',array('class'=>'abdomen_isdistensi')) ?> <label>Omphalocele</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'abdomen_isbisingusus',array('class'=>'abdomen_isbisingusus')) ?> <label>Bising Usus</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'abdomen_islainnya',array('class'=>'abdomen_islainnya','onchange'=>'setAbdomenLainnya();')) ?> <label>Lainnya</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls" style="padding-left: 20px">
                          <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'abdomen_lainnyaket', array('class' => 'span3 disabledinputan')); ?>
                        </div>
                      </div>
                   </div>
                 </div>
                 <br/>

                 <div class="panel panel-darkk">
                   <span class="group-title">
                       Genitalia
                   </span>
                   <div class="panel-body">
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'genitalia_iskelainan',array('class'=>'genitalia_iskelainan','onchange'=>'setGenitaKelainan();')) ?> <label>Kelainan</label>
                        </div>
                     </div>
                     <div class="control-group ">
                        <div class="controls">
                          <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'genitalia_kelainanket', array('class' => 'span3 disabledinputan')); ?>
                        </div>
                      </div>
                      <div class="control-group ">
                         <div class="controls">
                           <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'genitalia_ishermaprodit',array('class'=>'genitalia_ishermaprodit','onchange'=>'setAbdomenLainnya();')) ?> <label>Hemoprodit</label>
                         </div>
                      </div>
                      <div class="control-group ">
                         <div class="controls">
                           <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'genitalia_islainnya',array('class'=>'genitalia_islainnya','onchange'=>'setGenitaliaLainnya();')) ?> <label>Lainnya</label>
                         </div>
                      </div>
                      <div class="control-group ">
                         <div class="controls" style="padding-left: 20px">
                           <?php echo $form->textArea($modPeriksaFisikNeonatusRI, 'genitalia_lainnyaket', array('class' => 'span3 disabledinputan')); ?>
                         </div>
                       </div>
                   </div>
                 </div>
                 <br/>

                 <div class="panel panel-darkk">
                   <span class="group-title">
                       Kulit
                   </span>
                   <div class="panel-body">
                     <div class="row">
                       <div class="col-sm-6">
                         <div class="control-group ">
                           <label class="control-label" style="width: 50px">Turgor</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modPeriksaFisikNeonatusRI,'kulit_turgor',array('class'=>'span1','maxlength'=>100)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kulit_ismarmorata',array('class'=>'kulit_ismarmorata')) ?> <label>Kurtis Marmorata</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kulit_issianosis',array('class'=>'kulit_issianosis')) ?> <label>Sianosis</label>
                           </div>
                        </div>
                        <div class="control-group ">
                           <div class="controls">
                             <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kulit_ispendarahan',array('class'=>'kulit_ispendarahan')) ?> <label>Pendarahan</label>
                           </div>
                        </div>
                       </div>
                       <div class="col-sm-6">
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kulit_ishematoma',array('class'=>'kulit_ishematoma')) ?> <label>Hematoma</label>
                            </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kulit_issklerema',array('class'=>'kulit_issklerema')) ?> <label>Sklerema</label>
                            </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls">
                              <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'kulit_islainnya',array('class'=>'kulit_islainnya','onchange'=>'setKulitLainnya();')) ?> <label>Lainnya</label>
                            </div>
                         </div>
                         <div class="control-group ">
                            <div class="controls" style="padding-left: 20px">
                              <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'kulit_lainnyaket',array('class'=>'span3 disabledinputan')); ?>
                            </div>
                         </div>
                       </div>
                     </div>


                   </div>
                 </div>
             </div>
           </div>
           <br/>

           <div class="panel panel-darkk">
             <span class="group-title">
                 Reflek
             </span>
             <div class="panel-body">
               <div class="row">
                 <div class="col-sm-4">
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_ismoro',array('class'=>'','onchange'=>'setReflekMoro();')) ?> <label>Moro</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_moroket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_israsping',array('class'=>'','onchange'=>'setReflekRasping();')) ?> <label>Rasping/Genggam</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_raspingket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_issucking',array('class'=>'','onchange'=>'setReflekSucking();')) ?> <label>Sucking/ Isap</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_suckingket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_isrooting',array('class'=>'','onchange'=>'setReflekRooting();')) ?> <label>Rooting</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_rootingket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>

                 </div>
                 <div class="col-sm-4">
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_isstepping',array('class'=>'','onchange'=>'setReflekStepping();')) ?> <label>Stepping</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_steppingket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_isswallowing',array('class'=>'','onchange'=>'setReflekSwallowing();')) ?> <label>Swallowing/ Menelan</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_swallowingket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_isbabinski',array('class'=>'','onchange'=>'setReflekBabinski();')) ?> <label>Babinski</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_babinskiket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_isglabela',array('class'=>'','onchange'=>'setReflekGlabela();')) ?> <label>Glabela</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_glabelaket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>

                 </div>
                 <div class="col-sm-4">
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_istonickneck',array('class'=>'','onchange'=>'setReflekNeck();')) ?> <label>Tonick Neck</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_tonickneckket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls">
                        <?php echo CHtml::activeCheckBox($modPeriksaFisikNeonatusRI,'reflek_islainnya',array('class'=>'','onchange'=>'setReflekLainnya();')) ?> <label>Lainnya</label>
                      </div>
                   </div>
                   <div class="control-group ">
                      <div class="controls" style="padding-left: 20px">
                        <?php echo $form->textArea($modPeriksaFisikNeonatusRI,'reflek_lainnyaket',array('class'=>'span3 disabledinputan')); ?>
                      </div>
                   </div>

                 </div>
               </div>

             </div>
           </div>
       </div>
   </div>
</div>
