<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>ABDOMEN</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Supel</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('supel');
                echo $form->radioButtonList($model, 'abdomen_supel', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Hepar & Limpa</label>
        <div class="controls">
            <?php
                $murmur = LookupM::getItemsUrutan('hepar');
                echo $form->radioButtonList($model, 'abdomen_hepar', $murmur);
            ?>
        </div>
    </div>        
        
</div>



<div class="clear"></div>

<hr/>