<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>METABOLISME GLUKOSA</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">           
    <div class="control-group">
        <label class="control-label">Glukosa Puasa</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'metabolisme_glukosapuasa',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>                
    
    <div class="control-group">
        <label class="control-label">*Anjuran</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'metabolisme_anjuran',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
        
</div>



<div class="clear"></div>

<hr/>