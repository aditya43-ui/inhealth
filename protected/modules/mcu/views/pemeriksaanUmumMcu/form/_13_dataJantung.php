<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>JANTUNG</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Bunyi Jantung</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('bunyijantung');
                echo $form->radioButtonList($model, 'jantung_bunyi', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Mur mur</label>
        <div class="controls">
            <?php
                $murmur = LookupM::getItemsUrutan('murmur');
                echo $form->radioButtonList($model, 'jantung_murmur', $murmur);
            ?>
        </div>
    </div>        
    
    <div class="control-group">
        <label class="control-label">Gallop</label>
        <div class="controls">
            <?php
                $gallop = LookupM::getItemsUrutan('gallop');
                echo $form->radioButtonList($model, 'jantung_gallop', $gallop);
            ?>
        </div>
    </div>
      
</div>



<div class="clear"></div>

<hr/>