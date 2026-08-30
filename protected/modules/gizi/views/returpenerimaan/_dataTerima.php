<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTerima, 'nopenerimaanbahan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modTerima, 'nopenerimaanbahan', array('class' => 'span4', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTerima, 'sumberdanabhn', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modTerima, 'sumberdanabhn', array('class' => 'span4', 'readonly' => true))
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modTerima, 'tglterimabahan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modTerima, 'tglterimabahan', array('class' => 'span4', 'readonly' => true)) ?>
        </div>
    </div>
</div>