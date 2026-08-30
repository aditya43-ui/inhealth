<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>LEHER</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Bentuk</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('bentuk_leher');
                echo $form->radioButtonList($model, 'leher_bentuk', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Kel Limfe</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('kellimfe');
                echo $form->radioButtonList($model, 'leher_kellimfe', $deviasi);
            ?>
        </div>
    </div>        
</div>



<div class="clear"></div>

<hr/>