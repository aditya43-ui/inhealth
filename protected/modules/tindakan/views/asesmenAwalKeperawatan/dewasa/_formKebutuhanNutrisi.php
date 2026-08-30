<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kebutuhan Nutrisi & Cairan</strong></div>
        </div>
         <div class="panel-body">
             <div class="col-md-6">
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_nutricairankeluhan_status', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'keb_nutricairankeluhan_status',array(0=>'Tidak Ada',1=>'Ada') , array('class'=>'keb_nutricairankeluhan_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setKebNutrisiStatus_dws(this);')); ?>
                    </div>
                </div>
                 <div class="control-group ">
                    <div class="controls">
                        <label class="checkbox inline">
                            <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'keb_nutricairankeluhan_ismual',array('class'=>'kebnutricairankeluhan','disabled'=>true)); ?>
                            <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'keb_nutricairankeluhan_ismuntah',array('class'=>'kebnutricairankeluhan','disabled'=>true)); ?>
                            <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'keb_nutricairankeluhan_isgangguanmengunyah',array('class'=>'kebnutricairankeluhan','disabled'=>true)); ?>
                            <?php echo $form->checkboxRow($modAsesmenawalkeperawatanT,'keb_nutricairankeluhan_isgangguanmenelan',array('class'=>'kebnutricairankeluhan','disabled'=>true)); ?>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_nutricairan_rasahausberlebih', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_nutricairan_rasahausberlebih',array('value'=>'0','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?> <label>Tidak</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_nutricairan_rasahausberlebih',array('value'=>'1','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Ya</label>
                </div>
            </div>
             </div>
             <div class="col-md-6">
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_nutricairan_turgorkulit', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_nutricairan_turgorkulit',array('value'=>'Elastis','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?> <label>Elastis</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_nutricairan_turgorkulit',array('value'=>'Tidak','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Tidak Elastis</label>
                    </div>
                </div>
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_nutricairan_mukosamulut', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_nutricairan_mukosamulut',array('value'=>'Kering','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?> <label>Kering</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'keb_nutricairan_mukosamulut',array('value'=>'Lembab','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Lembab</label>
                    </div>
                </div>
                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'keb_nutricairan_edemastatus', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'keb_nutricairan_edemastatus',array(0=>'Tidak',1=>'Ya') , array('class'=>'keb_nutricairan_edemastatus','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setKebNutrisiEdema_dws(this);')); ?>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <label>Lokasi Edema </label>&nbsp;&nbsp;&nbsp;
                        <?php echo $form->textField($modAsesmenawalkeperawatanT, 'keb_nutricairan_edemalokasi', array('class' => 'span3','readonly'=>true)); ?> 
                    </div>
                </div>
             </div>
         </div>
     </div>
</div>
