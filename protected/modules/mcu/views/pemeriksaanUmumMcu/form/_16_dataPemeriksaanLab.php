<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>PEMERIKSAAN LAB</u></strong></label>       
    </div>
</div>

<div class="col-sm-12">        
    <div class="control-group">
        <label class="control-label">Pengambilan Darah</label>
        <div class="controls">
            <?php
                $bentuk = LookupM::getItemsUrutan('pengambilandarah');
                echo $form->radioButtonList($model, 'lab_darah', $bentuk);
            ?>
        </div>
    </div>    
    
    <div class="control-group">
        <label class="control-label">Pengambilan Urine</label>
        <div class="controls">
            <?php
                $murmur = LookupM::getItemsUrutan('pengambilanurine');
                echo $form->radioButtonList($model, 'lab_urin', $murmur);
            ?>
        </div>
    </div>                 
</div>



<div class="clear"></div>

<hr/>