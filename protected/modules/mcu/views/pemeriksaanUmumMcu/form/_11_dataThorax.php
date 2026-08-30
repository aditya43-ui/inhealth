<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>THORAX</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Dalam Diam & Pergerakan</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('thorax_pergerakan');
                echo $form->radioButtonList($model, 'thorax_pergerakan', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Stem fremitus kanan dan kiri</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('thorax_stem');
                echo $form->radioButtonList($model, 'thorax_stem', $deviasi);
            ?>
        </div>
    </div>        
</div>



<div class="clear"></div>

<hr/>