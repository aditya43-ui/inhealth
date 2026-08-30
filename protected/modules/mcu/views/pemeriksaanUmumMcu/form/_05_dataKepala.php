<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>MATA</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Anemis</label>
        <div class="controls">
            <?php
                $anemis = LookupM::getItemsUrutan('anemis');
                echo $form->radioButtonList($model, 'mata_anemis', $anemis);
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Ikterik</label>
        <div class="controls">
            <?php
                $ikterik = LookupM::getItemsUrutan('ikterik');
                echo $form->radioButtonList($model, 'mata_ikterik', $ikterik);
            ?>
        </div>
    </div>
</div>



<div class="clear"></div>

<hr/>