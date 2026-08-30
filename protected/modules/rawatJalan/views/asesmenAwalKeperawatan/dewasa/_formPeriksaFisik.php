<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Periksa Fisik</strong></div>
        </div>
         <div class="panel-body">
             <div class="row-fluid">
                 <div class="col-sm-12">
                     <div class="control-group ">
                         <label>&nbsp;</label>
                        <div class="controls">
                            <?php echo $form->checkBox($modAsesmenawalkeperawatanT,'is_dbn' , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setCheckDbn_dws();','rel' => 'tooltip', 'title' => 'Pilih jika semua hasil periksa fisik bernilai "Normal/ Dalam Batas Normal" ')); ?> <b>DBN (Dalam Batasan Normal)</b>
                        </div>
                    </div>
                 </div>
                 <br>
                 <div class="col-sm-4">
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'kepala_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'kepala_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilKepala_dws(this);','class'=>'kepala_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'kepala_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class="kepala_abnormalketerangan">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'kepala_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'mata_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'mata_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilMata_dws(this);','class'=>'mata_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'mata_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='mata_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'mata_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'leher_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'leher_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilLeher_dws(this);','class'=>'leher_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'leher_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='leher_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'leher_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'hidung_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'hidung_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilHidung_dws(this);','class'=>'hidung_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'hidung_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='hidung_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'hidung_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'telinga_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'telinga_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilTelinga_dws(this);','class'=>'telinga_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'telinga_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='telinga_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'telinga_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'mulut_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'mulut_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilMulut_dws(this);','class'=>'mulut_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'mulut_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='mulut_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'mulut_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'jantung_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'jantung_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilJantung_dws(this);','class'=>'jantung_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'jantung_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='jantung_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'jantung_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'paru_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'paru_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilParu_dws(this);','class'=>'paru_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'paru_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='paru_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'paru_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'abdomen_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'abdomen_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilAbdomen_dws(this);','class'=>'abdomen_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'abdomen_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='abdomen_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'abdomen_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'genitalia_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'genitalia_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilGenitalia_dws(this);','class'=>'genitalia_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'genitalia_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='genitalia_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'genitalia_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'extremitasatas_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'extremitasatas_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilExtremAtas_dws(this);','class'=>'extremitasatas_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'extremitasatas_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='extremitasatas_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'extremitasatas_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'extremitasbawah_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'extremitasbawah_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilExtremBawah_dws(this);','class'=>'extremitasbawah_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'extremitasbawah_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='extremitasbawah_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'extremitasbawah_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'kulit_hasilperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'kulit_hasilperiksa',array(1=>'Normal',0=>'Abnormal') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHasilKulit_dws(this);','class'=>'kulit_hasilperiksa')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'kulit_hasilperiksa'); ?>
                        </div>
                         <div class="controls">
                             <div style="padding-left: 100px;" class='kulit_abnormalketerangan'>
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modAsesmenawalkeperawatanT, 'attribute'=>'kulit_abnormalketerangan_dws', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                         </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
</div>
