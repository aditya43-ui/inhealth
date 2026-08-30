<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>PEMERIKSAAN FISIK</u></strong></label>       
    </div>
    
    <div class="control-group">
        <label class="control-label">Riwayat Penyakit Terdahulu</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'riwayatpenyakitterdahulu',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Riwayat Penyakit Keluarga</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'riwayatpenyakitkeluarga',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Keluhan Saat Ini</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'keluhansaatini',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
    
   
</div>
<div class="clear"></div>

<hr/>