<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>FUNGSI GINJAL</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">           
    <div class="control-group">
        <label class="control-label">Ureum</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'ginjal_ureum',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>                
    
    <div class="control-group">
        <label class="control-label">Creatinin</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'ginjal_creatinin',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Asam Urat</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'ginjal_asamurat',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">*Anjuran</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'ginjal_anjuran',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
</div>



<div class="clear"></div>

<hr/>