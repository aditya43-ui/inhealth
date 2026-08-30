<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Data Psikologi, Sosial, Ekonomi & Spiritual</strong></div>
        </div>
         <div class="panel-body">
             <div class="row-fluid">
                 <div class="col-sm-6">
                     <div class="control-group ">
                         <label class="control-label">Psikologi</label>
                        <div class="controls">
                            <label class="checkbox inline">
                                <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'statuspsikologis_isstabil',array()); ?>
                                <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'statuspsikologis_iscemas',array()); ?>
                                <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'statuspsikologis_ismarah',array()); ?>
                                <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'statuspsikologis_issedih',array()); ?>
                                <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'statuspsikologis_islainnya',array('onChange'=>'changePsikologiLainnya_dws(this);')); ?>
                            </label>
                        </div>
                    </div>
                     <div class="control-group ">
                         <label class="control-label">&nbsp;</label>
                         <div class="controls">
                             <?php echo $form->textArea($modAsesmenawalkeperawatanT,'statuspsikologis_lainnya',array('readonly'=>true, 'class'=>'span3','maxlength'=>100)); ?>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'hambatansosial_status', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'hambatansosial_status',array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHambatSosial_dws(this);')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'hambatansosial_status'); ?>
                        </div>
                    </div>
                     <div class="control-group ">
                         <label class="control-label">&nbsp;</label>
                         <div class="controls">
                             <?php echo $form->textArea($modAsesmenawalkeperawatanT,'hambatansosial_keteranganada',array('readonly'=>true, 'class'=>'span3')) ?>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'hambatanekonomi_status', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'hambatanekonomi_status',array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHambatEkonomi_dws(this);')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'hambatanekonomi_status'); ?>
                        </div>
                    </div>
                     <div class="control-group ">
                         <label class="control-label">&nbsp;</label>
                         <div class="controls">
                             <?php echo $form->textArea($modAsesmenawalkeperawatanT,'hambatanekonomi_keteranganada',array('readonly'=>true, 'class'=>'span3')) ?>
                         </div>
                    </div>
                 </div>
                 <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'hambatanspiritual_status', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'hambatanspiritual_status',array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setHambatSpiritual_dws(this);')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'hambatanspiritual_status'); ?>
                        </div>
                    </div>
                     <div class="control-group ">
                         <label class="control-label">&nbsp;</label>
                         <div class="controls">
                             <?php echo $form->textArea($modAsesmenawalkeperawatanT,'hambatanspiritual_keteranganada',array('readonly'=>true, 'class'=>'span3')) ?>
                         </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'nilaikepercayaan_status', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'nilaikepercayaan_status',array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setNilaiKepercayaan_dws(this);')); ?>
                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'nilaikepercayaan_status'); ?>
                        </div>
                    </div>
                     <div class="control-group ">
                         <label class="control-label">&nbsp;</label>
                         <div class="controls">
                              <?php echo $form->textArea($modAsesmenawalkeperawatanT,'nilaikepercayaan_keteranganada',array('readonly'=>true, 'class'=>'span3')) ?>
                         </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
</div>
