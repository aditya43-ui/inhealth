<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>TENGGOROKAN</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Faring</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('faring');
                echo $form->radioButtonList($model, 'tenggorokan_faring', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Tonsil</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('tonsil');
                echo $form->radioButtonList($model, 'tenggorokan_tonsil', $deviasi);
            ?>
        </div>
    </div>        
</div>



<div class="clear"></div>

<hr/>