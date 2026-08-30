<div class="panel panel-darkk">
    <span class="group-title">
        B2 Sirkulasi
    </span>
    <div class="panel-body">
        <div class="control-group">
            <label class="control-label">Tensi</label>
            <div class="controls">
                <?php echo $form->textField($model,'sirkulasi_tensi_sistolik',array('class'=>'numbers-only span1','style'=>'text-align:right;')); ?>
            </div>            
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php echo $form->textField($model,'sirkulasi_tensi_diastolik',array('class'=>'numbers-only span1','style'=>'text-align:right;')); ?> <label>&nbsp;mmHg</label>
            </div>   
        </div>
        
        <div class="control-group">
            <label class="control-label">Nadi</label>
            <div class="controls">
                <?php echo $form->textField($model,'sirkulasi_nadi',array('class'=>'numbers-only span2')); ?> <label>&nbsp;x/menit</label>
            </div>                        
        </div>
        
        <div class="control-group">
            <label class="control-label">Suhu</label>
            <div class="controls">
                <?php echo $form->textField($model,'suhu',array('class'=>'float span2')); ?> <label>&nbsp;C</label>
            </div>                        
        </div>
        
        <div class="control-group">
            <label class="control-label">Perfus</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'perfus_hangatkeringmerah',array()); ?> <label>Hangat Kering Merah</label>
            </div>            
            <div class="controls">
                &nbsp;
            </div>  
            <div class="controls">
                <?php echo $form->checkBox($model,'perfus_dinginpucat',array()); ?> <label>Dingin Pucat</label>
            </div>  
        </div>
        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'perfusi_sao2',array()); ?> <label>SaO<sub>2</sub></label>
            </div>            
            <div class="controls">
                <?php echo $form->textField($model,'perfusi_sao2_keterangan',array('class'=>'span2')); ?>
            </div>                         
        </div>
        
        <div class="control-group">
                 <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'perfusi_islainnya',array()); ?> <label>Dan Lain - Lain</label>
            </div>  
            <div class="controls">
                <?php echo $form->textField($model,'perfusi_islainnya_keterangan',array('class'=>'span2',
                    'onblur'=>"
                        if($(this).val()!=''){
                            $(".CHtml::activeId($model, 'perfusi_islainnya').").attr('checked',true);
                        }else{
                            $(".CHtml::activeId($model, 'perfusi_islainnya').").removeAttr('checked');
                        }
                    "
                )); ?>
            </div>  
        </div>
           
    </div>
</div>