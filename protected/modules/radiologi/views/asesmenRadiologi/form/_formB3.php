<div class="panel panel-darkk">
    <span class="group-title">
        B3 Persarafan
    </span>
    <div class="panel-body">
        <div class="control-group">
           <label>Kesadaran</label>
            <div class="controls">
            </div>
        </div>       
        
        <div class="control-group ">
                <?php echo $form->labelEx($model,'persarafan_gcs_eye', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php $crit = new CDbCriteria();
                                $crit->compare('LOWER(metodegcs_singkatan)',"e");
                                $crit->addCondition('metodegcs_nilai is not null');
                                $crit->order = 'metodegcs_nilai ASC';
                                 echo $form->dropDownList($model,'persarafan_gcs_eye',  
                                                CHtml::listData(MetodegcsM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo $form->labelEx($model,'persarafan_gcs_verb', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php 
                        $crit3 = new CDbCriteria();
                        $crit3->compare('LOWER(metodegcs_singkatan)',"v");
                        $crit3->addCondition('metodegcs_nilai is not null');
                        $crit3->order = 'metodegcs_nilai ASC';
                        echo $form->dropDownList($model,'persarafan_gcs_verb',
                                        CHtml::listData(MetodegcsM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                </div>
        </div>
        <div class="control-group ">
                <?php echo $form->labelEx($model,'persarafan_gcs_motorik', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php 
                        $crit2 = new CDbCriteria();
                        $crit2->compare('LOWER(metodegcs_singkatan)',"m");
                        $crit2->addCondition('metodegcs_nilai is not null');
                        $crit2->order = 'metodegcs_nilai ASC';
                        echo $form->dropDownList($model,'persarafan_gcs_motorik',
                                        CHtml::listData(MetodegcsM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                </div>
        </div>
           
        <?php echo $form->textFieldRow($model,'persarafan_total_gcs',array('readonly'=>true)); ?>
        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_nilai_berubah',array()); ?> <label>Berubah</label>
            </div>            
            <div class="controls">
                &nbsp;
            </div>  
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_gcs_normal',array()); ?> <label>Normal</label>
            </div>  
        </div>
        
        <div class="control-group">
            <label class="control-label">Psikologis</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_psikologis_tenang',array()); ?> <label>Tenang</label>
            </div>            
            <div class="controls">
                &nbsp;&nbsp;
            </div>  
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_psikologis_cemas',array()); ?> <label>Cemas</label>
            </div>  
             <div class="controls">
                &nbsp;
            </div>  
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_psikologis_takut',array()); ?> <label>Takut</label>
            </div>  
        </div>
        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_psikologis_marah',array()); ?> <label>Marah</label>
            </div>            
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>  
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_psikologis_sedih',array()); ?> <label>Sedih</label>
            </div>  
            
        </div>
        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'persarafan_psikologis_lainnya',array()); ?> <label>Lainnya</label>
            </div>            
            <div class="controls">
                &nbsp;
            </div>  
            <div class="controls">
                <?php echo $form->textField($model,'persarafan_psikologis_lainketerangan',array('placeholder'=>'lainnya','class' => 'span2',
                    'onblur'=>"
                        if($(this).val()!=''){
                            $(".CHtml::activeId($model, 'persarafan_psikologis_lainnya').").attr('checked',true);
                        }else{
                            $(".CHtml::activeId($model, 'persarafan_psikologis_lainnya').").removeAttr('checked');
                        }
                    "
                )); ?>
            </div>  
            
        </div>
    </div>
</div>