<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Menit ke - </label>
        <div class="controls">
            <?php 
                echo CHtml::activeHiddenField($model, 'monitoringpascaanastesi_id',array('reasonly' => true));
                echo CHtml::activeTextField($model, 'menit_ke', array('class'  => 'numbers-only required field-menitke'));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Temperatur</label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'temperature', array('class'  => 'numbers-only')); ?> <label><sup>o</sup>C</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Respiration Rate</label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'respiration_rate', array('class'  => 'numbers-only')); ?> <label>x/menit</label>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Nadi</label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'nadi', array('class'  => 'numbers-only')); ?> <label>x/menit</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tek. Darah</label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'tekanandarah_sistolik', array('class'  => 'numbers-only','style'=>'width:98px;')); ?>
        </div>
        <div class="controls">
            <label>/</label>
        </div>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'tekanandarah_diastolik', array('class'  => 'numbers-only','style'=>'width:98px;')); ?> <label>mmHg</label>
        </div>
    </div>
</div>