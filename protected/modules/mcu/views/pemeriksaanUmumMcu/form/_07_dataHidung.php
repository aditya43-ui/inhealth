<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>HIDUNG</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Bentuk</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('bentuk');
                echo $form->radioButtonList($model, 'hidung_bentuk', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Deviasi</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('deviasi');
                echo $form->radioButtonList($model, 'hidung_deviasi', $deviasi);
            ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Sekret</label>
        <div class="controls">
            <?php
                $sekret = LookupM::getItemsUrutan('sekret');
                echo $form->radioButtonList($model, 'hidung_sekret', $sekret);
            ?>
        </div>
    </div> 
</div>



<div class="clear"></div>

<hr/>