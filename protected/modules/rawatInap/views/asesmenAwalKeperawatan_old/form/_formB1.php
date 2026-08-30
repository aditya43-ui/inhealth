<div class="panel panel-darkk">
    <span class="group-title">
        B1 Pernapasan
    </span>
    <div class="panel-body">
        <?php echo $form->dropDownListRow($model,'pernafasan_sulitbernafas_ya', Params::getPilihanJawaban(),array('class' => 'span2')); ?>
        
        <div class="control-group">
            <label class="control-label">RR</label>
            <div class="controls">
                <?php echo $form->textField($model,'pernafasan_respiratorrate',array('class' => 'span2 numbers-only','style'=>'text-align:right;')) ?>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'pernafasan_iscyanosis',array()); ?> <label>Cyanosis</label>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Memakai O2</label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'pernafasan_pakai_o2_ya',array('onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'pernafasan_pakai_o2_tidak').'").removeAttr("checked");
                            $("#pakai_o2").show();
                        }
                    ')); ?> <label>Ya</label>
                </div>                        
                <div class="controls">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>   
                <?php if(!empty($model->asesmen_awal_keperawatan_id)){ ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'pernafasan_pakai_o2_tidak',array('onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'pernafasan_pakai_o2_ya').'").removeAttr("checked");
                            $("#pakai_o2").hide();
                        }
                    ')); ?> <label>Tidak</label>
                </div>
                <?php }else{ ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'pernafasan_pakai_o2_tidak',array('onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'pernafasan_pakai_o2_ya').'").removeAttr("checked");
                            $("#'.CHtml::activeId($model, 'pernafasan_pakai_sangkup').'").removeAttr("checked");
                            $("#'.CHtml::activeId($model, 'pernafasan_pakai_casalcanul').'").removeAttr("checked");
                            $("#'.CHtml::activeId($model, 'pernafasan_pakai_nonbreathing').'").removeAttr("checked");
                            $("#'.CHtml::activeId($model, 'pernafasan_pakai_o2').'").val("");
                            $("#pakai_o2").hide();
                        }
                    ')); ?> <label>Tidak</label>
                </div>
                <?php } ?>
        </div>
        <span id="pakai_o2">
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->textField($model,'pernafasan_pakai_o2',array('class' => 'span1 numbers-only','style'=>'text-align:right;')); ?> <label> L/Menit</label>          
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'pernafasan_pakai_casalcanul',array()); ?> <label>Nasal Canul</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'pernafasan_pakai_sangkup',array()); ?> <label>Sungkup</label>
            </div>
        </div>        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'pernafasan_pakai_nonbreathing',array()); ?> <label>Re/Non-breathing mas</label>
            </div>            
        </div>
        </span>
    </div>
</div>