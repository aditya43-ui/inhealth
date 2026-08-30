
            <div class="control-group">
                <label class="control-label">Sistolik</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'tekanandarah_sistolik',array('placeholder'=>'ketikkan angka untuk nilai Sistolik','class' => 'numbers-only span4', 'onchange' => 'hitungMAP();')); ?>
                </div>
                <div class="controls">
                    <label> mmHg</label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Diastolik</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'tekanandarah_diastolik',array('placeholder'=>'ketikkan angka untuk nilai Diastolik','class' => 'numbers-only span4', 'onchange' => 'hitungMAP();')); ?>
                </div>
                <div class="controls">
                    <label> mmHg</label>
                </div>
            </div>
        