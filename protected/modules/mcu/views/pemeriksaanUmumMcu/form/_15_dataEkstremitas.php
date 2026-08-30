<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>EKSTREMITAS</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Akal</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('akral');
                echo $form->radioButtonList($model, 'ekstermitas_akral', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Deformitas</label>
        <div class="controls">
            <?php
                $murmur = LookupM::getItemsUrutan('deformitas');
                echo $form->radioButtonList($model, 'ekstermitas_adeformitas', $murmur);
            ?>
        </div>
    </div>        
        
    <div class="control-group">
        <label class="control-label">Oedema</label>
        <div class="controls">
            <?php
                $murmur = LookupM::getItemsUrutan('oedema');
                echo $form->radioButtonList($model, 'ekstermitas_aoedema', $murmur);
            ?>
        </div>
    </div> 
</div>



<div class="clear"></div>

<hr/>