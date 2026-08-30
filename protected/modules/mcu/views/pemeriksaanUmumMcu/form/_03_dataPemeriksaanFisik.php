<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>PEMERIKSAAN FISIK</u></strong></label>       
    </div>
    
    <div class="control-group">
        <label class="control-label">Keadaan Umum</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'keadaanumum',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kesadaran</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'kesadaran',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
        
</div>
<div class="clear"></div>

<hr/>