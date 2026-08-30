<div class="panel panel-darkk">
    <span class="group-title">
        B6 Kulit dan Muskuloskeletal
    </span>
    <div class="panel-body">        
        
        <div class="control-group">
            <label class="control-label">Kulit</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'kulit_icterus',array()); ?> <label>Icterus</label>
            </div>                        
            <div class="controls">
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'kulit_luka',array()); ?> <label>Luka</label>
            </div>                        
            <div class="controls">
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'kulit_normal',array()); ?> <label>Normal</label>
            </div>                        
            <div class="controls">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'kulit_lainnya',array()); ?> <label>Dll</label>
            </div>        
            <div class="controls">
                <?php echo $form->textField($model,'kulit_keterangan',array('class' => 'span2',
                    'onblur'=>"
                        if($(this).val()!=''){
                            $(".CHtml::activeId($model, 'kulit_lainnya').").attr('checked',true);
                        }else{
                            $(".CHtml::activeId($model, 'kulit_lainnya').").removeAttr('checked');
                        }
                    "
                )) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Muskuloskeletal</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'muskuloskeletal_deformitas',array()); ?> <label>Deformitas</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'muskuloskeletal_decubitus',array()); ?> <label>Decubitus</label>
            </div>                        
        </div>
        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'muskuloskeletal_kekuatanotot',array('onclick'=>'
                        if($(this).is(":checked")){
                            $("#'.CHtml::activeId($model, 'muskuloskeletal_kekuatanotot_ket').'").attr("disabled",false);
                        }else{
                            $("#'.CHtml::activeId($model, 'muskuloskeletal_kekuatanotot_ket').'").attr("disabled",true);
                        }
                    ')); ?> <label>Kekuatan Otot</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'muskuloskeletal_normal',array()); ?> <label>Normal</label>
            </div>                        
        </div>
        
        <div class="control-group" id="kekuatan_otot">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->dropDownList($model,'muskuloskeletal_kekuatanotot_ket', LookupM::getItems('muskuloskeletal_kekuatanotot'),array('class' => 'span2','disabled'=>true)); ?> 
            </div>                     
            <div class="controls">
                &nbsp;&nbsp;&nbsp;
            </div>
            <div class="controls">
            </div>                        
        </div>
    </div>
</div>