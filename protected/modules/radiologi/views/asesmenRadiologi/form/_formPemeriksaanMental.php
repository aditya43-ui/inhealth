<style>
    .label-width{
        width: 300px;
    }
</style>
<div class="panel panel-darkk">
    <span class="group-title">
        Mental
    </span>
    <div class="panel-body">
        <div class="control-group">
            <div class="controls">
                <label class="label-width">Dalam 1 tahun terakhir pernahkan ada ide bunuh diri? </label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_idebunuhdiri_ya',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_idebunuhdiri_tidak').'").removeAttr("checked");
                    }
                ')); ?> <label>Ya</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
            </div>                        
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_idebunuhdiri_tidak',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_idebunuhdiri_ya').'").removeAttr("checked");
                    }
                ')); ?> <label>Tidak</label>
            </div>                        
        </div>
        <div class="control-group">
            <div class="controls">
                <label class="label-width">Melakukan percobaan bunuh diri? </label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_percobaanbunuhdiri_ya',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_percobaanbunuhdiri_tidak').'").removeAttr("checked");
                    }
                ')); ?> <label>Ya</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
            </div>                        
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_percobaanbunuhdiri_tidak',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_percobaanbunuhdiri_ya').'").removeAttr("checked");
                    }
                ')); ?> <label>Tidak</label>
            </div>                        
        </div>
        <div class="control-group">
            <div class="controls">
                <label class="label-width">Mengalami kekerasan dan/atau KDRT </label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_mengalami_kdrt_ya',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_mengalami_kdrt_tidak').'").removeAttr("checked");
                    }
                ')); ?> <label>Ya</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
            </div>                        
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_mengalami_kdrt_tidak',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_mengalami_kdrt_ya').'").removeAttr("checked");
                    }
                ')); ?> <label>Tidak</label>
            </div>                        
        </div>
        <div class="control-group">
            <div class="controls">
                <label class="label-width">Melakukan kekerasan dan/atau KDRT </label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_melakukan_kdrt_ya',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_melakukan_kdrt_tidak').'").removeAttr("checked");
                    }
                ')); ?> <label>Ya</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
            </div>                        
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_melakukan_kdrt_tidak',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_melakukan_kdrt_ya').'").removeAttr("checked");
                    }
                ')); ?> <label>Tidak</label>
            </div>                        
        </div>
        <div class="control-group">
            <div class="controls">
                <label class="label-width">Memakai narkotika, psikotropika , alkohol dan zat adiktif lainnya(kopi, dll) ? </label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'memakai_narkotika_ya',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'memakai_narkotika_tidak').'").removeAttr("checked");
                        $("#narkotikaShow").show();
                    }
                ')); ?> <label>Ya</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
            </div>                        
            <div class="controls">
                <?php echo $form->checkBox($model,'memakai_narkotika_tidak',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'memakai_narkotika_ya').'").removeAttr("checked");
                        $("#narkotikaShow").hide();
                    }
                ')); ?> <label>Tidak</label>
            </div>                        
        </div>
        <div class="control-group" id="narkotikaShow">
            <div class="controls">
                <label class="label-width">Bila ya, sebutkan </label>
            </div>
            <div class="controls">
                <?php echo $form->textArea($model,'memakai_narkotika_ya_ket',array('class'=>'span3', 'placeholder' => 'Keterangan')) ?>
            </div>                                               
        </div>
        
        <div class="control-group">
            <div class="controls">
                <label class="label-width">Dalam 1 tahun terakhir adakah kecenderungan untuk menelantarkan diri?</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_menelantarkandiri_ya',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_menelantarkandiri_tidak').'").removeAttr("checked");
                    }
                ')); ?> <label>Ya</label>
            </div>                        
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
            </div>                        
            <div class="controls">
                <?php echo $form->checkBox($model,'mental_menelantarkandiri_tidak',array('onclick'=>'
                    if($(this).is(":checked")){
                        $("#'.CHtml::activeId($model, 'mental_menelantarkandiri_ya').'").removeAttr("checked");
                    }
                ')); ?> <label>Tidak</label>
            </div>                        
        </div>
    </div>
</div>