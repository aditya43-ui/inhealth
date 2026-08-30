<div class="panel panel-darkk">
    <span class="group-title">
        Ketergantungan saat melaksanakan Actifity Daily Life
    </span>
    <div class="panel-body">        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Mobilisiasi : </label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_mobilisasi_mandiri',array()); ?> <label>Mandiri</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_mobilisasi_dibantu',array()); ?> <label>Dibantu</label>
                </div>                        
            </div>
            
            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_mobilisasi_tergantungpenuh',array()); ?> <label>Ketergantungan Penuh</label>
                </div>                                        
            </div>
                        
            <div class="control-group">
                <label class="control-label">Personal : </label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_personal_mandiri',array()); ?> <label>Mandiri</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_personal_dibantu',array()); ?> <label>Dibantu</label>
                </div>                        
            </div>
            
            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_personal_tergantungpenuh',array()); ?> <label>Ketergantungan Penuh</label>
                </div>                                        
            </div>
            
            <div class="control-group">
                <label class="control-label">Toileting : </label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_toileting_mandiri',array()); ?> <label>Mandiri</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_toileting_dibantu',array()); ?> <label>Dibantu</label>
                </div>                        
            </div>
            
            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_toileting_tergantungpenuh',array()); ?> <label>Ketergantungan Penuh</label>
                </div>                                        
            </div>
            
            <div class="control-group">
                <label class="control-label">Berpakaian : </label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_berpakaian_mandiri',array()); ?> <label>Mandiri</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_berpakaian_dibantu',array()); ?> <label>Dibantu</label>
                </div>                        
            </div>
            
            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_berpakaian_tergantungpenuh',array()); ?> <label>Ketergantungan Penuh</label>
                </div>                                        
            </div>
            
            <div class="control-group">
                <label class="control-label">Makan/Minum : </label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_mamin_mandiri',array()); ?> <label>Mandiri</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </div>                        
                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_mamin_dibantu',array()); ?> <label>Dibantu</label>
                </div>                        
            </div>
            
            <div class="control-group">
                <label class="control-label"></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'tergantung_mamin_tergantungpenuh',array()); ?> <label>Ketergantungan Penuh</label>
                </div>                                        
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group alatbantu_tidakada">
                <label class="control-label">Alat Bantu : </label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'alatbantu_tidakada',array( 'class'=>'alatbantu_tidakada', 'onclick'=>'validasiAlatBantuTidak("1")')); ?> <label>Tidak Ada</label>
                </div>                                                              
            </div>
            
             <div class="control-group alatbantu_ada">
                <label class="control-label"><span class="alatbantu">Alat Bantu : </span></label>

                <div class="controls">
                    <?php echo $form->checkBox($model,'alatbantu_ada',array( 'class'=>'alatbantu_ada', 'onclick'=>'validasiAlatBantuAda("1")')); ?> <label>Ada :</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </div>                        
                <div class="controls alatbantu">
                    <?php echo $form->checkBox($model,'alatbantu_ada_pendengaran',array( 'class'=>'alatbantu')); ?> <label>Pendengaran</label>
                </div>                        
            </div>
            
            <div class="alatbantu">
                <div class="control-group">
                    <label class="control-label"></label>

                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>                        
                    <div class="controls">
                        <?php echo $form->checkBox($model,'alatbantu_ada_penglihatan',array( 'class'=>'alatbantu')); ?> <label>Penglihatan</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>

                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>                        
                    <div class="controls">
                        <?php echo $form->checkBox($model,'alatbantu_ada_gerak',array( 'class'=>'alatbantu')); ?> <label>Gerak</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>

                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>                        
                    <div class="controls">
                        <?php echo $form->checkBox($model,'alatbantu_ada_jantung',array( 'class'=>'alatbantu')); ?> <label>Jantung</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>

                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>                        
                    <div class="controls">
                        <?php echo $form->checkBox($model,'alatbantu_ada_gigi',array( 'class'=>'alatbantu')); ?> <label>Jantung</label>
                    </div>                        
                </div>

                 <div class="control-group">
                    <label class="control-label"></label>

                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>                        
                    <div class="controls">
                        <?php echo $form->checkBox($model,'alatbantu_ada_lainnya',array( 'class'=>'alatbantu')); ?> <label>Lain - Lain</label>
                    </div>                        
                    <div class="controls">
                        <?php echo $form->textField($model,'alatbantu_ada_keterangan',array('class'=>'span2 alatbantu','placeholder'=>'lainnya',
                            'onblur'=>"
                                if($(this).val()!=''){
                                    $(".CHtml::activeId($model, 'alatbantu_ada_lainnya').").attr('checked',true);
                                }else{
                                    $(".CHtml::activeId($model, 'alatbantu_ada_lainnya').").removeAttr('checked');
                                }
                            "
                        )) ?>
                    </div>
            </div>
            
            </div>
        </div>
    </div>
</div>