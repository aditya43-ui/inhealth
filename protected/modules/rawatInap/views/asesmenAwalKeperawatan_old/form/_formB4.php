<div class="panel panel-darkk">
    <span class="group-title">
        B4 Eliminasi
    </span>
    <div class="panel-body">        
        
        <div class="control-group kemih_tidak">
            <label class="control-label">Masalah Perkemihan</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'eliminasi_tidakada',array('class'=>'kemih_tidak', 'onclick'=>'validasiEliminasiTidak("1")')); ?> <label>Tidak Ada</label>
            </div>                        
        </div>
        
        <div class="kemih_ada">
            <div class="control-group">
                <label class="control-label"><span class="eliminasi_ada">Masalah Perkemihan</span></label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'eliminasi_ada',array('class'=>'kemih_ada', 'onclick'=>'validasiEliminasiAda("1")')); ?> <label>Ada :</label>
                </div>                        
                <div class="controls">

                </div>             
                <div class="controls eliminasi_ada">
                    <?php echo $form->checkBox($model,'eliminasi_ada_stoma',array('class'=>'eliminasi_ada')); ?> <label>Stoma</label>
                </div>                        
            </div>
            <div class="eliminasi_ada">
                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->checkBox($model,'eliminasi_ada_inkontinensia',array('class'=>'eliminasi_ada')); ?> <label>Inkontinensia Urin</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->checkBox($model,'eliminasi_ada_retensi',array('class'=>'eliminasi_ada')); ?> <label>Retensi Urin</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->checkBox($model,'eliminasi_ada_kencingspontan',array('class'=>'eliminasi_ada')); ?> <label>Kencing Spontan</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->checkBox($model,'eliminasi_ada_striktur_uretra',array('class'=>'eliminasi_ada')); ?> <label>Striktur Uretra</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->checkBox($model,'eliminasi_ada_dialissi',array('class'=>'eliminasi_ada')); ?> <label>Dialisis</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->checkBox($model,'eliminasi_ada_dowerkateter',array('class'=>'eliminasi_ada')); ?> <label>Dower Kateter</label>
                    </div>                        
                </div>

                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->checkBox($model,'eliminasi_ada_lainnya',array('class'=>'eliminasi_ada')); ?> <label>Dll</label>
                    </div>                        
                </div>
                <div class="control-group">
                    <label class="control-label"></label>            
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>             
                    <div class="controls">
                        <?php echo $form->textField($model,'eliminasi_ada_keterangan',array('placeholder'=>'lainnya','class'=>'span2 eliminasi_ada',
                            'onblur'=>"
                                if($(this).val()!=''){
                                    $(".CHtml::activeId($model, 'eliminasi_ada_lainnya').").attr('checked',true);
                                }else{
                                    $(".CHtml::activeId($model, 'eliminasi_ada_lainnya').").removeAttr('checked');
                                }
                            "
                        )); ?> 
                    </div>                        
                </div>
            </div>
            
        </div>
        
    </div>
</div>