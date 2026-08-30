<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>FUNGSI HATI</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">           
    <div class="control-group">
        <label class="control-label">SGOT</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'fungsihati_sgot',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>                
    
    <div class="control-group">
        <label class="control-label">SGPT</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'fungsihati_sgpt',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div> 
        
</div>



<div class="clear"></div>

<hr/>