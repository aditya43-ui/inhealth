<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kebutuhan Eliminasi</strong></div>
        </div>
         <div class="panel-body">
             <div class="col-md-6">
                 <h4><b>Pola Buang Air Besar</b></h4>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_frekuensi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php  echo $form->textField($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_frekuensi',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>&nbsp; x / hari
                    </div>
                </div>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_keluhanstatus', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_keluhanstatus',array(0=>'Tidak Ada',1=>'Ada') , array('class'=>'keb_eliminasi_bab_keluhanstatus','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setKebEliminasiBab(this);')); ?>
                    </div>
                </div>
                 <div class="control-group ">
                     <label class="control-label">&nbsp;</label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_ispendarahan',array('class'=>'kebEliminasiBab','disabled'=>true)); ?>   <label>Pendarahan</label>
                    </div>
                </div>
                 <div class="control-group">
                     <label class="control-label">&nbsp;</label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_ishemorroid',array('class'=>'kebEliminasiBab','disabled'=>true)); ?>    <label>Hemorroid</label>
                    </div>
                </div>
                 <div class="control-group">
                     <label class="control-label"></label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_iskonstipasi',array('class'=>'kebEliminasiBab','disabled'=>true)); ?>     <label>Konstipasi</label>
                    </div>
                </div>
                 <div class="control-group ">
                     <label class="control-label"></label>
                     <div class="controls">
                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_iskeluhanlainnya',array('class'=>'kebEliminasiBab','disabled'=>true,'onchange'=>'setKebEliminasiKeluhanLainBab(this);')); ?>   <label>Lainnya</label>
                            <?php echo $form->textField($modAsesmenawalkeperawatanT, 'keb_eliminasi_bab_jeniskeluhanlainnya', array('class' => 'span3','readonly'=>true)); ?>
                    </div>
                </div>
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_karakteristik', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_karakteristik',array('value'=>'Padat','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?> <label>Padat</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_karakteristik',array('value'=>'Lunak','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Lunak</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_karakteristik',array('value'=>'Cair','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Cair</label>   
                    </div>
                </div>
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_warnafeces', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAsesmenawalkeperawatanT, 'keb_eliminasi_bab_warnafeces', array('class' => 'span3')); ?>
                    </div>
                </div>
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_status', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_status',array('value'=>'1','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?> <label>Ada</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_eliminasi_bab_status',array('value'=>'0','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Tidak Ada</label>
                    </div>
                </div>
             </div>
             <div class="col-md-6">
                 <h4><b>Pola Buang Air Kecil</b></h4>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_frekuensi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php  echo $form->textField($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_frekuensi',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>&nbsp; x / hari
                    </div>
                </div>
                 <div class="control-group ">
                     <label class="control-label">Jumlah <b class="fontColor" style="font-size: 14px">&#177;</b></label>
                    <div class="controls">
                        <?php  echo $form->textField($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_jumlah',array('class'=>'span1 float', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;'));?>&nbsp; cc / jam
                    </div>
                </div>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_warnaurin', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php  echo $form->textField($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_warnaurin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_keluhanstatus', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_keluhanstatus',array(0=>'Tidak Ada',1=>'Ada') , array('class'=>'keb_eliminasi_bak_keluhanstatus','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setKebEliminasiBak(this);')); ?>
                    </div>
                </div>
                 <div class="control-group">
                     <label class="control-label"></label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_isnyeri',array('class'=>'kebEliminasiBak','disabled'=>true)); ?>     <label>Nyeri</label>
                    </div>
                </div>
                 <div class="control-group">
                     <label class="control-label"></label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_ispendarahan',array('class'=>'kebEliminasiBak','disabled'=>true)); ?>     <label>Pendarahan</label>
                    </div>
                </div>
                 <div class="control-group">
                     <label class="control-label"></label>
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_iskeluhanlainnya',array('class'=>'kebEliminasiBak','disabled'=>true,'onchange'=>'setKebEliminasiKeluhanLainBak(this);')); ?>     <label>Lainnya</label>
                        <?php echo $form->textField($modAsesmenawalkeperawatanT, 'keb_eliminasi_bak_jeniskeluhanlainnya', array('class' => 'span3','readonly'=>true)); ?>
                    </div>
                </div>
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_status', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_status',array('value'=>'1','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?> <label>Ada</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_eliminasi_bak_status',array('value'=>'0','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Tidak Ada</label>
                    </div>
                </div>
             </div>
         </div>
     </div>
</div>
