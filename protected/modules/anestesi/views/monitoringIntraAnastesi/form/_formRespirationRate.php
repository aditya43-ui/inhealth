
            <div class="control-group">
                <label class="control-label">Spont. Respiration</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'spont_respiration',array('placeholder' => 'ketikkan angka untuk nilai Spont. Respiration','class' => 'numbers-only span5', 'onchange' => 'hitungMAP();')); ?>
                </div>
                <div class="controls">
                    
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Assisted Respiration</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'assissted_respiration',array('placeholder' => 'ketikkan angka untuk nilai Assisted Respiratio','class' => 'numbers-only span5', 'onchange' => 'hitungMAP();')); ?>
                </div>
                <div class="controls">
                    
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Controlled Respiration</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'controlled_respiration',array('placeholder' => 'ketikkan angka untuk nilai Controlled Respiration','class' => 'numbers-only span5', 'onchange' => 'hitungMAP();')); ?>
                </div>
                <div class="controls">
                    
                </div>
            </div>
        