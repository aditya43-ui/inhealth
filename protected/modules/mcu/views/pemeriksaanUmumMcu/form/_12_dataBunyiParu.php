<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>BUNYI PARU</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Sonor</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('sonor');
                echo $form->radioButtonList($model, 'bunyiparu_sonor', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Vesikuler</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('vesikuler');
                echo $form->radioButtonList($model, 'bunyiparu_vesikuler', $deviasi);
            ?>
        </div>
    </div>        
    
    <div class="control-group">
        <label class="control-label">Ronchi</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('ronchi');
                echo $form->radioButtonList($model, 'bunyiparu_ronchi', $deviasi);
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Wheezing</label>
        <div class="controls">
            <?php
                $deviasi = LookupM::getItemsUrutan('ronchi');
                echo $form->radioButtonList($model, 'bunyiparu_wheezing', $deviasi);
            ?>
        </div>
    </div>
</div>



<div class="clear"></div>

<hr/>