<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>PEMERIKSAAN RAD</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Pemeriksaan</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('pemeriksaanradiologi');
                echo $form->radioButtonList($model, 'radiologi_ada', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Kesimpulan & Saran</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'radiologi_kesmpulan',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>              
    
    <div class="control-group">
        <label class="control-label">Dari hasil pemeriksaan fisik didapat</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'radiologi_hasil',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>   
</div>



<div class="clear"></div>

<hr/>