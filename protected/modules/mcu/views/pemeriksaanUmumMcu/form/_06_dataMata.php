<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>KEPALA</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">    
    <div class="control-group">
        <label class="control-label">Bentuk Kepala</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'bentukkepala',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Benjolan</label>
        <div class="controls">
            <?php
                $benjolan = LookupM::getItemsUrutan('benjolan');
                echo $form->radioButtonList($model, 'benjolan', $benjolan);
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Warna Rambut</label>
        <div class="controls" style="width:80%">
            <?= $form->textArea($model,'warnarambut',['rows'=>5, 'style'=>'width:100%;']) ?>
        </div>
    </div>
</div>



<div class="clear"></div>

<hr/>