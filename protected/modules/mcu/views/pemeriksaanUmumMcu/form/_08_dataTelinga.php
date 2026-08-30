<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>TELINGA</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">CAE</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('cae');
                echo $form->radioButtonList($model, 'telinga_cae', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">MT</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('mt');
                echo $form->radioButtonList($model, 'telinga_mt', $deviasi);
            ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Sekret</label>
        <div class="controls">
            <?php
                $sekret = LookupM::getItemsUrutan('sekret');
                echo $form->radioButtonList($model, 'telinga_sekret', $sekret);
            ?>
        </div>
    </div> 
</div>



<div class="clear"></div>

<hr/>